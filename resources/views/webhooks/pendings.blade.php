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

        <h2 class="panel-title">Pagos Pendientes del Mes {{$formatDate}}</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead style="cursor: pointer;">
                <tr>
                <th scope="col">Cliente</th>
                <th scope="col">Servicio</th>
                <th scope="col">Número</th>
                <th scope="col">Monto Esperado</th>
                <th scope="col">Fecha Pago</th>
                <th scope="col">Fecha Límite de Pago</th>
                <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
           
            @foreach($paymentsPendings as $paymentsPending)
                <tr>
                    <td>{{$paymentsPending->client_name.' '.$paymentsPending->client_lastname}}</td>
                    <td>{{$paymentsPending->rate_name}}</td>
                    <td>{{$paymentsPending->DN}}</td>
                    <td>${{number_format($paymentsPending->amount,2)}}</td>
                    <td>{{$paymentsPending->date_pay}}</td>
                    <td>{{$paymentsPending->date_pay_limit}}</td>
                    <td>
                        <a href="{{url('/clients-details/'.$paymentsPending->client_id)}}" class="btn btn-info btn-sm mt-xs " ><i class="fa  fa-eye"></i></a>
                    @php
                        $ref = $paymentsPending->referenceID == null ? 'N/A' : $paymentsPending->referenceID
                    @endphp

                    @if($ref == 'N/A')
                    @else
                        <button type="button" onclick="ref(this.id)" class="btn btn-warning btn-sm ref-generated mt-xs" id="{{ $ref }}"><i class="fa fa-file-text-o"></i></button>
                    @endif
                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
                        <button type="button" class="btn btn-success btn-sm mt-xs register-pay-manual" payID="{{$paymentsPending->id}}" service="{{$paymentsPending->number_product}}"><i class="fa  fa-hand-o-right"></i></button>
                    @endif
                    </td>
                </tr>
            @endforeach

            @foreach($paymentsPendings2 as $paymentsPending2)
                <tr>
                    <td>{{$paymentsPending2->client_name.' '.$paymentsPending2->client_lastname}}</td>
                    <td>{{$paymentsPending2->pack_name}}</td>
                    <td>{{$paymentsPending2->number_install}}</td>
                    <td>${{number_format($paymentsPending2->amount,2)}}</td>
                    <td>{{$paymentsPending2->date_pay}}</td>
                    <td>{{$paymentsPending2->date_pay_limit}}</td>
                    <td>
                        <a href="{{url('/clients-details/'.$paymentsPending2->client_id)}}" class="btn btn-info btn-sm mt-xs " ><i class="fa fa-eye"></i></a>
                    @php
                        $ref = $paymentsPending2->referenceID == null ? 'N/A' : $paymentsPending2->referenceID
                    @endphp

                    @if($ref == 'N/A')
                    @else
                        <button type="button" onclick="ref(this.id)" class="btn btn-warning btn-sm ref-generated mt-xs" id="{{ $ref }}"><i class="fa fa-file-text-o"></i></button>
                    @endif
                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
                        <button type="button" class="btn btn-success btn-sm mt-xs register-pay-manual" payID="{{$paymentsPending2->id}}" service="{{$paymentsPending2->service_name}}"><i class="fa  fa-hand-o-right"></i></button>
                    @endif
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
        <button type="button" class="mb-xs mt-xs mr-xs btn btn-success" id="referenceWhatsapp" data-message="" data-number-id="" data-channel="2"><i class="fa fa-mobile-phone"></i> Whatsapp</button>
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
            <button type="button" class="mb-xs mt-xs mr-xs btn btn-success" id="referenceWhatsapp2" data-message="" data-number-id="" data-channel="2"><i class="fa fa-mobile-phone"></i> Whatsapp</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
    </div>
</div>
<input type="hidden" id="user_id" value="{{Auth::user()->id}}">

  
<script>
    $('#date-pay').click(function(){
        $.ajax({
                url: "{{ route('date-pay')}}",
                success: function(data){
                    console.log(data);
                    
                }
            });
    });

    $('.register-pay-manual').click(function(){
        let service = $(this).attr('service');
        let payID = $(this).attr('payID');
        let preg = /^([0-9]+\.?[0-9]{0,2})$/; 
        let monto = 0;
        let montoExtra = 0;
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

                if(methodPay){
                    typePay = methodPay;

                    const { value: extraAmount } = await Swal.fire({
                        title: 'Si hay algún monto extra por instalación o adeudo de dispositivo, ingréselo.',
                        input: 'text',
                        inputValue: '0.00',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Ingrese un dato, por favor'
                            }
                        }
                    })

                    if(extraAmount){
                        montoExtra = extraAmount;

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
                                    "<li class='list-alert'><b>Estado: </b>"+estadoPay+"</li><br>"+
                                    "<li class='list-alert'><b>Extra: </b>$"+montoExtra+"</li><br>",
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
                                        registryPay(service, payID, monto, typePay, folioPay, estadoPay, montoExtra);
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
            }
        })()
    });

    function registryPay(service, payID, monto, typePay, folioPay, estadoPay, montoExtra){
        let url = "{{route('facturacion.index')}}";
        let user_id = $('#user_id').val();
        let data = {
            service: service,
            payID: payID,
            monto: monto,
            typePay: typePay,
            folioPay: folioPay,
            estadoPay: estadoPay,
            montoExtra: montoExtra,
            user_id:user_id};

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
                            }else{
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pago guardado con éxito.',
                                    showConfirmButton: false,
                                });
                                setTimeout(function(){ location.reload(); }, 2500);
                            }
                            // Swal.fire({
                            //     title: 'Pago guardado con éxito.',
                            //     html: "<h4 class='text-bold text-dark'>¿Cargar factura?</h4>",
                            //     icon: 'warning',
                            //     showCancelButton: true,
                            //     confirmButtonText: 'SÍ',
                            //     cancelButtonText: 'NO',
                            //     customClass: {
                            //         confirmButton: 'btn btn-success mr-md',
                            //         cancelButton: 'btn btn-danger '
                            //     },
                            //     buttonsStyling: false,
                            // }).then((result) => {
                            //     if (result.isConfirmed) {
                            //         location.href = url+'?payment='+payID+'&type='+service;
                            //     } else if (
                                   
                            //         result.dismiss === Swal.DismissReason.cancel
                            //     ) {
                            //         Swal.fire({
                            //             icon: 'success',
                            //             title: 'Operación exitosa',
                            //             text: 'No se cargó alguna factura.',
                            //             showConfirmButton: false,
                            //             timer: 1500
                            //         })
                            //         setTimeout(function(){ location.reload(); }, 2000);
                            //     }
                            // })
                        }else if(data == 0){
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Ocurrió un problema, intente de nuevo o contacte que Desarrollo.',
                                text: 'Bad Request'
                            })
                        }
                    }
                });  
            }
        });
    }

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
                        // console.log(data);
                        if(data.channel_id == 1){
                            $('#modalTitleRef').html('Referencia '+data.reference)
                            $('#reference-pdf').attr('src', link+data.reference);
                            $('#referenceWhatsapp').attr('data-message','Hola, '+data.name+' '+data.lastname+', puedes descargar tu referencia de pago de Altcel accediendo a la siguiente dirección: https://dashboard.openpay.mx/paynet-pdf/m3one5bybxspoqsygqhz/'+data.reference);
                            $('#referenceWhatsapp').attr('data-number-id',data.number_id);
                            $('#reference').modal('show');
                        }else if(data.channel_id == 2){
                            $('#montoOxxo').html('$'+data.amount+'<sup>MXN</sup>');
                            $('#referenceOxxoCard').html(data.reference);
                            $('#referenceWhatsapp2').attr('data-message','Hola, '+data.name+' '+data.lastname+', te compartimos tu referencia de pago de Altcel, tu número de referencia es: '+data.reference);
                            $('#referenceWhatsapp2').attr('data-number-id',data.number_id);
                            $('#referenceOxxo').modal('show');
                            // console.log('referencia OxxoPay');
                        }
                        // console.log(data.reference);
                    }
                }); 
    }

    $('#referenceWhatsapp, #referenceWhatsapp2').click(function(){
        let message = $(this).attr('data-message');
        let number_id = $(this).attr('data-number-id');
        
        $.ajax({
            url: "{{route('getDataClientBySIM.get')}}",
            method: 'GET',
            data:{number_id:number_id},
            success: function(response){
                window.open('https://api.whatsapp.com/send?phone=52'+response.cellphone+'&text='+message, '_blank');
            }
        });
        
    });
</script>
@endsection