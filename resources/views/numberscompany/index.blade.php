@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Servicios de Compañías</h2>
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
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Números</h2>
    </header>
    <div class="panel-body" >
        <table class="table table-bordered table-striped mb-none" id="myTable">
            <thead style="cursor: pointer;">
                <tr>
                    <th>Empresa</th>
                    <th>#Línea</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $companies as $company )
                <tr style="cursor: pointer;" >
                    <td>{{$company['company']}}</td>
                    <td>{{$company['quantity']}}</td>

                    <td>
                    <button class="btn btn-info btn-sm btnDetalles" data-company="{{$company['company_id']}}" >
                        <i class="fa fa-eye"></i>
                    </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>

<div class="modal fade" id="modalPortabilidades" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-dark text-bold">Detalles de Números</h4>
            </div>

            <div class="col-md-4 mb-md">
                <label class="form-label mr-1" for="offers">Paquete (NORMAL):</label><br>
                <select class="form-control form-control-sm col-md-6" id="pack" >
                    <option selected value="0" >Nothing</option>
                </select>
            </div>

            <div class="col-md-4 mb-md">
                <label class="form-label mr-1" for="offers">Paquete (FFM):</label><br>
                <select class="form-control form-control-sm col-md-6" id="packFFM" >
                    <option selected value="0" >Nothing</option>
                </select>
            </div>
            <input type="hidden" id="company_to_recharge">
            <div class="panel-body" >
                <table class="table table-bordered table-striped mb-none" id="myTable">
                    <thead style="cursor: pointer;">
                        <tr>
                            <th>Empresa</th>
                            <th>#Línea</th>
                            <th>Producto</th>
                            <th>Creado por:</th>
                            <th>Fecha de Creación:</th>
                        </tr>
                    </thead>
                    <tbody id="infoTarje"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="executeBulk" >Ejecutar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalResultadosBulk" tabindex="-1" role="dialog" aria-labelledby="myModalResultadosBulkTile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-dark text-bold" id="titleResultadosBulk" ></h4>
            </div>
            <div class="col-12 mb-md" >
                <div class="col-md-6">
                    <h4 class="modal-title text-dark text-bold" id="successTag" >Exitosos: 100</h4>
                </div>
                <div class="col-md-6">
                    <h4 class="modal-title text-dark text-bold" id="errorsTag" >Erróneos: 100</h4>
                </div>
                <div class="col-md-12 mb-md">
                    <h4 class="modal-title text-dark text-bold" id="packTag" >Paquete elegido: </h4>
                </div>
            </div>
            <div class="mr-md ml-md" style="width: 95%;" >
                    <table class="table table-bordered table-striped mb-none mr-md ml-md" style="width: 95%;" id="datatable-records-bulk">
                        <thead >
                            <tr>
                                <th scope="col">MSISDN</th>
                                <th scope="col">Status Code</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Effective Date</th>
                                <th scope="col">Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                    
                        </tbody>
                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<section class="panle">
<div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Añadir Número</h2>
                </header>
                <div class="col-md-12">
                    <div class="col-md-3"  style="margin-bottom: 2rem; margin-top: 1rem; margin-left: -1.5rem;">
                        <span class="btn btn-default btn-file">
                            <span class="fileupload-new">Selecciona un archivo</span>
                            <input type="file" accept=".csv" id="csvNumbers">
                        </span>
                        <button class="btn btn-primary" id="importNumbers">Cargar Archivo</button>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal form-bordered">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Empresa</label>
                                        <select class="form-control" id="empresa_number">
                                            <option selected value="0">-- SELECCIONE --</option>
                                            @foreach( $companiesEmpre as $companie )
                                                <option value="{{ $companie->id }}">{{ $companie->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="lastname">#Línea</label>
                                        <input type="text" class="form-control form-control-sm" id="no_line" name="no_line" required>
                                        <label id="prueb"></label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="email">Creado Por</label>
                                        <input type="text" class="form-control form-control-sm" name="email" value="{{Auth::user()->name}} {{Auth::user()->lastname}}" disabled>
                                        <input type="hidden" class="form-control form-control-sm" id="new_create" name="email" value="{{Auth::user()->id}}" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="cellphone">Fecha de Recarga</label>
                                        <input type="datetime-local" class="form-control form-control-sm" id="date_recarga" name="date_recarga" required>
                                    </div>

                                    <input type="hidden" class="form-control" id="id_number" name="id_number">
                                </div>
                                <button type="button" class="btn btn-success" style="margin-top: 1rem;" id="saveNumbers" disabled>Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</section>

<!-- FUBCIONES JAVASCRIPT -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script>
    $('#no_line').keyup(function(){
        var msisdn = $('#no_line').val();
        let list = '';
        let badge_color = 'badge-primary';
        let numerFuncion  = '';

        $.ajax({
            url:"{{route('allDataLinea')}}",
            method: "POST",
            data: {msisdn:msisdn},
            success: function(data){
                // if(data.MSISDN == msisdn && data.status == "available"){
                if(data.MSISDN == msisdn){
                    badge_color = 'label label-success';
                    numerFuncion = 'Valido';

                    $('#saveNumbers').prop('disabled', false);
                    $('#id_number').val(data.id);
                } else{
                    badge_color = 'label label-danger';
                    numerFuncion = 'No valido';

                    $('#saveNumbers').prop('disabled', true);
                    $('#id_number').val('');
                }

                list+='<li class="list-group-item form-control form-control-sm">Número: <span class="badge '+badge_color+'"> '+numerFuncion+'</span></li>';

                $('#prueb').html(list);
            }
        });
    });
</script>

<script>
    $('#saveNumbers').click(function(){
        let empresa_number = $('#empresa_number').val();
        let new_create = $('#new_create').val();
        let date_recarga = $('#date_recarga').val();
        let id_number = $('#id_number').val();

        $.ajax({
            url: "{{ route('addNumbersCompany')}}",
            data:{
                  empresa_number:empresa_number,
                  new_create:new_create,
                  date_recarga:date_recarga,
                  id_number:id_number
                },
            success: function(data){
                if(data.error == 0){
                    let timerInterval
                    Swal.fire({
                        title: 'Guardando Registro',
                        html: 'Espere un momento mientras se genera el registro',
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                            // b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Registro generado exitosamente!!',
                                showConfirmButton: false,
                                timer: 2000
                            }).then((result) => {
                                window.location.reload();

                                $('#empresa_number').val('');
                                $('#date_recarga').val('');
                                $('#no_line').val('');
                                $('#id_number').val('');
                            });
                            // window.location.reload();

                        }
                    })
                }else if(data.error == 1){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        type: 'error'
                    });
                }
            }
        });
    });
</script>

<script>
    $('.btnDetalles').click(function(){
        let company_id = $(this).attr('data-company');
        let card = '', numbers = '', packs = '', packsOptions = '<option selected value="0">Elige un plan...</option>', packsFFM = '', packsFFMOptions = '<option selected value="0">Elige un plan...</option>';

        $.ajax({
            url: "{{ route('allCompanyId')}}",
            data:{company_id},
            success: function(data){
                numbers = data.dataNumber
                packs = data.packs;
                packsFFM = data.packsFFM;

                numbers.forEach(function(element){
                    // console.log(element);

                    card+="<tr><td>"+element.name+"</td><td>"+element.MSISDN+"</td><td>"+element.producto+"</td><td>"+element.nombre+" "+element.lastname+"</td><td>"+element.created_at+"</td></tr>";
                });

                packs.forEach(function(element){
                    // console.log(element);

                    packsOptions+="<option value='"+element.offerID+"' data-offerid='"+element.id+"' data-name='"+element.name+"' >"+element.name+" - $"+parseFloat(element.price_sale).toFixed(2)+"</option>";
                });

                packsFFM.forEach(function(element){
                    // console.log(element);

                    packsFFMOptions+="<option value='"+element.offerID+"' data-offerid='"+element.id+"' data-name='"+element.name+"' >"+element.name+" - $"+parseFloat(element.price_sale).toFixed(2)+"</option>";
                });

                // if(products.length > 1){
                //     alert('Al parecer esta empresa tiene líneas con más de un producto.');
                // }

                $('#infoTarje').html(card);
                $('#pack').html(packsOptions);
                $('#packFFM').html(packsFFMOptions);
                $('#company_to_recharge').val(company_id);
            }
        });

        $('#modalPortabilidades').modal('show');
    });
</script>

<script>
    $('#importNumbers').click(function(){
        let getCSV = $('#csvNumbers').val();

        let empresa_number = $('#empresa_number').val();
        let user_create = $('#new_create').val();
        let date_recarga = $('#date_recarga').val();

        // console.log(getCSV.length);
        // return false;

        if(getCSV.length == 0 || /^\s+$/.test(getCSV)){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor cargue un fichero con extensión CSV.',
                showConfirmButton: false,
                timer: 2000
            });

            console.log('CSV')
        }

        if(empresa_number == 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe Seleccionar una Empresa.',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        } 

        if(date_recarga == ''){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe Seleccionar una Fecha de Recarga.',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }


        let file_data = $('#csvNumbers').prop('files')[0];
        let form_data = new FormData();
        form_data.append('empresa_number', empresa_number);
        form_data.append('user_create', user_create);
        form_data.append('date_recarga', date_recarga);
        form_data.append('file', file_data);
        form_data.append('_token', '{{csrf_token()}}');

        $.ajax({
            url: "{{route('csvNumberComapy')}}",
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type:'POST',
           success:function(response){
               if (response == 1) {
                    let timerInterval;
                    Swal.fire({
                        title: 'Guardando Registro de Excel',
                        html: 'Espere un momento mientras se genera el registro',
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                            // b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        
                        if (result.dismiss === Swal.DismissReason.timer) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Registro generado exitosamente!!',
                                showConfirmButton: false,
                                timer: 2000
                            }).then((result) => {
                                window.location.reload();

                                $('#empresa_number').val('');
                                $('#date_recarga').val('');
                            });
                        }
                    });
                }
           },error(){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor cargue un fichero con extensión CSV codificado en UTF-8 (delimitado por comas) (.csv)',
                showConfirmButton: false,
                timer: 4500
            });

            }
        });
    });


    $('#executeBulk').click(function(){
        let offerID = $('#pack').val();
        let id = $('#pack option:selected').attr('data-offerid');
        let offerName = $('#pack option:selected').attr('data-name');
        let offerIDFFM = $('#packFFM').val();
        let idFFM = $('#packFFM option:selected').attr('data-offerid');
        let offerNameFFM = $('#packFFM option:selected').attr('data-name');
        let company = $('#company_to_recharge').val();
        let user_id = "{{Auth::user()->id}}";
        let records = '', rows = new Array(), msisdn = '', statusCode = '', orderID = '', effectiveDate = '', description = '', companyName, success = 0, errors = 0;

        if(offerID == 0 && offerIDFFM == 0){
            Swal.fire({
                icon: 'error',
                title: 'Debe elegir al menos un paquete (NORMAL o FFM).',
                timer: 2000,
                showConfirmButton: false
            });

            return false;
        }

        if(offerID > 0 && offerIDFFM > 0){
            Swal.fire({
                icon: 'error',
                title: 'Debe elegir solo un tipo de paquete (NORMAL o FFM).',
                timer: 2000,
                showConfirmButton: false
            });

            return false;
        }

        Swal.fire({
            title: 'ATENCIÓN',
            html: "¿Está seguro de aplicar <b>RECARGA</b> a todos los números mostrados en la tabla?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'SÍ, ESTOY SEGURO',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-primary mr-md',
                cancelButton: 'btn btn-danger '
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {
                

                $.ajax({
                    url: "{{ route('rechargeBulk')}}",
                    type: 'POST',
                    data:{
                        _token: "{{csrf_token()}}",
                        offerID,
                        id,
                        offerIDFFM,
                        idFFM,
                        company,
                        user_id
                    },
                    beforeSend: function(){
                        Swal.fire({
                            title: 'La recargas se están realizando, mientras tanto no cierres esta ventana y procura tener una buena conexión a internet. Si tienes algún problema, comunícate con Desarrollo.',
                            html: 'Espera un poco, un poquito más...',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(data){
                        if(data.http_code == 200){
                            companyName = data.company.name;
                            Swal.fire({
                                icon: 'success',
                                title: 'Recargas a '+companyName+' realizadas, a continuación se mostrarán los resultados del proceso.',
                                timer: 4000,
                                showConfirmButton: false
                            });

                            records = data.records;

                            records.forEach(function(e){
                                if(e.statusCode == 200){
                                    msisdn = "<span class='label label-success'>"+e.msisdn+"</span>";
                                    effectiveDate = "<span class='label label-success'>"+e.effectiveDate+"</span>";
                                    orderID = "<span class='label label-success'>"+e.order_id+"</span>";
                                    statusCode = "<span class='label label-success'>"+e.statusCode+"</span>";
                                    description = "<span class='label label-success'>TODO EN ORDEN</span>";
                                    success+=1;
                                }else{
                                    msisdn = "<span class='label label-danger'>"+e.msisdn+"</span>";
                                    effectiveDate = "<span class='label label-danger'>ERROR!!</span>";
                                    orderID = "<span class='label label-danger'>ERROR!!</span>";
                                    statusCode = "<span class='label label-danger'>"+e.statusCode+"</span>";
                                    description = "<span class='label label-danger'>"+e.description+"</span>";
                                    errors+=1;
                                }

                                rows.push({
                                    msisdn, effectiveDate, orderID, statusCode, description
                                });
                            });

                            $('#titleResultadosBulk').html("Resultados de la ejecución por bloques de "+data.company.name+".");
                            

                            var datatableInit = function() {
                                var $table = $('#datatable-records-bulk');

                                $table.DataTable({
                                    dom: 'Bfrtip',
                                    buttons: [{
                                        extend: 'excel',
                                        header: true,
                                        title: 'Recharges-Bulk-'+companyName,
                                        exportOptions : {
                                            columns: [ 0,1,2,3,4],
                                        }
                                    }],
                                    destroy: true,
                                    data: rows,
                                    columns: [
                                        {title: "MSISDN",data:"msisdn"},
                                        {title: "Status Code",data:"statusCode"},
                                        {title: "Order ID",data:"orderID"},
                                        {title: "Effective Date",data:"effectiveDate"},
                                        {title: "Descripción",data:"description"}
                                    ],
                                });

                            };

                            $(function() {
                                datatableInit();
                            });

                            $('#successTag').html("Exitosos: "+success);
                            $('#errorsTag').html("Erróneos: "+errors);
                            $('#packTag').html("Paquete elegido: "+offerName);
                            $('#modalPortabilidades').modal('hide');
                            $('#modalResultadosBulk').modal('show');
                        }
                    }
                });
                
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Operación cancelada',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        })
    })
</script>

@endsection