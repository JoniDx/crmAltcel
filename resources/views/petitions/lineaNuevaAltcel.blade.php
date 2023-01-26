@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Lineas Nuevas CRM</h2>
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
     <div class="panel-body table-responsive">
        <h2>Lineas Nuevas CRM POS</h2>
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead style="cursor: pointer;">
                <tr>
                <th scope="col">Cliente</th>
                <th scope="col">MSISDN</th>
                <th scope="col">ICC</th>
                <th scope="col">Rate</th>
                <th scope="col">Precio Plan</th>
                <th scope="col">Producto</th>
                <th scope="col">Promotor</th>
                <th scope="col">Fecha de Activación</th>
                <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lineNews as $lineNew)
                    <tr>
                        <td>{{$lineNew->client}}</td>
                        <td>{{$lineNew->msisdn}}</td>
                        <td>{{$lineNew->icc}}</td>
                        <td>{{$lineNew->rate}}</td>
                        <td>$ {{$lineNew->amount}}</td>
                        <td>{{$lineNew->product}}</td>
                        <td>{{$lineNew->username}}</td>
                        <td>{{$lineNew->date}}</td>
                        <td><button class="btn btn-primary activation" >Activar</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>



<input type="hidden" id="user_id" value="{{Auth::user()->id}}">
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script>
   $(document).ready( function () {
        $('#datatable-default').DataTable({
            order: false,
            dom: 'Bfrtip',
            buttons: [{
                header: true,
                title: 'portabilidadesPendientes',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ],
                }
            }],
        });
    });
</script>
@endsection