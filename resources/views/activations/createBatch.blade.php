@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Activaciones Batch</h2>
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
<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
        </div>

        <h2 class="panel-title">Activaciones Batch</h2>

    </header>
    <div class="panel-body">
        <form enctype="multipart/form-data" id="formuploadajax" method="POST">
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Cargar CSV</label>
                    <div class="col-md-6">
                        <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden">
                            <div class="input-append">
                                <div class="uneditable-input">
                                    <i class="fa fa-file fileupload-exists"></i>
                                    <span class="fileupload-preview"></span>
                                </div>
                                <span class="btn btn-default btn-file">
                                    <span class="fileupload-exists">Cambiar</span>
                                    <span class="fileupload-new">Selecciona un archivo</span>
                                    <input type="file" accept=".csv" id="sortpicture">
                                </span>
                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remover</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="type">Planes:</label>
                    <select class="form-control" data-plugin-multiselect="" name="rates" id="rates">
                        <option value="0" selected>Elegir...</option>
                        @foreach($rates as $rate)
                        <option value="{{$rate->offerID}}" data-rateid="{{$rate->id}}" data-offerid="{{$rate->offer_id}}">{{$rate->name.' - $'.number_format($rate->price,2)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Fecha de la Operación</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="date" class="form-control" id="scheduleDate">
                    </div>
                </div>
                <div class="col-md-6 mb-md">
                        <label>Clientes</label>
                        <select data-plugin-selectTwo class="form-control populate" id="client"  onchange="getData(this.value)">
                            <optgroup label="Clientes disponibles">
                            <option value="0">Elige...</option>
                            @foreach($clients as $client)
                            <option value="{{$client->id}}">
                                {{$client->name.' '.$client->lastname.' - '.$client->email}}
                            </option>
                            @endforeach
                            </optgroup>
                            
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="type">Personas físicas/morales:</label>
                        <select class="form-control" data-plugin-multiselect="" name="clientson" id="clientson">
                            <option value="0" selected>Elegir...</option>
                        </select>
                    </div>
            </div>
            <button class="btn btn-success btn-xs mt-md" id="verifyFile" type="button"><i class="fa fa-search"></i> Verificar</button>
        </form>
    <!-- </div>
    
    <div class="panel-body"> -->
        <div class="alert alert-dark mt-md d-none" id="contentCSV2">
            <strong>Diagnóstico del fichero</strong>.
            <p id="textDiagnostic"></p>
        </div>
        <div class="col-md-12 mt-md" id="contentCSV">
            <table class="table table-bordered table-striped mb-none" id="datatable-csv">
                <thead>
                    <tr>
                        <th>No. Línea</th>
                        <th>MSISDN</th>
                        <th>offerID</th>
                        <th>Coordenadas</th>
                        <th>Fecha Activa</th>
                        <th>Descripción Error</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</section>

<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script >
    
</script>
<script>

    $('#verifyFile').on('click', function() {
        let firstCSV = $('#sortpicture').val();
        let offerIDChoose = $('#rates').val();
        let rate_id = $('#rates option:selected').attr('data-rateid')
        let offer_id = $('#rates option:selected').attr('data-offerid')
        let scheduleDateForm = $('#scheduleDate').val();
        let client_id = $('#client').val();
        let clientson_id = $('#clientson').val();

        if(firstCSV.length == 0 || /^\s+$/.test(firstCSV)){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor cargue un fichero con extensión CSV.',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }

        if(offerIDChoose == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor elija un plan para los números a activar.',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }

        if(scheduleDateForm.length == 0 || /^\s+$/.test(scheduleDateForm)){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor elija una fecha para realizar las activaciones.',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }

        if(client_id == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor elija un cliente al que van a pertenecer las activaciones.',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }

        if(clientson_id == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor elija un tipo de persona moral/física para las activaciones.',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }

        let file_data = $('#sortpicture').prop('files')[0];
        let form_data = new FormData();
        let rowsInvalid, records, rows = new Array();
        let msisdn, offerID, coordinates, scheduleDate, numberLine, textDiagnostic = '', errorDescription = '';
        form_data.append('file', file_data);
        form_data.append('offerID', offerIDChoose);
        form_data.append('scheduleDate', scheduleDateForm);
        form_data.append('offer_id', offer_id);
        form_data.append('rate_id', rate_id);
        form_data.append('client_id', client_id);
        form_data.append('clientson_id', clientson_id);
        $.ajax({
            url: "{{route('extractCSV')}}",
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            beforeSend: function(){
                Swal.fire({
                    title: 'Verificando los datos del fichero...',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response){
                console.log(response);
                response = JSON.parse(response);
                rowsInvalid = response.rowsInvalid;
                textDiagnostic = rowsInvalid == 0 ? 'Los resultados de la activación se pueden apreciar en la siguiente tabla.<br>Puede descargar los resultados en el botón CSV de la tabla.<i class="fa fa-hand-o-down"></i>' : 'Hay <strong>'+rowsInvalid+'</strong> líneas con datos inválidos, verifique los resultados de la activación en la tabla siguiente.<br>Puede descargar los resultados en el botón CSV de la tabla.<i class="fa fa-hand-o-down"></i>';
                rowsInvalid == 0 ? $('#formuploadajaxTwo').removeClass('d-none') : $('#formuploadajaxTwo').addClass('d-none');

                records = response.records;
                console.log(records);
                records.forEach(function(e){
                    if(e.length == 'good'){
                        if(e.msisdnBool == 1){
                            msisdn = "<span class='label label-success'>"+e.msisdn+"</span>";
                        }else{
                            msisdn = "<span class='label label-danger'>"+e.msisdn+" es inválido</span>";
                        }

                        if(e.offerBool == 1){
                            offerID = "<span class='label label-success'>"+e.offerID+"</span>";
                        }else{
                            offerID = "<span class='label label-danger'>La oferta "+e.offerID+" es inválida</span>";
                        }

                        if(e.coordinatesBool == 0){
                            coordinates = "<span class='label label-success'></span>";
                        }else{
                            coordinates = "<span class='label label-danger'>El fichero contiene coordenadas: "+e.coordinates+", esto no está permitido.</span>";
                        }

                        if(e.dateBool == 1){
                            scheduleDate = "<span class='label label-success'>"+e.scheduleDate+"</span>";
                        }else{
                            scheduleDate = "<span class='label label-danger'>La fecha "+e.scheduleDate+" es inválida</span>";
                        }
                    }else{
                        msisdn = "<span class='label label-danger'>Inválido</span>";
                        offerID = "<span class='label label-danger'>Inválido</span>";
                        coordinates = "<span class='label label-danger'>Inválido</span>";
                        scheduleDate = "<span class='label label-danger'>Inválido</span>";
                    }

                    errorDescription = e.errorDescription;

                    numberLine = "<span class='label label-primary'>"+e.numberLine+"</span>";

                    rows.push({
                        numberLine: numberLine,
                        msisdn: msisdn,
                        offerID: offerID,
                        coordinates: coordinates,
                        scheduleDate: scheduleDate,
                        errorDescription: errorDescription
                    });
                });
                
                var datatableInit = function() {
                    var $table = $('#datatable-csv');

                    $table.DataTable({
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'csv',
                            header: false,
                            title: 'numbers',
                            exportOptions : {
                                columns: [ 0, 1, 2, 3 ],
                            }
                        }],
                        destroy: true,
                        data: rows,
                        columns: [
                            {title: "No. Línea",data:"numberLine"},
                            {title: "MSISDN",data:"msisdn"},
                            {title: "offerID",data:"offerID"},
                            {title: "Coordenadas",data:"coordinates"},
                            {title: "Fecha Activa",data:"scheduleDate"},
                            {title: "Descripción Error",data:"errorDescription"}
                        ],
                    });

                };

                $(function() {
                    datatableInit();
                });

                $('#textDiagnostic').html(textDiagnostic);
                // $('#contentCSV').removeClass('d-none');
                $('#contentCSV2').removeClass('d-none');
                Swal.close();
            }
        });
    });

    function getData(e){
        let options = "<option value='0' selected>Elegir...</option>";
        $.ajax({
            url: "{{route('findClientSon')}}",
            data: {client_id:e},
            success: function(response){
                response.forEach(function(e){
                    options+="<option value='"+e.id+"'>"+e.name+" "+e.lastname+"</option>";
                });
                $('#clientson').html(options);
            }
        });
    }

    $('#activateFile').click(function(){
        let secondCSV = $('#sortpictureTwo').val();
        let client_id = $('#client').val();
        let clientson_id = $('#clientson').val();
        let rate_id = $('#rate_id').val();
        let offer_id = $('#offer_id').val();
    
        if(secondCSV.length == 0 || /^\s+$/.test(secondCSV)){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor cargue un fichero con extensión CSV.',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }

        

        let file_data = $('#sortpictureTwo').prop('files')[0];
        let form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('client_id', client_id);
        form_data.append('clientson_id', clientson_id);
        form_data.append('rate_id', rate_id);
        form_data.append('offer_id', offer_id);

        $.ajax({
            url: "{{route('consumeCSV')}}",
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            beforeSend: function(){
                Swal.fire({
                    title: 'Verificando los datos del fichero...',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response){
                response = JSON.parse(response);
                let REQUEST_RESULT = response.REQUEST_RESULT;
                let rowsInvalid = response.rowsInvalid;
                let records = response.records;
                let status =  REQUEST_RESULT.status, lines, effectiveDate, transaction_id;
                let rows = new Array();
                let msisdnR, offerIDR, coordinatesR, scheduleDateR, numberLineR;

                records.forEach(function(e){
                    if(e.length == 'good'){
                        if(e.msisdnBool == 1){
                            msisdnR = "<span class='label label-success'>"+e.msisdn+"</span>";
                        }else{
                            msisdnR = "<span class='label label-danger'>"+e.msisdn+" es inválido</span>";
                        }

                        if(e.offerBool == 1){
                            offerIDR = "<span class='label label-success'>"+e.offerID+"</span>";
                        }else{
                            offerIDR = "<span class='label label-danger'>La oferta "+e.offerID+" es inválida</span>";
                        }

                        if(e.coordinatesBool == 0){
                            coordinatesR = "<span class='label label-success'></span>";
                        }else{
                            coordinatesR = "<span class='label label-danger'>El fichero contiene coordenadas: "+e.coordinates+", esto no está permitido.</span>";
                        }

                        if(e.dateBool == 1){
                            scheduleDateR = "<span class='label label-success'>"+e.scheduleDate+"</span>";
                        }else{
                            scheduleDateR = "<span class='label label-danger'>La fecha "+e.scheduleDate+" es inválida</span>";
                        }
                    }else{
                        msisdnR = "<span class='label label-danger'>Inválido</span>";
                        offerIDR = "<span class='label label-danger'>Inválido</span>";
                        coordinatesR = "<span class='label label-danger'>Inválido</span>";
                        scheduleDateR = "<span class='label label-danger'>Inválido</span>";
                    }

                    numberLineR = "<span class='label label-primary'>"+e.numberLine+"</span>";

                    rows.push({
                        numberLine: numberLineR,
                        msisdn: msisdnR,
                        offerID: offerIDR,
                        coordinates: coordinatesR,
                        scheduleDate: scheduleDateR
                    });
                });
                
                var datatableInit = function() {
                    var $table = $('#datatable-csv');

                    $table.DataTable({
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'csv',
                            header: false,
                            title: 'numbersActivated',
                            exportOptions : {
                                columns: [ 1, 2, 3, 4 ],
                            }
                        }],
                        destroy: true,
                        data: rows,
                        columns: [
                            {title: "No. Línea",data:"numberLine"},
                            {title: "MSISDN",data:"msisdn"},
                            {title: "offerID",data:"offerID"},
                            {title: "Coordenadas",data:"coordinates"},
                            {title: "Fecha Activa",data:"scheduleDate"}
                        ],
                    });

                };

                $(function() {
                    datatableInit();
                });
                
                if(status == 1){
                    

                    Swal.fire({
                        icon: 'success',
                        title: 'Hecho',
                        text: 'Los resultados de la activación por bloques se veran reflejados en la tabla, si hay resultados en rojo, consulte a Desarrollo.'
                    });

                }else if(status == 0){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No se ejecutó la activación por bloques, error con el resultado del request. Consulte a Desarrollo.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });

    });
</script>
@endsection