<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Datainvoice;
use App\Pay;
use App\Ethernetpay;

class InvoiceController extends Controller
{
    public function index(Request $request){
        $payment = $request->input('payment');
        $type = $request->input('type');
        $data['payment'] = $payment;
        $data['type'] = $type;
        $datainvoice['invoices'] = Invoice::all();
        return view('facturacion.index', $data, $datainvoice);
    }

   //facturas cargadas
    public function invoices(){
      $data['invoices'] = Invoice::all();
      return view('facturacion.invoices', $data);
    }

    //muestra la factura
    public function invoice($facturacion){
        $datainvoice['data'] = Datainvoice::where('invoice_id', "=", $facturacion)->get();
        $invoice['invoice'] = Invoice::find($facturacion);
        return view('facturacion.details-invoice', $invoice, $datainvoice);
    }

    public function invoiceJoin(Request $request){
      $payment = $request->post('payment');
      $type = $request->post('type');
      $uuid = $request->post('uuid');

      if ($type == 'HBB' || 'MIFI' || 'MOV') {
        Pay::where('id','=',$payment)->update(['invoice_id'=> $uuid]);
      }else {
        Ethernetpay::where('id','=',$payment)->update(['invoice_id'=> $uuid]);
      }
      // return $request;
    }

    //lectura del XML
    public function store(Request $request){
        $payment = $request->input('payment');
        $type = $request->input('type');
        $xmlString = file_get_contents($request->file('xml'));
        $xml = simplexml_load_string($xmlString); 
        $ns = $xml->getNamespaces(true);
        $xml->registerXPathNamespace('cfdi', $ns['cfdi']);
        $xml->registerXPathNamespace('t', $ns['tfd']);
         
        //factura
        $invoice = [];
        //EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA 
        foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){
               $invoice['date_expedition']=$cfdiComprobante['Fecha'];
               $invoice['total']=$cfdiComprobante['Total'];
               $invoice['subtotal']=$cfdiComprobante['SubTotal'];
               $invoice['way_payment']=$cfdiComprobante['FormaPago'];
               $invoice['method_payment']=$cfdiComprobante['MetodoPago'];
        } 
        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
              $invoice['rfc_emisor']=$Emisor['Rfc'];
              $invoice['name_emisor']=$Emisor['Nombre'];
        } 
        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
              $invoice['rfc_recptor']=$Receptor['Rfc'];
              $invoice['name_recptor']=$Receptor['Nombre'];
              $invoice['uso_cfdi']=$Receptor['UsoCFDI'];
        } 
        //concepto
        $dataInvoice = [];
        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){ 

           array_push($dataInvoice,array(
              'unity' => $Concepto['Unidad'],
              'quantity' => $Concepto['Cantidad'],
              'description' => $Concepto['Descripcion'],
              'unity_value' => $Concepto['ValorUnitario'],
              'sat_code'=>$Concepto['ClaveProdServ'],
              'unity_key_code'=>$Concepto['ClaveUnidad'],
              'amount'=>$Concepto['Importe'],
              'iva' => 0,
              'invoice_id' => null
           ));
        }
        $count = 0;
        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 
         $dataInvoice[$count]['iva'] = $Traslado['Importe'];
         $count++;
      } 
        foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 
            $invoice['iva']=$Traslado['Importe'];
        } 
        
        foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
            $invoice['id']=$tfd['UUID'];
        } 
 
        // return sizeof($dataInvoice);
        for ($i=0; $i < sizeof($dataInvoice); $i++) { 
          $dataInvoice[$i]['invoice_id'] = $invoice['id'];
        }

        //VALIDACION
        $uuid = $invoice['id'];
        $x = Invoice::where('id', $uuid)->exists();
        if ($x) {
          return back()->with('msg', 'El UUID ya existe.');
        }

        if ($type == 'HBB' || 'MIFI' || 'MOV') {
          Pay::where('id','=',$payment)->update(['invoice_id'=> $uuid]);
        }else {
          Ethernetpay::where('id','=',$payment)->update(['invoice_id'=> $uuid]);
        }
          $data['dataInvoice'] = $dataInvoice;
          $data['invoice'] = $invoice;
    
          $x = Invoice::insert($invoice);
          $y = Datainvoice::insert($dataInvoice);
          return view('facturacion.invoice',$data);
 
    }

    public function destroy($facturacion){
      $datainvoice = Datainvoice::where('invoice_id', "=", $facturacion)->delete();
      $invoice = Invoice::find($facturacion);
      $invoice->delete();
      if ($type == 'HBB' || 'MIFI' || 'MOV') {
        $datainvoice = Pay::where('invoice_id', "=", $facturacion)->delete();
      }else {
        $datainvoice = Ethernetpay::where('invoice_id', "=", $facturacion)->delete();
      }
      return back();
    }
}
