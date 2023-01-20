@extends('layouts.octopus')
@section('content')
@php
use \Carbon\Carbon;
@endphp
<header class="page-header">
    <h2>Administración de Pagos</h2>
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
    <strong>Mostrando registros en el rango de {{$date_init}} a {{$date_final}}</strong>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
           
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="{{route('webhook-openpay.get')}}">

                    <div class="form-group">
                        <!-- <label class="col-md-3 control-label">Date range</label> -->
                        <div class="col-md-6">
                            <div class="input-daterange input-group" data-plugin-datepicker>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input autocomplete="off" type="text" class="form-control" name="start">
                                <span class="input-group-addon">a</span>
                                <input autocomplete="off" type="text" class="form-control" name="end">
                            </div>
                        </div>
                        <button class="col-md-1 btn btn-success btn-sm">Consultar</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Pagos Completados</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead style="cursor: pointer;">
                <tr>
                <th scope="col">Canal de Pago</th>
                <th scope="col">Folio/Referencia</th>
                <th scope="col">Fecha de Pago</th>
                <th scope="col">Fecha de Operación</th>
                <th scope="col">Servicio</th>
                <th scope="col">Monto Esperado</th>
                <th scope="col">Monto Recibido</th>
                <th scope="col">Comisión</th>
                </tr>
            </thead>
            <tbody>
            @php
                $ingreso = 0;
                $comision = 0;
                $ingreso_total = 0;
            @endphp
            <!-- Pagos Manuales -->
            @foreach($paysCompleted as $payCompleted)
                <tr>
                    <td>{{$payCompleted->type_pay}}</td>
                    <td>{{$payCompleted->folio_pay}}</td>
                    <td>{{$payCompleted->date_pay}}</td>
                    <td>{{$payCompleted->updated_at}}</td>
                    <td>{{$payCompleted->number_product}}</td>
                    <td>${{number_format($payCompleted->amount,2)}}</td>
                    <td>${{number_format($payCompleted->amount_received,2)}}</td>
                    <td>{{'$0.00'}}</td>
                </tr>
            @php
                $ingreso += $payCompleted->amount_received;
            @endphp
            @endforeach
            
            @foreach($paysConectaCompleted as $payConectaCompleted)
            @php
                $monto_recibido = $payConectaCompleted->type_pay == 'efectivo/referencia' ? $payConectaCompleted->amount_received - $payConectaCompleted->reference_amount : $payConectaCompleted->amount_received;
            @endphp
                <tr>
                    <td>{{$payConectaCompleted->type_pay}}</td>
                    <td>{{$payConectaCompleted->folio_pay}}</td>
                    <td>{{$payConectaCompleted->date_pay}}</td>
                    <td>{{$payConectaCompleted->updated_at}}</td>
                    <td>{{$payConectaCompleted->service_name}}</td>
                    <td>${{number_format($payConectaCompleted->amount,2)}}</td>
                    <td>${{number_format($monto_recibido,2)}}</td>
                    <td>{{'$0.00'}}</td>
                </tr>
            @php
                $ingreso += $monto_recibido;
            @endphp
            @endforeach
            <!-- END Pagos Manuales -->
            
            <!-- Pagos Referenciados -->
            @foreach($paysReferencedCompleted as $payReferencedCompleted)
                <tr>
                    <td>{{$payReferencedCompleted->channel_name}}</td>
                    <td>{{$payReferencedCompleted->reference_folio}}</td>
                    <td>{{$payReferencedCompleted->date_pay}}</td>
                    <td>{{$payReferencedCompleted->reference_date_complete}}</td>
                    <td>{{$payReferencedCompleted->number_product}}</td>
                    <td>${{number_format($payReferencedCompleted->reference_amount,2)}}</td>
                    <td>${{number_format($payReferencedCompleted->amount_received,2)}}</td>
                    <td>${{number_format($payReferencedCompleted->reference_fee_amount,2)}}</td>
                </tr>
            @php
                $ingreso += $payReferencedCompleted->amount_received;
                $comision += $payReferencedCompleted->reference_fee_amount;
            @endphp
            @endforeach
            
            @foreach($paysReferencedConectaCompleted as $payReferencedConectaCompleted)
                @php
                    $monto_recibido = $payReferencedConectaCompleted->type_pay == 'efectivo/referencia' ? $payReferencedConectaCompleted->amount_waited : $payReferencedConectaCompleted->amount_received - $payReferencedConectaCompleted->amount_waited;
                @endphp
                <tr>
                    <td>{{$payReferencedConectaCompleted->channel_name}}</td>
                    <td>{{$payReferencedConectaCompleted->reference_folio}}</td>
                    <td>{{$payReferencedConectaCompleted->date_pay}}</td>
                    <td>{{$payReferencedConectaCompleted->reference_date_complete}}</td>
                    <td>{{$payReferencedConectaCompleted->service_name}}</td>
                    <td>${{number_format($payReferencedConectaCompleted->amount_waited,2)}}</td>
                    <td>${{number_format($payReferencedConectaCompleted->amount_waited,2)}}</td>
                    <td>${{number_format($payReferencedConectaCompleted->reference_fee_amount,2)}}</td>
                </tr>
            @php
                $ingreso += $monto_recibido;
                $comision += $payReferencedConectaCompleted->reference_fee_amount;
            @endphp
            @endforeach
            <!-- END Pagos Referenciados -->
            @php
                $ingreso_total = $ingreso - $comision;
            @endphp
            </tbody>
        </table>
       <h5 class="text-dark text-bold">Ingreso: <span class="text-warning">${{number_format($ingreso,2)}}</span></h5>
       <h5 class="text-dark text-bold">Comisiónes: <span class="text-warning">${{number_format($comision,2)}}</span></h5>
       <h5 class="text-dark text-bold">Ingreso Total: <span class="text-success">${{number_format($ingreso_total,2)}}</span></h5>
    </div>
</section>



<script>
    $('#date-pay').click(function(){
        $.ajax({
                url: "{{ route('date-pay')}}",
                success: function(data){
                    console.log(data);
                    
                }
            });
    });
</script>
@endsection
