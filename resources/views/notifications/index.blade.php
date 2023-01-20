@extends('layouts.octopus')
@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<header class="page-header">
    <h2>Notificaciones Altán</h2>
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

        <h2 class="panel-title">Pendientes</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead >
                <tr>
                <th scope="col">Fecha</th>
                <th scope="col">MSISDN</th>
                <th scope="col">Tipo</th>
                <th scope="col">Status</th>
                <th scope="col">Fecha Expedición</th>
                <th scope="col">Detalles</th>
                <th scope="col">Opciones</th>
                
                </tr>
            </thead>
            <tbody>
            @foreach( $notifications as $notification )
            <tr style="cursor: pointer;" class="rate-table" data-id="{{$notification->id}}">
                <td>{{ $notification->date_notification }}</td>
                <td>{{ $notification->identifier }}</td>
                <td>{{ $notification->eventType }}</td>
                <td>
                    @if($notification->status == 'pendiente')
                    <span class="label label-warning">{{$notification->status}}</span>
                    @else
                    <span class="label label-success">{{$notification->status}}</span>
                    @endif
                </td>
                <td>{{ $notification->effectiveDate }}</td>
                <td>{!! $notification->detail !!}</td>
                <td>   
                    <a href="{{route('notification.show',['notification'=>$notification->id])}}" class="mb-xs mt-xs mr-xs btn btn-info btn-sm update-rate" data-rate="{{ $notification->id }}" data-toggle="modal" ><i class="fa fa-eye"></i></a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</section>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Completadas</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default2">
            <thead >
                <tr>
                <th scope="col">Fecha</th>
                <th scope="col">MSISDN</th>
                <th scope="col">Tipo</th>
                <th scope="col">Status</th>
                <th scope="col">Fecha Expedición</th>
                <th scope="col">Detalles</th>
                <th scope="col">Opciones</th>
                
                </tr>
            </thead>
            <tbody>
            @foreach( $twoNotifications as $twoNotification )
            <tr style="cursor: pointer;" class="rate-table" data-id="{{$twoNotification->id}}">
                <td>{{ $twoNotification->date_notification }}</td>
                <td>{{ $twoNotification->identifier }}</td>
                <td>{{ $twoNotification->eventType }}</td>
                <td>
                    @if($twoNotification->status == 'pendiente')
                    <span class="label label-warning">{{$twoNotification->status}}</span>
                    @else
                    <span class="label label-success">{{$twoNotification->status}}</span>
                    @endif
                </td>
                <td>{{ $twoNotification->effectiveDate }}</td>
                <td>{!! $twoNotification->detail !!}</td>
                <td>   
                    <a href="{{route('notification.show',['notification'=>$twoNotification->id])}}" class="mb-xs mt-xs mr-xs btn btn-info btn-sm update-rate" data-rate="{{ $twoNotification->id }}" data-toggle="modal" ><i class="fa fa-eye"></i></a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</section>

@endsection