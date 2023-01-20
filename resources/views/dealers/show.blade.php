@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Detalles de Distribuidor</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('dealer.index')}}">
                    <i class="fa fa-home"></i> Volver
                </a>
            </li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>

<div class="row">
    <section class="panel panel-horizontal">
        <header class="panel-heading bg-success">
        <div class="panel-heading-icon">
                <i class="fa fa-dollar"></i>
            </div>
        </header>
        <div class="panel-body p-lg">
            <h3 class="text-semibold mt-sm">Saldo Disponible: ${{number_format($dealer->saldo,2)}} <i class="{{$icon}}"></i></h3>
            <!-- <blockquote class="info"> -->
                <p class="text-semibold">{{$dealer->first_name.' ' .$dealer->last_name}} - Username: {{$dealer->username}}</p>
                <p class="text-semibold">{{$dealer->email}}</p>
                <!-- <small>A. Einstein, <cite title="Magazine X">Magazine X</cite></small> -->
            <!-- </blockquote> -->
        </div>

        
    </section>

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
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>
            </div>

            <h2 class="panel-title">Actualizar Distribuidor</h2>
        </header>
        <div class="panel-body">
            <form class="form-horizontal form-bordered" method="POST" action="{{route('dealer.storeTwo')}}">
            @csrf

                <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                    <!-- <h3>Información personal</h3> -->
                    <div class="col md-12">
                        
                        <div class="col-md-6 ">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="username" value='' >
                        </div>
                        <div class="col-md-6 ">
                            <label for="first_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="first_name" value='{{$dealer->first_name}}'>
                        </div>
                        <div class="col-md-6 ">
                            <label for="last_name" class="form-label">Apellidos</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="last_name" value='{{$dealer->last_name}}'>
                        </div>
                        <div class="col-md-6 ">
                            <label for="price" class="form-label">Contraseña</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="password" >
                        </div>
                        <div class="col-md-6 ">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="email" value='{{$dealer->email}}'>
                        </div>
                        <div class="col-md-6 ">
                            <label for="email" class="form-label">Teléfono</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="cellphone" value='{{$dealer->cellphone}}'>
                        </div>
                        <div class="col-md-6 ">
                            <label for="price" class="form-label">Saldo</label>
                            <input type="text" class="form-control form-control-sm mr-2" id="balance" name="saldoExtra" value='0'>
                        </div>
                        <input type="hidden" class="form-control form-control-sm mr-2" id="wholesaler" name="wholesaler" value='{{$dealer->wholesaler}}'>
                        <input type="hidden" class="form-control form-control-sm mr-2" id="salesforce" name="salesforce" value='{{$dealer->salesforce}}'>
                        <input type="hidden" class="form-control form-control-sm mr-2" id="salesforce" name="id" value='{{$dealer->id}}'>
                        <input type="hidden" class="form-control form-control-sm mr-2" id="salesforce" name="user_id" value='{{Auth::user()->id}}'>
                        <input type="hidden" class="form-control form-control-sm mr-2" id="salesforce" name="saldo" value='{{$dealer->saldo}}'>
                        <div class="checkbox col-md-3">
                            <label class="control-label ml-sm">
                                <input type="checkbox" id="wholesaler_check" {{$checked = $dealer->wholesaler == 1 ? 'checked' : ''}}>
                                Mayorista
                            </label>
                        </div>
                        <div class="checkbox col-md-3">
                            <label class="control-label ml-sm">
                                <input type="checkbox" id="salesforce_check" {{$checked1 = $dealer->salesforce == 1 ? 'checked' : ''}}>
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

<!-- <section class="panel">
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
                <th scope="col">Email</th>
                <th scope="col">Saldo</th>
                <th scope="col">Creado por</th>
                <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                
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
                            <label for="price" class="form-label">Disponible</label>
                            <input type="text" class="form-control form-control-sm mr-2" id="balanceEdit" name="balanceEdit" >
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
</div> -->

<script>
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
</script>
@endsection