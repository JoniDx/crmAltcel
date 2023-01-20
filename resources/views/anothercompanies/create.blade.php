@extends('layouts.octopus')
@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<header class="page-header">
    <h2>Carga de Posibles Clientes</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><a href="{{ route('rates.index')}}"><span>Ver</span></a></li>
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

                <h2 class="panel-title">Carga Masiva</h2>
            </header>
            
            <div class="panel-body">
                <form class="form-horizontal form-bordered" method="POST" action="{{route('anothercompany.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-4"  >
                                    <span class="btn btn-default btn-file">
                                        <span class="fileupload-new">Selecciona un archivo</span>
                                        <input type="file" id="clientsFile" name="clientsFile">
                                    </span>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-success" style="margin-top: 1rem;" id="chargeFile">Guardar</button>
                        </div>
                    </div>

                </form>
            </div>
        </section>

    </div>
</div>

<script>
// $('#chargeFile').click(function(){
//     let firstCSV = $('#clientsFile').val();


//     if(firstCSV.length == 0 || /^\s+$/.test(firstCSV)){
//         Swal.fire({
//             icon: 'error',
//             title: 'Oops...',
//             text: 'Por favor cargue un fichero con extensión CSV.',
//             showConfirmButton: false,
//             timer: 2000
//         });
//         return false;

//         console.log('CSV')
//     }

//     let file_data = $('#clientsFile').prop('files')[0];
//     let form_data = new FormData();
//     form_data.append('file', file_data);
//     form_data.append('_token', '{{csrf_token()}}');
//     $.ajax({
//         url: "{{route('anothercompany.store')}}",
//         dataType: 'text',
//         cache: false,
//         contentType: false,
//         processData: false,
//         data: form_data,
//         type:'POST',
//         beforeSend: function(){
//             Swal.fire({
//                 title: 'Obteniendo datos de la operadora.',
//                 html: 'Espera un poco, un poquito más...',
//                 didOpen: () => {
//                     Swal.showLoading();
//                 }
//             });
//         },
//         success: function(response){
//             Swal.close();
//            console.log(response,'RESPONSE');
//             // if (response.code == 1) {
//             //     Swal.fire({
//             //         icon: 'success',
//             //         title: 'Well done!!',
//             //         text: response.message,
//             //         showConfirmButton: false,
//             //         timer: 1000
//             //     });
//             // }
//         // x = JSON.parse(response)
//         // let body = ''
//         // x.forEach(data =>
//         //     body+= "<tr>"+"<td>"+data.msisdnPorted+"</td>"+"<td>"+data.icc+"</td>"+"<td>"+data.msisdnTransitory+"</td>"+"<td>"+data.date+"</td>"+"<td>"+data.nip+"</td>"+"<td>"+data.rate+"</td>"+"<td>"+data.client+"</td>"+"<td>"+data.who_did_it+"</td>"+"<td>"+data.who_attended+"</td>"+"</tr>"
//         // );
//         // $('#body-complate').html(body)

//         }
//     })
// })
</script>
@endsection