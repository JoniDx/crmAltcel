@extends('layouts.octopus')
@section('content')

<section class="panel">
    <div class="panel-body">
        <div class="invoice">
            <header class="clearfix">
                <div class="row">
                    <div class="col-sm-6 mt-md">
                        <h2 class="h2 mt-none mb-sm text-dark text-bold">Factura</h2>
                    </div>
                </div>
            </header>
                <div class="bill-info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="bill-to">
                                <address>
                                    <label for="">Fecha expedición: </label> {{$invoice['date_expedition']}}
                                    <br/>
                                    <label for="">RFC emisor: </label> {{$invoice['rfc_emisor']}}
                                    <br>
                                    <label for="">Nombre del Emisor: </label> {{$invoice['name_emisor']}}
                                    <br/>
                                    <label for="">RFC receptor: </label> {{$invoice['rfc_recptor']}}
                                    <br/>
                                    <label for="">Nombre Receptor: </label> {{$invoice['name_recptor']}}
                                </address>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bill-data text-right">
                            <address>
                                    <label for="">Metodo de Pago: </label> {{$invoice['method_payment']}}
                                    <br/>
                                    <label for="">Forma de Pago: </label> {{$invoice['way_payment']}}
                                    <br>
                                    <label for="">Total: </label> {{$invoice['total']}}
                                    <br/>
                                    <label for="">Subtotal: </label> {{$invoice['subtotal']}}
                                    <br/>
                                    <label for="">I.V.A.: </label> {{$invoice['iva']}}
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="table-responsive">
                    <table class="table invoice-items">
                        <thead>
                            <tr>
                                <th>Codigo SAT</th>
                                <th>Clave de Unidad</th>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                                <th>Descripción</th>
                                <th>Valor Unitario</th>
                                <th>Importe</th>
                                <th>I.V.A</th>
                                <th>Folio Fiscal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $x)
                            <tr>0
                                <td>{{$x['sat_code']}}</td>
                                <td>{{$x['unity_key_code']}}</td>
                                <td>{{$x['quantity']}}</td>
                                <td>{{$x['unity']}}</td>
                                <td>{{$x['description']}}</td>
                                <td>{{$x['unity_value']}}</td>
                                <td>{{$x['amount']}}</td>
                                <td>{{$x['iva']}}</td>
                                <td>{{$x['invoice_id']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-right mr-lg">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Regresar</a>
                </div>         
        </div>
    </div>
</section>
@endsection

