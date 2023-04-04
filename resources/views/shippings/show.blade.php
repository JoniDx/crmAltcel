@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Dashboard</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><a href="{{route('shipping.index')}}">Envíos</a></li>
        </ol>
        <a class="sidebar-right-toggle" href="{{route('shipping.index')}}"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>
<section class="panel">
    <div class="panel-body" id="elementToPrint">
        <div class="invoice">
            <header class="clearfix">
                <div class="row">
                    <div class="col-sm-6 mt-md">
                        <h2 class="h2 mt-none mb-sm text-dark text-bold">Envío</h2>
                        <h4 class="h4 m-none text-dark text-bold">#{{$id}}</h4>
                        @if($status == 'pendiente')
                        <span class="badge label label-warning" style="font-size: 14px;">Estado: {{$status}}</span>
                        @elseif($status == 'progress')
                        <span class="badge label label-info" style="font-size: 14px;">Estado: {{$status}}</span>
                        @elseif($status == 'completado')
                        <span class="badge label label-success" style="font-size: 14px;">Estado: {{$status}}</span>
                        @endif
                    </div>
                    <div class="col-sm-6 text-right mt-md mb-md">
                        <div class="ib">
                            {{-- PENDIENTE --}}
                            {{-- <img src="{{asset('images/conecta.png')}}" style="width: 40%;" /> --}}
                        </div>
                    </div>
                </div>
            </header>
            <div class="bill-info">
                <div class="row">
                    <div class="col-md-3">
                        <div class="bill-to">
                            <p class="h5 mb-xs text-dark text-bold">Para:</p>
                            <address >
                                <p class="text-bold mb-xs">{{$userData->name.' '.$userData->lastname}}</p>
                                <p class="text-semibold mb-xs">Zona: <span class="text-bold">{{$zona}}</span></p> 
                                <p class="text-semibold mb-xs">C.P: <span class="text-bold">{{$cp}}</span></p> 
                                <p class="text-semibold mb-xs">No. Exterior: <span class="text-bold">{{$no_exterior}}</span></p> 
                                <p class="text-semibold mb-xs">No. Interior: <span class="text-bold">{{$no_interior}}</span></p>
                                <p class="text-bold mb-xs">{{$tipo_asentamiento}} {{$colonia}}</p>
                                <p class="text-bold mb-xs">{{$ciudad}}</p>
                                <p class="text-bold mb-xs">{{$municipio}}, {{$estado}}, {{$pais}}</p>
                                <p class="text-bold mb-xs">Teléfono: {{$phone_contact}}</p>
                            </address>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bill-to">
                            <p class="h5 mb-xs text-dark text-bold">Extra:</p>
                            <address class="text-bold">
                                <p class="text-semibold mb-xs">Referencias: <span class="text-bold">{{$referencias}}</span></p>
                                <p class="text-semibold mb-xs">Recibe: <span class="text-bold">{{$recept = $recibe == 'N/A' ? $userData->name.' '.$userData->lastname : $recibe}}</span></p>
                                <p class="text-semibold mb-xs">Teléfono Alternativo: <span class="text-bold">{{$phone_alternative}}</span></p>
                                <p class="text-semibold mb-xs">Canal de Venta: <span class="text-bold">{{$canal}}</span></p>
                                <p class="text-semibold mb-xs">Comentarios: <span class="text-bold">{{$comments}}</span></p>
                            </address>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bill-to">
                            <p class="h5 mb-xs text-dark text-bold">Informació del Servicio:</p>
                            <address class="text-bold">
                                @if($rate_id != null)
                                <p class="text-semibold mb-xs">Producto: <span class="text-bold">{{$rateData->producto}}</span></p>
                                <p class="text-semibold mb-xs">Plan Solicitado: <span class="text-bold">{{$rateData->name}}</span></p>
                                <p class="text-semibold mb-xs">Pago de Plan: <span class="text-bold">${{number_format($rate_price,2)}}</span></p>
                                <p class="text-semibold mb-xs">Pago de Dispositivo/SIM: <span class="text-bold">${{number_format($device_price,2)}}</span></p>
                                <p class="text-semibold mb-xs">Envío: <span class="text-bold">${{number_format($shipping_price,2)}}</span></p>
                                @endif
                                @if($status == 'progress' || $status == 'completado')
                                <p class="text-semibold mb-xs">ICC: <span class="text-bold">{{$icc}}</span></p>
                                <p class="text-semibold mb-xs">IMEI: <span class="text-bold">{{$imei}}</span></p>
                                <p class="text-semibold mb-xs">MAC: <span class="text-bold">{{$mac_address}}</span></p>
                                <p class="text-semibold mb-xs">No. Serie: <span class="text-bold">{{$serial_number}}</span></p>
                                @endif
                            </address>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bill-to">
                            <address class="text-bold">
                                <p class="text-semibold mb-xs">Creación: <span class="text-bold">{{$creationDate}}</span></p>
                                <p class="text-semibold mb-xs">Creado por: <span class="text-bold">{{$createdData->name.' '.$createdData->lastname}}</span></p>
                                <p class="text-semibold mb-xs">Vendido por: <span class="text-bold">{{$soldData->name.' '.$soldData->lastname}}</span></p>
                                <hr>
                                @if($status == 'progress' || $status == 'completado')
                                    <p class="text-semibold mb-xs">Atendido el: <span class="text-bold">{{$attendDate}}</span></p>
                                    <p class="text-semibold mb-xs">Atendido por: <span class="text-bold">{{$attendedData->name.' '.$attendedData->lastname}}</span></p>
                                    <hr>
                                    @if($status == 'completado')
                                        <p class="text-semibold mb-xs">Completado el: <span class="text-bold">{{$completeDate}}</span></p>
                                        <p class="text-semibold mb-xs">Completado por: <span class="text-bold">{{$completedData->name.' '.$completedData->lastname}}</span></p>
                                        <!-- <hr> -->
                                    @endif
                                    <hr>
                                    <p class="text-semibold mb-xs">Última actualización: <span class="text-bold">{{$updateDate}}</span></p>
                                @endif
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>

        <div class="text-right mr-lg">
            <a href="javascript:window.printRoots(elementToPrint)" class="btn btn-primary ml-sm" id="btnPrint"><i class="fa fa-print"></i> Print</a>
            @if($status == 'pendiente')
                <button class="btn btn-success ml-sm" id="sendPack"><i class="fa fa-check"></i> Enviar</butt>
            @elseif($status == 'progress')
                <button class="btn btn-success ml-sm" id="notifyCCModal"><i class="fa fa-bell"></i> Entregado</butt>
            @endif
        </div>
    </div>
</section>

<div class="modal fade" id="modalSend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-bold" id="myModalLabel">Elementos a Enviar</h4>
            </div>
            <div class="modal-body col-md-12">
                <div class="col-md-12">
                    <div class="col-md-6 mb-md">
                        <label for="icc">ICC</label>
                        <input class="form-control" type="text" id="icc" name="icc" >
                    </div>

                    <div class="col-md-6 mb-md">
                        <label for="imei">IMEI (En caso de enviar también dispositivo)</label>
                        <input class="form-control" type="text" id="imei" name="imei" >
                    </div>

                    <div class="col-md-6" id="content-MAC">
                        <label for="mac_address_activation" class="form-label">MAC Address</label>
                        <input type="text" class="form-control" id="mac_address_activation" name="mac_address_activation" required >
                        <input type="hidden" id="mac_address_boolean" value="0">
                    </div>

                    
                    <div class="col-md-6" id="content-MAC">
                        <label for="no_serie" class="form-label">No. Serie</label>
                        <input type="text" class="form-control" id="no_serie" name="no_serie" required >
                    </div>

                    <div class="col-md-6 mt-2 d-none" id="data-dn">
                        <ul class="list-group col-md-6" id="data-dn-list">
                        
                        </ul>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="saveShipping" disabled>Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalObservations" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-bold" id="myModalLabel">Entrega de SIM</h4>
            </div>
            <div class="modal-body col-md-12">
                <div class="col-md-12">
                    <div class="col-md-6 mb-md">
                        <label for="observations">Observaciones</label>
                        <textarea class="form-control"  id="observations" name="observations" ></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="notifyCC">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#sendPack').click(function(){
        $('#modalSend').modal('show');
    });

    $('#icc').keyup(function(){
        let msisdn = $('#icc').val();
        let token = $('meta[name="csrf-token"]').attr('content');
        let list = '';
        let product = '';
        let badge_color = 'badge-danger';
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
                        $('#saveShipping').attr('disabled',true);
                    }else if(data.status == 'available'){
                        badge_color = 'label label-success';
                        product = data.producto;
                        $('#icc_id').val(data.icc_id);
                        $('#msisdn').val(data.MSISDN);
                        $('#saveShipping').attr('disabled',false);
                    }else{
                        badge_color = 'label label-warning';
                        product = data.producto;
                        $('#icc_id').val(data.icc_id);
                        $('#msisdn').val(data.MSISDN);
                        $('#saveShipping').attr('disabled',true);
                    }
                    list+='<li class="list-group-item d-flex justify-content-between align-items-center">Estado: <span class="badge '+badge_color+'"> '+data.status+'</span></li>';

                    $('#data-dn-list').html(list);
                }
        });
    });

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

    $('#saveShipping').click(function(){
        let icc = $('#icc').val();
        let imei = $('#imei').val();
        let mac_address = $('#mac_address_activation').val();
        let serial_number = $('#no_serie').val();

        let id = "{{$id}}";
        let attended_by = "{{Auth::user()->id}}";
        let imeiText = '';
        let macText = '';
        let snText = '';
        let url = "{{route('shipping.update',['shipping' => 'temp'])}}";
        url = url.replace('temp',id);

        if(imei.length == 0 || /^\s+$/.test(imei)){
            imeiText = 'vacío';
            imei = 'N/A';
        }else{
            imeiText = imei;
        }

        if(mac_address.length == 0 || /^\s+$/.test(mac_address)){
            macText = 'vacío';
            mac_address = 'N/A';
        }else{
            macText = mac_address;
        }

        if(serial_number.length == 0 || /^\s+$/.test(serial_number)){
            snText = 'vacío';
            serial_number = 'N/A';
        }else{
            snText = serial_number;
        }

        console.log(id);

        Swal.fire({
            title: 'ATENCIÓN',
            html: "¿Está seguro de guardar el envío con el ICC <b>"+icc+"</b>, el IMEI <b>"+imeiText+"</b>, la MAC <b>"+macText+"</b> y el No. Serie <b>"+snText+"</b>?",
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
                    url,
                    method: 'PUT',
                    data: {_method:'PUT',_token:'{{csrf_token()}}',icc,imei,serial_number,mac_address,attended_by,status:'progress'},
                    beforeSend: function(){

                    },
                    success: function(response){
                        if(response.http_code){
                            if(response.http_code == 200){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Well done!!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                                setTimeout(function(){ location.reload(); }, 700);
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Woops!!',
                                    text: 'Algo salió mal, intente de nuevo o contacte a Desarrollo.',
                                })
                            }
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Woops!!',
                                text: 'Algo salió mal, intente de nuevo o contacte a Desarrollo.',
                            })
                        }
                    },
                    error:function(){
                        Swal.fire({
                            icon: 'error',
                            title: 'Woops!!',
                            text: 'Algo salió mal, intente de nuevo o contacte a Desarrollo.',
                        })
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

    $('#notifyCCModal').click(function(){
        $('#modalObservations').modal('show');
    });

    $('#notifyCC').click(function(){
        let to_id = "{{$to_id}}";
        let completed_by = "{{Auth::user()->id}}";
        let id = "{{$id}}";
        let url = "{{route('shipping.update',['shipping' => 'temp'])}}";
        let observations = $('#observations').val();
        url = url.replace('temp',id);

        Swal.fire({
            title: 'ATENCIÓN',
            html: "¿Está seguro completar el envío? Se notificará a Call Center para que se comunique con el cliente.",
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
                    url,
                    method: 'PUT',
                    data: {_method:'PUT',_token:'{{csrf_token()}}',completed_by,status:'completado',to_id,observations},
                    beforeSend: function(){

                    },
                    success: function(response){
                        if(response.http_code){
                            if(response.http_code == 200){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Well done!!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                                setTimeout(function(){ location.reload(); }, 700);
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Woops!!',
                                    text: 'Algo salió mal, intente de nuevo o contacte a Desarrollo.',
                                })
                            }
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Woops!!',
                                text: 'Algo salió mal, intente de nuevo o contacte a Desarrollo.',
                            })
                        }
                    },
                    error:function(){
                        Swal.fire({
                            icon: 'error',
                            title: 'Woops!!',
                            text: 'Algo salió mal, intente de nuevo o contacte a Desarrollo.',
                        })
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

    function printRoots(elementToPrint){
        // $('#btnPrint').addClass('d-none');
        // var printContents = document.getElementById('elementToPrint').innerHTML;
        // w = window.open();
        // w.document.write(printContents);
        // w.document.close(); 
        // w.focus();
		// w.print();
		// w.close();
        // $('#btnPrint').removeClass('d-none');
        // return true;

        // var ficha = document.getElementById('elementToPrint');
        // var ventimp = window.open(' ', 'popimpr');
        // ventimp.document.write( ficha.innerHTML );
        // ventimp.document.close();
        // ventimp.print( );
        // ventimp.close();

        var contenido= document.getElementById('elementToPrint').innerHTML;
        var contenidoOriginal= document.body.innerHTML;

        document.body.innerHTML = contenido;

        window.print();

        document.body.innerHTML = contenidoOriginal;
    }
</script>
@endsection