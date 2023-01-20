@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Mis Portabilidades Pendientes</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Dashboard</span></li>
        </ol>
    </div>
</header>

<style>
    .active-row{
        background: #2abb85 !important;
        color: white;
    }
</style>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Pendientes</h2>
    </header>
    <div class="panel-body table-responsive" >
        <table class="table table-bordered table-striped mb-none" id="myTable">
            <thead style="cursor: pointer;">
                <tr>
                    <th>Número Portado</th>
                    <th>ICC</th>
                    <th>Número Transitorio</th>
                    <th>Fecha de Creación</th>
                    <th>Fecha para Activar</th>
                    <th>Fecha para Portar</th>
                    <th>NIP</th>
                    <th>Plan Activación</th>
                    <th>Monto</th>
                    <th>Cliente</th>
                    <th>Enviado por</th>
                    <th>Comentarios</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($pendings as $pending)
                <tr style="cursor: pointer;" >
                    <td id='msisdnPortedPendiente_{{$pending["id"]}}'>{{$pending['msisdnPorted']}}</td>
                    <td id='iccPendiente_{{$pending["id"]}}'>{{$pending['icc']}}</td>
                    <td id='msisdnTransitoryPendiente_{{$pending["id"]}}'>{{$pending['msisdnTransitory']}}</td>
                    <td id='created_atPendiente_{{$pending["id"]}}'>{{$pending['created_at']}}</td>
                    <td id='datePendiente_{{$pending["id"]}}'>{{$pending['date']}}</td>
                    <td id='approvedDateABDPendiente_{{$pending["id"]}}'>{{$pending['approvedDateABD']}}</td>
                    <td id='nipPendiente_{{$pending["id"]}}'>{{$pending['nip']}}</td>
                    <td id='ratePendiente_{{$pending["id"]}}'>{{$pending['name_rate']}}</td>
                    <td id='ratePendiente_{{$pending["id"]}}'>$ {{$pending['amount']}}</td>
                    <td id='clientPendiente_{{$pending["id"]}}'>{{$pending['client']}}</td>
                    <td id='who_did_itPendiente_{{$pending["id"]}}'>{{$pending['who_did_it']}}</td>
                    <td id='commentsPendiente_{{$pending["id"]}}'>{{$pending['comments']}}</td>
                    <td>
                        <button class="btn btn-success btn-xs pending-port" data-id="{{$pending['id']}}" data-msisdn="{{$pending['msisdnTransitory']}}" data-toggle="tooltip" data-placement="left" title="" data-original-title="Activar SIM"><li class="fa fa-check-circle"></li></button>
                        <button class="btn btn-warning btn-xs activated-port btnEditPendientes"  
                                data-id="{{$pending['id']}}" data-msisdn="{{$pending['msisdnPorted']}}" data-icc="{{$pending['icc']}}" data-msisdnTransito="{{$pending['msisdnTransitory']}}"
                                data-created="{{$pending['created_at']}}" data-date="{{$pending['date']}}" data-approvedDate="{{$pending['approvedDateABD']}}" 
                                data-nip="{{$pending['nip']}}" data-rate="{{$pending['name_rate']}}" data-client="{{$pending['client']}}" data-wowDid="{{$pending['who_did_it']}}"
                                data-comments="{{$pending['comments']}}"
                                data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar Pendientes">
                            <i class="fa fa-edit" ></i>
                        </button>
                        <button class="btn btn-danger btn-xs delete-port" data-id="{{$pending['id']}}" data-msisdn="{{$pending['msisdnTransitory']}}" data-toggle="tooltip" data-placement="left" title="" data-original-title="Eliminar SIM"><li class="fa fa-ban"></li></button>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
       
    </div>
</section>


<div class="modal fade" id="modalPendientes" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-dark text-bold">Datos de la Portabilidad</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-bordered" action="" method="" id="form-update-rate">
                
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <div class="form-group col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label for="edit_noPortabilidadPendiente" class="form-label">Número Portado</label>
                                    <input type="text" class="form-control" id="edit_noPortabilidadPendiente" name="edit_noPortabilidadPendiente" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_iccPendiente" class="form-label">ICC</label>
                                    <input type="text" class="form-control" id="edit_iccPendiente" name="edit_iccPendiente" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_noTransitorioPendiente" class="form-label">Número Transitorio</label>
                                    <input type="text" class="form-control" id="edit_noTransitorioPendiente" name="edit_noTransitorioPendiente" maxlength="10" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_fechaCreacionPendiente" class="form-label">Fecha de Creación</label>
                                    <input type="datetime-local" class="form-control" id="edit_fechaCreacionPendiente" name="edit_fechaCreacionPendiente" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_fechaActivarPendiente" class="form-label">Fecha para Activar</label>
                                    <input type="date" class="form-control" id="edit_fechaActivarPendiente" name="edit_fechaActivarPendiente">
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_fechaPortarPendiente" class="form-label">Fecha para Portar</label>
                                    <input type="date" class="form-control" id="edit_fechaPortarPendiente" name="edit_fechaPortarPendiente" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_nipPendiente" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="edit_nipPendiente" name="edit_nipPendiente" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_planActivacionPendiente" class="form-label">Plan Activación</label>
                                    <input type="text" class="form-control" id="edit_planActivacionPendiente" name="edit_planActivacionPendiente" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_clientePendiente" class="form-label">Cliente</label>
                                    <input type="text" class="form-control" id="edit_clientePendiente" name="edit_clientePendiente" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_enviadoPendiente" class="form-label">Enviado por</label>
                                    <input type="text" class="form-control" id="edit_enviadoPendiente" name="edit_enviadoPendiente" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_comentarioPendiente" class="form-label">Comentarios</label>
                                    <textarea class="form-control" id="edit_comentarioPendiente" name="edit_comentarioPendiente" required></textarea>
                                    {{-- <input type="text" class="form-control" id="edit_comentarioPendiente" name="edit_comentarioPendiente" required> --}}
                                </div>
                                <input type="hidden" id="id_to_editPendiente">
                            </div>
                        </div>
                    </div>              

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="add_updatePortaPendiente">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Activadas</h2>
    </header>
    <div class="col-md-12">
        <div class="col-md-3" style="margin-bottom: 1rem; margin-top: 1rem; ">
            <button class="btn btn-success btn-sm" id="importAll" >Importar a Altan</button>
        </div>
        <div class="col-md-4"  style="margin-bottom: 1rem; margin-top: 1rem; margin-left: -6rem">
            <span class="btn btn-default btn-file">
                <span class="fileupload-new">Selecciona un archivo</span>
                <input type="file" accept=".csv" id="csvtAltan">
            </span>
            <button class="btn btn-primary" id="importAltan">Cargar Archivo</button>
        </div>
    </div>
    <div class="panel-body table-responsive" >
        
            <table class="table table-bordered table-striped mb-none" id="myTable2">
                <thead style="cursor: pointer;">
                    <tr>
                        <th>Número Portado</th>
                        <th>ICC</th>
                        <th>Número Transitorio</th>
                        <th>Fecha de Creación</th>
                        <th>Fecha para Activar</th>
                        <th>Fecha para Portar</th>
                        <th>NIP</th>
                        <th>Plan Activación</th>
                        <th>Monto</th>
                        <th>Cliente</th>
                        <th>Enviado por</th>
                        <th>Atendido por</th>
                        <th>Comentarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($activateds as $activated)
                        @if($activated['ABD'] == 1)
                            <tr style="cursor: pointer;" id="activada_{{$activated['id']}}" class="active-row ">
                        @else
                            <tr style="cursor: pointer;" id="activada_{{$activated['id']}}" class="">
                        @endif
                        <td id='msisdnPorted_{{$activated["id"]}}'>{{$activated['msisdnPorted']}}</td>
                        <td id='icc_{{$activated["id"]}}'>{{$activated['icc']}}</td>
                        <td id='msisdnTransitory_{{$activated["id"]}}'>{{$activated['msisdnTransitory']}}</td>
                        <td id='created_at{{$activated["id"]}}'>{{$activated['created_at']}}</td>
                        <td id='date_{{$activated["id"]}}'>{{$activated['date']}}</td>
                        <td id='approvedDateABD_{{$activated["id"]}}'>{{$activated['approvedDateABD']}}</td>
                        <td id='nip_{{$activated["id"]}}'>{{$activated['nip']}}</td>
                        <td id='rate_{{$activated["id"]}}'>{{$activated['name_rate']}}</td>
                        <td id='rate_{{$activated["id"]}}'>$ {{$activated['amount']}}</td>
                        <td id='client_{{$activated["id"]}}'>{{$activated['client']}}</td>
                        <td id='who_did_it_{{$activated["id"]}}'>{{$activated['who_did_it']}}</td>
                        <td id='who_attended_{{$activated["id"]}}'>{{$activated['who_attended']}}</td>
                        <td id='comments_{{$activated["id"]}}'>{{$activated['comments']}}</td>
                        <td style="gap: 1rem; display: grid;">
                            <button class="btn btn-success btn-xs activated-port btnPortabilidad" data-id="{{$activated['id']}}" data-msisdn="{{$activated['msisdnPorted']}}" data-icc="{{$activated['icc']}}" data-toggle="tooltip" data-placement="left" title="" data-original-title="Importar a Altán">
                                <i class="fa fa-check" ></i>
                            </button>
                            <button class="btn btn-warning btn-xs activated-port btnEditPorta" data-id="{{$activated['id']}}" data-msisdn="{{$activated['msisdnPorted']}}" data-icc="{{$activated['icc']}}" data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar Portabilidad">
                                <i class="fa fa-edit" ></i>
                            </button>
                            <button class="btn btn-info btn-xs check-abd" data-id="{{$activated['id']}}" data-row="activada_{{$activated['id']}}" data-toggle="tooltip" data-placement="left" title="" data-original-title="Marcar ABD">
                                <i class="fa fa-check-square-o" ></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        
    </div>
</section>


<div class="modal fade" id="modalPortabilidades" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-dark text-bold">Datos de la Portabilidad</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-bordered" action="" method="" id="form-update-rate">
                
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <div class="form-group col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label for="edit_noPortabilidad" class="form-label">Número Portado</label>
                                    <input type="text" class="form-control" id="edit_noPortabilidad" name="edit_noPortabilidad" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_icc" class="form-label">ICC</label>
                                    <input type="text" class="form-control" id="edit_icc" name="edit_icc" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_noTransitorio" class="form-label">Número Transitorio</label>
                                    <input type="text" class="form-control" id="edit_noTransitorio" name="edit_noTransitorio" maxlength="10" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_fechaActivar" class="form-label">Fecha para Activar</label>
                                    <input type="date" class="form-control" id="edit_fechaActivar" name="edit_fechaActivar" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_fechaPortar" class="form-label">Fecha para Portar</label>
                                    <input type="date" class="form-control" id="edit_fechaPortar" name="edit_fechaPortar" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit_nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="edit_nip" name="edit_nip" required>
                                </div>
                                <input type="hidden" id="id_to_edit">
                            </div>
                        </div>
                    </div>              

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="add_updatePorta">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Completadas</h2>
    </header>
    <div class="panel-body table-responsive" >
        <table class="table table-bordered table-striped mb-none" id="myTable3">
            <thead style="cursor: pointer;">
                <tr>
                    <th>Número Portado</th>
                    <th>ICC</th>
                    <th>Número Transitorio</th>
                    <th>Fecha de Creación</th>
                    <th>Fecha para Activar</th>
                    <th>Fecha para Portar</th>
                    <th>NIP</th>
                    <th>Plan Activación</th>
                    <th>Monto Plan</th>
                    <th>Cliente</th>
                    <th>Enviado por</th>
                    <th>Atendido por</th>
                    <th>Comentarios</th>
                </tr>
            </thead>
            <tbody id="body-complate">
            @foreach($completeds as $completed)
                <tr style="cursor: pointer;" >
                    <td>{{$completed['msisdnPorted']}}</td>
                    <td>{{$completed['icc']}}</td>
                    <td>{{$completed['msisdnTransitory']}}</td>
                    <td>{{$completed['created_at']}}</td>
                    <td>{{$completed['date']}}</td>
                    <td>{{$completed['approvedDateABD']}}</td>
                    <td>{{$completed['nip']}}</td>
                    <td>{{$completed['name_rate']}}</td>
                    <td>$ {{$completed['amount']}}</td>
                    <td>{{$completed['client']}}</td>
                    <td>{{$completed['who_did_it']}}</td>
                    <td>{{$completed['who_attended']}}</td>
                    <td>{{$completed['comments']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>

<div class="modal fade" id="modalErrors" tabindex="-1" aria-labelledby="modalErrorsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moralPersonModalLabel">Errores encontrados en la importación</h5>
            </div>
            <div class="modal-body" id="tblErrors">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
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
    $('.btnEditPorta').click(function(){
        let id = $(this).attr('data-id');

        $.ajax({
            url:"{{route('getAllDataPorta')}}",
            method: "POST",
            data: {id},
            success: function(data){
                // console.log("data",data);
                $('#edit_noPortabilidad').val(data.msisdnPorted);
                $('#edit_icc').val(data.icc);
                $('#edit_noTransitorio').val(data.msisdnTransitory);
                // $('#edit_fechaActivar').val(data.approvedDateABD);
                // $('#edit_fechaPortar').val(data.date);
                $('#edit_fechaActivar').val(data.date);
                $('#edit_fechaPortar').val(data.approvedDateABD);
                $('#edit_nip').val(data.nip);
                $('#id_to_edit').val(id);

                $('#modalPortabilidades').modal('show');
            }
        }); 
        
    });

    $('.btnEditPendientes').click(function(){
        let id = $(this).attr('data-id');
    
        $.ajax({
            url:"{{route('getAllDataPortaPendiente')}}",
            method: "POST",
            data: {id},
            success: function(data){
                // console.log("data",data[0].id);
                
                $('#edit_noPortabilidadPendiente').val(data[0].msisdnPorted);
                $('#edit_iccPendiente').val(data[0].icc);
                $('#edit_noTransitorioPendiente').val(data[0].msisdnTransitory);
                $('#edit_fechaCreacionPendiente').val(data[0].created_at);
                $('#edit_fechaPortarPendiente').val(data[0].approvedDateABD);
                $('#edit_fechaActivarPendiente').val(data[0].date);
                $('#edit_nipPendiente').val(data[0].nip);


                $('#edit_planActivacionPendiente').val(data[0].rate);
                $('#edit_clientePendiente').val(data[0].client);
                $('#edit_enviadoPendiente').val(data[0].who_did_it);
                $('#edit_comentarioPendiente').val(data[0].comments);


                $('#id_to_editPendiente').val(id);

                $('#modalPendientes').modal('show');
            }
        }); 
        
    });

    $('#add_updatePortaPendiente').click(function(){
        let id = $('#id_to_editPendiente').val();

        Swal.fire({
            title: '¿Estás seguro de modificar la información?',
            showCancelButton: true,
            confirmButtonText: 'SI, ESTOY SEGURO',
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                var noPortabilidadPendiente = $('#edit_noPortabilidadPendiente').val()
                var iccPendiente = $('#edit_iccPendiente').val();
                var noTransitorioPendiente = $('#edit_noTransitorioPendiente').val();
                var fechaPortarPendiente = $('#edit_fechaPortarPendiente').val();
                var edit_fechaActivarPendiente = $('#edit_fechaActivarPendiente').val();
                var nipPendiente = $('#edit_nipPendiente').val();
                var comentarioPendiente = $('#edit_comentarioPendiente').val();
                

                let data = {
                    noPortabilidadPendiente:noPortabilidadPendiente,
                    iccPendiente:iccPendiente,
                    noTransitorioPendiente:noTransitorioPendiente,
                    fechaPortarPendiente:fechaPortarPendiente,
                    edit_fechaActivarPendiente:edit_fechaActivarPendiente,
                    nipPendiente:nipPendiente,
                    comentarioPendiente:comentarioPendiente,
                    id:id
                };

                $.ajax({
                    url:"{{route('setAllDataPortaPendiente')}}",
                    method: "POST",
                    data: data,
                    success: function(response){
                        console.log("response",response);
                        if(response == 1 ){
                            Swal.fire({
                                icon: 'success',
                                title: 'Hecho!!',
                                timer: 2000,
                                showConfirmButton: false
                            }).then((result) => {
                                $('#msisdnPortedPendiente_'+id).html(noPortabilidadPendiente);
                                $('#iccPendiente_'+id).html(iccPendiente);
                                $('#msisdnTransitoryPendiente_'+id).html(noTransitorioPendiente);
                                $('#approvedDateABDPendiente_'+id).html(fechaPortarPendiente);
                                $('#nipPendiente_'+id).html(nipPendiente);
                                $('#commentsPendiente_'+id).html(comentarioPendiente);
                                $('#modalPendientes').modal('hide');
                            });
                        }
                        else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Woops!!',
                                text: 'Ocurrio un error, intente de nuevo o notifique a Desarrollo',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                        
                    }
                });  
            } else{
                Swal.fire({
                    icon: 'info',
                    title: 'Operación Cancelada',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })
    });

    $('#add_updatePorta').click(function(){
        let id = $('#id_to_edit').val();

        Swal.fire({
            title: '¿Estás seguro de modificar la información?',
            showCancelButton: true,
            confirmButtonText: 'SI, ESTOY SEGURO',
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                var msisdnPorted = $('#edit_noPortabilidad').val();
                var icc = $('#edit_icc').val();
                var msisdnTransitory = $('#edit_noTransitorio').val();
                // MODIFICADO
                // var approvedDateABD = $('#edit_fechaActivar').val();
                // var date = $('#edit_fechaPortar').val();
                // MODIFICADO
                var approvedDateABD = $('#edit_fechaPortar').val();
                var date = $('#edit_fechaActivar').val();
                var nip = $('#edit_nip').val();

                let data = {
                    msisdnPorted:msisdnPorted,
                    icc:icc,
                    msisdnTransitory:msisdnTransitory,
                    approvedDateABD:approvedDateABD,
                    date:date,
                    nip:nip
                };

                $.ajax({
                    url:"{{route('setAllDataPorta')}}",
                    method: "POST",
                    data: data,
                    success: function(response){
                        if(response == 1 ){
                            Swal.fire({
                                icon: 'success',
                                title: 'Hecho!!',
                                timer: 2000,
                                showConfirmButton: false
                            }).then((result) => {
                                $('#msisdnPorted_'+id).html(msisdnPorted);
                                $('#icc_'+id).html(icc);
                                $('#msisdnTransitory_'+id).html(msisdnTransitory);
                                // MODIFICADO
                                // $('#approvedDateABD_'+id).html(date);
                                // $('#date_'+id).html(approvedDateABD);
                                // MODIFICADO
                                $('#approvedDateABD_'+id).html(approvedDateABD);
                                $('#date_'+id).html(date);
                                $('#nip_'+id).html(nip);
                                $('#modalPortabilidades').modal('hide');
                            });
                        }
                        else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Woops!!',
                                text: 'Ocurrio un error, intente de nuevo o notifique a Desarrollo',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                        
                    }
                });  
            } else{
                Swal.fire({
                    icon: 'info',
                    title: 'Operación Cancelada',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })
    });

    $('.btnPortabilidad').click(function(){
        let icc = $(this).attr('data-icc');
        let msisdn_portado = $(this).attr('data-msisdn');
        let id = $(this).attr('data-id');

        Swal.fire({
            title: '¿Estás seguro de marcar como completada la Portabilidad?',
            showCancelButton: true,
            confirmButtonText: 'SI, ESTOY SEGURO',
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url:"{{route('getAllDataPortPendiente')}}",
                    method: "POST",
                    data: {icc, msisdn_portado},
                    success: function(data){
                        console.log(data)
                        if(data == 1){
                            Swal.fire({
                                icon: 'success',
                                title: 'Hecho!!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#activada_'+id).remove();
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Woops!!',
                                text: 'Ocurrio un error, intente de nuevo o notifique a Desarrollo',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    }
                }); 
                
            } else{
                Swal.fire({
                    icon: 'info',
                    title: 'Operación Cancelada',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })

    });

    $('.check-abd').click(function() {
        let row_id = $(this).data("row");
        let porta_id = $(this).data("id");
        let tr_change = document.getElementById(row_id);
        $.ajax({
            url:"{{route('updateABD')}}",
            method: "POST",
            data: {_token: "{{csrf_token()}}", id:porta_id},
            success:function(response){
                console.log(response);
                if (response) {
                    tr_change.classList.toggle('active-row')
                }               
            }
        })
    })
</script>

<script >
    $(document).ready( function () {
        $('#myTable').DataTable({
            order: false,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                header: true,
                title: 'portabilidadesPendientes',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8,9,10,11 ],
                }
            }],
        });

        $('#myTable2').DataTable({
            order: false,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                header: true,
                title: 'portabilidadesActivadas',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8,9,10,11 ],
                }
            }],
        });

        $('#myTable3').DataTable({
            dom: 'Bfrtip',
            order: false,
            buttons: [{
                extend: 'excel',
                header: true,
                title: 'portabilidadesCompletadas',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8,9,10,11 ],
                }
            }],
        });
    });
</script>

<script>
    $(".delete-port").click(function () {
        let id = $(this).data('id');
        let msisdn = $(this).data('msisdn');
        Swal.fire({
            title: 'ATENCIÓN',
            html: "¿Está seguro de eliminar el número <b>"+msisdn+"</b>?",
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
                $.ajax({
                    url: "{{route('destroyPort')}}",
                    method: "POST",
                    data: {_token: "{{csrf_token()}}", id: id},
                    beforeSend: function(){
                        Swal.fire({
                            title: 'Eliminando',
                            html: 'Espera un poco, un poquito más...',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response){
                        if (response) {
                            setTimeout(function(){ location.reload(); }, 1000);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Algo salió mal, recarge e intente de nuevo, si el error presiste consulte con Desarrollo.',
                            });   
                        }
                    }
                });
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

    $('.pending-port').click(function(){
        let id = $(this).data('id');
        let msisdn = $(this).data('msisdn');
        Swal.fire({
            title: 'ATENCIÓN',
            html: "¿Está seguro de realizar la activación del número <b>"+msisdn+"</b>?",
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
                $.ajax({
                    url: "{{route('doActivationPort')}}",
                    method: "POST",
                    data: {_token: "{{csrf_token()}}", id: id, user_id: "{{Auth::user()->id}}"},
                    beforeSend: function(){
                        Swal.fire({
                            title: 'Activando',
                            html: 'Espera un poco, un poquito más...',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response){
                        if (response == false ) {
                            return Swal.fire({
                                icon: 'error',
                                title: 'El icc de esta portabilidad ya fue activada',
                                text: response.message,
                            });
                        }
                        if(response.http_code){
                            if(response.http_code == 200){
                                setTimeout(function(){ location.reload(); }, 1000);
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Woops!!',
                                    text: response.message,
                                })
                            }
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Algo salió mal, consulta a Desarrollo.',
                            })
                        }
                    }
                });
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
</script>

<script>
    $('#importAll').click(function(){
        Swal.fire({
            title: 'ATENCIÓN',
            html: "¿Está seguro de realizar la importación de números a portar en Altan?",
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
                $.ajax({
                    url: "{{route('importAllPorts')}}",
                    method: "POST",
                    data: {_token:"{{csrf_token()}}"},
                    beforeSend: function(){
                        Swal.fire({
                            title: 'Importando datos a Altan',
                            html: 'Espera un poco, un poquito más...',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response){
                        Swal.close();
                        let message = response.message;
                        let error = response.error;
                        let errors = response.errors;
                        let tbl = "<table class='table table-bordered table-striped mb-none'><thead> <tr> <th>Número a Portar</th> <th>Descripción</th> <th>Código Error</th> </tr> </thead><tbody>";

                        if(error == 1){
                            errors.forEach(function(element){
                                tbl+="<tr><td><span class='badge label-danger'>"+element.msisdn.msisdnPorted+"</span></td><td><span class='badge label-danger'>"+element.msisdn.response.description+"</span></td><td><span class='badge label-danger'>"+element.msisdn.response.errorCode+"</span></td></tr>";
                            });

                            tbl+="</tbody></table>";
                            $('#tblErrors').html(tbl);
                            $('#modalErrors').modal('show');
                        }else{
                            Swal.fire({
                                icon: 'success',
                                title: 'Well Done!!',
                                text: 'La importación se realizó sin errores.'
                            });
                        }
                        
                        
                    }
                });
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
        });
    });
</script>

<script>
    $('#importAltan').click(function(){
        let firstCSV = $('#csvtAltan').val();


        if(firstCSV.length == 0 || /^\s+$/.test(firstCSV)){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor cargue un fichero con extensión CSV.',
                showConfirmButton: false,
                timer: 2000
            });

            console.log('CSV')
        }

        let file_data = $('#csvtAltan').prop('files')[0];
        let form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('_token', '{{csrf_token()}}');
        $.ajax({
            url: "{{route('csvAltan')}}",
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type:'POST',
           success:function(response){
               console.log(response);
            //    return false;
               if (response) {
                window.location.reload();
               }
            // x = JSON.parse(response)
            // let body = ''
            // x.forEach(data =>
            //     body+= "<tr>"+"<td>"+data.msisdnPorted+"</td>"+"<td>"+data.icc+"</td>"+"<td>"+data.msisdnTransitory+"</td>"+"<td>"+data.date+"</td>"+"<td>"+data.nip+"</td>"+"<td>"+data.rate+"</td>"+"<td>"+data.client+"</td>"+"<td>"+data.who_did_it+"</td>"+"<td>"+data.who_attended+"</td>"+"</tr>"
            // );
            // $('#body-complate').html(body)

           }
        })
    })
</script>
@endsection