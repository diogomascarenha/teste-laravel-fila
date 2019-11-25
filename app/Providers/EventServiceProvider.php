<?php

namespace App\Providers;

use App\Events\SerieCriadaEvent;
use App\Events\SerieExcluidaEvent;
use App\Listeners\CriarThumbnailCapaSerieListener;
use App\Listeners\ExcluirArquivosSeriesListener;
use App\Listeners\NotificarNovaSerieListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SerieCriadaEvent::class => [
            NotificarNovaSerieListener::class
        ],
        SerieExcluidaEvent::class => [
            ExcluirArquivosSeriesListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
