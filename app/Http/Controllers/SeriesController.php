<?php

namespace App\Http\Controllers;

use App\Events\SerieCriadaEvent;
use App\Http\Requests\SeriesFormRequest;
use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $series   = Serie::query()
            ->orderBy('nome')
            ->get();
        $mensagem = $request->session()->get('mensagem');

        return view('series.index', compact('series', 'mensagem'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(
        SeriesFormRequest $request,
        CriadorDeSerie $criadorDeSerie
    )
    {
        $capa = null;
        if ($request->capa) {
            $prefixo        = Uuid::uuid4()->toString();
            $extensao       = request()->capa->getClientOriginalExtension();
            $nomeArquivo    = $prefixo . '.' . $extensao;
            $caminhoArquivo = 'imagens/series';
            $request->capa->move(public_path($caminhoArquivo), $nomeArquivo);
            $capa = $caminhoArquivo . '/' . $nomeArquivo;
        }

        $serie = $criadorDeSerie->criarSerie(
            $request->nome,
            $capa,
            $request->qtd_temporadas,
            $request->ep_por_temporada
        );

        event(new SerieCriadaEvent($serie));


        $usuarioAutenticado      = Auth::user();
        $usuariosNaoAutenticados = \App\User::where('id', '!=', $usuarioAutenticado->id)->get();

        $segundosAdicionais = 0;
        foreach ($usuariosNaoAutenticados as $usuario) {
            $mail   = new \App\Mail\NotificarNovaSerie(
                $request->nome,
                $request->qtd_temporadas,
                $request->ep_por_temporada
            );
            $quando = now()->addSeconds($segundosAdicionais * 15);
            \Illuminate\Support\Facades\Mail::to($usuario)->later($quando, $mail);
            $segundosAdicionais++;
        }

        $request->session()
            ->flash(
                'mensagem',
                "Série {$serie->id} e suas temporadas e episódios criados com sucesso {$serie->nome}"
            );

        return redirect()->route('listar_series');
    }

    public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
    {
        $nomeSerie = $removedorDeSerie->removerSerie($request->id);
        $request->session()
            ->flash(
                'mensagem',
                "Série $nomeSerie removida com sucesso"
            );
        return redirect()->route('listar_series');
    }

    public function editaNome(int $id, Request $request)
    {
        $serie       = Serie::find($id);
        $novoNome    = $request->nome;
        $serie->nome = $novoNome;
        $serie->save();
    }
}
