@extends('layouts.octopus')
@section('content')
@php
use \Carbon\Carbon;
@endphp
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
<div class="alert alert-primary">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Mostrando registros en el rango de {{$date_init}} a {{$date_final}}</strong>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
           
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="{{route('incomes.get')}}">

                    <div class="form-group">
                        <!-- <label class="col-md-3 control-label">Date range</label> -->
                        <div class="col-md-6">
                            <div class="input-daterange input-group" data-plugin-datepicker>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input autocomplete="off" type="text" class="form-control" name="start">
                                <span class="input-group-addon">a</span>
                                <input autocomplete="off" type="text" class="form-control" name="end">
                            </div>
                        </div>
                        <button class="col-md-1 btn btn-success btn-sm">Consultar</button>
                    </div>
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

        <h2 class="panel-title">Pagos Completados</h2>
    </header>
    <div class="panel-body">
        
        <table class="table table-bordered table-striped mb-none" id="incomesTable">
            <thead style="cursor: pointer;">
                <tr>
                <th scope="col">Fecha de Operación</th>
                <th scope="col">Fecha de Pago</th>
                <th scope="col">Folio/Referencia</th>
                <th scope="col">Tipo</th>
                <th scope="col">Número</th>
                <th scope="col">Servicio</th>
                <th scope="col">Canal de Pago</th>
                <th scope="col">Monto Esperado</th>
                <th scope="col">Monto Recibido</th>
                <th scope="col">Comisión</th>
                <th scope="col">Registrado por</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $incomesMonthlies = 0;
                $incomesChanges = 0;
                $incomesSurplus = 0;
                $incomesDevices = 0;
                $totalFeeAmount = 0;
                ?>
                @foreach($monthliesCash as $monthly)
                <tr>
                    <td>{{ $monthly->updated_at }}</td>
                    <td>{{ $monthly->date_pay }}</td>
                    <td>{{ $folio = $monthly->folio_pay == null ? 'N/A' : $monthly->folio_pay }}</td>
                    <td>MENSUALIDAD</td>
                    <td><span class="badge label-primary">{{ $monthly->msisdn }}</span></td>
                    <td><span class="badge label-primary">{{ $monthly->service }}</span></td>
                    <td>{{ $type_pay = $monthly->type_pay == null ? 'efectivo' : $monthly->type_pay }}</td>
                    <td>${{ number_format($monthly->amount,2) }}</td>
                    <td><span class="badge label-success">${{ number_format($monthly->amount_received,2) }}</span></td>
                    <td><span class="badge label-warning">$0.00</span></td>
                    <td><span class="badge label-info">{{$monthly->who_name}} {{$monthly->who_lastname}}</span></td>
                </tr>
                @php
                $incomesMonthlies+=$monthly->amount_received;
                @endphp
                @endforeach

                @foreach($monthliesOreda as $monthly)
                <tr>
                    <td>{{ $monthly->updated_at }}</td>
                    <td>{{ $monthly->date_pay }}</td>
                    <td>{{ $folio = $monthly->folio_pay == null ? 'N/A' : $monthly->folio_pay }}</td>
                    <td>MENSUALIDAD</td>
                    <td><span class="badge label-primary">{{ $monthly->number }}</span></td>
                    <td><span class="badge label-primary">TELMEX</span></td>
                    <td>{{ $type_pay = $monthly->type_pay == null ? 'efectivo' : $monthly->type_pay }}</td>
                    <td>${{ number_format($monthly->amount,2) }}</td>
                    <td><span class="badge label-success">${{ number_format($monthly->amount_received,2) }}</span></td>
                    <td><span class="badge label-warning">$0.00</span></td>
                    <td></td>
                </tr>
                @php
                $incomesMonthlies+=$monthly->amount_received;
                @endphp
                @endforeach

                @foreach($monthliesChannels as $monthly)
                <tr>
                    <td>{{ $monthly->updated_at }}</td>
                    <td>{{ $monthly->date_pay }}</td>
                    <td>{{ $monthly->reference }}</td>
                    <td>MENSUALIDAD</td>
                    <td><span class="badge label-primary">{{ $monthly->msisdn }}</span></td>
                    <td><span class="badge label-primary">{{ $monthly->service }}</span></td>
                    <td>{{ $monthly->channel }}</td>
                    <td>${{ number_format($monthly->amount,2) }}</td>
                    <td><span class="badge label-success">${{ number_format($monthly->amount_paid,2) }}</span></td>
                    <td><span class="badge label-warning">${{ number_format($monthly->comision,2) }}</span></td>
                    <td><span class="badge label-info">Automático</span></td>
                </tr>
                @php
                $incomesMonthlies+=$monthly->amount_paid;
                $totalFeeAmount+=$monthly->comision;
                @endphp
                @endforeach

                @foreach($monthliesOredaChannels as $monthly)
                <tr>
                    <td>{{ $monthly->date_complete }}</td>
                    <td>{{ $monthly->date_pay }}</td>
                    <td>{{ $monthly->reference }}</td>
                    <td>MENSUALIDAD</td>
                    <td><span class="badge label-primary">{{ $monthly->number }}</span></td>
                    <td><span class="badge label-primary">TELMEX</span></td>
                    <td>{{ $monthly->channel }}</td>
                    <td>${{ number_format($monthly->amount,2) }}</td>
                    <td><span class="badge label-success">${{ number_format($monthly->amount_paid,2) }}</span></td>
                    <td><span class="badge label-warning">${{ number_format($monthly->comision,2) }}</span></td>
                    <td><td><span class="badge label-info">Automático</span></td></td>
                </tr>
                @php
                $incomesMonthlies+=$monthly->amount_paid;
                $totalFeeAmount+=$monthly->comision;
                @endphp
                @endforeach

                @foreach($changes as $change)
                <tr>
                    <td>{{ $change->date }}</td>
                    <td>{{ $change->date }}</td>
                    <td>{{ $type = $change->reference == null ? 'N/A' : $change->reference }}</td>
                    <td>CAMBIO DE PRODUCTO</td>
                    <td><span class="badge label-primary">{{ $change->msisdn }}</span></td>
                    <td><span class="badge label-primary">{{ $change->service }}</span></td>
                    <td>{{ $channel = $change->channel == null ? 'N/A' : $change->channel }}</td>
                    <td>${{ number_format($change->amount,2) }}</td>
                    <td><span class="badge label-success">${{ number_format($change->amount,2) }}</span></td>
                    <td><span class="badge label-warning">${{ $comision = $change->comision == null ? '0.00' : number_format($change->comision,2) }}</span></td>
                    <td><span class="badge label-info">{{ $who_changed = $change->who_name == null ? 'Automático' : $change->who_name.' '.$change->who_lastname }}</span></td>
                </tr>
                @php
                $incomesChanges+=$change->amount;
                $totalFeeAmount += $feeAmount = $change->comision == null ? 0 : $change->comision;
                @endphp
                @endforeach

                @foreach($surplusChannels as $surplus)
                <tr>
                    <td>{{ $surplus->updated_at }}</td>
                    <td>{{ $surplus->updated_at }}</td>
                    <td>{{ $surplus->reference }}</td>
                    <td>COMPRA DE GBs</td>
                    <td><span class="badge label-primary">{{ $surplus->msisdn }}</span></td>
                    <td><span class="badge label-primary">{{ $surplus->service }}</span></td>
                    <td>{{ $channel = $surplus->channel == null ? 'N/A' : $surplus->channel }}</td>
                    <td>${{ number_format($surplus->amount,2) }}</td>
                    <td><span class="badge label-success">${{ number_format($surplus->amount,2) }}</span></td>
                    <td><span class="badge label-warning">${{ number_format($surplus->fee_amount,2) }}</span></td>
                    <td><span class="badge label-info">Automático</span></td>
                </tr>
                @php
                $incomesSurplus+=$surplus->amount;
                $totalFeeAmount+=$surplus->fee_amount;
                @endphp
                @endforeach

                @foreach($surpluses as $surplus)
                <tr>
                    <td>{{ $surplus->date }}</td>
                    <td>{{ $surplus->date }}</td>
                    <td>N/A</td>
                    <td>COMPRA DE GBs</td>
                    <td><span class="badge label-primary">{{ $surplus->msisdn }}</span></td>
                    <td><span class="badge label-primary">{{ $surplus->service }}</span></td>
                    <td>{{ $channel = $surplus->gestor == null ? $channel = $surplus->order_id_conekta == null ? 'Efectivo' : 'Conekta' : strtoupper($surplus->gestor) }}</td>
                    <td>${{ number_format($surplus->amount,2) }}</td>
                    <td><span class="badge label-success">${{ number_format($surplus->amount,2) }}</span></td>
                    <td><span class="badge label-warning">${{ number_format($surplus->fee_amount,2) }}</span></td>
                    <td><span class="badge label-info">{{$surplus->who_name}} {{$surplus->who_lastname}}</span></td>
                </tr>
                @php
                $incomesSurplus+=$surplus->amount;
                $totalFeeAmount+=$surplus->fee_amount;
                @endphp
                @endforeach

                @foreach($devicesChannels as $device)
                <tr>
                    <td>{{ $device->updated_at }}</td>
                    <td>{{ $device->updated_at }}</td>
                    <td>{{ $device->reference }}</td>
                    <td>VENTA DE DISPOSITIVO</td>
                    <td><span class="badge label-primary">N/A</span></td>
                    <td><span class="badge label-primary">N/A</span></td>
                    <td>{{ $channel = $device->channel == null ? 'N/A' : $device->channel }}</td>
                    <td>${{ number_format($device->amount,2) }}</td>
                    <td><span class="badge label-success">${{ number_format($device->amount,2) }}</span></td>
                    <td><span class="badge label-warning">${{ number_format($device->fee_amount,2) }}</span></td>
                    <td><span class="badge label-info">Automático</span></td>
                </tr>
                @php
                $incomesDevices+=$device->amount;
                $totalFeeAmount+=$device->fee_amount;
                @endphp
                @endforeach
            </tbody>
        </table>
        <?php
        $incomeSubtotal = $incomesMonthlies+$incomesChanges+$incomesSurplus+$incomesDevices;
        $incomeTotal = $incomeSubtotal-$totalFeeAmount;
        ?>
        <div class="col-md-12">
            <div class="col-md-12">
                <h2 class="badge label-primary" style="font-size:1.75rem;">Mensualidades: ${{number_format($incomesMonthlies,2)}}</h2> 
                <h2 class="badge label-primary" style="font-size:1.75rem;">Cambios de Plan: ${{number_format($incomesChanges,2)}}</h2>
                <h2 class="badge label-primary" style="font-size:1.75rem;">Excedentes: ${{number_format($incomesSurplus,2)}}</h2>
                <h2 class="badge label-primary" style="font-size:1.75rem;">Ventas Dispositivos: ${{number_format($incomesDevices,2)}}</h2>
            </div>
            <div class="col-md-12"><h2 class="badge label-primary" style="font-size:1.75rem; margin-top: 0 !important;">Subtotal: ${{number_format($incomeSubtotal,2)}}</h2></div>
            <div class="col-md-12"><h2 class="badge label-warning" style="font-size:1.75rem; margin-top: 0 !important;">Comisiones: ${{number_format($totalFeeAmount,2)}}</h2></div>
            <div class="col-md-12"><h2 class="badge label-success" style="font-size:2rem; margin-top: 0 !important;">Total (menos comisiones): ${{number_format($incomeTotal,2)}}</h2></div>
        </div>
    </div>
</section>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready( function () {
        $('#incomesTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                title: 'Pagos Completados',
                exportOptions : {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ],
                }
            }]
        });
    });
</script>
@endsection
