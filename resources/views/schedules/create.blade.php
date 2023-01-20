@extends('layouts.octopus')
@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<header class="page-header">
    <h2>Añadir a Agenda</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><a href="{{ route('schedules.index')}}"><span>Administración</span></a></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Agendar Instalación</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="{{route('schedules.store')}}" method="POST">
                @csrf
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Rango de Tiempo y Paquete</h3>
                                </div>
                                <div class="col-md-4">
                                    <label for="date_install_init">Hora y Fecha Inicial</label>
                                    <input type="datetime-local" class="form-control form-control-sm" id="date_install_init" name="date_install_init" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="date_install_final">Hora y Fecha Final</label>
                                    <input type="datetime-local" class="form-control form-control-sm" id="date_install_final" name="date_install_final" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="pack_id">Paquete</label>
                                    <select id="pack_id" name="pack_id" class="form-control form-control-sm">
                                        <option selected value="0">Choose...</option>
                                    @foreach($packs as $pack)
                                        <option value="{{$pack->id}}">{{$pack->name}}</option>
                                    @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <h3>Datos</h3>
                                </div>
                                <div class="col-md-3">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control form-control-sm" id="name" name="name" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="lastname">Apellido</label>
                                    <input type="text" class="form-control form-control-sm" id="lastname" name="lastname" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control form-control-sm" id="email" name="email" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="cellphone">Teléfono</label>
                                    <input type="text" class="form-control form-control-sm" id="cellphone" name="cellphone" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="address">Dirección</label>
                                    <input type="text" class="form-control form-control-sm" id="address" name="address" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="address">Referencia de Dirección</label>
                                    <input type="text" class="form-control form-control-sm" id="reference_address" name="reference_address" required>
                                </div>
                                

                                <input type="hidden" class="form-control form-control-sm" id="user_id" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" class="form-control form-control-sm" id="who_did_id" name="who_did_id" value="{{Auth::user()->id}}">
                            </div>

                            <button type="submit" class="btn btn-success" style="margin-top: 1rem;" id="save">Guardar</button>
                        </div>
                    </div>

                </form>
            </div>
        </section>

    </div>
</div>

@endsection