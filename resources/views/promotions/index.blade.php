@extends('layouts.octopus')
@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<header class="page-header">
    <h2>Promociones Creadas</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><a href="{{ route('promotion.create')}}"><span>Crear</span></a></li>
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

        <h2 class="panel-title">Promociones</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead >
                <tr>
                <th scope="col">Promoción</th>
                <th scope="col">Dispositivos Permitidos</th>
                <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $promotions as $promotion )
            <tr style="cursor: pointer;" >
                <td>{{ $promotion->name }}</td>
                <td>{{ $promotion->device_quantity }}</td>
                <td>
                    <a href="{{url('/promotion/'.$promotion->id)}}" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</section>
<script>
   
</script>
@endsection