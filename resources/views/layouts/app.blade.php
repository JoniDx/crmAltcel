<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/swal.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
    <style>
        h3 {
            margin-bottom: 10px;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .opps {
            width: 496px; 
            border-radius: 4px;
            box-sizing: border-box;
            padding: 0 45px;
            margin: 40px auto;
            overflow: hidden;
            border: 1px solid #b0afb5;
            font-family: 'Open Sans', sans-serif;
            color: #4f5365;
        }

        .opps-reminder {
            position: relative;
            top: -1px;
            padding: 9px 0 10px;
            font-size: 11px;
            text-transform: uppercase;
            text-align: center;
            color: #ffffff;
            background: #000000;
        }

        .opps-info {
            margin-top: 26px;
            position: relative;
        }

        .opps-info:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;

        }

        .opps-brand {
            width: 45%;
            float: left;
        }

        .opps-brand img {
            max-width: 150px;
            margin-top: 2px;
        }

        .opps-ammount {
            width: 55%;
            float: right;
        }

        .opps-ammount h2 {
            font-size: 36px;
            color: #000000;
            line-height: 24px;
            margin-bottom: 15px;
        }

        .opps-ammount h2 sup {
            font-size: 16px;
            position: relative;
            top: -2px
        }

        .opps-ammount p {
            font-size: 10px;
            line-height: 14px;
        }

        .opps-reference {
            margin-top: 14px;
        }

        h1 {
            font-size: 27px;
            color: #000000;
            text-align: center;
            margin-top: -1px;
            padding: 6px 0 7px;
            border: 1px solid #b0afb5;
            border-radius: 4px;
            background: #f8f9fa;
        }

        .opps-instructions {
            margin: 32px -45px 0;
            padding: 32px 45px 45px;
            border-top: 1px solid #b0afb5;
            background: #f8f9fa;
        }

        ol {
            margin: 17px 0 0 16px;
        }

        a {
            color: #1155cc;
        }

        .opps-footnote {
            margin-top: 22px;
            padding: 22px 20 24px;
            color: #108f30;
            text-align: center;
            border: 1px solid #108f30;
            border-radius: 4px;
            background: #ffffff;
        }
        @media screen and (min-width: 768px) {
            #dataT_filter {
                display: flex;
                justify-content: flex-end;
            }
            #dataR_filter {
                display: flex;
                justify-content: flex-end;
            }
            #dataP_filter {
                display: flex;
                justify-content: flex-end;
            }
            #dataC_filter {
                display: flex;
                justify-content: flex-end;
            }
            #dataServices_filter {
                display: flex;
                justify-content: flex-end;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
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

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        @php
                            $cargo =  \App\Role::where('id',Auth::user()->role_id)->first();
                            $cargo = $cargo->rol
                        @endphp
                       
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                            </li>
                        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11)
                        
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('activations.index')}}">Activaciones</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Pagos
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAdmin">
                                    <a class="dropdown-item" href="{{route('webhook-openpay.get')}}">
                                        Administración
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Administración
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAdmin">
                                    <a class="dropdown-item" href="{{route('offers.index')}}">
                                        Ofertas
                                    </a>
                                    <a class="dropdown-item" href="{{route('rates.index')}}">
                                        Tarifas
                                    </a>
                                    <a class="dropdown-item" href="{{route('show-users.get')}}">
                                        Usuarios
                                    </a>
                                    <a class="dropdown-item" href="{{route('ethernet-admin.get')}}">
                                        Internet
                                    </a>
                                    <a class="dropdown-item" href="{{route('dealers.index')}}">
                                        Distribuidores
                                    </a>
                                </div>
                            </li>
                        @elseif(Auth::user()->role_id == 2)
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Pagos
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAdmin">
                                    <a class="dropdown-item" href="{{route('clients-pay-all.get')}}">
                                        Clientes
                                    </a>
                                    <a class="dropdown-item" href="{{route('webhook-openpay.get')}}">
                                        Administración
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Activaciones
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAdmin">
                                    <a class="dropdown-item" href="{{route('activations.create')}}">
                                        Alta
                                    </a>
                                    <a class="dropdown-item" href="{{route('activations.index')}}">
                                        Ver
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Agenda
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAdmin">
                                    <a class="dropdown-item" href="{{route('schedules.create')}}">
                                        Alta
                                    </a>
                                    <a class="dropdown-item" href="{{route('schedules.index')}}">
                                        Administración
                                    </a>
                                </div>
                            </li>
                        @elseif(Auth::user()->role_id == 6)
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Clientes
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAdmin">
                                    <a class="dropdown-item" href="{{route('clients-pay-all.get')}}">
                                        Ver
                                    </a>
                                    <a class="dropdown-item" href="{{route('webhook-openpay.get')}}">
                                        Pagos
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Activaciones
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAdmin">
                                    <a class="dropdown-item" href="{{route('activations.create')}}">
                                        Alta
                                    </a>
                                    <a class="dropdown-item" href="{{route('activations.index')}}">
                                        Ver
                                    </a>
                                </div>
                            </li>
                        @elseif(Auth::user()->role_id == 3)
                            
                        @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                           
                                    {{'('.$cargo.')'}}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('myProfile') }}">
                                        Mi Perfil
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }} 
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
