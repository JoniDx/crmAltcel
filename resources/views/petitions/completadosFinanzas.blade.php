@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Administración de Solicitudes</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Dashboard</span></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>
<div class="alert alert-primary">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

    <strong>{{$fecha}}</strong>
</div>
<div class="panel-body mb-lg pr-xl pl-xl">
    <div class="row">
        <section class="panel panel-featured-left panel-featured-info col-md-6">
            <div class="panel-body">
                <div class="widget-summary widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-info">
                            <i class="fa fa-usd"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Monto total de cobros Dispositivos</h4>
                            <div class="info">
                                <strong class="amount">${{number_format($totalcpe,2)}}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="panel panel-featured-left panel-featured-warning col-md-6">
            <div class="panel-body">
                <div class="widget-summary widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-warning">
                            <i class="fa fa-usd"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Monto total de cobros planes</h4>
                            <div class="info">
                                <strong class="amount">${{number_format($totalplan,2)}}</strong>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<section class="panel">
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="{{route('recibidos')}}">

            <div class="form-group">
                <div class="col-md-6">
                    <div class="input-daterange input-group" data-plugin-datepicker="">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input autocomplete="off" type="text" class="form-control" name="start">
                        <span class="input-group-addon">a</span>
                        <input autocomplete="off" type="text" class="form-control" name="end">
                    </div>
                </div>
                <div class="col-md-12 mt-md">
                    <button class="btn btn-success btn-sm">Consultar</button>
                </div>
            </div>
        </form>
    </div>
</section>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>
        <h2 class="panel-title">Solicitudes Finalizadas</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead style="cursor: pointer;">
                <tr>
                <th>Cliente</th>
                <th>Producto</th>
                <th>Plan Activación</th>
                <th>Status</th>
                <th>Cobro cpe</th>
                <th>Cobro Plan</th>
                <th>Forma Pago</th>
                <th>Fecha Solicitud</th>
                <th>Activado Por</th>
                <th>Fecha Activación</th>
                <th>Recibido Por</th>
                <th>Fecha Recibido</th>
                <th>Comentario</th>
                </tr>
            </thead>
            <tbody>
                @foreach($completadas as $completado)
                <tr>
                    <td>{{$completado['client']}}</td>
                    <td>{{$completado['product']}}</td>
                    <td>{{$completado['rate_activation']}}</td>
                    <td><span class="badge label-{{$completado['badgeStatus']}}">{{$completado['status']}}</span></td>
                    <td>${{number_format($completado['cobroCpe'],2)}}</td>
                    <td>${{number_format($completado['cobroPlan'],2)}}</td>
                    <td>{{$completado['payment_way'].' - Plazo: '.$completado['plazo']}}</td>
                    <td>{{$completado['fecha_solicitud']}}</td>
                    <td>{{$completado['activadoPor']}}</td>
                    <td>{{$completado['date_activated']}}</td> 
                    <td>{{$completado['recibido']}}</td>
                    <td><span class="badge label-{{$completado['badgeFecha']}}">{{$completado['dateRecibido']}}</span></td>
                    <td>{{$completado['comment']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection