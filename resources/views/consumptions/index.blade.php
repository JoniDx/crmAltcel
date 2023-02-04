@extends('layouts.octopus')
@section('content')
    <header class="page-header">
        <h2>Consumos Altan Redes</h2>
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

    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-semibold text-dark text-uppercase mb-md mt-lg">Diagnóstico de Consumos del Día</h5>
        </div>
        <div class="col-md-4 col-xl-12">
            <section class="panel">
                <div class="panel-body bg-secondary">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon">
                                <i class="fa fa-life-ring"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Datos Móviles</h4>
                                <div class="info">
                                    <strong class="amount" id="gbTag">0 GB</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-md-4 col-xl-12">
            <section class="panel">
                <div class="panel-body bg-tertiary">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon">
                                <i class="fa fa-life-ring"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Voz</h4>
                                <div class="info">
                                    <strong class="amount" id="minTag">0 Min</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-md-4 col-xl-12">
            <section class="panel">
                <div class="panel-body bg-primary">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon">
                                <i class="fa fa-life-ring"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">SMS</h4>
                                <div class="info">
                                    <strong class="amount" id="smsTag">0 SMS</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>

                    <h2 class="panel-title">Reportes</h2>
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
                                            Por Número <b>(DATOS MÓVILES)</b>
                                        </label>
                                    </div>
                                    <div class="radio col-md-2">
                                        <label for="datosGeneral">
                                            <input class="option" type="radio" data-type="datosgeneral" name="optionsRadios" id="datosGeneral" value="Datos General">
                                            General <b>(DATOS MÓVILES)</b>
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
                        
                            <div class="tab-content">    
                                <div class="row">
                                    <div class=" mb-md col-md-4">
                                        <label for="MSISDNconsumos">MSISDN</label>
                                        <input type="nummber" name="MSISDN" class="form-control" id="MSISDNconsumos" maxlength="10">
                                    </div>
                                    <div class=" mb-md col-md-4">
                                        <label for="priceUnity">Precio por Unidad de Medida(GB, Min, SMS)</label>
                                        <input type="number" name="priceUnity" class="form-control" id="priceUnity" value="0">
                                    </div>
                                    <div class=" mb-md col-md-4">
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
                                </div>
                                <section class="panel panel-featured-left panel-featured-success">
                                    <div class="panel-body">
                                        <div class="widget-summary widget-summary-sm">
                                            <div class="widget-summary-col widget-summary-col-icon">
                                                <div class="summary-icon bg-success">
                                                    <i class="fa fa-usd"></i>
                                                </div>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h4 class="title">Total en Dinero</h4>
                                                    <div class="info">
                                                        <strong class="amount" id="moneyIndividualTag">$0</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                
                                <input type="hidden" id="type" name="type">
                                <button class="btn btn-success" type="button" id="btnIndividual"><li class="fa fa-arrow-circle-right"></li></button>
                            </div>
                            <div class="panel-body table-individual">
                                <hr>
                                <table class="table table-bordered table-striped mb-none " id="datatable-individual">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Fecha</th>
                                            <th class="text-left">Consumos</th>
                                            <th class="text-left">Unidad Medida</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cuerpo-table"></tbody>
                                </table>
                            </div>
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
                            <div class="tab-content">
                                <div class="row">
                                    <div class=" mb-md col-md-4">
                                        <label for="priceUnityGeneral">Precio por Unidad de Medida(GB, Min, SMS)</label>
                                        <input type="number" name="priceUnityGeneral" class="form-control" id="priceUnityGeneral" value="0">
                                    </div>
                                    <div class=" mb-md col-md-4">
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
                                </div>
                                <section class="panel panel-featured-left panel-featured-success">
                                    <div class="panel-body">
                                        <div class="widget-summary widget-summary-sm">
                                            <div class="widget-summary-col widget-summary-col-icon">
                                                <div class="summary-icon bg-success">
                                                    <i class="fa fa-usd"></i>
                                                </div>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h4 class="title">Total en Dinero</h4>
                                                    <div class="info">
                                                        <strong class="amount" id="moneyGeneralTag">$0</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <input type="hidden" id="type-general" name="type">
                                <button class="btn btn-success" type="button" id="btnGeneral"><li class="fa fa-arrow-circle-right"></li></button>
                            </div>
                            <div class="panel-body table-general">
                                <hr>
                                <table class="table table-bordered table-striped mb-none " id="datatable-general">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Fecha</th>
                                            <th class="text-left">MSISDN</th>
                                            <th class="text-left">Consumos</th>
                                            <th class="text-left">Unidad Medida</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cuerpo-table-general"></tbody>
                                </table>
                            </div>
                    </div>
                </section>
                

            </div>
            <!--End General-->
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
        let gbDiagnostico = 0;
        let minDiagnostico = 0;
        let smsDiagnostico = 0;
        let acumuladoGeneral = 0;
        let acumulado = 0;
        
        $(document).ready(function(){ 
            let fecha = new Date();
            let anio = fecha.getFullYear();
            let dia = fecha.getDate();
            let mes = fecha.getMonth() + 1;

            dia = dia < 10 ? "0"+dia : dia;
            mes = mes < 10 ? "0"+mes : mes;

            let today = mes+"/"+dia+"/"+anio;

            getCDRSDocumentRedy("datosgeneral", today);
            getCDRSDocumentRedy("smsGeneral", today);
            getCDRSDocumentRedy("minGeneral", today);
        })

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
            let priceUnity = $("#priceUnity").val();
            let unityText = "";
            priceUnity = parseFloat(priceUnity);
            let sumatory = 0;
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

                    if(type == "datosIndividual"){
                        unityText = "GB";
                        sumatory = parseFloat(sumatory);
                    }else if(type == "smsIndividual"){
                        unityText = "SMS";
                        sumatory = parseInt(sumatory);
                    }else if(type == "minIndividual"){
                        unityText = "MIN";
                        sumatory = parseInt(sumatory);
                    }

                    if (typeS == 'individual') {
                        $('.table-individual').removeClass('d-none');
                            // data.forEach(function(element){
                            //     if(type == 'smsIndividual' || type == 'smsGeneral'){
                            //         contenido+="<tr><td>"+element.START_DATE+"</td><td>"+element.consumos+" SMS</td></tr>"
                            //     }else if(type == 'datosIndividual' || type == 'datosgeneral'){
                            //         contenido+="<tr><td>"+element.START_DATE+"</td><td>"+parseFloat(element.consumos).toFixed(4)+" MB</td></tr>"
                            //     }else if(type == 'minIndividual' || type == 'minGeneral'){
                            //         contenido+="<tr><td>"+element.START_DATE+"</td><td>"+element.consumos+" Min</td></tr>"
                            //     }
                                
                            // });

                            for (let index = 0; index < data.length; index++) {
                                if(type == "datosIndividual"){
                                    sumatory+=parseFloat(data[index]["consumos"]);
                                }else if(type == "smsIndividual"){
                                    sumatory+=parseInt(data[index]["consumos"]);
                                }else if(type == "minIndividual"){
                                    sumatory+=parseInt(data[index]["consumos"]);
                                }
                            }
                            sumatory = parseFloat(sumatory);
                            acumulado = sumatory*priceUnity;
                            $("#moneyIndividualTag").html("$"+parseFloat(acumulado).toFixed(2)+" por "+parseFloat(sumatory).toFixed(2)+" "+unityText+" a $"+parseFloat(priceUnity).toFixed(2)+" c/u");
                            
                            var datatableInit = function() {
                                    var $table = $('#datatable-individual');

                                    $table.DataTable({
                                        dom: 'Bfrtip',
                                        buttons: [{
                                            extend: 'excel',
                                            header: true,
                                            title: 'Consumos-'+type+'-'+msisdn+'-'+date_start+' - '+date_end,
                                            exportOptions : {
                                                columns: [ 0,1,2],
                                            }
                                        }],
                                        destroy: true,
                                        data: data,
                                        columns: [
                                            {title: "Fecha",data:"START_DATE"},
                                            {title: "Consumos",data:"consumos"},
                                            {title: "Unidad Medida",data:"UNIDAD"},
                                        ],
                                    });

                                };

                                $(function() {
                                    datatableInit();
                                });
                    }
                    // $('#cuerpo-table').html(contenido);
                }
            })
        });

        $('#btnGeneral').click(function(){
            let contenido = '';
            let type = $('#type-general').val();
            let date_start = $('#start_dateG').val();
            let date_end = $('#end_dateG').val();
            let priceUnity = $("#priceUnityGeneral").val();
            let unityText = "";
            priceUnity = parseFloat(priceUnity);
            let sumatory = 0;
            console.log(type, "TIPO");
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

                    if(type == "datosgeneral"){
                        unityText = "GB";
                        sumatory = parseFloat(sumatory);
                    }else if(type == "smsGeneral"){
                        unityText = "SMS";
                        sumatory = parseInt(sumatory);
                    }else if(type == "minGeneral"){
                        unityText = "MIN";
                        sumatory = parseInt(sumatory);
                    }

                    if (typeS == 'general') {
                        $('.table-general').removeClass('d-none');
                            // data.forEach(function(element){
                                
                            //     if(type == 'smsIndividual' || type == 'smsGeneral'){
                            //         contenido+="<tr><td>"+element.START_DATE+"</td><td>"+element.PRI_IDENTITY+"</td><td>"+element.consumos+" SMS</td></tr>"
                            //     }else if(type == 'datosIndividual' || type == 'datosgeneral' || 'datosAnual'){
                            //         contenido+="<tr><td>"+element.START_DATE+"</td><td>"+element.PRI_IDENTITY+"</td><td>"+parseFloat(element.consumos).toFixed(4)+" MB</td></tr>"
                            //     }else if(type == 'minIndividual' || type == 'minGeneral'){
                            //         contenido+="<tr><td>"+element.START_DATE+"</td><td>"+element.PRI_IDENTITY+"</td><td>"+element.consumos+" Min</td></tr>"
                            //     }
                            // });
                            for (let index = 0; index < data.length; index++) {
                                if(type == "datosgeneral"){
                                    sumatory+=parseFloat(data[index]["consumos"]);
                                }else if(type == "smsGeneral"){
                                    sumatory+=parseInt(data[index]["consumos"]);
                                }else if(type == "minGeneral"){
                                    sumatory+=parseInt(data[index]["consumos"]);
                                }
                            }
                            sumatory = parseFloat(sumatory);
                            acumulado = sumatory*priceUnity;
                            $("#moneyGeneralTag").html("$"+parseFloat(acumulado).toFixed(2)+" por "+parseFloat(sumatory).toFixed(2)+" "+unityText+" a $"+parseFloat(priceUnity).toFixed(2)+" c/u");

                            var datatableInit = function() {
                                    var $table = $('#datatable-general');

                                    $table.DataTable({
                                        dom: 'Bfrtip',
                                        buttons: [{
                                            extend: 'excel',
                                            header: true,
                                            title: 'Consumos-'+type+'-'+date_start+' - '+date_end,
                                            exportOptions : {
                                                columns: [ 0,1,2,3],
                                            }
                                        }],
                                        destroy: true,
                                        data: data,
                                        columns: [
                                            {title: "Fecha",data:"START_DATE"},
                                            {title: "MSISDN",data:"PRI_IDENTITY"},
                                            {title: "Consumos",data:"consumos"},
                                            {title: "Unidad Medida",data:"UNIDAD"},
                                        ],
                                    });

                                };

                                $(function() {
                                    datatableInit();
                                });
                    }
                    // $('#cuerpo-table-general').html(contenido);
                    console.log(data);
                }
            })
        });

        function getCDRSDocumentRedy(type, today){
            console.log(today,"HOY")
            $.ajax({
                url: "{{route('consumos')}}",
                method: 'GET',
                data:{type:type, date_start:today, date_end:today},
                beforeSend: function(){
                    swal_loading('Extrayendo datos para el diagnóstico del día...', 'Espera un poco, un poquito más...')
                },
                success:function(response){
                    console.log(response, "RESPUESTA DOCUMENT READY")
                    Swal.close();
                    let data = response[1];
                    gbDiagnostico = parseFloat(gbDiagnostico);
                    smsDiagnostico = parseInt(smsDiagnostico);
                    minDiagnostico = parseInt(minDiagnostico);

                    for (let index = 0; index < data.length; index++) {
                        if(type == "datosgeneral"){
                            gbDiagnostico+=parseFloat(data[index]["consumos"]);
                        }else if(type == "smsGeneral"){
                            smsDiagnostico+=parseInt(data[index]["consumos"]);
                        }else if(type == "minGeneral"){
                            minDiagnostico+=parseInt(data[index]["consumos"]);
                        }
                    }

                    if(type == "datosgeneral"){
                        $("#gbTag").html(gbDiagnostico.toFixed(2)+" GB");
                    }else if(type == "smsGeneral"){
                        $("#smsTag").html(smsDiagnostico+" SMS");
                    }else if(type == "minGeneral"){
                        $("#minTag").html(minDiagnostico+" Min");
                    }
                }
            })
        }
    </script>
@endsection