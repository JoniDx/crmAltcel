@extends('layouts.octopus')
@section('content')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<header class="page-header">
    <h2>Planes Altán</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="{{route('home')}}">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            @if(Auth::user()->role_id != 4)
            <li><a href="{{ route('rates.create')}}"><span>Crear</span></a></li>
            @endif
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Planes</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead >
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Oferta Primaria</th>
                <th scope="col">Paquete Altcel</th>
                <th scope="col">Precio</th>
                
                <th scope="col">Satus</th>
                <th scope="col">Opciones</th>
                
                </tr>
            </thead>
            <tbody>
            @foreach( $rates as $rate )
            <tr style="cursor: pointer;" class="rate-table" data-id="{{$rate->id}}">
                <td>{{ $rate->name }}</td>
                <td>{{ $rate->name_offer }}</td>
                @php
                    $pack_altcel = $rate->altcel_pack_id == null ? 'N/A' : $rate->altcel_pack_id
                @endphp
                <td>{{ $pack_altcel }}</td>
                <td>{{ '$'.number_format($rate->price,2) }}</td>
                
                <td>
                    @if($rate->status == 'activo')
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-danger btn-xs button-status button-danger" data-status="activo" data-id="{{$rate->id}}" data-type="altan">Desactivar</button>
                    @elseif($rate->status == 'inactivo')
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-success btn-xs button-status button-success" data-status="inactivo" data-id="{{$rate->id}}" data-type="altan">Activar</button>
                    @endif
                </td>
                <td>   
                    <button type="button" class="mb-xs mt-xs mr-xs btn btn-info btn-sm update-rate" data-rate="{{ $rate->id }}" data-toggle="modal" ><i class="fa fa-edit"></i></button>
                </td>
                
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
<div class="modal fade" id="modalInfoRate" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalTitle"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-bordered" action="{{url('offers/')}}" method="POST" id="form-update-rate">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <h3>Datos</h3>
                        <div class="form-group col-md-12">
                            <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Precio Inicial</label>
                                    <input type="text" class="form-control" id="price" name="price" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Precio Subsecuente</label>
                                    <input type="text" class="form-control" id="price_subsequent" name="price_subsequent" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Precio de Lista</label>
                                    <input type="text" class="form-control" id="price_list" name="price_list" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Recurrencia</label>
                                    <input type="text" class="form-control" id="recurrency" name="recurrency" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="offer_primary">Oferta</label>
                                    <select id="offer_primary" name="offer_primary" class="form-control form-control-sm">
                                        <option selected value="0">Choose...</option>
                                        
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="type">Tipo</label>
                                    <select id="type" name="type" class="form-control form-control-sm">
                                        
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Costo Altan</label>
                                    <input type="text" class="form-control" id="price_c_iva_offer" readonly>
                                </div>
                                <div class="col-md-4 has-warning">
                                    <label for="name" class="form-label">Precio Referencia</label>
                                    <input type="text" class="form-control" id="price_sale_offer" readonly>
                                </div>
                                <div class="col-md-12" style="margin-top: 1rem;">
                                    <textarea name="description" id="description"></textarea>
                                </div>
                                <script>
                                        CKEDITOR.replace('description');
                                </script>
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
</section>
<script>
    $('.update-rate').click(function(){
        let id = $(this).attr('data-rate');
        let action = '';
        var url = "{{route('rates.edit',['rate'=>'temp'])}}",
        url = url.replace('temp',id);
        let option_offer_primary = '';
        
        $.ajax({
            url:url,
            data: {id:id},
            success: function(data){
                data = data[0];
                console.log(data);
                // return false;
                // $('#id_user_update').val(id)
                $('#myModalTitle').html('Plan <strong>'+data.name+'</strong>');
                $('#name').val(data.name);
                $('#price').val(data.price);
                $('#price_subsequent').val(data.price_subsequent);
                $('#price_list').val(data.price_list);
                $('#price_c_iva_offer').val(data.price_c_iva_offer);
                $('#price_sale_offer').val(data.price_sale_offer);
                $('#recurrency').val(data.recurrency);

                if(data.type == 'publico'){
                    $('#type').html('<option selected value="publico">Público</option><option value="interno">Interno</option>');
                }else if(data.type == 'interno'){
                    $('#type').html('<option selected value="interno">Interno</option><option value="publico">Público</option>');
                }

                getAllOffers(data.alta_offer_id);

                CKEDITOR.instances['description'].setData(data.description);
                
                var url = "{{ route('rates.update', ['rate' => 'temp']) }}";
                url = url.replace('temp', data.id);
                $('#form-update-rate').attr('action', url);
                $('#modalInfoRate').modal('show');
            }
        }); 
        
    });

    function getAllOffers(id){
        let options = '';
        $.ajax({
                url: "{{route('getAllOffers.get')}}",
                success: function(data){
                    Object.values(data).forEach(function(element){
                        if(element.id == id){
                            options+="<option value='"+element.id+"' selected>"+element.name+" - "+element.product+"</option>"
                        }else{
                            options+="<option value='"+element.id+"'>"+element.name+" - "+element.product+"</option>"
                        }
                        
                    });
                    
                    $('#offer_primary').html(options);
                }
            });
    }

    $('#add_update').click(function(){
        
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
                $("#form-update-rate").submit();
                 
                Swal.fire({
                    icon: 'success',
                    title: 'Guardando cambios...',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        })
    });
    $('.button-status').click(function(){
        let status = $(this).attr('data-status');
        let id = $(this).attr('data-id');
        let type = $(this).attr('data-type');

        $.ajax({
                url:"{{route('change-status.rates-packs')}}",
                method: "GET",
                data: {status: status, id: id, type: type},
                success: function(data){
                    location.reload();
                }
            });
    });
</script>
@endsection