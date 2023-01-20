@extends('layouts.octopus')
@section('content')
    <header class="page-header">
        <h2>Reporte de Clientes</h2>
        <div class="right-wrapper pull-right" style="margin-right: 1rem;">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{route('home')}}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Dashboard</span></li>
            </ol>
        </div>
    </header>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label for="type">Concepto:</label>
                            <select class="form-control" data-plugin-multiselect name="plan" id="plan">
                                <option value="" selected>Seleccione un opción</option>
                                <option value="108">Plan Anual 40gb</option>
                                <option value="103">Plan Anual 5gb</option>
                                <option value="109">Plan Semestral </option>
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
                            <button id="searchClients" class="btn btn-primary btn-sm"><i class="fa fa-cloud-download"></i> Consultar</button>
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
                <a href="#" class="fa fa-times"></a>
            </div>
                <h2 class="panel-title">Clientes</h2>
        </header>
        <div class="panel-body">
            <table class="table table-bordered table-striped mb-none" id="myTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Contacto</th>
                        <th>MSISDN</th>
                        <th>ICC</th>
                        <th>Plan/Paquete</th>
                        <th>Servicio</th>
                        <th>Status</th>
                        <th>Fecha</th>
                        <th>Fecha de Expiración</th>
                    </tr>
                </thead>
                <tbody id="tbody">

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
        $("#searchClients").click(async function(){
            let plan = $("#plan").val();
            let date_start = $("#start_date").val();
            let date_end = $("#end_date").val();
            let date_send = false;
            if (!(!!plan)) return alerts("un plan", false)
            if ((!!date_start || !!date_end) ) {
                if (!(!!date_start && !!date_end)) {
                    return alerts("las fechas", false)
                }else{ 
                    date_send = true;
                }  
            }        
            await checkPlanUsers(plan, date_send, date_start, date_end);


        });

        function checkPlanUsers(plan, date_send, date_start, date_end) {
            let tbl = ``;
            var table =  $('#myTable').DataTable();
            table.destroy();

            $.ajax({
                url:"/reports-plans",
                type:"GET",
                data:{plan:plan, date_send:date_send, date_start:date_start, date_end:date_end},
                success: function(data){   

                    let array_clients = data.clients;               
                    array_clients.forEach(element => {
                        tbl+=`
                            <tr>
                                <td>${element.name}</td>
                                <td>${element.cellphone}</td>
                                <td>${element.MSISDN}</td>
                                <td>${element.icc}</td>
                                <td>${element.rate_name}-${element.amount_rate}</td>
                                <td>${element.service}</td>
                                <td>${element.status_altan}</td>
                                <td>${element.date_activation}</td>
                                <td>${element.date_expire}</td>
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
                                    title: 'Tabla de planes',
                                    exportOptions : {
                                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ],
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

    </script>

@endsection