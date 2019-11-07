<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adicionada uma nova série</title>
</head>
<body>
    <h1>Adicionada uma nova série</h1>
    <h2>Série: {{ $nomeSerie }}</h2>
    <h2>Temporada: {{ $qtdTemporadas }}</h2>
    <h2>Episódios: {{ $qtdEpisodios }}</h2>
    <a href="{{ route('listar_series')  }}">Ir para listagem de séries</a>
</body>
</html>
