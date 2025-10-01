@extends('layouts.app')

@section('content')
<div class="custom-container">
    <div class="titulo-y-boton">
        <h1>{{ __('recetas.listar.titulo') }}</h1>
        <a href="{{ route('receta.crear') }}" class="btn btn-success">{{ __('recetas.listar.nueva_receta') }}</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="receta-grid">
        @forelse($receta as $receta)
            <div class="receta-card">
                <div class="receta-img">
                    @if($receta->foto)
                        <img src="{{ asset('storage/' . $receta->foto) }}" alt="Foto">
                    @else
                        <div class="sin-foto">{{ __('recetas.listar.sin_foto') }}</div>
                    @endif
                </div>
                <div class="receta-info">
                    <h3 class="receta-titulo">{{ $receta->titulo }}</h3>
                    <p>{{ $receta->descripcion }}</p>
                    <div class="receta-acciones">
                        <a href="{{ route('receta.editar', $receta) }}" class="btn-accion">{{ __('recetas.listar.editar') }}</a>
                        <form action="{{ route('receta.eliminar', $receta) }}" method="POST" onsubmit="return confirm('{{ __('recetas.listar.confirmar_eliminacion') }}')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-accion btn-eliminar">{{ __('recetas.listar.eliminar') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>{{ __('recetas.listar.no_hay_recetas') }}</p>
        @endforelse
    </div>
</div>
@endsection

