@extends('layouts.app')

@section('content')
<div class="rc-container rc-margin-top">
    <h1 class="rc-title">{{ __('recetas.crear.titulo') }}</h1>

    @if ($errors->any())
        <div class="rc-alert">
            @foreach ($errors->all() as $error)
                <p class="rc-error-item">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('receta.guardar') }}" method="POST" enctype="multipart/form-data" class="rc-form">
        @csrf

        <label for="titulo" class="rc-label">{{ __('recetas.crear.titulo_label') }}</label>
        <input type="text" name="titulo" id="titulo" class="rc-input">

        <label for="descripcion" class="rc-label">{{ __('recetas.crear.descripcion_label') }}</label>
        <textarea name="descripcion" id="descripcion" class="rc-textarea"></textarea>

        <label for="ingredientes" class="rc-label">
            {{ __('recetas.crear.ingredientes_label') }}
            <small class="rc-hint">({{ __('recetas.crear.salto_linea') }})</small>
        </label>
        <textarea name="ingredientes" id="ingredientes" class="rc-textarea"></textarea>

        <label for="pasos" class="rc-label">
            {{ __('recetas.crear.pasos_label') }}
            <small class="rc-hint">({{ __('recetas.crear.salto_linea') }})</small>
        </label>
        <textarea name="pasos" id="pasos" class="rc-textarea"></textarea>

        <label for="foto" class="rc-label">{{ __('recetas.crear.foto_label') }}</label>
        <input type="file" name="foto" id="foto" class="rc-input">

        <button type="submit" class="rc-button">{{ __('recetas.crear.boton_crear') }}</button>
    </form>
</div>
@endsection