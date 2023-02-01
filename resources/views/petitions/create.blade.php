@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Solicitud</h2>
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
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Alta de Solicitud</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="{{route('petition.store')}}" method="POST" enctype="multipart/form-data" id="formPetition">
                @csrf
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                               
                                <div class="col-md-12">
                                    <h3>Cliente</h3>
                                    
                                </div>

                                <div class="col-md-12 mb-lg" id="msisdn-select">
                                    <label>Clientes</label>
                                    <select data-plugin-selectTwo class="form-control populate" id="client" onchange="getData()">
                                        <optgroup label="Clientes disponibles">
                                        <option value="0">Elige...</option>
                                        @foreach($clients as $client)
                                    <option value="{{$client->id}}"
                                        data-name="{{$client->name}}"
                                        data-lastname="{{$client->lastname}}"
                                        data-address="{{$client->address}}"
                                        data-email="{{$client->email}}"
                                        data-rfc="{{$client->rfc}}"
                                        data-ine_code="{{$client->ine_code}}"
                                        data-cellphone="{{$client->cellphone}}"
                                        data-date_born="{{$client->date_born}}"
                                    >
                                        {{$client->name.' '.$client->lastname}}
                                    </option>
                                    @endforeach
                                        </optgroup>
                                        
                                    </select>
                                </div>

                                <input type="hidden" name="client_id" id="client_id" value="0">

                                <div class="form-group col-md-6">
                                    <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                                    <div class="col-md-12">
                                        <section class="form-group-vertical">
                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-user"></i></span>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Nombre" id="name" name="name" required>
                                            </div>

                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-user"></i></span>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Apellido" id="lastname" name="lastname" required>
                                            </div>

                                            <div class="input-group finput-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-user"></i></span>
                                                </span>
                                                <input autocomplete="off" class="form-control" type="text" placeholder="RFC" id="rfc" name="rfc">
                                            </div>

                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-calendar"></i></span>
                                                </span>
                                                <input class="form-control" type="date" id="date_born" name="date_born">
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                                    <div class="col-md-12">
                                        <section class="form-group-vertical">
                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-home"></i></span>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Dirección" id="address" name="address" required>
                                            </div>

                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-envelope"></i></span>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Email" id="email" name="email">
                                            </div>

                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-user"></i></span>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Código INE, Cédula o Pasaporte" id="ine_code" name="ine_code">
                                            </div>

                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-phone"></i></span>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Teléfono Contacto" id="cellphone" name="cellphone" maxlength="10" required>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-xs mb-md">
                                    <div class="checkbox">
                                        <label class="control-label">
                                            <input type="checkbox" id="diffLADA">
                                            LADA Diferente
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-icon d-none" id="containerLADA">
                                            <span class="input-group-addon">
                                                <span class="icon"><i class="fa fa-phone"></i></span>
                                            </span>
                                            <input class="form-control" type="text" placeholder="961" id="lada" name="lada" maxlength="3" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mt-xs mb-md">
                                    <label for="product">Producto</label>
                                    <select id="product" name="product" class="form-control form-control-sm" required="">
                                        <option selected value="Ninguno">Ninguno...</option>
                                        <option value="HBB">HBB</option>
                                        <option value="MIFI">MIFI</option>
                                        <option value="MOV">MOV</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mt-xs mb-md">
                                    <label for="rates">Plan Activación</label>
                                    <select id="rates" name="rate_activation" class="form-control form-control-sm" required="">
                                        <option value="0" selected>Elige uno...</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mt-xs mb-md">
                                    <label for="ratesSecond">Plan Subsecuente</label>
                                    <select id="ratesSecond" name="rate_secondary" class="form-control form-control-sm" required="">
                                        <option selected value="Ninguno">Elige uno...</option>
                                        @foreach($rates as $rate)
                                        <option value="{{$rate->id}}">{{$rate->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mt-xs mb-md">
                                    <label for="payment_way">Forma de Pago</label>
                                    <select id="payment_way" name="payment_way" class="form-control form-control-sm" required="">
                                        <option selected value="0">Elige uno...</option>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Transferencia">Transferencia</option>
                                        <option value="Desc. Vía Nómina">Desc. Vía Nómina</option>
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

                                <div class="col-md-4 mt-xs mb-md">
                                    <label for="product">ICC</label>
                                    <input class="form-control" type="text" id="icc" name="icc">
                                </div>

                                <div class="col-md-4 mt-xs mb-md">
                                    <label for="product">IMEI</label>
                                    <input class="form-control" type="text" id="imei" name="imei">
                                </div>

                                <div class="col-md-4 mt-xs mb-md">
                                    <label for="product">No. Serie</label>
                                    <input class="form-control" type="text" id="noSerie" name="noSerie">
                                </div>

                                <div class="col-md-4 mt-xs mb-md">
                                    <label for="product">Dirección MAC</label>
                                    <input class="form-control" type="text" id="direccionMac" name="direccionMac">
                                </div>


                                <div class="col-md-4 mt-xs mb-md d-none" id="contentPlazo">
                                    <label for="plazo">Plazo (quincenal)</label>
                                    <input type="number" id="plazo" name="plazo" class="form-control form-control-sm" min="0" value="0">
                                </div>

                                <div class="col-md-12 mt-xs mb-md">
                                    <div class="col-md-4">
                                        <label for="comment">Comentario (opcional):</label>
                                        <textarea class="form-control" name="comment" id="comment" cols="30" rows="3" placeholder="Escribe algo"></textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="user" id="user" value="{{ Auth::user()->id }}" required>

                                <div class="col-md-12" style="margin-top: 1rem;">
                                    <button type="button" class="btn btn-primary" id="send">Guardar</button>
                                    <!-- <button type="button" class="btn btn-success" id="date-pay">Date Pay</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<script>
    

    function getData(){
        let client_id = $('#client').val();
        let name;
        let lastname;
        let address;
        let email;
        let rfc;
        let ine_code;
        let cellphone;
        let date_born;
        if(client_id == 0){
            $('#client_id').val(0);
            $('#name').val('');
            $('#lastname').val('');
            $('#rfc').val('');
            $('#date_born').val('');

            $('#address').val('');
            $('#email').val('');
            $('#ine_code').val('');
            $('#cellphone').val('');
        }
        else{
            name = $('#client option:selected').attr('data-name');
            lastname = $('#client option:selected').attr('data-lastname');
            address = $('#client option:selected').attr('data-address');
            email = $('#client option:selected').attr('data-email');
            rfc = $('#client option:selected').attr('data-rfc');
            ine_code = $('#client option:selected').attr('data-ine_code');
            cellphone = $('#client option:selected').attr('data-cellphone');
            date_born = $('#client option:selected').attr('data-date_born');

            $('#client_id').val(client_id);
            $('#name').val(name);
            $('#lastname').val(lastname);
            $('#rfc').val(rfc);
            $('#date_born').val(date_born);

            $('#address').val(address);
            $('#email').val(email);
            $('#ine_code').val(ine_code);
            $('#cellphone').val(cellphone);
        }
    }

    $('#payment_way').change(function(){
        let value = $(this).val();
         if(value == 'Desc. Vía Nómina'){
             $('#contentPlazo').removeClass('d-none');
         }else{
            $('#contentPlazo').addClass('d-none');
         }

         $('#plazo').val(0);
    });

    $('#cellphone').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#rfc').keyup(function(){
        let rfc = $(this).val();
        let anio = rfc.substring(4,6);
        let mes = rfc.substring(6,8);
        let dia = rfc.substring(8,10);
        let date = '';
        let id = $(this).attr('id');
        $(this).val($(this).val().toUpperCase());
        if(rfc.length == 10){
            anio = new Date(anio);
            anio = anio.getFullYear();
            date = anio+'-'+mes+'-'+dia;
            $('#date_born').val(date);
        }
    });

    $('#send').click(function(){
        let client_id = $('#client_id').val();
        let name = $('#name').val();
        let lastname = $('#lastname').val();
        let rfc = $('#rfc').val();
        let date_born = $('#date_born').val();
        let address = $('#address').val();
        let email = $('#email').val();
        let ine_code = $('#ine_code').val();
        let cellphone = $('#cellphone').val();
        let product = $('#product').val();
        let rate_activation = $('#rates').val();
        let rate_secondary = $('#ratesSecond').val();
        let payment_way = $('#payment_way').val();
        let plazo = $('#plazo').val();
        let lada = $('#lada').val();
        let icc = $('#icc').val();
        let imei = $('#imei').val();
        let noSerie = $('#noSerie').val();
        let direccionMac = $('#direccionMac').val();


        if(name.length == 0 || /^\s+$/.test(name)){
            let message = "El campo Nombre no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('name').focus();
            return false;
        }

        if(lastname.length == 0 || /^\s+$/.test(lastname)){
            let message = "El campo Apellido no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('lastname').focus();
            return false;
        }

        if(address.length == 0 || /^\s+$/.test(address)){
            let message = "El campo Dirección no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('address').focus();
            return false;
        }

        if(cellphone.length == 0 || /^\s+$/.test(cellphone)){
            let message = "El campo Teléfono Contacto no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('cellphone').focus();
            return false;
        }

        if(product == 'Ninguno'){
            let message = "Debe elegir un tipo de producto.";
            sweetAlertFunction(message);
            document.getElementById('product').focus();
            return false;
        }

        if(rate_activation == 0){
            let message = "Debe elegir un plan de activación.";
            sweetAlertFunction(message);
            document.getElementById('rates').focus();
            return false;
        }

        if(rate_secondary == 0){
            let message = "Debe elegir un plan secundario.";
            sweetAlertFunction(message);
            document.getElementById('ratesSecond').focus();
            return false;
        }

        if(payment_way == 0){
            let message = "Debe elegir una forma de pago.";
            sweetAlertFunction(message);
            document.getElementById('payment_way').focus();
            return false;
        }

        if(payment_way == 'Desc. Vía Nómina'){
            if(plazo == 0){
                let message = "Ingrese un plazo válido mayor a 0.";
                sweetAlertFunction(message);
                document.getElementById('plazo').focus();
                return false;
            }
        }

       /* if(icc == ''){
            let message = "El campo ICC no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('icc').focus();
            return false;
        }

        if(imei == ''){
            let message = "El campo IMEI no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('imei').focus();
            return false;
        }

        if(noSerie == ''){
                let message = "El campo No. Serie no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('noSerie').focus();
                return false;
        }

        if(direccionMac == ''){
                let message = "El campo Dirección Mac no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('direccionMac').focus();
                return false;
        }*/

        if($('#diffLADA').prop('checked')) {
            if(lada.length == 0 || /^\s+$/.test(lada)){
                let message = "El campo de LADA no puede estar vacío, si no desea añadir la LADA, quite el check de LADA Diferente.";
                sweetAlertFunction(message);
                document.getElementById('lada').focus();
                return false;
            }
        }
        // console.log('SUCCESS, TODO GOOD');
        // return false;

        $('#formPetition').submit();

    });

    $('#diffLADA').click(function(){
        if($('#diffLADA').prop('checked')) {
            $('#containerLADA').removeClass('d-none');
            document.getElementById('lada').focus();
        }else{
            $('#containerLADA').addClass('d-none');
        }
    });

    function sweetAlertFunction(message){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
            showConfirmButton: false,
            timer: 2000
        });
    }

    $('#product').change(function(){
        let producto = $(this).val();
        let options = '<option value="0">Elige uno...</option>';

        $.ajax({
            url: "{{route('petition.rates')}}",
            data:{producto: producto},
            success: function(response){

                response.forEach(function(element){
                    options+="<option value='"+element.id+"'>"+element.name+" - $"+parseFloat(element.price).toFixed(2)+"</option>"
                });

                $('#rates').html(options);
                $('#ratesSecond').html(options);
            }
        });
    })
</script>
@endsection