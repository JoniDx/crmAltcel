@extends('layouts.app')

@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Agregar Distribuidor <a href="{{ route('dealers.index')}}" class="badge badge-dark">Administración</a></div>
                <div class="card-body">
                <form action="{{route('dealers.store')}}" method="POST">
                @csrf
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="name" name="name">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="email">Email</label>
                            <input type="text" class="form-control form-control-sm" id="email" name="email">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cellphone">Teléfono</label>
                            <input type="text" class="form-control form-control-sm" id="phone" name="phone">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Dirección</label>
                            <input type="text" class="form-control form-control-sm" id="address" name="address">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="asociation">Asociación</label>
                            <input type="text" class="form-control form-control-sm" id="asociation" name="asociation">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rfc">RFC</label>
                            <input type="text" class="form-control form-control-sm" id="rfc" name="rfc">
                        </div>
                        <input type="hidden" class="form-control form-control-sm" id="who_did_id" name="who_did_id" value="{{Auth::user()->id}}">
                    </div>
                    
                    <button type="submit" class="btn btn-primary" id="form-offer">Guardar</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection