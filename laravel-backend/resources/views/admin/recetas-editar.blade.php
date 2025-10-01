@extends('layouts.app')

@section('content')
<div class="rc-container rc-margin-top">
    <h1 class="rc-title">{{ __('recetas.editar.titulo') }}</h1>

    @if ($errors->any())
        <div class="rc-alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="rc-error-item">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('receta.actualizar', $receta) }}" method="POST" enctype="multipart/form-data" class="rc-form">
        @csrf
        @method('PUT')

        <label for="titulo" class="rc-label">{{ __('recetas.editar.titulo_campo') }}</label>
        <input type="text" name="titulo" id="titulo" class="rc-input" value="{{ $receta->titulo }}">

        <label for="descripcion" class="rc-label">{{ __('recetas.editar.descripcion') }}</label>
        <textarea name="descripcion" id="descripcion" class="rc-textarea">{{ $receta->descripcion }}</textarea>

        <label for="ingredientes" class="rc-label">
            {{ __('recetas.editar.ingredientes') }}
            <small class="rc-hint">({{ __('recetas.editar.hint_linea') }})</small>
        </label>
        <textarea name="ingredientes" id="ingredientes" class="rc-textarea">{{ $receta->ingredientes }}</textarea>

        <label for="pasos" class="rc-label">
            {{ __('recetas.editar.pasos') }}
            <small class="rc-hint">({{ __('recetas.editar.hint_linea') }})</small>
        </label>
        <textarea name="pasos" id="pasos" class="rc-textarea">{{ $receta->pasos }}</textarea>

        <label for="foto" class="rc-label">{{ __('recetas.editar.foto') }}</label>
        <input type="file" name="foto" id="foto" class="rc-input">

        <button type="submit" class="rc-button">{{ __('recetas.editar.boton_actualizar') }}</button>
    </form>
</div>
@endsection