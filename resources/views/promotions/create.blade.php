@extends('layouts.octopus')
@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<header class="page-header">
    <h2>Creación de Promociones</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><a href="{{ route('promotion.index')}}"><span>Ver</span></a></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>
@if(session('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="alert-heading">Well done!!</h4>
        <p>{{session('success')}}</p>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="alert-heading">Upps!!</h4>
        <p>{{session('error')}}</p>
    </div>
@endif
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Promoción Nueva</h2>
            </header>
            
            <div class="panel-body">
                <form class="form-horizontal form-bordered" method="post" action="{{route('promotion.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control form-control-sm" id="name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name">Cantidad de Dispositivos Permitidos</label>
                                    <input type="text" class="form-control form-control-sm" id="price" name="device_quantity" required>
                                </div>
                                

                            </div>

                            <button type="submit" class="btn btn-success" style="margin-top: 1rem;" >Guardar</button>
                        </div>
                    </div>

                </form>
            </div>
        </section>

    </div>
</div>

<script>

</script>
@endsection