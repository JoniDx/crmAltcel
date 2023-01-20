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
<input type="hidden" id="userConsigned" value="{{auth()->user()->id}}">
<div class="panel-body mb-lg pr-xl pl-xl">
    <div class="row">
        <section class="panel panel-featured-left panel-featured-info col-md-4">
            <div class="panel-body">
                <div class="widget-summary widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-info">
                            <i class="fa fa-usd"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Recargas</h4>
                            <div class="info">
                                <strong class="amount">${{number_format($purchasesTotal,2)}}</strong>
                                <span class="text-primary">( {{$purchasesCount}} recargas )</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        <section class="panel panel-featured-left panel-featured-warning col-md-4">
            <div class="panel-body">
                <div class="widget-summary widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-warning">
                            <i class="fa fa-usd"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Cambios de Plan</h4>
                            <div class="info">
                                <strong class="amount">${{number_format($changesTotal,2)}}</strong>
                                <span class="text-primary">( {{$changesCount}} cambios )</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        <section class="panel panel-featured-left panel-featured-success col-md-4">
            <div class="panel-body">
                <div class="widget-summary widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-success">
                            <i class="fa fa-usd"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Mensualidades</h4>
                            <div class="info">
                                <strong class="amount">${{number_format($paysTotal,2)}}</strong>
                                <span class="text-primary">( {{$paysCount}} mensualidades )</span>
                            </div>
                        </div>
                        
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
        </div>
        <h2 class="panel-title">Cambio de Producto</h2>
    </header>
    <div class="panel-body table-responsive">
        <table class="table table-bordered table-striped mb-none " id="myTable">
            <thead>
                <tr>
                    <th>Monto</th>
                    <th>Cobrador</th>
                    <th>Cliente</th>
                    <th>MSISDN</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Razón</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Cobrar</th>
                    <th>Ver</th>
                </tr>
            </thead>
                <tbody>
                    @foreach($changes as $change)
                        <tr>
                            <td>${{number_format($change['amount'],2)}}</td>
                            <td>{{$change['user']}}</td>
                            <td>{{$change['client']}}</td>
                            <td>{{$change['MSISDN']}}</td>
                            <td>{{$change['name_rate']}}</td>
                            <td>{{$change['status']}}</td>
                            <td>{{$change['reason']}}</td>
                            <td>{{$change['date']}}</td>
                            <td><span class="badge label-warning">Cambio de Plan</span></td>
                            <td><button class="btn btn-warning cobrar" data-status="pendiente" data-type="changes" data-id="{{$change['id']}}">Cobrar</button></td>
                            <td><a href="{{url('/cortes/'.$change['who_did_id'])}}" class="btn btn-info btn-sm mt-xs"><i class="fa fa-eye"></i></a></td>
                        </tr>
                @endforeach     
                @foreach($purchases as $purchase)
                    <tr>
                        <td>${{number_format($purchase['amount'],2)}}</td>
                        <td>{{$purchase['user']}}</td>
                        <td>{{$purchase['client']}}</td>
                        <td>{{$purchase['MSISDN']}}</td>
                        <td>{{$purchase['name_rate']}}</td>
                        <td>{{$purchase['status']}}</td>
                        <td>{{$purchase['reason']}}</td>
                        <td>{{$purchase['date']}}</td>
                        <td><span class="badge label-info">Recarga</span></td>
                        <td><button class="btn btn-warning cobrar" data-status="pendiente" data-type="purchases" data-id="{{$purchase['id']}}">Cobrar</button></td>
                        <td><a href="{{url('/cortes/'.$purchase['who_did_id'])}}" class="btn btn-info btn-sm mt-xs"><i class="fa fa-eye"></i></a></td>
                    </tr>
                @endforeach    
            
                @foreach($pays as $pay)
                    <tr>
                        <td>${{number_format($pay['amount'],2)}}</td>
                        <td>{{$pay['user']}}</td>
                        <td>{{$pay['client']}}</td>
                        <td>{{$pay['MSISDN']}}</td>
                        <td>{{$pay['name_rate']}}</td>
                        <td>{{$pay['status']}}</td>
                        <td>Cobro</td>
                        <td>{{$pay['date']}}</td>
                        <td><span class="badge label-success">Mensualidad</span></td>
                        <td><button class="btn btn-warning cobrar" data-status="pendiente" data-type="monthly" data-id="{{$pay['id']}}">Cobrar</button></td>
                        <td><a href="{{url('/cortes/'.$pay['who_did_id'])}}" class="btn btn-info btn-sm mt-xs"><i class="fa fa-eye"></i></a></td>
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

<script >
    $(document).ready( function () {
        $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                title: 'Concesiones Pendientes',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ],
                }
            }]
        });
    });

    $('.cobrar').click(function(){
        let item = $(this);
        let status = $(this).attr('data-status');
        let type = $(this).attr('data-type');
        let id = $(this).attr('data-id');
        let idConsigned = $('#userConsigned').val()
        console.log(status);
        console.log(type);
        console.log(id);
        
        $.ajax({
            url: "{{route('status.update')}}",
                method: 'POST',
                data: {idpay:id, type:type, status:status, id_consigned:idConsigned},
                success:function(response){
                        Swal.fire({ 
                            icon: 'success',
                            title: 'Éxitoso',
                            text: 'Cobro exitoso',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $(item).closest('tr').remove();
                        
                }
        })

    })
</script>

@endsection