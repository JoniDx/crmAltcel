@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Mis instalaciones</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Dashboard</span></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>
<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Instalaciones del mes dfgds</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Paquete</th>
                    <th>Servicio</th>
                    <th>Radiobase</th>
                    <th>Cliente</th>
                    <th>Dirección</th>
                    <th>Atendió</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $instalations as $instalation )
                <tr>
                    <td>{{ $instalation->date_instalation }}</td>
                    <td>{{ $instalation->pack_name }}</td>
                    <td>{{ $instalation->pack_service }}</td>
                    <td>{{ $instalation->radiobase_name }}</td>
                    <td>{{ $instalation->client_name }}</td>
                    <td>{{ $instalation->address }}</td>
                    @php
                    $atendio = \App\User::where('id',$instalation->who_did_id)->first()
                    @endphp
                    <td>{{ $atendio->name }}</td>
                </tr>
            @endforeach

            @foreach( $TELMEXinstalations as $TELMEXinstalation )
                <tr>
                    <td>{{ $TELMEXinstalation->date_instalation }}</td>
                    <td>{{ $TELMEXinstalation->pack_name }}</td>
                    <td>{{ $TELMEXinstalation->pack_service }}</td>
                    <td>N/A</td>
                    <td>{{ $TELMEXinstalation->client_name }}</td>
                    <td>{{ $TELMEXinstalation->address }}</td>
                    @php
                    $atendio = \App\User::where('id',$TELMEXinstalation->who_did_id)->first()
                    @endphp
                    <td>{{ $atendio->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection