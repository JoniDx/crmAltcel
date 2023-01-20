@extends('layouts.octopus')
@section('content')
<header class="page-header">
    <h2>Administración de Pagos</h2>
    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Dashboard</span></li>
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

        <h2 class="panel-title">Pagos de Cambio de Producto</h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
            <thead style="cursor: pointer;">
                <tr>
                <th scope="col">Referencia</th>
                <th scope="col">Status</th>
                <th scope="col">Cliente</th>
                <th scope="col">Método de pago</th>
                <th scope="col">Plan</th>
                <th scope="col">usuario</th>
                <th scope="col">Número</th>
                <th scope="col">Referencia</th>
                </tr>
            </thead>
            <tbody>
            @foreach($excedentes as $excedente)
            <tr>
                <td>{{$excedente['reference']}}</td>
                <td>{{$excedente['status']}}</td>
                <td>{{$excedente['client']}}</td>
                <td>{{$excedente['channel']}}</td>
                <td>{{$excedente['rate_name']}}</td>
                <td>{{$excedente['user_name']}}</td>
                <td>{{$excedente['numbers']}}</td>
                @if($product['status'] == 'pending_payment' || $product['status'] =='peding')
                <td><button type="button" onclick="ref(this.id)" class="btn btn-warning btn-sm ref-generated mt-xs" id="{{$product['id']}}"><i class="fa fa-eye"></i></button></td>
                @else
                <td></td>
                @endif  
            </tr>
            @endforeach
            </tr>
            @endforeach
            </tbody>
        </table>
       
    </div>
       <!-- Modal Referencia -->
<div class="modal fade" id="reference" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleRef">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe class="col-md-12" id="reference-pdf" style=" width: 100%; height: 400px;" src=""></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de referencia OxxoPay -->
<div class="modal fade" id="referenceOxxo" tabindex="-1" aria-labelledby="referenceOxxo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="referenceOxxoLabel">Referencia OXXOPay</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <div class="opps">
                <div class="opps-header">
                    <div class="opps-reminder">Ficha digital, puedes capturar la pantalla. No es necesario imprimir.</div>
                        <div class="opps-info">
                            <div class="opps-brand"><img src="{{asset('storage/uploads/oxxopay_brand.png')}}" alt="OXXOPay"></div>
                            <div class="opps-ammount">
                                <h3 class="title-3">Monto a pagar</h3>
                                <!-- <h2>$ 0,000.00 <sup>MXN</sup></h2> -->
                                <h2 id="montoOxxo"></h2>
                                <p>OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
                            </div>
                        </div>
                        <div class="opps-reference">
                            <h3 class="title-3">Referencia</h3>
                            <h1 class="referenceOxxoCard" id="referenceOxxoCard"></h1>
                        </div>
                    </div>
                    <div class="opps-instructions">
                        <h3 class="title-3">Instrucciones</h3>
                        <ol class="instructions">
                            <li style="margin-top: 10px;color: #000000;">Acude a la tienda OXXO más cercana. <a class="search-oxxo" href="https://www.google.com.mx/maps/search/oxxo/" target="_blank">Encuéntrala aquí</a>.</li>
                            <li style="margin-top: 10px;color: #000000;">Indica en caja que quieres realizar un pago de <strong>OXXOPay</strong>.</li>
                            <li style="margin-top: 10px;color: #000000;">Dicta al cajero el número de referencia en esta ficha para que tecleé directamete en la pantalla de venta.</li>
                            <li style="margin-top: 10px;color: #000000;">Realiza el pago correspondiente con dinero en efectivo.</li>
                            <li style="margin-top: 10px;color: #000000;">Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
                        </ol>
                        <div class="opps-footnote">Al completar estos pasos recibirás un correo de <strong>Nombre del negocio</strong> confirmando tu pago.</div>
                    </div>
                </div>	
            <div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
    </div>
</div>
    <script>
    function ref(reference_id){
        // let link = 'https://sandbox-dashboard.openpay.mx/paynet-pdf/mvtmmoafnxul8oizkhju/';
        let link = 'https://dashboard.openpay.mx/paynet-pdf/m3one5bybxspoqsygqhz/';
    
            $.ajax({
                    url:"{{url('/show-reference')}}",
                    method: "GET",
                    data: {
                        reference_id: reference_id
                    },
                    success: function(data){
                        // x=data;
                        if(data.channel_id == 1){
                            $('#modalTitleRef').html('Referencia '+data.reference)
                            $('#reference-pdf').attr('src', link+data.reference);
                            $('#reference').modal('show');
                        }else if(data.channel_id == 2){
                            $('#montoOxxo').html('$'+data.amount+'<sup>MXN</sup>');
                            $('#referenceOxxoCard').html(data.reference);
                            
                            $('#referenceOxxo').modal('show');
                            console.log('referencia OxxoPay');
                        }
                        console.log(data.reference);
                    }
                }); 
    }
    </script>
</section>
@endsection