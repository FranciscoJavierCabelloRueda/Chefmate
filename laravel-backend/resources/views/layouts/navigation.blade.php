<nav class="nav-bar">
    <div class="nav-logo">
        <img src="{{ asset('storage/favicon/chefmate.png') }}" alt="Logo">
        <img src="{{ asset('storage/img/nombre_chefmate.png') }}" alt="Nombre">
    </div>
    <div class="nav-links">
        <x-nav-link :href="route('inicio.main')" :active="request()->routeIs('inicio.main')">
            {{ __('nav.inicio') }}
        </x-nav-link>
        <x-nav-link :href="route('receta.listar')" :active="request()->routeIs('receta.listar')">
            {{ __('nav.recetas') }}
        </x-nav-link>
        <x-nav-link :href="route('usuario.listar')" :active="request()->routeIs('usuario.listar')">
            {{ __('nav.usuarios') }}
        </x-nav-link>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('nav.cerrar_sesion') }}
            </x-nav-link>
        </form>
    </div>
</nav>
