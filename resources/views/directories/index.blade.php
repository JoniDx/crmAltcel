@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Clientes por Contactar</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Dashboard</span></li>
            <li></li>
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
    <div class="panel-body" >
        <table class="table table-bordered table-striped mb-none" id="myTable">
            <thead style="cursor: pointer;">
                <tr>
                    <th>Cliente</th>
                    <th>Motivo/Razón</th>
                    <th>Observaciones</th>
                    <th>Enviado por</th>
                    <th>Fecha de Envío</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td>{{$client['name']}}</td>
                    <td>{{$client['reason']}}</td>
                    <td>{{$client['observations']}}</td>
                    <td>{{$client['sender']}}</td>
                    <td>{{$client['created_at']}}</td>
                    <td>
                        <button class="btn btn-success btn-sm client-shipping" data-shipping="{{$client['shipping_id']}}" data-directory="{{$client['id']}}"><i class="fa fa-pencil"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Contactados</h2>
    </header>
    <div class="panel-body" >
        <table class="table table-bordered table-striped mb-none" id="myTable2">
            <thead style="cursor: pointer;">
                <tr>
                    <th>Cliente</th>
                    <th>Motivo/Razón</th>
                    <th>Observaciones</th>
                    <th>Enviado por</th>
                    <th>Contactado por</th>
                    <th>Fecha de Envío</th>
                    <th>Fecha de Atención</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientsAttended as $client)
                <tr>
                    <td>{{$client['name']}}</td>
                    <td>{{$client['reason']}}</td>
                    <td>{{$client['observations']}}</td>
                    <td>{{$client['sender']}}</td>
                    <td>{{$client['attended_by']}}</td>
                    <td>{{$client['created_at']}}</td>
                    <td>{{$client['attended_at']}}</td>
                    <td>
                        <a href="{{route('shipping.show',['shipping' => $client['shipping_id']])}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<div class="modal fade" id="modalDetails" tabindex="-1" aria-labelledby="modalDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailsLabel">Detalles del Contacto</h5>
            </div>
            <div class="modal-body col-md-12">
                <div class="col-md-4 mb-md mt-md">
                    <label>C.P: </label>
                    <strong id="cp"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>Tipo Asentamiento: </label>
                    <strong id="tipo_asentamiento"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>Colonia: </label>
                    <strong id="colonia"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>Municipio: </label>
                    <strong id="municipio"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>Estado: </label>
                    <strong id="estado"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>Ciudad: </label>
                    <strong id="ciudad"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>No. Ext: </label>
                    <strong id="no_exterior"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>No. Int: </label>
                    <strong id="no_interior"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>Referencias: </label>
                    <strong id="referencias"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>Contacto: </label>
                    <strong class="label label-success mb-sm" id="phone_contact" style="font-size: 14px;"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>Contacto Alternativo: </label>
                    <strong class="label label-success mb-sm" id="phone_alternative" style="font-size: 14px;"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>Recibe: </label>
                    <strong id="recibe"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>ICC: </label>
                    <strong class="label label-success mb-sm" id="icc" style="font-size: 14px;"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>Producto: </label>
                    <strong class="label label-success mb-sm" id="producto" style="font-size: 14px;"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>IMEI: </label>
                    <strong class="label label-success mb-sm" id="imei" style="font-size: 14px;"></strong>
                </div>
                <div class="col-md-4 mb-md mt-md">
                    <label>Canal: </label>
                    <strong id="canal"></strong>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h4>Datos para Solicitud de Activación</h4>
                    <input type="hidden" id="name_petition">
                    <input type="hidden" id="lastname_petition">
                    <input type="hidden" id="client_id_petition">
                    <input type="hidden" id="remitente_petition" value="{{Auth::user()->name}} {{Auth::user()->lastname}}">
                    <input type="hidden" id="email_remitente_petition" value="{{Auth::user()->email}}">
                    <input type="hidden" id="status_petition" value="solicitud">
                    <input type="hidden" id="correo_client_petition">
                    <input type="hidden" id="product_petition">
                    <input type="hidden" id="shipping_id">
                    <input type="hidden" id="directory_id">
                    <input type="hidden" id="icc_to_petition">
                    <input type="hidden" id="imei_to_petition">
                    <input type="hidden" id="serial_number_to_petition">
                    <input type="hidden" id="mac_address_to_petition">

                    <div class="col-md-4 mb-md">
                        <label for="rate">Planes</label>
                        <select class="form-control"  id="rate" name="rate" ></select>
                    </div>

                    <div class="col-md-4 mb-md">
                        <label for="lada">LADA</label>
                        <input class="form-control"  id="lada" name="lada" value="961">
                    </div>

                    <div class="col-md-4 mb-md">
                        <label for="payment_way">Forma de Pago</label>
                        <select class="form-control"  id="payment_way" name="payment_way" >
                            <option value="Promo">Promoción</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-md">
                        <label for="comment">Comentarios:</label>
                        <textarea class="form-control"  id="comment" name="comment" rows="7"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="petition">Solicitar Activación</button>
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
                title: 'ClientesPorContactar',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4 ],
                }
            }],
        });

        $('#myTable2').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                header: true,
                title: 'ClientesContactados',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ],
                }
            }],
        });
    });

    $('.client-shipping').click(function(){
        let shipping = $(this).data('shipping');
        let directory = $(this).data('directory');
        let url = "{{route('showShipping.async',['shipping'=>'temp'])}}";
        url = url.replace('temp',shipping);
        let rates = '', rate_id = 0;
        $('#shipping_id').val(shipping);
        $('#directory_id').val(directory);

        $.ajax({
            url,
            success: function(response){
                $('#cp').html(response.shipping.cp);
                $('#tipo_asentamiento').html(response.shipping.tipo_asentamiento);
                $('#colonia').html(response.shipping.colonia);
                $('#municipio').html(response.shipping.municipio);
                $('#estado').html(response.shipping.estado);
                $('#ciudad').html(response.shipping.ciudad);
                $('#no_exterior').html(response.shipping.no_exterior);
                $('#no_interior').html(response.shipping.no_interior);
                $('#referencias').html(response.shipping.referencias);
                $('#phone_contact').html(response.shipping.phone_contact);
                $('#phone_alternative').html(response.shipping.phone_alternative);
                rate_id = response.shipping.rate_id;

                if(response.shipping.recibe == 'N/A'){
                    $('#recibe').html(response.userData.name+' '+response.userData.lastname);
                }else{
                    $('#recibe').html(response.shipping.recibe);
                }

                $('#icc').html(response.shipping.icc);
                $('#icc_to_petition').val(response.shipping.icc);
                $('#imei_to_petition').val(response.shipping.imei);
                $('#serial_number_to_petition').val(response.shipping.serial_number);
                $('#mac_address_to_petition').val(response.shipping.mac_address);
                $('#producto').html(response.producto);
                $('#imei').html(response.shipping.imei);
                $('#canal').html(response.shipping.canal);
                $('#name_petition').val(response.userData.name);
                $('#lastname_petition').val(response.userData.lastname);
                $('#client_id_petition').val(response.userData.id);
                $('#correo_client_petition').val(response.userData.email);
                $('#product_petition').val(response.producto);
                $('#comment').val('Se debe ACTIVAR con el ICC: '+response.shipping.icc+', el IMEI asignado es: '+response.shipping.imei+'. SE DEBE ACTIVAR CUANTO ANTES, EL CLIENTE YA RECIBIÓ SIM. ');
                
                $.ajax({
                    url: "{{route('get-rates-alta.post')}}",
                    method: "POST",
                    data: {_token: '{{csrf_token()}}',product:response.producto},
                    success: function(rateResponse){
                        rateResponse.forEach(function(element){
                            if(rate_id == element.id){
                                rates+='<option value="'+element.id+'" selected>'+element.name+' - $'+parseFloat(element.price).toFixed(2)+'</option>';
                            }else{
                                rates+='<option value="'+element.id+'">'+element.name+' - $'+parseFloat(element.price).toFixed(2)+'</option>';
                            }

                        });
                        $('#rate').html(rates);
                    }
                });
            }
        });

        $('#modalDetails').modal('show');
    });

$('#petition').click(function(){
    let sender = "{{Auth::user()->id}}";
    let client_id = $('#client_id_petition').val();
    let product = $('#product_petition').val();
    let comment = $('#comment').val();
    let rate_activation = $('#rate').val();
    let payment_way = $('#payment_way').val();
    let lada = $('#lada').val();

    let name = $('#name_petition').val();
    let lastname = $('#lastname_petition').val();
    let remitente = $('#remitente_petition').val();
    let email_remitente = $('#email_remitente_petition').val();
    let status = $('#status_petition').val();
    let correo = $('#correo_client_petition').val();
    let directory_id = $('#directory_id').val();

    let icc = $('#icc_to_petition').val();
    let imei = $('#imei_to_petition').val();
    let serial_number = $('#serial_number_to_petition').val();
    let mac_address = $('#mac_address_to_petition').val();

    // console.log(icc_to_petition);
    // return false;

    $.ajax({
        url: "{{route('petition.store')}}",
        method: "POST",
        data: {
            _token: '{{csrf_token()}}',
            sender,
            client_id,
            product,
            comment,
            rate_activation,
            rate_secondary:rate_activation,
            payment_way,
            plazo:0,
            status,
            lada,
            icc,
            imei,
            serial_number,
            mac_address,
            directory_id
        },
        beforeSend: function(){
            Swal.fire({
                title: 'Guardando solicitud',
                html: 'Espera un poco, un poquito más...',
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response){
            Swal.close();
            if(response == 1){
                $.ajax({
                    url: "{{url('/petitions-notifications')}}",
                    data: {
                        name,
                        lastname,
                        remitente,
                        comment,
                        correo,
                        product,
                        email_remitente,
                        status
                    },
                    beforeSend: function(){
                        Swal.fire({
                            title: 'Notificando',
                            html: 'Espera un poco, un poquito más...',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response){

                        if(response.http_code && response.http_code == 200){
                            Swal.fire({
                                icon: 'success',
                                title: 'Well done!!',
                                text: 'Notificado y guardado con éxito',
                            });
                            setTimeout(function(){ location.reload(); }, 700);
                        }else{
                            Swal.fire({
                                icon:'error',
                                title: 'Well done!!',
                                text: 'Notificado y guardado con éxito',
                            });
                        }
                        
                    }
                });
            }
        }
    });
});
</script>
@endsection