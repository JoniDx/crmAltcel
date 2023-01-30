@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Portabilidad</h2>
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
@if(session('error'))
    <div class="alert alert-danger" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="alert-heading">Upps!!</h4>
        <p>{!!session('error')!!}</p>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="alert-heading">Well done!!</h4>
        <p>{!!session('success')!!}</p>
    </div>
@endif
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                </div>

                <h2 class="panel-title">Nueva</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="{{route('portabilities.store')}}" method="POST">
                    @csrf

                    <div class="row form-group col-md-12">
                        <div class="col-md-4 mb-md">
                            <label for="msisdnPorted">Número a Portar</label>
                            <input class="form-control" type="text" id="msisdnPorted" name="msisdnPorted" maxlength="10" required>
                        </div>

                        <div class="col-md-4 mb-md">
                            <label for="dida">DIDA</label>
                            <input class="form-control" type="text" id="dida" name="dida" required readonly>
                        </div>

                        <div class="col-md-4 mb-md">
                            <label for="dcr">DCR</label>
                            <input class="form-control" type="text" id="dcr" name="dcr" required readonly>
                        </div>

                        <div class="col-md-4 mb-md">
                            <label for="icc">Número de SIM (código de barras)</label>
                            <input class="form-control" type="text" id="icc" name="icc" maxlength="20" required>
                        </div>

                        <div class="col-md-4 mb-md">
                            <label for="msisdnTransitory">Número Provisional</label>
                            <input class="form-control" type="text" id="msisdnTransitory" name="msisdnTransitory" required readonly>
                        </div>

                        <div class="col-md-4 mb-md">
                            <label for="imsi">IMSI</label>
                            <input class="form-control" type="text" id="imsi" name="imsi" required readonly>
                        </div>

                        <div class="col-md-4 mb-md">
                            <label for="date">Fecha de Activación de SIM</label>
                            <input class="form-control" type="date" id="date" name="date" required >
                        </div>

                        <div class="col-md-4 mb-md">
                            <label for="approvedDateABD">Fecha de Portabilidad</label>
                            <input class="form-control" type="date" id="approvedDateABD" name="approvedDateABD" required >
                        </div>

                        <div class="col-md-4 mb-md">
                            <label for="nip">NIP</label>
                            <input class="form-control" type="text" id="nip" name="nip" required >
                        </div>

                        <div class="col-md-4 mb-md">
                            <label for="rate_id">Planes</label>
                            <select name="rate_id" id="rate_id">
                                @foreach($rates as $rate)
                                <option value="{{$rate->id}}">{{$rate->name}} - ${{number_format($rate->price,2)}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-md">
                            <label for="comments">Comentarios</label>
                            <textarea class="form-control" type="text" id="comments" name="comments" required ></textarea>
                        </div>

                        <div class="col-md-6 mb-lg">
                            <label>Clientes</label>
                            <select data-plugin-selectTwo class="form-control populate" id="client_id" name="client_id" onchange="validateFields()">
                                <optgroup label="Clientes disponibles">
                                <option value="0">Elige...</option>
                                @foreach($clients as $client)
                                <option value="{{$client->id}}">
                                    {{$client->name.' '.$client->lastname.' - '.$client->email.' - '.$client->cellphone}}
                                </option>
                                @endforeach
                                </optgroup>
                            </select>
                        </div>

                        <div class="col-md-4 mb-lg">
                            <label>Empleado que vendió</label>
                            <select data-plugin-selectTwo class="form-control populate" id="sold_by" name="sold_by" >
                                <optgroup label="Clientes disponibles">
                                <option value="0">Elige...</option>
                                @foreach($employes as $employe)
                                    @if($employe->id == Auth::user()->id)
                                    <option selected value="{{$employe->id}}">
                                        {{$employe->name.' '.$employe->lastname.' - '.$employe->email}}
                                    </option>
                                    @else
                                    <option value="{{$employe->id}}">
                                        {{$employe->name.' '.$employe->lastname.' - '.$employe->email}}
                                    </option>
                                    @endif
                                @endforeach
                                </optgroup>
                            </select>
                        </div>

                    </div>
                    <input type="hidden" name="who_did_it" value="{{Auth::user()->id}}">

                    <div class="col-md-12" style="margin-top: 1rem;">
                        <button type="submit" class="btn btn-success" id="save" disabled>Guardar</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<script>
$('#msisdnPorted').keyup(function(){
    let msisdn = $(this).val();
    if(msisdn.length == 10){
        $.ajax({
            url: "{{route('currentOperator')}}",
            method: "GET",
            data: {msisdn:msisdn},
            beforeSend: function(){
                Swal.fire({
                    title: 'Obteniendo datos de la operadora.',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response){
                Swal.close();
                $('#dida').val(response.ida);
                $('#dcr').val(response.cr);
                validateFields();
            }
        });
    }else{
        $('#dida').val('');
        $('#dcr').val('');
        validateFields();
    }
    
});

$('#icc').keyup(function(){
    let icc = $(this).val();
    if(icc.length == 20){
        $.ajax({
            url: "{{route('msisdnTransitory')}}",
            method: "GET",
            data: {icc:icc},
            beforeSend: function(){
                Swal.fire({
                    title: 'Obteniendo datos de la SIM transitoria.',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response){
                Swal.close();
                $('#msisdnTransitory').val(response.MSISDN);
                $('#imsi').val(response.imsi);
                validateFields();
            }
        });
    }else{
        $('#imsi').val('');
        validateFields();
    }
});

$('#approvedDateABD').change(function(){
    let dateChoosed = $(this).val();
    let date = new Date();
    let month = date.getMonth();
    month = parseInt(month);
    month +=1;
    month = month < 10 ? '0'+month : month;
    let today = date.getFullYear()+"-"+month+"-"+date.getDate();
    dateChoosed = new Date(dateChoosed).getTime();
    today = new Date(today).getTime();
    let diff = dateChoosed - today;
    console.log(today);
    console.log(dateChoosed);
    console.log(diff);
    console.log(diff/(1000*60*60*24));
    validateFields();
});

function validateFields(){
    let msisdnPorted = $('#msisdnPorted').val();
    let dida = $('#dida').val();
    let dcr = $('#dcr').val();
    let icc = $('#icc').val();
    let msisdnTransitory = $('#msisdnTransitory').val();
    let imsi = $('#imsi').val();
    let date = $('#date').val();
    let client_id = $('#client_id').val();

    if((msisdnPorted.length == 0 || /^\s+$/.test(msisdnPorted)) || (icc.length == 0 || /^\s+$/.test(icc)) || (msisdnTransitory.length == 0 || /^\s+$/.test(msisdnTransitory)) || (imsi.length == 0 || /^\s+$/.test(imsi)) || (date.length == 0 || /^\s+$/.test(date)) || client_id == 0){
        $('#save').attr('disabled',true);
    }else{
        let day = new Date(date).getDay();
        let days = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
        
        if(days[day] == 'domingo'){
            $('#save').attr('disabled',true);
            return false;
        }
        $('#save').attr('disabled',false);
    }
}
</script>
@endsection