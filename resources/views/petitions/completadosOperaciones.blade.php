@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Administración de Solicitudes</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
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
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Solicitudes Completadas</h2>
    </header>
    <div class="panel-body">
        <div class="table-responsive">
        <table class="table table-bordered table-striped mb-none" id="myTable">
            <thead style="cursor: pointer;">
                <tr>
                <th>Cliente</th>
                <th>Enviado Por</th>
                <th>Producto</th>
                <th>Plan Activación</th>
                <th>Status</th>
                <th>Cobro cpe</th>
                <th>Cobro Plan</th>
                <th>Forma Pago</th>
                <th>Fecha Solicitud</th>
                <th>Activado Por</th>
                <th>Fecha Activación</th>
                <th>Recibido Por</th>
                <th>Fecha Recibido</th>
                <th>Comentario</th>
                @if(Auth::user()->role_id == 5 || Auth::user()->role_id == 1 || Auth::user()->role_id == 6)
                <th>Opciones</th>
                @endif
                </tr>
            </thead>
            <tbody>
                @foreach($completadas as $completado)
                <tr>
                    <td>{{$completado['client']}}</td>
                    <td>{{$completado['name_sender']}}</td>
                    <td>{{$completado['product']}}</td>
                    <td>{{$completado['rate_activation']}}</td>
                    <td><span class="badge label-{{$completado['badgeStatus']}}">{{$completado['status']}}</span></td>
                    <td>${{number_format($completado['cobroCpe'],2)}}</td>
                    <td>${{number_format($completado['cobroPlan'],2)}}</td>
                    <td>{{$completado['payment_way'].' - Plazo: '.$completado['plazo']}}</td>
                    <td>{{$completado['fecha_solicitud']}}</td>
                    <td>{{$completado['activadoPor']}}</td>
                    <td>{{$completado['date_activated']}}</td>
                    <td>{{$completado['recibido']}}</td>
                    <td><span class="badge label-{{$completado['badgeFecha']}}">{{$completado['dateRecibido']}}</span></td>
                    <td>{{$completado['comment']}}</td>
                    @if(Auth::user()->role_id == 5)
                    <td>
                        <button class="btn btn-success btn-sm collect" data-petition-id="{{$completado['id']}}" data-collected-cpe="{{number_format($completado['cobroCpe'],2)}}" data-collected-rate="{{number_format($completado['cobroPlan'],2)}}"><i class="fa fa-usd"></i></button>
                    </td>
                    @elseif(Auth::user()->role_id == 1 || Auth::user()->role_id == 6)
                    <td>
                        <button class="btn btn-success btn-sm format" data-petition-id="{{$completado['id']}}" data-toggle="tooltip" data-placement="top" data-original-title="Formato de Entrega" ><i class="fa fa-file-text-o"></i></button>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</section>

<div class="modal fade" id="modalCollect" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalTitle"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-bordered" >
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-md-12">
                                <h4 class="text-success text-bold">Montos Esperados y a Ingresar</h4>
                            </div>

                            <div class="col-md-12">
                                <div class="alert alert-info fade in nomargin">
                                    <h4 class="text-semibold">Información Solicitud y Activación</h4>
                                    <ul>
                                        <li id="amount_device_info"></li>
                                        <li id="amount_rate_info"></li>
                                        <li id="collected_cpe_info"></li>
                                        <li id="collected_rate_info"></li>
                                    </ul>
                                    <p class="text-bold" id="amount_total_tag"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="alert alert-warning fade in nomargin">
                                    <h4 class="text-semibold">Falta por recaudar:</h4>
                                    <ul>
                                        <li id="residuary_cpe_info"></li>
                                        <li id="residuary_rate_info"></li>
                                        
                                    </ul>
                                    <p class="text-bold" id="amount_total_tag"></p>
                                </div>
                            </div>

                            <input type="hidden" id="petition_id">
                            <input type="hidden" id="activation_id">
                            <input type="hidden" id="amount_rate">
                            <input type="hidden" id="amount_device">
                            <input type="hidden" id="collected_cpe">
                            <input type="hidden" id="collected_rate">
                            <input type="hidden" id="user_id" value="{{Auth::user()->id}}">

                            <div class="form-group col-md-12">
                                <div class="col-md-6">
                                    <section class="form-group-vertical">
                                        <div class="input-group input-group-icon">
                                            <label for="received_amount_device">Monto CPE:</label>
                                            <input class="form-control" type="text" id="received_amount_cpe" name="received_amount_cpe" autocomplete="off">
                                        </div>
                                    </section>
                                </div>

                                <div class="col-md-6">
                                    <section class="form-group-vertical">
                                        <div class="input-group input-group-icon">
                                            <label for="received_amount_device">Monto Plan:</label>
                                            <input class="form-control" type="text" id="received_amount_rate" name="received_amount_rate" autocomplete="off">
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>        

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="save_collect">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<script >
    $(document).ready( function () {
        $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                header: true,
                title: 'lineasActivadas',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 8, 9, 10, 13 ],
                }
            }],
        });
    });
</script>
<script>

    $('#received_amount_cpe, #received_amount_rate').on('input', function () {
        this.value = this.value.replace(/[^0-9.-]/g, '');
    });

    $('.collect').click(function(){
        let id = $(this).data('petition-id');
        let collected_rate = $(this).data('collected-rate');
        let collected_cpe = $(this).data('collected-cpe');
        let token = $('meta[name="csrf-token"]').attr('content');
        
         $.ajax({
             url: "{{route('collectMoney')}}",
             method: "POST",
             data: {_token: token, collectedCPE: collected_cpe, collectedRate: collected_rate, petition_id: id},
             beforeSend: function(){
                Swal.fire({
                    title: 'Estamos extrayendo la información que solicitas...',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
             },
             success: function(response){
                 
                 $('#amount_device_info').html('Monto esperado en CPE: $'+parseFloat(response.amount_device).toFixed(2));
                 $('#amount_rate_info').html('Monto esperado en Plan Activación: $'+parseFloat(response.amount_rate).toFixed(2));
                 $('#collected_cpe_info').html('Monto recaudado en CPE: $'+parseFloat(collected_cpe).toFixed(2));
                 $('#collected_rate_info').html('Monto recaudado en Plan Activación: $'+parseFloat(collected_rate).toFixed(2));

                 $('#residuary_cpe_info').html('CPE: $'+parseFloat(response.residuaryDevice).toFixed(2));
                 $('#residuary_rate_info').html('Plan: $'+parseFloat(response.residuaryRate).toFixed(2));

                 $('#petition_id').val(response.petition_id);
                 $('#activation_id').val(response.activation_id);
                 $('#amount_rate').val(response.amount_rate);
                 $('#amount_device').val(response.amount_device);
                 $('#collected_cpe').val(collected_cpe);
                 $('#collected_rate').val(collected_rate);

                Swal.close();
                $('#modalCollect').modal('show');
             }
         });
    });

    $('#received_amount_cpe').keyup(function(){
        let received_amount = $(this).val();
        let collected_amount = $('#collected_cpe').val();
        let amount = $('#amount_device').val();

        if(received_amount.length == 0 || /^\s+$/.test(received_amount)){
            received_amount = 0;
        }

        let new_collected_amount = parseFloat(received_amount)+parseFloat(collected_amount);
        let residuary_temp = parseFloat(amount)-parseFloat(new_collected_amount);

        $('#residuary_cpe_info').html('CPE: $'+parseFloat(residuary_temp).toFixed(2));
        console.log(residuary_temp);

    });

    $('#received_amount_rate').keyup(function(){
        let received_amount = $(this).val();
        let collected_amount = $('#collected_rate').val();
        let amount = $('#amount_rate').val();

        if(received_amount.length == 0 || /^\s+$/.test(received_amount)){
            received_amount = 0;
        }

        let new_collected_amount = parseFloat(received_amount)+parseFloat(collected_amount);
        let residuary_temp = parseFloat(amount)-parseFloat(new_collected_amount);

        $('#residuary_rate_info').html('CPE: $'+parseFloat(residuary_temp).toFixed(2));
        console.log(residuary_temp);

    });

    $('#save_collect').click(function(){
        let received_amount_cpe = $('#received_amount_cpe').val();
        let received_amount_rate = $('#received_amount_rate').val();
        let who_received = $('#user_id').val();
        let activation_id = $('#activation_id').val();
        let petition_id = $('#petition_id').val();
        let token = $('meta[name="csrf-token"]').attr('content');

        if(received_amount_cpe.length == 0 || /^\s+$/.test(received_amount_cpe)){
            received_amount_cpe = 0;
        }

        if(received_amount_rate.length == 0 || /^\s+$/.test(received_amount_rate)){
            received_amount_rate = 0;
        }

        Swal.fire({
            title: 'Verifique los datos siguientes:',
            html: "<li class='list-alert'><b>Recibido por CPE: </b>$"+parseFloat(received_amount_cpe).toFixed(2)+"</li><br>"+
            "<li class='list-alert'><b>Recibido por Plan: </b>$"+parseFloat(received_amount_rate).toFixed(2)+"</li><br>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-success mr-md',
                cancelButton: 'btn btn-danger '
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "{{route('saveCollected')}}",
                    method: "POST",
                    data: {
                        _token:token,
                        received_amount_cpe: received_amount_cpe,
                        received_amount_rate: received_amount_rate,
                        who_received: who_received,
                        activation_id: activation_id,
                        petition_id: petition_id,
                        },
                    beforeSend: function(){
                        Swal.fire({
                            title: 'Guardando registros...',
                            html: 'Espera un poco, un poquito más...',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response){
                        Swal.close();
                        
                        if(response == 1){
                            Swal.fire({
                                icon: 'success',
                                title: 'Operación realizada con éxito.',
                                showConfirmButton: false,
                                timer: 1000
                            })
                            setTimeout(function(){ location.reload(); }, 1200);
                        }else if(response == 0){
                            Swal.fire({
                                icon: 'error',
                                title: 'Ocurrió un error durante la operación.',
                                text: 'Consulte a Desarrollo.'
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
                    text: 'No se registro ningún pago.',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        })

    });

    $('.format').click(function(){
        let petition = $(this).data('petition-id');
        let url = "{{route('getActivation',['petition'=>'temp'])}}";
        url = url.replace('temp',petition);
        let urlFormat = "{{route('formatDelivery',['activation' => 'temp'])}}";

        $.ajax({
            url: url,
            success: function(response){
                urlFormat = urlFormat.replace('temp',response);
                window.open(urlFormat,'','width=600,height=400,left=50,top=50,toolbar=yes');
            }
        });
    });
</script>

@endsection