<x-guest-layout>
    <div class="container">
        <div class="left">
            <img src="{{ asset('storage/favicon/chefmate.png') }}" alt="logo" class="logo-icon" />
            <img src="{{ asset('storage/img/nombre_chefmate.png') }}" alt="logo" class="logo-icon" />
        </div>
        <div class="right">
            <h1>{{ __('login.titulo') }}</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <x-input-label for="email" :value="__('login.correo')" class="label-login"/>
                <x-text-input id="email" type="email" name="email" value="admin@chefmate.com" autofocus autocomplete="username" />

                <x-input-label for="password" :value="__('login.contraseña')" class="label-login"/>
                <x-text-input id="password" type="password" name="password" value="password" autocomplete="current-password"/>

                <x-input-error :messages="$errors->get('email')" class="error" />
                <x-input-error :messages="$errors->get('password')" class="error" />

                <x-primary-button>{{ __('login.acceder') }}</x-primary-button>
            </form>
        </div>
    </div>
    @include('layouts.footer')
</x-guest-layout>