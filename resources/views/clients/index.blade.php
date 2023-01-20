@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Reporte de Clientes</h2>
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
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <form class="form-horizontal form-bordered" action="{{route('reportscAtivations')}}">
                        <div class="col-md-4">
                            <label for="type">Concepto:</label>
                            <select class="form-control" data-plugin-multiselect name="type" id="type">
                                <option value="" selected>Seleccione un opción</option>
                                <option value="general">General</option>
                                <option value="MIFI">MIFI</option>
                                <option value="HBB">HBB</option>
                                <option value="MOV">MOV</option>
                                <option value="TELMEX">TELMEX</option>
                            </select>
                        </div>
                            
                        <div class="col-md-8  mb-sm">
                            <label class="">Fecha</label>
                            <div class="input-daterange input-group" data-plugin-datepicker>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input autocomplete="off" type="text" class="form-control" id="start_date" name="start">
                                <span class="input-group-addon">a</span>
                                <input autocomplete="off" type="text" class="form-control" id="end_date" name="end">
                            </div>
                        </div>

                        <div class="col-md-12 mt-md">
                            <button class="btn btn-primary btn-sm" ><i class="fa fa-cloud-download"></i> Consultar</button>
                        </div>
                    </form>
                </div>
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
            <h2 class="panel-title">Clientes</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>MSISDN</th>
                    <th>No. Serie</th>
                    <th>IMEI</th>
                    <th>MAC</th>
                    <th>ICC</th>
                    <th>Plan/Paquete</th>
                    <th>Servicio</th>
                    <th>Status</th>
                    <th>Plan</th>
                    <th>CPE</th>
                    <th>Expira</th>
                    <th>Fecha</th>
                    <th>Fecha de Expiración</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @php
                $amount_total = 0;
                $amount_pendiente = 0;
            @endphp
            @foreach( $clients as $client )
                <tr class="{{$client->service}} "  >
                    <td>{{ $name = strtoupper($client->name.' '.$client->lastname) }}</td>
                    <td>{{ $client->cellphone }}</td>
                    <td>{{ $client->MSISDN }}</td>
                    <td>{{ $client->serial_number }}</td>
                    <td>{{ substr($client->imei,4) }}</td>
                    <td>{{ $client->mac }}</td>
                    <td>{{$client->icc }}</td>
                    <td>{{ $rate = strtoupper($client->rate_name) }}</td>
                    <td>{{ $service = strtoupper($client->service) }}</td>
                    @php
                    $service = trim($service);
                    @endphp
                    @if($service == 'MOV')
                     <td>
                         @if($client->traffic_outbound == 'inactivo')
                            <span class="label label-danger mb-sm">Tráfico: {{ $client->traffic_outbound }}</span>
                        @else
                            <span class="label label-success mb-sm">Tráfico: {{ $client->traffic_outbound }}</span>
                        @endif

                        @if($client->status_altan == 'activo')
                            <span class="label label-success mb-sm">Status: {{ $client->status_altan }}</span>
                        @else
                            <span class="label label-danger mb-sm">Status: {{ $client->status_altan }}</span>
                        @endif
                     </td>
                     @else
                     <td>
                        @if($client->traffic_outbound_incoming == 'inactivo')
                            <span class="label label-danger mb-sm">Tráfico: {{ $client->traffic_outbound_incoming }}</span>
                        @else
                            <span class="label label-success mb-sm">Tráfico: {{ $client->traffic_outbound_incoming }}</span>
                        @endif

                        @if($client->status_altan == 'activo')
                            <span class="label label-success mb-sm">Status: {{ $client->status_altan }}</span>
                        @else
                            <span class="label label-danger mb-sm">Status: {{ $client->status_altan }}</span>
                        @endif
                    </td>

                    @endif
                    <td>${{ number_format($client->amount_rate,2) }}</td>
                    <td>${{ number_format($client->amount_device,2) }}</td>
                    <td>{{ $client->date_expire }}</td>
                    <td>{{ $client->date_activation }}</td>
                    <td>{{$client->date_expire}}</td>
                    <td><button class="btn btn-info altan" data-id-dn="{{$client->id_dn}}" data-id-act="{{$client->id_act}}" data-service="{{trim($client->service)}}">Información</button><button class="btn btn-danger porta" id="" data-port="{{$client->portado}}" data-dn="{{$client->MSISDN}}">Portado</button></td>
                </tr>
            @endforeach
            @foreach( $clientsTwo as $clientTwo )
                <tr class="{{$clientTwo->service}}">
                    <td>{{ $name = strtoupper($clientTwo->name.' '.$clientTwo->lastname) }}</td>
                    <td>{{ $clientTwo->cellphone }}</td>
                    <td>{{ $clientTwo->number }}</td>
                    <td>{{ $clientTwo->serial_number }}</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>{{ $rate = strtoupper($clientTwo->pack_name) }}</td>
                    <td>{{ $service = strtoupper($clientTwo->service) }}</td>
                    <td>N/A</td>
                    <td>${{ number_format($clientTwo->amount_pack,2) }}</td>
                    <td>${{ number_format($clientTwo->amount_install,2) }}</td>
                    <td>N/A</td>
                    <td>{{ $clientTwo->date_instalation }}</td>
                    <td>N/A</td>
                    <td>N/A</td>
                </tr>
            @endforeach
           
    </div>
</section>
<script>
    $('.altan').click(function(){
        let id_dn = $(this).data('id-dn');
        let id_act = $(this).data('id-act');
        let service = $(this).data('service');
        let url = "{{route('showProductDetails',['id_dn'=>'temp','id_act'=>'temp1','service'=>'temp2'])}}";
        url = url.replace('temp',id_dn);
        url = url.replace('temp1',id_act);
        url = url.replace('temp2',service);

        location.href = url;
    });

    $('.porta').click(function(){
        let portado = $(this).data('port');
        let dn = $(this).data('dn');
        $.ajax({
            url: "{{route('numPortado')}}",
            method:'GET',
            data: {portado,dn},
            success: function(response){
                console.log(response)
            }
        })
    })
</script>

@endsection