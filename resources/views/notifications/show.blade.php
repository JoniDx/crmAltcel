@extends('layouts.octopus')
@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<header class="page-header">
    <h2>{{str_replace ( "_", ' ', $eventType)}}</h2>
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
    <div class="panel-body">
        <div class="invoice">
            <header class="clearfix">
                <div class="row">
                    <div class="col-sm-6 mt-md">
                        <h2 class="h2 mt-none mb-sm text-dark text-bold">{{$eventType}}</h2>
                        <h4 class="h4 m-none text-dark text-bold">{{$identifier}}</h4>
                    </div>
                    <div class="col-sm-6 text-right mt-md mb-md">
                        <address class="ib mr-xlg">
                            Fecha Recepción: {{$date_notification}}
                            <br>
                            Fecha Expedición: {{$effectiveDate}}
                            <br>
                            @if($who_attended == null)
                                <span class="label label-warning">Sin Atender</span>
                            @else
                                <span class="label label-success">{{$attendedBy}}</span>
                            @endif
                        </address>
                    </div>
                </div>
            </header>
            <div class="bill-info">
                <div class="row">
                    <div class="col-md-6">
                        <div class="bill-to">
                            <p class="h5 mb-xs text-dark text-semibold">Detalles:</p>
                            <address>
                                {!! $detail !!}
                            </address>
                        </div>
                    </div>
                </div>
            </div>     
        </div>

        <div class="text-right mr-lg">
            @if($eventType == 'SUSPEND_MOVILITY' && $who_attended == null)
                <div class="row">
                    <div class="col-md-4 form-group mb-lg">
                        <input type="text" placeholder="Coordenadas" class="form-control" id="coordinates" value="{{$lat.','.$lng}}">
                    </div>
                
                    <button class="btn btn-success btn-sm solution" data-type="suspend-movility" data-msisdn="{{$identifier}}"><i class="fa fa-check"></i> Reanudación de Tráfico por Movilidad</button>
                </div>
            @endif
        </div>
    </div>
</section>
<script>
    $( document ).ready(function() {
        let eventType = '{{$eventType}}';
        let seen = '{{$seen}}';
        let status = '{{$status}}';
        let id = '{{$id}}';
        let url = "{{route('notification.update',['notification'=>'temp'])}}";
        let token = $('meta[name="csrf-token"]').attr('content');
        url = url.replace('temp',id);
        console.log(url);

        $.ajax({
            url: url,
            method: 'PUT',
            data: {_token:token, eventType:eventType, seen:seen, status:status, id:id},
            success: function(response){
                console.log(response);
            }
        });
    });

    $('.solution').click(function(){
        let type = $(this).data('type');
        let msisdn = '', data = {};
        let id = '{{$id}}';
        let who_attended = "{{Auth::user()->id}}";

        if(type == 'suspend-movility'){
            msisdn = $(this).data('msisdn');
            let coordinates = $('#coordinates').val();

            if(coordinates.length == 0 || /^\s+$/.test(coordinates)){
                Swal.fire({
                    icon: 'error',
                    title: 'Woops!!',
                    text: 'Ingresa las coordenadas donde se encuentra el dispositivo. El formato es: 16.000000, -93.0000000'
                });
                return false;
            }
            data = {type:type, msisdn:msisdn, coordinates:coordinates, id:id, who_attended:who_attended}
        }

        $.ajax({
            url: "{{route('notification.solution')}}",
            method: "GET",
            data: data,
            beforeSend: function(){
                Swal.fire({
                    title: 'Realizando los ajustes correspondientes...',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response){
                
                if(response.status){
                    if(response.status == 'OK'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Well done!!',
                            text: msisdn+' salió de suspensión por movilidad.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(location.reload(), 2000);
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Woops!! Algo salió mal.',
                            text: response.description
                        });
                    }
                }
            }
        });
    });
</script>
@endsection