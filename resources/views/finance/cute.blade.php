@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Reporte de Clientes</h2>
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

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Concesiones</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                @foreach($concesiones as $concesion)
                    <tr>
                        <td>{{$concesion->name}}</td>
                        <td><a href="{{url('/cortes/'.$concesion->id)}}" class="btn btn-info btn-sm mt-xs"><i class="fa fa-eye"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
       
    </script>
</section>
@endsection