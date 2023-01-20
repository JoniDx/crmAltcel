@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Producto</h2>

    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
                    <i class="fa fa-home"></i>
                </a>
            </li>
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
                        @if($service == 'MIFI' || $service == 'HBB' || $service == 'MOV')
                        <h4 class="card-title"></h4>
                        <h2 class="h2 mt-none mb-sm text-dark text-bold">{{$service.'/'.$DN}}</h2>
                        @elseif($service == 'Conecta' || $service == 'Telmex')
                        <h2 class="h2 mt-none mb-sm text-dark text-bold">{{$service}}</h2>
                        @endif
                        <h4 class="h4 m-none text-dark text-bold">Paquete/Plan Actual: <br>
                        {{$pack_name}} - {{'$'.number_format($pack_price,2)}}</h4>
                    </div>
                    <div class="col-sm-6 text-right mt-md mb-md">
                        <address class="ib mr-xlg">
                            Fecha de Activación: {{$date_activation}}
                            @if($service == 'MIFI' || $service == 'HBB' || $service == 'MOV')
                                <br/>
                                    @php
                                        $tag = $traffic_out == 'activo' ? 'label-success' : 'label-danger';
                                        $tagS = $traffic_out_in == 'activo' ? 'label-success' : 'label-danger'
                                    @endphp
                                Tráfico Saliente: <span class="label {{$tag}}" style="cursor: pointer;" data-msisdn="{{$DN}}" data-status="{{$traffic_out}}" data-toggle="tooltip" data-placement="left" title="Suspensión/Reanudación del Tráfico Saliente" id="traffic_out">{{$traffic_out}}</span>
                                <br/>
                                Tráfico Saliente/Entrante: <span class="label {{$tagS}}" style="cursor: pointer;" data-msisdn="{{$DN}}" data-status="{{$traffic_out_in}}" data-toggle="tooltip" data-placement="left" title="Suspensión/Reanudación del Tráfico Saliente/Entrante" id="traffic_out_in">{{$traffic_out_in}}</span>
                            
                            @endif
                            <br>
                            <button type="button" class="btn btn-success btn-xs mt-xs" data-toggle="modal" data-target="#operations"><li class="fa fa-cogs"></li> Operaciones</button>
                        </address>
                    </div>
                </div>
            </header>

            <div class="col-md-12">
                <div class="panel-body">
                    <div class="row mb-md">
                        <div class="col-md-4">
                            <span class="badge label label-{{$consultUF['status_color']}}">Estado: {{$consultUF['status']}}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="badge label label-success">IMEI: {{$consultUF['imei']}}</span>
                        </div>
                        <div class="col-md-4">
                            <span class="badge label label-success">ICC: {{$consultUF['icc']}}</span>
                        </div>
                    </div>
                    
                    @if($service == 'MIFI' || $service == 'HBB')
						<h4 class="h4 m-none text-dark text-bold">Plan contratado: {{$consultUF['rate']}}</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <meter min="0" max="100" value="{{$FreeUnits['freePercentage']}}" id="meter"></meter>
                                <h5 class="text-center text-bold text-dark">Porcentaje restante del plan contratado</h5>

								<div class="col-md-12 mt-2" >
									<ul class="list-group col-md-12" id="data-dn-list">
										<li class="list-group-item d-flex justify-content-between align-items-center text-dark">
											Unidades Totales: 
											<span class="badge label label-success">{{number_format($FreeUnits['totalAmt'],2)}} GB</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center text-dark">
											Unidades Restantes: 
											<span class="badge label label-success">{{number_format($FreeUnits['unusedAmt'],2)}} GB</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center text-dark">
											Inicio: 
											<span class="badge label label-success">{{$effectiveDatePrimary}}</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center text-dark">
											Expira: 
											<span class="badge label label-danger">{{$expireDatePrimary}}</span>
										</li>
									</ul>
								</div>

                                

                            </div>
                            <div class="col-md-6">
								@if($FreeUnits2Boolean == 1)
									<meter min="0" max="100" value="{{$FreeUnits2['freePercentage']}}" id="meterDark"></meter>
									<h5 class="text-center text-bold text-dark">Porcentaje de unidades libres en GB extras (recarga)</h5>
								@else
									<meter min="0" max="100" value="{{$FreeUnits2['freePercentage']}}" id="meterDark"></meter>
									<h5 class="text-center text-bold text-dark">Porcentaje de unidades libres en GB extras (sin recarga realizada)</h5>
								@endif
								<div class="col-md-12 mt-2" >
									<ul class="list-group col-md-12" id="data-dn-list">
										<li class="list-group-item d-flex justify-content-between align-items-center text-dark">
											Unidades Totales: 
											<span class="badge label label-success">{{number_format($FreeUnits2['totalAmt'],2)}} GB</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center text-dark">
											Unidades Restantes: 
											<span class="badge label label-success">{{number_format($FreeUnits2['unusedAmt'],2)}} GB</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center text-dark">
											Inicio: 
											<span class="badge label label-success">{{$effectiveDateSurplus}}</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center text-dark">
											Expira: 
											<span class="badge label label-danger">{{$expireDateSurplus}}</span>
										</li>
									</ul>
								</div>
                            </div>
                            
                        </div>
                    @elseif($service == 'MOV')
						<h4 class="h4 m-none text-dark text-bold">Plan contratado: {{$consultUF['rate']}}</h4>
                        <div class="panel-body">
                            @foreach($consultUF['freeUnits']['nacionales']  as $units)
                                <div class="col-md-4 text-dark mb-md">
                                    <h4 class="h4 m-none text-dark text-bold">{{$units['name']}}</h4>
                                    <h6 class="m-none text-dark text-bold">Total: {{number_format($units['totalAmt'],2).' '.$units['description']}}</h6>
                                    <h6 class="m-none text-dark text-bold">Restante: {{number_format($units['unusedAmt'],2).' '.$units['description']}}</h6>
                                    <div class="progress progress-striped light active m-md">
                                        <div class="progress-bar progress-bar-dark" role="progressbar" aria-valuenow="{{number_format($units['freePercentage'],2)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($units['freePercentage'],2)}}%;">
                                            {{number_format($units['freePercentage'])}}%
                                        </div>
                                    </div>
                                    Inicio: <span class="badge label label-success">{{$units['effectiveDate']}}</span><br>
                                    Expira: <span class="badge label label-danger">{{$units['expireDate']}}</span>
                                </div>
                            @endforeach
                            @foreach($consultUF['freeUnits']['ri']  as $units)
                                <div class="col-md-4 text-dark mb-md">
                                    <h4 class="h4 m-none text-dark text-bold">{{$units['name']}}</h4>
                                    <h6 class="m-none text-dark text-bold">Total: {{number_format($units['totalAmt'],2).' '.$units['description']}}</h6>
                                    <h6 class="m-none text-dark text-bold">Restante: {{number_format($units['unusedAmt'],2).' '.$units['description']}}</h6>
                                    <div class="progress progress-striped light active m-md">
                                        <div class="progress-bar progress-bar-dark" role="progressbar" aria-valuenow="{{number_format($units['freePercentage'],2)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($units['freePercentage'],2)}}%;">
                                            {{number_format($units['freePercentage'])}}%
                                        </div>
                                    </div>
                                    Inicio: <span class="badge label label-success">{{$units['effectiveDate']}}</span><br>
                                    Expira: <span class="badge label label-danger">{{$units['expireDate']}}</span>
                                </div>
                            @endforeach
							<hr> <br>
                            @foreach($consultUF['freeUnits']['extra']  as $units)
                                <div class="col-md-6 text-dark mb-md">
                                    <h4 class="h4 m-none text-dark text-bold">{{$units['name']}}</h4>
                                    <h6 class="m-none text-dark text-bold">Total: {{number_format($units['totalAmt'],2).' '.$units['description']}}</h6>
                                    <h6 class="m-none text-dark text-bold">Restante: {{number_format($units['unusedAmt'],2).' '.$units['description']}}</h6>
                                    <div class="progress progress-striped light active m-md">
                                        <div class="progress-bar progress-bar-dark" role="progressbar" aria-valuenow="{{number_format($units['freePercentage'],2)}}" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($units['freePercentage'],2)}}%;">
                                            {{number_format($units['freePercentage'])}}%
                                        </div>
                                    </div>
                                    Inicio: <span class="badge label label-success">{{$units['effectiveDate']}}</span><br>
                                    Expira: <span class="badge label label-danger">{{$units['expireDate']}}</span>
                                </div>
                            @endforeach 
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- <div class="text-right mr-lg">
            <a href="#" class="btn btn-default">Submit Invoice</a>
            <a href="pages-invoice-print.html" target="_blank" class="btn btn-primary ml-sm"><i class="fa fa-print"></i> Print</a>
        </div> -->

        <div class="col-md-12 mt-md">
            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#monthlies" data-toggle="tab">Mensualidades</a>
                    </li>
                    <li>
                        <a href="#purchases" data-toggle="tab">Excedentes</a>
                    </li>
                    <li>
                        <a href="#changes" data-toggle="tab">Cambios de Plan</a>
                    </li>
                    <li>
                        <a href="#history" data-toggle="tab">Historial de Número</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="monthlies" class="tab-pane active">
                        <p>Pagadas</p>
                        <table class="table table-bordered table-striped mb-none" id="datatable-default">
                            <thead style="cursor: pointer;">
                                <tr>
                                <th scope="col">Fecha de Pago</th>
                                <th scope="col">Fecha Límite de Pago</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">No. Referencia</th>
                                <th scope="col">Pagado el</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $monthlies as $monthly )
                            <tr style="cursor: pointer;">
                                <td>{{ $monthly->date_pay }}</td>
                                <td>{{ $monthly->date_pay_limit }}</td>
                                <td>${{ number_format($monthly->amount,2) }}</td>
                                <td>{{ $monthly->type }}</td>
                                <td>{{ $reference = $monthly->reference == null ? 'N/A' : $monthly->reference }}</td>
                                <td>{{ $monthly->date_paid }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="purchases" class="tab-pane">
                        <p>Pagados</p>
                        <table class="table table-bordered table-striped mb-none" id="datatable-default2">
                            <thead style="cursor: pointer;">
                                <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Oferta</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Razón/Referencia</th>
                                <th scope="col">Comentario</th>
                                <th scope="col">Realizado por</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $purchases as $purchase )
                            <tr style="cursor: pointer;">
                                <td>{{ $purchase->date }}</td>
                                <td>{{ $purchase->name }}</td>
                                <td>${{ number_format($purchase->amount,2) }}</td>
                                <td>{{ $purchase->reason }}</td>
                                <td>{{ $purchase->comment }}</td>
                                <td>{{ $purchase->user_name.' '.$purchase->user_lastname }}</td>
                            </tr>
                            @endforeach

                            @foreach( $referencePurchases as $referencePurchase )
                            <tr style="cursor: pointer;">
                                <td>{{ $date = $referencePurchase->date == null ? $referencePurchase->date_complete : $referencePurchase->date }}</td>
                                <td>{{ $referencePurchase->name }}</td>
                                <td>${{ number_format($referencePurchase->amount,2) }}</td>
                                <td>{{ $referencePurchase->channel.' - '.$referencePurchase->reference }}</td>
                                <td>N/A</td>
                                <td>{{ $referencePurchase->user_name.' '.$referencePurchase->user_lastname }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="changes" class="tab-pane">
                        <p>Pagados</p>
                        <table class="table table-bordered table-striped mb-none" id="datatable-default3">
                            <thead style="cursor: pointer;">
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Plan</th>
                                    <th scope="col">Oferta</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Referencia</th>
                                    <th scope="col">Razón</th>
                                    <th scope="col">Comentario</th>
                                    <th scope="col">Realizado por</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $changes as $change )
                            <tr style="cursor: pointer;">
                                <td>{{ $change->date }}</td>
                                <td>{{ $change->rate }}</td>
                                <td>{{ $change->offer }}</td>
                                <td>${{ number_format($change->amount,2) }}</td>
                                <td>{{ $reference = $change->reference == null ? 'N/A' : $change->channel.' - '.$change->reference }}</td>
                                <td>{{ $change->reason }}</td>
                                <td>{{ $comment = $change->comment == null ? 'N/A' : $change->comment }}</td>
                                <td>{{ $user = $change->user_name == null ? 'N/A' : $change->user_name.' '.$change->user_lastname }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="history" class="tab-pane">
                        <p>Números Anteriores</p>
                        <table class="table table-bordered table-striped mb-none" id="datatable-default4">
                            <thead style="cursor: pointer;">
                                <tr>
                                    <th scope="col">MSISDN Anterior</th>
                                    <th scope="col">Fecha de Operación</th>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Realizado por</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $historics as $historic )
                            <tr style="cursor: pointer;">
                                <td>{{ $historic->oldMSISDN }}</td>
                                <td>{{ $historic->date_change }}</td>
                                <td>{{ $historic->order_id }}</td>
                                <td>{{ $historic->user_name.' '.$historic->user_lastname }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal de Operaciones -->
<div class="modal fade" id="operations" tabindex="-1" aria-labelledby="operations" aria-hidden="true">
    <div class="modal-block modal-block-full">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-dark" id="operationsLabel">Operaciones</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="msisdn" value="{{$DN}}">
            <div class="container row">
                <button class="btn btn-warning btn-xs ml-xs mr-xs mt-xs mb-xs" id="predeactivate" data-type="predeactivate"><li class="fa fa-level-down"></li> Baja Temporal</button>
                <button class="btn btn-success btn-xs ml-xs mr-xs mt-xs mb-xs" id="reactivate" data-type="reactivate"><li class="fa fa-level-up"></li> Reactivación</button>
                <button class="btn btn-success btn-xs ml-xs mr-xs mt-xs mb-xs" id="purchase" ><li class="fa fa-plus-square"></li> Compra Excedente</button>

                @if($service == 'MIFI' || $service == 'HBB')
                <button class="btn btn-warning btn-xs ml-xs mr-xs mt-xs mb-xs" id="change" ><li class="fa fa-exchange"></li> Cambio de Paquete</button>
                @endif

                @if($service == 'MOV' || $service == 'MIFI')
                <button class="btn btn-warning btn-xs ml-xs mr-xs mt-xs mb-xs" id="changeMSISDN" ><li class="fa fa-exchange"></li> Cambio de MSISDN</button>
                @endif

                <button class="btn btn-warning btn-xs ml-xs mr-xs mt-xs mb-xs" id="reemplazoSIM" ><li class="fa fa-exchange"></li> Reemplazo de SIM</button>

                @if($service == 'HBB')
                <button class="btn btn-warning btn-xs ml-xs mr-xs mt-xs mb-xs" id="changeCoordinates" ><li class="fa fa-exchange"></li> Cambio de Coordenadas</button>
                @endif
            </div>

            <!-- Form Purchase -->
                <section class="panel form-wizard d-none" id="w6">
                    <header class="panel-heading">
        
                        <h2 class="panel-title">Compra de Producto</h2>
                    </header>
                    <div class="panel-body">
                        <div class="wizard-tabs hidden">
                            <ul class="wizard-steps">
                                <li class="active">
                                    <a href="#w6-msisdn-number-purchase" data-toggle="tab"><span class="badge">1</span>Número MSISDN</a>
                                </li>
                                <li>
                                    <a href="#w6-offer" data-toggle="tab"><span class="badge">2</span>Oferta</a>
                                </li>
                                <li>
                                    <a href="#w6-purchase-mood" data-toggle="tab"><span class="badge">3</span>Modo de Compra</a>
                                </li>
                            </ul>
                        </div>
                        <div class="progress progress-striped ligth active m-md light">
                            <div class="progress-bar progress-bar-danger" id="progress-bar-content-purchase" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                <span class="sr-only">60%</span>
                            </div>
                        </div>
                        
                        <form class="form-horizontal" novalidate="novalidate">
                            <div class="tab-content">
                                <div id="w6-msisdn-number-purchase" class="tab-pane active">
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="w6-msisdn">MSISDN</label>
                                            <input type="text" class="form-control" name="msisdn" id="w6-msisdn" maxlength="10" required value="{{$DN}}" disabled readonly>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div id="w6-offer" class="tab-pane">
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-6 row">
                                            <label for="ratesPurchaseProduct">Planes</label>
                                            <select class="form-control" name="ratesPurchaseProduct" id="ratesPurchaseProduct" required>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="w6-purchase-mood" class="tab-pane">
                                    <div class="col md-12">
                                        <div class="row">
                                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 6 || Auth::user()->id == 323)
                                            <div class="radio col-md-2">
                                                <label>
                                                    <input type="radio" name="purchaseProductRadio" value="purchaseProductFree">
                                                    Sin Costo
                                                </label>
                                            </div>
                                            <div class="radio col-md-2">
                                                <label>
                                                    <input type="radio" name="purchaseProductRadio" value="purchaseProductCollect">
                                                    Cobro
                                                </label>
                                            </div>
                                            @endif
                                            <div class="radio col-md-2">
                                                <label>
                                                    <input type="radio" name="purchaseProductRadio" value="purchaseProductPayment">
                                                    Referencia
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 6 || Auth::user()->id == 323)
                                    <div class="col-md-12 mt-md">
                                        <label class="col-md-12 " for="commentPurchase">Comentario</label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" rows="3" id="commentPurchase" placeholder="Si el excedente se dará sin cobro, escriba aquí la razón..."></textarea>
                                        </div>
                                    </div>
                                    @endif
                                    <hr >
                                    <div class="form-row mt-md d-none" id="formPurchaseProductPayment">
                                        <div class="form-group col-md-12">
                                            <h4>Información Personal para Referencia</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Nombre: </label>
                                            <input type="text" class="form-control form-control-sm" id="namePurchase" placeholder="Nombre" value="">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname">Apellidos: </label>
                                            <input type="text" class="form-control form-control-sm" id="lastnamePurchase" placeholder="Apellidos">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname">Email: </label>
                                            <input type="email" class="form-control form-control-sm" id="emailPurchase" value="" placeholder="Email" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname">Celular: </label>
                                            <input type="email" class="form-control form-control-sm" id="cellphonePurchase" placeholder="Celular">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname">Monto: </label>
                                            <input type="text" class="form-control form-control-sm" id="amountPurchase" placeholder="Monto" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname">Concepto: </label>
                                            <input type="email" class="form-control form-control-sm" id="conceptoPurchase" placeholder="Concepto" value="Compra de GBs Altcel.">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="channelPurchase">Métodos de Pago</label>
                                            <select id="channelPurchase" class="form-control form-control-sm">
                                                <option selected value="0">Choose...</option>
                                                @foreach($channels as $channel)
                                                <option value="{{$channel->id}}">{{$channel->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- div link reference to whatsApp -->
                                     <div class="dropdown  col-md-12 " id="pay-whats-purchases">
                                        <div class="panel">
                                            <button class="btn-link" aling="left" type="button" onclick="copyToClickBoardTwo()" class="btn-clipboard"><i class="fa fa-comments">WhatsApp</i></button>
                                            <pre class="chroma " id="url_pay-purchases"></pre>
                                        </div>
                                    </div>
                                        <input type="hidden" id="user_idPurchase" value="{{Auth::user()->id}}">
                                        <input type="hidden" id="client_idPurchase">
                                        <input type="hidden" id="number_idPurchase">
                                        <input type="hidden" id="referencestype_idPurchase" value="5">
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">
                        <ul class="pager">
                            <li class="previous disabled">
                                <a><i class="fa fa-angle-left"></i> Previous</a>
                            </li>
                            <li class="finish hidden pull-right">
                                <a>Finish</a>
                            </li>
                            <li class="next" id="nextproductPurchase">
                                <a id="nextproductPurchaseLink">Next <i class="fa fa-angle-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </section>
            <!-- END Form Purchase -->

            <!-- Form Change Product -->
                <section class="panel form-wizard d-none" id="w5">
                    <header class="panel-heading">
        
                        <h2 class="panel-title">Cambio de Paquete</h2>
                    </header>
                    <div class="panel-body">
                        <div class="wizard-tabs hidden">
                            <ul class="wizard-steps">
                                <li class="active">
                                    <a href="#w5-msisdn-number" data-toggle="tab"><span class="badge">1</span>Número MSISDN</a>
                                </li>
                                <li>
                                    <a href="#w5-rate" data-toggle="tab"><span class="badge">2</span>Planes</a>
                                </li>
                                <li>
                                    <a href="#w5-effectiveDate" data-toggle="tab"><span class="badge">3</span>Fecha Efectiva</a>
                                </li>
                            </ul>
                        </div>
                        <div class="progress progress-striped ligth active m-md light">
                            <div class="progress-bar progress-bar-danger" id="progress-bar-content" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                <span class="sr-only">60%</span>
                            </div>
                        </div>
                        <div class="alert alert-info d-none" id="infoDN">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <ul>
                                <li id="typeProduct"></li>
                                <li id="rateName"></li>
                                <li id="offerName"></li>
                                <li id="coordenadasInfo"></li>
                            </ul>
                        </div>
                        <form class="form-horizontal" novalidate="novalidate">
                            <div class="tab-content">
                                <div id="w5-msisdn-number" class="tab-pane active">
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-4">
                                            <label for="w5-msisdn">MSISDN</label>
                                            <input type="text" class="form-control" name="msisdn" id="w5-msisdn" maxlength="10" required value="{{$DN}}" disabled readonly>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div id="w5-rate" class="tab-pane">
                                    <div class="row d-none" id="coordenadasContent">
                                        <div class="col-sm-12 col-md-4 mr-md">
                                            <label for="w5-lat">Latitud</label>
                                            <div class="row">
                                                <input type="text" class="form-control" name="lat" id="w5-lat" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="w5-lng">Longitud</label>
                                            <div class="row">
                                                <input type="text" class="form-control" name="lng" id="w5-lng" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-6 row">
                                            <label for="ratesChangeProduct">Planes</label>
                                            <select class="form-control" name="ratesChangeProduct" id="ratesChangeProduct" required>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" id="originalRate">
                                    <input type="hidden" id="originalOffer">
                                    <input type="hidden" id="product">
                                </div>
                                <div id="w5-effectiveDate" class="tab-pane">
                                    <div class="form-group">
                                        <div class="col-sm-12 col-md-4 row" >
                                            <label >Fecha de la Operación</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="date" class="form-control" id="scheduleDateChange">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col md-12">
                                        <div class="row">
                                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 6 || Auth::user()->id == 323)
                                            <div class="radio col-md-2">
                                                <label>
                                                    <input type="radio" name="optionsRadiosC" id="internalRadio" value="internalChange" checked>
                                                    Cambio Interno
                                                </label>
                                            </div>
                                            <div class="radio col-md-2">
                                                <label>
                                                    <input type="radio" name="optionsRadiosC" id="internalExternalRadio" value="internalExternalChange">
                                                    Cambio Externo Gratis
                                                </label>
                                            </div>
                                            <div class="radio col-md-2">
                                                <label>
                                                    <input type="radio" name="optionsRadiosC" id="internalExternalRadioCollect" value="internalExternalChangeCollect">
                                                    Cambio Externo Cobro
                                                </label>
                                            </div>
                                            @endif
                                            <div class="radio col-md-2">
                                                <label>
                                                    <input type="radio" name="optionsRadiosC" id="internalExternalPaymentRadio" value="internalExternalPaymentChange">
                                                    Cambio Externo Pago Referenciado
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 6 || Auth::user()->id == 323)
                                    <div class="col-md-12 mt-md">
                                        <label class="col-md-12 " for="commentChangeProduct">Comentario</label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" rows="3" id="commentChangeProduct" placeholder="Si el cambio se hará sin cobro, escriba aquí la razón..."></textarea>
                                        </div>
                                    </div>
                                    @endif
                                    <hr >
                                    <div class="form-row mt-md d-none" id="formPayment">
                                        <div class="form-group col-md-12">
                                            <h4>Información Personal para Referencia</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Nombre: </label>
                                            <input type="text" class="form-control form-control-sm" id="name" placeholder="Nombre" value="">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname">Apellidos: </label>
                                            <input type="text" class="form-control form-control-sm" id="lastname" placeholder="Apellidos">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname">Email: </label>
                                            <input type="email" class="form-control form-control-sm" id="email" value="" placeholder="Email" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname">Celular: </label>
                                            <input type="email" class="form-control form-control-sm" id="cellphone" placeholder="Celular">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname">Monto: </label>
                                            <input type="text" class="form-control form-control-sm" id="amount" placeholder="Monto" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastname">Concepto: </label>
                                            <input type="email" class="form-control form-control-sm" id="concepto" placeholder="Concepto" value="Cambio de Producto Altcel.">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="my-product">Métodos de Pago</label>
                                            <select id="channel" class="form-control form-control-sm">
                                                <option selected value="0">Choose...</option>
                                                @foreach($channels as $channel)
                                                <option value="{{$channel->id}}">{{$channel->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- div link reference to whatsApp -->
                                    <div class="dropdown  col-md-12 " id="pay-whats-change">
                                        <div class="panel">
                                            <button class="btn-link" aling="left" type="button" onclick="copyToClickBoard()" class="btn-clipboard"><i class="fa fa-comments">WhatsApp</i></button>
                                            <pre class="chroma "id="url_pay-change"></pre>
                                        </div>
                                    </div>
                                        <input type="hidden" id="user_id" value="{{Auth::user()->id}}">
                                        <input type="hidden" id="client_id">
                                        <input type="hidden" id="number_id">
                                        <input type="hidden" id="referencestype_id" value="4">
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">
                        <ul class="pager">
                            <li class="previous disabled">
                                <a><i class="fa fa-angle-left"></i> Previous</a>
                            </li>
                            <li class="finish hidden pull-right">
                                <a>Finish</a>
                            </li>
                            <li class="next" id="nextChangeProduct">
                                <a id="nextChangeProductLink">Next <i class="fa fa-angle-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </section>
            <!-- END Form Change Product -->
            
            <!-- Form Change MSISDN -->
                <section class="panel form-wizard d-none" id="formChangeMSISDN">
                    <header class="panel-heading">
        
                        <h2 class="panel-title">Cambio de MSISDN</h2>
                    </header>
                    <div class="panel-body">
                        
                        <form class="form-horizontal" novalidate="novalidate">
                            <div class="tab-content">     
                                <div class="input-group mb-md col-md-4">
                                    <label for="msisdn_to_change">MSISDN</label>
                                    <input type="text" class="form-control" id="msisdn_to_change" maxlength="10" value="{{$DN}}" disabled readonly>
                                </div>
                                <div class="input-group mb-md col-md-4">
                                    <label for="msisdn_to_change">NIR</label>
                                    <input type="text" class="form-control" id="nir" maxlength="3">
                                </div>
                                <button class="btn btn-success" type="button" id="changeMSISDNBTN"><li class="fa fa-arrow-circle-right"></li></button>
                            </div>
                        </form>
                    </div>
                </section>
            <!-- END Form Change MSISDN -->

            <!-- Form Replacement SIM -->
                <section class="panel form-wizard d-none" id="formReplacementSIM">
                    <header class="panel-heading">

                        <h2 class="panel-title">Reemplazo SIM</h2>
                    </header>
                    <div class="panel-body">
                        
                        <form class="form-horizontal" novalidate="novalidate">
                            <div class="tab-content">
                                <div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
                                    <div class="col-md-4" style="padding-left: 0px !important; padding-right: 0px !important;">
                                        <label for="msisdn_locked">MSISDN</label>
                                        <input type="text" class="form-control" id="msisdn_replacementSim" maxlength="10" value="{{$DN}}" disabled readonly>
                                        <label for="msisdn_locked">ICC Nuevo</label>
                                        <input type="text" class="form-control" id="new_icc" maxlength="19">
                                        <div class="col-md-12">
                                        </div>
                                    </div>
                                    
                                </div>
                                <button type="button" class="btn btn-success mt-md" id="replacementSim">Aceptar</button>
                                
                            </div>
                        </form>
                    </div>
                </section>
            <!-- END Form Replacement SIM -->

            <!-- Form Change Link -->
                <div class="col-md-12 mt-md d-none" id="formChangeCoordinates">
                <h2 class="panel-title">Cambio de Coordenadas</h2>

                    <div class="col-md-12 mt-xs">
                        <div class="col-md-12">
                            <label for="msisdn">MSISDN</label>
                            <div class="input-group mb-md col-md-4">
                                <input type="text" class="form-control" id="msisdnchange" value="{{$DN}}" disabled readonly>
                            </div>
                            <div class="alert alert-info col-md-6" id="latlng">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                <p>Latitud y Longitud Actuales</p><br>
                                <strong id="lat">Latitud: {{$lat}}</strong><br>
                                <strong id="lng">Longitud: {{$lng}}</strong>
                            </div>
                        </div>
                        <!-- Actualización de coordenadas-->
                        <div class="col-md-12" id="coor">
                            <label for="Actualiza Coordenadas">Coordenadas Nuevas</label>
                            <div class="input-group mb-md col-md-4">
                                <label for="Actualiza Coordenadas">Latitud</label>
                                <input type="text" class="form-control" id="lat_hbb">
                            </div>
                            <div class="input-group mb-md col-md-4">
                                <label for="Actualiza Coordenadas">Longitud</label>
                                <input type="text" class="form-control" id="lng_hbb">
                            </div>
                            <button class="btn btn-success" type="button" id="changeCoordinate"><li class="fa fa-arrow-circle-right"></li></button>
                        </div>
                        
                    </div>
                </div>
            <!-- END Form Change Link -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>

    </div>
</div>

<!-- Modal de referencia OpenPay -->
<div class="modal fade" id="reference" tabindex="-1" aria-labelledby="reference" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="referenceLabel">Referencia</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div>
            <iframe class="col-md-12" id="reference-pdf" style="height: 400px;" src=""></iframe>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>

    </div>
</div>
<!-- Modal de referencia OxxoPay -->
<div class="modal fade" id="referenceOxxo" tabindex="-1" aria-labelledby="referenceOxxo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="referenceOxxoLabel">Referencia OXXOPay</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <div class="opps">
                <div class="opps-header">
                    <div class="opps-reminder">Ficha digital, puedes capturar la pantalla. No es necesario imprimir.</div>
                        <div class="opps-info">
                            <div class="opps-brand"><img src="{{asset('storage/uploads/oxxopay_brand.png')}}" alt="OXXOPay"></div>
                            <div class="opps-ammount">
                                <h3 class="title-3">Monto a pagar</h3>
                                <!-- <h2>$ 0,000.00 <sup>MXN</sup></h2> -->
                                <h2 id="montoOxxo"></h2>
                                <p>OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
                            </div>
                        </div>
                        <div class="opps-reference">
                            <h3 class="title-3">Referencia</h3>
                            <h1 class="referenceOxxoCard" id="referenceOxxoCard"></h1>
                        </div>
                    </div>
                    <div class="opps-instructions">
                        <h3 class="title-3">Instrucciones</h3>
                        <ol class="instructions">
                            <li style="margin-top: 10px;color: #000000;">Acude a la tienda OXXO más cercana. <a class="search-oxxo" href="https://www.google.com.mx/maps/search/oxxo/" target="_blank">Encuéntrala aquí</a>.</li>
                            <li style="margin-top: 10px;color: #000000;">Indica en caja que quieres realizar un pago de <strong>OXXOPay</strong>.</li>
                            <li style="margin-top: 10px;color: #000000;">Dicta al cajero el número de referencia en esta ficha para que tecleé directamete en la pantalla de venta.</li>
                            <li style="margin-top: 10px;color: #000000;">Realiza el pago correspondiente con dinero en efectivo.</li>
                            <li style="margin-top: 10px;color: #000000;">Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
                        </ol>
                        <div class="opps-footnote">Al completar estos pasos recibirás un correo de <strong>Nombre del negocio</strong> confirmando tu pago.</div>
                    </div>
                </div>	
            <div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
    </div>
</div>

<script src="{{asset('octopus/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
<script src="{{asset('octopus/assets/vendor/liquid-meter/liquid.meter.js')}}"></script>
<script src="{{asset('octopus/assets/vendor/snap-svg/snap.svg.js')}}"></script>

<!-- <script src="{{asset('octopus/assets/vendor/bootstrap/js/bootstrap.js')}}"></script> -->
<script src="{{asset('octopus/assets/vendor/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('octopus/assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js')}}"></script>
<script src="{{asset('octopus/assets/vendor/pnotify/pnotify.custom.js')}}"></script>

<script>

    $('#meter').liquidMeter({
		shape: 'circle',
		color: '#0088CC',
		background: '#272A31',
        stroke: '#33363F',
		fontSize: '24px',
		fontWeight: '600',
		textColor: '#FFFFFF',
		liquidOpacity: 0.9,
		liquidPalette: ['#0088CC'],
		speed: 3000
	});

	/*
	Liquid Meter Dark
	*/
	$('#meterDark').liquidMeter({
		shape: 'circle',
		color: '#0088CC',
		background: '#272A31',
		stroke: '#33363F',
		fontSize: '24px',
		fontWeight: '600',
		textColor: '#FFFFFF',
		liquidOpacity: 0.9,
		liquidPalette: ['#0088CC'],
		speed: 3000
	});

</script>
<script>
    var token = $('meta[name="csrf-token"]').attr('content'); 

    //send reference whatsApp
    $('#pay-whats-change').addClass('d-none');
    $('#pay-whats-purchases').addClass('d-none');

    function copyToClickBoard(){
        let content = document.getElementById('url_pay-change').innerHTML;
        let cellphone = $('#cellphone').val();
        window.open('https://api.whatsapp.com/send?phone=52'+cellphone+'&text=Hola, este es el link para completar tu pago en lí­nea por tu cambio de plan Altcel: '+content, '_blank');
    }

    function copyToClickBoardTwo(){
        let content = document.getElementById('url_pay-purchases').innerHTML;
        let cellphone = $('#cellphonePurchase').val();
        window.open('https://api.whatsapp.com/send?phone=52'+cellphone+'&text=Hola, este es el link para completar tu pago en lí­nea por tu compra de GBs Altcel: '+content, '_blank');
    }


    $('#traffic_out').click(function(){
        let status = $(this).attr('data-status');
        let msisdn = $(this).attr('data-msisdn');
        let type = 'out';
        activateDeactivateTraffic(status,type,msisdn);
    });

    $('#traffic_out_in').click(function(){
        let status = $(this).attr('data-status');
        let msisdn = $(this).attr('data-msisdn');
        let type = 'out_in';
        activateDeactivateTraffic(status,type,msisdn);
    });

    function activateDeactivateTraffic(status, type, msisdn){
        let headers = {headers: {'Content-type': 'application/json'}};
        let data = {
                _token: token, status: status, type: type, msisdn: msisdn
            };

            Swal.fire({
                title: 'Estamos trabajando en ello.',
                html: 'Espera un poco, un poquito más...',
                didOpen: () => {
                    Swal.showLoading();
                    $.ajax({
                        url:"{{route('activate-deactivate.post')}}",
                        method: "POST",
                        data: data,
                        success: function(data){
                            if(data.bool == 1){
                                    Swal.close();
                                    Swal.fire({
                                        icon: 'success',
                                        title: data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    setTimeout(function(){ location.reload(); }, 1500);
                                    // alert(data.bool)
                                }else if(data.bool == 0){
                                    Swal.close();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error: '+data.errorCode,
                                        text: data.description
                                    });
                                    // alert(data.bool)
                                }
                        }
                    });  
                }
            });
            
                // axios.post('/activate-deactivate/DN', data, headers).then(response => {
                        
                //         // if(response.data == 0){
                //         //     
                //         // }
                //     }).catch(e => {
                //         console.log(e);
                //     })
    }
</script>
<script>
    var stack_bar_bottom = {"dir1": "up", "dir2": "right", "spacing1": 0, "spacing2": 0};

    $('.modal-backdrop').click(function(){
        alert();
    });

    $('#predeactivate, #reactivate').click(function(){
        let type = $(this).data('type');
        let msisdn = $('#msisdn').val();
        let token = $('meta[name="csrf-token"]').attr('content');
        let textType = type == 'predeactivate' ? 'Baja Temporal' : 'Reactivación';

        $('#w5').addClass('d-none');
        $('#w6').addClass('d-none');
        $('#formChangeMSISDN').addClass('d-none');
        $('#formReplacementSIM').addClass('d-none');
        $('#formChangeCoordinates').addClass('d-none');


        Swal.fire({
            title: 'ATENCIÓN',
            html: "¿Está seguro de aplicar <b>"+textType+"</b> al MSISDN <b>"+msisdn+"</b>?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'SÍ, ESTOY SEGURO',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-primary mr-md',
                cancelButton: 'btn btn-danger '
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Estamos trabajando en ello.',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                        // setTimeout(function(){ Swal.close(); }, 2000);
                        
                        $.ajax({
                            url: "{{route('predeactivate.reactivate')}}",
                            method: "POST",
                            data: {_token:token, msisdn:msisdn, type:type, scheduleDate:''},
                            success: function(response){
                                if(response.http_code == 1){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Operación exitosa',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    })
                                }else if(response.http_code == 2){
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Ocurrió algo',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    })
                                }
                            }
                        });
                    }
                });
                
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Operación cancelada',
                    text: 'No se registro ningún pago.',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        })
    });

    $('#purchase').click(function(){
        $('#w6').removeClass('d-none');
        $('#w5').addClass('d-none');
        $('#formChangeMSISDN').addClass('d-none');
        $('#formReplacementSIM').addClass('d-none');
        $('#formChangeCoordinates').addClass('d-none');
    });

    $('#change').click(function(){
        $('#w5').removeClass('d-none');
        $('#w6').addClass('d-none');
        $('#formChangeMSISDN').addClass('d-none');
        $('#formReplacementSIM').addClass('d-none');
        $('#formChangeCoordinates').addClass('d-none');
    });

    $('#changeMSISDN').click(function(){
        $('#formChangeMSISDN').removeClass('d-none');
        $('#w5').addClass('d-none');
        $('#w6').addClass('d-none');
        $('#formReplacementSIM').addClass('d-none');
        $('#formChangeCoordinates').addClass('d-none');
    });

    $('#reemplazoSIM').click(function(){
        $('#formReplacementSIM').removeClass('d-none');
        $('#w5').addClass('d-none');
        $('#w6').addClass('d-none');
        $('#formChangeMSISDN').addClass('d-none');
        $('#formChangeCoordinates').addClass('d-none');
    });

    $('#changeCoordinates').click(function(){
        $('#formChangeCoordinates').removeClass('d-none');
        $('#formReplacementSIM').addClass('d-none');
        $('#w5').addClass('d-none');
        $('#w6').addClass('d-none');
        $('#formChangeMSISDN').addClass('d-none');
    });

    // Funcionalidad de Compra de Excedente
    $('#w6-msisdn').keyup(function(){
        let msisdn = $(this).val();
        if(msisdn.length == 10){
            $('#nextproductPurchase').removeClass('disabled');
            $('#nextproductPurchaseLink').removeClass('not-action');
        }else{
            $('#nextproductPurchase').addClass('disabled');
            $('#nextproductPurchaseLink').addClass('not-action');
        }
    });

    (function( $ ) {

        'use strict';

        var $w6finish = $('#w6').find('ul.pager li.finish'),
            $w6validator = $("#w6 form").validate({
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
                $(element).remove();
            },
            errorPlacement: function( error, element ) {
                element.parent().append( error );
            }
        });

        $w6finish.on('click', function( ev ) {
            ev.preventDefault();
            let msisdn = $('#w6-msisdn').val();
            let offerID = $('#ratesPurchaseProduct').val();
            let rate = $('#ratesPurchaseProduct option:selected').attr('data-rate-id');
            let price = $('#ratesPurchaseProduct option:selected').attr('data-rate-price');
            let offer_id = $('#ratesPurchaseProduct option:selected').attr('data-offer-id');
            let token = $('meta[name="csrf-token"]').attr('content');
            let route = '', data, method = 'GET';

            let channel = $('#channelPurchase').val();
            let number_id = $('#number_idPurchase').val();
            let name = $('#namePurchase').val();
            let lastname = $('#lastnamePurchase').val();
            let email = $('#emailPurchase').val();
            let cel_destiny_reference = $('#cellphonePurchase').val();
            let amount = $('#amountPurchase').val();
            let concepto = $('#conceptoPurchase').val();
            let user_id = $('#user_idPurchase').val();
            let client_id = $('#client_idPurchase').val();
            let referencestype = $('#referencestype_idPurchase').val();
            let comment = $('#commentPurchase').val();
            let reason = '', status = '';
            let pay_id = 0;
            
            // console.log(msisdn+' - '+offerID);

            var validated = $('#w6 form').valid();

            if($('input[name="purchaseProductRadio"]').is(':checked')) {
                if(validated){
                    let radioOption = $('input[name="purchaseProductRadio"]:checked').val();

                    if(radioOption == 'purchaseProductFree'){

                        if(comment.length == 0 || /^\s+$/.test(comment)){
                            
                            new PNotify({
                                title: 'Ooops!',
                                text: 'Por favor escriba la razón por la que el excedente será sin cobro.',
                                addclass: 'stack-bar-bottom',
                                stack: stack_bar_bottom,
                                width: "70%"
                            });
                            return false;
                        }

                        reason = 'bonificacion';
                        status = 'completado';

                    }else if(radioOption == 'purchaseProductCollect'){
                        reason = 'cobro';
                        status = 'pendiente';
                    }

                    if(radioOption == 'purchaseProductFree' || radioOption == 'purchaseProductCollect'){
                        data = {msisdn:msisdn, offer:offerID, user_id:user_id, rate_id:rate, offer_id:offer_id, price:price, comment:comment, reason:reason, status:status};
                        route = "{{route('purchase')}}";
                        method = 'GET';
                    }else if(radioOption == 'purchaseProductPayment'){
                        data = {
                            _token:token, number_id: number_id, name: name, lastname: lastname, email: email,
                            cel_destiny_reference: cel_destiny_reference, amount: amount, offer_id: offer_id,
                            concepto: concepto, type: referencestype, channel: channel, rate_id: rate, user_id: user_id,
                            client_id: client_id, pay_id: pay_id, quantity: 1
                        };
                        route = "{{url('/create-reference-openpay')}}";
                        method = 'POST';
                    }
                    // console.log(data);
                    // return false;
                    $.ajax({
                        url: route,
                        method: method,
                        data: data,
                        beforeSend: function(){
                            Swal.fire({
                                title: 'Estamos trabajando en tu petición...',
                                html: 'Espera un poco, un poquito más...',
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function(response){
                            console.log(response);
                            if(radioOption == 'purchaseProductFree' || radioOption == 'purchaseProductCollect'){
                                if(response.http_code == 1){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Hecho',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Ooops!',
                                        text: response.message
                                    });
                                }
                                
                            }else{
                                Swal.close();
                                if(channel == 1){
                                // referenceWhatsapp = response.reference;
                                pdfPaynet(response.reference,cel_destiny_reference,name,lastname);
                                }else if(channel == 2){
                                    // referenceWhatsapp = response.charges.data[0].payment_method.reference;
                                    showOxxoPay(response.amount,response.charges.data[0].payment_method.reference);
                                }else if(channel == 3){
                                    console.log(response)
                                    $('#pay-whats-purchases').removeClass('d-none');

                                    $('#url_pay-purchases').html(response.url);
                                }
                            }
                            
                        }
                    });
                    
                }
            }else{
                alert('Elige una opción...');
            }
            
        });

        $('#w6').bootstrapWizard({
            tabClass: 'wizard-steps',
            nextSelector: 'ul.pager li.next',
            previousSelector: 'ul.pager li.previous',
            firstSelector: null,
            lastSelector: null,
            onNext: function( tab, navigation, index, newindex ) {
                var validated = $('#w6 form').valid();
                
                if( !validated ) {
                    $w6validator.focusInvalid();
                    return false;
                }
            },
            onTabChange: function( tab, navigation, index, newindex ) {
                // console.log('onTabChange1: '+tab+' - '+navigation+' - '+index+' - '+newindex);
                if(index == 0){
                    let msisdn = $('#w6-msisdn').val();
                    getOffersSurplus(msisdn);
                }else if(index == 1){
                    console.log('evento2');
                }else if(index == 2){
                    // console.log('Do change');
                }
                var $total = navigation.find('li').size() - 1;
                $w6finish[ newindex != $total ? 'addClass' : 'removeClass' ]( 'hidden' );
                $('#w6').find(this.nextSelector)[ newindex == $total ? 'addClass' : 'removeClass' ]( 'hidden' );
            },
            onTabShow: function( tab, navigation, index ) {
                var $total = navigation.find('li').length;
                var $current = index + 1;
                var $percent = ( $current / $total ) * 100;
                $('#w6').find('.progress-bar').css({ 'width': $percent + '%' });
                
                if(index == 0){
                    let msisdn = $('#w6-msisdn').val();

                    // $('#infoDN').addClass('d-none');

                    $('#progress-bar-content-purchase').addClass('progress-bar-danger');
                    $('#progress-bar-content-purchase').removeClass('progress-bar-warning');
                    $('#progress-bar-content-purchase').removeClass('progress-bar-success');

                    if(msisdn.length < 10){
                        $('#nextproductPurchase').addClass('disabled');
                        $('#nextproductPurchaseLink').addClass('not-action');
                    }else{
                        $('#nextproductPurchase').removeClass('disabled');
                        $('#nextproductPurchaseLink').removeClass('not-action');
                    }
                }else if(index == 1){
                
                    $('#progress-bar-content-purchase').removeClass('progress-bar-danger');
                    $('#progress-bar-content-purchase').addClass('progress-bar-warning');
                    $('#progress-bar-content-purchase').removeClass('progress-bar-success');
                
                }else if(index == 2){
                    $('#progress-bar-content-purchase').removeClass('progress-bar-danger');
                    $('#progress-bar-content-purchase').removeClass('progress-bar-warning');
                    $('#progress-bar-content-purchase').addClass('progress-bar-success');
                }
            }
        });

    }).apply( this, [ jQuery ]);

    function getOffersSurplus(msisdn){
        let options = "<option select value='0'>Elige un plan...</option>";
        let dataMSISDN = 0, packsSurplus = 0;

        $.ajax({
            url: "{{route('getOffersSurplus.get')}}",
            data: {msisdn:msisdn},
            success: function(response){
                // console.log(response);
                dataMSISDN = response.dataMSISDN;
                packsSurplus = response.packsSurplus;
                console.log(dataMSISDN);

                $('#namePurchase').val(dataMSISDN.name_user); 
                $('#lastnamePurchase').val(dataMSISDN.lastname_user);
                $('#emailPurchase').val(dataMSISDN.email_user);
                $('#cellphonePurchase').val(dataMSISDN.cellphone_user);
                $('#number_idPurchase').val(dataMSISDN.number_id);
                $('#client_idPurchase').val(dataMSISDN.id_user);
            
                packsSurplus.forEach(function(element){
                    options+="<option value='"+element.offerID+"' data-rate-price='"+element.price_sale+"' data-rate-id='"+dataMSISDN.rate_id+"' data-offer-id='"+element.id+"'>"+element.name+" - $"+parseFloat(element.price_sale).toFixed(2)+"</option>"
                })
                $('#ratesPurchaseProduct').html(options);
            }
        });
    }

    $('input[name="purchaseProductRadio"]').click(function(){
        let radioOption = $(this).val();
        if(radioOption == 'purchaseProductFree' || radioOption == 'purchaseProductCollect'){
            $('#formPurchaseProductPayment').addClass('d-none');
        }else if(radioOption == 'purchaseProductPayment'){
            $('#formPurchaseProductPayment').removeClass('d-none');
        }
    });

    $('#ratesPurchaseProduct').change(function(){
        let amount = $('#ratesPurchaseProduct option:selected').attr('data-rate-price');
        $('#amountPurchase').val(parseFloat(amount).toFixed(2));
    });
    // END Funcionalidad de Compra de Excedente

    // Funcionalidad de Cambio de Producto
    (function( $ ) {

        'use strict';

        var $w5finish = $('#w5').find('ul.pager li.finish'),
            $w5validator = $("#w5 form").validate({
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
                $(element).remove();
            },
            errorPlacement: function( error, element ) {
                element.parent().append( error );
            }
        });

        $w5finish.on('click', function( ev ) {
            ev.preventDefault();
            let msisdn = $('#w5-msisdn').val();
            let rate = $('#ratesChangeProduct').val();
            let offerID = $('#ratesChangeProduct option:selected').attr('data-offerid');
            let offer_id = $('#ratesChangeProduct option:selected').attr('data-offer-id');
            let type = $('input[name="optionsRadiosC"]:checked').val();
            let producto = $('#product').val();
            let scheduleDateFirst = $('#scheduleDateChange').val();
            let scheduleDate = scheduleDateFirst.replace(/-/g, "");
            let token = $('meta[name="csrf-token"]').attr('content');
            let lat = '', lng = '', address = '';
            let data, route = '';

            let channel = $('#channel').val();
            let number_id = $('#number_id').val();
            let name = $('#name').val();
            let lastname = $('#lastname').val();
            let email = $('#email').val();
            let cel_destiny_reference = $('#cellphone').val();
            let amount = $('#amount').val();
            let concepto = $('#concepto').val();
            let user_id = $('#user_id').val();
            let client_id = $('#client_id').val();
            let referencestype = $('#referencestype_id').val();
            let comment = $('#commentChangeProduct').val();
            let reason = '', status = '';
            let pay_id = 0;

            if(scheduleDateFirst.length == 0 || /^\s+$/.test(scheduleDateFirst)){
                scheduleDate = '';
            }

            if(producto == 'HBB'){
                lat = $('#w5-lat').val();
                lng = $('#w5-lng').val();
                address = lat+','+lng;
            }else{
                address = null;
            }

            let originalRate = $('#originalRate').val();
            let originalOffer = $('#originalOffer').val();

            var validated = $('#w5 form').valid();
            if(validated){

                if((originalOffer == offer_id) && ((type == 'internalExternalChange') || (type == 'internalExternalPaymentChange') || (type == 'internalExternalChangeCollect'))){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oferta duplicada.',
                        text: 'El cambio externo no puede completarse, ya que eligió un plan con la misma oferta ALTAN. Para un cambio externo elija un plan con diferente oferta ALTAN.'
                    })
                    return false;
                }

                if(type == 'internalExternalChange'){

                    if(comment.length == 0 || /^\s+$/.test(comment)){
                        
                        new PNotify({
                            title: 'Ooops!',
                            text: 'Por favor escriba la razón por la que el cambio será sin cobro.',
                            addclass: 'stack-bar-bottom',
                            stack: stack_bar_bottom,
                            width: "70%"
                        });
                        return false;
                    }

                    reason = 'bonificacion';
                    status = 'completado';

                }else if(type == 'internalExternalChangeCollect'){
                    reason = 'cobro';
                    status = 'pendiente';
                }

                if(type == 'internalExternalPaymentChange'){
                    data = {
                        _token:token, number_id: number_id, name: name, lastname: lastname, email: email,
                        cel_destiny_reference: cel_destiny_reference, amount: amount, offer_id: offer_id,
                        concepto: concepto, type: referencestype, channel: channel, rate_id: rate, user_id: user_id,
                        client_id: client_id, pay_id: pay_id, quantity: 1
                    };
                    route = "{{url('/create-reference-openpay')}}";
                }else{
                    data = {
                        _token:token, 
                        msisdn:msisdn, 
                        rate_id:rate, 
                        offerID:offerID, 
                        offer_id:offer_id, 
                        type:type, 
                        scheduleDate:scheduleDate, 
                        address:address,
                        user_id: user_id,
                        amount: amount,
                        comment:comment,
                        reason:reason,
                        status:status,
                        pay_id:pay_id,
                        reference_id:null
                    }
                    route = "{{route('changeProduct.post')}}";
                }

                // console.log(data);
                // return false;

                $.ajax({
                    url: route,
                    method: "POST",
                    data: data,
		    beforeSend: function(){
                            Swal.fire({
                                title: 'Estamos trabajando en tu petición...',
                                html: 'Espera un poco, un poquito más...',
                                didOpen: () => {
                                    Swal.showLoading();
                           }
                     	});
                     },
                    success: function(response){
                    Swal.close();
                        if(type == 'internalExternalPaymentChange'){
                            if(channel == 1){
                                // referenceWhatsapp = response.reference;
                                pdfPaynet(response.reference,cel_destiny_reference,name,lastname);
                            }else if(channel == 2){
                                // referenceWhatsapp = response.charges.data[0].payment_method.reference;
                                showOxxoPay(response.amount,response.charges.data[0].payment_method.reference);
                            }else if(channel == 3){

                                $('#pay-whats-change').removeClass('d-none');

                                $('#url_pay-change').html(response.url);
                            }
                        }else{
                            if(response.http_code == 1){
                                new PNotify({
                                    title: 'Hecho',
                                    text: response.message,
                                    type: 'custom',
                                    addclass: 'notification-success',
                                    icon: 'fa fa-check'
                                });
                            }else if(response.http_code == 2){
                                new PNotify({
                                    title: 'Hecho',
                                    text: response.message,
                                    type: 'custom',
                                    addclass: 'notification-warning',
                                    icon: 'fa fa-check'
                                });
                            }
                        }
                    }
                });
            }
        });

        $('#w5').bootstrapWizard({
            tabClass: 'wizard-steps',
            nextSelector: 'ul.pager li.next',
            previousSelector: 'ul.pager li.previous',
            firstSelector: null,
            lastSelector: null,
            onNext: function( tab, navigation, index, newindex ) {
                var validated = $('#w5 form').valid();
                
                if( !validated ) {
                    $w5validator.focusInvalid();
                    return false;
                }
            },
            onTabChange: function( tab, navigation, index, newindex ) {
                // console.log('onTabChange1: '+tab+' - '+navigation+' - '+index+' - '+newindex);
                if(index == 0){
                    let msisdn = $('#w5-msisdn').val();
                    getOffersRatesDiff(msisdn);
                    $('#nextChangeProduct').addClass('disabled');
                    $('#nextChangeProductLink').addClass('not-action');

                }else if(index == 1){
                    // console.log('Captar oferta');
                }else if(index == 2){
                    // console.log('Do change');
                }
                var $total = navigation.find('li').size() - 1;
                $w5finish[ newindex != $total ? 'addClass' : 'removeClass' ]( 'hidden' );
                $('#w5').find(this.nextSelector)[ newindex == $total ? 'addClass' : 'removeClass' ]( 'hidden' );
            },
            onTabShow: function( tab, navigation, index ) {
                var $total = navigation.find('li').length;
                var $current = index + 1;
                var $percent = ( $current / $total ) * 100;
                $('#w5').find('.progress-bar').css({ 'width': $percent + '%' });
                
                if(index == 0){
                    let msisdn = $('#w5-msisdn').val();

                    $('#infoDN').addClass('d-none');

                    $('#progress-bar-content').addClass('progress-bar-danger');
                    $('#progress-bar-content').removeClass('progress-bar-warning');
                    $('#progress-bar-content').removeClass('progress-bar-success');

                    if(msisdn.length < 10){
                        $('#nextChangeProduct').addClass('disabled');
                        $('#nextChangeProductLink').addClass('not-action');
                    }else{
                        $('#nextChangeProduct').removeClass('disabled');
                        $('#nextChangeProductLink').removeClass('not-action');
                    }
                }else if(index == 1){
                    let rate = $('#ratesChangeProduct').val();
                    // console.log('rate: '+rate)
                    $('#progress-bar-content').removeClass('progress-bar-danger');
                    $('#progress-bar-content').addClass('progress-bar-warning');
                    $('#progress-bar-content').removeClass('progress-bar-success');

                    if(rate == 0 || rate == null){
                        $('#nextChangeProduct').addClass('disabled');
                        $('#nextChangeProductLink').addClass('not-action');
                    }else{
                        $('#nextChangeProduct').removeClass('disabled');
                        $('#nextChangeProductLink').removeClass('not-action');
                    }
                }else if(index == 2){
                    $('#progress-bar-content').removeClass('progress-bar-danger');
                    $('#progress-bar-content').removeClass('progress-bar-warning');
                    $('#progress-bar-content').addClass('progress-bar-success');
                }
            }
        });

    }).apply( this, [ jQuery ]);

    function getOffersRatesDiff(msisdn){
        let options = "<option select value='0'>Elige un plan...</option>";

        $.ajax({
            url: "{{route('getOffersRatesDiff.get')}}",
            data: {msisdn:msisdn},
            success: function(response){
                let offersAndRates = response.offersAndRates;
                $('#product').val(response.dataMSISDN.producto);
                $('#infoDN').removeClass('d-none');
                $('#typeProduct').html('Producto: <b>'+response.dataMSISDN.producto+'</b>');
                $('#rateName').html('Plan actual: <b>'+response.dataMSISDN.rate_name+'</b>');
                $('#offerName').html('Oferta actual: <b>'+response.dataMSISDN.offer_name+'</b>');

                if(response.dataMSISDN.producto == 'HBB'){
                    $('#coordenadasContent').removeClass('d-none');
                    $('#coordenadasInfo').removeClass('d-none');
                    $('#coordenadasInfo').html('LatLng: <b>'+response.dataMSISDN.lat+', '+response.dataMSISDN.lng+'</b>');
                    $('#w5-lat').val(response.dataMSISDN.lat);
                    $('#w5-lng').val(response.dataMSISDN.lng);
                }else{
                    $('#coordenadasContent').addClass('d-none');
                    $('#coordenadasInfo').addClass('d-none');
                    $('#w5-lat').val('');
                    $('#w5-lng').val('');
                }
                
                $('#originalRate').val(response.dataMSISDN.rate_id);
                $('#originalOffer').val(response.dataMSISDN.offer_id);
                offersAndRates.forEach(function(element){
                    options+="<option value='"+element.rate_id+"' data-rate-id='"+response.dataMSISDN.rate_id+"' data-rate-price='"+element.rate_price+"' data-offerID='"+element.offerID+"' data-offer-id='"+element.offer_id+"' >"+element.rate_name+" - $"+parseFloat(element.rate_price).toFixed(2)+"</option>"
                })
                $('#ratesChangeProduct').html(options);
            }
        });
    }

    $('#w5-msisdn').keyup(function(){
        let msisdn = $(this).val();
        if(msisdn.length == 10){
            $('#nextChangeProduct').removeClass('disabled');
            $('#nextChangeProductLink').removeClass('not-action');
        }else{
            $('#nextChangeProduct').addClass('disabled');
            $('#nextChangeProductLink').addClass('not-action');
        }
    });

    $('#ratesChangeProduct').change(function(){
        let valor = $(this).val();
        if(valor == 0){
            $('#nextChangeProduct').addClass('disabled');
            $('#nextChangeProductLink').addClass('not-action');
        }else{
            $('#nextChangeProduct').removeClass('disabled');
            $('#nextChangeProductLink').removeClass('not-action');
            let amount = $('#ratesChangeProduct option:selected').attr('data-rate-price');

            $('#amount').val(parseFloat(amount).toFixed(2));
        }
    });

    $('input[name="optionsRadiosC"]').on('click', function() {
        let radioOption = $(this).val();
        let msisdn = $('#w5-msisdn').val();
        let amount = $('#ratesChangeProduct option:selected').attr('data-rate-price');
        let options = '<option selected value="0">Choose...</option>';
        
        if(radioOption == 'internalExternalPaymentChange'){
            $('#formPayment').removeClass('d-none');
            $.ajax({
                url: "{{route('getDataClientChangeProduct.get')}}",
                data: {msisdn:msisdn},
                success: function(response){
                    $('#name').val(response.name);
                    $('#lastname').val(response.lastname);
                    $('#email').val(response.email);
                    $('#cellphone').val(response.cellphone);
                    $('#number_id').val(response.number_id);
                    $('#client_id').val(response.client_id);
                    $('#amount').val(parseFloat(amount).toFixed(2))
                }
            });
        }else{
            $('#formPayment').addClass('d-none');
        }
        
    });
    // END Funcionalidad de Cambio de Producto

    // Funcionalidad Change MSISDN
    $('#changeMSISDNBTN').click(function(){
        let msisdn = $('#msisdn_to_change').val();
        let nir = $('#nir').val();
        let token = $('meta[name="csrf-token"]').attr('content');

        if((msisdn.length > 0 && msisdn.length < 10) || (msisdn.length >10)){
            Swal.fire({
                icon: 'error',
                title: 'Por favor introduzca un MSISDN válido.',
                text: 'La longitud requerida es de 10 dígitos.',
                showConfirmButton: false,
                timer: 2000
            })
            return false;
        }

        if(msisdn.length == 0 || /^\s+$/.test(msisdn)){
            Swal.fire({
                icon: 'error',
                title: 'Por favor introduzca un MSISDN.',
                showConfirmButton: false,
                timer: 1500
            })
            return false;
        }

        if((nir.length > 0 && nir.length < 3) || (nir.length >3)){
            Swal.fire({
                icon: 'error',
                title: 'Por favor introduzca un NIR válido.',
                text: 'La longitud requerida es de 3 dígitos.',
                showConfirmButton: false,
                timer: 2000
            })
            return false;
        }

        if(nir.length == 0 || /^\s+$/.test(nir)){
            Swal.fire({
                icon: 'error',
                title: 'Por favor introduzca un NIR.',
                showConfirmButton: false,
                timer: 1500
            })
            return false;
        }

        Swal.fire({
            title: 'ATENCIÓN',
            html: "¿Está seguro de aplicar el cambio de número al MSISDN <b>"+msisdn+"</b>?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'SÍ, ESTOY SEGURO',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-primary mr-md',
                cancelButton: 'btn btn-danger '
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Estamos trabajando en ello.',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                        // setTimeout(function(){ Swal.close(); }, 2000);
                        $.ajax({
                            url: "{{route('bonding')}}",
                            method: 'POST',
                            data: {_token: token, msisdn:msisdn, nir:nir, type:'change'},
                            beforeSend: function(){
                                Swal.fire({
                                    title: 'Estamos trabajando en ello.',
                                    html: 'Espera un poco, un poquito más...',
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                            },
                            success: function(response){
                                if(response.http_code == 1){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Cambio de MSISDN hecho con éxito.',
                                        text: response.message,
                                    })
                                }else if(response.http_code == 0){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Woops!!',
                                        text: response.message,
                                    })
                                }else if(response.http_code == 2){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Woops!!',
                                        text: response.message,
                                    })
                                }else if(response.http_code == 3){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Woops!!',
                                        text: response.message,
                                    })
                                }
                            }
                        });
                    }
                });
                
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Operación cancelada',
                    text: 'No se registro ningún pago.',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        })
    });
    // END Funcionalidad Change MSISDN

    // Funcionalidad Replacement SIM
    $('#replacementSim').click(function(){
        let msisdn = $('#msisdn_replacementSim').val();
        let icc = $('#new_icc').val();

        if((msisdn.length > 0 && msisdn.length < 10) || (msisdn.length >10)){
            Swal.fire({
                icon: 'error',
                title: 'Por favor introduzca un MSISDN válido.',
                text: 'La longitud requerida es de 10 dígitos.',
                showConfirmButton: false,
                timer: 2000
            })
            return false;
        }

        if(msisdn.length == 0 || /^\s+$/.test(msisdn)){
            Swal.fire({
                icon: 'error',
                title: 'Por favor introduzca un MSISDN.',
                showConfirmButton: false,
                timer: 1500
            })
            return false;
        }

        if((icc.length > 0 && icc.length < 19) || (icc.length >19)){
            Swal.fire({
                icon: 'error',
                title: 'Por favor introduzca un ICC válido.',
                text: 'La longitud requerida es de 19 dígitos.',
                showConfirmButton: false,
                timer: 2000
            })
            return false;
        }

        if(icc.length == 0 || /^\s+$/.test(icc)){
            Swal.fire({
                icon: 'error',
                title: 'Por favor introduzca un ICC.',
                showConfirmButton: false,
                timer: 1500
            })
            return false;
        }
        // console.log(msisdn);
        Swal.fire({
            title: 'ATENCIÓN',
            html: "¿Está seguro de aplicar el cambio de número al MSISDN <b>"+msisdn+"</b>?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'SÍ, ESTOY SEGURO',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-primary mr-md',
                cancelButton: 'btn btn-danger '
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Estamos trabajando en ello.',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                        // setTimeout(function(){ Swal.close(); }, 2000);
                        $.ajax({
                            url:"{{route('replacementSim')}}",
                            data: {msisdn:msisdn, icc:icc ,type:'replace'},
                            beforeSend: function(){
                                Swal.fire({
                                    title: 'Estamos trabajando en ello.',
                                    html: 'Espera un poco, un poquito más...',
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                            },
                            success:function(response){
                                console.log(response)
                                if(response.http_code == 1){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'El reemplazo de SIM se realizó correctamente.',
                                        text: (response),
                                        showConfirmButton: true
                                    })
                                }else if(response.http_code == 0){
                                    Swal.fire({
                                        icon: 'error',
                                        title: response.message,
                                        text: (response),
                                        showConfirmButton: true
                                    })
                                }
                            }
                        })
                    }
                });
                
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Operación cancelada',
                    text: 'No se registro ningún pago.',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        })
    })
    // END Funcionalidad Replacement SIM

    // Funcionalidad Change Coordinates
        $("#changeCoordinate").click(function(){
            let lat_hbb = $('#lat_hbb').val();
            let lng_hbb = $('#lng_hbb').val();
            let msisdn = $('#msisdnchange').val();
            let scheduleDate = '';
            $.ajax({
                url: "{{route('updateCoordinate')}}",
                method: 'PATCH',
                data: {lat_hbb:lat_hbb, lng_hbb:lng_hbb, msisdn:msisdn},
                success: function(data){
                    if(data.http_code == 1){
                        Swal.fire({ 
                            icon: 'success',
                            title: 'Éxito',
                            text: (data.message),
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }else if(data.http_code == 0){
                        Swal.fire({ 
                            icon: 'error',
                            title: 'Ooops',
                            text: (data.message),
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }else if(data.http_code == 2){
                        Swal.fire({ 
                            icon: 'warning',
                            title: 'Ooops',
                            text: (data.message),
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                    // console.log(data)
                }
            })
        });
    // END Funcionalidad Change Coordinates

    // Funcionalidad de Modales de Referencias
    function pdfPaynet(reference,celphone,name,lastname){
        let link = 'https://dashboard.openpay.mx/paynet-pdf/m3one5bybxspoqsygqhz/'+reference;
        // let link = 'https://sandbox-dashboard.openpay.mx/paynet-pdf/mvtmmoafnxul8oizkhju/'+reference;
        $('#referenceWhatsapp').removeClass('d-none');
        $('#btn-reference-openpay').removeClass('d-none');
        $('#btn-reference-oxxo').addClass('d-none');
        $('#reference-pdf').removeClass('d-none');
        $('#reference-pdf').attr('src', link);
        $('#reference').modal('show');
        // window.open('https://api.whatsapp.com/send?phone=52'+celphone+'&text=Hola, '+name+' '+lastname+', puedes descargar tu referencia de pago de Altcel accediendo a la siguiente dirección: https://sandbox-dashboard.openpay.mx/paynet-pdf/mvtmmoafnxul8oizkhju/'+reference, '_blank');
    }

    function showOxxoPay(amount,reference){
        amount = amount/100;
        $('#referenceWhatsapp2').removeClass('d-none');
        $('#btn-reference-oxxo').removeClass('d-none');
        $('#btn-reference-openpay').addClass('d-none');
        $('#montoOxxo').html('$'+amount.toFixed(2)+'<sup>MXN</sup>');
        $('#referenceOxxoCard').html(reference);
        $('#referenceOxxo').modal('show');
    }
    // END Funcionalidad de Modales de Referencias
</script>
@endsection