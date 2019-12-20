<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Na vbar -->
                    <ul class="navbar-nav  ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                            </li>
                            {{--@if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('pedidos') }}">{{ __('Pedidos') }}</a>
                                </li>
                            @endif--}}
                        @else
                            @if (Auth::user()->department=='ADMIN' || Auth::user()->department=='BODEGA')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('bodega') }}">{{ __('Bodega') }}</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pedidos') }}">{{ __('Pedidos') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('informes') }}">{{ __('Informes') }}</a>
                            </li>
                            @if (Auth::user()->department=='ADMIN' || Auth::user()->department=='BODEGA')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('mantenedores') }}">{{ __('Mantenedores') }}</a>
                            </li>
                            @endif
                            @if (Auth::user()->department=='ADMIN')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('configuraciones') }}">{{ __('Configuraciones') }}</a>
                            </li>
                            
                            @endif
                            <li id="notificacionesa" class="nav-item" data-toggle="modal" data-target="#notificacionesmodal" >
                                <a class="nav-link" href="#">
                                Notificaciones <span class="badge badge-primary badge-pill" if="notifcant">1</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Desconectarse') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @auth
            <nofiticacion-vue></nofiticacion-vue>
        @endauth
        <main class="py-4">
            @yield('content')
        </main>
        
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
