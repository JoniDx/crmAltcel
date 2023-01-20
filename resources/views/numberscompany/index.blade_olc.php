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
                    <button class="btn btn-info btn-sm btnDetalles" data-company="{{$company['company_id']}}"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar Portabilidad">
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
            <div class="panel-body" >
                <table class="table table-bordered table-striped mb-none" id="myTable">
                    <thead style="cursor: pointer;">
                        <tr>
                            <th>Empresa</th>
                            <th>#Línea</th>
                            <th>Creado por:</th>
                            <th>Fecha de Creación:</th>
                        </tr>
                    </thead>
                    <tbody id="infoTarje"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                                            <option selected>-- SELECCIONE --</option>
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
        let card = '';

        $.ajax({
            url: "{{ route('allCompanyId')}}",
            data:{company_id},
            success: function(data){

                data.forEach(function(element){
                    // console.log(element);

                    card+="<tr><td>"+element.name+"</td><td>"+element.MSISDN+"</td><td>"+element.nombre+" "+element.lastname+"</td><td>"+element.created_at+"</td></tr>";
                });
                $('#infoTarje').html(card);
            }
        });

        $('#modalPortabilidades').modal('show');
    });
</script>

<script>
    $('#importNumbers').click(function(){
        let getCSV = $('#csvNumbers').val();
        // console.log(getCSV);

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

        let file_data = $('#csvNumbers').prop('files')[0];
        let form_data = new FormData();
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
                //    console.log(response);
                //    return false;
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
                            });
                            // window.location.reload();
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
</script>

@endsection