<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Altcel II</title>
    
    <link rel="shortcut icon" type="image/png" href="{{asset('images/Altcel2_Ok@2x.png')}}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('robust/app-assets/css/bootstrap.css')}}">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="{{asset('robust/app-assets/fonts/icomoon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('robust/app-assets/fonts/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('robust/app-assets/vendors/css/extensions/pace.css')}}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('robust/app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('robust/app-assets/css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('robust/app-assets/css/colors.css')}}">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('robust/app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('robust/app-assets/css/core/menu/menu-types/vertical-overlay-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('robust/app-assets/css/core/colors/palette-gradient.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('robust/assets/css/style.css')}}">
    <!-- END Custom CSS-->
    <style>
    .d-none{
        display: none;
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

<body data-open="click" data-menu="vertical-menu" data-col="2-columns"
    class="vertical-layout vertical-menu 2-columns  fixed-navbar">

    <!-- navbar-fixed-top-->
    <nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav">
                    <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs"><i
                                class="icon-menu5 font-large-1"></i></a></li>
                    <li class="nav-item"><a href="{{url('/home')}}" class="navbar-brand nav-link"><img alt="branding logo"
                                src="{{asset('robust/app-assets/images/logo/robust-logo-light.png')}}"
                                data-expand="{{asset('robust/app-assets/images/logo/robust-logo-light.png')}}"
                                data-collapse="{{asset('robust/app-assets/images/logo/robust-logo-small.png')}}"
                                class="brand-logo"></a></li>
                    <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse"
                            data-target="#navbar-mobile" class="nav-link open-navbar-container"><i
                                class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content container-fluid">
                <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                    <ul class="nav navbar-nav">
                        <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs">
                                <i class="icon-menu5"> </i></a>
                        </li>
                    </ul>
                    <!-- Pestaña desplegable opciones del usuario -->
                    <ul class="nav navbar-nav float-xs-right">
                        <li class="dropdown dropdown-user nav-item">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                                <span class="avatar avatar-online">
                                    <img src="{{asset('robust/app-assets/images/portrait/small/avatar-s-1.png')}}" alt="avatar">
                                    <i></i>
                                </span>
                                <span class="user-name">{{Auth::user()->name}}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('myProfile') }}" class="dropdown-item">
                                    <i class="icon-head"></i>Mi Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="icon-power3"></i>
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- main menu-->
    <div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
        
        <!-- main menu content-->
        <div class="main-menu-content">
            <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
                <!-- Redireccionamiento al Inicio -->
                <li class=" nav-item"><a href="{{ route('home') }}">
                    <i class="icon-home3"></i>
                    <span data-i18n="nav.support_raise_support.main"class="menu-title">Inicio</span></a>
                </li>

                @if(Auth::user()->role_id == 1)
                
                <li class=" nav-item"><a href="{{route('clients-pay-all.get')}}">
                <i class="fas fa-plus"></i>
                    <span class="menu-title">Clientes</span></a>
                </li>
                <li class=" nav-item"><a href="{{route('activations.index')}}">
                <i class="fas fa-plus"></i>
                    <span class="menu-title">Activaciones</span></a>
                </li>

                <li class=" nav-item"><a href="#"><i class="fas fa-comment-dollar"></i><span class="menu-title">
                     Pagos</span></a>
                    <ul class="menu-content">
                        <li class="">
                            <a href="{{route('webhook-openpay.get')}}" class="menu-item">
                            <i class="fas fa-file-invoice-dollar"></i> Administración</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="fab fa-readme"></i><span class="menu-title">
                     Administración</span></a>
                    <ul class="menu-content">

                        <li>
                            <a href="#" data-i18n="nav.menu_levels.second_level_child.main" class="menu-item"><i class="fas fa-clipboard-list"></i> Ofertas</a>
                            <ul class="menu-content">
                                <li><a href="{{route('offers.index')}}" data-i18n="nav.menu_levels.second_level_child.third_level" class="menu-item">
                                    <i class="fas fa-eye"></i> Ver</a></li>
                                <li><a href="{{route('offers.create')}}" data-i18n="nav.menu_levels.second_level_child.third_level" class="menu-item">
                                    <i class="fas fa-folder-plus"></i> Crear</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#" data-i18n="nav.menu_levels.second_level_child.main" class="menu-item"><i class="fas fa-clipboard-list"></i> Tarifas</a>
                            <ul class="menu-content">
                                <li><a href="{{route('rates.index')}}" data-i18n="nav.menu_levels.second_level_child.third_level" class="menu-item">
                                    <i class="fas fa-eye"></i> Ver</a></li>
                                <li><a href="{{route('rates.create')}}" data-i18n="nav.menu_levels.second_level_child.third_level" class="menu-item">
                                    <i class="fas fa-folder-plus"></i> Crear</a></li>
                                <li><a href="{{route('politicRate.create')}}" data-i18n="nav.menu_levels.second_level_child.third_level" class="menu-item">
                                    <i class="fas fa-balance-scale"></i> Políticas</a></li>
                            </ul>
                        </li>

                        <li class="">
                            <a href="{{route('show-users.get')}}" class="menu-item">
                            <i class="fas fa-address-book"></i> Usuarios</a>
                        </li>
                        <li class="">
                            <a href="{{route('ethernet-admin.get')}}" class="menu-item">
                            <i class="fas fa-ethernet"></i> Internet</a>
                        </li>

                        <li>
                            <a href="#" data-i18n="nav.menu_levels.second_level_child.main" class="menu-item"><i class="fas fa-clipboard-list"></i> Distribuidores</a>
                            <ul class="menu-content">
                                <li><a href="{{route('dealers.index')}}" data-i18n="nav.menu_levels.second_level_child.third_level" class="menu-item">
                                    <i class="fas fa-eye"></i> Ver</a></li>
                                <li><a href="{{route('dealers.create')}}" data-i18n="nav.menu_levels.second_level_child.third_level" class="menu-item">
                                    <i class="fas fa-folder-plus"></i> Crear</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @elseif(Auth::user()->role_id == 2)
                <li class=" nav-item"><a href="#"><span class="menu-title">
                    <i class="fas fa-comment-dollar"></i> Pagos</span></a>
                    <ul class="menu-content">
                        <li class="">
                            <a href="{{route('clients-pay-all.get')}}" class="menu-item">
                            <i class="fas fa-file-invoice-dollar"></i> Clientes</a>
                        </li>
                        <li class="">
                            <a href="{{route('webhook-openpay.get')}}" class="menu-item">
                            <i class="fas fa-file-invoice-dollar"></i> Administración</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><span class="menu-title">
                    <i class="fas fa-plus"></i> Activaciones</span></a>
                    <ul class="menu-content">
                        <li class="">
                            <a href="{{route('activations.create')}}" class="menu-item">
                            <i class="fas fa-folder-plus"></i> Alta</a>
                        </li>
                        <li class="">
                            <a href="{{route('activations.index')}}" class="menu-item">
                            <i class="fas fa-eye"></i> Ver</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><span class="menu-title">
                    <i class="far fa-calendar-alt"></i> Agenda</span></a>
                    <ul class="menu-content">
                        <li class="">
                            <a href="{{route('schedules.create')}}" class="menu-item">
                            <i class="far fa-calendar-plus"></i> Alta</a>
                        </li>
                        <li class="">
                            <a href="{{route('schedules.index')}}" class="menu-item">
                            <i class="fas fa-calendar-day"></i> Administración</a>
                        </li>
                    </ul>
                </li>
                @elseif(Auth::user()->role_id == 6)
                <li class=" nav-item"><a href="#"><span class="menu-title">
                    <i class="fas fa-user-friends"></i> Clientes</span></a>
                    <ul class="menu-content">
                        <li class="">
                            <a href="{{route('clients-pay-all.get')}}" class="menu-item">
                            <i class="fas fa-eye"></i> Ver</a>
                        </li>
                        <!-- <li class="">
                            <a href="{{route('webhook-openpay.get')}}" class="menu-item">
                            <i class="fas fa-file-invoice-dollar"></i> Pagos</a>
                        </li> -->
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><span class="menu-title">
                    <i class="fas fa-plus"></i> Activaciones</span></a>
                    <ul class="menu-content">
                        <li class="">
                            <a href="{{route('activations.create')}}" class="menu-item">
                            <i class="fas fa-folder-plus"></i> Alta</a>
                        </li>
                        <li class="">
                            <a href="{{route('activations.index')}}" class="menu-item">
                            <i class="fas fa-eye"></i> Ver</a>
                        </li>
                    </ul>
                </li>
                @endif
                
               
            </ul>
        </div>
        <!-- /main menu content-->
        <!-- main menu footer-->
        <!-- include includes/menu-footer-->
        <!-- main menu footer-->
    </div>
    <!-- / main menu-->

    <div class="app-content content container-fluid">
        @yield('content')
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <footer class="footer footer-static footer-light navbar-border mt-5">
        <p class="clearfix text-muted text-sm-center mb-0 px-2"><span
                class="float-md-left d-xs-block d-md-inline-block">Copyright &copy; 2017 <a
                    href="https://themeforest.net/user/pixinvent/portfolio?ref=pixinvent" target="_blank"
                    class="text-bold-800 grey darken-2">PIXINVENT </a>, All rights reserved. </span><span
                class="float-md-right d-xs-block d-md-inline-block">Hand-crafted & Made with <i
                    class="icon-heart5 pink"></i></span></p>
    </footer>

    <!-- BEGIN VENDOR JS-->
    <!-- <script src="../../app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script> -->
    <script src="{{asset('robust/app-assets/vendors/js/ui/tether.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('robust/app-assets/js/core/libraries/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('robust/app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('robust/app-assets/vendors/js/ui/unison.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('robust/app-assets/vendors/js/ui/blockUI.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('robust/app-assets/vendors/js/ui/jquery.matchHeight-min.js')}}" type="text/javascript"></script>
    <script src="{{asset('robust/app-assets/vendors/js/ui/screenfull.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('robust/app-assets/vendors/js/extensions/pace.min.js')}}" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{asset('robust/app-assets/vendors/js/charts/chart.min.js')}}" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script src="{{asset('robust/app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
    <script src="{{asset('robust/app-assets/js/core/app.js')}}" type="text/javascript"></script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- <script src="{{asset('robust/app-assets/js/scripts/pages/dashboard-lite.js')}}" type="text/javascript"></script> -->
    <!-- END PAGE LEVEL JS-->
</body>

</html>