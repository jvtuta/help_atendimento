<!doctype html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    
    <link rel="shortcut icon" href="https://ticket.memoriaram.com.br/pics/favicon.ico">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.theme.min lux.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
      <div class="container-liquid">
        <navbar-component brand="{{ config('app.name', 'Tele-Helpdesk') }}" brandroute="{{ route('home') }}" asset_logo="{{asset('img/logo.png')}}">
            <template>




                <!-- Left Side Of Navbar -->
                @guest

                @else
                    <navbar-list-component dir="esquerda">
                        <template>
                            
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('chat') }}" class="nav-link">Chat</a>
                            </li>
                            @if(Session::get('departamento')=='teleatendimento' && strtolower(Auth::user()->nivel_usuario) =='gerente' || Auth::user()->administrador == true)
                                <meta-dropdown-component route_import="{{route('meta','importar')}}" route_visualizar_imports="{{route('meta','visualizar')}}"></meta-dropdown-component>
                            @endif
                        </template>
                    </navbar-list-component>
                @endguest

                <!-- Right Side Of Navbar -->

                <!-- Authentication Links -->
                <navbar-list-component dir="direita">
                    <template>
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registrar</a>
                                </li>
                            @endif
                        @else
                        
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if (Auth::user()->administrador == 1 )
                                        <a class="dropdown-item" href="/phpmyadmin/">
                                            Phpmyadmin
                                        </a>
                                    @endif
                                    @if (strtolower(Auth::user()->nivel_usuario) == 'gerente' || Auth::user()->administrador == 1)
                                        <a href="{{ route('configuracoes') }}" class="dropdown-item">
                                            Configurações
                                        </a>

                                    @endif
                                    <a class="dropdown-item" href="{{ route('reset_password') }}">
                                        Alterar a senha
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                                             document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </template>
                </navbar-list-component>
            </template>
        </navbar-component>
    </div>  
        <main class="py-4">
            @yield('content')
        </main>
    </div>

</body>

</html>
