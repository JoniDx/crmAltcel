@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Distribuidores</h2>
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

@if(session('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="alert-heading">Well done!!</h4>
        <p>{{session('message')}}</p>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="alert-heading">Oopps!!</h4>
        <p>{{session('error')}}</p>
    </div>
@endif
@if(session('warning'))
    <div class="alert alert-warning" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="alert-heading">Oopps!!</h4>
        <p>{!! session('warning') !!}</p>
    </div>
@endif
<div class="row" id="create">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Crear Distribuidor</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" method="POST" action="{{route('dealer.store')}}">
                @csrf

                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <!-- <h3>Información personal</h3> -->
                        <div class="col md-12">
                            
                            <div class="col-md-6 ">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control form-control-sm mr-2" name="username" >
                            </div>
                            <div class="col-md-6 ">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control form-control-sm mr-2" name="email" >
                            </div>
                            <div class="col-md-6 ">
                                <label for="email" class="form-label">Teléfono</label>
                                <input type="text" class="form-control form-control-sm mr-2" name="cellphone" >
                            </div>
                            <div class="col-md-6 ">
                                <label for="first_name" class="form-label">Nombre</label>
                                <input type="text" class="form-control form-control-sm mr-2" name="first_name" >
                            </div>
                            <div class="col-md-6 ">
                                <label for="last_name" class="form-label">Apellidos</label>
                                <input type="text" class="form-control form-control-sm mr-2" name="last_name" >
                            </div>
                            <div class="col-md-6 ">
                                <label for="price" class="form-label">Contraseña</label>
                                <input type="text" class="form-control form-control-sm mr-2" name="password" >
                            </div>
                            <div class="col-md-6 ">
                                <label for="price" class="form-label">Saldo</label>
                                <input type="text" class="form-control form-control-sm mr-2" id="balance" name="saldo" value="0.00">
                            </div>
                            <input type="hidden" class="form-control form-control-sm mr-2" id="wholesaler" name="wholesaler" value='0'>
                            <input type="hidden" class="form-control form-control-sm mr-2" id="salesforce" name="salesforce" value='0'>
                            <div class="checkbox col-md-3">
                                <label class="control-label ml-sm">
                                    <input type="checkbox" id="wholesaler_check">
                                    Mayorista
                                </label>
                            </div>
                            <div class="checkbox col-md-3">
                                <label class="control-label ml-sm">
                                    <input type="checkbox" id="salesforce_check">
                                    Saldo Libre
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 1rem;">
                        <button type="submit" class="btn btn-success" id="savePrice">Guardar</button>
                        </div>
                    </div>              

                </form>
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

        <h2 class="panel-title">Distribuidores Existentes</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead >
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Username</th>
                <th scope="col">Saldo</th>
                <th scope="col">Saldo Libre</th>
                <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dealers as $dealer)
                <tr>
                    <td>{{$dealer->first_name}} {{$dealer->last_name}}</td>
                    <td>{{$dealer->username}}</td>
                    <td id="balance-{{$dealer->id}}">${{number_format($dealer->saldo,2)}}</td>
                    <td>{{$freBaalance = $dealer->salesforce == 0 ? 'NO' : 'SI'}}</td>
                    <td>
                        <a href="{{route('dealer.show',['dealer' => $dealer->id])}}" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Ver detalles"><i class="fa fa-eye"></i></a>
                        <button class="btn btn-warning btn-xs editBalance" data-balance="{{$dealer->saldo}}" data-name="{{$dealer->first_name.' '.$dealer->last_name}}" data-dealer-id="{{$dealer->id}}" data-toggle="tooltip" data-placement="top" data-original-title="Ajustar saldo"><i class="fa fa-edit"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<div class="modal fade" id="modalDealer" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-dark" id="myModalTitle">Saldo</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-bordered">
                    <input type="hidden" id="methodUpdate" name="_method" value="PUT">
                    <input type="hidden" id="tokenUpdate" name="_token" value="{{ csrf_token() }}">
                
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <div class="col-md-6 ">
                            <label for="price" class="form-label">Cantidad $:</label>
                            <input type="number" class="form-control form-control-sm mr-2" id="balanceExtra" name="balanceExtra" value='0.00' >
                            <input type="hidden" class="form-control form-control-sm mr-2" id="balanceEdit" name="balanceEdit" >
                        </div>
                    </div>              

                    <input type="hidden" id="dealer_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="add_update_balance">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('octopus/assets/vendor/pnotify/pnotify.custom.js')}}"></script>
<script>
$('#balance, #balanceExtra').on('input', function () {
    this.value = this.value.replace(/[^0-9.]/g, '');
});

$('#wholesaler_check').click(function(){
    if($(this).is(':checked')){
        $('#wholesaler').val(1);
    }else{
        $('#wholesaler').val(0);
    }
});

$('#salesforce_check').click(function(){
    if($(this).is(':checked')){
        $('#salesforce').val(1);
    }else{
        $('#salesforce').val(0);
    }
});

function getData(){
    let id = $('#users').val();

    if(id == 0){
        $('#data-user').addClass('d-none');
        $('#name_user').html('');
        $('#lastname_user').html('');
        $('#email_user').html('');
    }
    else{
        let name = $('#users option:selected').data('name');
        let lastname = $('#users option:selected').data('lastname');
        let email = $('#users option:selected').data('email');

        $('#name_user').html(name);
        $('#lastname_user').html(lastname);
        $('#email_user').html(email);
        $('#newDealerData').val(name+' '+lastname);
        $('#data-user').removeClass('d-none');
    }
}

$('.editBalance').click(function(){
    let balance = $(this).data('balance');
    let dealer = $(this).data('name');
    let dealer_id = $(this).data('dealer-id');
    
    $('#dealer_id').val(dealer_id);
    $('#myModalTitle').html('Saldo de '+dealer);
    $('#balanceEdit').val(balance.toFixed(2));
    $('#modalDealer').modal('show');
});

$('#add_update_balance').click(function(){
    let balance = $('#balanceEdit').val();
    let balanceExtra = $('#balanceExtra').val();
    let id = $('#dealer_id').val();
    let method = $('#methodUpdate').val();
    let token = $('#tokenUpdate').val();
    let url = "{{route('dealer.update',['dealer' => 'temp'])}}";
    url = url.replace('temp',id);

    $.ajax({
        url: url,
        method: 'PUT',
        data: {_token:token, _method:method, saldo:balance, balanceExtra, user_id:"{{Auth::user()->id}}"},
        beforeSend: function(){
            Swal.fire({
                    title: 'Estamos trabajando en ello...',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                    }
            });
        },
        success: function(response){
            Swal.close();
            
            if(response.http_code == 1){
                $('#balance-'+id).html('$'+parseFloat(balance).toFixed(2));
                new PNotify({
                    title: response.message,
                    text: "<a href='{{route('dealer.index')}}' style='color: white !important;'>Click aquí para actualizar.</a>",
                    type: 'success',
                    icon: 'fa fa-check'
                });
            }else if(response.http_code == 0){
                new PNotify({
                    title: 'Oopps!',
                    text: response.message,
                    type: 'error',
                    icon: 'fa fa-times'
                });
            }
        }
    });
});
</script>
@endsection