@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Invetarios de Dispositivos</h2>
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


<div class="row" id="create">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Asignar precio</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" >
                @csrf
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <h3>Información personal</h3>
                        <div class="col md-12">
                            <div class="col-md-6" style="margin-top: 1rem;">
                                <label for="exampleFormControlSelect1">Material: </label>
                                <select class="form-control form-control-sm" id="material" name="material" >
                                <option value="0" selected>Elegir...</option>
                                    @foreach($devices as $device)
                                    <option value="{{$device['material']}}">{{$device['material']}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-6 mt-sm">
                                <label for="price" class="form-label">Precio</label>
                                <input type="text" class="form-control form-control-sm mr-2" id="price" name="price" >
                                <!-- <button type="button" class="btn btn-success btn-sm" id="searching"><i class="fas fa-search"></i> Search</button> -->
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 1rem;">
                        <button type="button" class="btn btn-success" id="savePrice">Guardar</button>
                        <button type="button" class="btn btn-success" id="consultUF">UF</button>
                        </div>
                    </div>              

                </form>

                <form action="{{route('chargeCSVNIR')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="nirs" >
                    <button type="submit">Send</button>
                </form>
            </div>
        </section>

    </div>
</div>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">SIM</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead >
                <tr>
                <th scope="col">Producto</th>
                <th scope="col">Disponibles</th>
                <th scope="col">No Diponibles</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $products as $product )
            <tr style="cursor: pointer;">
                <td>{{$product['producto']}}</td>
                <td>{{$product['available']}}</td>
                <td>{{$product['taken']}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>
        </div>

        <h2 class="panel-title">Materiales</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead >
                <tr>
                <th scope="col">Material</th>
                <th scope="col">Description</th>
                <th scope="col">En inventario</th>
                <th scope="col">Precio</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $devices as $device )
            <tr style="cursor: pointer;">
                <td>{{$device['material']}}</td>
                <td>{{$device['description']}}</td>
                <td>{{$device['available']}}</td>
                <td>${{number_format($device['price'],2)}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>

<script>
$('#price').on('input', function () {
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#material').change(function(){
        let value = $(this).val();
        let token = $('meta[name="csrf-token"]').attr('content');
        let datos = "material="+value;
        var url = "{{route('devices.show',['device'=>'temp'])}}",
        url = url.replace('temp',value)
        $.ajax({
            url:url,
            data: datos,
            success: function(data){
                $('#price').val(data.price);
            }
        });  
    });

    $('#savePrice').click(function(){
        let material = $('#material').val();
        let price = $('#price').val();
        
        $.ajax({
            url: "{{route('updatePriceDevice.get')}}",
            method: 'GET',
            data: {material: material, price:price},
            success: function(data){
                if(data == 1){
                    location.reload();
                }
            }
        })
    })

    $('.update-user').click(function(){
        let id = $(this).attr('data-user');
        $.ajax({
            url:"{{route('get-user.get')}}",
            data: {id:id},
            success: function(data){
                console.log(data);
                $('#id_user_update').val(id)
                $('#myModalTitle').html('Datos de <strong>'+data.name+' '+data.lastname+'</strong>');
                $('#name-modal').val(data.name);
                $('#lastname-modal').val(data.lastname);
                $('#email-modal').val(data.email);
                $('#modalInfoUser').modal('show');
            }
        }); 
        
    });

    $('#consultUF').click(function(){
        $.ajax({
            url: "{{route('consultUF.get')}}",
            success: function(response){
                console.log(response)
            }
        })
    });
</script>
@endsection