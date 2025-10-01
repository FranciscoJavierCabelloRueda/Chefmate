@extends('layouts.app')

@section('content')
<div class="custom-container">
    <h1 class="titulo-usuarios">{{ __('usuarios.titulo') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <table class="custom-table custom-table-striped">
        <thead>
            <tr>
                <th>{{ __('usuarios.nombre') }}</th>
                <th>{{ __('usuarios.email') }}</th>
                <th>{{ __('usuarios.admin') }}</th>
                <th>{{ __('usuarios.acciones') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->nombre }} {{ $usuario->apellidos }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td class="admin-usuario">
                        @if(auth()->user()->idUsu !== $usuario->idUsu && $usuario->idUsu !== 1)
                            <form action="{{ route('usuario.actualizar', $usuario) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="checkbox" name="admin" onchange="this.form.submit()" {{ $usuario->admin ? 'checked' : '' }}>
                            </form>
                        @else
                            <span class="text-muted">{{ __('usuarios.protegido') }}</span>
                        @endif
                    </td>
                    <td class="accion-usuario">
                        @if(auth()->user()->idUsu !== $usuario->idUsu && $usuario->idUsu !== 1)
                            <form action="{{ route('usuario.eliminar', $usuario) }}" method="POST" onsubmit="return confirm('{{ __('usuarios.confirmacion_eliminar') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-accion btn-eliminar">{{ __('usuarios.eliminar') }}</button>
                            </form>
                        @else
                            <span class="text-muted">{{ __('usuarios.no_permitido') }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection