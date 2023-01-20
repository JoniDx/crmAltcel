@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Recargas de clientes Veracruz</h2>
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

<div class="container">
    <section class="panle">
        <div class="row">
            <div class="col-lg-12 ">
                <section class="panel">
                    <h2>Tabla de recargas</h2>
                    <table class="table table-bordered table-striped mb-none" id="myTable2">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Nombre</th>
                                <th>Monto</th>                            
                                <th>Razon</th>
                                <th>Comentario</th>
                                <th>Distribuidor</th>
                                <th>Fecha</th>                            
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{$item->MSISDN}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->reason}}</td>
                                    <td>{{$item->comment}}</td>
                                    <td>{{$item->user_name}} {{$item->user_lastname}}</td>
                                    <td>{{$item->date}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                
                </section>
            </div>
        </div>
    </section>

    <section class="panle">
        <div class="row">
            <div class="col-lg-12 ">
                <section class="panel">
                    <h2>Tabla de referencias</h2>
                    <table class="table table-bordered table-striped mb-none" id="myTable3">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Nombre</th>
                                <th>Monto</th>                            
                                <th>Referencia</th>
                                <th>Canal</th>
                                <th>Distribuidor</th>
                                <th>Fecha completada</th>                            
                                <th>Fecha del ultimo cambio</th>                            
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach ($referencePurchases as $item)
                                <tr>
                                    <td>{{$item->MSISDN}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->reference}}</td>
                                    <td>{{$item->channel}}</td>
                                    <td>{{$item->user_name}} {{$item->user_lastname}}</td>
                                    <td>{{$item->date}}</td>
                                    <td>{{$item->date_complete}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                
                </section>
            </div>
        </div>
    </section>
</div>
<!-- FUBCIONES JAVASCRIPT -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function () {
        $('#myTable2').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                header: true,
                title: `Tabla de recargas`,
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ],
                }
            }],
        });

        $('#myTable3').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                header: true,
                title: `Tabla de referencias`,
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ],
                }
            }],
        });
    });

</script>

@endsection