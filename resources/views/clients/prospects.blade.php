@extends('layouts.octopus')

@section('content')
<header class="page-header">
    <h2>Prospectos</h2>
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
<div class="panel-body mb-lg pr-xl pl-xl">
    <div class="row">
        <section class="panel panel-featured-left panel-featured-quartenary col-md-4">
            <div class="panel-body">
                <div class="widget-summary widget-summary-sm">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-quartenary">
                            <i class="fa fa-user"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">HBB</h4>
                            <div class="info">
                                <strong class="amount">{{$HBB}}</strong>
                                <span class="text-primary">PROSPECTOS</span>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a class="text-muted text-uppercase">(view all)</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="panel panel-featured-left panel-featured-primary col-md-4">
            <div class="panel-body">
                <div class="widget-summary widget-summary-sm">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                            <i class="fa fa-user"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">MIFI</h4>
                            <div class="info">
                                <strong class="amount">{{$MIFI}}</strong>
                                <span class="text-primary">PROSPECTOS</span>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a class="text-muted text-uppercase">(view all)</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="panel panel-featured-left panel-featured-warning col-md-4">
            <div class="panel-body">
                <div class="widget-summary widget-summary-sm">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-warning">
                            <i class="fa fa-user"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Telmex</h4>
                            <div class="info">
                                <strong class="amount">{{$Telmex}}</strong>
                                <span class="text-primary">PROSPECTOS</span>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a class="text-muted text-uppercase">(view all)</a>
                        </div>
                    </div>
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
        <h2 class="panel-title">Prospectos</h2>
    </header>
    <div class="panel-body">
        
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead >
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Dirección</th>
                <th scope="col">Contacto</th>
                <th scope="col">Añadido Por</th>
                <th scope="col">Interesado En</th>
                <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($prospects as $prospect )
            <tr style="cursor: pointer;">
                <td>{{ $name = strtoupper($prospect['name'].' '.$prospect['lastname']) }}</td>
                <td>{{ $prospect['email'] }}</td>
                <td>{{ $address = strtoupper($prospect['address']) }}</td>
                <td>{{ $prospect['phone'] }}</td>
                <td>{{ $prospect['who_did_id'] }}</td>
                <td>{{ $prospect['interests'] }}</td>
                <td><button class="btn btn-warning btn-sm mb-xs update-data-client" data-id="{{$prospect['id']}}" data-toggle="modal"><i class="fa fa-edit" ></i></button></td>
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
                                
                                <input type="hidden" name="id_user_update" id="id_user_update">
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

<script src="{{asset('octopus/assets/vendor/pnotify/pnotify.custom.js')}}"></script>
<script>
   $('.update-data-client').click(function(){
    let id = $(this).attr('data-id');
    let token = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            url:"{{route('getAllDataClient.post')}}",
            method: "POST",
            data: {_token:token,id:id},
            success: function(data){
                console.log(data);
                $('#myModalTitle').html('Datos de '+data[0].name+' '+data[0].lastname);
                $('#name').val(data[0].name);
                $('#lastname').val(data[0].lastname);
                $('#email').val(data[0].email);
                $('#cellphone').val(data[0].cellphone);
                $('#date_born').val(data[0].date_born);
                $('#ine_code').val(data[0].ine_code);
                $('#rfc').val(data[0].rfc);
                $('#address').val(data[0].address);
                $('#id_user_update').val(data[0].user_id);
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
        let user_id = $('#id_user_update').val();
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
            user_id:user_id
        };

        $.ajax({
            url:"{{route('setAllDataClient.post')}}",
            method: "POST",
            data: data,
            success: function(response){
                if(response == 1){
                    new PNotify({
                        title: 'Hecho.',
                        text: "<a href='{{route('prospects.index')}}' style='color: white !important;'>Click aquí para actualizar.</a>",
                        type: 'success',
                        icon: 'fa fa-check'
                    });
                }else if(response == 0){
                    new PNotify({
                        title: 'Ooops! Ocurrió un error.',
                        text: "<a href='{{route('prospects.index')}}' style='color: white !important;'>Click aquí para actualizar.</a>",
                        type: 'error',
                        icon: 'fa fa-times'
                    });
                }else if(response == 2){
                    new PNotify({
                        title: 'Ooops! No se pudo ejecutar el cambio.',
                        text: "<a href='{{route('prospects.index')}}' style='color: white !important;'>Click aquí para actualizar.</a>",
                        type: 'warning',
                        icon: 'fa fa-exclamation'
                    });
                }
            }
        }); 
    });
</script>
@endsection