@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Detalles de Preactivación</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li>
                <a href="{{route('solicitudes')}}">Volver</a>
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
                        <h3 class="h3 mt-none mb-sm text-dark text-bold">{{$client->name.' '.$client->lastname}}</h3>
                        <h4 class="h4 m-none text-dark text-bold">Plan: {{$rate->name}}</h4>
                    </div>
                    <div class="col-sm-6 text-right mt-md mb-md">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalBootstrap"><i class="fa fa-edit"></i> Cambiar Plan</button>
                    </div>
                </div>
            </header>
            <div class="bill-info">
                <div class="row">
                    <div class="col-md-6">
                        <div class="bill-to">
                            <p class="h5 mb-xs text-dark text-semibold">Datos del Cliente:</p>
                            <address class="text-dark">
                                <b>Dirección: </b>{{$dataClient->address}}
                                <br/>
                                <b>Email: </b>{{$client->email}}
                                <br>
                                <b>Tel: </b>{{$dataClient->cellphone}}
                                <br>
                                <b>RFC: </b>{{$dataClient->rfc}}
                                <br>
                                <b>No. Identificación (Cédula, Código INE, etc.): </b>{{$dataClient->ine_code}}
                            </address>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bill-data text-right">
                            <p class="mb-none">
                                <span class="text-dark text-semibold">Fecha de Operación:</span>
                                <span class="text-dark">{{$petition->date_to_activate}}</span>
                            </p>
                            <p class="mb-none">
                                <span class="text-dark text-semibold">Solicitado por:</span>
                                <span class="text-dark">{{$sender->name.' '.$sender->lastname}}</span>
                                <span class="text-dark">{{$sender->email}}</span>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="bill-to">
                            <p class="h5 mb-xs text-dark text-semibold">SIM:</p>
                            <address class="text-dark">
                                <b>MSISDN: </b>{{$number->MSISDN}}
                                <br/>
                                <b>ICC: </b>{{$number->icc_id}}
                                <br/>
                                <b>Producto: </b>{{$number->producto}}
                            </address>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bill-to">
                            <p class="h5 mb-xs text-dark text-semibold">Dispositivo:</p>
                            <address class="text-dark">
                                <b>IMEI: </b>{{$device->no_serie_imei}}
                                <br/>
                                <b>Material: </b>{{$device->material}}
                                <br/>
                                <b>Descripción: </b>{{$device->description}}
                                <br>
                                <b>Precio: </b><span class="label label-success" style="font-size: 11px;">${{number_format($device->price,2)}}</span>
                                <br>
                                <b>No. Serie: </b>{{$petition->serial_number}}
                                <br>
                                <b>MAC: </b>{{$petition->mac_address}}
                            </address>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="bill-to">
                            <p class="h5 mb-xs text-dark text-semibold">Plan:</p>
                            <address class="text-dark">
                                {{$rate->name}}
                                <br/>
                                <b>Precio Inicial: </b><span class="label label-success" style="font-size: 11px;">${{number_format($rate->price,2)}}</span>
                                <br>
                                <b>Mensualidad: </b><span class="label label-success" style="font-size: 11px;">${{number_format($rate->price_subsequent,2)}}</span>
                            </address>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bill-to">
                            <p class="h5 mb-xs text-dark text-semibold">Oferta:</p>
                            <address class="text-dark">
                                {{$offer->name}}
                                <br/>
                                <b>OfferID: </b>{{$offer->offerID}}
                                <br/>
                                <b>Producto: </b>{{$offer->product}}
                                <br>
                                <b>Precio de Venta: </b><span class="label label-success" style="font-size: 11px;">${{number_format($offer->price_sale,2)}}</span>
                            </address>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="text-right mr-lg">
            <button type="button" class="btn btn-danger" id="rollback"><i class="fa fa-times-circle"></i> Cancelar</button>
            <button type="button" class="btn btn-success ml-sm" id="activate"><i class="fa fa-check-circle"></i> Activar</button>
        </div>
    </div>
</section>

<div class="modal fade" id="modalBootstrap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-bold text-dark" id="myModalLabel">Cambio de Plan</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-bordered" >
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <h4 class="text-bold text-dark">Plan actual: {{$rate->name}}</h4>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label for="rate">Planes Disponibles</label>
                                <select id="rate" name="rate" class="form-control form-control-sm" required>
                                    <option selected value="0">Choose...</option>
                                @foreach($rates as $rate)
                                <option value="{{$rate->id}}" data-offer-id="{{$rate->alta_offer_id}}">{{$rate->name}}</option>
                                @endforeach
                                </select>
                            </div>

                            <input type="hidden" id="petition_id" value="{{$petition->id}}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="confirmChangeRate">Confirmar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#confirmChangeRate').click(function(){
        let rate = $('#rate').val();
        let petition_id = $('#petition_id').val();
        let token = $('meta[name="csrf-token"]').attr('content');
       
        if(rate == 0){
            Swal.fire({
                icon: 'error',
                title: 'Debes elegir un plan.',
                showConfirmButton: false,
                timer: 1500
            })
           return false;
        }else{
            Swal.fire({
                title: '¿Está seguro de realizar este cambio?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#47a447',
                cancelButtonColor: '#d33',
                confirmButtonText: 'SÍ, ESTOY SEGURO.'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('changeRatePetition')}}",
                        method: "POST",
                        data: {_token:token, rate_id:rate, petition_id:petition_id},
                        success: function(response){
                            console.log(response);
                            if(response == 1){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Cambio hecho con éxito.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                location.reload();
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ha ocurrido un error, consulte a soporte.',
                                    showConfirmButton: false,
                                    timer: 1500
                                }) 
                            }
                        }
                    });
                }
            })
        }
    });

    $('#activate').click(function(){
        let petition_id = $('#petition_id').val();
        let token = $('meta[name="csrf-token"]').attr('content');
        let url = "{{route('executeActivation',['petition'=>'temp'])}}";
        url = url.replace('temp',petition_id);

        Swal.fire({
            title: '¿Está seguro de ejecutar la activación?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#47a447',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SÍ, ESTOY SEGURO.'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: "POST",
                    data: {_token:token},
                    success: function(response){
                        console.log(response);
                        if(response.http_code == 1){
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function(){ location.href = "{{route('solicitudes')}}"; }, 1600);
                        }else if(response.http_code == 2){
                            Swal.fire({
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }) 
                        }else if(response.http_code == 0){
                            Swal.fire({
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            }
        });
    });
</script>
@endsection