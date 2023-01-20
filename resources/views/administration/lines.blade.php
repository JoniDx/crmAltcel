@extends('layouts.octopus')
@section('content')

<header class="page-header">
    <h2>Lineas nuevas y Portadas Distribuidores</h2>
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
<div class="alert alert-primary">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Mostrando registros en el rango de {{$date_init}} a {{$date_final}}</strong>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
           
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="{{route('administrationLines.get')}}">

                    <div class="form-group">
                        <!-- <label class="col-md-3 control-label">Date range</label> -->
                        <div class="col-md-6">
                            <div class="input-daterange input-group" data-plugin-datepicker>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input autocomplete="off" type="text" class="form-control" name="start">
                                <span class="input-group-addon">a</span>
                                <input autocomplete="off" type="text" class="form-control" name="end">
                            </div>
                        </div>
                        <button class="col-md-1 btn btn-success btn-sm">Consultar</button>
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

        <h2 class="panel-title">Números</h2>
    </header>
    <div class="panel-body">
        
        <table class="table table-bordered table-striped mb-none" id="incomesTable">
            <thead style="cursor: pointer;">
                <tr>
                <th scope="col">Fecha de Operación</th>
                <th scope="col">Distribuidor</th>
                <th scope="col">MSISDN</th>
                <th scope="col">Tipo</th>
                <th scope="col">ICC</th>
                <th scope="col">Producto</th>
                <th scope="col">Plan</th>
                <th scope="col">Monto</th>
                <th scope="col">Comisión</th>
                </tr>
            </thead>
            <tbody>
               @foreach($lines as $line)
               <tr>
                <td>{{$line->date}}</td>
                <td><b>{{$line->username}}</b> - {{$line->first_name.' '.$line->last_name}}</td>
                <td>{{$line->msisdn}}</td>
                <td>{{$line->tipo}} - <b>{{$flagWholesaler = $line->wholesaler == 1 ? 'MAYORISTA' : 'MINORISTA'}}</b></td>
                <td>{{$line->icc}}</td>
                <td>{{$line->product}}</td>
                <td>{{$line->rate}}</td>
                <td>${{number_format($line->amount,2)}}</td>
                <td>${{$comission = $line->wholesaler == 1 ? number_format($line->amount*0.50,2) : number_format($line->amount*0.20,2)}}</td>
               </tr>
               @endforeach
                

            </tbody>
        </table>
    </div>
</section>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready( function () {
        $('#incomesTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                title: 'DISTRIBUIDORES_Activaciones_y_Portabilidades',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ],
                }
            }],
            order: [[0, 'desc']]
        });
    });
</script>
@endsection
