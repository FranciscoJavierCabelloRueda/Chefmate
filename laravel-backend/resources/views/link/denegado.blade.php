<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('storage/img/chefmate.png') }}">
    <title>Chefmate | Internal</title>
    <link href="https://fonts.googleapis.com/css2?family=Gantari&family=Roboto:wght@400;700&family=Rosarivo:ital@0;1&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="welcome-container">
        <img src="{{ asset('storage/img/nombre_chefmate.png') }}" alt="logo" class="logo-welcome" />
        <div class="welcome-message">
            {!! __('denegado.mensaje') !!}
        </div>
        <a href="{{ url('/') }}" class="btn" style="margin-top: 1rem;">{{ __('denegado.volver') }}</a>
    </div>
    @include('layouts.footer')
</body>
</html>