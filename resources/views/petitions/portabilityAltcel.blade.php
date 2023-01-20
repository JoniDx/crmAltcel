@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Portabilidades Altcel</h2>
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
        <form class="form-horizontal form-bordered" action="{{route('portaAltcel')}}">

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
                        <input type="hidden" name="status" value="pendientes">
                    </div>
                </div>
                <button class="col-md-1 btn btn-success btn-sm">Consultar</button>
            </div>
        </form>
       <table class="table table-bordered table-striped mb-none" id="datatable-default">
           <thead style="cursor: pointer;">
               <tr>
               <th scope="col">Nombre</th>
               <th scope="col">Curp</th>
               <th scope="col">Número de Teléfono</th>
               <th scope="col">nip</th>
               <th scope="col">Fecha</th>
               <th scope="col">Status</th>
               <th scope="col">Compañia</th>
               <th scope="col">Icc</th>
               <th scope="col">Observaciones</th>
               <th scope="col">Promo</th>
               <th scope="col">INE</th>
               <th scope="col">Dirección</th>
               <th scope="col">Promotor</th>
               <th scope="col">Acción</th>
               </tr>
           </thead>
           <tbody>
               @foreach($portabilitys as $portabiliti)
                   <tr>
                       <td>{{$portabiliti->nombre}}</td>
                       <td>{{$portabiliti->curp}}</td>
                       <td>{{$portabiliti->numero}}</td>
                       <td>{{$portabiliti->nip}}</td>
                       <td>{{$portabiliti->fecha}}</td>
                       <td>{{$portabiliti->status}}</td>
                       <td>{{$portabiliti->cia}}</td>
                       <td>{{$portabiliti->iccid}}</td>
                       <td>{{$portabiliti->observaciones}}</td>
                       <td>{{$portabiliti->promo}}</td>
                       <td>{{$portabiliti->ine}}</td>
                       <td>{{$portabiliti->direccion}}</td>
                       <td>{{$portabiliti->promotor}}</td>
                       <td><button class="btn btn-primary verify" data-petiton="{{$portabiliti->id}}">Acción</button></td>
                   </tr>
               @endforeach
           </tbody>
       </table>
   </div>
</section>

<section class="panel">
    <div class="panel-body table-responsive">
        <h2>Portabilidades Realizadas</h2>
        <form class="form-horizontal form-bordered" action="{{route('portaAltcel')}}">
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
                        <input type="hidden" name="status" value="completadas">
                    </div>
                </div>
                <button class="col-md-1 btn btn-success btn-sm">Consultar</button>
            </div>
        </form>
       <table class="table table-bordered table-striped mb-none" id="datatable-default2">
           <thead style="cursor: pointer;">
               <tr>
               <th scope="col">Nombre</th>
               <th scope="col">Curp</th>
               <th scope="col">Número de Teléfono</th>
               <th scope="col">nip</th>
               <th scope="col">Fecha</th>
               <th scope="col">Status</th>
               <th scope="col">Compañia</th>
               <th scope="col">Icc</th>
               <th scope="col">Observaciones</th>
               <th scope="col">Promo</th>
               <th scope="col">INE</th>
               <th scope="col">Dirección</th>
               <th scope="col">Promotor</th>
               </tr>
           </thead>
           <tbody>
               @foreach($portabilitysCompletadas as $portabilitiCompletada)
                   <tr>
                       <td>{{$portabilitiCompletada->nombre}}</td>
                       <td>{{$portabilitiCompletada->curp}}</td>
                       <td>{{$portabilitiCompletada->numero}}</td>
                       <td>{{$portabilitiCompletada->nip}}</td>
                       <td>{{$portabilitiCompletada->fecha}}</td>
                       <td>{{$portabilitiCompletada->status}}</td>
                       <td>{{$portabilitiCompletada->cia}}</td>
                       <td>{{$portabilitiCompletada->iccid}}</td>
                       <td>{{$portabilitiCompletada->observaciones}}</td>
                       <td>{{$portabilitiCompletada->promo}}</td>
                       <td>{{$portabilitiCompletada->ine}}</td>
                       <td>{{$portabilitiCompletada->direccion}}</td>
                       <td>{{$portabilitiCompletada->promotor}}</td>
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
    $('#datatable-default').DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excel',
            scrollX: true,
            header: true,
            title: 'portabilidadesCompletadas',
            exportOptions : {
                columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
            }
        }],
    });

    $('#datatable-default2').DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excel',
            scrollX: true,
            header: true,
            title: 'portabilidadesCompletadas',
            exportOptions : {
                columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ],
            }
        }],
    });

    $('.verify').click(function(){
        let idPetion = $(this).data('petiton');
        let userId = $('#user_id').val();
        $.ajax({
            url: "{{route('changeStatusAltcel1')}}",
            method: "GET",
            data: {idPetion:idPetion, userId:userId},
            success:function(response){
                if(response.http_code == 1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Well done!!',
                        text: response.message,
                    });
                    setTimeout(function(){ location.reload(); }, 2500);
                }else if (response.http_code == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ocurrio un problema',
                        // text: 'Comuniquese ',
                    });
                }
            }
        })
    });
</script>
@endsection