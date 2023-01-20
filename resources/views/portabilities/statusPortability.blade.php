@extends('layouts.octopus')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-12  mb-sm">
                            <label class="">Fecha</label>
                            <div class="input-daterange input-group" data-plugin-datepicker>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input autocomplete="off" type="text" class="form-control" id="status_date" name="status_date">
                            </div>
                        </div>     

                        <div class="col-md-12 mt-md">
                            <button id="filterByDate" class="btn btn-primary btn-sm"><i class="fa fa-cloud-download"></i> Consultar</button>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="panel-body" >
        <table class="table table-bordered table-striped mb-none" id="myTable">
            <thead style="cursor: pointer;">
                <tr>
                    <th class="text-center">DN Portado</th>
                    <th class="text-center">DN Transitorio</th>
                    <th class="text-center">Accion</th>
                    <th class="text-center">Fecha del ABD</th>
                    <th class="text-center">Detalle</th> 
                </tr>
            </thead>
            <tbody id="tbody">
                @foreach($status_portabilitys as $portability)
                    <tr style="cursor: pointer;">
                        <td class="text-center">{{$portability->DN_portado}}</td>    
                        <td class="text-center">{{$portability->DN_transitorio}}</td>    
                        <td class="text-center">{{$portability->accion}}</td>    
                        <td class="text-center">{{$portability->date_ABD}}</td>   
                        @if ($portability->estado == 'OK')
                            <td class="text-center">{{$portability->detalles}}</td>    
                        @else
                            <td class="text-center">{{$portability->estado}}</td>    
                        @endif 
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
 
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                order: false,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    header: true,
                    title: `Tabla de portabilidades del {{$status_date}} `,
                    exportOptions : {
                        columns: [ 0, 1, 2, 3, 4 ],
                    } 
                }],
            });
        });

        $("#filterByDate").click(()=>{
            let status_date = $("#status_date").val();
            let tbl = "";

            if (!(!!status_date)) return alerts(" tiene que ingresar una fecha", false)
            $.ajax({
                url:"/status-filter",
                type:"GET",
                data:{status_date},
                beforeSend: function(){
                    Swal.fire({
                        title: 'Buscando',
                        html: 'Espera un poco, un poquito más...',
                        timer: 2000,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(data){   
                    if (data.status_portabilitys) {
                        if (data.status_portabilitys.length != 0) {
                                var table =  $('#myTable').DataTable();
                                table.destroy();   
                                let array_status_portabilitys = data.status_portabilitys;
                                let detalles = ""
                                let status_date = data.status_date;
                                // console.log(status_date);
                                array_status_portabilitys.forEach(element => {
                                    if (element.estado == 'OK') {
                                        detalles = element.detalles
                                    } else {
                                        detalles = element.estado
                                    }                                
                                    tbl+=`
                                        <tr style="cursor: pointer;">
                                            <td class="text-center">${element.DN_portado}</td>    
                                            <td class="text-center">${element.DN_transitorio}</td>    
                                            <td class="text-center">${element.accion}</td>    
                                            <td class="text-center">${element.date_ABD}</td>    
                                            <td class="text-center">${detalles}</td>    
                                        </tr>
                                    `;
                                });

                                $("#tbody").html(tbl); 

                                table = $('#myTable').DataTable({
                                    order: false,
                                    dom: 'Bfrtip',
                                    buttons: [{
                                        extend: 'excel',
                                        header: true,
                                        title: `Tabla de portabilidades del ${status_date} `,
                                        exportOptions : {
                                            columns: [ 0, 1, 2, 3],
                                        }
                                    }],
                                });
                        }else{
                            return alerts("No existen registros en esta fecha", false)
                        }
                    }else{
                        return alerts("Error consultar con Desarrollo", false)
                    }             
                },
                error: function(data){          
                    console.log(data);
                }                
            });
        })

        function alerts(text, boolean) {
            if (!boolean) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Ooops!',
                    text:  text
                });
            }
        }

    </script>
@endsection
