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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nomeSerie, $qtdTemporadas, $qtdEpisodios)
    {
        $this->nomeSerie = $nomeSerie;
        $this->qtdTemporadas = $qtdTemporadas;
        $this->qtdEpisodios = $qtdEpisodios;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.series.notificar-nova-serie');
    }
}
