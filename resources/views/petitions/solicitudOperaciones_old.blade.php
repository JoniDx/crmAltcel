@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Administración de Solicitudes</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
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

        <h2 class="panel-title">Nuevas Solicitudes</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead style="cursor: pointer;">
                <tr>
                <th scope="col">Enviado Por</th>
                <th scope="col">Status</th>
                <th scope="col">Fecha de envio</th>
                <th scope="col">Cliente</th>
                <th scope="col">Producto</th>
                <th scope="col">LADA</th>
                <th scope="col">Plan Activación</th>
                <th scope="col">Forma Pago</th>
                <th scope="col">Comentario</th>
                <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($solicitudes as $solicitud)
                <tr>
                    <td>{{$solicitud['name_sender']}}</td>
                    <td><span class="badge label-warning">{{$solicitud['status']}}</span></td>
                    <td>{{$solicitud['date_sent']}}</td>
                    <td>{{$solicitud['client']}}</td>
                    <td>{{$solicitud['product']}}</td>
                    <td>{{$solicitud['lada']}}</td>
                    <td>{{$solicitud['rate_activation']}}</td>
                    <td>{{$solicitud['payment_way'].' - Plazo: '.$solicitud['plazo']}}</td>
                    <td>{{$solicitud['comment']}}</td>
                    <td>
                        @if($solicitud['type'] == 'local')
                        <button class="btn btn-warning solicitud" id="notification" data-id="{{$solicitud['id']}}" data-client="{{$solicitud['id_client']}}" data-comment="{{$solicitud['comment']}}" data-lada="{{$solicitud['lada']}}">Activar</button>
                        @elseif($solicitud['type'] == 'external')
                        <a href="{{url('/activate-dealer-petition/'.$solicitud['id'])}}" class="btn btn-success" id="notification" data-id="{{$solicitud['id']}}" >Activar</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default2">
            <thead >
                <tr>
                    <th scope="col">MSISDN</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Solicitado por</th>
                    <th scope="col">Status</th>
                    <th scope="col">Comentario</th>
                    <th scope="col">Opción</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $otherpetitions as $otherpetition )
            <tr style="cursor: pointer;">
                <td>{{ $otherpetition['msisdn'] }}</td>
                <td><span class="badge label-info">{{ $otherpetition['type'] }}</span></td>
                <td>{{ $otherpetition['client'] }}</td>
                <td>{{ $otherpetition['dealer'] }}</td>
                <td><span class="badge label-warning">{{ $otherpetition['status'] }}</span></td>
                <td>{{ $otherpetition['comment'] }}</td>
                <td>
                    @if($otherpetition['type'] == 'lockImei')
                    <button class="btn btn-xs btn-danger imei" data-type="{{$otherpetition['type']}}" data-msisdn="{{$otherpetition['msisdn']}}" data-otherid="{{$otherpetition['id']}}"><i class="fa fa-lock"></i></button>
                    @elseif($otherpetition['type'] == 'unlockImei')
                    <button class="btn btn-xs btn-success imei" data-type="{{$otherpetition['type']}}" data-msisdn="{{$otherpetition['msisdn']}}" data-otherid="{{$otherpetition['id']}}"><i class="fa fa-unlock"></i></button>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>
<input type="hidden" id="user_id" value="{{Auth::user()->id}}">
<script>
    $('.solicitud').click(function(){
        let idClient = $(this).attr('data-client');
        let id_petition = $(this).attr('data-id');
        let lada = $(this).attr('data-lada');
        let route = "{{route('activations.create')}}"
        let comment = $(this).attr('data-comment');
        $.ajax({
            url:"{{route('activation.get')}}",
            method:'GET',
            data:{idClient:idClient, comment:comment},
            success:function(response){

                let name = response[0].name;
                let lastname = response[0].lastname;
                let rfc = response[0].rfc;
                let email = response[0].email;
                let cellphone = response[0].cellphone;
                let address = response[0].address;
                let date_born = response[0].date_born;
                let ine_code = response[0].ine_code;
                let id = id_petition;
                
                let url = route+'?from=petition&name='+name+'&lastname='+lastname+'&rfc='+rfc+'&date_born='+date_born+'&address='+address+'&email='+email+'&ine_code='+ine_code+'&cellphone='+cellphone+'&petition='+id+'&lada='+lada;
                // console.log(url);
                location.href=url;
            }
        })
    });

    $('.imei').click(function(){
        let type = $(this).data('type');
        let msisdn = $(this).data('msisdn');
        let otherid = $(this).data('otherid');
        let user = $('#user_id').val();

        let text = type == 'lockImei' ? 'bloquear' : 'desbloquear';
        let bool = type == 'lockImei' ? 'SI' : 'NO';
        let desc, status;
        let token = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'ATENCIÓN',
            html: "¿Está seguro de "+text+" el IMEI del número <b>"+msisdn+"</b>?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'SÍ, ESTOY SEGURO',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-primary mr-md',
                cancelButton: 'btn btn-danger '
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Estamos consultando la información...',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                        $.ajax({
                            url: "{{route('status')}}",
                            method: "GET",
                            data: {msisdn:msisdn},
                            success: function(response){
                                Swal.close();
                                let imei = response.imei;
                                
                                if(response.blocked == bool){
                                    desc = bool == 'SI' ? 'El IMEI ya se encuentra bloqueado.' : 'El IMEI ya se encuentra desbloqueado.';
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Ooops!',
                                        text: desc,
                                        showConfirmButton: true,
                                    });
                                }else{
                                    status = bool == 'SI' ? 'NO' : 'SI';
                                    $.ajax({
                                        url: "{{route('locked')}}",
                                        method: 'POST',
                                        data: {_token:token,imei:imei, status:status, msisdn:msisdn,otherid:otherid,user:user},
                                        beforeSend: function(){
                                            Swal.fire({
                                                title: 'Estamos trabajando en ello...',
                                                html: 'Espera un poco, un poquito más...',
                                                didOpen: () => {
                                                    Swal.showLoading();
                                                }
                                            });
                                        },
                                        success:function(response){
                                            // console.log(response);
                                            if(response.http_code == 1){
                                                desc = status == 'SI' ? 'IMEI '+response.message+' desbloqueado con éxito.' : 'IMEI '+response.message+' bloqueado con éxito.'
                                                Swal.fire({ 
                                                    icon: 'success',
                                                    title: 'Éxito',
                                                    text: desc,
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                                location.reload();

                                            // console.log(response)
                                            }else{
                                                response = JSON.parse(response);
                                                Swal.fire({ 
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: response.description
                                                })
                                            }
                                        }
                                    });
                                }

                                console.log(response);

                            }
                        });
                    }
                });
                
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Operación cancelada',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        });

    });
</script>
@endsection