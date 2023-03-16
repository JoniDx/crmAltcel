@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Reporte de Clientes</h2>
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
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <form class="form-horizontal form-bordered" action="{{route('reportscAtivations')}}">
                        <div class="col-md-4">
                            <label for="type">Concepto:</label>
                            <select class="form-control" data-plugin-multiselect name="type" id="type">
                                <option value="" selected>Seleccione un opción</option>
                                <option value="general">General</option>
                                <option value="MIFI">MIFI</option>
                                <option value="HBB">HBB</option>
                                <option value="MOV">MOV</option>
                                <option value="TELMEX">TELMEX</option>
                            </select>
                        </div>
                            
                        <div class="col-md-8  mb-sm">
                            <label class="">Fecha</label>
                            <div class="input-daterange input-group" data-plugin-datepicker>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input autocomplete="off" type="text" class="form-control" id="start_date" name="start">
                                <span class="input-group-addon">a</span>
                                <input autocomplete="off" type="text" class="form-control" id="end_date" name="end">
                            </div>
                        </div>

                        <div class="col-md-12 mt-md">
                            <button class="btn btn-primary btn-sm" ><i class="fa fa-cloud-download"></i> Consultar</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>
            <h2 class="panel-title">Clientes</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>MSISDN</th>
                    <th>No. Serie</th>
                    <th>IMEI</th>
                    <th>MAC</th>
                    <th>ICC</th>
                    <th>Plan/Paquete</th>
                    <th>Servicio</th>
                    <th>Status</th>
                    <th>Plan</th>
                    <th>CPE</th>
                    <th>Expira</th>
                    <th>Fecha</th>
                    <th>Fecha de Expiración</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $amount_total = 0;
                    $amount_pendiente = 0;
                @endphp
                @foreach( $clients as $client )
                    <tr class="{{$client->service}} "  >
                        <td>{{ $name = strtoupper($client->name.' '.$client->lastname) }}</td>
                        <td>{{ $client->cellphone }}</td>
                        <td>{{ $client->MSISDN }}</td>
                        <td>{{ $client->serial_number }}</td>
                        <td>{{ substr($client->imei,4) }}</td>
                        <td>{{ $client->mac }}</td>
                        <td>{{$client->icc }}</td>
                        <td>{{ $rate = strtoupper($client->rate_name) }}</td>
                        <td>{{ $service = strtoupper($client->service) }}</td>
                        @php
                        $service = trim($service);
                        @endphp
                        @if($service == 'MOV')
                        <td class="">
                            @if($client->traffic_outbound == 'inactivo')
                                <span class="label label-danger mb-sm">Tráfico: {{ $client->traffic_outbound }}</span>
                            @else
                                <span class="label label-success mb-sm">Tráfico: {{ $client->traffic_outbound }}</span>
                            @endif

                            @if($client->status_altan == 'activo')
                                <span class="label label-success mb-sm">Status: {{ $client->status_altan }}</span>
                            @else
                                <span class="label label-danger mb-sm">Status: {{ $client->status_altan }}</span>
                            @endif
                        </td>
                        @else
                        <td>
                            @if($client->traffic_outbound_incoming == 'inactivo')
                                <span class="label label-danger mb-sm">Tráfico: {{ $client->traffic_outbound_incoming }}</span>
                            @else
                                <span class="label label-success mb-sm">Tráfico: {{ $client->traffic_outbound_incoming }}</span>
                            @endif

                            @if($client->status_altan == 'activo')
                                <span class="label label-success mb-sm">Status: {{ $client->status_altan }}</span>
                            @else
                                <span class="label label-danger mb-sm">Status: {{ $client->status_altan }}</span>
                            @endif
                        </td>

                        @endif
                        <td>${{ number_format($client->amount_rate,2) }}</td>
                        <td>${{ number_format($client->amount_device,2) }}</td>
                        <td>{{ $client->date_expire }}</td>
                        <td>{{ $client->date_activation }}</td>
                        <td>{{$client->date_expire}}</td>
                        <td class="td-grid">
                            <button class="btn btn-warning update-data-client" data-id="{{$client->id}}" data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar datos del cliente">Editar <i class="fa fa-edit" ></i></button>
                            <button class="btn btn-info altan" data-id-dn="{{$client->id_dn}}" data-id-act="{{$client->id_act}}" data-service="{{trim($client->service)}}">Información</button>
                            <button class="btn btn-danger porta" id="" data-port="{{$client->portado}}" data-dn="{{$client->MSISDN}}">Portado</button>
                            <a href="{{url('/clients-details/'.$client->id)}}" class="btn btn-info btn-sm mb-xs" data-toggle="tooltip" data-placement="left" title="" data-original-title="Información del cliente"> Ver <i class="fa fa-info-circle"></i></a>
                        </td>

                    </tr>
                @endforeach
                @foreach( $clientsTwo as $clientTwo )
                    <tr class="{{$clientTwo->service}}">
                        <td>{{ $name = strtoupper($clientTwo->name.' '.$clientTwo->lastname) }}</td>
                        <td>{{ $clientTwo->cellphone }}</td>
                        <td>{{ $clientTwo->number }}</td>
                        <td>{{ $clientTwo->serial_number }}</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>{{ $rate = strtoupper($clientTwo->pack_name) }}</td>
                        <td>{{ $service = strtoupper($clientTwo->service) }}</td>
                        <td>N/A</td>
                        <td>${{ number_format($clientTwo->amount_pack,2) }}</td>
                        <td>${{ number_format($clientTwo->amount_install,2) }}</td>
                        <td>N/A</td>
                        <td>{{ $clientTwo->date_instalation }}</td>
                        <td>N/A</td>
                        <td>N/A</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<div class="modal fade" id="modalInfoClient" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-dark text-bold" id="myModalTitle"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-bordered" action="" method="" id="form-update-rate">
                
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <div class="form-group col-md-12">
                            <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Nombre(s)</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="lastname" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="cellphone" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="cellphone" name="cellphone" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="date_born" class="form-label">Fecha Nac.</label>
                                    <input type="date" class="form-control" id="date_born" name="date_born" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="ine_code" class="form-label">Folio Identificación</label>
                                    <input type="text" class="form-control" id="ine_code" name="ine_code" placeholder="Código INE, Cédula o Pasaporte" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="rfc" class="form-label">RFC</label>
                                    <input type="text" class="form-control" id="rfc" name="rfc" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Dirección</label>
                                    <!-- <input type="text" class="form-control" id="address" name="address" required> -->
                                    <textarea class="form-control" name="address" id="address" cols="30" rows="5"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <h5 class="text-dark text-bold" id="who_did"></h5>
                                </div>
                                
                                <input type="hidden" name="id_client" id="id_client">
                            </div>
                        </div>
                    </div>              

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="add_update">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $('.altan').click(function(){
        let id_dn = $(this).data('id-dn');
        let id_act = $(this).data('id-act');
        let service = $(this).data('service');
        let url = "{{route('showProductDetails',['id_dn'=>'temp','id_act'=>'temp1','service'=>'temp2'])}}";
        url = url.replace('temp',id_dn);
        url = url.replace('temp1',id_act);
        url = url.replace('temp2',service);

        location.href = url;
    });

    $('.porta').click(function(){
        let portado = $(this).data('port');
        let dn = $(this).data('dn');
        $.ajax({
            url: "{{route('numPortado')}}",
            method:'GET',
            data: {portado,dn},
            success: function(response){
                console.log(response)
            }
        })
    })

    $('.update-data-client').click(function(){
        let id = $(this).attr('data-id');
        let token = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            url:"{{route('getAllDataClient.post')}}",
            method: "POST",
            data: {_token:token,id:id},
            success: function(data){
                // console.log(data);
                $('#myModalTitle').html('Datos de '+data[0].name+' '+data[0].lastname);
                $('#name').val(data[0].name);
                $('#lastname').val(data[0].lastname);
                $('#email').val(data[0].email);
                $('#cellphone').val(data[0].cellphone);
                $('#date_born').val(data[0].date_born);
                $('#ine_code').val(data[0].ine_code);
                $('#rfc').val(data[0].rfc);
                $('#address').val(data[0].address);
                $('#id_client').val(data[0].id);
                $('#who_did').html('Añadido por: '+data[0].who_did);
                $('#modalInfoClient').modal('show');
            }
        }); 
    });

    $('#add_update').click(function(){
        let name = $('#name').val();
        let lastname = $('#lastname').val();
        let email = $('#email').val();
        let cellphone = $('#cellphone').val();
        let date_born = $('#date_born').val();
        let ine_code = $('#ine_code').val();
        let rfc = $('#rfc').val();
        let address = $('#address').val();
        let id = $('#id_client').val();
        let token = $('meta[name="csrf-token"]').attr('content');

        let data = {
            _token:token,
            name:name,
            lastname:lastname,
            email:email,
            cellphone:cellphone,
            date_born:date_born,
            ine_code:ine_code,
            rfc:rfc,
            address:address,
            id:id
        };

        $.ajax({
            url:"{{route('setAllDataClient.post')}}",
            method: "POST",
            data: data,
            success: function(response){
                console.log(response);
                if(response == 1){
                    swal_succes('¡Guardado!',"Cliente Actualizado.");
                }else if(response == 0){
                    swal_error('Ooops! Ocurrió un error.')
                }else if(response == 2){
                    swal_warning('Ooops! No se pudo ejecutar el cambio.')
                }
            }
        }); 
    });
</script>

@endsection