}@extends('layouts.octopus')
@section('content')
@if(session('msg'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss = "alert" aria-hidden= "true">x</button>
        <h4 class="alert-heading">Oooops!</h4>
        <p>{{session('msg')}}</p>
    </div>
@endif
<div class="panel-body">
    <form action="{{route('facturacion.store')}}" method="POST" id="form-xml" enctype="multipart/form-data">
        <header class="panel-heading">
            <h2 class="panel-title">Agregar XML</h2>
        </header>
        
        {{csrf_field() }}
        <label for="Foto">Seleccione un archivo</label>
        <br>
        <input type="file" name="xml" id="xml" accept=".xml">
        <br>
        <div class="checkbox">
            <label class="control-label ml-sm">
                <input type="checkbox" id="typeInvoiceCheck">
                Público en General
            </label>
        </div>
        
        <input type="hidden" id="payment" name="payment" value="{{$payment}}">
        <input type="hidden" id="type" name="type" value="{{$type}}">
        <input type="hidden" id="typeInvoice" name="typeInvoice" value="0">
        <input type="button" id="addXML" value="agregar" class="btn btn-primary" disabled>
    </form>
<br>
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Facturas</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead>
                <tr>
                    <th class="text-left">UUID</th>
                    <th class="text-left">RFC Emisor</th>
                    <th class="text-left">Nombre Emisor</th>
                    <th class="text-left">RFC Receptor</th>
                    <th class="text-left">Nombre Receptor</th>
                    <th class="text-left">Opción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $data)
                <tr>
                    <td class="text-left">{{$data->id}}</td>
                    <td class="text-left">{{$data->rfc_emisor}}</td>
                    <td class="text-left">{{$data->name_emisor}}</td>
                    <td class="text-left">{{$data->rfc_recptor}}</td>
                    <td class="text-left">{{$data->name_recptor}}</td>
                    <td class="text-left">
                        <button class="btn btn-success invoice-view" data-uuid="{{$data->id}}">Asignar Pago</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
</div>
<script>
$('.invoice-view').click(function(){
    let payment = document.getElementById('payment').value;
    let type = document.getElementById('type').value;
    let uuid = $(this).attr('data-uuid');
    let token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ route('invoiceJoin.post')}}",
        method: 'POST',
        data:{_token:token, payment:payment, type:type, uuid:uuid },
        success: function(response){
            if(response == 1){
                $('#'+attrID).addClass('d-none');
                new PNotify({
                    title: 'Hecho.',
                    text: "Ok",
                    type: 'success',
                    icon: 'fa fa-home'
                });
            }
        }
    });
})

//evento para check
$('#typeInvoiceCheck').click(function(){
    if($(this).prop('checked')){
        $('#typeInvoice').val(1);
    }else{
        $('#typeInvoice').val(0);
    }
});

//valida el tipo de archivo
$('#xml').change(function(){
    let archivo = document.getElementById('xml').value;

    let extension = archivo.substring(archivo.lastIndexOf('.'),archivo.length);
  
    if(document.getElementById('xml').getAttribute('accept').split(',').indexOf(extension) < 0) {
        // alert('Archivo inválido. No se permite la extensión ' + extension);
        Swal.fire({
            icon: 'error',
            title: 'Archivo no permitido o no seleccionado.',
            text: 'La extensión requerida es .xml',
            showConfirmButton: false,
            timer: 2000
        });
        $('#addXML').attr('disabled',true);
    }else{
        $('#addXML').attr('disabled',false);
    }
});

//muestra alerta para asegurar el archivo
$('#addXML').click(function(){
    Swal.fire({
        title: '¿Está seguro de cargar esta factura?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        customClass: {
            confirmButton: 'btn btn-success mr-md',
            cancelButton: 'btn btn-danger '
        },
        buttonsStyling: false,
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form-xml').submit();
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            Swal.fire({
                icon: 'error',
                title: 'Operación cancelada',
                text: 'No se registro ningún pago.',
                showConfirmButton: false,
                timer: 1000
            })
        }
    })
    
});
</script>
@endsection