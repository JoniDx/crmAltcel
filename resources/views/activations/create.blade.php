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
    <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
        <li class="fa fa-plus-square"></li> Nuevo Cliente
    </button>
</div>

<div class="col-md-12">
@if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 6 || Auth::user()->role_id == 10)
    <div class="tabs tabs-success">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#home" data-toggle="tab"><i class="fa fa-star"></i> Altan Redes</a>
            </li>
            <li>
                <a href="#paquete" data-toggle="tab">Conecta</a>
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
                                        <h3>MIFI/HBB/MOV</h3>
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

                                    <div class="form-group col-md-12">
                                        
                                        <div class="col-md-6 d-none" id="coordinates">
                                        <label class="control-label col-md-4">Coordenadas:</label>
                                            <section class="form-group-vertical">
                                                <div class="input-group input-group-icon">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-globe"></i></span>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="Latitud" id="lat_hbb" name="lat_hbb">
                                                </div>

                                                <div class="input-group input-group-icon">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-globe"></i></span>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="Longitud" id="lng_hbb" name="lng_hbb">
                                                </div>

                                            </section>
                                        </div>
                                    </div>

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
                                        <h3>Datos del Cliente</h3>
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" id="type_person_mifi">
                                                Persona moral
                                            </label>
                                            <label class="control-label ml-sm">
                                                <input type="checkbox" id="copy_data">
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
                                                    <input class="form-control" type="text" placeholder="Nombre" id="name_child" name="name_child">
                                                </div>

                                                <div class="input-group input-group-icon hidden-type-person-mifi">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-user"></i></span>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="Apellido" id="lastname_child" name="lastname_child">
                                                </div>

                                                <div class="input-group input-group-icon">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-user"></i></span>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="RFC" id="rfc_child" name="rfc_child">
                                                </div>

                                                <div class="input-group input-group-icon hidden-type-person-mifi">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-calendar"></i></span>
                                                    </span>
                                                    <input class="form-control" type="date" id="date_born_child" name="date_born_child">
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
                                                    <input class="form-control" type="text" placeholder="Dirección" id="address_child" name="address_child">
                                                </div>

                                                <div class="input-group input-group-icon hidden-type-person-mifi">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-envelope"></i></span>
                                                    </span>
                                                    <input class="form-control" type="email" placeholder="Email" id="email_child" name="email_child">
                                                </div>

                                                <div class="input-group input-group-icon hidden-type-person-mifi">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-user"></i></span>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="Código INE" id="ine_code_child" name="ine_code_child">
                                                </div>

                                                <div class="input-group input-group-icon">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-phone"></i></span>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="Teléfono Contacto" id="cellphone_child" name="celphone_child" maxlength="10">
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
<!-- Modal de Cliente Nuevo -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cliente Nuevo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="display:flex; justify-content:center; margin-left: auto !important;">
                <form class="form-horizontal form-bordered" action="{{route('clients.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                            
                                <div class="col-md-12">
                                    <h3>Contacto</h3>
                                    
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                                    <div class="col-md-12">
                                        <section class="form-group-vertical">
                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-user"></i></span>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Nombre" id="new_name" name="new_name">
                                            </div>

                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-user"></i></span>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Apellido" id="new_lastname" name="new_lastname">
                                            </div>

                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-user"></i></span>
                                                </span>
                                                <input autocomplete="off" class="form-control" type="text" placeholder="RFC" id="new_rfc" name="new_rfc">
                                            </div>

                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-calendar"></i></span>
                                                </span>
                                                <input class="form-control" type="date" id="new_date_born" name="new_date_born">
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
                                                <input class="form-control" type="text" placeholder="Dirección" id="new_address" name="new_address">
                                            </div>

                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-envelope"></i></span>
                                                </span>
                                                <input class="form-control" type="email" placeholder="Email" id="new_email" name="new_email">
                                            </div>

                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-user"></i></span>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Código INE, Cédula o Pasaporte" id="new_ine_code" name="new_ine_code">
                                            </div>

                                            <div class="input-group input-group-icon">
                                                <span class="input-group-addon">
                                                    <span class="icon"><i class="fa fa-phone"></i></span>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Teléfono Contacto" id="new_cellphone" name="new_cellphone" maxlength="10">
                                            </div>
                                        </section>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-xs mb-md">
                                    <label for="interests">Producto de Interés</label>
                                    <select id="interests" name="interests" class="form-control form-control-sm" required="">
                                        <option selected value="Ninguno">Ninguno...</option>
                                        <option value="HBB">HBB</option>
                                        <option value="MIFI">MIFI</option>
                                        <option value="Portabilidad Telmex">Portabilidad Telmex</option>
                                    </select>
                                </div>

                                <input type="hidden" name="new_user" id="new_user" value="{{ Auth::user()->id }}" required>

                                <div class="col-md-12" style="margin-top: 1rem;">
                                    <button type="button" class="btn btn-primary" id="send_client">Guardar</button>
                                    <!-- <button type="button" class="btn btn-success" id="date-pay">Date Pay</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
<!-- Modal de Personas Morales -->
<div class="modal fade" id="personaMoralModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moralPersonModalLabel">Personas Morales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="display:flex; justify-content:center; margin-left: auto !important;">
                <form class="form-horizontal form-bordered" action="{{route('clients.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">

                                <div class="col-md-12 mt-xs mb-md">
                                    <label for="moralPersons">Personas Morales</label>
                                    <select id="moralPersons" name="moralPersons" class="form-control form-control-sm" required="">
                                        <option selected value="Ninguno">Ninguno...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<script src="{{asset('octopus/assets/vendor/pnotify/pnotify.custom.js')}}"></script>
<script>
    var petition = '{{$petition}}';
            
    // $('#icc-to-search').keyup(function(){
    //     // let msisdn = $('#icc-to-search').val();
    //     let msisdn = $(this).val();

    //     let token = $('meta[name="csrf-token"]').attr('content');
        
    //     let list = '';
    //     let product = '';
    //     let badge_color = 'badge-primary';
    //     $.ajax({
    //         url: "{{ route('search-dn.post')}}",
    //         method: 'POST',
    //         data:{
    //             _token:token, 
    //             msisdn:msisdn
    //             },
    //         success: function(data){
    //             console.log(data);
    //             $('#data-dn').removeClass('d-none');
    //             $('#content-offers').removeClass('d-none');
                
    //             list+='<li class="list-group-item d-flex justify-content-between align-items-center">MSISDN: <span class="badge label label-primary"> '+data.MSISDN+'</span></li>';
    //             list+='<li class="list-group-item d-flex justify-content-between align-items-center">PUK: <span class="badge label label-primary"> '+data.puk+'</span></li>';
    //             list+='<li class="list-group-item d-flex justify-content-between align-items-center">PIN: <span class="badge label label-primary"> '+data.pin+'</span></li>';
    //             list+='<li class="list-group-item d-flex justify-content-between align-items-center">Producto: <span class="badge label label-primary"> '+data.producto+'</span></li>';
    //             if(data.status == 'taken') {
    //                 badge_color = 'label label-danger';
    //                 $('#icc_id').val('');
    //                 $('#msisdn').val('');
    //             }else if(data.status == 'available'){
    //                 badge_color = 'label label-success';
    //                 product = data.producto;
    //                 $('#icc_id').val(data.icc_id);
    //                 $('#msisdn').val(data.MSISDN);
    //             }else{
    //                 badge_color = 'label label-warning';
    //                 product = data.producto;
    //                 $('#icc_id').val(data.icc_id);
    //                 $('#msisdn').val(data.MSISDN);
    //             }
    //             list+='<li class="list-group-item d-flex justify-content-between align-items-center">Estado: <span class="badge '+badge_color+'"> '+data.status+'</span></li>';

    //             $('#data-dn-list').html(list);
    //             getRates(product);
    //             // console.log("product:",product);
    //             // return false;
    //         }
    //     });
    // });

    // $('#imei').keyup(function(){
        
    //     let imei = $(this).val();
    //     // let imei = $('#imei').val();
    //     console.log(imei)
    //     let price_device = 0;
    //     let price_rate = $('#price_rate').val();
    //     let total = 0;
        
    //     if(imei.length >= 15){
    //         $.ajax({
    //             url: "{{route('getImei.get')}}",
    //             data: {imei:imei},
    //             success: function(data){
    //                 price_device = data.price;

    //                 total = parseFloat(price_device)+parseFloat(price_rate);
                
    //                 $('#monto').val(total);
    //                 if(promo_boolean_global == 1){
    //                     console.log('Promo activa');
    //                     $('#price_device').val(device_price_global);
    //                     $('#label-device').html('Dispositivo: $'+parseFloat(device_price_global).toFixed(2));
    //                 }else{
    //                     console.log('Promo inactiva');
    //                     $('#price_device').val(data.price);
    //                     $('#label-device').html('Dispositivo: $'+data.price.toFixed(2));
    //                 }
                    
                    
    //                 $('#label-total').html('Total a Cobrar: $'+total.toFixed(2));
    //             }
    //         });
    //     }else{
    //         $('#price_device').val(0);
    //         total = 0+parseFloat(price_rate);
    //         $('#label-device').html('Dispositivo: $0.00');
    //         $('#label-total').html('Total a Cobrar: $'+total.toFixed(2));
    //         $('#monto').val(total);
    //     }
    // });

        // $('#offers').change(function(){
    //     let valor = $(this).val();
    //     console.log("valor",valor);
    //     let rate_id = $('#offers option:selected').attr('data-rate-id');
    //     let rate_name =  $('#offers option:selected').attr('data-plan-name');
    //     let rate_price =  $('#offers option:selected').attr('data-plan-price');
    //     let product = $('#offers option:selected').attr('data-product');
    //     let promo_bool = $('#offers option:selected').attr('data-promo-bool');
    //     let device_price = $('#offers option:selected').attr('data-device-price');
    //     let token = $('meta[name="csrf-token"]').attr('content');
    //     let options = '<option value="0">Choose...</option>';

    //     console.log('Boolean promo: '+promo_bool);
    //     console.log('Device price: '+device_price);

    //     promo_boolean_global = promo_bool;
    //     device_price_global = device_price;
    
    //     rate_price = parseFloat(rate_price);
    //     console.log(product);

    //     if(valor == 0){
    //         $('#content-politics').addClass('d-none');
    //         $('#politics').html(options);
    //     }else{
    //         rate_name = rate_name.toLowerCase();
    //         if (rate_name.includes('alianza')){
    //         $('#altcel_content').removeClass('d-none');
    //         }else{
    //             $('#altcel_content').addClass('d-none');
    //         }

    //         if(product == 'HBB'){
    //             $('#coordinates').removeClass('d-none');
    //         }else{
    //             $('#coordinates').addClass('d-none');
    //             $('#lat_hbb').val('');
    //             $('#lng_hbb').val('');
    //         }

    //         $('#content-politics').removeClass('d-none');
    //         $.ajax({
    //             url: "{{ route('get-politics-rates.post')}}",
    //             method: 'POST',
    //             data:{
    //                 _token:token, 
    //                 },
    //             success: function(data){
    //                 data.forEach(function(element){
    //                     let porcent = element.porcent/100;
    //                     let cobro = rate_price*porcent;
    //                     options+="<option value='"+cobro+"' >"+element.description+"</option>"
    //                 });
    //                 $('#politics').html(options);
    //             }
    //         });
    //     }
    // });

    /**
     *
     * 
     * 
    **/
    
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
                // console.log(data);
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

    function imeis(imei){
        let price_device = 0;
        let price_rate = $('#price_rate').val();
        let total = 0;
        $.ajax({
                url: "{{route('getImei.get')}}",
                data: {imei:imei},
                success: function(data){
                    price_device = data.price;

                    total = parseFloat(price_device)+parseFloat(price_rate);
                
                    $('#monto').val(total);
                    if(promo_boolean_global == 1){
                        console.log('Promo activa');
                        $('#price_device').val(device_price_global);
                        $('#label-device').html('Dispositivo: $'+parseFloat(device_price_global).toFixed(2));
                    }else{
                        console.log('Promo inactiva');
                        $('#price_device').val(data.price);
                        $('#label-device').html('Dispositivo: $'+data.price.toFixed(2));
                    }
                    
                    
                    $('#label-total').html('Total a Cobrar: $'+total.toFixed(2));
                }
            });
    }
    function valors(valor){
        
        let rate_id = $('#offers option:selected').attr('data-rate-id');
        let rate_name =  $('#offers option:selected').attr('data-plan-name');
        let rate_price =  $('#offers option:selected').attr('data-plan-price');
        let product = $('#offers option:selected').attr('data-product');
        let promo_bool = $('#offers option:selected').attr('data-promo-bool');
        let device_price = $('#offers option:selected').attr('data-device-price');
        let token = $('meta[name="csrf-token"]').attr('content');
        let options = '<option value="0">Choose...</option>';

        console.log('Boolean promo: '+promo_bool);
        console.log('Device price: '+device_price);

        promo_boolean_global = promo_bool;
        device_price_global = device_price;
    
        rate_price = parseFloat(rate_price);
        console.log(product);

        if(valor == 0){
            $('#content-politics').addClass('d-none');
            $('#politics').html(options);
        }else{
            rate_name = rate_name.toLowerCase();
            if (rate_name.includes('alianza')){
            $('#altcel_content').removeClass('d-none');
            }else{
                $('#altcel_content').addClass('d-none');
            }

            if(product == 'HBB'){
                $('#coordinates').removeClass('d-none');
            }else{
                $('#coordinates').addClass('d-none');
                $('#lat_hbb').val('');
                $('#lng_hbb').val('');
            }

            $('#content-politics').removeClass('d-none');
            $.ajax({
                url: "{{ route('get-politics-rates.post')}}",
                method: 'POST',
                data:{
                    _token:token, 
                    },
                success: function(data){
                    data.forEach(function(element){
                        let porcent = element.porcent/100;
                        let cobro = rate_price*porcent;
                        options+="<option value='"+cobro+"' >"+element.description+"</option>"
                    });
                    $('#politics').html(options);
                }
            });
        }
    }


    $('#icc-to-search').keyup(function(){
        let msisdn = $(this).val();

        if(msisdn.length == 20){
            msisdns(msisdn);
        }
   
    });

    $(document).ready(function(){
        let msisdn = $('#icc-to-search').val();

        if(msisdn.length != 0){
            msisdns(msisdn);
        }
    });


    $('#imei').keyup(function(){

        let imei = $(this).val();

        if(imei.length >= 15){
            imeis(imei);
        

        }else{
            $('#price_device').val(0);
            total = 0+parseFloat(price_rate);
            $('#label-device').html('Dispositivo: $0.00');
            $('#label-total').html('Total a Cobrar: $'+total.toFixed(2));
            $('#monto').val(total);
        }
    });

    $(document).ready(function(){
        let imei = $('#imei').val();
        // console.log("imei",imei)
        if(imei.length != 0){
            imeis(imei);
        }else{
            $('#price_device').val(0);
            total = 0+parseFloat(price_rate);
            $('#label-device').html('Dispositivo: $0.00');
            $('#label-total').html('Total a Cobrar: $'+total.toFixed(2));
            $('#monto').val(total);
        }
    });

    $('#offers').change(function(){
        let valor = $(this).val();
        console.log("valor",valor);
        valors(valor);

    });

    /**
     *
     * 
     * 
    **/

    var altcel;
    var promo_boolean_global = 0;
    var device_price_global = 0;

    $('#mac_address_activation').keyup(function(){
        this.value = 
            (this.value.toUpperCase()
            .replace(/[^\d|A-Z]/g, '')
            .match(/.{1,2}/g) || [])
            .join(":");

            let valor = $(this).val();

            let regex = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/;
            let tag   = document.getElementById('tag');
            if( regex.test( valor ) ) {
                $('#content-MAC').removeClass('has-error');
                $('#content-MAC').addClass('has-success');
                $('#mac_address_boolean').val(1);
            } else {
                $('#content-MAC').removeClass('has-success');
                $('#content-MAC').addClass('has-error');
                $('#mac_address_boolean').val(0);
            }
    });

    $('#date-pay').click(function(){
        let x = $('#input').val();
        let token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
                url: "{{ route('date-pay')}}",
                method: "POST",
                data: {z:x,_token:token},
                success: function(data){
                    console.log(data);
                    
                }
            });
    });

    $('#new_address').keyup(function(){
        let myValue = $(this).val();
        console.log(myValue);
        myValue = myValue.replace(/#/g,'No. ');
        $('#new_address').val(myValue);
    });


    $('#rfc, #rfc_ethernet, #new_rfc').keyup(function(){
        let rfc = $(this).val();
        let anio = rfc.substring(4,6);
        let mes = rfc.substring(6,8);
        let dia = rfc.substring(8,10);
        let date = '';
        let id = $(this).attr('id');

        if(rfc.length == 10){
            anio = new Date(anio);
            anio = anio.getFullYear();
            date = anio+'-'+mes+'-'+dia;

            if(id == 'rfc'){
                $('#date_born').val(date);
            }else if(id == 'rfc_ethernet'){
                $('#date_born_ethernet').val(date);
            }else if(id == 'new_rfc'){
                $('#new_date_born').val(date);
            }
        }
    });


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


    $('#politics').change(function(){
        let monto = $(this).val();
        let price_device = $('#price_device').val();
        let imei = $('#imei').val();
        let total = 0;

        if(imei.length == 0 || /^\s+$/.test(imei)){
            price_device = 0;
            price_device = parseFloat(price_device);

            total = parseFloat(total);
            monto = parseFloat(monto);

            total = monto+price_device;
            console.log('Total + Device: '+total);

            $('#monto').val(total);
            $('#price_rate').val(monto);
            $('#label-rate').html('Tarifa: $'+monto.toFixed(2));
            $('#label-total').html('Total a Cobrar: $'+total.toFixed(2));

        }else{
            if(imei.length >= 15){
                $.ajax({
                    url: "{{route('getImei.get')}}",
                    data: {imei:imei},
                    success: function(data){
                        // price_device = data.price;
                        
                        if(promo_boolean_global == 1){
                            price_device = device_price_global;
                            $('#price_device').val(device_price_global);
                            $('#label-device').html('Dispositivo: $'+parseFloat(device_price_global).toFixed(2));
                            console.log('Promo activa: $'+price_device);
                        }else{
                            // console.log('Promo inactiva');
                            price_device = data.price;
                            $('#price_device').val(data.price);
                            $('#label-device').html('Dispositivo: $'+parseFloat(price_device).toFixed(2));
                            console.log('Promo inactiva: $'+price_device);
                        }

                        total = parseFloat(total);
                        monto = parseFloat(monto);

                        console.log('Total: '+total);
                        console.log('Monto: '+monto);

                        price_device = parseFloat(price_device);
                        console.log('Device price: '+price_device);

                        total = monto+price_device;
                        console.log('Total + Device: '+total);
                        $('#monto').val(total);
                        $('#price_rate').val(monto);
                        $('#label-rate').html('Tarifa: $'+monto.toFixed(2));
                        $('#label-total').html('Total a Cobrar: $'+total.toFixed(2));

                    }
                });
            }else{
                price_device = 0;

                total = parseFloat(total);
                monto = parseFloat(monto);

                console.log('Total: '+total);
                console.log('Monto: '+monto);

                price_device = parseFloat(price_device);
                console.log('Device price: '+price_device);

                total = monto+price_device;
                console.log('Total + Device: '+total);
                $('#monto').val(total);
                $('#price_rate').val(monto);
                $('#label-rate').html('Tarifa: $'+monto.toFixed(2));
                $('#label-total').html('Total a Cobrar: $'+total.toFixed(2));
            }
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

        let name_child = $('#name_child').val();
        let lastname_child = $('#lastname_child').val();
        let address_child = $('#address_child').val();
        let email_child = $('#email_child').val();
        let cellphone_child = $('#cellphone_child').val();
        let rfc_child = $('#rfc_child').val();
        let date_born_child = $('#date_born_child').val();
        let ine_code_child = $('#ine_code_child').val();
        let type_person = '';

        let imei = $('#imei').val();
        let serial_number = $('#serial_number').val();
        let mac_address = $('#mac_address_activation').val();
        let mac_address_boolean = $('#mac_address_boolean').val();
        let offer = $('#offers').val();
        let rate =  $('#offers option:selected').attr('data-rate-id');
        let rate_name =  $('#offers option:selected').attr('data-plan-name');
        let rate_recurrency =  $('#offers option:selected').attr('data-plan-recurrency');
        let product =  $('#offers option:selected').attr('data-product');
        let icc_id = $('#icc_id').val();
        let msisdn = $('#msisdn').val();
        let lat_hbb = $('#lat_hbb').val();
        let lng_hbb = $('#lng_hbb').val();
        let sim_altcel = $('#sim_altcel').val();
        let from = 'self';
        let monto = $('#monto').val();
        let amount_device = $('#price_device').val();
        let amount_rate = $('#price_rate').val();
        let token = $('meta[name="csrf-token"]').attr('content');
        let who_did_id = $('#user').val();
        let scheduleDateFirst = $('#scheduleDate').val();
        let scheduleDate = scheduleDateFirst.replace(/-/g, "");
        let email_not = 0;
        let activate = 0;
        let statusActivation = 'activated';
        let petition = $('#petition_id').val();
        let flag_rate = $('#flag_rate').val();
        let rate_subsequent = $('#rate_subsequent').val();
        // console.log(name+' - '+lastname+' - '+address+' - '+email+' - '+ine_code+' - '+imei+' - '+offer+' - '+rate);

        if(mac_address.length == 0 || /^\s+$/.test(mac_address)){

        }else{
            if(mac_address_boolean == 0){
                let message = "Ingrese una dirección MAC válida..";
                sweetAlertFunction(message);
                document.getElementById('mac_address_activation').focus();
                return false;
            }
        }
        
        if(petition == 0){
            petition = '';
        }

        if(scheduleDateFirst.length == 0 || /^\s+$/.test(scheduleDateFirst)){
            // scheduleDate = '';
            let message = "El campo Fecha Operación no debe ir vacío.";
            sweetAlertFunction(message);
            document.getElementById('scheduleDate').focus();
            return false;
        }

        if($('#statusActivation').prop('checked') ) {
            statusActivation = 'preactivated';
        }else{
            statusActivation = 'activated';
        }

        if($('#type_person_mifi').prop('checked') ) {
            type_person = 'moral';
        }else{
            type_person = 'física';
        }

        if($('#email-not').prop('checked') ) {
            email_not = 1;
        }else{
            email_not = 0;
        }

        if($('#activate_bool').prop('checked') ) {
            activate_bool = 1;
        }else{
            activate_bool = 0;
        }

        if(product != 'HBB'){
            lat_hbb = null;
            lng_hbb = null;
        }else{
            if(lat_hbb.length == 0 || /^\s+$/.test(lat_hbb)){
                let message = "Ingrese latitud, no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('lat_hbb').focus();
                return false;
            }

            if(lng_hbb.length == 0 || /^\s+$/.test(lng_hbb)){
                let message = "Ingrese longitud, no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('lng_hbb').focus();
                return false;
            }
        }
        
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

        if(rfc.length == 0 || /^\s+$/.test(rfc)){
            let message = "El campo RFC no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('rfc').focus();
            return false;
        }

        if(date_born.length == 0 || /^\s+$/.test(date_born)){
            let message = "El campo Fecha Nacimiento no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('date_born').focus();
            return false;
        }

        if(address.length == 0 || /^\s+$/.test(address)){
            let message = "El campo Dirección no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('address').focus();
            return false;
        }

        if(email.length == 0 || /^\s+$/.test(email)){
            let message = "El campo Email no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('email').focus();
            return false;
        }

        if(cellphone.length == 0 || /^\s+$/.test(cellphone)){
            let message = "El campo Teléfono Contacto no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('cellphone').focus();
            return false;
        }

        if(ine_code.length == 0 || /^\s+$/.test(ine_code)){
            let message = "El campo Código INE no puede estar vacío.";
            sweetAlertFunction(message);
            document.getElementById('ine_code').focus();
            return false;
        }

        if(icc_id.length == 0 || /^\s+$/.test(icc_id)){
            let message = "El campo ICC_ID no puede estar vacío, por favor busque un SIM.";
            sweetAlertFunction(message);
            document.getElementById('icc-to-search').focus();
            return false;
        }

        if(msisdn.length == 0 || /^\s+$/.test(msisdn)){
            let message = "El campo MSISDN no puede estar vacío, por favor busque un SIM.";
            sweetAlertFunction(message);
            document.getElementById('msisdn').focus();
            return false;
        }

        if(imei.length == 0 || /^\s+$/.test(imei)){
            imei = 'null';
        }

        rate_name = rate_name.toLowerCase();

        if(rate_name.includes('alianza')){
            if(sim_altcel.length == 0 || /^\s+$/.test(sim_altcel)){
                let message = "Parece que has elegido un Plan Alianza, por favor completa el campo Sim.";
                sweetAlertFunction(message);
                document.getElementById('sim_altcel').focus();
                return false;
            }
        }else{
            sim_altcel = 'nothing';
        }
        $(this).attr('disabled',true);

        Swal.fire({
            title: 'Realizando activación...',
            html: 'Espera un poco, un poquito más...',
            didOpen: () => {
                Swal.showLoading();
            $.ajax({
                    url: "{{ route('activation-general.post')}}",
                    method: 'GET',
                    data:{
                        _token:token, 
                        name:name,
                        lastname:lastname,
                        address:address,
                        email:email,
                        cellphone:cellphone,
                        ine_code:ine_code,
                        rfc: rfc,
                        date_born: date_born,
                        name_child:name_child,
                        lastname_child:lastname_child,
                        address_child:address_child,
                        email_child:email_child,
                        cellphone_child:cellphone_child,
                        ine_code_child:ine_code_child,
                        rfc_child: rfc_child,
                        date_born_child: date_born_child,
                        type_person:type_person,
                        imei:imei,
                        serial_number:serial_number,
                        mac_address:mac_address,
                        offer_id:offer,
                        rate_id:rate,
                        icc_id:icc_id,
                        msisdn:msisdn,
                        lat_hbb: lat_hbb,
                        lng_hbb: lng_hbb,
                        product: product,
                        from: from,
                        sim_altcel: sim_altcel,
                        rate_recurrency: rate_recurrency,
                        price: monto,
                        price_device: amount_device,
                        price_rate: amount_rate,
                        who_did_id: who_did_id,
                        email_not: email_not,
                        activate_bool: activate_bool,
                        scheduleDate:scheduleDate,
                        statusActivation:statusActivation,
                        petition:petition,
                        promo_boolean:promo_boolean_global,
                        flag_rate:flag_rate,
                        rate_subsequent:rate_subsequent
                        },
                    success: function(data){
                        if(data.activation_id){
                            let url = "{{route('formatDelivery',['activation'=>'temp'])}}";
                            url = url.replace('temp',data.activation_id);
                            // window.open(url, '_blank');
                            window.open(url,'','width=600,height=400,left=50,top=50,toolbar=yes');

                            Swal.fire({
                                icon: 'success',
                                title: 'Activación hecha con éxito.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#send').attr('disabled',false);
                            setTimeout(function(){ location.href = "{{route('activations.create')}}"; }, 1500);
                            
                        }else if(data == 1){
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Activación hecha con éxito.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#send').attr('disabled',false);
                            setTimeout(function(){ location.href = "{{route('activations.create')}}"; }, 1500);
                        }else if(data == 0){
                            Swal.fire({
                                icon: 'error',
                                title: 'Hubo un error con la activación.',
                                showConfirmButton: false,
                                timer: 1500
                            })

                            return false;
                        }else if(data == 2){
                            Swal.fire({
                                icon: 'error',
                                title: 'Hubo un error con la activación.',
                                text: 'No se encontró el MSISDN...',
                                showConfirmButton: false,
                                timer: 1500
                            })

                            return false;
                        }else if(data == 3){
                            Swal.fire({
                                icon: 'error',
                                title: 'Hubo un error con la activación.',
                                text: 'Sin obtención de token de acceso, consulte a Soporte Técnico.',
                                showConfirmButton: false,
                                timer: 1500
                            })

                            return false;
                        }else{
                            // data = JSON.stringify(data);
                            
                            altcel = data;
                            if (data.simAltcel) {
                                console.log(data.simAltcel[0])
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ocurrió lo siguiente',
                                    html: data.simAltcel[0],
                                })
                            }else if (data.MSISDNAltcel2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ocurrió lo siguiente',
                                    html: data.MSISDNAltcel2[0],
                                })
                            }
                            console.log(data);
                            return false;
                        }
                        console.log(data);
                    
                    }
                });
            }
        });
    });

    $('#pack').change(function(){
        let pack_id = $(this).val();
        let politicFlag = 2;
        let amountInstall = $('#pack option:selected').attr('data-install');
        let service = $('#pack option:selected').attr('data-service');
        let price = $('#pack option:selected').attr('data-price');
        let token = $('meta[name="csrf-token"]').attr('content');
        let options = '<option value="0">Choose...</option>';
        price = parseFloat(price);
        
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

    $('#moralPersons').change(function(){
        let name = $('#moralPersons option:selected').attr('data-name');
        let rfc = $('#moralPersons option:selected').attr('data-rfc');
        let address = $('#moralPersons option:selected').attr('data-address');
        let cellphone = $('#moralPersons option:selected').attr('data-cellphone');

        $('#name_child').val(name);
        $('#rfc_child').val(rfc);
        $('#address_child').val(address);
        $('#cellphone_child').val(cellphone);
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
        let number = $('#number_install').val();
        let token = $('meta[name="csrf-token"]').attr('content');

        let name = $('#name_ethernet').val();
        let lastname = $('#lastname_ethernet').val();
        let rfc = $('#rfc_ethernet').val();
        let date_born = $('#date_born_ethernet').val();
        let client_address = $('#address_ethernet').val();
        let ine_code = $('#ine_code_ethernet').val();
        let email = $('#email_ethernet').val();
        let cellphone = $('#cellphone_ethernet').val();

        let name_child = $('#name_ethernet_child').val();
        let lastname_child = $('#lastname_ethernet_child').val();
        let rfc_child = $('#rfc_ethernet_child').val();
        let date_born_child = $('#date_born_ethernet_child').val();
        let client_address_child = $('#address_ethernet_child').val();
        let ine_code_child = $('#ine_code_ethernet_child').val();
        let email_child = $('#email_ethernet_child').val();
        let cellphone_child = $('#cellphone_ethernet_child').val();
        let type_person = '';
        let email_not = 0;

        if($('#type_person').prop('checked') ) {
            type_person = 'moral';
        }else{
            type_person = 'física';
        }

        if($('#email-not-ethernet').prop('checked') ) {
            email_not = 1;
        }else{
            email_not = 0;
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
                let message = "El campo IP Address Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('lat').focus();
                return false;
            }

            if(lng.length == 0 || /^\s+$/.test(lng)){
                let message = "El campo IP Address Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('lng').focus();
                return false;
            }

            if(address.length == 0 || /^\s+$/.test(address)){
                let message = "El campo IP Address Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('address_antena').focus();
                return false;
            }

            if(no_serie_router.length == 0 || /^\s+$/.test(no_serie_router)){
                let message = "El campo IP No. Serie Router Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('no_serie_router_antena').focus();
                return false;
            }

            if(mac_address_router.length == 0 || /^\s+$/.test(mac_address_router)){
                let message = "El campo IP MAC Address Router Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('mac_address_router_antena').focus();
                return false;
            }

            if(model_router.length == 0 || /^\s+$/.test(model_router)){
                let message = "El campo IP MAC Address Router Antena no puede estar vacío.";
                sweetAlertFunction(message);
                document.getElementById('model_router_antena').focus();
                return false;
            }

            if(radiobase_id == 0){
                let message = "Elija una Radiobase.";
                sweetAlertFunction(message);
                return false;
            }

            if(pack_id == 0){
                let message = "Elija un Paquete.";
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
                name_child: name_child,
                lastname_child: lastname_child,
                rfc_child: rfc_child,
                date_born_child: date_born_child,
                client_address_child: client_address_child,
                ine_code_child: ine_code_child,
                email_child: email_child,
                cellphone_child: cellphone_child,
                type_person: type_person,
                amount: amount,
                amount_install: amount_install,
                amount_total: amount_total,
                pack_service: pack_service,
                schedule_flag: 0,
                email_not: email_not,
                number:number
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
                        element => options+='<option value="'+element.user_id+'" data-name="'+element.name+'" data-lastname="'+element.lastname+'" data-email="'+element.email+'" data-rfc="'+element.rfc+'" data-date_born="'+element.date_born+'" data-address="'+element.address+'" data-ine_code="'+element.ine_code+'" data-cellphone="'+element.cellphone+'">'+element.name+' - '+element.email+'</options>'
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

    function sweetAlertFunction(message){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
            showConfirmButton: false,
            timer: 2000
        });
    }

    $('#send_client').click(function(){
        let name = $('#new_name').val();
        let lastname = $('#new_lastname').val();
        let rfc = $('#new_rfc').val();
        let date_born = $('#new_date_born').val();
        let address = $('#new_address').val();
        let email = $('#new_email').val();
        let ine_code = $('#new_ine_code').val();
        let cellphone = $('#new_cellphone').val();
        let interests = $('#interests').val();
        let user_id = $('#new_user').val();

        $.ajax({
            url: "{{ route('addClientAsync.get')}}",
            data:{name:name,
                  lastname:lastname,
                  rfc:rfc,
                  date_born:date_born,
                  address:address,
                  email:email,
                  ine_code:ine_code,
                  cellphone:cellphone,
                  interests:interests,
                  user_id:user_id},
            success: function(data){
                if(data.error == 0){
                    new PNotify({
                        title: 'Hecho.',
                        text: "Añadido con éxito.",
                        type: 'success',
                        icon: 'fa fa-check'
                    });
                }else if(data.error == 1){
                    new PNotify({
                        title: 'Ooops!',
                        text: data.message,
                        type: 'error',
                        icon: 'fa fa-times'
                    });
                }
            }
        });
    });
</script>
@endsection