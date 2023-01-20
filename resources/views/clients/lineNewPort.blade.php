@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Reporte de Líneas Nuevas y Portabilidades</h2>
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
                    <form class="form-horizontal form-bordered" action="{{route('linePorta')}}">
                        <div class="col-md-4">
                            <label for="type">Concepto:</label>
                            <select class="form-control" data-plugin-multiselect name="type" id="type">
                                <option value="" selected>Seleccione un opción</option>
                                <option value="New">Linea Nueva</option>
                                <option value="Porta">Porta</option>
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

                        <div class="col-md-12 mt-md">
                            <button class="btn btn-primary btn-sm" ><i class="fa fa-cloud-download"></i> Consultar</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>
                    <h2 class="panel-title">Líneas Nuevas</h2>
            </header>
            <div class="panel-body table-responsive">
                <table class="table table-bordered table-striped mb-none" id="myTable">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Número</th>
                            <th>Icc</th>
                            <th>Plan</th>
                            <th>Fecha de Activación</th>
                            <th>Producto</th>
                            <th>Enviado Por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $linesNews as $lineNew )
                            <tr>
                                <td>{{$lineNew->cliente}}</td>
                                <td>{{$lineNew->msisdn}}</td>
                                <td>{{$lineNew->icc}}</td>
                                <td>{{$lineNew->date}}</td>
                                <td>{{$lineNew->rate.' - $'.number_format($lineNew->amount,2)}}</td>
                                <td>{{$lineNew->product}}</td>
                                <td>{{$lineNew->first_name.' '.$lineNew->last_name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>
                    <h2 class="panel-title">Portabilidades</h2>
            </header>
            <div class="panel-body">
                <table class="table table-bordered table-striped mb-none" id="myTable2">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Número Portado</th>
                            <th>Número Transitorio</th>
                            <th>Nip</th>
                            <th>ICC</th>
                            <th>Fecha de Activación</th>
                            <th>Fecha a Portar</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Enviado Por</th>
                            <th>Atendido Por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $portabilitys as $portabiliti )
                            <tr>
                                <td>{{$portabiliti['client']}}</td>
                                <td>{{$portabiliti['msisdnPorted']}}</td>
                                <td>{{$portabiliti['msisdnTransitory']}}</td>
                                <td>{{$portabiliti['nip']}}</td>
                                <td>{{$portabiliti['icc']}}</td>
                                <td>{{$portabiliti['date']}}</td>
                                <td>{{$portabiliti['approvedDateABD']}}</td>
                                <td>{{$portabiliti['name_rate']}}</td>
                                <td>$ {{$portabiliti['amount']}}</td>
                                <td>{{$portabiliti['who_did_it']}}</td>
                                <td>{{$portabiliti['who_attended']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script>
    $('.altan').click(function(){
        let id_dn = $(this).data('id-dn');
        let id_act = $(this).data('id-act');
        let service = $(this).data('service');
        let url = "{{route('showProductDetails',['id_dn'=>'temp','id_act'=>'temp1','service'=>'temp2'])}}";
        url = url.replace('temp',id_dn);
        url = url.replace('temp1',id_act);
        url = url.replace('temp2',service);

        location.href = url;
    });
    $(document).ready( function () {

        $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                header: true,
                title: 'portabilidadesActivadas',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8 ,9 ],
                }
            }],
        });
        $('#myTable2').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                header: true,
                title: 'portabilidadesActivadas',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8 ,9,10 ],
                }
            }],
        });
    })
</script>

@endsection