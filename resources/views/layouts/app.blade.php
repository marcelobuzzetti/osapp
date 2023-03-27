<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
        integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

    {{-- Datatables --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/af-2.5.1/b-2.3.2/b-colvis-2.3.2/b-html5-2.3.2/b-print-2.3.2/cr-1.6.1/fh-3.3.1/kt-2.8.0/r-2.4.0/rr-1.3.1/sc-2.0.7/sb-1.4.0/sl-1.5.0/sr-1.2.0/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/af-2.5.1/b-2.3.2/b-colvis-2.3.2/b-html5-2.3.2/b-print-2.3.2/cr-1.6.1/fh-3.3.1/kt-2.8.0/r-2.4.0/rr-1.3.1/sc-2.0.7/sb-1.4.0/sl-1.5.0/sr-1.2.0/datatables.min.js">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.13.1/sorting/date-euro.js"></script>

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    {{-- IcoFonts --}}
    <link rel="stylesheet" href="{{ asset('assets/icofont/icofont.min.css') }}" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/template.css') }}" />

    {{-- Pusher --}}
    {{--<script src="https://js.pusher.com/7.2/pusher.min.js"></script>--}}

    {{-- Socket.IO --}}
    <script type="text/javascript" src="{{config('broadcasting.connections.socket-io.url')}}/socket.io/socket.io.js"></script>

</head>

<body>
    <div id="app">
        @auth
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top card mx-2 mt-1">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ $empresa->nome }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link @if (Request::url() === config('app.url') . '/ordens/create') active @endif"
                                    href="/ordens/create">Nova OS?</a>
                            </li>
                            <li class="nav-item dropdown">
                                {{-- Other way to get current url --}}
                                <a class="nav-link {{ request()->is('/') ? 'active' : '' }} " href="{{ url('/') }}">
                                    Buscar OS?
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                {{-- Other way to get current url --}}
                                <a class="nav-link {{ request()->is('arquivadas') ? 'active' : '' }} " href="{{ url('/arquivadas') }}">
                                    OS Arquivadas
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('clientes/*') || request()->is('clientes') ? 'active' : '' }}"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Clientes
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item @if (Request::url() === config('app.url') . '/clientes') active @endif"
                                            href="/clientes">Lista</a></li>
                                    <li><a class="dropdown-item @if (Request::url() === config('app.url') . '/clientes/create') active @endif"
                                            href="/clientes/create">Criar</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle @if (Request::url() === config('app.url') . '/ordens') active @endif @if (Request::url() === config('app.url') . '/ordens/create') active @endif"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    OS
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item @if (Request::url() === config('app.url') . '/ordens') active @endif"
                                            href="/ordens">Lista</a></li>
                                    <li><a class="dropdown-item @if (Request::url() === config('app.url') . '/ordens/create') active @endif"
                                            href="/ordens/create">Criar</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle @if (Request::url() === config('app.url') . '/marcas') active @endif @if (Request::url() === config('app.url') . '/marcas/create') active @endif"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Marcas
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item @if (Request::url() === config('app.url') . '/marcas') active @endif"
                                            href="/marcas">Lista</a></li>
                                    <li><a class="dropdown-item @if (Request::url() === config('app.url') . '/marcas/create') active @endif"
                                            href="/marcas/create">Criar</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link {{ request()->is('balanco') || request()->is('relatorio') ? 'active' : '' }} " href="/balanco">
                                    Relatório
                                </a>
                            </li>
                            @if (Auth::user()->is_admin)

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle @if (Request::url() === config('app.url') . '/usuarios') active @endif @if (Request::url() === config('app.url') . '/usuarios/create') active @endif"
                                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Usuários
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item @if (Request::url() === config('app.url') . '/usuarios') active @endif"
                                                href="/usuarios">Lista</a></li>
                                        <li><a class="dropdown-item @if (Request::url() === config('app.url') . '/usuarios/create') active @endif"
                                                href="/usuarios/create">Criar</a></li>
                                    </ul>
                                </li>

                            @endif
                        </ul>
                    </div>


                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                {{-- @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif --}}
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <img class="avatar"
                                            src="<?= 'https://www.gravatar.com/avatar.php?gravatar_id=' . md5(strtolower(trim(Auth::user()->email))) ?>"
                                            alt="user">
                                        <span class="ml-3">{{ Auth::user()->name }}</span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('usuarios.edit', Auth::user()->id) }}"><i
                                                class="icofont-ui-edit"></i> Editar</a>
                                        <a class="dropdown-item" href="{{ route('empresas.show', $empresa->id) }}"><i class="icofont-gears"></i> Config</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="icofont-exit"></i> {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        @endauth
        <main class="py-4 container-fluid">
            @if ($message = Session::get('message'))
                @if ($message['type'] == 'success')
                    <script>
                        toastr.success("<?php echo $message['message']; ?>");
                    </script>
                @else
                    <script>
                        toastr.error("<?php echo $message['message']; ?>");
                    </script>
                @endif
            @endif
            @yield('content')
        </main>
    </div>
    {{-- Toastr --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script>
        $("#valor_servico").maskMoney({
            /* "prefix": "R$", */
            /* "decimal": ",", */
            "thousands": ""
        });

        $("#valor").maskMoney({
            /* "prefix": "R$", */
            /* "decimal": ",", */
            "thousands": ""
        });
        $(document).ready(function() {
        /*    Echo.channel('atualizacao-ordem')
                .listen('.alteracao-status', (data) => {
                    var url = `/ordens/${data.ordem.id}`
                    var text = `A Ordem nº ${data.ordem.id} foi atualizada <br></div><strong>Veja a OS clicando<a class='btn btn-dark' href=${url}>AQUI</a>!!!</strong>`
                    toastr.options = {
                        "closeButton": true,
                        "extendedTimeOut": "0",
                        "timeOut": "0",
                        "tapToDismiss": false,
                        "positionClass": "toast-bottom-right",
                        "newestOnTop": true,
                        "preventDuplicates": true,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut",
                    }
                    @unless(Session::get('message'))
                    toastr.success(text)
                    @endunless
                })*/
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }


            const socket = io("{{config('broadcasting.connections.socket-io.url')}}");
            socket.on('messages', function(data){
                console.log(data);
                toastr.options = {
                    "closeButton": true,
                    "extendedTimeOut": "0",
                    "timeOut": "0",
                    "tapToDismiss": false,
                    "positionClass": "toast-bottom-right",
                    "newestOnTop": true,
                    "preventDuplicates": true,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                }
                var url = `/ordens/${data}`
                var text = `A Ordem nº ${data} foi atualizada <br></div><strong>Veja a OS clicando<a class='btn btn-dark' href=${url}>AQUI</a>!!!</strong>`
                toastr.success(text)
            });
        });

        // Enable pusher logging - don't include this in production
        /*Pusher.logToConsole = false;

        var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('atualizacao-ordem');
        channel.bind('alteracao-status', function(data) {
            var url = `/ordens/${data.ordem.id}`
            var text = `A Ordem nº ${data.ordem.id} foi atualizada <br></div><strong>Veja a OS clicando<a class='btn btn-dark' href=${url}>AQUI</a>!!!</strong>`
            toastr.options = {
                "closeButton": true,
                "extendedTimeOut": "0",
                "timeOut": "0",
                "tapToDismiss": false,
                "positionClass": "toast-bottom-right",
                "newestOnTop": true,
                "preventDuplicates": true,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
            }
            @unless(Session::get('message'))
                toastr.success(text)
            @endunless
        })*/
    </script>
    <script>
        window.onload=function() {

        }
    </script>
</body>

</html>
