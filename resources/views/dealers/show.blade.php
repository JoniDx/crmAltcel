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
                <p class="text-semibold">{{$dealer->name.' ' .$dealer->lastname}} </p>
                <p class="text-semibold">{{$dealer->email}}</p>
                <!-- <small>A. Einstein, <cite title="Magazine X">Magazine X</cite></small> -->
            <!-- </blockquote> -->
        </div>

        
    </section>

    @if(session('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4 class="alert-heading">Realizado!!</h4>
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
            <form class="form-horizontal form-bordered" method="POST" action="{{route('dealer.update')}}">
                @csrf
                <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                    <!-- <h3>Información personal</h3> -->
                    <div class="col md-12">
                        <div class="col-md-6 ">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="name" value='{{$dealer->name}}'>
                        </div>

                        <div class="col-md-6 ">
                            <label for="lastname" class="form-label">Apellidos</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="lastname" value='{{$dealer->lastname}}'>
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
                            <input type="text" class="form-control form-control-sm mr-2" name="telefono" value='{{$dealer->telefono}}'>
                        </div>

                        <div class="col-md-6 ">
                            <label for="price" class="form-label">Saldo</label>
                            <input type="text" class="form-control form-control-sm mr-2" id="saldo" name="saldo" value='{{$dealer->saldo}}'>
                        </div>

                        <input type="hidden" class="form-control form-control-sm mr-2" id="wholesaler" name="wholesaler" value='{{$dealer->wholesaler}}'>
                        <input type="hidden" class="form-control form-control-sm mr-2" id="salesforce" name="salesforce" value='{{$dealer->salesforce}}'>
                        <input type="hidden" class="form-control form-control-sm mr-2" id="id" name="id" value='{{$dealer->id}}'>
                        {{-- <input type="hidden" class="form-control form-control-sm mr-2" id="saldo" name="saldo" value='{{$dealer->saldo}}'> --}}
                        
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