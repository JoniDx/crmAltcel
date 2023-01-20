@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Pago de Servicios <strong>con Tarjeta</strong></h2>
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
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                    <a href="#" class="fa fa-times"></a>
                </div>

                <h2 class="panel-title">Tarjeta</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" method="get">
                    <div class="form-group"  style="padding-right: 1rem; padding-left: 1rem;">
                        <h3>Información personal</h3>
                        <div class="form-group col-md-12">
                            <!-- <label class="control-label col-md-6">Vertical Group w/ icon</label> -->
                            <div class="col-md-12">
                                <section class="form-group-vertical">
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="name" placeholder="Nombre" >
                                    </div>
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="lastname" placeholder="Apellidos" >
                                    </div>
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-envelope"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="email" placeholder="Email">
                                    </div>
                                    <div class="input-group input-group-icon">
                                        <span class="input-group-addon">
                                            <span class="icon"><i class="fa fa-phone"></i></span>
                                        </span>
                                        <input class="form-control" type="text" id="cellphone" placeholder="Celular">
                                    </div>
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                            Número al que se enviará la referencia generada.
                                        </div>
                                </section>
                            </div>
                        </div>
                        <h3>Datos Extras</h3>

                        <div class="form-group col-md-6">
                            <label for="lastname">Monto: </label>
                            <input type="text" class="form-control form-control-sm" id="amount" placeholder="Monto" >
                        </div>

                        <div class="form-group col-md-6">
                            <label for="lastname">Concepto: </label>
                            <input type="text" class="form-control form-control-sm" id="concepto" placeholder="Concepto" >
                        </div>
                        
                        <div class="form-actions col-md-12">
                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-success" id="card_button"><span class="spinner-border spinner-border-sm d-none" id="spinner-pay_generate" role="status" aria-hidden="true"></span><i class="fas fa-file-invoice-dollar"></i> Generar</button>
                        </div>
                    </div>              

                </form>
            </div>
        </section>

    </div>
</div>
    
<script>
$('#card_button').click(function(){
    let name = $('#name').val();
    let lastname = $('#lastname').val();
    let email = $('#email').val();
    let cellphone = $('#cellphone').val();
    let amount = $('#amount').val();
    let concepto = $('#concepto').val();
    let token = $('meta[name="csrf-token"]').attr('content');
    let link = '';

    $.ajax({
        url: "{{url('/send-card-payment')}}",
        method: 'POST',
        data: {_token: token, name: name, lastname: lastname, email: email, cellphone: cellphone, amount: amount, concepto: concepto},
        success: function(data){
            console.log(data);
            link = data.url,
            window.location.href = link;
        }
    });
});
</script>
@endsection
