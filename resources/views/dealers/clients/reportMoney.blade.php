@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Reporte de Ingreso</h2>
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
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form-group  mb-sm">
                    <form class="form-horizontal form-bordered" action="{{route('payments')}}">
                        <div class="col-md-4">
                            <label for="type">Concepto:</label>
                            <select class="form-control" data-plugin-multiselect name="type" id="type">
                                <option value="" selected>Seleccione un opción</option>
                                <option value="activations">Ingreso Activaciones</option>
                                <option value="change">Ingreso Cambio de Paquete</option>
                                <option value="monthly">Ingreso Mensualidad</option>
                                <option value="reference">Ingreso por Referencias</option>
                                <option value="purchases">Ingreso Compras</option>
                            </select>
                        </div>
                            
                        <div class="col-md-8  mb-sm">
                            <label class="">Fecha</label>
                            <div class="input-daterange input-group" data-plugin-datepicker>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input autocomplete="off" type="text" class="form-control" id="start_date" name="start">
                                <span class="input-group-addon">a</span>
                                <input autocomplete="off" type="text" class="form-control" id="end_date" name="end">
                            </div>
                        </div>

                        <div class="col-md-8 mt-md">
                            <button class="btn btn-primary btn-sm" id="exportar"><i class="fa fa-cloud-download"></i> Exportar</button>
                        </div>
                    </form>
                    <div class="col-md-8 mt-md">
                        <button class="btn btn-success btn-sm" id="consultar"><i class="fa fa-clipboard"></i> Consultar</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<section class="panel">
            <section class="panel-body" id="table-activation">
                <h2 class="head-title">Ingreso por Activaciones</h2>
                <table class="table table-bordered table-striped mb-none" id="table-activation">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Fecha Activación</th>
                            <th>MSISDN</th>
                            <th>Tipo</th>
                            <th>Monto Plan</th>
                            <th>Monto Dispositivo</th>
                        </tr>
                    </thead >
                    <tbody id="body-activation">
                    </tbody>
                </table>
            </section>
            <section class="panel-body" id="table-change">
                <h2 class="head-title">Ingreso por Cambios</h2>
            <table class="table table-bordered table-striped mb-none" >
                <thead>
                    <tr>
                        <th>SIM</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Plan</th>
                        <th>Ejecutado Por</th>
                    </tr>
                </thead>
                <tbody id="body-change">
                </tbody>
            </table>
            </section>
            <section class="panel-body" id="table-monthly">
                <h2 class="head-title">Ingreso de Mensualidades</h2>
            <table class="table table-bordered table-striped mb-none" >
                <thead>
                    <tr>
                        <th>SIM</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody id="body-monthly">
                </tbody>
            </table>
            </section>

            <section class="panel-body" id="table-purchases">
                <h2 class="head-title">Compras</h2>
            <table class="table table-bordered table-striped mb-none">
                <thead>
                    <tr>
                        <th>SIM</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Plan</th>
                        <th>Ejecutado Por</th>
                    </tr>
                </thead>
                <tbody id="body-purchases">
                </tbody>
            </table>
            </section>

            <section class="panel-body" id="table-reference">
                <h2 class="head-title">Ingreso por Referencias</h2>
            <table class="table table-bordered table-striped mb-none">
                <thead>
                    <tr>
                        <th>SIM</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody id="body-reference">
                </tbody>
            </table>
            </section>
</section>  

<script>
    $('#table-reference').addClass('d-none');
    $('#table-activation').addClass('d-none');
    $('#table-change').addClass('d-none');
    $('#table-purchases').addClass('d-none');
    $('#table-monthly').addClass('d-none');

    $('#exportar').click(function(){
        let type = $('#type').val();
        let start = $('#start_date').val();

        if (start.length == 0 || /^\s+$/.test(start)) {
            Swal.fire({
                icon: 'error',
                title: 'Por favor introduzca una fecha inicial.',
                showConfirmButton: false,
                timer: 1500
            })
            return false;
        }

        if (end.length == 0 || /^\s+$/.test(end)) {
            Swal.fire({
                icon: 'error',
                title: 'Por favor introduzca una fecha final.',
                showConfirmButton: false,
                timer: 1500
            })
            return false;
        }
    });

    $('#consultar').click(function(){
        let type = $('#type').val();
        let start = $('#start_date').val();
        let end = $('#end_date').val();
        let contenido = '';

        if (start.length == 0 || /^\s+$/.test(start)) {
            Swal.fire({
                icon: 'error',
                title: 'Por favor introduzca una fecha inicial.',
                showConfirmButton: false,
                timer: 1500
            })
            return false;
        }

        if (end.length == 0 || /^\s+$/.test(end)) {
            Swal.fire({
                icon: 'error',
                title: 'Por favor introduzca una fecha final.',
                showConfirmButton: false,
                timer: 1500
            })
            return false;
        }
        $.ajax({
            url: "{{route('consultMoney')}}",
            method: 'GET',
            data:{type:type, start:start, end:end},
            success:function(response){
                if (type == 'activations') {
                    $('#table-activation').removeClass('d-none');
                    $('#table-reference').addClass('d-none');
                    $('#table-change').addClass('d-none');
                    $('#table-purchases').addClass('d-none');
                    $('#table-monthly').addClass('d-none');
                    response.forEach(function(element){
                        contenido +="<tr><td>"+element.name+"</td><td>"+element.date_activation+"</td><td>"+element.MSISDN+"</td><td>"+element.type+"</td><td>"+'$'+element.received_amount_rate+"</td><td>"+'$'+element.received_amount_device+"</td></tr>"
                    });
                    $('#body-activation').html(contenido);
                    
                }else if (type == 'change') {
                    $('#table-reference').addClass('d-none');
                    $('#table-activation').addClass('d-none');
                    $('#table-purchases').addClass('d-none');
                    $('#table-monthly').addClass('d-none')
                    $('#table-change').removeClass('d-none');
                    response.forEach(function(element){
                        contenido+= "<tr><td>"+element.sim+"</td><td>"+'$'+element.monto+"</td><td>"+element.fecha+"</td><td>"+element.plan+"</td><td>"+element.ejecutado_por+"</td></tr>"
                    });
                    $('#body-change').html(contenido);
                    
                }else if (type == 'monthly') {
                    $('#table-reference').addClass('d-none');
                    $('#table-activation').addClass('d-none');
                    $('#table-change').addClass('d-none');
                    $('#table-purchases').addClass('d-none');
                    $('#table-monthly').removeClass('d-none');
                    response.forEach(function(element){
                        contenido+= "<tr><td>"+element.sim+"</td><td>"+'$'+element.monto+"</td><td>"+element.fecha+"</td></tr>"
                    });
                    $('#body-monthly').html(contenido);
                }else if(type == 'reference'){
                    $('#table-activation').addClass('d-none');
                    $('#table-change').addClass('d-none');
                    $('#table-purchases').addClass('d-none');
                    $('#table-monthly').addClass('d-none');
                    $('#table-reference').removeClass('d-none');
                    response.forEach(function(element){
                        contenido+= "<tr><td>"+element.sim+"</td><td>"+'$'+element.monto+"</td><td>"+element.fecha+"</td></tr>"
                    });
                    $('#body-reference').html(contenido);
                }else if (type == 'purchases') {
                    $('#table-reference').addClass('d-none');
                    $('#table-activation').addClass('d-none');
                    $('#table-change').addClass('d-none');
                    $('#table-monthly').addClass('d-none');
                    $('#table-purchases').removeClass('d-none');
                    response.forEach(function(element){
                        contenido+= "<tr><td>"+element.sim+"</td><td>"+'$'+element.monto+"</td><td>"+element.fecha+"</td><td>"+element.plan+"</td><td>"+element.ejecutado_por+"</td></tr>"
                    });
                    $('#body-purchases').html(contenido);
                }
            }
        })
    })
</script>
@endsection