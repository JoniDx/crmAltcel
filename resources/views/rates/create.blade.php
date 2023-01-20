@extends('layouts.octopus')
@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<header class="page-header">
    <h2>Creación de Planes Altán</h2>
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
@if(session('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="alert-heading">Well done!!</h4>
        <p>{{session('success')}}</p>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger" >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4 class="alert-heading">Upps!!</h4>
        <p>{{session('error')}}</p>
    </div>
@endif
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
                <form class="form-horizontal form-bordered" method="post" action="{{route('rates.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control form-control-sm" id="name" name="name" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="alta_offer_id">Oferta</label>
                                    <select id="alta_offer_id" name="alta_offer_id" class="form-control form-control-sm" required>
                                        <option selected value="0">Choose...</option>
                                        @foreach($offers as $offer)
                                        <option value="{{$offer->id}}">{{$offer->product.' - '.$offer->name.' - '.$offer->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="type">Tipo</label>
                                    <select id="type" name="type" class="form-control form-control-sm" required>
                                        <option selected value="publico">Público</option>
                                        <option value="interno">Interno</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="name">Precio Inicial</label>
                                    <input type="text" class="form-control form-control-sm" id="price" name="price" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="name">Precio Subsecuente</label>
                                    <input type="text" class="form-control form-control-sm" id="price_subsequent" name="price_subsequent" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="name">Precio de Lista</label>
                                    <input type="text" class="form-control form-control-sm" id="price_list" name="price_list" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="name">Recurrencia</label>
                                    <input type="text" class="form-control form-control-sm" id="recurrency" name="recurrency" required>
                                </div>
                                
                                <div class="col-md-3 mt-xl">
                                    <div class="checkbox">
                                        <label class="control-label">
                                            <input type="checkbox" id="pack_altcel">
                                            Altcel
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 d-none" id="pack-altcel-content">
                                    <label for="name">Paquete Altcel</label>
                                    <input type="text" class="form-control form-control-sm" id="altcel_pack_id" name="altcel_pack_id">
                                </div>
                                <!-- <div class="col-md-3 ">
                                    <input type="file" class="form-control custom-file-input" id="image" name="image" required>
                                    <label class="custom-file-label" for="image">Elegir</label>
                                </div> -->
                                <!-- <div class="col-md-12 mt-lg">
                                    <div class="col-md-6">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <label for="image">Imagen</label>
                                            <div class="input-append">
                                                <div class="uneditable-input">
                                                    <i class="fa fa-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-default btn-file">
                                                    <span class="fileupload-exists">Change</span>
                                                    <span class="fileupload-new">Select file</span>
                                                    <input type="file" id="image" name="image">
                                                </span>
                                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" >
                                        <img src="" id="img1" style="max-width: 200px;">
                                    </div>
                                </div> -->

                                <div class="col-md-3 mt-xl">
                                    <div class="checkbox">
                                        <label class="control-label">
                                            <input type="checkbox" id="promo_check">
                                            Promoción
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3 d-none content-promo">
                                    <label for="name">Precio Dispositivo</label>
                                    <input type="text" class="form-control form-control-sm" id="device_price" name="device_price">
                                </div>

                                <div class="col-md-3 d-none content-promo">
                                    <label for="promotion_id">Promociones</label>
                                    <select id="promotion_id" name="promotion_id" class="form-control form-control-sm" required>
                                        <option selected value="0">Choose...</option>
                                        @foreach($promotions as $promotion)
                                        <option value="{{$promotion->id}}">{{$promotion->name.' - Dispositivos disponibles: '.$promotion->device_quantity}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="hidden" name="promo_bool" id="promo_bool" value="0">
                               

                                <div class="col-md-12" style="margin-top: 1rem;">
                                    <textarea name="description" id="description" required></textarea>
                                </div>
                                <script>
                                        CKEDITOR.replace('description');
                                </script>

                            </div>

                            <button type="submit" class="btn btn-success" style="margin-top: 1rem;" id="form-rate">Guardar</button>
                        </div>
                    </div>

                </form>
            </div>
        </section>

    </div>
</div>

<script>
// document.getElementById("image").onchange = function(event) {
//     console.log($(this).val());
//     var file = event.target.files[0];
//   var reader = new FileReader();
//   reader.onload = function(event) {
//     var img = document.getElementById('img1');
//     img.src= event.target.result;
//   }
//   reader.readAsDataURL(file);
// }

    $('#price, #price_subsequent, #recurrency').on('input', function () {
        this.value = this.value.replace(/[^0-9.]/g, '');
    });

$('#pack_altcel').click(function(){
    if($('#pack_altcel').prop('checked')){
        $('#pack-altcel-content').removeClass('d-none');
    }else{
        $('#pack-altcel-content').addClass('d-none');
        $('#altcel_pack_id').val('');
    }
});

$('#promo_check').click(function(){
    if($('#promo_check').prop('checked')){
        $('#promo_bool').val(1);
        $('.content-promo').removeClass('d-none');
    }else{
        $('#promo_bool').val(0);
        $('.content-promo').addClass('d-none');
    }
});

</script>
@endsection