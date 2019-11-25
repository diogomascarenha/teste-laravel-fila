<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ExcluirArquivosSeriesListener implements ShouldQueue
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
        $serie = $event->serie;
        $this->excluirCapa($serie);
    }

    public function excluirCapa($serie): void
    {
        $capa = $serie['capa'] ?? null;

        if (empty($capa)) {
            Log::info('A série ' . $serie['nome'] . ' não possui capa para ser excluída!');
            return;
        }

        try {
            unlink(public_path().DIRECTORY_SEPARATOR. $capa);
            Log::info('A capa da série ' . $serie['nome'] .' foi excluída com sucesso!');
        }
        catch (\Exception $e)
        {
            Log::info('Erro ao tentar excluir a capa da série ' . $serie['nome'] .'!');
            Log::info($e->getTraceAsString());
        }
    }
}
