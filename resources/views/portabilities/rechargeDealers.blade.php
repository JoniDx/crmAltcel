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
                    <th>Número Recargado</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Promotor</th>
                    <th>Saldo para Vender</th>
                </tr>
            </thead>
            <tbody>
            @foreach($recharges as $recharge)
                <tr style="cursor: pointer;" >
                    <td >{{$recharge->phonenumber}}</td>
                    <td >{{$recharge->fecha}}</td>
                    <td >${{number_format($recharge->qty)}}</td>
                    <td >{{$recharge->delearName}}</td>
                    <td >${{number_format($recharge->saldo_conecta)}}</td>
            @endforeach
            </tbody>
        </table>
       
    </div>
</section>



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
                title: 'Recargas hechas por Promotores Veracruz',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4 ],
                }
            }],
        });

    });
</script>


@endsection