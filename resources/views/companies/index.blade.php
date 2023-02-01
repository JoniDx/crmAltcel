@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Promotores</h2>
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

<div class="row" id="create">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Crear empresa</h2>
            </header>

            <div class="panel-body">
                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 6)
                    <form action="{{route('companies.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tipo Persona</label>
                            <div class="col-sm-9">
                                <select name="type_person" class="form-control" required="">
                                    <option value="moral">Moral</option>
                                    <option value="fisica">Física</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Teléfono</label>
                            <div class="col-sm-9">
                                <input type="phone" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">RFC</label>
                            <div class="col-sm-9">
                                <input type="text" name="rfc" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dirección</label>
                            <div class="col-sm-9">
                                <input type="text" name="address" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 mt-md">
                            <button type="submit" class="mb-xs mt-xs mr-xs btn btn-success" >Crear</button>
                        </div> 
                    </form>
                @endif
            </div>
        </section>

    </div>
</div>

@if(Auth::user()->role_id == 1 || Auth::user()->role_id == 6)
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>
            </div>

            <h2 class="panel-title">Empresas</h2>
        </header>
        <div class="panel-body">
            <table class="table table-bordered table-striped mb-none" id="companies">
                <thead >
                    <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Tipo de Persona</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">RFC</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $company)
                        <tr>
                            <td>{{$company->name}}</td>
                            <td>{{$company->type_person}}</td>
                            <td>{{$company->email}}</td>
                            <td>{{$company->phone}}</td> 
                            <td>{{$company->address}}</td> 
                            <td>{{$company->rfc}}</td> 
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endif


<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready( function () {
        $('#companies').DataTable({
            order: false,
        });
    });
</script>
@endsection