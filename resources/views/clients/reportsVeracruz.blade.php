@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>reportes de Consumos</h2>
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

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Funciones</h2>
            </header>

            <div class="panel-body">
                <form class="form-horizontal form-bordered">
                    @csrf
                    <div class="form-group" style="padding-right: 1rem; padding-left: 1rem;">
                        <div class="col md-12">
                            <div class="row">
                                <div class="radio col-md-2">
                                    <label for="datosGeneral">
                                        <input class="option" type="radio" data-type="datosgeneral" name="optionsRadios" id="datosGeneral" value="Datos General">
                                        Consumos de Datos General
                                    </label>
                                </div>
                                <div class="radio col-md-2">
                                    <label for="smsGeneral">
                                        <input class="option" type="radio" data-type="smsGeneral" name="optionsRadios" id="smsGeneral" value="SMS General">
                                        Consumos de SMS General
                                    </label>
                                </div>
                                <div class="radio col-md-2">
                                    <label for="minGeneral">
                                        <input class="option" type="radio" data-type="minGeneral" name="optionsRadios" id="minGeneral" value="Minutos General">
                                        Consumos de Minutos General
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!--General-->

        {{-- <div class="col-md-12 d-none" id="general"> --}}
            {{-- <section class="panel form-wizard"> --}}
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>
    
                    <h2 class="panel-title" id="textGeneral"></h2>
                </header>
                <div class="panel-body">
                    <form class="form-horizontal" novalidate="novalidate" method="GET" action="{{url('consumos-general-export-excel')}}">
                        <div class="tab-content">   
                            <div class="input-group mb-md col-md-4">
                                <label class="">Fecha</label>
                                <div class="input-daterange input-group" data-plugin-datepicker>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input autocomplete="off" type="text" class="form-control" id="start_dateG" name="start_dateG">
                                    <span class="input-group-addon">a</span>
                                    <input autocomplete="off" type="text" class="form-control" id="end_dateG" name="end_dateG">
                                </div>
                            </div>
                            <input type="hidden" id="type-general" name="type">
                            <button class="btn btn-success" type="button" id="btnGeneral"><li class="fa fa-arrow-circle-right"></li></button>
                        </div>
                        {{-- <div class="panel-body table-general"> --}}
                        <div class="panel-body">
                            <button class="btn btn-primary"><i class="fa fa-cloud-download"></i> Consumos</button>
                            <hr>
                            <div class="panel-body">
                                <table class="table table-bordered table-striped mb-none" id="myTable">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Fecha</th>
                                            <th class="text-left">MSISDN</th>
                                            <th class="text-left">Consumos</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cuerpo-table-general"></tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            

        {{-- </div> --}}

        <!--End General-->
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
    $('.option').click(function(){
        let valor = $(this).val();
        let type = $(this).attr('data-type');
        console.log(valor);
        if (valor == 'Datos General') {
            $('#textGeneral').html(valor)
            $('#type-general').val(type);
            $('#individual').addClass('d-none');
            $('#general').removeClass('d-none');
            $('.table-general').addClass('d-none');
            $('.table-individual').addClass('d-none');
        }else if (valor == 'SMS General') {
            $('#textGeneral').html(valor)
            $('#type-general').val(type);
            $('#individual').addClass('d-none');
            $('#general').removeClass('d-none');
            $('.table-general').addClass('d-none');
        }else if (valor == 'Minutos General') {
            $('#textGeneral').html(valor)
            $('#type-general').val(type);
            $('#individual').addClass('d-none');
            $('#general').removeClass('d-none');
            $('.table-general').addClass('d-none');
            $('.table-individual').addClass('d-none');
        }
    })

    $('#btnGeneral').click(function(){
        var table =  $('#myTable').DataTable();
        table.destroy();
        let contenido = '';
        let type = $('#type-general').val();
        let date_start = $('#start_dateG').val();
        let date_end = $('#end_dateG').val();
        console.log(type);
        console.log(date_start);
        console.log(date_end);
        $.ajax({
            url: "{{route('consumos')}}",
            method: 'GET',
            data:{type:type, date_start:date_start, date_end:date_end},
            beforeSend: function(){
                Swal.fire({
                    title: 'Extrayendo data...',
                    html: 'Espera un poco, un poquito más...',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success:function(response){
                $('#datatable-default').DataTable();
                Swal.close();
                let typeS = response[0];
                let data = response[1];
                if (typeS == 'general') {
                    $('.table-general').removeClass('d-none');
                        data.forEach(function(element){
                            
                            if(type == 'smsIndividual' || type == 'smsGeneral'){
                                contenido+="<tr><td>"+element.START_DATE+"</td><td>"+element.PRI_IDENTITY+"</td><td>"+element.consumos+" SMS</td></tr>"
                            }else if(type == 'datosIndividual' || type == 'datosgeneral' || 'datosAnual'){
                                contenido+="<tr><td>"+element.START_DATE+"</td><td>"+element.PRI_IDENTITY+"</td><td>"+parseFloat(element.consumos).toFixed(4)+" MB</td></tr>"
                            }else if(type == 'minIndividual' || type == 'minGeneral'){
                                contenido+="<tr><td>"+element.START_DATE+"</td><td>"+element.PRI_IDENTITY+"</td><td>"+parseFloat(element.consumos)/60+" Min</td></tr>"
                            }
                    });
                }
                $('#cuerpo-table-general').html(contenido);
                console.log(data);

                

                table = $('#myTable').DataTable({
                    order: false,
                    // dom: 'Bfrtip',
                    // buttons: [{
                    //     extend: 'excel',
                    //     header: true,
                    //     title: 'Tabla de planes',
                    //     exportOptions : {
                    //         columns: [ 0, 1, 2],
                    //     }
                    // }],
                });
            }
        })
    });
</script>
@endsection