<?php

namespace App\Listeners;

use App\Mail\NotificarNovaSerie;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificarNovaSerieListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $usuarioAutenticado = $event->usuario;
        $serie              = $event->serie;
        $qtdTemporadas      = $serie->temporadas->count();
        $qtdEpisodios       = $serie->temporadas->first()->episodios->count();
        $capa               = $serie->capa;
        $urlCapa            = $capa ? url($capa) : null;

        $usuariosNaoAutenticados = User::where('id', '!=', $usuarioAutenticado->id)->get();

        $segundosAdicionais = 0;
        foreach ($usuariosNaoAutenticados as $usuario) {
            Log::info('Adicionado a notificação de série ' . $serie->nome . ' para o email '. $usuario->email . ' na fila');
            $mail   = new NotificarNovaSerie(
                $serie->nome,
                $qtdTemporadas,
                $qtdEpisodios,
                $urlCapa
            );
            $quando = now()->addSeconds($segundosAdicionais * 15);
            Mail::to($usuario)->later($quando, $mail);
            $segundosAdicionais++;
        }
    }


}
