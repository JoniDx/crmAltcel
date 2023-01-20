@extends('layouts.octopus')
@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<header class="page-header">
    <h2>Ofertas Altán</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><a href="{{ route('offers.create')}}"><span>Crear</span></a></li>
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
    <strong>Well done!</strong> {{session('error')}}
</div>
@endif

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Ofertas</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead >
                <tr>
                <th scope="col">OfferID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Producto Altan</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio Venta</th>
                <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $offers as $offer )
            <tr style="cursor: pointer;" class="offer-table" data-id="{{$offer->id}}">
                <td>{{ $offer->offerID }}</td>
                <td>{{ $offer->name }}</td>
                <td>{{ $offer->product_altan }}</td>
                <td class="text-bold">{{ $offer->product.'/'.$offer->type }}</td>
                <td>{{ '$'.number_format($offer->price_sale,2) }}</td>
                <td>
                    <button type="button" class="mb-xs mt-xs mr-xs btn btn-info update-offer" data-offer="{{ $offer->id }}" data-toggle="modal" ><i class="fa fa-edit"></i></button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>
<div class="modal fade" id="modalInfoOffer" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalTitle"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-bordered" action="{{url('offers/')}}" method="POST" id="form-update-offer">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-md-12">
                                <h4 class="text-success text-bold">Oferta Primaria</h4>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <div class="col-md-12">
                                    <section class="form-group-vertical">
                                        <div class="input-group input-group-icon">
                                            <label for="offerID">Offer ID</label>
                                            <input class="form-control" type="text" placeholder="Offer ID" id="offerID" name="offerID">
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <label for="name">Nombre Altan</label>
                                            <input class="form-control" type="text" placeholder="Nombre" id="name" name="name">
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <label for="product_altan">Nombre Altcel</label>
                                            <input class="form-control" type="text" placeholder="Producto Altan" id="product_altan" name="product_altan">
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="col-md-12">
                                    <section class="form-group-vertical">
                                        <div class="input-group input-group-icon">
                                            <label for="price_s_iva">Costo s/IVA</label>
                                            <input class="form-control" type="text" placeholder="Costo s/IVA" id="price_s_iva" name="price_s_iva" autocomplete="off">
                                        </div>
                                        <div class="input-group input-group-icon">
                                        <label for="price_c_iva">Costo c/IVA</label>
                                            <input class="form-control" type="text" placeholder="Costo c/IVA" id="price_c_iva" name="price_c_iva" autocomplete="off">
                                        </div>
                                        <div class="input-group input-group-icon">
                                        <label for="price_sale">Precio Venta</label>
                                            <input class="form-control" type="text" placeholder="Precio Venta" id="price_sale" name="price_sale" autocomplete="off">
                                        </div>
                                    </section>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <h4 class="text-dark text-bold">Oferta Secundaria</h4>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="col-md-12">
                                    <section class="form-group-vertical">
                                        <div class="input-group input-group-icon">
                                            <label for="offerID_second">Offer ID</label>
                                            <input class="form-control" type="text" placeholder="Offer ID" id="offerID_second" name="offerID_second">
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <label for="name_second">Nombre Altan</label>
                                            <input class="form-control" type="text" placeholder="Nombre" id="name_second" name="name_second">
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <label for="product_altan_second">Nombre Altcel</label>
                                            <input class="form-control" type="text" placeholder="Producto Altan" id="product_altan_second" name="product_altan_second">
                                        </div>
                                    </section>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 row">    
                            <div class="col-md-3">
                                <label for="product">Producto</label>
                                <select id="product" name="product" class="form-control form-control-sm">
                                
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="type">Tipo</label>
                                <select id="type" name="type" class="form-control form-control-sm">
                                
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="recurrency" class="form-label">Recurrencia</label>
                                <input type="text" class="form-control" id="recurrency" name="recurrency" required>
                            </div>
                            <div class="col-md-3" id="offerID_right-content">
                                <label for="offerID_right">Oferta Padre</label>
                                <select id="offerID_right" name="offerID_excedente" class="form-control form-control-sm">
                                    <option value="0">Sin opciones</option>
                                </select>
                            </div>
                            <div class="col-md-12" style="margin-top: 1rem;">
                                <textarea name="description" id="description"></textarea>
                            </div>
                            <script>
                                    CKEDITOR.replace('description');
                            </script>
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

(function(){

/**
 * Ajuste decimal de un número.
 *
 * @param	{String}	type	El tipo de ajuste.
 * @param	{Number}	value	El número.
 * @param	{Integer}	exp		El exponente(el logaritmo en base 10 del ajuste).
 * @returns	{Number}			El valor ajustado.
 */
function decimalAdjust(type, value, exp) {
    // Si el exp es indefinido o cero...
    if (typeof exp === 'undefined' || +exp === 0) {
        return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // Si el valor no es un número o el exp no es un entero...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
        return NaN;
    }
    // Cambio
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Volver a cambiar
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
}

// Redondeo decimal
if (!Math.round10) {
    Math.round10 = function(value, exp) {
        return decimalAdjust('round', value, exp);
    };
}


})();


$('#price_s_iva, #price_c_iva, #price_sale, #price_s_iva_excedente, #price_c_iva_excedente, #price_sale_excedente, #recurrency').on('input', function () {
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
$('#price_s_iva').keyup(function(){
    let valor = $(this).val();
    let iva = valor*1.16;
    iva = Math.round10(iva, -1);
    $('#price_c_iva').val(iva);
});

$('#price_s_iva_excedente').keyup(function(){
    let valor = $(this).val();
    let iva = valor*1.16;
    iva = Math.round10(iva, -1);
    $('#price_c_iva_excedente').val(iva);
});

$('#product').change(function(){
    let product = $(this).val();
    let options = "<option selected value='0'>Elige una opción...</option>"
    $.ajax({
        url: "{{route('getAllOffersByType.get')}}",
        data: {product: product},
        success: function(response){
            // console.log(response);
            // let offers = response.offers;
            jQuery.each(response,function(i,val){
                options+="<option value='"+val.offerID+"'>"+val.offerID+' - '+val.name+"</option>"
            })
            $('#offerID_right').html(options);
        }
    });
});

$('#type').change(function(){
    let val = $(this).val();
    let product = $('#product').val();
    let options = '<option selected value="0">Elige una opción...</option>';
    if(val == 'normal'){
        $('#offerID_right-content').addClass('d-none');
    }else if(val == 'excedente'){
        $.ajax({
            url: "{{route('getAllOffers.get')}}",
            success: function(response){
                response.forEach(function(element){
                    if(element.product == product && element.type == 'normal'){
                        options+="<option value='"+element.offerID+"'>"+element.offerID+" - "+element.name+"</option>";
                    }
                    
                });
                $('#offerID_right').html(options);
            }
        });
        $('#offerID_right-content').removeClass('d-none');
    }
});

    $('.update-offer').click(function(){
        let id = $(this).attr('data-offer');
        let action = '';
        let options = '';
        let offerID_right = '';
        let product = '';
        $.ajax({
            url:"{{route('get-offer.get')}}",
            data: {id:id},
            success: function(data){
                // console.log(data);
                // $('#id_user_update').val(id)
                $('#myModalTitle').html('Oferta <strong>'+data.name+'</strong>');
                $('#offerID').val(data.offerID);
                $('#name').val(data.name);
                $('#product_altan').val(data.product_altan);
                $('#price_s_iva').val(data.price_s_iva);
                $('#price_c_iva').val(data.price_c_iva);
                $('#price_sale').val(data.price_sale);

                $('#offerID_second').val(data.offerID_second);
                $('#name_second').val(data.name_second);
                $('#product_altan_second').val(data.product_altan_second);
                offerID_right = data.offerID_excedente;
                product = data.product;

                if(data.type == 'excedente'){
                    $.ajax({
                        url: "{{route('getAllOffers.get')}}",
                        success: function(response){
                            response.forEach(function(element){
                                if(element.offerID == offerID_right){
                                    options+="<option selected value='"+element.offerID+"'>"+element.offerID+" - "+element.name+"</option>";
                                }else if(element.product == product && element.type == 'normal'){
                                    options+="<option value='"+element.offerID+"'>"+element.offerID+" - "+element.name+"</option>";
                                }
                                
                            });
                            $('#offerID_right').html(options);
                        }
                    });
                }

                if(data.product == 'MIFI'){
                    $('#product').html(
                        '<option selected value="'+data.product+'">'+data.product+'</option>'+
                        '<option value="MOV">MOV</option>'+
                        '<option value="HBB">HBB</option>');
                }else if(data.product == 'HBB'){
                    $('#product').html(
                        '<option selected value="'+data.product+'">'+data.product+'</option>'+
                        '<option value="MOV">MOV</option>'+
                        '<option value="MIFI">MIFI</option>');
                }else if(data.product == 'MOV'){
                    $('#product').html(
                        '<option selected value="'+data.product+'">'+data.product+'</option>'+
                        '<option value="MIFI">MIFI</option>'+
                        '<option value="HBB">HBB</option>');
                }

                if(data.type == 'normal'){
                    $('#type').html(
                        '<option selected value="'+data.type+'">'+data.type+'</option>'+
                        '<option value="excedente">excedente</option>'
                    );
                    $('#offerID_right-content').addClass('d-none');
                }else if(data.type == 'excedente'){
                    $('#type').html(
                        '<option selected value="'+data.type+'">'+data.type+'</option>'+
                        '<option value="normal">normal</option>'
                    );
                    $('#offerID_right-content').removeClass('d-none');
                }

                
                $('#recurrency').val(data.recurrency);
                CKEDITOR.instances['description'].setData(data.description);
                
                var url = "{{ route('offers.update', ['offer' => 'temp']) }}";
                url = url.replace('temp', data.id);
                $('#form-update-offer').attr('action', url);
                $('#modalInfoOffer').modal('show');
            }
        }); 
        
    });

    $('#add_update').click(function(){
        let type = $('#type').val();
        let offerID_right = $('#offerID_right').val();
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
                $("#form-update-offer").submit();
                 
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