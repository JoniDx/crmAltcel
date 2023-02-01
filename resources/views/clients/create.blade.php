@extends('layouts.octopus')
@section('content')
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            <ul>
                <li>{{ $error }}</li>
            </ul>            
        </div>
    @endforeach

    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif

    <header class="page-header">
        <h2>Nuevo Cliente</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{route('home')}}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
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

                    <h2 class="panel-title">Alta</h2>
                </header>
                <div class="panel-body">
                    <form class="form-horizontal form-bordered" action="{{route('clients.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="row">                               
                                    <div class="col-md-12">
                                        <h3>Contacto</h3>
                                        
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="col-md-12">
                                            <section class="form-group-vertical">
                                                <div class="input-group input-group-icon">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-user"></i></span>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="Nombre" id="name" name="name">
                                                </div>

                                                <div class="input-group input-group-icon">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-user"></i></span>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="Apellido" id="lastname" name="lastname">
                                                </div>

                                                <div class="input-group finput-group-icon">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-user"></i></span>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="RFC" id="rfc" name="rfc">
                                                </div>

                                                <div class="input-group input-group-icon">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-calendar"></i></span>
                                                    </span>
                                                    <input class="form-control" type="date" id="date_born" name="date_born">
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="col-md-12">
                                            <section class="form-group-vertical">
                                                <div class="input-group input-group-icon">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-home"></i></span>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="Dirección" id="address" name="address">
                                                </div>

                                                <div class="input-group input-group-icon">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-envelope"></i></span>
                                                    </span>
                                                    <input class="form-control" type="email" placeholder="Email" id="email" name="email">
                                                </div>

                                                <div class="input-group input-group-icon">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-user"></i></span>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="Código INE" id="ine_code" name="ine_code">
                                                </div>

                                                <div class="input-group input-group-icon">
                                                    <span class="input-group-addon">
                                                        <span class="icon"><i class="fa fa-phone"></i></span>
                                                    </span>
                                                    <input class="form-control" type="text" placeholder="Teléfono Contacto" id="cellphone" name="cellphone" maxlength="10">
                                                </div>
                                            </section>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-xs mb-md">
                                        <label for="interests">Producto de Interés</label>
                                        <select id="interests" name="interests" class="form-control form-control-sm" required="">
                                            <option selected value="Ninguno">Ninguno...</option>
                                            <option value="MOV">MOV</option>
                                            <option value="MIFI">MIFI</option>
                                            <option value="Portabilidad Telmex">Portabilidad Telmex</option>
                                        </select>
                                    </div>

                                    <input type="hidden" name="user" id="user" value="{{ Auth::user()->id }}" required>

                                    <div class="col-md-12" style="margin-top: 1rem;">
                                        <button type="submit" class="btn btn-primary" id="send">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection