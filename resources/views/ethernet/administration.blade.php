@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Administación de Paquetes de Internet</h2>
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
<div class="col-md-12">
    <div class="tabs tabs-success">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#home" data-toggle="tab"><i class="fa fa-star"></i> Home</a>
            </li>
            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 4 || Auth::user()->role_id == 5)
            <li>
                <a href="#paquete" data-toggle="tab">Paquete</a>
            </li>
            @endif
            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 6)
            <li>
                <a href="#radiobase" data-toggle="tab">Radiobase</a>
            </li>
            @endif
        </ul>
        <div class="tab-content">
            <div id="home" class="tab-pane active">
                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 4 || Auth::user()->role_id == 5)
                <h3>Paquetes</h3>
                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead >
                            <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Servicio</th>
                            <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach( $packs as $pack )
                        <tr style="cursor: pointer;" >
                            <td>{{ $pack->name }}</td>
                            <td>{{ $pack->description }}</td>
                            <td>${{ number_format($pack->price,2) }}</td>
                            <td>{{ $pack->service_name }}</td>
                            <td>
                                @if($pack->status == 'activo')
                                    <button type="button" class="btn btn-danger btn-xs button-status" data-status="activo" data-id="{{$pack->id}}" data-type="ethernet">Desactivar</button>
                                @elseif($pack->status == 'inactivo')
                                    <button type="button" class="btn btn-success btn-xs button-status" data-status="inactivo" data-id="{{$pack->id}}" data-type="ethernet">Activar</button>
                                @endif
                                <button type="button" class="btn btn-info btn-xs update-pack" data-id="{{$pack->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
                <h3>Radiobases</h3>
                    <table class="table table-bordered table-striped mb-none" id="datatable-default3">
                        <thead >
                            <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">IP Address</th>
                            <th scope="col">Latitud</th>
                            <th scope="col">Longitud</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach( $radiobases as $radiobase )
                        <tr style="cursor: pointer;" >
                            <td>{{ $radiobase->name }}</td>
                            <td>{{ $radiobase->address }}</td>
                            <td>{{ $radiobase->ip_address }}</td>
                            <td>{{ $radiobase->lat }}</td>
                            <td>{{ $radiobase->lng }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
            <div id="paquete" class="tab-pane">
                <h3>Creación de Paquete</h3>
                <form class="form-horizontal form-bordered">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control-label" for="name">Nombre</label>
                                    <input type="text" class="form-control" id="name">
                                </div>
                                <div class="col-md-5">
                                    <label class="control-label" for="description">Description</label>
                                    <input type="text" class="form-control" id="description">
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label" for="service_name">Servicio</label>
                                    <select class="form-control" id="service_name">
                                        <option value="Conecta">Conecta</option>
                                        <option value="Telmex">Telmex</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="recurrency">Recurrency</label>
                                    <input type="text" class="form-control" id="recurrency">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="price_s_iva">Precio s/IVA</label>
                                    <input type="text" class="form-control" id="price_s_iva" autocomplete="off">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="price">Precio</label>
                                    <input type="text" class="form-control" id="price" autocomplete="off">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="price_install">Precio Instalación</label>
                                    <input type="text" class="form-control" id="price_install" autocomplete="off">
                                </div>
                                
                                <div class="col-md-12" style="margin-top: 1rem;">
                                    <button type="button" class="btn btn-primary mb-2" id="add_pack">Añadir</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
            <div id="radiobase" class="tab-pane">
                <h3>Creación de Radiobase</h3>
                <form class="form-horizontal form-bordered">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control-label" for="name_r">Nombre</label>
                                    <input type="text" class="form-control" id="name_r">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="ip_address_r">IP Address</label>
                                    <input type="text" class="form-control" id="ip_address_r">
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label" for="address_r">Dirección</label>
                                    <input type="text" class="form-control" id="address_r">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="lat_r">Lat</label>
                                    <input type="text" class="form-control" id="lat_r">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="lng_r">Lng</label>
                                    <input type="text" class="form-control" id="lng_r">
                                </div>
                                <div class="col-md-12" style="margin-top: 1rem;">
                                    <button type="button" class="btn btn-primary mb-2" id="add_radiobase">Añadir</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalInfoPack" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalTitle"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-bordered" action="" method="POST" id="form-update-pack">
                    @csrf
                
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <h4>Status: <span class="label " id="status_update"></span></h4>
                        <div class="form-group col-md-12">
                            <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label for="name_update" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="name_update" name="name" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="description_update" class="form-label">Descripción</label>
                                    <input type="text" class="form-control" id="description_update" name="description" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="service_name_update">Servicio</label>
                                    <select id="service_name_update" name="service_name" class="form-control form-control-sm">
                                        
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="price_s_iva_update" class="form-label">Precio s/IVA</label>
                                    <input type="text" class="form-control" id="price_s_iva_update" name="price_s_iva" autocomplete="off" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="price_update" class="form-label">Precio</label>
                                    <input type="text" class="form-control" id="price_update" name="price" autocomplete="off" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="price_install_update" class="form-label">Precio Instalación</label>
                                    <input type="text" class="form-control" id="price_install_update" name="price_install" autocomplete="off" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="recurrency_update" class="form-label">Recurrency</label>
                                    <input type="text" class="form-control" id="recurrency_update" name="recurrency" required>
                                </div>
                                
                                <!-- <input type="hidden" name="id" id="id_user_update"> -->
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
$('#price_s_iva, #price, #price_install, #recurrency, #price_s_iva_update, #price_update, #price_install_update, #recurrency_update').on('input', function () {
    this.value = this.value.replace(/[^0-9.]/g, '');
});
$('#price_s_iva').keyup(function(){
    let price_s_iva = $(this).val();
    let iva = 0.16;
    if(price_s_iva.length != 0){
        price_s_iva = parseFloat(price_s_iva);
        iva = parseFloat(iva);
        let price = price_s_iva * iva;
        price = price + price_s_iva;
        
        $('#price').val(price);
    }else{
        $('#price').val('');
    }
    
});

    $('#add_pack').click(function() {
        let name = $('#name').val();
        let description = $('#description').val();
        let service_name = $('#service_name').val();
        let recurrency = $('#recurrency').val();
        let price = $('#price').val();
        let price_s_iva = $('#price_s_iva').val();
        let price_install = $('#price_install').val();

        let headers = {
            headers: {
                'Content-type': 'application/json'
            }
        };
        let data = {
            name: name,
            description: description,
            service_name: service_name,
            recurrency: recurrency,
            price: price,
            price_s_iva: price_s_iva,
            price_install: price_install
        };

        axios.post('/create-pack', data, headers).then(response => {
            $('#name').val('');
            $('#description').val('');
            $('#service_name').val('');
            $('#recurrency').val('');
            $('#price').val('');
            $('#price_s_iva').val('');
            $('#price_install').val('');

            Swal.fire({
                icon: 'success',
                title: 'Todo ready!',
                showConfirmButton: false,
                timer: 1500
            });
            location.reload();
        }).catch(e => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: e,
            });
        })
    });

    $('#add_radiobase').click(function() {
        let name = $('#name_r').val();
        let address = $('#address_r').val();
        let ip_address = $('#ip_address_r').val();
        let lat = $('#lat_r').val();
        let lng = $('#lng_r').val();

        let headers = {
            headers: {
                'Content-type': 'application/json'
            }
        };
        let data = {
            name: name,
            address: address,
            ip_address: ip_address,
            lat: lat,
            lng: lng
        };

        axios.post('/create-radiobase', data, headers).then(response => {
            $('#name_r').val('');
            $('#address_r').val('');
            $('#ip_address_r').val('');
            $('#lat_r').val('');
            $('#lng_r').val('');

            Swal.fire({
                icon: 'success',
                title: 'Todo ready!',
                showConfirmButton: false,
                timer: 1500
            })
            location.reload();
        }).catch(e => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: e,
            });
        })
    });

    $('.button-status').click(function(){
        let status = $(this).attr('data-status');
        let id = $(this).attr('data-id');
        let type = $(this).attr('data-type');

        $.ajax({
                url:"{{route('change-status.rates-packs')}}",
                method: "GET",
                data: {status: status, id: id, type: type},
                success: function(data){
                    location.reload();
                }
            });
    });

    $('.update-pack').click(function(){
        let id = $(this).attr('data-id');
        let status_class = '';
        $.ajax({
            url:"{{route('get-pack-ethernet.get')}}",
            data: {id:id},
            success: function(data){
                // console.log(data);
                $('#myModalTitle').html('<strong>'+data.name+'</strong>');
                $('#name_update').val(data.name);
                $('#description_update').val(data.description);
                if(data.service_name == 'Telmex'){
                    $('#service_name_update').html(
                        '<option value="'+data.service_name+'" selected>'+data.service_name+'</option>'+
                        '<option value="Conecta">Conecta</option>'
                    );
                }else if(data.service_name == 'Conecta'){
                    $('#service_name_update').html(
                        '<option value="'+data.service_name+'" selected>'+data.service_name+'</option>'+
                        '<option value="Telmex">Telmex</option>'
                    );
                }

                $('#price_s_iva_update').val(data.price_s_iva);
                $('#price_update').val(data.price);
                $('#price_install_update').val(data.price_install);
                $('#recurrency_update').val(data.recurrency);
                $('#status_update').html(data.status);
                status_class = data.status == 'activo' ? 'label-success' : 'label-danger';
                
                $('#status_update').removeClass('label-success');
                $('#status_update').removeClass('label-danger');
                $('#status_update').addClass(status_class);
                var url = "{{ route('update-pack-ethernet.get', ['pack_id' => 'temp']) }}";
                url = url.replace('temp', data.id);
                $('#form-update-pack').attr('action', url);
                $('#modalInfoPack').modal('show');
            }
        });
    });

    $('#add_update').click(function(){
        Swal.fire({
            title: '¿Está seguro de guardar estos cambios?',
            text: "Le sugiero corroborar nuevamente los datos antes de guardarlos.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SÍ, ESTOY SEGURO.'
            }).then((result) => {
            if (result.isConfirmed) {
                $("#form-update-pack").submit();
                 
                Swal.fire({
                    icon: 'success',
                    title: 'Guardando cambios...',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        })
    });
</script>
@endsection