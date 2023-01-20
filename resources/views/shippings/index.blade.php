@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Dashboard</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><a href="{{route('home')}}">Dashboard</a></li>
        </ol>
        <a class="sidebar-right-toggle" href="{{route('shipping.index')}}"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <form class="form-horizontal form-bordered" action="{{route('shipping.index')}}">
                            
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
                            <button class="btn btn-primary btn-sm" >Consultar</button>
                        </div>
                    </form>

                    <div class="col-md-4 mt-md">
                        <label for="type">Filtrar por:</label>
                        <select class="form-control" data-plugin-multiselect name="type" id="type">
                            <option value="pending">Envíos Pendientes</option>
                            <option value="progress">Envíos en Proceso</option>
                            <option value="completed">Envíos Completados</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<section class="panel"  id="tblPending">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Pendientes</h2>
    </header>
    <div class="panel-body" >
        <table class="table table-bordered table-striped mb-none" id="myTable">
            <thead style="cursor: pointer;">
                <tr>
                    <th>CP</th>
                    <th>Estado</th>
                    <th>Municipio</th>
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th>Canal</th>
                    <th>Creado Por</th>
                    <th>Vendido Por</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendings as $pending)
                <tr>
                    <td>{{ $pending['cp']}}</td>
                    <td>{{ $pending['estado']}}</td>
                    <td>{{ $pending['municipio']}}</td>
                    <td>{{ $pending['to']}}</td>
                    <td>{{ $pending['phone_contact']}}</td>
                    <td>{{ $pending['canal']}}</td>
                    <td>{{ $pending['created_by']}}</td>
                    <td>{{ $pending['sold_by']}}</td>
                    <td>{{ $pending['created_at']}}</td>
                    <td>
                        <a href="{{route('shipping.show',['shipping'=>$pending['id']])}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<section class="panel d-none" id="tblProgress">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">En Progreso</h2>
    </header>
    <div class="panel-body" >
        <table class="table table-bordered table-striped mb-none" id="myTable2">
            <thead style="cursor: pointer;">
                <tr>
                    <th>CP</th>
                    <th>Estado</th>
                    <th>Municipio</th>
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th>Canal</th>
                    <th>Creado Por</th>
                    <th>Vendido Por</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($progresses as $progress)
                <tr>
                    <td>{{ $progress['cp']}}</td>
                    <td>{{ $progress['estado']}}</td>
                    <td>{{ $progress['municipio']}}</td>
                    <td>{{ $progress['to']}}</td>
                    <td>{{ $progress['phone_contact']}}</td>
                    <td>{{ $progress['canal']}}</td>
                    <td>{{ $progress['created_by']}}</td>
                    <td>{{ $progress['sold_by']}}</td>
                    <td>{{ $progress['created_at']}}</td>
                    <td>
                        <a href="{{route('shipping.show',['shipping'=>$progress['id']])}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<section class="panel d-none" id="tblComplete">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Completados</h2>
    </header>
    
    <div class="panel-body" >
        <table class="table table-bordered table-striped mb-none" id="myTable3">
            <thead style="cursor: pointer;">
                <tr>
                    <th>CP</th>
                    <th>Estado</th>
                    <th>Municipio</th>
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th>Canal</th>
                    <th>Creado Por</th>
                    <th>Vendido Por</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($completes as $complete)
                <tr>
                    <td>{{ $complete['cp']}}</td>
                    <td>{{ $complete['estado']}}</td>
                    <td>{{ $complete['municipio']}}</td>
                    <td>{{ $complete['to']}}</td>
                    <td>{{ $complete['phone_contact']}}</td>
                    <td>{{ $complete['canal']}}</td>
                    <td>{{ $complete['created_by']}}</td>
                    <td>{{ $complete['sold_by']}}</td>
                    <td>{{ $complete['created_at']}}</td>
                    <td>
                        <a href="{{route('shipping.show',['shipping'=>$complete['id']])}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                    </td>
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
            buttons: [
                'csv', 'excel',
            ],
        });

        $('#myTable2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel',
            ],
        });

        $('#myTable3').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel',
            ],
        });
    });

    $('#type').change(function(){
        let type = $(this).val();

        if(type == 'pending'){
            $('#tblProgress').addClass('d-none');
            $('#tblComplete').addClass('d-none');
            $('#tblPending').removeClass('d-none');
        }else if(type == 'progress'){
            $('#tblProgress').removeClass('d-none');
            $('#tblComplete').addClass('d-none');
            $('#tblPending').addClass('d-none');
        }else if(type == 'completed'){
            $('#tblProgress').addClass('d-none');
            $('#tblComplete').removeClass('d-none');
            $('#tblPending').addClass('d-none');
        }
    });
</script>
@endsection