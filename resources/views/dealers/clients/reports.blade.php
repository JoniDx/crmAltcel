@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>reportes de Consumos</h2>
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

<div class="col-md-12 mb-md" id="msisdn-select">
    <label>Clientes</label>
    <select data-plugin-selectTwo class="form-control populate" id="clients"  onchange="getData()">
        <optgroup label="Clientes disponibles">
        <option value="0">Elige...</option>
        @foreach($clients as $client)
        <option value="{{$client->MSISDN}}">
            {{$client->MSISDN.' - '.$client->service.' - '.$client->name.' '.$client->lastname}}
        </option>
        @endforeach
        </optgroup>
        
    </select>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Funciones</h2>
            </header>

            <div class="panel-body">
                <form class="form-horizontal form-bordered">
                    @csrf
                    <div class="form-group" style="padding-right: 1rem; padding-left: 1rem;">
                        <div class="col md-12">
                            <div class="row">
                                <div class="radio col-md-2">
                                    <label for="datosIndividual">
                                        <input class="option" type="radio" data-type="datosIndividual" name="optionsRadios" id="datosIndividual" value="Datos Individual">
                                        Consumos de Datos Individual
                                    </label>
                                </div>
                                <div class="radio col-md-2">
                                    <label for="datosGeneral">
                                        <input class="option" type="radio" data-type="datosgeneral" name="optionsRadios" id="datosGeneral" value="Datos General">
                                        Consumos de Datos General
                                    </label>
                                </div>
                                <div class="radio col-md-2">
                                    <label for="smsIndividual">
                                        <input class="option" type="radio" data-type="smsIndividual" name="optionsRadios" id="smsIndividual" value="SMS Individual">
                                        Consumos de SMS Individual
                                    </label>
                                </div>
                                <div class="radio col-md-2">
                                    <label for="smsGeneral">
                                        <input class="option" type="radio" data-type="smsGeneral" name="optionsRadios" id="smsGeneral" value="SMS General">
                                        Consumos de SMS General
                                    </label>
                                </div>
                                <div class="radio col-md-2">
                                    <label for="minIndividual">
                                        <input class="option" type="radio" data-type="minIndividual" name="optionsRadios" id="minIndividual" value="Minutos Individual">
                                        Consumos de Minutos Individual
                                    </label>
                                </div>
                                <div class="radio col-md-2">
                                    <label for="minGeneral">
                                        <input class="option" type="radio" data-type="minGeneral" name="optionsRadios" id="minGeneral" value="Minutos General">
                                        Consumos de Minutos General
                                    </label>
                                </div>
                                <div class="radio col-md-2">
                                    <label for="datosAnual">
                                        <input class="option" type="radio" data-type="datosAnual" name="optionsRadios" id="datosAnual" value="Datos Mensual">
                                        Consumos de Datos Mensuales
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!--Individual -->
        <div class="col-md-12 d-none" id="individual">
            <section class="panel form-wizard" >
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>
    
                    <h2 class="panel-title" id="textIndividual"></h2>
                </header>
                <div class="panel-body">
                    
                    <form class="form-horizontal" novalidate="novalidate" method="GET" action="{{url('consumos-export-excel')}}">
                        <div class="tab-content">     
                            <div class="input-group mb-md col-md-4">
                                <label for="MSISDNconsumos">MSISDN</label>
                                <input type="text" name="MSISDN" class="form-control" id="MSISDNconsumos" maxlength="10">
                            </div>
                            <div class="input-group mb-md col-md-4">
                                <label class="">Fecha</label>
                                <div class="input-daterange input-group" data-plugin-datepicker>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input autocomplete="off" type="text" class="form-control" id="start_date" name="start_date">
                                    <span class="input-group-addon">a</span>
                                    <input autocomplete="off" type="text" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>
                            <input type="hidden" id="type" name="type">
                            <button class="btn btn-success" type="button" id="btnIndividual"><li class="fa fa-arrow-circle-right"></li></button>
                        </div>
                        <div class="panel-body table-individual">
                            <button class="btn btn-primary"><i class="fa fa-cloud-download"></i> Consumos</button>
                            <hr>
                            <table class="table table-bordered table-striped mb-none " id="datatable-default">
                                <thead>
                                    <tr>
                                        <th class="text-left">Fecha</th>
                                        <th class="text-left">Consumos</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpo-table"></tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <!--End Individual -->

        <!--General-->
        <div class="col-md-12 d-none" id="general">
            <section class="panel form-wizard" >
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>
    
                    <h2 class="panel-title" id="textGeneral"></h2>
                </header>
                <div class="panel-body">
                    <form class="form-horizontal" novalidate="novalidate" method="GET" action="{{url('consumos-general-export-excel')}}">
                        <div class="tab-content">   
                            <div class="input-group mb-md col-md-4">
                                <label class="">Fecha</label>
                                <div class="input-daterange input-group" data-plugin-datepicker>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input autocomplete="off" type="text" class="form-control" id="start_dateG" name="start_dateG">
                                    <span class="input-group-addon">a</span>
                                    <input autocomplete="off" type="text" class="form-control" id="end_dateG" name="end_dateG">
                                </div>
                            </div>
                            <input type="hidden" id="type-general" name="type">
                            <button class="btn btn-success" type="button" id="btnGeneral"><li class="fa fa-arrow-circle-right"></li></button>
                        </div>
                        <div class="panel-body table-general">
                            <button class="btn btn-primary"><i class="fa fa-cloud-download"></i> Consumos</button>
                            <hr>
                            <table class="table table-bordered table-striped mb-none " id="datatable-default">
                                <thead>
                                    <tr>
                                        <th class="text-left">Fecha</th>
                                        <th class="text-left">MSISDN</th>
                                        <th class="text-left">Consumos</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpo-table-general"></tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </section>
            

        </div>
        <!--End General-->
    </div>
</div>

<script>
    $('.option').click(function(){
        let valor = $(this).val();
        let type = $(this).attr('data-type');
        console.log(valor);
        if (valor == 'Datos Individual') {
            $('#textIndividual').html(valor);
            $('#type').val(type);
            $('#individual').removeClass('d-none');
            $('#general').addClass('d-none');
            $('.table-general').addClass('d-none');
            $('.table-individual').addClass('d-none');
        }else if (valor == 'Datos General') {
            $('#textGeneral').html(valor)
            $('#type-general').val(type);
            $('#individual').addClass('d-none');
            $('#general').removeClass('d-none');
            $('.table-general').addClass('d-none');
            $('.table-individual').addClass('d-none');
        }else if (valor == 'SMS Individual') {
            $('#textIndividual').html(valor);
            $('#type').val(type);
            $('#individual').removeClass('d-none');
            $('#general').addClass('d-none');
            $('.table-general').addClass('d-none');
            $('.table-individual').addClass('d-none');
        }else if (valor == 'SMS General') {
            $('#textGeneral').html(valor)
            $('#type-general').val(type);
            $('#individual').addClass('d-none');
            $('#general').removeClass('d-none');
            $('.table-general').addClass('d-none');
        }else if (valor == 'Minutos Individual') {
            $('#textIndividual').html(valor);
            $('#type').val(type);
            $('#individual').removeClass('d-none');
            $('#general').addClass('d-none');
            $('.table-general').addClass('d-none');
            $('.table-individual').addClass('d-none');
        }else if (valor == 'Minutos General') {
            $('#textGeneral').html(valor)
            $('#type-general').val(type);
            $('#individual').addClass('d-none');
            $('#general').removeClass('d-none');
            $('.table-general').addClass('d-none');
            $('.table-individual').addClass('d-none');
        }else if(valor == 'Datos Mensual'){
            $('#textGeneral').html(valor)
            $('#type-general').val(type);
            $('#individual').addClass('d-none');
            $('#general').removeClass('d-none');
            $('.table-general').addClass('d-none');
            $('.table-individual').addClass('d-none');
        }
    })

    $('#btnIndividual').click(function(){
        let contenido = '';
        let type = $('#type').val();
        let msisdn = $('#MSISDNconsumos').val();
        let date_start = $('#start_date').val();
        let date_end = $('#end_date').val();
        $.ajax({
            url: "{{route('consumos')}}",
            method:'GET',
            data: {type:type, msisdn:msisdn, date_start:date_start, date_end:date_end},
            beforeSend: function(){
                Swal.fire({
                    title: 'Extrayendo data...',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success:function(response){
                Swal.close();
                let typeS = response[0];
                let data = response[1];
                if (typeS == 'individual') {
                    $('.table-individual').removeClass('d-none');
                        data.forEach(function(element){
                            if(type == 'smsIndividual' || type == 'smsGeneral'){
                                contenido+="<tr><td>"+element.START_DATE+"</td><td>"+element.consumos+" SMS</td></tr>"
                            }else if(type == 'datosIndividual' || type == 'datosgeneral'){
                                contenido+="<tr><td>"+element.START_DATE+"</td><td>"+parseFloat(element.consumos).toFixed(4)+" MB</td></tr>"
                            }else if(type == 'minIndividual' || type == 'minGeneral'){
                                contenido+="<tr><td>"+element.START_DATE+"</td><td>"+parseFloat(element.consumos)/60+" Min</td></tr>"
                            }
                            
                    });
                }
                $('#cuerpo-table').html(contenido);
            }
        })
    });

    $('#btnGeneral').click(function(){
        let contenido = '';
        let type = $('#type-general').val();
        let date_start = $('#start_dateG').val();
        let date_end = $('#end_dateG').val();
        console.log(type);
        console.log(date_start);
        console.log(date_end);
        $.ajax({
            url: "{{route('consumos')}}",
            method: 'GET',
            data:{type:type, date_start:date_start, date_end:date_end},
            beforeSend: function(){
                Swal.fire({
                    title: 'Extrayendo data...',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success:function(response){
                Swal.close();
                let typeS = response[0];
                let data = response[1];
                if (typeS == 'general') {
                    $('.table-general').removeClass('d-none');
                        data.forEach(function(element){
                            
                            if(type == 'smsIndividual' || type == 'smsGeneral'){
                                contenido+="<tr><td>"+element.START_DATE+"</td><td>"+element.PRI_IDENTITY+"</td><td>"+element.consumos+" SMS</td></tr>"
                            }else if(type == 'datosIndividual' || type == 'datosgeneral' || 'datosAnual'){
                                contenido+="<tr><td>"+element.START_DATE+"</td><td>"+element.PRI_IDENTITY+"</td><td>"+parseFloat(element.consumos).toFixed(4)+" MB</td></tr>"
                            }else if(type == 'minIndividual' || type == 'minGeneral'){
                                contenido+="<tr><td>"+element.START_DATE+"</td><td>"+element.PRI_IDENTITY+"</td><td>"+parseFloat(element.consumos)/60+" Min</td></tr>"
                            }
                    });
                }
                $('#cuerpo-table-general').html(contenido);
                console.log(data);
            }
        })
    });
</script>
@endsection