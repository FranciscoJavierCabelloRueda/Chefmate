@extends('layouts.app')

@section('content')
<div class="welcome-container">
    <img src="{{ asset('storage/img/nombre_chefmate.png') }}" alt="logo" class="logo-welcome" />
    <div class="welcome-message">
        {{ __('index.bienvenida', ['nombre' => Auth::user()->nombre, 'apellidos' => Auth::user()->apellidos]) }}
    </div>
</div>
@include('layouts.footer')
@endsection