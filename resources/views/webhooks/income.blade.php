@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Ingresos</h2>
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
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
           
            <div class="panel-body">
                <form class="form-horizontal form-bordered" method="GET" action="{{route('income')}}" id="formIncome">

                    <div class="form-group">

                        <div class="col-md-3">
                            <label for="type">Seleccione un rango de fechas</label>
                            <select id="type" name="type" class="form-control form-control-sm" required>
                                <option selected value="0">Choose...</option>
                                <option value="today">Hoy</option>
                                <option value="yesterday">Ayer</option>
                                <option value="last7">Últimos 7 días</option>
                                <option value="last30">Últimos 30 días</option>
                                <option value="thisMonth">Este mes</option>
                                <option value="pastMonth">Mes pasado</option>
                                <option value="personalized">Personalizado</option>
                            </select>
                        </div>

                        <div class="col-md-6 d-none" id="contentDateRange">
                        <label class="control-label">Rango de fechas</label>
                            <div class="input-daterange input-group" data-plugin-datepicker>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input autocomplete="off" type="text" class="form-control" name="start" id="start">
                                <span class="input-group-addon">a</span>
                                <input autocomplete="off" type="text" class="form-control" name="end" id="end">
                            </div>
                        </div>

                        <div class="col-md-12 mt-md">
                            <button type="button" class="btn btn-success btn-sm" id="consultar">Consultar</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<input type="hidden" id="startC" value="{{$start}}">
<input type="hidden" id="endC" value="{{$end}}">

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Relación de ingresos</h2>
            </header>
            <div class="panel-body">
                <a class="btn btn-success btn-xs mb-md" href="{{url('/incomes-export?start='.$start.'&end='.$end)}}">Exportar <i class="fa fa-file-excel-o"></i></a>
                <div class="table-responsive">
                    <table class="table mb-none" id="datatable-default">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Número</th>
                                <th>Monto</th>
                                <th>Tipo</th>
                                <th>Producto</th>
                                <th>Medio de Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incomes as $income)
                            <tr>
                                <td>{{$income->fecha}}</td>
                                <td>{{$income->sim}}</td>
                                <td>{{number_format($income->monto,2)}}</td>
                                <td>{{$income->tipo}}</td>
                                <td>{{$income->producto}}</td>
                                <td>{{$income->medio_pago}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
   $('#type').change(function(){
       let value = $(this).val();
       
       if(value == 'personalized'){
           $('#contentDateRange').removeClass('d-none');
       }else{
        $('#contentDateRange').addClass('d-none');
       }
   });

   $('#consultar').click(function(){
       let type = $('#type').val();
       let start = $('#start').val();
       let end = $('#end').val();

       if(type == 0){
            Swal.fire({
                icon: 'error',
                title: 'Woops!!!',
                text: 'Por favor selecciona un tipo de rango.',
                showConfirmButton: false,
                timer: 2000
            });
            document.getElementById('type').focus();
            return false;
       }else if(type == 'personalized'){
            if(start.length == 0 || /^\s+$/.test(start)){
                Swal.fire({
                    icon: 'error',
                    title: 'Woops!!!',
                    text: 'Por favor selecciona una fecha de inicio en el rango de fechas.',
                    showConfirmButton: false,
                    timer: 2000
                });
                document.getElementById('start').focus();
                return false;
            }

            if(end.length == 0 || /^\s+$/.test(end)){
                Swal.fire({
                    icon: 'error',
                    title: 'Woops!!!',
                    text: 'Por favor selecciona una fecha final en el rango de fechas.',
                    showConfirmButton: false,
                    timer: 2000
                });
                document.getElementById('end').focus();
                return false;
            }
       }

       $('#formIncome').submit();

   });
</script>
@endsection