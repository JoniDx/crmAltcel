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

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-4">
                        <label for="type">Concepto:</label>
                        <select class="form-control" data-plugin-multiselect id="type">
                            <option value="" selected>Seleccione un opción</option>
                            <option value="changes">Cambio de Producto</option>
                            <option value="purchases">Compra de producto</option>
                            <option value="monthly">Mensualidad</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="status">Status:</label>
                        <select class="form-control" data-plugin-multiselect id="status">
                            <option value="" selected>Seleccione un status</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="completado">Completado</option>
                        </select>
                    </div><div class="col-md-4">
                        <label for="bonificacion">Acción:</label>
                        <select class="form-control" data-plugin-multiselect id="bonificacion">
                            <option value="" selected>Seleccione una bonificación</option>
                            <option value="bonificacion">Bonificación</option>
                            <option value="cobro">Cobro</option>
                        </select>
                    </div>
                        
                    <div class="col-md-12 mt-md mb-sm">
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

                    <div class="col-md-12 mt-md">
                        <button class="btn btn-success btn-sm" id="consult" type="button">Consultar</button>
                    </div>
                </div>
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
        <input type="hidden" id="userConsigned" value="{{auth()->user()->id}}">
        @foreach($users as $user)
        <h2 class="panel-title">{{$user->name}} {{$user->lastname}}</h2>
        <h4 class="text-dark text-bold">Total: $<span id="total"></span></h4>
        <input type="hidden" id="user" value="{{$user->id}}">
        <input type="hidden" id="totalAll">
        <button class="btn btn-primary" id="all"></button>
        @endforeach
    </header>
    <div class="panel-body table">
        <table class="table table-bordered table-striped mb-none" >
            <thead>
                <tr>
                    <th>Monto</th>
                    <th>Cliente</th>
                    <th>MSISDN</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Razón</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="cuerpo-table"></tbody>
        </table>
    </div>
    <script>
        $('#all').hide();
        let id = $('#user').val();
        
        $('#type').change(function(){let type = $(this).val();})
        $('#status').change(function(){let status2 = $(this).val();})
        $('#bonificacion').change(function(){let bonificacion2 = $(this).val();})

        $('#consult').click(function(){
            let contenido = '';
            let type = $('#type').val()
            let status = $('#status').val()
            let bonificacion = $('#bonificacion').val()
            let start = $('#start_date').val()
            let end = $('#end_date').val()
            let total = 0;
            let textbtn = status == 'completado' ? 'Revertir' : 'Cobrar';
            let classBadge = status == 'completado' ? 'success' : 'danger';
            let reason = '';

            $.ajax({
                url: "{{route('consulta.post')}}",
                method:'post',
                data: {type:type, status:status, start:start, end:end, id:id, bonificacion:bonificacion},
                success:function(response){
                    var data = response.consultas;
                    data.forEach(function(element){
                        reason = element.reason == undefined ? 'cobro' : element.reason;
                        contenido+="<tr id='row_"+element.id+"'><td class='mon'>"+'$ '+ parseFloat(element.amount).toFixed(2)+"</td><td>"+element.client+" "+element.lastname+"</td><td>"+element.MSISDN+"</td><td>"+element.name_product+"</td><td><span class='badge label-"+classBadge+"' data-status='"+element.status+"'>"+element.status+"</span></td><td><span class='badge label-success'>"+reason+"</span></td><td>"+element.date+"</td><td><button onclick='xF(this.id)' id='btnC_"+element.id+"' class='btn btn-warning cobro' data-amount='"+element.amount+"' data-id ='"+element.id+"'>"+textbtn+"</button></td</tr>"
                        total+=element.amount;
                    });
                    $('#cuerpo-table').html(contenido);
                    $('#total').text(total.toFixed(2));                   
                    $('#totalAll').val(total.toFixed(2));                   
                    
                    if (status == 'pendiente') {
                        $('#all').show();
                        $('#all').text('Cobrar Todos');
                    }else if(status == 'completado'){
                        $('#all').show();
                        $('#all').text('Revertir Todos');
                    }
                }
            })
        });

        // todos
        $('#all').click(function(){
            let id_consigned = $('#userConsigned').val();
            let startPa = $('#start_date').val();
            let endPa = $('#end_date').val();
            let statusPa = $('#status').val();
            let idPa = $('#user').val();
            let typePa = $('#type').val()
            
            $.ajax({
                url: "{{route('payAll')}}",
                method: 'POST',
                data: {type:typePa, status:statusPa, start:startPa, end:endPa, id:idPa, id_consigned:id_consigned},
                success:function(response){
                    if (response == 1) {
                        let tfinal = 0;
                        $('#total').text(tfinal.toFixed(2));
                        let contenido1 = '';
                        $('#cuerpo-table').html(contenido1);
                        Swal.fire({ 
                                icon: 'success',
                                title: 'Éxitoso',
                                text: 'Se ha cobrado todas las cocesiones con éxito',
                                showConfirmButton: false,
                                timer: 2000
                            });
                    }else {
                        Swal.fire({ 
                                icon: 'error',
                                title: 'Oops!!',
                                text: 'Intente de nuevo o consulte desarrollo'
                            });
                    }
                }
            })
        });

        function xF(id){
            let id_consigned = $('#userConsigned').val();
            let idpay = $('#'+id).attr('data-id');
            let type = $('#type').val()
            let monto = $('#'+id).attr('data-amount');
            let status = $('#status').val();
            let totalAll = $('#total').text();
            totalAll = parseFloat(totalAll);
            monto = parseFloat(monto);
            let totalF = totalAll - monto;
            $('#total').text(totalF.toFixed(2));                   

            $('#'+id).closest('tr').remove();;
            $.ajax({
                url: "{{route('status.update')}}",
                method: 'POST',
                data: {idpay:idpay, type:type, status:status, id_consigned:id_consigned},
                success:function(response){
                        Swal.fire({ 
                            icon: 'success',
                            title: 'Éxitoso',
                            text: 'Cobro exitoso',
                            showConfirmButton: false,
                            timer: 2000
                        })
                }
            })
        }
    </script>
</section>
@endsection