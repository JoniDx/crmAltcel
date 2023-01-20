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


<div class="row" id="create">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Asignar Dispositivos/MSISDN</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" >
                @csrf
                <div class="col-md-4" style="margin-top: 1rem;">
                    <label for="promoter">Promotor: </label>
                    <select class="form-control form-control-sm" id="promoter" name="promoter" >
                    <option value="0" selected>Elegir...</option>
                        @foreach($promoters as $promoter)
                        <option value="{{$promoter->id}}">{{$promoter->name.' '.$promoter->lastname.' - '.$promoter->rol}}</option>
                        
                        @endforeach

                    </select>
                </div>
                <div class="col-md-2">
                    <div class="radio col-md-12">
                        <label>
                            <input type="radio" name="optionRadioAsign" id="radioSIM" value="sim">
                            SIM
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="radio col-md-12">
                        <label>
                            <input type="radio" name="optionRadioAsign" id="radioDevice" value="device">
                            Dispositivo
                        </label>
                    </div>
                </div>
                <div class="col-md-12 mt-md">
                    <div class="col-md-6 d-none" id="msisdn-select">
                        <label>MSISDN</label>
                        <select data-plugin-selectTwo class="form-control populate" id="sim">
                            <optgroup label="SIM's disponibles">
                            <option value="0">Elige...</option>
                            @foreach($numbers as $number)
                                <option value="{{$number->id}}">{{$number->icc_id.' - '.$number->MSISDN.' - '.$number->producto}}</option>
                                @endforeach
                            </optgroup>
                            
                        </select>
                    </div>
                    <div class="col-md-6 d-none" id="device-select">
                        <label>Dispositivo</label>
                        <select data-plugin-selectTwo class="form-control populate" id="device">
                            <optgroup label="Dispositivos disponibles">
                            <option value="0">Elige...</option>
                            @foreach($devices as $device)
                                <option value="{{$device->id}}">{{$device->no_serie_imei.' - '.$device->material}}</option>
                                @endforeach
                            </optgroup>
                            
                        </select>
                    </div>
                </div>
                <div class="col-md-12 mt-md">
                    <button type="button" class="mb-xs mt-xs mr-xs btn btn-success" id="add" disabled>Añadir</button>
                </div>              
                </form>
            </div>
        </section>

    </div>
</div>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Resumen</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead >
                <tr>
                <th scope="col">Promotor</th>
                <th scope="col">SIM's</th>
                <th scope="col">Dispositivos</th>
                </tr>
            </thead>
            <tbody>
            @foreach($resumes as $resume)
            <tr class="promoter-assignment" style="cursor: pointer;" id="{{$resume['id']}}" data-name="{{$resume['name']}}">
                <td>{{$resume['name']}}</td>
                <td><span class="badge label label-success">Disponible: {{ $resume['numbersAvailable'].'/'.$resume['numbersTotal'] }}</span></td>
                <td><span class="badge label label-success">Disponible: {{ $resume['devicesAvailable'].'/'.$resume['devicesTotal'] }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>

<div class="modal fade" id="modalPromoterAssignments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-dark" id="promoterName"></h4>
            </div>
            <div class="modal-body">
                    <section class="panel ">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="fa fa-caret-down"></a>
                            </div>
            
                            <h2 class="panel-title">SIM's</h2>
                        </header>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table mb-none">
                                    <thead>
                                        <tr>
                                            <th>ICC</th>
                                            <th>MSISDN</th>
                                            <th>PUK</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body-numbers">
                                        <tr>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                            <td class="actions-hover">
                                                <a href=""><i class="fa fa-pencil"></i></a>
                                                <a href="" class="delete-row"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    <section class="panel ">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="fa fa-caret-down"></a>
                            </div>
            
                            <h2 class="panel-title">Dispositivos</h2>
                        </header>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table mb-none">
                                    <thead>
                                        <tr>
                                            <th>IMEI</th>
                                            <th>MATERIAL</th>
                                            <th>DESCRIPCIÓN</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body-devices">
                                        <tr>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                            <td class="actions-hover">
                                                <a href=""><i class="fa fa-pencil"></i></a>
                                                <a href="" class="delete-row"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
$('input[name="optionRadioAsign"]').on('click', function() {
    let radioOption = $(this).val();
    $('#add').attr('disabled',false);
    if(radioOption == 'sim'){
        $('#msisdn-select').removeClass('d-none');
        $('#device-select').addClass('d-none');
    }else if(radioOption == 'device'){
        $('#msisdn-select').addClass('d-none');
        $('#device-select').removeClass('d-none');
    }
    
});

$('#add').click(function(){
    let promotor = $('#promoter').val();
    let type = $('input[name="optionRadioAsign"]:checked').val();
    let sim_device = 0;
    let data;
    let token = $('meta[name="csrf-token"]').attr('content');

    if(type == 'sim'){
        sim_device = $('#sim').val();
        data = {_token:token, type:type, promoter_id:promotor,number_id:sim_device, device_id:null};
    }else if(type == 'device'){
        sim_device = $('#device').val();
        data = {_token:token, type:type, promoter_id:promotor, number_id:null, device_id:sim_device};
    }
    console.log(data);
    $.ajax({
        url: "{{route('assignment.store')}}",
        method: "POST",
        data: data,
        success: function(response){
            if(response == 1){
                Swal.fire({
                    icon: 'success',
                    title: 'Asignado con éxito.',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(function(){ location.reload(); }, 1750);
            }else if(response == 0){
                Swal.fire({
                    icon: 'error',
                    title: 'Hubo un error, consulte a Desarrollo.',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    });
});

$('.promoter-assignment').click(function(){
    let id = $(this).attr('id');
    let promoter = $(this).data('name');
    let numbers, devices, numbersTable = '', devicesTable = '';
    let url = "{{route('showAssignments',['promoter'=>'temp'])}}";
    url = url.replace('temp',id);

    $.ajax({
        url: url,
        method: "GET",
        success: function(response){
            numbers = response.numbers;
            devices = response.devices;

            numbers.forEach(element => numbersTable+="<tr id='assignment-"+element.assignment_id+"'><td>"+element.ICC+"</td>"+
            "<td>"+element.MSISDN+" - "+element.producto+"</td>"+
            "<td>"+element.PUK+"</td>"+
            "<td class='actions-hover'><a class='btn btn-sm btn-danger delete-assignment' style='color: white !important;' onclick='destroy(this)' data-assignment='"+element.assignment_id+"'><i class='fa fa-trash-o text-white'></i></a></td>"+
            "</tr>");
            $('#body-numbers').html(numbersTable);

            devices.forEach(element => devicesTable+="<tr id='assignment-"+element.assignment_id+"'><td>"+element.imei+"</td>"+
            "<td>"+element.material+"</td>"+
            "<td>"+element.description+"</td>"+
            "<td class='actions-hover'><a class='btn btn-sm btn-danger delete-assignment' style='color: white !important;' onclick='destroy(this)' data-assignment='"+element.assignment_id+"'><i class='fa fa-trash-o text-white'></i></a></td>"+
            "</tr>" );
            $('#body-devices').html(devicesTable);
        }
    });

    $('#promoterName').html(promoter);
    $('#modalPromoterAssignments').modal('show');
});


function destroy(element){
    let id = $(element).data('assignment');
    let token = $('meta[name="csrf-token"]').attr('content');
    let method = 'DELETE';
    let url = "{{route('assignment.destroy',['assignment'=>'temp'])}}";
    url = url.replace('temp',id);
    
    Swal.fire({
        title: '¿Está seguro de eliminar esta asignación?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#47a447',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SÍ, ESTOY SEGURO.'
        }).then((result) => {
        if (result.isConfirmed){
            Swal.fire({
                title: 'Realizando activación...',
                html: 'Espera un poco, un poquito más...',
                didOpen: () => {
                    Swal.showLoading();

                    $.ajax({
                        url: url,
                        method: "DELETE",
                        data: {_token:token, _method:method},
                        success:function(response){
                            if(response == 1){
                                $('#assignment-'+id).remove();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Se ha eliminado la asignación.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    });
                }
            });
        }
    });
}
</script>
@endsection