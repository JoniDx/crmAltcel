@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Activaciones</h2>
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
    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 6 || Auth::user()->role_id == 10)
        <div class="tabs tabs-success">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#home" data-toggle="tab"><i class="fa fa-star"></i> Altan Redes</a>
                </li>
                <li>
                    <a href="#paquete" data-toggle="tab">SpotMobile</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="home" class="tab-pane active">
                <!-- Altán Services Accordions -->
                    <!-- MIFI Content -->
                    <div class="toggle-content">
                        <form class="form-horizontal form-bordered">

                        @if($petition != 0)
                            <div class="alert alert-warning">
                                <h3>¡¡ATENCIÓN!!</h3>
                                <strong>EL PLAN DE ACTIVACIÓN SOLICITADO ES {{$rate_activation}}</strong>.<br>
                                <strong>SE SOLICITÓ LA LADA {{$lada}}, SE DEBE  HACER CAMBIO DE SIM DESPUÉS DE ACTIVAR</strong>.
                            </div>
                        @endif
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>MIFI/MOV</h3>
                                        </div>
                                        <div class="col-md-6 mx-sm-3 mb-2">
                                            <label for="icc-to-search" class="form-label">ICC_ID</label>
                                            <input type="text" class="form-control form-control-sm mr-2" id="icc-to-search" name="icc-to-search" value="{{$icc}}">
                                            <input type="hidden" class="form-control form-control-sm mr-2" id="rate-to-search" name="icc-to-search" value="{{$rate_name}}">
                                            <input type="hidden" class="form-control form-control-sm mr-2" id="rate-id-search" name="icc-to-search" value="{{$rate_id}}">
                                            <!-- <button type="button" class="btn btn-success btn-sm" id="searching"><i class="fas fa-search"></i> Search</button> -->
                                        </div>
                                        <div class="col-md-12 mt-2 d-none" id="data-dn">
                                            <ul class="list-group col-md-6" id="data-dn-list">
                                            
                                            </ul>

                                        </div>
                                        <div class="col-md-6 d-none mt-4 mb-2" id="content-offers">
                                            <label class="form-label mr-1" for="offers">Tarifa:</label><br>
                                            <select class="form-control form-control-sm col-md-6" id="offers" >
                                                <option selected value="0" >Nothing</option>
                                            </select>
                                        </div>

                                        <input type="hidden" id="flag_rate" value="{{$flag_rate}}">
                                        <input type="hidden" id="rate_subsequent" value="{{$rate_subsequent}}">

                                        <div class="col-md-6">
                                            <label for="exampleDataList" class="form-label">Buscar</label>
                                            <input class="form-control" list="datalistOptions" id="clients_search_altan" placeholder="Escribe algo...">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="exampleFormControlSelect1">Clientes</label>
                                            <select multiple class="form-control" id="clients_options_altan">
                                            </select>
                                        </div>
                                        <input type="hidden" name="petition_id" id="petition_id" value="{{$petition}}">
                                        <div class="col-md-12">
                                            <h3>Contacto</h3>
                                            <div class="checkbox">
                                                <label class="control-label ml-sm">
                                                    <input type="checkbox" id="email-not">
                                                    Omitir envío de correo con accesos
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                                            <div class="col-md-12">
                                                <section class="form-group-vertical">
                                                    <div class="input-group input-group-icon">
                                                        <span class="input-group-addon">
                                                            <span class="icon"><i class="fa fa-user"></i></span>
                                                        </span>
                                                        <input class="form-control" type="text" placeholder="Nombre" id="name" name="name" value="{{$name}}">
                                                    </div>

                                                    <div class="input-group input-group-icon">
                                                        <span class="input-group-addon">
                                                            <span class="icon"><i class="fa fa-user"></i></span>
                                                        </span>
                                                        <input class="form-control" type="text" placeholder="Apellido" id="lastname" name="lastname" value="{{$lastname}}">
                                                    </div>

                                                    <div class="input-group finput-group-icon">
                                                        <span class="input-group-addon">
                                                            <span class="icon"><i class="fa fa-user"></i></span>
                                                        </span>
                                                        <input class="form-control" type="text" placeholder="RFC" id="rfc" name="rfc" value="{{$rfc}}">
                                                    </div>

                                                    <div class="input-group input-group-icon">
                                                        <span class="input-group-addon">
                                                            <span class="icon"><i class="fa fa-calendar"></i></span>
                                                        </span>
                                                        <input class="form-control" type="date" id="date_born" name="date_born" value="{{$date_born}}">
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
                                                        <input class="form-control" type="text" placeholder="Dirección" id="address" name="address" value="{{$address}}">
                                                    </div>

                                                    <div class="input-group input-group-icon">
                                                        <span class="input-group-addon">
                                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                                        </span>
                                                        <input class="form-control" type="email" placeholder="Email" id="email" name="email" value="{{$email}}">
                                                    </div>

                                                    <div class="input-group input-group-icon">
                                                        <span class="input-group-addon">
                                                            <span class="icon"><i class="fa fa-user"></i></span>
                                                        </span>
                                                        <input class="form-control" type="text" placeholder="Código INE" id="ine_code" name="ine_code" value="{{$ine_code}}">
                                                    </div>

                                                    <div class="input-group input-group-icon">
                                                        <span class="input-group-addon">
                                                            <span class="icon"><i class="fa fa-phone"></i></span>
                                                        </span>
                                                        <input class="form-control" type="text" placeholder="Teléfono Contacto" id="cellphone" name="celphone" maxlength="10" value="{{$cellphone}}">
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-12">
                                            <h3>Dispositivo y SIM</h3>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="sim" class="form-label">ICC_ID</label>
                                            <input type="text" class="form-control" id="icc_id" name="icc_id" required readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="sim" class="form-label">MSISDN</label>
                                            <input type="text" class="form-control" id="msisdn" name="msisdn" required readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="sim" class="form-label">IMEI</label>
                                            <input type="text" class="form-control" id="imei" name="imei" required value="{{$imei}}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="serial_number" class="form-label">No. Serie</label>
                                            <input type="text" class="form-control" id="serial_number" name="serial_number" required value="{{$no_serie}}">
                                        </div>
                                        <div class="col-md-3" id="content-MAC">
                                            <label for="mac_address_activation" class="form-label">MAC Address</label>
                                            <input type="text" class="form-control" id="mac_address_activation" name="mac_address_activation" required value="{{$mac}}">
                                            <input type="hidden" id="mac_address_boolean" value="0">
                                        </div>
                                        <div class="col-md-3 d-none">
                                            <label for="sim" class="form-label">Precio Dispositivo</label>
                                            <input type="hidden" class="form-control" id="price_device" name="price_device" disabled value="0" >
                                            <input type="hidden" class="form-control" id="price_rate" name="price_rate" disabled value="0" >
                                        </div>
                                        <div class="col-md-3 d-none" id="altcel_content">
                                            <label for="sim" class="form-label">SIM</label>
                                            <input type="text" class="form-control" id="sim_altcel" name="sim_altcel" required >
                                        </div>
                                        <div class="col-md-3 d-none mb-2" id="content-politics">
                                            <label class="form-label mr-1" for="offers">Políticas:</label><br>
                                            <select class="form-control col-md-12" id="politics" >
                                                <option selected value="0">Nothing</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 d-none">
                                            <label for="monto" class="form-label">Total a cobrar</label>
                                            <input type="hidden" class="form-control" id="monto" name="monto" required readonly value="0">
                                        </div>
                                        <div class="col-md-12 mt-sm">
                                            <div class="col-md-3 well success">
                                            <h3 style="margin-top: 0px;">Desglose</h3>
                                            <h5><span class="label label-warning" id="label-device">Dispositivo: $0.00</span></h5>
                                            <h5><span class="label label-warning" id="label-rate">Tarifa: $0.00</span></h5>
                                            <h5><span class="label label-danger" id="label-total">Total a Cobrar: $0.00</span></h5>
                                            </div>
                                        </div>

                                        <input type="hidden" name="user" id="user" value="{{ Auth::user()->id }}" required>

                                        <div class="col-md-3">
                                            <label for="scheduleDate" class="form-label">Fecha Operación</label>
                                            <input type="date" class="form-control" id="scheduleDate" name="scheduleDate" required >
                                        </div>

                                        <div class="col-md-12">
                                            <div class="checkbox col-md-3">
                                                <label class="control-label ml-sm">
                                                    <input type="checkbox" id="activate_bool">
                                                    Producto activado
                                                </label>
                                            </div>
                                            <div class="checkbox col-md-3 d-none">
                                                <label class="control-label ml-sm">
                                                    <input type="checkbox" id="statusActivation">
                                                    Preactivación
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 1rem;">
                                            <button type="button" class="btn btn-primary" id="send">Aceptar</button>
                                            <!-- <button type="button" class="btn btn-success" id="date-pay">Date Pay</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End MIFI Content -->
                        
                <!-- End Altán Services Accordions -->
                    
                    
                </div>
            
                <div id="paquete" class="tab-pane">
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
                                    <option value="{{$pack->id}}" data-install="{{$pack->price_install}}" data-service="{{$pack->service_name}}" data-price="{{$pack->price}}">{{$pack->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label for="exampleDataList" class="form-label">Buscar</label>
                                <input class="form-control" list="datalistOptions" id="clients_search" placeholder="Escribe algo...">
                            </div>
                            <div class="col-md-6">
                                <label for="exampleFormControlSelect1">Clientes</label>
                                <select multiple class="form-control" id="clients_options">
                                </select>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" id="client_id_ethernet" name="client_id_ethernet" value='0'>

                        <div class="form-group col-md-12">
                            <h3>Datos de Contacto</h3>
                        </div>

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
                        
                        <div class="form-group col-md-6">
                            <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                            <div class="col-md-12">
                                <section class="form-group-vertical">
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" placeholder="Nombre" id="name_ethernet_child" name="name_ethernet_child">
                                    </div>

                                    <div class="input-group input-group-icon hidden-type-person">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" placeholder="Apellido" id="lastname_ethernet_child" name="lastname_ethernet_child">
                                    </div>

                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" placeholder="RFC" id="rfc_ethernet_child" name="rfc_ethernet_child">
                                    </div>

                                    <div class="input-group input-group-icon hidden-type-person">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-calendar"></i></span>
                                        </span>
                                        <input class="form-control" type="date" id="date_born_ethernet_child" name="date_born_ethernet_child">
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
                                        <input class="form-control" type="text" placeholder="Dirección" id="address_ethernet_child" name="address_ethernet_child">
                                    </div>

                                    <div class="input-group input-group-icon hidden-type-person">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                        </span>
                                        <input class="form-control" type="email" placeholder="Email" id="email_ethernet_child" name="email_ethernet_child">
                                    </div>

                                    <div class="input-group input-group-icon hidden-type-person">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" placeholder="Código INE" id="ine_code_ethernet_child" name="ine_code_ethernet_child">
                                    </div>

                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-phone"></i></span>
                                        </span>
                                        <input class="form-control" type="text" placeholder="Teléfono Contacto" id="cellphone_ethernet_child" name="celphone_ethernet_child" maxlength="10">
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
                            <label for="number_install" class="form-label">Número</label>
                            <input type="text" class="form-control" id="number_install" name="number_install" >
                        </div>
                        <div class="form-group col-md-4" style="margin-right: 0.5rem; margin-left: 0.5rem;">
                            <label for="address" class="form-label">Total</label>
                            <input type="text" class="form-control" id="amount-total-pack" name="amount-total-pack" required readonly>
                        </div>

                        <input type="hidden" name="user" id="user_ethernet_id" value="{{ Auth::user()->id }}" required>

                        <div class="col-md-12 mb-sm">
                            <div class="checkbox">
                                <label class="control-label ml-sm">
                                    <input type="checkbox" id="email-not-ethernet">
                                    Omitir envío de correo con accesos
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="button" class="btn btn-primary" id="send_instalation">Aceptar</button>
                        </div>
                    </div>
                    </form>
                </div>
            
            </div>
        </div>
    @elseif(Auth::user()->role_id == 4)
        <div class="tabs tabs-success">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#paquete" data-toggle="tab">Oreda</a>
                </li>
            </ul>
            <div class="tab-content">
            
                <div id="paquete" class="tab-pane active">
                    <form class="form-horizontal form-bordered" method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group" style="padding-right: 1rem; padding-left: 1rem;">
                        @csrf
                        <div class="form-group col-md-12">
                            <h3>Servicios Oreda/Tonalá</h3>
                        </div>

                        <div class="form-group col-md-6 mb-1">
                            <label class="form-label mr-1" for="offers">Paquete:</label><br>
                            <select class="form-control col-md-12" id="pack" >
                                <option selected value="0">Nothing</option>
                                @foreach($packs as $pack)
                                    <option value="{{$pack->id}}" data-install="{{$pack->price_install}}" data-service="{{$pack->service_name}}" data-price="{{$pack->price}}">{{$pack->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label for="exampleDataList" class="form-label">Buscar</label>
                                <input class="form-control" list="datalistOptions" id="clients_search" placeholder="Escribe algo...">
                            </div>
                            <div class="col-md-6">
                                <label for="exampleFormControlSelect1">Clientes</label>
                                <select multiple class="form-control" id="clients_options">
                                </select>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" id="client_id_ethernet" name="client_id_ethernet" value='0'>

                        <div class="form-group col-md-12">
                            <h3>Datos de Contacto</h3>
                        </div>

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
                            <h3>Datos Cliente</h3>
                            <div class="checkbox">
                                <label class="control-label">
                                    <input type="checkbox" id="type_person">
                                    Persona moral
                                </label>
                                <label class="control-label ml-sm">
                                    <input type="checkbox" id="copy_data_ethernet">
                                    Copiar datos de contacto
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                            <div class="col-md-12">
                                <section class="form-group-vertical">
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" placeholder="Nombre" id="name_ethernet_child" name="name_ethernet_child">
                                    </div>

                                    <div class="input-group input-group-icon hidden-type-person">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" placeholder="Apellido" id="lastname_ethernet_child" name="lastname_ethernet_child">
                                    </div>

                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" placeholder="RFC" id="rfc_ethernet_child" name="rfc_ethernet_child">
                                    </div>

                                    <div class="input-group input-group-icon hidden-type-person">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-calendar"></i></span>
                                        </span>
                                        <input class="form-control" type="date" id="date_born_ethernet_child" name="date_born_ethernet_child">
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
                                        <input class="form-control" type="text" placeholder="Dirección" id="address_ethernet_child" name="address_ethernet_child">
                                    </div>

                                    <div class="input-group input-group-icon hidden-type-person">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                        </span>
                                        <input class="form-control" type="email" placeholder="Email" id="email_ethernet_child" name="email_ethernet_child">
                                    </div>

                                    <div class="input-group input-group-icon hidden-type-person">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" placeholder="Código INE" id="ine_code_ethernet_child" name="ine_code_ethernet_child">
                                    </div>

                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-phone"></i></span>
                                        </span>
                                        <input class="form-control" type="text" placeholder="Teléfono Contacto" id="cellphone_ethernet_child" name="celphone_ethernet_child" maxlength="10">
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
                            <label for="number_install" class="form-label">Número</label>
                            <input type="text" class="form-control" id="number_install" name="number_install" >
                        </div>
                        <div class="form-group col-md-4" style="margin-right: 0.5rem; margin-left: 0.5rem;">
                            <label for="address" class="form-label">Total</label>
                            <input type="text" class="form-control" id="amount-total-pack" name="amount-total-pack" required readonly>
                        </div>

                        <input type="hidden" name="user" id="user_ethernet_id" value="{{ Auth::user()->id }}" required>

                        <div class="col-md-12 mb-sm">
                            <div class="checkbox">
                                <label class="control-label ml-sm">
                                    <input type="checkbox" id="email-not-ethernet">
                                    Omitir envío de correo con accesos
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="button" class="btn btn-primary" id="send_instalation">Aceptar</button>
                        </div>
                    </div>
                    </form>
                </div>
            
            </div>
        </div>
    @endif
</div>

<script src="{{asset('octopus/assets/vendor/pnotify/pnotify.custom.js')}}"></script>

<script>
    var petition = '{{$petition}}';

    $(document).ready(function(){
        let msisdn = $('#icc-to-search').val();

        if(msisdn.length != 0){
            msisdns(msisdn);
        }
    });

    $('#icc-to-search').keyup(function(){
        let msisdn = $(this).val();

        if(msisdn.length == 20){
            msisdns(msisdn);
        }
   
    });

    $('#offers').change(function(){
        // $('#monto').val(total);
        let price = $('#offers option:selected').attr('data-plan-price');
        $('#label-rate').html('Tarifa: $'+price.toFixed(2));
        // $('#label-total').html('Total a Cobrar: $'+total.toFixed(2));

    });


    function msisdns(msisdn){
        let token = $('meta[name="csrf-token"]').attr('content');
        
        let list = '';
        let product = '';
        let badge_color = 'badge-primary';
        $.ajax({
            url: "{{ route('search-dn.post')}}",
            method: 'POST',
            data:{
                _token:token, 
                msisdn:msisdn
                },
            success: function(data){
                console.log(data);
                $('#data-dn').removeClass('d-none');
                $('#content-offers').removeClass('d-none');
                
                list+='<li class="list-group-item d-flex justify-content-between align-items-center">MSISDN: <span class="badge label label-primary"> '+data.MSISDN+'</span></li>';
                list+='<li class="list-group-item d-flex justify-content-between align-items-center">PUK: <span class="badge label label-primary"> '+data.puk+'</span></li>';
                list+='<li class="list-group-item d-flex justify-content-between align-items-center">PIN: <span class="badge label label-primary"> '+data.pin+'</span></li>';
                list+='<li class="list-group-item d-flex justify-content-between align-items-center">Producto: <span class="badge label label-primary"> '+data.producto+'</span></li>';
                if(data.status == 'taken') {
                    badge_color = 'label label-danger';
                    $('#icc_id').val('');
                    $('#msisdn').val('');
                }else if(data.status == 'available'){
                    badge_color = 'label label-success';
                    product = data.producto;
                    $('#icc_id').val(data.icc_id);
                    $('#msisdn').val(data.MSISDN);
                }else{
                    badge_color = 'label label-warning';
                    product = data.producto;
                    $('#icc_id').val(data.icc_id);
                    $('#msisdn').val(data.MSISDN);
                }
                list+='<li class="list-group-item d-flex justify-content-between align-items-center">Estado: <span class="badge '+badge_color+'"> '+data.status+'</span></li>';

                $('#data-dn-list').html(list);
                getRates(product);
                // console.log("product:",product);
                // return false;
            }
        });
    }

    function getRates(product) {
        let token = $('meta[name="csrf-token"]').attr('content');
        let options = '<option value="0">Choose...</option>';
        // let options = '';
        let count = 0;
        let name_rate = $('#rate-to-search').val();
        let id_rate = $('#rate-id-search').val();
        let offerIDChoosed = 0;
        $.ajax({
                url: "{{ route('get-rates-alta.post')}}",
                method: 'POST',
                data:{
                    _token:token, 
                    product:product
                    },
                success: function(data){
                    // console.log(data);
                    // return false;

                     data.forEach(function(element){

                        if(petition != 0){

                            if(name_rate == element.name && id_rate == element.id){
                                options+="<option selected value='"+element.offerID+"' data-rate-id='"+element.id+"' data-plan-price='"+element.price+"' data-plan-name='"+element.name+"' data-plan-recurrency='"+element.recurrency+"' data-product='"+element.offer_product+"' data-promo-bool='"+element.promo_bool+"' data-device-price='"+element.device_price+"'>"+element.name+"</option>"
                                offerIDChoosed = element.offerID;
                            }
                            else{
                                options+="<option value='"+element.offerID+"' data-rate-id='"+element.id+"' data-plan-price='"+element.price+"' data-plan-name='"+element.name+"' data-plan-recurrency='"+element.recurrency+"' data-product='"+element.offer_product+"' data-promo-bool='"+element.promo_bool+"' data-device-price='"+element.device_price+"'>"+element.name+"</option>"
                            }
                        }else{
                        // console.log(element.name);
                        // return false;
                        options+="<option value='"+element.offerID+"' data-rate-id='"+element.id+"' data-plan-price='"+element.price+"' data-plan-name='"+element.name+"' data-plan-recurrency='"+element.recurrency+"' data-product='"+element.offer_product+"' data-promo-bool='"+element.promo_bool+"' data-device-price='"+element.device_price+"'>"+element.name+"</option>"
                        }
                    });
                    

                    console.log(count);
                    $('#offers').html(options);
                    valors(offerIDChoosed);
                }
            });
    }

    $('#pack').change(function(){
        let pack_id = $(this).val();
        let politicFlag = 2;
        let amountInstall = $('#pack option:selected').attr('data-install');
        let service = $('#pack option:selected').attr('data-service');
        let price = $('#pack option:selected').attr('data-price');
        let token = $('meta[name="csrf-token"]').attr('content');
        let options = '<option value="0">Choose...</option>';
        price = parseFloat(price);
        
        if(service == 'SpotMobile'){
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
                    _token:token
                    },
                success: function(data){
                    data.forEach(function(element){
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

    $('#type_person').click(function(){
        if($('#type_person').prop('checked') ) {
            $('.hidden-type-person').addClass('d-none');
            $('#lastname_ethernet_child').val('');
            $('#date_born_ethernet_child').val('');
            $('#ine_code_ethernet_child').val('');
            $('#email_ethernet_child').val('');

        }else{
            $('.hidden-type-person').removeClass('d-none');
            
        }
    });

    $('#copy_data').click(function(){
        if($('#copy_data').prop('checked') ) {
            let name = $('#name').val();
            let lastname = $('#lastname').val();
            let rfc = $('#rfc').val();
            let date_born = $('#date_born').val();
            let address = $('#address').val();
            let ine_code = $('#ine_code').val();
            let email = $('#email').val();
            let cellphone = $('#cellphone').val();

            $('#name_child').val(name);
            $('#rfc_child').val(rfc);
            $('#lastname_child').val(lastname);
            $('#date_born_child').val(date_born);
            $('#address_child').val(address);
            $('#ine_code_child').val(ine_code);
            $('#email_child').val(email);
            $('#cellphone_child').val(cellphone);

        }else{
            $('#name_child').val('');
            $('#rfc_child').val('');
            $('#lastname_child').val('');
            $('#date_born_child').val('');
            $('#address_child').val('');
            $('#ine_code_child').val('');
            $('#email_child').val('');
            $('#cellphone_child').val('');
        }
    });

    $('#copy_data_ethernet').click(function(){
        if($('#copy_data_ethernet').prop('checked') ) {
            let name = $('#name_ethernet').val();
            let lastname = $('#lastname_ethernet').val();
            let rfc = $('#rfc_ethernet').val();
            let date_born = $('#date_born_ethernet').val();
            let address = $('#address_ethernet').val();
            let ine_code = $('#ine_code_ethernet').val();
            let email = $('#email_ethernet').val();
            let cellphone = $('#cellphone_ethernet').val();

            $('#name_ethernet_child').val(name);
            $('#rfc_ethernet_child').val(rfc);
            $('#lastname_ethernet_child').val(lastname);
            $('#date_born_ethernet_child').val(date_born);
            $('#address_ethernet_child').val(address);
            $('#ine_code_ethernet_child').val(ine_code);
            $('#email_ethernet_child').val(email);
            $('#cellphone_ethernet_child').val(cellphone);

        }else{
            $('#name_ethernet_child').val('');
            $('#rfc_ethernet_child').val('');
            $('#lastname_ethernet_child').val('');
            $('#date_born_ethernet_child').val('');
            $('#address_ethernet_child').val('');
            $('#ine_code_ethernet_child').val('');
            $('#email_ethernet_child').val('');
            $('#cellphone_ethernet_child').val('');
        }
    });

    $('#type_person_mifi').click(function(){
        if($('#type_person_mifi').prop('checked') ) {
            $('.hidden-type-person-mifi').addClass('d-none');
            $('#lastname_child').val('');
            $('#date_born_child').val('');
            $('#ine_code_child').val('');
            $('#email_child').val('');

            let client = $('#clients_options_altan').val();
            let optionsPM = '<option value="0">Ninguno...</option>'
            $.ajax({
                url: "{{route('searchMoralPerson')}}",
                data: {id:client},
                success: function(response){
                    console.log(response)
                    // response = JSON.parse(response);
                    response.forEach(function(e){
                        optionsPM+="<option data-name='"+e.name+"' data-rfc='"+e.rfc+"' data-address='"+e.address+"' data-cellphone='"+e.cellphone+"'>"+e.name+" - "+e.rfc+" - "+e.cellphone+"</option>"
                    });
                    $('#moralPersons').html(optionsPM);
                    $('#personaMoralModal').modal('show');
                }
            })
        }else{
            $('.hidden-type-person-mifi').removeClass('d-none');
            
        }
    });

    $('#clients_search, #clients_search_altan').keyup( function(){
        let term = $(this).val();
        let id = $(this).attr('id');
        // return console.log(id);
        let options = '';
        if(term.length == 0 || /^\s+$/.test(term)){
            if(id == 'clients_search_altan'){
                $('#clients_options_altan').html(options);
                $('#name').val('');
                $('#lastname').val('');
                $('#lastname').val('');
                $('#email').val('');
                $('#celphone').val('');
                $('#rfc').val('');
                $('#date_born').val('');
                $('#address').val('');
                $('#ine_code').val('');
                $('#cellphone').val('');
                return false;
            }else if(id == 'clients_search'){
                $('#clients_options').html(options);
                $('#client_id_ethernet').val(0);
                $('#name_ethernet').val('');
                $('#lastname_ethernet').val('');
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
        }
            $.ajax({
                url: "{{ route('search-clients.get')}}",
                data:{term:term},
                success: function(data){
                    console.log(data);
                    data.forEach(
                        element => options+='<option value="'+element.id+'" data-name="'+element.name+'" data-lastname="'+element.lastname+'" data-email="'+element.email+'" data-rfc="'+element.rfc+'" data-date_born="'+element.date_born+'" data-address="'+element.address+'" data-ine_code="'+element.ine_code+'" data-cellphone="'+element.cellphone+'">'+element.name+' '+element.lastname+' - '+element.email+'</options>'
                        );
                        if(id == 'clients_search_altan'){
                            $('#clients_options_altan').html(options);
                        }else if(id == 'clients_search'){
                            $('#clients_options').html(options);
                        }
                }
            });
    });

    $('#clients_options, #clients_options_altan').change( function(){
        let id = $(this).val();
        let id_text = $(this).attr('id');

        let name = $('option:selected', $(this)).attr('data-name');
        let lastname = $('option:selected', $(this)).attr('data-lastname');
        let email = $('option:selected', $(this)).attr('data-email');
        let rfc = $('option:selected', $(this)).attr('data-rfc');
        let date_born = $('option:selected', $(this)).attr('data-date_born');
        let address = $('option:selected', $(this)).attr('data-address');
        let ine_code = $('option:selected', $(this)).attr('data-ine_code');
        let cellphone = $('option:selected', $(this)).attr('data-cellphone');
        console.log(id);
        if(id_text == 'clients_options'){
            $('#client_id_ethernet').val(id);
            $('#name_ethernet').val(name);
            $('#lastname_ethernet').val(lastname);
            $('#rfc_ethernet').val(rfc);
            $('#date_born_ethernet').val(date_born);
            $('#address_ethernet').val(address);
            $('#ine_code_ethernet').val(ine_code);
            $('#email_ethernet').val(email);
            $('#cellphone_ethernet').val(cellphone);
        }else if(id_text = 'clients_options_altan'){
            $('#name').val(name);
            $('#lastname').val(lastname);
            $('#rfc').val(rfc);
            $('#date_born').val(date_born);
            $('#address').val(address);
            $('#ine_code').val(ine_code);
            $('#email').val(email);
            $('#cellphone').val(cellphone);
        }
        
    });

    $('#send').click(function(){
        let name = $('#name').val();
        let lastname = $('#lastname').val();
        let address = $('#address').val();
        let email = $('#email').val();
        let cellphone = $('#cellphone').val();
        let rfc = $('#rfc').val();
        let date_born = $('#date_born').val();
        let ine_code = $('#ine_code').val();
        let offer_id = $('#offers').val();
        let rate_id =  $('#offers option:selected').attr('data-rate-id');
        let rate_name =  $('#offers option:selected').attr('data-plan-name');
        let rate_recurrency =  $('#offers option:selected').attr('data-plan-recurrency');
        let product =  $('#offers option:selected').attr('data-product');
        let promo_bool = $('#offers option:selected').attr('data-promo-bool');
        let amount = $('#offers option:selected').attr('data-plan-price');
        let price_device = $('#price_device').val();
        let price_rate = $('#price_rate').val();
        let icc_id = $('#icc_id').val();
        let msisdn = $('#msisdn').val();
        let who_did_id = $('#user').val();
        let scheduleDateFirst = $('#scheduleDate').val();
        let petition = $('#petition_id').val();
        let flag_rate = $('#flag_rate').val();
        let rate_subsequent = $('#rate_subsequent').val();
        let from = 'self';
        let imei = $('#imei').val();
        let serial_number = $('#serial_number').val();
        let mac_address = $('#mac_address_activation').val();
        let statusActivation = 'activated';

        $.ajax({
            url: "{{ route('activation-general.post')}}",
            method: 'GET',
            data:{
                price_device,
                price_rate,
                name,
                lastname,
                address,
                email,
                cellphone,
                rfc,
                date_born,
                ine_code,
                offer_id,
                rate_id,
                rate_name,
                rate_recurrency,
                product,
                icc_id,
                msisdn,
                who_did_id,
                scheduleDateFirst,
                petition,
                flag_rate,
                from,
                rate_subsequent,
                statusActivation,
                promo_bool,
                mac_address,
                imei,
                serial_number,
                amount
            },
            success:function(response){
                if (response == 1) {
                    swal_succes('Activacion completada!!');
                } else if(response == 2) {
                    swal_error('Activacion interrumpida');
                }else if (response == 0) {
                    swal_error('Revise correctamente los datatos ingresados');
                }else{
                    swal_error('Error comunicarce con desarrollo');
                }
            }
        })
    })
</script>
@endsection