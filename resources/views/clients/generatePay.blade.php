@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Pago de Servicios <strong>{{$data_client['service']}}</strong></h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Generar Referencia</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" method="get">
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <h3>Información personal</h3>
                        <div class="form-group col-md-12">
                            <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                            <div class="col-md-12">
                                <section class="form-group-vertical">
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="name" placeholder="Nombre" value="{{$data_client['client_name']}}">
                                    </div>
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="lastname" placeholder="Apellidos" value="{{$data_client['client_lastname']}}">
                                    </div>
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="email" value="{{$data_client['client_email']}}" placeholder="Email">
                                    </div>
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-phone"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="cellphone" placeholder="Celular" value="{{$data_client['client_phone']}}">
                                    </div>
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                            Número al que se enviará la referencia generada.
                                        </div>
                                </section>
                            </div>
                        </div>
                        <h3>Datos Extras</h3>
                        @if($datos['referencestype'] == 1)

                        <div class="form-group col-md-6" id="content-rate">
                            <label for="exampleFormControlSelect1">Planes: </label>
                            <select class="form-control form-control-sm" id="rate" >
                                <option selected value="{{$datos['rate_id']}}" data-offer-id="{{$datos['offer_id']}}" data-price="{{$datos['rate_price']}}">{{$datos['rate_name'].' - $'.number_format($datos['rate_price'],2)}}</option>
                                @foreach($rates as $rate)
                                <option value="{{$rate->id}}" data-offer-id="{{$rate->offer_id}}" data-price="{{$rate->price_subsequent}}">{{ $rate->name.' - $'.number_format($rate->price_subsequent,2) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="lastname">Número de tu Producto: </label>
                            <input type="text" class="form-control form-control-sm" id="number_product" placeholder="Monto" value="{{$datos['DN']}}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="lastname">Monto: </label>
                            <input type="text" class="form-control form-control-sm" id="amount" placeholder="Monto" value="{{number_format($datos['rate_price'],2)}}" readonly>
                        </div>

                        <input type="hidden" id="number_id" value="{{$datos['number_id']}}">
                        <!-- <input type="hidden" id="offer_id" value="{{$datos['offer_id']}}"> -->

                        @elseif($datos['referencestype'] == 2)

                        <div class="form-group col-md-6" id="content-rate">
                            <label for="exampleFormControlSelect1">Paquete: </label>
                            <select class="form-control form-control-sm" id="pack" >
                                <option selected value="{{$datos['pack_id']}}">{{$datos['pack_name']}}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="lastname">Monto: </label>
                            <input type="text" class="form-control form-control-sm" id="amount" placeholder="Monto" value="{{number_format($datos['pack_price'],2)}}" readonly>
                        </div>
                        @endif

                        <div class="form-group col-md-6">
                            <label for="lastname">Concepto: </label>
                            <input type="text" class="form-control form-control-sm" id="concepto" placeholder="Concepto" value="{{$datos['concepto']}}">
                        </div>
                        <div class="form-group col-md-6" id="content-rate">
                            <label for="exampleFormControlSelect1">Canal de Pago: </label>
                            <select class="form-control form-control-sm" id="channel" >
                                <option value="0">Nothing</option>
                                @foreach($channels as $channel)
                                <option value="{{$channel->id}}">{{$channel->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="referencestype_id" value="{{$datos['referencestype']}}">
                        <input type="hidden" class="form-control form-control-sm" id="client_id" value="{{$data_client['client_id']}}">
                        <input type="hidden" class="form-control form-control-sm" id="user_id" value="{{$data_client['employe_id']}}">
                        <input type="hidden" class="form-control form-control-sm" id="pay_id" value="{{$data_client['pay_id']}}">
                        
                        <div class="dropdown  col-md-12" id="pay">
                            <div class="panel">
                                <button class="btn-link" aling="left" type="button" onclick="copyToClickBoard()" class="btn-clipboard"><i class="fa fa-comments">WhatsApp</i></button>
                                <pre class="chroma" id="url_pay"></pre>
                            </div>
                        </div>
                        <div class="form-actions col-md-12">
                            @if($datos['referencestype'] == 1)
                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-success" id="pay_generate"><span class="spinner-border spinner-border-sm d-none" id="spinner-pay_generate" role="status" aria-hidden="true"></span><i class="fas fa-file-invoice-dollar"></i> Generar</button>
                            @elseif($datos['referencestype'] == 2)
                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-success" id="pay_generate_2"><span class="spinner-border spinner-border-sm d-none" id="spinner-pay_generate_2" role="status" aria-hidden="true"></span><i class="fas fa-file-invoice-dollar"></i> Generar</button>
                            @endif
                            <!-- <button type="button" class="btn btn-outline-success" id="oxxo" data-channel="2"><span class="spinner-border spinner-border-sm d-none" id="spinner-oxxo" role="status" aria-hidden="true"></span><i class="fas fa-file-invoice-dollar"></i> Oxxo</button> -->
                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-map-marker"></i> Mapa</button>
                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary d-none" id="btn-reference-openpay" data-toggle="modal" data-target="#reference"><i class="fa fa-eye"></i> Referencia OpenPay</button>
                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary d-none" id="btn-reference-oxxo" data-toggle="modal" data-target="#referenceOxxo"><i class="fa fa-eye"></i> Referencia OXXOPay</button>
                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-success d-none" id="referenceWhatsapp"><i class="fa fa-mobile-phone"></i> Whatsapp</button>
                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-success d-none" id="referenceWhatsapp2"><i class="fa fa-mobile-phone"></i> Whatsapp</button>
                        </div>
                        
                    </div>              

                </form>
            </div>
        </section>
        
    </div>
</div>
<!-- Modal de mapa -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Puntos de pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div>
                <iframe class="col-md-12" style="height: 400px;" src="https://www.paynet.com.mx/mapa-tiendas/index.html?locationNotAllowed=true"></iframe>
            </div>
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
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js"></script>
<!-- <script src="clipboard.min.js"></script> -->
<script>
    $('#pay').addClass('d-none');
    var cellphone = $('#cellphone').val();

    function copyToClickBoard(){
        var content = document.getElementById('url_pay').innerHTML;
        var local = '127.0.0.1';


        location.href='https://api.whatsapp.com/send?phone=52'+cellphone+'&text='+content;
            // console.log("Text copied to clipboard...")
 
    }

var dataPay, referenceWhatsapp = '';
// var x = '';

    $('#pay_generate').click(function(){
        let channelID = $(this).attr('id');
        $('#spinner-'+channelID).removeClass('d-none');
        $(this).attr('disabled',true);
        
        let channel = $('#channel').val();
        let number_id = $('#number_id').val();
        let name = $('#name').val();
        let lastname = $('#lastname').val();
        let email = $('#email').val();
        let cel_destiny_reference = $('#cellphone').val();
        let amount = $('#amount').val();
        let offer_id = $('#rate option:selected').attr('data-offer-id');
        let concepto = $('#concepto').val();
        let rate_id = $('#rate').val();
        let user_id = $('#user_id').val();
        let client_id = $('#client_id').val();
        let type = $('#referencestype_id').val();
        let pay_id = $('#pay_id').val();
        let token = $('meta[name="csrf-token"]').attr('content'); 
        let headers = {headers: {'Content-type': 'application/json'}};
        let data = {
                _token:token, number_id: number_id, name: name, lastname: lastname, email: email,
                cel_destiny_reference: cel_destiny_reference, amount: amount, offer_id: offer_id,
                concepto: concepto, type: type, channel: channel, rate_id: rate_id, user_id: user_id,
                client_id: client_id, pay_id: pay_id, quantity: 1
            };
            // console.log(data);
            // return false;
            if(channel == 0){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe elegir un método de pago.',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#spinner-'+channelID).addClass('d-none');
                $(this).attr('disabled',false);
                $('#channel').focus();
                return false;
            }

            $.ajax({
                url: "{{url('/create-reference-openpay')}}",
                method: "POST",
                data: data,
                success: function(response){
                        if(channel == 1){
                            referenceWhatsapp = response.reference;
                            pdfPaynet(response.reference,cel_destiny_reference,name,lastname);
                        }else if(channel == 2){
                            referenceWhatsapp = response.charges.data[0].payment_method.reference;
                            showOxxoPay(response.amount,response.charges.data[0].payment_method.reference);
                        }else {
                            console.log(response);
                            $('#pay').removeClass('d-none');

                            $('#url_pay').html(response.url);
                        }
                        $('#spinner-'+channelID).addClass('d-none');
                        $(this).attr('disabled',false);
                    }
            })
    });

    $('#pay_generate_2').click(function(){
        let channelID = $(this).attr('id');
        $('#spinner-'+channelID).removeClass('d-none');
        $(this).attr('disabled',true);

        let channel = $('#channel').val();
        let name = $('#name').val();
        let lastname = $('#lastname').val();
        let email = $('#email').val();
        let amount = $('#amount').val();
        let pack_id = $('#pack').val();
        let cel_destiny_reference = $('#cellphone').val();
        let concepto = $('#concepto').val();
        let user_id = $('#user_id').val();;
        let client_id = $('#client_id').val();
        let type = $('#referencestype_id').val();
        let pay_id = $('#pay_id').val();
        let token = $('meta[name="csrf-token"]').attr('content'); 
        let headers = {headers: {'Content-type': 'application/json'}};

        let data = {
                _token:token, name: name, lastname: lastname, email: email,
                cel_destiny_reference: cel_destiny_reference, amount: amount, 
                concepto: concepto, type: type, channel: channel, pack_id: pack_id, 
                user_id: user_id, client_id: client_id, pay_id: pay_id, quantity: 1,
                offer_id:0, number_id:0, rate_id:0
            };

            if(channel == 0){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe elegir un método de pago.',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#spinner-'+channelID).addClass('d-none');
                $(this).attr('disabled',false);
                $('#channel').focus();
                return false;
            }

            $.ajax({
                url: "{{url('/create-reference-openpay')}}",
                method: "POST",
                data: data,
                success: function(response){
                    if(channel == 1){
                        referenceWhatsapp = response.reference;
                        pdfPaynet(response.reference,cel_destiny_reference,name,lastname);
                    }else if(channel == 2){
                        referenceWhatsapp = response.charges.data[0].payment_method.reference;
                        showOxxoPay(response.amount,response.charges.data[0].payment_method.reference);
                    }else{
                        console.log(response);
                        $('#pay').removeClass('d-none');

                        $('#url_pay').html(response.url);
                    }
                $('#spinner-'+channelID).addClass('d-none');
                $(this).attr('disabled',false);
                    }
            })
    });

    function pdfPaynet(reference,celphone,name,lastname){
        let link = 'https://dashboard.openpay.mx/paynet-pdf/m3one5bybxspoqsygqhz/'+reference;
        // let link = 'https://sandbox-dashboard.openpay.mx/paynet-pdf/mvtmmoafnxul8oizkhju/'+reference;
        $('#referenceWhatsapp').removeClass('d-none');
        $('#btn-reference-openpay').removeClass('d-none');
        $('#reference-pdf').removeClass('d-none');
        $('#reference-pdf').attr('src', link);
        $('#reference').modal('show');
        // window.open('https://api.whatsapp.com/send?phone=52'+celphone+'&text=Hola, '+name+' '+lastname+', puedes descargar tu referencia de pago de Altcel accediendo a la siguiente dirección: https://sandbox-dashboard.openpay.mx/paynet-pdf/mvtmmoafnxul8oizkhju/'+reference, '_blank');
    }

    function showOxxoPay(amount,reference){
        amount = amount/100;
        $('#referenceWhatsapp2').removeClass('d-none');
        $('#btn-reference-oxxo').removeClass('d-none');
        $('#montoOxxo').html('$'+amount.toFixed(2)+'<sup>MXN</sup>');
        $('#referenceOxxoCard').html(reference);
        $('#referenceOxxo').modal('show');
    }

    $('#referenceWhatsapp').click(function(){
        let name = $('#name').val();
        let lastname = $('#lastname').val();
        let cel_destiny_reference = $('#cellphone').val();
        window.open('https://api.whatsapp.com/send?phone=52'+cel_destiny_reference+'&text=Hola, '+name+' '+lastname+', puedes descargar tu referencia de pago de Altcel accediendo a la siguiente dirección: https://dashboard.openpay.mx/paynet-pdf/m3one5bybxspoqsygqhz/'+referenceWhatsapp, '_blank');
    });

    $('#referenceWhatsapp2').click(function(){
        let name = $('#name').val();
        let lastname = $('#lastname').val();
        let cel_destiny_reference = $('#cellphone').val();
        window.open('https://api.whatsapp.com/send?phone=52'+cel_destiny_reference+'&text=Hola, '+name+' '+lastname+', te compartimos tu referencia de pago de Altcel, tu número de referencia es: '+referenceWhatsapp, '_blank');
    });

    $('#rate').change(function(){
        // let price = $(this,' option:selected').data('price');
        let price = $('#'+this.id+' option:selected').attr('data-price');
        $('#amount').val(parseFloat(price).toFixed(2));
    });
</script>
@endsection