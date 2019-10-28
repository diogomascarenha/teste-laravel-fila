@component('mail::message')
# Nova Série Adicionada
## Nome: {{ $nomeSerie }}
## Quantidade de Temporadas: {{ $qtdTemporadas }}
## Quantidade de Episódios: {{ $qtdEpisodios }}

@component('mail::button', ['url' => route('listar_series')])
    Ir para listagem de séries
@endcomponent


@endcomponent
