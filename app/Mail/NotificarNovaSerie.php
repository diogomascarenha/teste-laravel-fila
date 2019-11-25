<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificarNovaSerie extends Mailable
{
    use Queueable, SerializesModels;
    public $nomeSerie;
    public $qtdTemporadas;
    public $qtdEpisodios;
    public $capa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        $nomeSerie,
        $qtdTemporadas,
        $qtdEpisodios,
        $capa
    )
    {
        $this->nomeSerie     = $nomeSerie;
        $this->qtdTemporadas = $qtdTemporadas;
        $this->qtdEpisodios  = $qtdEpisodios;
        $this->capa          = $capa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.series.notificar-nova-serie');
    }
}
