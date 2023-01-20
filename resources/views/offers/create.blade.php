@extends('layouts.octopus')
@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<header class="page-header">
    <h2>Creación de Ofertas Altán</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><a href="{{ route('offers.index')}}"><span>Ver</span></a></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>
<div class="alert alert-success d-none" id="alert-positive">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>¡Éxito!</strong> Oferta añadida, <a class="alert-link" href="{{ route('offers.index')}}">click aquí para ver</a>.
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Datos</h2>
            </header>
            <div class="panel-body">
                <div class="col-md-2 col-md-offset-10">
                    <button type="button" class="mb-xs mt-xs mr-xs btn btn-info btn-block" data-toggle="modal" data-target="#surplusModal">Excedente <li class="fa fa-plus-circle"></li></button>
                </div>
                <form class="form-horizontal form-bordered" method="get">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-md-12">
                                <h4>Oferta Primaria</h4>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <div class="col-md-12">
                                    <section class="form-group-vertical">
                                        <div class="input-group input-group-icon">
                                            <input class="form-control" type="text" placeholder="Offer ID" id="offerID" name="offerID">
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <input class="form-control" type="text" placeholder="Nombre" id="name" name="name">
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <input class="form-control" type="text" placeholder="Producto Altan" id="product_altan" name="product_altan">
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="col-md-12">
                                    <section class="form-group-vertical">
                                        <div class="input-group input-group-icon">
                                            <input class="form-control" type="text" placeholder="Costo s/IVA" id="price_s_iva" name="price_s_iva" autocomplete="off">
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <input class="form-control" type="text" placeholder="Costo c/IVA" id="price_c_iva" name="price_c_iva" autocomplete="off">
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <input class="form-control" type="text" placeholder="Precio Venta" id="price_sale" name="price_sale" autocomplete="off">
                                        </div>
                                    </section>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <h4>Oferta Secundaria</h4>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="col-md-12">
                                    <section class="form-group-vertical">
                                        <div class="input-group input-group-icon">
                                            <input class="form-control" type="text" placeholder="Offer ID" id="offerID_second" name="offerID_second">
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <input class="form-control" type="text" placeholder="Nombre" id="name_second" name="name_second">
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <input class="form-control" type="text" placeholder="Producto Altan" id="product_altan_second" name="product_altan_second">
                                        </div>
                                    </section>
                                </div>
                            </div>
                            
                            <div class="row col-md-12">
                                <div class="col-md-2">
                                    <label for="product">Tipo Producto</label>
                                    <select id="product" class="form-control form-control-sm">
                                        <option selected value="0">Choose...</option>
                                        <option value="MOV">MOV</option>
                                        <option value="MIFI">MIFI</option>
                                        <option value="HBB">HBB</option>
                                    </select>
                                </div>
                               
                                <div class="col-md-2">
                                    <label for="recurrency">Recurrencia</label>
                                    <input type="text" class="form-control form-control-sm" id="recurrency" >
                                </div>
                                <div class="col-md-12" style="margin-top: 1rem;">
                                    <textarea name="description" id="description"></textarea>
                                </div>
                                <script>
                                        CKEDITOR.replace('description');
                                </script>

                                <input type="hidden" id="type" value="normal" >

                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success" style="margin-top: 1rem;" id="form-offer" data-type="normal">Guardar</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </section>

    </div>
</div>

<!-- Modal de Oferta Excedente -->
<div class="modal fade" id="surplusModal" tabindex="-1" aria-labelledby="surplusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Oferta Excedente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="display:flex; justify-content:center; margin-left: auto !important;">
                <form class="form-horizontal form-bordered" >
                    @csrf
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                            
                                <div class="col-md-12">
                                    <h4>Datos de la Oferta</h4>
                                </div>

                                <div class="form-group col-md-6">
                                    <div class="col-md-12">
                                        <section class="form-group-vertical">
                                            <div class="input-group input-group-icon">
                                                <input class="form-control" type="text" placeholder="Offer ID" id="offerID_excedente" name="offerID_excedente">
                                            </div>
                                            <div class="input-group input-group-icon">
                                                <input class="form-control" type="text" placeholder="Nombre" id="name_excedente" name="name_excedente">
                                            </div>
                                            <div class="input-group input-group-icon">
                                                <input class="form-control" type="text" placeholder="Producto Altan" id="product_altan_excedente" name="product_altan_excedente">
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-md-12">
                                        <section class="form-group-vertical">
                                            <div class="input-group input-group-icon">
                                                <input class="form-control" type="text" placeholder="Costo s/IVA" id="price_s_iva_excedente" name="price_s_iva_excedente" autocomplete="off">
                                            </div>
                                            <div class="input-group input-group-icon">
                                                <input class="form-control" type="text" placeholder="Costo c/IVA" id="price_c_iva_excedente" name="price_c_iva_excedente" autocomplete="off">
                                            </div>
                                            <div class="input-group input-group-icon">
                                                <input class="form-control" type="text" placeholder="Precio Venta" id="price_sale_excedente" name="price_sale_excedente" autocomplete="off">
                                            </div>
                                        </section>
                                    </div>
                                </div>

                                <div class="row col-md-12">
                                    <div class="col-md-3">
                                        <label for="product_excedente">Tipo Producto</label>
                                        <select id="product_excedente" class="form-control form-control-sm">
                                            <option selected value="0">Choose...</option>
                                            <option value="MOV">MOV</option>
                                            <option value="MIFI">MIFI</option>
                                            <option value="HBB">HBB</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="offerID_right">Oferta Padre</label>
                                        <select id="offerID_right" class="form-control form-control-sm">
                                            <option value="0">Sin opciones</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin-top: 1rem;">
                                    <button type="button" class="btn btn-primary" id="form-offer-excedente" data-type="excedente">Guardar</button>
                                    <!-- <button type="button" class="btn btn-success" id="date-pay">Date Pay</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
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

$('#product_excedente').change(function(){
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

    $('#form-offer, #form-offer-excedente').click(function(){
        let type = $(this).attr('data-type');
        
        let offerID = '';
        let name = '';
        let product_altan = '';
        // let action = $('#action').val();
        let product = $('#product').val();
        let price_s_iva = '';
        let price_c_iva = '';
        let price_sale = '';
        let recurrency = '';

        let offerID_second = $('#offerID_second').val();
        let name_second = $('#name_second').val();
        let product_altan_second = $('#product_altan_second').val();

        let description = CKEDITOR.instances['description'].getData();
        let token = $('meta[name="csrf-token"]').attr('content');
        let data;

        if(type == 'normal'){
            offerID = $('#offerID').val();
            name = $('#name').val();
            product_altan = $('#product_altan').val();
            product = $('#product').val();
            price_s_iva = $('#price_s_iva').val();
            price_c_iva = $('#price_c_iva').val();
            price_sale = $('#price_sale').val();
            recurrency = $('#recurrency').val();

            data = {
                    _token:token,
                    offerID:offerID,
                    name:name,
                    product_altan:product_altan,
                    product:product,
                    price_s_iva:price_s_iva,
                    price_c_iva:price_c_iva,
                    price_sale:price_sale,
                    recurrency:recurrency,
                    description:description,
                    offerID_second:offerID_second,
                    name_second:name_second,
                    product_altan_second:product_altan_second,
                    type:type
                };
        }else if(type == 'excedente'){
            offerID = $('#offerID_excedente').val();
            offerRight = $('#offerID_right').val();
            name = $('#name_excedente').val();
            product_altan = $('#product_altan_excedente').val();
            product = $('#product_excedente').val();
            price_s_iva = $('#price_s_iva_excedente').val();
            price_c_iva = $('#price_c_iva_excedente').val();
            price_sale = $('#price_sale_excedente').val();
            recurrency = 0;

            data = {
                    _token:token,
                    offerID:offerID,
                    name:name,
                    product_altan:product_altan,
                    product:product,
                    price_s_iva:price_s_iva,
                    price_c_iva:price_c_iva,
                    price_sale:price_sale,
                    recurrency:recurrency,
                    offerID_excedente:'0000000',
                    offerID_excedente:offerRight,
                    type:type
                };
        }

        // console.log(data);
        // return false;

        $.ajax({
                url:"{{route('offers.store')}}",
                method: "POST",
                data: data,
                success: function(data){
                    if(data == 1){
                        $('#alert-positive').removeClass('d-none');
                        if(type == 'normal'){
                            $('#offerID').val('');
                            $('#name').val('');
                            $('#product_altan').val('');
                            // $('#action').val('');
                            $('#product').val('');
                            $('#price_s_iva').val('');
                            $('#price_c_iva').val('');
                            $('#price_sale').val('');
                            $('#recurrency').val('');
                            CKEDITOR.instances['description'].setData('');
                        }else if(type == 'excedente'){
                            $('#offerID_excedente').val('');
                            $('#name_excedente').val('');
                            $('#product_altan_excedente').val('');
                            // $('#action_excedente').val('');
                            $('#product_excedente').val('');
                            $('#price_s_iva_excedente').val('');
                            $('#price_c_iva_excedente').val('');
                            $('#price_sale_excedente').val('');
                        }
                        
                    }
                }
            });  
    });

    $('#close-alert-positive').click(function(){
        $('#alert-positive').addClass("d-none")
    });
</script>
@endsection