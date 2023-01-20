@extends('layouts.octopus')
@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<header class="page-header">
    <h2>Preactivaciones</h2>
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

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Preactivaciones Pendientes</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead >
                <tr>
                <th scope="col">Cliente</th>
                <th scope="col">Plan</th>
                <th scope="col">MSISDN</th>
                <th scope="col">Dispositivo</th>
                <th scope="col">Tipo</th>
                <th scope="col">Fecha Operación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($preactivations as $preactivation)
                <tr class="preactivate" style="cursor: pointer;" id="{{$preactivation->id}}">
                    <td>{{$preactivation->client_name.' '.$preactivation->client_lastname}}</td>
                    <td>{{$preactivation->rate_name}}</td>
                    <td><span class="label label-info" style="font-size: 12px;">{{$preactivation->MSISDN}} - {{$preactivation->ICC}}</span></td>
                    <td><span class="label label-info" style="font-size: 12px;">{{$preactivation->IMEI}}</span></td>
                    <td>{{$preactivation->producto}}</td>
                    <td>{{$preactivation->date_activation}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</section>
<script>
    $('.preactivate').click(function(){
        let id = $(this).attr('id');
        let url = "{{route('activations.show',['activation'=>'temp'])}}";
        url = url.replace('temp',id);
        location.href = url;
    });
</script>
@endsection