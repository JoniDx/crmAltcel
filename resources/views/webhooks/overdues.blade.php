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


<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Pagos Vencidos del Mes {{$formatDate}}</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead style="cursor: pointer;">
                <tr>
                <th scope="col">Servicio</th>
                <th scope="col">Cliente</th>
                <th scope="col">Monto Esperado</th>
                <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
           
            @foreach($paymentsOverdues as $paymentsOverdue)
                <tr>
                    <td>{{$paymentsOverdue->rate_name}}</td>
                    <td>{{$paymentsOverdue->client_name.' '.$paymentsOverdue->client_lastname}}</td>
                    <td>${{number_format($paymentsOverdue->amount,2)}}</td>
                    <td></td>
                </tr>
            @endforeach
         
            </tbody>
        </table>
       
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