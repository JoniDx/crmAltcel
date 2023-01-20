@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Detalles de <strong>{{$client_name}}</strong></h2>
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

        <h2 class="panel-title">Próximos Pagos</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead style="cursor: pointer;">
                <tr>
                <th scope="col">Servicio</th>
                <th scope="col">Número</th>
                <th scope="col">Plan</th>
                <!-- <th scope="col">Status</th> -->
                <th scope="col">Fecha de Pago</th>
                <th scope="col">Fecha Límite</th>
                <th scope="col">Días restantes</th>
                <th scope="col">Monto</th>
                <th scope="col">Recibido</th>
                <th scope="col">Restante</th>
                <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $mypays as $mypay )
            <tr style="cursor: pointer;">
                <td>{{ $mypay->number_product }}</td>
                <td>{{ $mypay->DN }}</td>
                <td>{{ $mypay->rate_name }}</td>
                <!-- <td>{{ $mypay->status }}</td> -->
                <td>{{ $mypay->date_pay }}</td>
                <td>{{ $mypay->date_pay_limit }}</td>
                @php
                $fecha1= new DateTime('NOW');
                $fecha2= new DateTime($mypay->date_pay);
                $diff = $fecha1->diff($fecha2);
                @endphp
                <td>{{$diff->days.' DÍAS'}}</td>
                <td>{{ '$'.number_format($mypay->amount,2) }}</td>

                <!-- Columnas de Recibido y Restante -->
                @php
                    $recibido = $mypay->amount_received;
                    $aRecibir = $mypay->amount;
                @endphp
                @if($recibido == null)
                    @php
                        $restante = 0.00;
                    @endphp
                <td>$0.00</td>
                @else
                    @php
                        $restante = $aRecibir - $recibido;
                    @endphp
                <td>{{ '$'.number_format($recibido,2) }}</td>
                @endif
                
                <td>{{ '$'.number_format($restante,2) }}</td>
                <!-- END Columnas de Recibido y Restante -->

                <td>
                @php
                    $ref = $mypay->reference_id == null ? 'N/A' : $mypay->reference_id
                @endphp
                    
                <a href="{{url('/generateReference/'.$mypay->id.'/'.$mypay->number_product.'/'.$client_id)}}" class="btn btn-success btn-sm mt-xs" data-toggle="tooltip" data-placement="left" title="" data-original-title="Generar pago de mensualidad"><i class="fa fa-money"></i></a>
                @if($ref == 'N/A')
                    
                @else
                    <button type="button" onclick="ref(this.id)" class="btn btn-warning btn-sm ref-generated mt-xs" id="{{ $ref }}" data-toggle="tooltip" data-placement="left" title="" data-original-title="Referencia generada"><i class="fa fa-eye"></i></button>
                @endif
                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
                        <button type="button" class="btn btn-success btn-sm mt-xs register-pay-manual" payID="{{$mypay->id}}" service="{{$mypay->number_product}}" data-toggle="tooltip" data-placement="left" title="" data-original-title="Registrar pago manual"><i class="fa  fa-hand-o-right"></i></button>
                    @endif
                    <a href="{{url('/show-product-details/'.$mypay->number_id.'/'.$mypay->activation_id.'/'.$mypay->number_product)}}" class="btn btn-info btn-sm mt-xs" data-toggle="tooltip" data-placement="left" title="" data-original-title="Información del servicio"><i class="fa fa-info-circle"></i></a>
                </td>
            </tr>
            @endforeach
            @foreach( $my2pays as $my2pay )
            <tr style="cursor: pointer;">
                <td>{{ $my2pay->service_name }}</td>
                <td>{{ $my2pay->instalation_number }}</td>
                <td>{{ $my2pay->pack_name }}</td>
                <!-- <td>{{ $my2pay->status }}</td> -->
                <td>{{ $my2pay->date_pay }}</td>
                <td>{{ $my2pay->date_pay_limit }}</td>
                @php
                $fecha1= new DateTime('NOW');
                $fecha2= new DateTime($my2pay->date_pay);
                $diff = $fecha1->diff($fecha2);
                @endphp
                <td>{{$diff->days.' DÍAS'}}</td>
                <td>{{ '$'.number_format($my2pay->amount,2) }}</td>

                <!-- Columnas de Recibido y Restante -->
                @php
                    $recibido = $my2pay->amount_received;
                    $aRecibir = $my2pay->amount;
                @endphp
                @if($recibido == null)
                    @php
                        $restante = 0.00;
                    @endphp
                <td>$0.00</td>
                @else
                    @php
                        $restante = $aRecibir - $recibido;
                    @endphp
                <td>{{ '$'.number_format($recibido,2) }}</td>
                @endif
                
                <td>{{ '$'.number_format($restante,2) }}</td>
                <!-- END Columnas de Recibido y Restante -->

                <td>
                @php
                    $ref = $my2pay->reference_id == null ? 'N/A' : $my2pay->reference_id
                @endphp

                    <a href="{{url('/generateReference/'.$my2pay->id.'/'.$my2pay->service_name.'/'.$client_id)}}" class="btn btn-success btn-sm mt-xs" data-toggle="tooltip" data-placement="left" title="" data-original-title="Generar pago de mensualidad"><i class="fa fa-money"></i></a>
                @if($ref == 'N/A')
                    
                @else
                    <button type="button" onclick="ref(this.id)" class="btn btn-warning btn-sm ref-generated mt-xs" id="{{ $ref }}" data-toggle="tooltip" data-placement="left" title="" data-original-title="Referencia generada"><i class="fa fa-eye"></i></button>
                @endif
                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
                        <button type="button" class="btn btn-success btn-sm mt-xs register-pay-manual" payID="{{$my2pay->id}}" service="{{$my2pay->service_name}}" data-toggle="tooltip" data-placement="left" title="" data-original-title="Registrar pago manual"><i class="fa  fa-hand-o-right"></i></button>
                    @endif
                    <a href="{{url('/show-product-details/null/'.$my2pay->instalation_id.'/'.$my2pay->service_name)}}" class="btn btn-info btn-sm mt-xs" data-toggle="tooltip" data-placement="left" title="" data-original-title="Información del servicio"><i class="fa fa-info-circle"></i></a>
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

        <h2 class="panel-title">Pagos completados</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default2">
            <thead style="cursor: pointer;">
                <tr>
                <th scope="col">Servicio</th>
                <th scope="col">Número</th>
                <th scope="col">Plan</th>
                <th scope="col">Status</th>
                <th scope="col">Fecha de Pago</th>
                <th scope="col">Fecha Límite</th>
                <th scope="col">Monto</th>
                <th scope="col">Forma de Pago</th>
                <th scope="col">Monto Recibido</th>
                <th scope="col">Folio</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $completemypays as $completemypay )
            <tr style="cursor: pointer;">
                <td>{{ $completemypay->number_product }}</td>
                <td>{{ $completemypay->DN }}</td>
                <td>{{ $completemypay->rate_name }}</td>
                <td>{{ $completemypay->status }}</td>
                <td>{{ $completemypay->date_pay }}</td>
                <td>{{ $completemypay->date_pay_limit }}</td>
                <td>{{ '$'.number_format($completemypay->amount,2) }}</td>
                <td>{{ $completemypay->type_pay }}</td>
                <td>{{ '$'.number_format($completemypay->amount_received,2) }}</td>
            @php
                $folio = $completemypay->reference_id == null ? $completemypay->folio_pay : $completemypay->reference_folio;
            @endphp
                <td><span class="badge label label-success">{{ $folio }}</span></td>
            </tr>
            @endforeach
            @foreach( $completemy2pays as $completemy2pay )
            <tr style="cursor: pointer;">
                <td>{{ $completemy2pay->service_name }}</td>
                <td>{{ $completemy2pay->instalation_number }}</td>
                <td>{{ $completemy2pay->pack_name }}</td>
                <td>{{ $completemy2pay->status }}</td>
                <td>{{ $completemy2pay->date_pay }}</td>
                <td>{{ $completemy2pay->date_pay_limit }}</td>
                <td>{{ '$'.number_format($completemy2pay->amount,2) }}</td>
                <td>{{ $completemy2pay->type_pay }}</td>
                <td>{{ '$'.number_format($completemy2pay->amount_received,2) }}</td>
            @php
                $folio = $completemy2pay->reference_id == null ? $completemy2pay->folio_pay : $completemy2pay->reference_folio;
            @endphp
                <td><span class="badge label label-success">{{ $folio }}</span></td>
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
        <table class="table table-bordered table-striped mb-none" id="datatable-default3">
            <thead >
                <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Servicio</th>
                <th scope="col">Número</th>
                <th scope="col">ICC</th>
                <th scope="col">Número de Serie</th>
                <th scope="col">Paquete</th>
                <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $activations as $activation )
            <tr style="cursor: pointer;">
                <td>{{ $activation->date_activation }}</td>
                <td>{{ $activation->service }}</td>
                <td>{{ $activation->DN }}</td>
                <td>{{ $activation->icc }}</td>
                <td>{{ $serial_number = $activation->serial_number != null ? $activation->serial_number : 'N/A'}}</td>
                <td>{{ $activation->pack_name }}</td>
                <td>
                    @if($activation->deleted_at == null)
                    <button type="button" class="mr-xs btn btn-warning btn-sm update-number" data-id="{{ $activation->id }}" data-type="activation"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar No. Serie"><i class="fa fa-edit" ></i></button>
                    <button type="button" class="mr-xs btn btn-warning btn-sm update-owner" data-id="{{ $activation->id }}" data-type="activation" data-toggle="tooltip" data-placement="left" title="" data-original-title="Cambiar propietario"><i class="fa fa-exchange" ></i></button>
                    <a href="{{url('/show-product-details/'.$activation->numbers_id.'/'.$activation->id.'/'.$activation->service)}}" class="mr-xs btn btn-info btn-sm " data-toggle="tooltip" data-placement="left" title="" data-original-title="Información del servicio"><i class="fa fa-info-circle"></i></a>
                    <button class="mr-xs btn btn-danger btn-sm delete-activation" data-id="{{ $activation->id }}" data-toggle="tooltip" data-placement="left" title="" data-original-title="Cancelar servicio"><i class="fa fa-level-down"></i></button>
                    @else
                    <span class="badge label label-danger">Sin Opciones. SIM dada de BAJA DEFINITIVA.</span>
                    @endif
                </td>
            </tr>
            @endforeach
            @foreach( $instalations as $instalation )
            <tr style="cursor: pointer;">
                <td>{{ $instalation->date_instalation }}</td>
                <td>{{ $instalation->service }}</td>
                <td>{{ $number = $instalation->number != null ? $instalation->number : 'N/A' }}</td>
                <td>N/A</td>
                <td>{{ $serial_number = $instalation->serial_number != null ? $instalation->serial_number : 'N/A' }}</td>
                <td>{{ $instalation->pack_name }}</td>
                <td>
                    <button type="button" class=" mt-xs mr-xs btn btn-warning btn-sm update-number" data-id="{{ $instalation->id }}" data-type="instalation" data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar No. Serie" ><i class="fa fa-edit"></i></button>
                    <button type="button" class="mr-xs btn btn-warning btn-sm update-owner" data-id="{{ $instalation->id }}" data-type="instalation" data-toggle="tooltip" data-placement="left" title="" data-original-title="Cambiar propietario"><i class="fa fa-exchange" ></i></button>
                    <!-- <a href="{{url('/show-product-details/null/'.$instalation->id.'/'.$instalation->service)}}" class="btn btn-info btn-sm mt-xs"><i class="fa fa-info-circle"></i></a> -->
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>   
    </div>
</section>

<!-- Modal Referencia -->
<div class="modal fade" id="reference" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleRef">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe class="col-md-12" id="reference-pdf" style=" width: 100%; height: 400px;" src=""></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
<!-- Modal de Cliente Nuevo -->
<div class="modal fade" id="numberModal" tabindex="-1" aria-labelledby="numberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualización de Datos en el Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="display:flex; justify-content:center; margin-left: auto !important;">
                <div class="col-md-6" id="no_indentify_content">
                    <label for="exampleDataList" class="form-label">No. Identificación</label>
                    <input class="form-control" id="number_telmex" >
                    <input type="hidden" class="form-control" id="number_id">
                    <input type="hidden" class="form-control" id="type">
                </div>
                <div class="col-md-6">
                    <label for="exampleDataList" class="form-label">Número de Serie</label>
                    <input class="form-control" id="serial_number" >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_number">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Cancelación de Activación -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualización de Datos en el Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="display:flex; justify-content:center; margin-left: auto !important;">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <label for="amount_cancelation" class="form-label">Monto:</label>
                        <input class="form-control" name="amount_cancelation" id="amount_cancelation" value="0.00">
                    </div>
                    <div class="col-md-6">
                        <label for="cancelation_type">Tipo de Cancelación</label>
                        <select id="cancelation_type" class="form-control form-control-sm">
                            <option selected value="0">Elegir...</option>
                            <option value="restore">Devolución y Baja Definitiva</option>
                            <option value="destroy">Solo Baja Definitiva</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="reason-delete" class="form-label">Razón:</label>
                        <textarea class="form-control" name="reason-delete" id="reason-delete" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <input type="hidden" class="form-control" id="activation-delete-id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="delete-activation">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Cambio de Propietario -->
<div class="modal fade" id="changeOwner" tabindex="-1" aria-labelledby="changeOwnerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambio de Propietario del Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="display:flex; justify-content:center; margin-left: auto !important;">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="col-md-12 mb-lg" id="msisdn-select">
                            <label>Clientes</label>
                            <select data-plugin-selectTwo class="form-control populate" id="client" onchange="getData()">
                                <optgroup label="Clientes disponibles">
                                <option value="0">Elige...</option>
                                @foreach($clients as $client)
                            <option value="{{$client->id}}">
                                {{$client->name.' '.$client->lastname.' '.$client->email}}
                            </option>
                            @endforeach
                                </optgroup>
                                
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" class="form-control" id="client_new_id">
                <input type="hidden" class="form-control" id="activation_new_id">
                <input type="hidden" class="form-control" id="type_service">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="change-owner-btn">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var x = '';
    function ref(reference_id){
        // let link = 'https://sandbox-dashboard.openpay.mx/paynet-pdf/mvtmmoafnxul8oizkhju/';
        let link = 'https://dashboard.openpay.mx/paynet-pdf/m3one5bybxspoqsygqhz/';

            $.ajax({
                    url:"{{url('/show-reference')}}",
                    method: "GET",
                    data: {
                        reference_id: reference_id
                    },
                    success: function(data){
                        // x=data;
                        if(data.channel_id == 1){
                            $('#modalTitleRef').html('Referencia '+data.reference)
                            $('#reference-pdf').attr('src', link+data.reference);
                            $('#reference').modal('show');
                        }else if(data.channel_id == 2){
                            $('#montoOxxo').html('$'+data.amount+'<sup>MXN</sup>');
                            $('#referenceOxxoCard').html(data.reference);
                            
                            $('#referenceOxxo').modal('show');
                            console.log('referencia OxxoPay');
                        }
                        console.log(data.reference);
                    }
                }); 
    }

    $('.register-pay-manual').click(function(){
        let service = $(this).attr('service');
        let payID = $(this).attr('payID');
        let preg = /^([0-9]+\.?[0-9]{0,2})$/; 
        let monto = 0;
        let typePay = '';
        let folioPay = '';
        let estadoPay = '';
        // console.log(service+' - '+payID);
        
        (async () => {
            const { value: amount } = await Swal.fire({
                title: 'Ingrese el monto, por favor',
                input: 'text',
                inputLabel: '$',
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return 'Por favor ingrese un valor'
                    }

                    if(preg.test(value) === false){
                        // monto = value;
                        // methodPay(monto);
                        return 'Sólo se permiten números y dos décimales';
                    }
                }
            })

            if (amount) {
                monto = amount;
                const { value: methodPay } = await Swal.fire({
                    title: 'Método de pago por el monto de $'+amount,
                    input: 'select',
                    inputOptions: {
                        'efectivo': 'Efectivo',
                        'deposito': 'Depósito',
                        'transferencia': 'Transferencia',
                    },
                    inputPlaceholder: 'Elige uno...',
                    showCancelButton: true,
                    inputValidator: (value) => {
                        return new Promise((resolve) => {
                        if (value == 'efectivo' || value == 'deposito' || value == 'transferencia') {
                            typePay = value;
                            resolve()
                        } else {
                            resolve('Seleccione un método de pago, por favor')
                        }
                        })
                    }
                })

                if (methodPay) {
                    typePay = methodPay;

                    const { value: folio } = await Swal.fire({
                        title: 'Ingrese el folio de pago, por favor',
                        input: 'text',
                        inputValue: 'N/A',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Ingrese un dato, por favor'
                            }
                        }
                    })

                    if(folio){
                        folioPay = folio;
                        const { value: statusPay } = await Swal.fire({
                            title: 'Indique el estado del pago:',
                            input: 'select',
                            inputOptions: {
                                'pendiente': 'Pendiente',
                                'completado': 'Completado',
                            },
                            inputPlaceholder: 'Elija uno...',
                            showCancelButton: true,
                            inputValidator: (value) => {
                                return new Promise((resolve) => {
                                if (value == 'pendiente' || value == 'completado') {
                                    estadoPay = value;
                                    resolve()
                                } else {
                                    resolve('Seleccione un método de pago, por favor')
                                }
                                })
                            }
                        })

                        if(statusPay){
                            estadoPay = statusPay;

                            Swal.fire({
                                title: 'Verifique los datos siguientes:',
                                html: "<li class='list-alert'><b>Monto: </b>$"+monto+"</li><br>"+
                                "<li class='list-alert'><b>Método: </b>"+typePay+"</li><br>"+
                                "<li class='list-alert'><b>Folio: </b>"+folioPay+"</li><br>"+
                                "<li class='list-alert'><b>Estado: </b>"+estadoPay+"</li><br>",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Guardar',
                                cancelButtonText: 'Cancelar',
                                customClass: {
                                    confirmButton: 'btn btn-success mr-md',
                                    cancelButton: 'btn btn-danger '
                                },
                                buttonsStyling: false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    registryPay(service, payID, monto, typePay, folioPay, estadoPay);
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
                        }
                    }
                }
            }
        })()
    });

    function registryPay(service, payID, monto, typePay, folioPay, estadoPay){
        // console.log(service+' - '+payID+' - '+monto+' - '+typePay+' - '+folioPay);
        let data = {
            service: service,
            payID: payID,
            monto: monto,
            typePay: typePay,
            folioPay: folioPay,
            estadoPay: estadoPay,
            user_id: "{{ Auth::user()->id}}"
        };

        Swal.fire({
            title: 'Registrando pago...',
            html: 'Espera un poco, un poquito más...',
            didOpen: () => {
                Swal.showLoading();
                // setTimeout(function(){ Swal.close(); }, 2000);
                $.ajax({
                    url:"{{route('save-manual-pay.get')}}",
                    method: "GET",
                    data: data,
                    success: function(data){
                        // return console.log(data);
                        if(data == 1){
                            Swal.close();
                            Swal.fire({
                                icon: 'success',
                                title: '¡Guardado!',
                                text: 'Éxito'
                            });
                            if(service != 'Telmex'){
                                $.ajax({
                                    url:"{{route('unbarring.get')}}",
                                    method: "GET",
                                    data: {payID:payID},
                                    beforeSend: function(){
                                        Swal.fire({
                                            title: 'Pago guardado con éxito',
                                            html: 'El servicio se está reanudando...',
                                            didOpen: () => {
                                                Swal.showLoading();
                                            }
                                        });
                                    },
                                    success:function(response){
                                        
                                        if(response == 1){
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'El servicio ha sido reanudado.',
                                                showConfirmButton: false,
                                            });
                                            setTimeout(function(){ location.reload(); }, 2500);
                                        }else{
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Hubo un problema al reanudar el servicio.',
                                                text: 'Bad Request'
                                            });
                                        }
                                        
                                    }
                                });
                            }
                        }else if(data == 0){
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Ocurrió un error, intente de nuevo o contacte a Desarrollo.',
                                text: 'Bad Request'
                            })
                        }
                    }
                });  
            }
        });
    }

    $('.update-number').click(function(){
        let id = $(this).attr('data-id');
        let type = $(this).attr('data-type');
        
        $.ajax({
            url:"{{route('getNumberInstalation.get')}}",
            method: "GET",
            data: {id:id,type:type},
            success: function(data){
                console.log(data);
                if(type == 'activation'){
                    $('#no_indentify_content').addClass('d-none');
                }else{
                    $('#no_indentify_content').removeClass('d-none');
                }
                $('#number_telmex').val(data.number);
                $('#serial_number').val(data.serial_number);
                $('#number_id').val(data.id);
                $('#type').val(type);
                $('#numberModal').modal('show');
            }
        });  
    });

    $('#save_number').click(function(){
        let number = $('#number_telmex').val();
        let serial_number = $('#serial_number').val();
        let id = $('#number_id').val();
        let type = $('#type').val();
        
        $.ajax({
            url:"{{route('setNumberInstalation.get')}}",
            method: "GET",
            data: {id:id,number:number,serial_number:serial_number, type:type},
            success: function(data){
                console.log(data);
                location.reload();
            }
        });  
    });

    $('.delete-activation').click(function(){
        let activation_id = $(this).data('id');
        $('#activation-delete-id').val(activation_id);
        $('#deactivateModal').modal('show');
    });

    $('.update-owner').click(function(){
        let id = $(this).data('id');
        let type = $(this).data('type');
        $('#activation_new_id').val(id);
        $('#type_service').val(type);
        $('#changeOwner').modal('show');
    });

    $('#delete-activation').click(function(){
        let activation_id = $('#activation-delete-id').val();
        let amount = $('#amount_cancelation').val();
        let reason = $('#reason-delete').val();
        let type = $('#cancelation_type').val();

        if(type == 0){
            Swal.fire({
                icon: 'error',
                title: 'Woops!!',
                text: "Por favor elija un tipo de cancelación.",
                showConfirmButton: false,
                timer: 2000
            });
            document.getElementById('reason-delete').focus();
            return false;
        }

        if(reason.length == 0 || /^\s+$/.test(reason)){
            Swal.fire({
                icon: 'error',
                title: 'Woops!!',
                text: "Por favor ingrese la razón la que se realiza la cancelación.",
                showConfirmButton: false,
                timer: 2000
            });
            document.getElementById('reason-delete').focus();
            return false;
        }

        Swal.fire({
            title: '¿Está seguro de dar de baja la activación?',
            text: 'Esto ocasionará la baja definitiva de la SIM. ESTO NO SE PUEDE REVERTIR.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-success mr-md',
                cancelButton: 'btn btn-danger '
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{route('deleteActivation')}}",
                    data: {activation_id:activation_id,amount:amount,reason:reason,type:type},
                    beforeSend: function(){
                        Swal.fire({
                            title: 'Realizando BAJA DEFINITIVA...',
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
                                title: 'Well done!!',
                                text: response.message
                            });
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Woops!!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    }
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Operación cancelada',
                    showConfirmButton: false,
                    timer: 1000
                });
            }
        });
    });

    $('#change-owner-btn').click(function(){
        let client = $('#client_new_id').val();
        let activation = $('#activation_new_id').val();
        let type = $('#type_service').val();
        let url = "/clients-details/"+client+"#datatable-default3";

        if(client == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops!!',
                text: "Por favor elija un cliente al cual se asignará el servicio.",
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }

        $.ajax({
            url: "{{route('changeOwner')}}",
            data: {activation:activation, type:type, client:client},
            beforeSend: function(){
                Swal.fire({
                    title: 'Realizando cambio...',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response){
                
                if(response.http_code = 1){
                    location.href = url;
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!!',
                        text: "Al parecer algo salió mal, intente de nuevo o contacte a Desarrollo."
                    });
                }
                
            }
        });

    });

    function getData(){
        let client_id = $('#client').val();
        $('#client_new_id').val(client_id);
    }
</script>
@endsection