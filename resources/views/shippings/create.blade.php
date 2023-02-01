@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Envío Nuevo</h2>
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
@if(session('error'))
    <div class="alert alert-danger" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="alert-heading">Upps!!</h4>
        <p>{!!session('error')!!}</p>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="alert-heading">Well done!!</h4>
        <p>{!!session('success')!!}</p>
    </div>
@endif
@if($flagMessage == 1)
    <div class="alert alert-warning" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="alert-heading">ATENCION!!</h4>
        <strong>{{$message}}</strong>
    </div>
@endif
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                </div>

                <h2 class="panel-title">Nueva</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="{{route('shipping.store')}}" method="POST" id="formCreate">
                @csrf

                <div class="row form-group col-md-12">

                    <div class="col-md-12">
                        <div class="col-md-5 mb-lg">
                            <label>Clientes</label>
                            <select data-plugin-selectTwo class="form-control populate" id="to_id" name="to_id" onchange="getPhone()">
                                <optgroup label="Clientes disponibles">
                                    <option value="0">Elige...</option>
                                    @foreach($clients as $client)
                                    <option value="{{$client->id}}" data-phone="{{$client->cellphone}}">
                                        {{$client->name.' '.$client->lastname.' - '.$client->email.' - '.$client->cellphone}}
                                    </option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-2 mb-md">
                            <label for="cp">Código Postal</label>
                            <input class="form-control" type="text" id="cp" name="cp" required>
                        </div>

                        <div class="col-md-2 mb-md">
                            <label for="colonia">Colonia</label>
                            <input class="form-control" type="text" id="colonia" name="colonia" required>
                        </div>

                        <div class="col-md-2 mb-md">
                            <label for="tipo_asentamiento">Tipo Asentamiento</label>
                            <input class="form-control" type="text" id="tipo_asentamiento" name="tipo_asentamiento" required>
                        </div>

                        <div class="col-md-2 mb-md">
                            <label for="municipio">Municipio</label>
                            <input class="form-control" type="text" id="municipio" name="municipio" required>
                        </div>

                        <div class="col-md-2 mb-md">
                            <label for="estado">Estado</label>
                            <input class="form-control" type="text" id="estado" name="estado" required>
                        </div>

                        <div class="col-md-2 mb-md">
                            <label for="ciudad">Ciudad</label>
                            <input class="form-control" type="text" id="ciudad" name="ciudad" required>
                        </div>

                        <div class="col-md-1 mb-md">
                            <label for="no_exterior">No. Exterior</label>
                            <input class="form-control" type="text" id="no_exterior" name="no_exterior" required>
                        </div>

                        <div class="col-md-1 mb-md">
                            <label for="no_interior">No. Interior</label>
                            <input class="form-control" type="text" id="no_interior" name="no_interior" >
                        </div>

                        <div class="col-md-2 mb-md">
                            <label for="phone_contact">Teléfono de Contacto</label>
                            <input class="form-control" type="text" id="phone_contact" name="phone_contact" required>
                        </div>

                        <div class="col-md-4 mb-md">
                            <label for="referencias">Referencias (opcional)</label>
                            <textarea class="form-control" type="text" id="referencias" name="referencias" ></textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-3 mb-md">
                            <label for="recibe">Quien Recibe</label>
                            <input class="form-control" type="text" id="recibe" name="recibe" >
                        </div>

                        <div class="col-md-2 mb-md">
                            <label for="phone_alternative">Teléfono Alternativo</label>
                            <input class="form-control" type="text" id="phone_alternative" name="phone_alternative" >
                        </div>

                        <div class="col-md-3 mb-md">
                            <label for="canal">Canal</label>
                            <select class="form-control" name="canal" id="canal">
                                <option value="Facebook">Facebook</option>
                                <option value="Cambaceo">Cambaceo</option>
                                <option value="Cambaceo">Whatsapp</option>
                                <option value="Cambaceo">Llamada</option>
                                <option value="Página Web">Página Web</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-lg">
                            <label>Empleado que vendió</label>
                            <select data-plugin-selectTwo class="form-control populate" id="sold_by" name="sold_by" >
                                <optgroup label="Clientes disponibles">
                                <option value="0">Elige...</option>
                                @foreach($employes as $employe)
                                    @if($employe->id == Auth::user()->id)
                                    <option selected value="{{$employe->id}}">
                                        {{$employe->name.' '.$employe->lastname.' - '.$employe->email}}
                                    </option>
                                    @else
                                    <option value="{{$employe->id}}">
                                        {{$employe->name.' '.$employe->lastname.' - '.$employe->email}}
                                    </option>
                                    @endif
                                @endforeach
                                </optgroup>
                            </select>
                        </div>

                        <div class="col-md-2 mb-md">
                            <label for="zona">Zona</label>
                            <select class="form-control" name="zona" id="zona">
                                <option value="Local">Local</option>
                                <option value="Fuera">Fuera</option>
                                <option value="En Tienda">Recoge En Tienda</option>
                            </select>
                        </div>

                        <div class="col-md-2 mb-md">
                            <label for="zona">Generar link de pago</label>
                            <select class="form-control" name="flag_link" id="flag_link">
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>

                        <div class="col-md-2 mt-xs mb-md">
                            <label for="product">Producto</label>
                            <select id="product" name="product" class="form-control form-control-sm" required="">
                                <option selected value="Ninguno">Ninguno...</option>
                                <option value="HBB">HBB</option>
                                <option value="MIFI">MIFI</option>
                                <option value="MOV">MOV</option>
                            </select>
                        </div>

                        <div class="col-md-2 mt-xs mb-md">
                            <div class="checkbox">
                                <label for="diferido" class="control-label">
                                <input type="checkbox" id="diferido">Diferido
                                </label>
                                
                            </div>
                        </div>

                        <div class="col-md-4 mt-xs mb-md">
                            <label for="rates">Plan Activación</label>
                            <select id="rates" name="rate_id" class="form-control form-control-sm" required="">
                                <option value="0" selected>Elige uno...</option>
                            </select>
                        </div>

                        <input type="hidden" name="rate_price" id="rate_price" value="0">
                        <input type="hidden" name="device_price" id="device_price" value="899">

                        <div class="col-md-4 mb-md">
                            <label for="comments">Comentarios (opcional)</label>
                            <textarea class="form-control" type="text" id="comments" name="comments" ></textarea>
                        </div>

                        <div class="col-md-4 mb-md mt-xl">
                            <button type="button" class="btn btn-success btn-sm" id="changeShippingPrice">Cambiar precio de envío</button>
                        </div>
                    </div>

                </div>
                <input type="hidden" name="created_by" value="{{Auth::user()->id}}">
                <div class="col-md-6 row">
                    <div class="col-md-3">
                        <div class="h4 text-bold mb-none mt-lg" id="rateTag">$0.00</div>
                        <p class="text-sm text-muted mb-none">Plan</p>
                    </div>
                    <div class="col-md-3">
                        <div class="h4 text-bold mb-none mt-lg" id="deviceTag">$899.00</div>
                        <p class="text-sm text-muted mb-none">Dispositivo/SIM</p>
                    </div>
                    <div class="col-md-3">
                        <div class="h4 text-bold mb-none mt-lg" id="shippingTag">$50.00</div>
                        <p class="text-sm text-muted mb-none">Envío</p>
                    </div>
                    <div class="col-md-3">
                        <div class="h4 text-bold text-success mb-none mt-lg" id="totalTag">$0.00</div>
                        <p class="text-sm text-success mb-none">Total</p>
                    </div>
                </div>

                <input type="hidden" id="rateTagValue" value="0">
                <input type="hidden" id="deviceTagValue" value="854">
                <input type="hidden" id="shippingTagValue" name="shippingTagValue" value="50">
                <input type="hidden" id="totalTagValue" value="0">

                <div class="col-md-12" style="margin-top: 1rem;">
                    <button type="button" class="btn btn-success" id="save">Guardar</button>
                    <button type="button" class="mb-xs mt-xs mr-xs btn btn-default" data-toggle="modal" data-target="#modalAddresses">Direcciones</button>
                </div>
                </form>
            </div>
        </section>
    </div>
</div>

<div class="modal fade" id="modalChangePriceShipping" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-block modal-block-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Cambio de precio del envío</h4>
            </div>
            <div class="modal-body col-md-12">
                <div class="col-md-12 d-flex justify-content-center" >

                    <div class="col-md-2 mb-md">
                        <label for="newPriceShipping">Precios disponibles</label>
                        <select class="form-control" id="newPriceShipping">
                            <option value="0">$0</option>
                            <option value="10">$10</option>
                            <option value="20">$20</option>
                            <option value="30">$30</option>
                            <option value="40">$40</option>
                            <option value="50">$50</option>
                            <option value="60">$60</option>
                            <option value="70">$70</option>
                            <option value="80" selected>$80</option>
                            <option value="90">$90</option>
                            <option value="100">$100</option>
                            <option value="120">$120</option>
                            <option value="130">$130</option>
                            <option value="140">$140</option>
                            <option value="150">$150</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="applyNewPrice">Aplicar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddresses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-block modal-block-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Direcciones Encontradas</h4>
            </div>
            <div class="modal-body col-md-12">
                <div class="col-md-12 d-flex justify-content-center" id="contentAddresses">
                    <h4>NO HAS BUSCADO NADA...</h4>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function(){
    // alert('Hola, podrás notar que hay nuevos campos para realizar el envío, esto es para realizar las pruebas correspondientes para que desde aquí puedas generar los links de pago, llena todos los campos.');
    sumatory();
});

function getPhone(){
    let client_id = $('#to_id').val();
    let phone = '';

    if(client_id == 0){

    }else{
        phone = $('#to_id option:selected').attr('data-phone');
        $('#phone_contact').val(phone);
    }
}

$('#cp').keyup(function(){
    let value = $(this).val();
    let options = '';

    if(value.length == 5){
        $.ajax({
            url: "{{route('consultCP')}}",
            data: {cp:value},
            beforeSend: function(){

            },
            success: function(response){
                response = JSON.parse(response);
                response.forEach(function(e){
                    if(e.error == false){
                        options+='<div class="alert alert-info col-md-3 ml-md mr-md mt-md mb-md"><center><h5><strong>CP: '+e.response.cp+'</strong></h5></center>'+
                                    'Asentamiento: <strong>'+e.response.asentamiento+'</strong><br>'+
                                    'Tipo de Asentamiento: <strong>'+e.response.tipo_asentamiento+'</strong><br>'+
                                    'Municipio: <strong>'+e.response.municipio+'</strong><br>'+
                                    'Estado: <strong>'+e.response.estado+'</strong><br>'+
                                    'Ciudad: <strong>'+e.response.ciudad+'</strong><br>'+
                                    '<button type="button" class="btn btn-success mt-md choosed-cp" '+
                                    'data-colonia="'+e.response.asentamiento+'" '+
                                    'data-tipo-asentamiento="'+e.response.tipo_asentamiento+'" '+
                                    'data-municipio="'+e.response.municipio+'" '+
                                    'data-estado="'+e.response.estado+'" '+
                                    'data-ciudad="'+e.response.ciudad+'" '+
                                    'onclick="getDataAddress(this)">Elegir</button>'+
                                '</div>'
                    }
                });
                $('#contentAddresses').html(options);
                $('#modalAddresses').modal('show');
            }
        })
    }
});

$('#save').on('click', function (event) {
    event.preventDefault();
    Swal.fire({
        title: 'ATENCIÓN',
        html: "¿Está seguro de guardar el envío ?",
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
            $('#formCreate').submit();
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            Swal.fire({
                icon: 'error',
                title: 'Operación cancelada',
                showConfirmButton: false,
                timer: 1000
            })
        }
    })
});


function getDataAddress(e){
    let asentamiento = $(e).attr('data-colonia');
    let tipo = $(e).attr('data-tipo-asentamiento');
    let municipio = $(e).attr('data-municipio');
    let estado = $(e).attr('data-estado');
    let ciudad = $(e).attr('data-ciudad');

    $('#colonia').val(asentamiento);
    $('#tipo_asentamiento').val(tipo);
    $('#municipio').val(municipio);
    $('#estado').val(estado);
    $('#ciudad').val(ciudad);
    $('#modalAddresses').modal('hide');
}

$('#product').change(function(){
    let producto = $(this).val();
    let options = '<option value="0">Elige uno...</option>';
    let diferido_glag = 0;

    if($('#diferido').is(':checked')){
        diferido_flag = 1;
    }else{
        diferido_flag = 0;
    }

    if(producto == 'MOV'){
        $('#deviceTagValue').val(0);
        $('#device_price').val(0);
    }else if(producto == 'MIFI'){
        if($('#diferido').is(':checked')){
            $('#deviceTagValue').val(0);
            $('#device_price').val(0);
        }else{
            $('#deviceTagValue').val(854);
            $('#device_price').val(854);
        }
    }else if(producto == 'HBB'){
        $('#deviceTagValue').val(1200);
        $('#device_price').val(1200);
    }

    sumatory();

    $.ajax({
        url: "{{route('petition.rates')}}",
        data:{producto: producto},
        success: function(response){

            response.forEach(function(element){
                if(diferido_flag == 0){
                    if(element.plazo == 0){
                        options+="<option value='"+element.id+"' data-price='"+parseFloat(element.price).toFixed(2)+"'>"+element.name+" - $"+parseFloat(element.price).toFixed(2)+"</option>"
                    }
                }else{
                    if(element.plazo > 0){
                        options+="<option value='"+element.id+"' data-price='"+parseFloat(element.price).toFixed(2)+"'>"+element.name+" - $"+parseFloat(element.price).toFixed(2)+"</option>"
                    }
                }
            });

            $('#rates').html(options);
        }
    });
});

$('#diferido').click(function(){
    let diferido_glag = 0;
    let producto = $('#product').val();
    let options = '<option value="0">Elige uno...</option>';

    if($('#diferido').is(':checked')){
        diferido_flag = 1;
        $('#device_price').val(0);
        $('#deviceTagValue').val(0)
    }else{
        diferido_flag = 0;
        $('#device_price').val(854);
        $('#deviceTagValue').val(854)
    }

    if(producto == 'MOV'){
        $('#deviceTagValue').val(0);
        $('#device_price').val(0);
    }else if(producto == 'MIFI'){
        if($('#diferido').is(':checked')){
            $('#deviceTagValue').val(0);
            $('#device_price').val(0);
        }else{
            $('#deviceTagValue').val(0);
            $('#device_price').val(0);
        }
    }else if(producto == 'HBB'){

        if($('#diferido').is(':checked')){
            $('#deviceTagValue').val(0);
            $('#device_price').val(0);
        }else{
            $('#deviceTagValue').val(1200);
            $('#device_price').val(1200);
        }
    }

    sumatory();

    $.ajax({
        url: "{{route('petition.rates')}}",
        data:{producto: producto},
        success: function(response){

            response.forEach(function(element){
                if(diferido_flag == 0){
                    if(element.plazo == 0){
                        options+="<option value='"+element.id+"' data-price='"+parseFloat(element.price).toFixed(2)+"'>"+element.name+" - $"+parseFloat(element.price).toFixed(2)+"</option>"
                    }
                }else{
                    if(element.plazo > 0){
                        options+="<option value='"+element.id+"' data-price='"+parseFloat(element.price).toFixed(2)+"'>"+element.name+" - $"+parseFloat(element.price).toFixed(2)+"</option>"
                    }
                }
            });

            $('#rates').html(options);
        }
    });
});

$('#changeShippingPrice').click(function(){
    $('#modalChangePriceShipping').modal('show');
});

$('#rates').change(function(){
    let valor = $(this).val();
    let price = $('#rates option:selected').data('price');
    if(valor == 0){
        price = 0;
    }
    console.log(price);
    $('#rate_price').val(price);
    $('#rateTagValue').val(price);
    sumatory();
});

$('#zona').change(function(){
    if($(this).val() == 'Local'){
        $('#shippingTagValue').val(50);
    }else if($(this).val() == 'Fuera'){
        $('#shippingTagValue').val(150);
    }else if($(this).val() == 'En Tienda'){
        $('#shippingTagValue').val(0);
    }

    sumatory();
});

$('#applyNewPrice').click(function(){
    let newPrice = $('#newPriceShipping').val();
    $('#shippingTag').html(parseFloat(newPrice).toFixed(2));
    $('#shippingTagValue').val(newPrice);
    sumatory();
    $('#modalChangePriceShipping').modal('hide');
});

function sumatory(){
    let rate = $('#rateTagValue').val();
    let device = $('#deviceTagValue').val();
    let shipping = $('#shippingTagValue').val();
    let total = 0;

    total = parseFloat(rate)+parseFloat(device)+parseFloat(shipping);
    $('#rateTag').html('$'+parseFloat(rate).toFixed(2));
    $('#deviceTag').html('$'+parseFloat(device).toFixed(2));
    $('#shippingTag').html('$'+parseFloat(shipping).toFixed(2));
    $('#totalTagValue').val(parseFloat(total).toFixed(2));

    $('#totalTag').html('$'+parseFloat(total));
}

</script>
@endsection