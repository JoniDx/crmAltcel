@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Instalación de {{$name.' '.$lastname}}</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><a href="{{ route('schedules.create')}}"><span>Crear</span></a></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>
<section class="panel">
    <div class="panel-body">
        <div class="invoice">
            <header class="clearfix">
                <div class="row">
                    <div class="col-sm-6 mt-md">
                        <h2 class="h2 mt-none mb-sm text-dark text-bold">Paquete: {{$pack->name}}</h2>
                        <h4 class="h4 m-none text-dark text-bold" >Agendado por: {{$who_did->name}}</h4>
                        @if($status == 'pendiente')
                        <h4 class="h4 m-none text-dark text-bold" style="margin-top:1rem !important; margin-bottom:1rem !important;">Status: <span class="label label-warning">{{$status}}</span></h4>
                        @elseif($status == 'completado')
                        <h4 class="h4 m-none text-dark text-bold" style="margin-top:1rem !important;">Status: <span class="label label-success">{{$status}}</span></h4>
                        <h4 class="h4 m-none text-dark text-bold" style="margin-top:1rem !important; margin-bottom:1rem !important;">Completado por: {{$user->name}}</h4>
                        @endif
                        
                        
                    </div>
                    <div class="col-sm-6 text-right mt-md mb-md">
                        
                        <div class="ib">
                            <img src="{{asset('images/conecta.png')}}" style="width:200px;" alt="OKLER Themes" />
                        </div>
                        
                    </div>
                </div>
            </header>
            <div class="bill-info">
                <div class="row">
                    <div class="col-md-6">
                        <div class="bill-to">
                            <p class="h5 mb-xs text-dark text-semibold">Datos del cliente:</p>
                            <address>
                                {{$name.' '.$lastname.'.'}}
                                <br/>
                                {{$email}}
                                <br/>
                                Teléfono: {{$cellphone}}
                            </address>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bill-to text-right">
                            <p class="h5 mb-xs text-dark text-semibold">Dirección:</p>
                            <address>
                                {{$address}}
                                <br/>
                                {{$reference_address}}
                                
                            </address>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="bill-to">
                            <p class="mb-none">
                                <span class="text-dark">Fecha y hora inicial:</span>
                                <span class="value">{{\Illuminate\Support\Str::limit($date_install_init, $limit=16, $end = '')}}</span>
                            </p>
                            <p class="mb-none">
                                <span class="text-dark">Fecha y hora final:</span>
                                <span class="value">{{\Illuminate\Support\Str::limit($date_install_final, $limit=16, $end = '')}}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($status == 'pendiente')
        <div class="text-right mr-lg">
            <a href="{{url('/schedules/'.$id)}}" class="btn btn-danger ml-sm" onclick="event.preventDefault();
                                                     document.getElementById('logout-complete').submit();">
                <i class="fa fa-times-circle"></i> Cancelar
            </a>
            <a href="{{url('/schedules/'.$id)}}" class="btn btn-primary ml-sm" onclick="event.preventDefault();
                                                     document.getElementById('logout-complete').submit();">
                <i class="fa fa-sign-in"></i> Completar
            </a>
            <form id="logout-complete" action="{{url('/schedules/'.$id)}}" method="POST" class="d-none">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
        @endif
    </div>
</section>
@endsection