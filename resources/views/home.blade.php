@extends('layouts.octopus')
@extends('layouts.datatablescss')
@section('content')
<header class="page-header">
    <h2>Dashboard</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Dashboard</span></li>
        </ol>
        <a class="sidebar-right-toggle" ><i class="fa fa-chevron-left"></i></a>
    </div>
</header>

<!-- Dashboard -->
@if(Auth::user()->role_id == 1 || Auth::user()->role_id == 4 || Auth::user()->role_id == 5 || Auth::user()->role_id == 11)
<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="row">
            <div class="col-md-4 ">
                <section class="panel panel-featured-left panel-featured-warning">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-warning">
                                    <i class="fa fa-refresh"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Pagos Pendientes</h4>
                                    <div class="info">
                                        <strong class="amount">{{$pendings}}</strong><br>
                                        <span class="text-primary">{{$formatDate}}</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <!-- <a href="" class="text-muted text-uppercase mr-xs">Reporte <i class="fa fa-cloud-download"></i></a> -->
                                    @if(Auth::user()->id != 1)
                                    <a href="{{route('webhook-payments-pending.get')}}" class="text-muted text-uppercase">Ver <i class="fa fa-arrow-circle-right"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel panel-featured-left panel-featured-secondary">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-secondary">
                                    <i class="fa fa-times-circle"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Por Llamar</h4>
                                    <div class="info">
                                        <strong class="amount">{{$toCall}}</strong><br>
                                        <span class="text-primary">Atender cuanto antes :)</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <!-- <a href="" class="text-muted text-uppercase mr-xs">Reporte <i class="fa fa-cloud-download"></i></a> -->
                                    <a href="{{route('directory.index')}}" class="text-muted text-uppercase">Ver <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel panel-featured-left panel-featured-success">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-success">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Pagos Completados</h4>
                                    <div class="info">
                                        <strong class="amount">{{$completes}}</strong><br>
                                        <span class="text-primary">{{$formatDate}}</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                <!-- <a href="" class="text-muted text-uppercase mr-xs">Reporte <i class="fa fa-cloud-download"></i></a> -->
                                @if(Auth::user()->id != 1)
                                <a href="{{route('incomes.get')}}" class="text-muted text-uppercase">Ver <i class="fa fa-arrow-circle-right"></i></a>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel panel-featured-left panel-featured-quartenary">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-quartenary">
                                    <i class="fa fa-user"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Prospectos</h4>
                                    <div class="info">
                                        <strong class="amount">{{$newClients}}</strong><br>
                                        <span class="text-primary">Sin servicio adquirido</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                @if(Auth::user()->id != 1)
                                    <a href="{{route('newClients.excel')}}" class="text-muted text-uppercase mr-xs">Reporte <i class="fa fa-cloud-download"></i></a>
                                    <a href="{{route('prospects.index')}}" class="text-muted text-uppercase">Ver <i class="fa fa-arrow-circle-right"></i></a>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel panel-featured-left panel-featured-info">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-info">
                                    <i class="fa fa-money"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Planes Activos</h4>
                                    <div class="info">
                                        <strong class="amount">{{$ratesActives}}</strong><br>
                                        <span class="text-primary">Gestionado por Comercial</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                @if(Auth::user()->id != 1)
                                    <a href="{{route('rates.excel')}}" class="text-muted text-uppercase mr-xs">Reporte <i class="fa fa-cloud-download"></i></a>
                                    <a href="{{route('rates.index')}}" class="text-muted text-uppercase">Ver <i class="fa fa-arrow-circle-right"></i></a>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel panel-featured-left panel-featured-success">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-success">
                                    <i class="fa fa-usd"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Ingresos</h4>
                                    <div class="info">
                                        <strong class="amount">Reportes</strong><br>
                                        <span class="text-primary">Detallados</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                @if(Auth::user()->id != 1)
                                    <a href="{{route('income')}}" class="text-muted text-uppercase">Ver <i class="fa fa-arrow-circle-right"></i></a>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div>
        <h1 class="text-center">Líneas</h1>
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="row">
                <div class="col-md-4 ">
                    <section class="panel panel-featured-left" style="background-color: #A11C1F;">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon" style="background-color: #A11C1F;">
                                        <i class="fa-solid fa-spinner"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Líneas Totales</h4>
                                        <div class="info">
                                            <strong class="amount">
                                                {{
                                                    $HBB[0]->HBB+$MOV[0]->MOV+$MIFI[0]->MIFI
                                                }}
                                            </strong><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-4">
                    <section class="panel panel-featured-left" style="background-color: #B0AFB5;">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon " style="background-color: #B0AFB5;">
                                        <i class="fa-solid fa-signal"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Líneas HBB</h4>
                                        <div class="info">
                                            <strong class="amount">{{$HBB[0]->HBB}}</strong><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-4">
                    <section class="panel panel-featured-left" style="background-color: #008A8D;">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon " style="background-color: #008A8D;">
                                        {{--  <i class="fa-solid fa-hashtag"></i>  --}}
                                        <i class="fa-solid fa-signal"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Líneas MOV</h4>
                                        <div class="info">
                                            <strong class="amount">{{$MOV[0]->MOV}}</strong><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-4">
                    <section class="panel panel-featured-left " style="background-color: #D3BF00;">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon" style="background-color: #D3BF00;">
                                        <i class="fa-solid fa-signal"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Líneas MIFI</h4>
                                        <div class="info">
                                            <strong class="amount">{{$MIFI[0]->MIFI}}</strong><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(Auth::user()->role_id == 2)
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <section class="panel panel-featured-left panel-featured-warning">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-warning">
                                    <i class="fa fa-refresh"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Pagos Pendientes</h4>
                                    <div class="info">
                                        <strong class="amount">{{$pendings}}</strong><br>
                                        <span class="text-primary">{{$formatDate}}</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <!-- <a href="" class="text-muted text-uppercase mr-xs">Reporte <i class="fa fa-cloud-download"></i></a> -->
                                    <a href="{{route('webhook-payments-pending.get')}}" class="text-muted text-uppercase">Ver <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel panel-featured-left panel-featured-secondary">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-secondary">
                                    <i class="fa fa-times-circle"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Por Llamar</h4>
                                    <div class="info">
                                        <strong class="amount">{{$toCall}}</strong><br>
                                        <span class="text-primary">Atender cuanto antes :)</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <!-- <a href="" class="text-muted text-uppercase mr-xs">Reporte <i class="fa fa-cloud-download"></i></a> -->
                                    <a href="{{route('directory.index')}}" class="text-muted text-uppercase">Ver <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel panel-featured-left panel-featured-success">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-success">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Pagos Completados</h4>
                                    <div class="info">
                                        <strong class="amount">{{$completes}}</strong><br>
                                        <span class="text-primary">{{$formatDate}}</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                <!-- <a href="" class="text-muted text-uppercase mr-xs">Reporte <i class="fa fa-cloud-download"></i></a> -->
                                <a href="{{route('incomes.get')}}" class="text-muted text-uppercase">Ver <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel panel-featured-left panel-featured-info">
                    <div class="panel-body">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-info">
                                    <i class="fa fa-money"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Planes Activos</h4>
                                    <div class="info">
                                        <strong class="amount">{{$ratesActives}}</strong><br>
                                        <span class="text-primary">Gestionado por Comercial</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <a href="{{route('rates.excel')}}" class="text-muted text-uppercase mr-xs">Reporte <i class="fa fa-cloud-download"></i></a>
                                    <a href="{{route('rates.index')}}" class="text-muted text-uppercase">Ver <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endif
<!-- Final Dashboard -->

@if(Auth::user()->role_id == 3)
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>
            </div>

            <h2 class="panel-title">Próximos pagos</h2>
        </header>
        <div class="panel-body">
        
            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                <thead style="cursor: pointer;">
                    <tr>
                    <th scope="col">Servicio</th>
                    <th scope="col">Número</th>
                    <th scope="col">Plan</th>
                    <th scope="col">Status</th>
                    <th scope="col">Fecha de Pago</th>
                    <th scope="col">Fecha Límite</th>
                    <th scope="col">Días restantes</th>
                    <th scope="col">Monto</th>
                    <th scope="col">Referencia</th>
                    <th scope="col">Pagar</th>
                    </tr>
                </thead>
                <tbody>
                @foreach( $mypays as $mypay )
                <tr style="cursor: pointer;">
                    <td>{{ $mypay->number_product }}</td>
                    <td>{{ $mypay->DN }}</td>
                    <td>{{ $mypay->rate_name }}</td>
                    <td>{{ $mypay->status }}</td>
                    <td>{{ $mypay->date_pay }}</td>
                    <td>{{ $mypay->date_pay_limit }}</td>
                    @php
                    $fecha1= new DateTime('NOW');
                    $fecha2= new DateTime($mypay->date_pay);
                    $diff = $fecha1->diff($fecha2);
                    @endphp
                    <td>{{$diff->days.' DÍAS'}}</td>
                    <td>{{ '$'.number_format($mypay->rate_price,2) }}</td>
                    @php
                        $ref = $mypay->reference_id == null ? 'N/A' : $mypay->reference_id
                    @endphp

                    @if($ref == 'N/A')
                    <td>No generada</td>
                    @else
                    <td><button type="button" onclick="ref(this.id)" class="btn btn-warning btn-sm ref-generated" id="{{ $ref }}"><i class="fa fa-eye"></i></button>
                    </td>
                    @endif
                    <td>
                        <a href="{{url('/generateReference/'.$mypay->id.'/'.$mypay->number_product.'/'.Auth::user()->id)}}" class="btn btn-success btn-sm"><i class="fa fa-money"></i></a>
                    </td>
                </tr>
                @endforeach
                @foreach( $my2pays as $my2pay )
                <tr>
                    <td>{{ $my2pay->service_name }}</td>
                    <td>N/A</td>
                    <td>{{ $my2pay->pack_name }}</td>
                    <td>{{ $my2pay->status }}</td>
                    <td>{{ $my2pay->date_pay }}</td>
                    <td>{{ $my2pay->date_pay_limit }}</td>
                    @php
                    $fecha1= new DateTime('NOW');
                    $fecha2= new DateTime($my2pay->date_pay);
                    $diff = $fecha1->diff($fecha2);
                    @endphp
                    <td>{{$diff->days.' DÍAS'}}</td>
                    <td>{{ '$'.number_format($my2pay->pack_price,2) }}</td>
                    @php
                        $ref = $my2pay->reference_id == null ? 'N/A' : $my2pay->reference_id
                    @endphp

                    @if($ref == 'N/A')
                    <td>No generada</td>
                    @else
                    <td><button onclick="ref(this.id)" class="btn btn-warning btn-sm ref-generated" id="{{ $ref }}"><i class="fa fa-eye"></i></button>
                    </td>
                    @endif
                    <td>
                        <a href="{{url('/generateReference/'.$my2pay->id.'/'.$my2pay->service_name.'/'.Auth::user()->id)}}" class="btn btn-success btn-sm"><i class="fa fa-money"></i></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>
            </div>

            <h2 class="panel-title">Servicios Contratados</h2>
        </header>
        <div class="panel-body">
        
        <table class="table table-bordered table-striped mb-none" id="datatable-default2">
            <thead style="cursor: pointer;">
                <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Servicio</th>
                <th scope="col">Número</th>
                <th scope="col">Paquete</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $activations as $activation )
            <tr style="cursor: pointer;">
                <td>{{ $activation->date_activation }}</td>
                <td>{{ $activation->service }}</td>
                <td>{{ $activation->DN }}</td>
                <td>{{ $activation->pack_name }}</td>
            </tr>
            @endforeach
            @foreach( $instalations as $instalation )
            <tr style="cursor: pointer;">
                <td>{{ $instalation->date_instalation }}</td>
                <td>{{ $instalation->service }}</td>
                <td>N/A</td>
                <td>{{ $instalation->pack_name }}</td>
            </tr>
            @endforeach

            
            </tbody>
        </table>
        </div>
    </section>

<div class="modal fade" id="reference" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleRef"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe class="col-md-12" id="reference-pdf" style="height: 400px;" src=""></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endif



<script>

    
    
    function ref(reference_id){
        let link = 'https://sandbox-dashboard.openpay.mx/paynet-pdf/mvtmmoafnxul8oizkhju/';

            $.ajax({
                    url:"{{url('/show-reference')}}",
                    method: "GET",
                    data: {
                        reference_id: reference_id
                    },
                    success: function(data){
                        console.log(data.reference);
                        $('#modalTitleRef').html('Referencia '+data.reference)
                        $('#reference-pdf').attr('src', link+data.reference);
                        $('#reference').modal('show');
                    }
                }); 
    }
</script>
@endsection