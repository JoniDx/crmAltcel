@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Pre Registro</h2>
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

<section class="panle">
    <div class="row">
        <div class="col-lg-12 ">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Cargar un archivo CSV</h2>
                </header>
                <div class="container">
                    <div class="col-md-3"  style=" margin: 2rem 0; display: flex; flex-direction: column; gap: 1rem;">
                        <span class="btn btn-default btn-file">
                            <span class="fileupload-new">Selecciona un archivo</span>
                            <input type="file" accept=".csv" id="csvPreRegistro">
                        </span>
                        <button class="btn btn-primary" id="importPreRegistro">Cargar Archivo</button>
                    </div>
                    <div class="col-md-6 "  style=" margin: 2rem 0; display: flex; flex-direction: column;">
                        <span> Ejemplo de archivo a cargar, se requiere el MSISDN y el offerID</span>
                        <table class="table table-bordered table-striped " style="margin-top: 2rem;" id="">                
                            <tbody id="proyection">       
                                <tr>
                                    <td>8952140062009768214F</td>
                                    <td>1779977001</td>
                                </tr>
                                <tr>
                                    <td>8952140061756577034F</td>
                                    <td>1779977001</td>
                                </tr>
                                <tr>
                                    <td>8952140061756576176F</td>
                                    <td>1779977001</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
    $('#importPreRegistro').click(function(){
        let tstart = `<table class="table table-bordered table-striped mb-none" id="myTable3">
                        <thead style="cursor: pointer;">
                            <tr>
                                <th class="text-center">MSISDN</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>`;
        let tend = `</tbody></table>`;
        
        let getCSV = $('#csvPreRegistro').val();
        //let file_data = document.getElementById('csvPreRegistro');
        let file_data = $('#csvPreRegistro').prop('files')[0];
        let form_data = new FormData();     
        form_data.append('file', file_data);
        form_data.append('_token', "{{csrf_token()}}");
        $.ajax({
            url:"{{route('sendPreRegistro')}}",
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            beforeSend: function(){
                Swal.fire({
                    title: 'En proceso',
                    html: "Pre Registrando los dato espere un momento.",
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(data){
                data = JSON.parse(data)                
                console.log(data);
                let table_data = "";
                if (data.error == "") {
                    console.log(data.response);
                    let arreglo_msisdn = data.response
                    if (arreglo_msisdn.length > 0) {
                        arreglo_msisdn.forEach(e => {
                            table_data+=`
                                            <tr>
                                                <td class="text-center">${e.MSISDN}</td>
                                                <td class="text-center">${e.status}</td>
                                            </tr>
                                        `;
                        });
                        Swal.fire({
                            title: 'Estos son los registros que fallaron.',
                            html: tstart+table_data+tend
                        });
                    }else{
                        Swal.fire({
                            icon: 'success',
                            title: 'Pre registro completado.',
                            showConfirmButton: false
                        });
                    }
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops!',
                        text: data.error
                    });  
                }
            },
            error: function(data){    
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops!',
                    text: "Error inesperado, consulte con Desarrollo"
                });      
            }                
        });
    });

</script>

@endsection