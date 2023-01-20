@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Activación</h2>

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
<div class="col-md-12">
    <div class="tabs">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#popular" data-toggle="tab"><i class="fa fa-star"></i> Conecta</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="popular" class="tab-pane active">
                <form class="form-horizontal form-bordered" method="POST" action="" enctype="multipart/form-data">
                <div class="form-group" style="padding-right: 1rem; padding-left: 1rem;">
                    @csrf
                    <div class="form-group col-md-12">
                        <h3>Servicio</h3>
                    </div>

                    <div class="form-group col-md-6 mb-1">
                        <label class="form-label mr-1" for="offers">Paquete:</label><br>
                        <select class="form-control col-md-12" id="pack" >
                            <option selected value="0">Nothing</option>
                            @foreach($packs as $pack)
                                <option value="{{$pack->id}}" data-install="{{$pack->price_install}}" data-service="{{$pack->service_name}}">{{$pack->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <h3>Datos Cliente</h3>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="exampleDataList" class="form-label">Buscar</label>
                        <input class="form-control" list="datalistOptions" id="clients_search" placeholder="Escribe algo...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleFormControlSelect1">Clientes</label>
                        <select multiple class="form-control" id="clients_options">
                        </select>
                    </div>

                    <input type="hidden" class="form-control" id="client_id_ethernet" name="client_id_ethernet" value='0'>

                    <div class="form-group col-md-6">
                        <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                        <div class="col-md-12">
                            <section class="form-group-vertical">
                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-user"></i></span>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Nombre" id="name_ethernet" name="name_ethernet">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-user"></i></span>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Apellido" id="lastname_ethernet" name="lastname_ethernet">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-user"></i></span>
                                    </span>
                                    <input class="form-control" type="text" placeholder="RFC" id="rfc_ethernet" name="rfc_ethernet">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-calendar"></i></span>
                                    </span>
                                    <input class="form-control" type="date" id="date_born_ethernet" name="date_born_ethernet">
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
                                    <input class="form-control" type="text" placeholder="Dirección" id="address_ethernet" name="address_ethernet">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-envelope"></i></span>
                                    </span>
                                    <input class="form-control" type="email" placeholder="Email" id="email_ethernet" name="email_ethernet">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-user"></i></span>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Código INE" id="ine_code_ethernet" name="ine_code_ethernet">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-phone"></i></span>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Teléfono Contacto" id="cellphone_ethernet" name="celphone_ethernet" maxlength="10">
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <h3>Antena Cliente</h3>
                    </div>

                    <div class="form-group col-md-6 id_content">
                        <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                        <div class="col-md-12">
                            <section class="form-group-vertical">
                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-rss"></i></span>
                                    </span>
                                    <input class="form-control" type="text" placeholder="No. Serie Antena" id="no_serie_antena" name="no_serie_antena">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-rss"></i></span>
                                    </span>
                                    <input class="form-control" type="email" placeholder="MAC Address Antena" id="mac_address_antena" name="mac_address_antena">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-rss"></i></span>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Modelo Antena" id="model_antena" name="model_antena">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-rss"></i></span>
                                    </span>
                                    <input class="form-control" type="text" placeholder="IP Address Antena" id="ip_antena" name="ip_antena">
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="form-group col-md-6 ">
                        <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                        <div class="col-md-12">
                            <section class="form-group-vertical">
                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-globe"></i></span>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Latitud" id="lat" name="lat">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-globe"></i></span>
                                    </span>
                                    <input class="form-control" type="email" placeholder="Longitud" id="lng" name="lng">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-home"></i></span>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Dirección Antena" id="address_antena" name="address_antena">
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="form-group col-md-12 id_content">
                        <h3>Router Cliente</h3>
                    </div>
                    <div class="form-group col-md-6 id_content">
                        <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                        <div class="col-md-12">
                            <section class="form-group-vertical">
                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-globe"></i></span>
                                    </span>
                                    <input class="form-control" type="text" placeholder="No. Serie Router" id="no_serie_router" name="no_serie_router">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-globe"></i></span>
                                    </span>
                                    <input class="form-control" type="email" placeholder="MAC Address Router" id="mac_address_router" name="mac_address_router">
                                </div>

                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-home"></i></span>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Modelo Router" id="model_router" name="model_router">
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <h3>Extras</h3>
                    </div>
                    <div class="form-group col-md-4 id_content" style="margin-right: 0.5rem; margin-left: 0.5rem;">
                        <label class="form-label mr-1" for="offers">Radiobase:</label><br>
                        <select class="form-control col-md-12" id="radiobase" >
                            <option selected value="0">Nothing</option>
                            @foreach($radiobases as $radiobase)
                                <option value="{{$radiobase->id}}">{{$radiobase->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4" style="margin-right: 0.5rem; margin-left: 0.5rem;">
                        <label class="form-label mr-1" for="offers">Políticas:</label><br>
                        <select class="form-control col-md-12" id="politics-pack" >
                        </select>
                    </div>

                    <div class="form-group col-md-4" id="cobro_paquete" style="margin-right: 0.5rem; margin-left: 0.5rem;">
                        <label for="address" class="form-label">Cobro del paquete</label>
                        <input type="text" class="form-control" id="amount-pack" name="amount-pack" required readonly>
                    </div>
                    <div class="form-group col-md-4" style="margin-right: 0.5rem; margin-left: 0.5rem;">
                        <label for="address" class="form-label">Cobro de Instalación</label>
                        <input type="text" class="form-control" id="amount-install-pack" name="amount-install-pack" required readonly>
                    </div>
                    <div class="form-group col-md-4" style="margin-right: 0.5rem; margin-left: 0.5rem;">
                        <label for="address" class="form-label">Total</label>
                        <input type="text" class="form-control" id="amount-total-pack" name="amount-total-pack" required readonly>
                    </div>

                    <input type="hidden" name="user" id="user_ethernet_id" value="{{ Auth::user()->id }}" required>

                    
                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-primary" id="send_instalation">Aceptar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $('#date-pay').click(function(){
        $.ajax({
                url: "{{ route('date-pay')}}",
                success: function(data){
                    console.log(data);
                    
                }
            });
    });

    $('#pack').change(function(){
        let pack_id = $(this).val();
        let politicFlag = 2;
        let amountInstall = $('#pack option:selected').attr('data-install');
        let service = $('#pack option:selected').attr('data-service');
        let token = $('meta[name="csrf-token"]').attr('content');
        let options = '<option value="0">Choose...</option>';

        $('#amount-pack').val('');
        $('#amount-install-pack').val('');
        $('#amount-total-pack').val('');
        
        if(service == 'Conecta'){
            $('.id_content').removeClass('d-none');
            $('#cobro_paquete').removeClass('mt-3');
        }else if(service == 'Telmex'){
            $('.id_content').addClass('d-none');
            $('#cobro_paquete').addClass('mt-3');
        }
        if(pack_id != 0){
            let amountInstall = $('#pack option:selected').attr('data-install');
            $('#amount-install-pack').val(amountInstall);
        }
        $.ajax({
                url: "{{ route('get-politics-rates.post')}}",
                method: 'POST',
                data:{
                    _token:token, 
                    pack_id: pack_id,
                    politicFlag: politicFlag
                    },
                success: function(data){
                    data.forEach(function(element){
                        let price = element.price;
                        let porcent = element.porcent/100;
                        let cobro = price*porcent;
                        options+="<option value='"+cobro+"' >"+element.description+"</option>"
                    });
                    $('#politics-pack').html(options);
                }
            });
    });

    $('#politics-pack').change(function(){
        let amount = parseFloat($(this).val());
        let amountInstall = parseFloat($('#amount-install-pack').val());
        let total = amount+amountInstall;
        $('#amount-pack').val(amount);
        $('#amount-total-pack').val(total);
    });

    $('#send_instalation').click(function(){
        let no_serie_antena = $('#no_serie_antena').val();
        let mac_address_antena = $('#mac_address_antena').val();
        let model_antena = $('#model_antena').val();
        let ip_address_antena = $('#ip_antena').val();
        let lat = $('#lat').val();
        let lng = $('#lng').val();
        let address = $('#address_antena').val();
        let no_serie_router = $('#no_serie_router').val();
        let mac_address_router = $('#mac_address_router').val();
        let model_router = $('#model_router').val();
        let radiobase_id = $('#radiobase').val();
        let pack_id = $('#pack').val();
        let pack_service = $('#pack option:selected').attr('data-service');
        let who_did_id = $('#user_ethernet_id').val();
        let client_id = $('#client_id_ethernet').val();
        let amount = $('#amount-pack').val();
        let amount_install = $('#amount-install-pack').val();
        let amount_total = $('#amount-total-pack').val();
        let token = $('meta[name="csrf-token"]').attr('content');

        let name = $('#name_ethernet').val();
        let lastname = $('#lastname_ethernet').val();
        let rfc = $('#rfc_ethernet').val();
        let date_born = $('#date_born_ethernet').val();
        let client_address = $('#address_ethernet').val();
        let ine_code = $('#ine_code_ethernet').val();
        let email = $('#email_ethernet').val();
        let cellphone = $('#cellphone_ethernet').val();

        if(pack_id == 0){
            let message = "Elija un Paquete.";
            sweetAlertFunction(message);
            return false;
        }

        if(name.length == 0 || /^\s+$/.test(name)){
            let message = "El campo Nombre no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('name_ethernet').focus();
            return false;
        }

        if(lastname.length == 0 || /^\s+$/.test(lastname)){
            let message = "El campo Apellido no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('lastname_ethernet').focus();
            return false;
        }

        if(rfc.length == 0 || /^\s+$/.test(rfc)){
            let message = "El campo RFC no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('rfc_ethernet').focus();
            return false;
        }

        if(date_born.length == 0 || /^\s+$/.test(date_born)){
            let message = "El campo Fecha nacimiento no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('date_born_ethernet').focus();
            return false;
        }

        if(client_address.length == 0 || /^\s+$/.test(client_address)){
            let message = "El campo Dirección no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('address_ethernet').focus();
            return false;
        }

        if(email.length == 0 || /^\s+$/.test(email)){
            let message = "El campo Email no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('email_ethernet').focus();
            return false;
        }

        if(ine_code.length == 0 || /^\s+$/.test(ine_code)){
            let message = "El campo Código INE no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('ine_code_ethernet').focus();
            return false;
        }

        if(cellphone.length == 0 || /^\s+$/.test(cellphone)){
            let message = "El campo Teléfono Contacto no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('cellphone_ethernet').focus();
            return false;
        }

        if(pack_service == 'Conecta'){
            if(no_serie_antena.length == 0 || /^\s+$/.test(no_serie_antena)){
                let message = "El campo No. Serie Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('no_serie_antena').focus();
                return false;
            }

            if(mac_address_antena.length == 0 || /^\s+$/.test(mac_address_antena)){
                let message = "El campo MAC Address Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('mac_address_antena').focus();
                return false;
            }

            if(model_antena.length == 0 || /^\s+$/.test(model_antena)){
                let message = "El campo Modelo Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('model_antena').focus();
                return false;
            }

            if(ip_address_antena.length == 0 || /^\s+$/.test(ip_address_antena)){
                let message = "El campo IP Address Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('ip_address_antena').focus();
                return false;
            }

            if(lat.length == 0 || /^\s+$/.test(lat)){
                let message = "El campo Latitud no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('lat').focus();
                return false;
            }

            if(lng.length == 0 || /^\s+$/.test(lng)){
                let message = "El campo Logintud no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('lng').focus();
                return false;
            }

            if(address.length == 0 || /^\s+$/.test(address)){
                let message = "El campo Dirección de Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('address_antena').focus();
                return false;
            }

            if(no_serie_router.length == 0 || /^\s+$/.test(no_serie_router)){
                let message = "El campo No. Serie Router Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('no_serie_router_antena').focus();
                return false;
            }

            if(mac_address_router.length == 0 || /^\s+$/.test(mac_address_router)){
                let message = "El campo MAC Address Router Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('mac_address_router_antena').focus();
                return false;
            }

            if(model_router.length == 0 || /^\s+$/.test(model_router)){
                let message = "El campo MAC Address Router Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('model_router_antena').focus();
                return false;
            }

            if(radiobase_id == 0){
                let message = "Elija una Radiobase.";
                sweetAlertFunction(message);
                return false;
            }
            
            if(amount.length == 0 || /^\s+$/.test(amount)){
                let message = "Elija una política para obtener un cobro de paquete.";
                sweetAlertFunction(message);
                document.getElementById('amount-pack').focus();
                return false;
            }
            
            if(amount_total.length == 0 || /^\s+$/.test(amount_total)){
                let message = "Elija una política para obtener un cobro de paquete.";
                sweetAlertFunction(message);
                document.getElementById('amount-total-pack').focus();
                return false;
            }
        }

        $.ajax({
            url: "{{ route('activation-ethernet.post')}}",
            method: 'GET',
            data:{
                _token:token, 
                no_serie_antena: no_serie_antena,
                mac_address_antena: mac_address_antena,
                model_antena: model_antena,
                ip_address_antena: ip_address_antena,
                lat: lat,
                lng: lng,
                address: address,
                no_serie_router: no_serie_router,
                mac_address_router: mac_address_router,
                model_router: model_router,
                radiobase_id: radiobase_id,
                pack_id: pack_id,
                who_did_id: who_did_id,
                client_id: client_id,
                name: name,
                lastname: lastname,
                rfc: rfc,
                date_born: date_born,
                client_address: client_address,
                ine_code: ine_code,
                email: email,
                cellphone: cellphone,
                amount: amount,
                amount_install: amount_install,
                amount_total: amount_total,
                pack_service: pack_service,
                schedule_flag: 0
                },
            success: function(data){
                // console.log(data);
                Swal.fire({
                    icon: 'success',
                    title: data,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        });
    });

    $('#clients_search').keyup( function(){
        let term = $(this).val();
        let options = '';
        if(term.length == 0 || /^\s+$/.test(term)){
            $('#clients_options').html(options);
            $('#client_id_ethernet').val(0);
            $('#name_ethernet').val('');
            $('#lastname_ethernet').val('');
            $('#email_ethernet').val('');
            $('#celphone_ethernet').val('');
            $('#rfc_ethernet').val('');
            $('#date_born_ethernet').val('');
            $('#address_ethernet').val('');
            $('#ine_code_ethernet').val('');
            $('#cellphone_ethernet').val('');
            return false;
        }
            $.ajax({
                url: "{{ route('search-clients.get')}}",
                data:{term:term},
                success: function(data){
                    console.log(data);
                    data.forEach(
                        element => options+='<option value="'+element.user_id+'" data-name="'+element.name+'" data-lastname="'+element.lastname+'" data-email="'+element.email+'" data-rfc="'+element.rfc+'" data-date_born="'+element.date_born+'" data-address="'+element.address+'" data-ine_code="'+element.ine_code+'" data-cellphone="'+element.cellphone+'">'+element.name+' - '+element.email+'</options>'
                        );
                        $('#clients_options').html(options);
                }
            });
    });

    $('#clients_options').change( function(){
        let id = $(this).val();
        let name = $('option:selected', $(this)).attr('data-name');
        let lastname = $('option:selected', $(this)).attr('data-lastname');
        let email = $('option:selected', $(this)).attr('data-email');
        let rfc = $('option:selected', $(this)).attr('data-rfc');
        let date_born = $('option:selected', $(this)).attr('data-date_born');
        let address = $('option:selected', $(this)).attr('data-address');
        let ine_code = $('option:selected', $(this)).attr('data-ine_code');
        let cellphone = $('option:selected', $(this)).attr('data-cellphone');
        console.log(id);
        $('#client_id_ethernet').val(id);
        $('#name_ethernet').val(name);
        $('#lastname_ethernet').val(lastname);
        $('#rfc_ethernet').val(rfc);
        $('#date_born_ethernet').val(date_born);
        $('#address_ethernet').val(address);
        $('#ine_code_ethernet').val(ine_code);
        $('#email_ethernet').val(email);
        $('#cellphone_ethernet').val(cellphone);
    });

    function sweetAlertFunction(message){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        });
    }
</script>
@endsection