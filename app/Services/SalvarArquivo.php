<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\Uuid;


class SalvarArquivo
{
    public function salvar(?UploadedFile $arquivo, ?string $diretorio = null): ?string
    {
        $caminhoCompleto = null;
        if ($arquivo) {
            $prefixo     = Uuid::uuid4()->toString();
            $extensao    = $arquivo->getClientOriginalExtension();
            $nomeArquivo = $prefixo . '.' . $extensao;
            $arquivo->move(public_path($diretorio), $nomeArquivo);
            $caminhoCompleto = $diretorio . '/' . $nomeArquivo;
        }
        return $caminhoCompleto;
    }
}
