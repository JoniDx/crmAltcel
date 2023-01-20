@extends('layouts.octopus')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label for="type">Concepto:</label>
                            <select class="form-control" data-plugin-multiselect name="supervisor" id="supervisor">
                                <option value="" selected>Seleccione un opción</option>
                                @if(!(Auth::user()->id == 1567 || Auth::user()->id == 1825 || Auth::user()->id == 2253))
                                    <option value="1565">Supervisor 1</option> 
                                @endif
                                @if (!(Auth::user()->id == 1565 || Auth::user()->id == 1824 || Auth::user()->id == 2253))
                                    <option value="1567">Supervisor 2</option> 
                                @endif
                                @if (!(Auth::user()->id == 1567 || Auth::user()->id == 1825 || Auth::user()->id == 1565 || Auth::user()->id == 1824))
                                    <option value="2253">Supervisor 3</option> 
                                @endif
                        
                            </select>
                        </div>      

                        <div class="col-md-8  mb-sm">
                            <label class="">Fecha</label>
                            <div class="input-daterange input-group" data-plugin-datepicker>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input autocomplete="off" type="text" class="form-control" id="start_date" name="start_date">
                                <span class="input-group-addon">a</span>
                                <input autocomplete="off" type="text" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>     

                        <div class="col-md-12 mt-md">
                            <button id="searchSupervisor" class="btn btn-primary btn-sm"><i class="fa fa-cloud-download"></i> Consultar</button>
                        </div>

                    </div>

                    <div class="">
                        <h3>Proyeccion del mes actual</h3>
                        <table class="table table-bordered table-striped " style="margin-top: 2rem;" id="">
                            <thead style="cursor: pointer;">
                                <tr>
                                    <th class="text-center">Supervisor</th>
                                    <th class="text-center">Meta</th>
                                    <th class="text-center">Avance</th>
                                    <th class="text-center">Porcentaje</th> 
                                    <th class="text-center">Tendencia </th>
                                    <th class="text-center">Proyeccion</th>
                                    <th class="text-center">Deficit</th>
                                    <th class="text-center">Lineal</th>
                                    <th class="text-center">Venta total</th>
                                    <th class="text-center">Productividad</th>
                                </tr>
                            </thead>
                            <tbody id="proyection">
                                <?php $meta = 684; $number = 0;?>
                                <tr>
                                    @foreach($proyecciones as $proyeccion)
                                        <?php $number++?>
                                        <tr style="cursor: pointer;">
                                            <td class="text-center">Supervisor {{$number}}</td>  
                                            <td class="text-center">{{$meta}}</td>  
                                            <td class="text-center">{{$proyeccion->lineas}}</td>  
                                            <td class="text-center">{{round($proyeccion->lineas/$meta*100)}}%</td>  
                                            <td class="text-center">{{round($proyeccion->lineas/6*24)}}</td>  
                                            <td class="text-center">{{round(round($proyeccion->lineas/6*24)/$meta*100)}}%</td>  
                                            <td class="text-center">{{$meta-$proyeccion->lineas}}</td>  
                                            <td class="text-center">{{round($meta-$proyeccion->lineas/18)}}</td>  
                                            <td class="text-center">{{$proyeccion->lineas}}</td>  
                                            <td class="text-center">{{round($proyeccion->lineas/9/5)}}</td>  
                                        </tr>
                                    @endforeach

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="panel-body" >
        <table class="table table-bordered table-striped mb-none" id="myTable">
            <thead style="cursor: pointer;">
                <tr>
                    <th class="text-center">Promotor</th>
                    <th class="text-center">Portabilidades / Ganancia</th>
                    <th class="text-center">Ingresos</th>
                    <th class="text-center">Lineas Nuevas / Ganancia</th> 
                </tr>
            </thead>
            <tbody id="tbody">
                @foreach($promotores as $promotor)
                    <tr style="cursor: pointer;">
                        <td onclick="openModal({{$promotor->id}}, '{{$promotor->username}}')">{{$promotor->username}}</td>
                        <td class="text-center">{{$promotor->portabilidad}} / ${{$promotor->portabilidadMoneyTotal}}</td>
                        <td class="text-center">${{$promotor->portabilidadMoney + $promotor->portabilidaPromo}}</td>
                        <td class="text-center">{{$promotor->lineaNueva}} / ${{$promotor->lineaNuevaMoney}}</td> 
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
    
    <div class="modal fade" style="margin:2rem;" id="distribuidorModal" tabindex="-1" role="dialog" aria-labelledby="distribuidorModalLabel" aria-hidden="true">
        <div class="modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="distribuidorModalLabel">Portas de distribuidor</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped mb-none" id="myTable2">
                        <thead style="cursor: pointer;">
                            <tr>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">MSISDN</th>
                                <th class="text-center">ICC</th> 
                                <th class="text-center">Plan/Paquete</th>
                                <th class="text-center">Servicio</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Compañía</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_modal">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    

    <script>
        var table =  $('#myTable').DataTable();
        table.destroy();

        $(document).ready(function () {

            let supervisor = send_supervisor({{$supervisor}})

            $('#myTable').DataTable({
                order: false,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    header: true,
                    title: `Tabla de registros del ${supervisor}`,
                    exportOptions : {
                        columns: [ 0, 1, 2, 3 ],
                    }
                }],
            });
        });

        $("#searchSupervisor").click(()=>{
            let supervisor = $("#supervisor").val();
            let date_start = $("#start_date").val();
            let date_end = $("#end_date").val();
            let date_send = false;
            if (!(!!supervisor)) return alerts("un supervisor", false)
            if ((!!date_start || !!date_end) ) {
                if (!(!!date_start && !!date_end)) {
                    return alerts("las fechas", false)
                }else{ 
                    date_send = true;
                }  
            }                  
            check_supervisor(supervisor, date_send, date_start, date_end);
        });

        function check_supervisor(supervisor, date_send, date_start, date_end) {
            let tbl = "";
            var table =  $('#myTable').DataTable();
            let supervisor_name = send_supervisor(parseInt(supervisor))
            table.destroy();
            $.ajax({
                url:"/supervisor-reports-veracruz",
                type:"GET",
                data:{supervisor:supervisor, date_send:date_send, date_start:date_start, date_end:date_end},
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
                    let array_promotores = data.promotores;
                    array_promotores.forEach(element => {
                        tbl+=`
                            <tr style="cursor: pointer;">
                                <td onclick="openModal(${element.id}, '${element.username}')">${element.username}</td>
                                <td class="text-center">${element.portabilidad} / $${element.portabilidadMoneyTotal}</td>
                                <td class="text-center">$${element.portabilidadMoney + element.portabilidaPromo}</td>
                                <td class="text-center">${element.lineaNueva} / $${element.lineaNuevaMoney}</td>
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
                                    title: `Tabla de registros del ${supervisor_name} `,
                                    exportOptions : {
                                        columns: [ 0, 1, 2, 3],
                                    }
                                }],
                            });
                },
                error: function(data){          
                    console.log(data);
                }                
            });
        }
        
        function alerts(text, boolean) {
            if (!boolean) {
                return Swal.fire({
                    icon: 'error',
                    title: 'Ooops!',
                    text: 'tiene que ingresar ' + text
                });
            }
        }


        function openModal(id, name) {
            let date_start = $("#start_date").val();
            let date_end = $("#end_date").val();
            let date_send = false;
            let tbl = "";
            var table2 =  $('#myTable2').DataTable();
            table2.destroy();

            // console.log(name);
            if ((!!date_start || !!date_end) ) {
                if (!(!!date_start && !!date_end)) {
                    return alerts("las fechas", false)
                }else{ 
                    date_send = true;
                }  
            } 

            $.ajax({
                url:"/modal-report-distribuidores",
                type:"GET",
                data:{distribuidor:id, date_send:date_send, date_start:date_start, date_end:date_end},
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
                    let array_portas = data.portas;               
                    array_portas.forEach(element => {
                        tbl+=`
                            <tr>
                                <td>${element.cliente}</td>
                                <td class="text-center">${element.msisdn}</td>
                                <td class="text-center">${element.icc}</td>
                                <td class="text-center">${element.rate}</td>
                                <td class="text-center">${element.product}</td>
                                <td class="text-center">${element.date}</td>
                                <td class="text-center">${element.tipo}</td>
                                <td class="text-center">${element.company}</td>
                            </tr>
                        `;
                    });
                    $("#tbody_modal").html(tbl);        
                    $('#distribuidorModal').modal({
                        show: 'false'
                    });    

                    table2 = $('#myTable2').DataTable({
                                order: false,
                                dom: 'Bfrtip',
                                buttons: [{
                                    extend: 'excel',
                                    header: true,
                                    title: `Tabla de registros del ${name}`,
                                    exportOptions : {
                                        columns: [ 0, 1, 2, 3],
                                    }
                                }],
                            });         
                },
                error: function(data){          
                    console.log(data);
                }                
            });

        }

        function send_supervisor(supervisor_id) {
            console.log(supervisor_id);
            switch (supervisor_id) {
                case 1565:
                    return "Supervisor 1"
                    break;
                case 1567:
                    return "Supervisor 2"
                break;
                case 2253:
                    return "Supervisor 3"
                break;
            }
        }
    </script>
@endsection
