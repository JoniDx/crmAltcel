@extends('layouts.app')

@section('content')
<div class="container">
                @if(session('message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Upps!</h4>
                        <p>{{session('message')}}</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Recarga</div>
                
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="my-product">Tus productos</label>
                            <select id="my-product" class="form-control form-control-sm">
                                <option selected value="0">Choose...</option>
                            @foreach($clientDatas as $clientData)
                            <option value="{{$clientData->number_id}}" data-DN="{{$clientData->MSISDN}}" data-producto="{{$clientData->producto}}">{{$clientData->MSISDN.' - '.$clientData->producto}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Nombre: </label>
                            <input type="text" class="form-control form-control-sm" id="name" placeholder="Nombre" value="{{Auth::user()->name}}">
                        </div>
                        <input type="hidden" class="form-control form-control-sm" id="user_id" value="{{Auth::user()->id}}">

                        <div class="form-group col-md-6">
                            <label for="lastname">Apellidos: </label>
                            <input type="text" class="form-control form-control-sm" id="lastname" placeholder="Apellidos">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Email: </label>
                            <input type="email" class="form-control form-control-sm" id="email" value="{{Auth::user()->email}}" placeholder="Email" >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Celular: </label>
                            <input type="email" class="form-control form-control-sm" id="celphone" placeholder="Celular">
                        </div>
                        <div class="form-group col-md-6" id="content-rate">
                            <label for="exampleFormControlSelect1">Ofertas: </label>
                            <select class="form-control form-control-sm" id="rate" >
                                <option selected value="0">Nothing</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Monto: </label>
                            <input type="text" class="form-control form-control-sm" id="amount" placeholder="Monto" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Concepto: </label>
                            <input type="email" class="form-control form-control-sm" id="concepto" placeholder="Concepto" value="Recarga telefónica.">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="my-product">Métodos de Pago</label>
                            <select id="channel" class="form-control form-control-sm">
                                <option selected value="0">Choose...</option>
                            @foreach($channels as $channel)
                            <option value="{{$channel->id}}">{{$channel->name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <input type="hidden" class="form-control form-control-sm" id="client_id" value="{{Auth::user()->id}}">
                        
                    </div>
                    <button type="button" class="btn btn-outline-success" id="pay_generate"><span class="spinner-border spinner-border-sm d-none" id="spinner-pay_generate" role="status" aria-hidden="true"></span><i class="fas fa-file-invoice-dollar"></i> Generar</button>
                    <!-- <button type="button" class="btn btn-outline-success" id="oxxo" data-channel="2"><span class="spinner-border spinner-border-sm d-none" id="spinner-oxxo" role="status" aria-hidden="true"></span><i class="fas fa-file-invoice-dollar"></i> Oxxo</button> -->
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-map-marker-alt"></i> Mapa</button>
                    <!-- <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#reference"><i class="fas fa-eye"></i> Referencia OpenPay</button>
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#referenceOxxo"><i class="fas fa-eye"></i> Referencia OXXOPay</button> -->
                </div>
            </div>
        </div>
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
                        <div class="opps-reminder">Ficha digital. No es necesario imprimir.</div>
                            <div class="opps-info">
                                <div class="opps-brand"><img src="{{asset('storage/uploads/oxxopay_brand.png')}}" alt="OXXOPay"></div>
                                <div class="opps-ammount">
                                    <h3>Monto a pagar</h3>
                                    <!-- <h2>$ 0,000.00 <sup>MXN</sup></h2> -->
                                    <h2 id="montoOxxo"></h2>
                                    <p>OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
                                </div>
                            </div>
                            <div class="opps-reference">
                                <h3>Referencia</h3>
                                <h1 id="referenceOxxoCard"></h1>
                            </div>
                        </div>
                        <div class="opps-instructions">
                            <h3>Instrucciones</h3>
                            <ol>
                                <li style="margin-top: 10px;color: #000000;">Acude a la tienda OXXO más cercana. <a href="https://www.google.com.mx/maps/search/oxxo/" target="_blank">Encuéntrala aquí</a>.</li>
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
<script>
var dataPay;
    $('#my-product').change(function(){
        let msisdn_id = $(this).val();
        let msisdn = $('option:selected', $(this)).attr('data-DN');
        let producto = $('option:selected', $(this)).attr('data-producto');
        let token = $('meta[name="csrf-token"]').attr('content');
        let options = '<option selected value="0">Nothing</option>';
        let client_id = $('#client_id').val();
        
        if(msisdn != 0){
            $('#celphone').val(msisdn);
            $.ajax({
                url:"{{route('get-rates.post')}}",
                method: "POST",
                data: {
                    _token:token,
                    product: producto,
                    client_id: client_id,
                    msisdn_id: msisdn_id
                },
                success: function(data){
                    console.log(data);
                    data.forEach(function(element){
                    options+="<option value='"+element.offerAltanID+"' data-price='"+element.price+"' data-rate='"+element.id+"' data-offer-ref='"+element.offer_id+"'>"+element.name+"</option>";
                    console.log(element);
                });
                    $('#rate').html(options);
                }
            }); 
        }else{
            $('#rate').html(options);
        }
    });

    $('#rate').change(function(){
        let price = $('option:selected', $(this)).attr('data-price');
        $('#amount').val(price);
    });

    $('#pay_generate').click(function(){
        let channelID = $(this).attr('id');
        $('#spinner-'+channelID).removeClass('d-none');
        $(this).attr('disabled',true);
        
        let channel = $('#channel').val();
        let myproduct = $('#my-product').val();
        let name = $('#name').val();
        let lastname = $('#lastname').val();
        let email = $('#email').val();
        let cel_destiny_reference = $('#celphone').val();
        let amount = $('#amount').val();
        let offerID = $('#rate').val();
        let concepto = $('#concepto').val();
        let offer_id_ref = $('option:selected', $('#rate')).attr('data-offer-ref');
        let rate_id = $('option:selected', $('#rate')).attr('data-rate');
        let user_id = $('#user_id').val();
        let type = 1;
        let token = $('meta[name="csrf-token"]').attr('content'); 
        let headers = {headers: {'Content-type': 'application/json'}};
        let data = {
                _token:token,
                myproduct: myproduct,
                name: name,
                lastname: lastname,
                email: email,
                cel_destiny_reference: cel_destiny_reference,
                amount: amount,
                offer_id: offerID,
                concepto: concepto,
                type: type,
                offer_id_ref: offer_id_ref,
                channel: channel,
                rate_id: rate_id,
                user_id: user_id,
                quantity: 1
            };

        axios.post('/create-reference-openpay', data, headers).then(response => {
            
            dataPay = response;
            if(channel == 1){
                pdfPaynet(response.data.reference,cel_destiny_reference,name,lastname);
            }else if(channel == 2){
                showOxxoPay(response.data.amount,response.data.charges.data[0].payment_method.reference,);
            }
            $('#spinner-'+channelID).addClass('d-none');
            $(this).attr('disabled',false);
        }).catch(e => {
            $('#spinner-'+channelID).addClass('d-none');
            $(this).attr('disabled',false);
            console.log(e);
        })
    });

    function pdfPaynet(reference,celphone,name,lastname){
        let link = 'https://sandbox-dashboard.openpay.mx/paynet-pdf/mvtmmoafnxul8oizkhju/'+reference;
        $('#reference-pdf').removeClass('d-none');
        $('#reference-pdf').attr('src', link);
        $('#reference').modal('show');
        window.open('https://api.whatsapp.com/send?phone=52'+celphone+'&text=Hola, '+name+' '+lastname+', puedes descargar tu referencia de pago de Altcel accediendo a la siguiente dirección: https://sandbox-dashboard.openpay.mx/paynet-pdf/mvtmmoafnxul8oizkhju/'+reference, '_blank');
    }

    function showOxxoPay(amount,reference){
        amount = amount/100;
        $('#montoOxxo').html('$'+amount.toFixed(2)+'<sup>MXN</sup>');
        $('#referenceOxxoCard').html(reference);
        $('#referenceOxxo').modal('show');
    }
</script>
@endsection