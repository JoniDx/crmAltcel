@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Políticas de Cobro</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>
@if(session('message'))
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Well done!</strong> {{session('message')}}
</div>
@endif
@if(session('error'))
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Ooops!</strong> {{session('error')}}
</div>
@endif
<div class="col-md-12">
    <div class="tabs tabs-success">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#home" data-toggle="tab"><i class="fa fa-star"></i> Home</a>
            </li>
            <li>
                <a href="#paquete" data-toggle="tab">Crear</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="home" class="tab-pane active">
                <h3>Políticas</h3>
                    <table class="table table-bordered table-striped mb-none" id="datatable-default2">
                        <thead >
                            <tr>
                            <th scope="col">Descripción</th>
                            <th scope="col">Porcentaje</th>
                            <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($politics as $politic)
                        <tr>
                            <td>{{$politic->description}}</td>
                            <td>{{$politic->porcent}}%</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm update-politic" data-politic="{{$politic->id}}"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-danger btn-sm delete-politic" data-politic="{{$politic->id}}"><li class="fa fa-trash-o"></li></button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                
            </div>
            <div id="paquete" class="tab-pane">
                <h3>Creación de Política</h3>
                <form class="form-horizontal form-bordered">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="description">Descripción</label>
                                    <input type="text" class="form-control" id="description">
                                </div>
                                <div class="col-md-5">
                                    <label for="porcentaje">Porcentaje</label>
                                    <input type="text" class="form-control" id="porcentaje">
                                </div>

                                <div class="col-md-12" style="margin-top: 1rem;">
                                    <button type="button" class="btn btn-primary mb-2" id="add_politic">Añadir</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalInfoPolitic" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalTitle"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-bordered" action="" method="POST" id="form-update-politic">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <h3>Datos</h3>
                        <div class="form-group col-md-12">
                            <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label for="porcent" class="form-label">Porcentaje</label>
                                    <input type="text" class="form-control" id="porcent" name="porcent" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Descripción</label>
                                    <input type="text" class="form-control" id="description_update" name="description" required>
                                </div>
                                <!-- <input type="hidden" name="id" id="id_user_update"> -->
                            </div>
                        </div>
                    </div>              

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="add_update">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#porcentaje, #porcent').on('input', function () {
    this.value = this.value.replace(/[^0-9.]/g, '');
    });
    
    $('#add_politic').click(function() {
        let description = $('#description').val();
        let porcentaje = $('#porcentaje').val();
        let token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{route('politicRate.create')}}",
            method: 'POST',
            data: {description: description,porcent: porcentaje,_token:token},
            success: function(data){
                if(data == 1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Todo ready!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }else if(data == 0){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: e,
                    });
                }
            }
        });
    });

    $('.delete-politic').click(function(){
        let politic_id = $(this).attr('data-politic');
        console.log(politic_id);
        var url = "{{ route('politic.delete', ['politic_id' => 'temp']) }}";
        url = url.replace('temp', politic_id);
        
        Swal.fire({
            title: '¿Está seguro de eliminar esta política?',
            text: "Le sugiero corroborar nuevamente los datos antes de guardarlos.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SÍ, ESTOY SEGURO.'
            }).then((result) => {
            if (result.isConfirmed) {
                 let timerInterval;
                Swal.fire({
                    title: 'Espera un momento...',
                    html: 'Estamos actualizando los registros.',
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                        const content = Swal.getHtmlContainer()
                        if (content) {
                            const b = content.querySelector('b')
                            if (b) {
                            b.textContent = Swal.getTimerLeft()
                            }
                        }
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = url;
                    }
                })
                
            }
        })
        // console.log(url);
    });

    $('.update-politic').click(function(){
        let politic_id = $(this).attr('data-politic');
        let rate_name = $(this).attr('data-rate');
        let product_name = $(this).attr('data-product');

        var url = "{{ route('politic.edit', ['politic_id' => 'temp']) }}";
        url = url.replace('temp', politic_id);

        $.ajax({
            url:url,
            success: function(data){
                $('#myModalTitle').html('Política <strong>'+rate_name+'/'+product_name+'</strong>');
                $('#porcent').val(data.porcent);
                $('#description_update').val(data.description);

                var url = "{{ route('politic.update', ['politic' => 'temp']) }}";
                url = url.replace('temp', politic_id);
                $('#form-update-politic').attr('action', url);
                $('#modalInfoPolitic').modal('show');
            }
        }); 
    });

    $('#add_update').click(function(){
        let porcent = $('#porcent').val();
        let description = $('#description_update').val();

        if(porcent.length == 0 || /^\s+$/.test(porcent)){
            Swal.fire({
                icon: 'error',
                title: 'Complete todos los campos, por favor.',
                text: 'Porcentaje no puede estar vacío.',
                showConfirmButton: false,
                timer: 1500
            })
            return false;
        }

        if(description.length == 0 || /^\s+$/.test(description)){
            Swal.fire({
                icon: 'error',
                title: 'Complete todos los campos, por favor.',
                text: 'Descripción no puede estar vacío.',
                showConfirmButton: false,
                timer: 1500
            })
            return false;
        }

        Swal.fire({
            title: '¿Está seguro de guardar estos cambios?',
            text: "Le sugiero corroborar nuevamente los datos antes de guardarlos.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SÍ, ESTOY SEGURO.'
            }).then((result) => {
            if (result.isConfirmed) {
                $("#form-update-politic").submit();
                 
                Swal.fire({
                    icon: 'success',
                    title: 'Guardando cambios...',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        })
    });
</script>
@endsection