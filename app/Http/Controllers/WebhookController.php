<?php

namespace App\Http\Controllers;

use DB;
use Http;
use App\Pay;
use App\Pack;
use App\Rate;
use App\User;
use App\GuzzleHttp;
use DateTime;
use App\Offer;
use App\Number;
use App\Recharge;
use App\Reference;
use App\Activation;
use App\Ethernetpay;
use App\Instalation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationDealerSurplus;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function notificationOpenPay(Request $request) {
        $type = $request->type;
        $event_date = $request->event_date;
        $event_date = substr($event_date,0,19);
        $event_date = str_replace("T", "", $event_date);
        $event_date = str_replace("-", "", $event_date);
        $event_date = str_replace(":", "", $event_date);
        $transaction = $request->transaction;
        $reference_id = $transaction['id'];
        $status = $transaction['status'];
        $authorization = $transaction['authorization'];

        if($type == 'charge.succeeded'){
            $fee = $transaction['fee'];
            $fee_amount = $fee['amount'];
            $fee_tax = $fee['tax'];
            $fee_currency = $fee['currency'];

            $x = Reference::where('reference_id',$reference_id)->first();
            $referencestype_id = $x->referencestype_id;
            
            if($referencestype_id){
                Ethernetpay::where('reference_id',$reference_id)->update([
                    'status' => 'completado'
                ]);
                $y = Ethernetpay::where('reference_id',$reference_id)->first();

                $instalation_id = $y->instalation_id;
                $fecha_pay = $y->date_pay;
                $fecha_limit = $y->date_pay_limit;
                // Obtenemos el siguiente mes
                $fecha_pay_new = strtotime('+3 days', strtotime($fecha_pay));
                $fecha_pay_new = date('Y-m-d',$fecha_pay_new);
                // Obtenemos su último día
                $fecha_pay_new = new DateTime($fecha_pay_new);
                $fecha_pay_new->modify('last day of this month');
                $fecha_pay_new = $fecha_pay_new->format('Y-m-d');
                // Obtenemos nueva fecha límite de pago
                $fecha_limit_new = strtotime('+5 days', strtotime($fecha_pay_new));
                $fecha_limit_new = date('Y-m-d',$fecha_limit_new);
                
                Ethernetpay::insert([
                    'date_pay' => $fecha_pay_new,
                    'date_pay_limit' => $fecha_limit_new,
                    'instalation_id' => $instalation_id,
                    'status' => 'pendiente'
                ]);
            }

            Reference::where('reference_id',$reference_id)->update([
                'event_date_complete' => $event_date,
                'status' => $status,
                'authorizacion' => $authorization,
                'fee_amount' => $fee_amount,
                'fee_tax' => $fee_tax,
                'fee_currency' => $fee_currency
            ]); 
        }
        return response()->json(['http_code'=>'200']);
    }

    public function openpayPays(Request $request){
        if(isset($request['start']) && isset($request['end'])){
            if($request['start'] != null && $request['end'] != null){
                $year =  substr($request['start'],6,4);
                $month = substr($request['start'],0,2);
                $day = substr($request['start'],3,2);
                $init_date = $year.'-'.$month.'-'.$day;

                $year =  substr($request['end'],6,4);
                $month = substr($request['end'],0,2);
                $day = substr($request['end'],3,2);
                $final_date = $year.'-'.$month.'-'.$day;

                // return $date_init.' y '.$date_final;
            }else{
                
                $today = date('D');
        
                if($today == 'Fri'){
                    $init_date = date('Y-m-d');
                    $final_date = date("Y-m-d", strtotime('next Thursday', time()));
                }else if($today == 'Thu'){
                    $init_date = date("Y-m-d", strtotime('last Friday', time()));
                    $final_date = date('Y-m-d');
                }else{
                    $init_date = date("Y-m-d", strtotime('last Friday', time()));
                    $final_date = date("Y-m-d", strtotime('next Thursday', time()));
                }
            }
        }else{
            $today = date('D');
        
            if($today == 'Fri'){
                $init_date = date('Y-m-d');
                $final_date = date("Y-m-d", strtotime('next Thursday', time()));
            }else if($today == 'Thu'){
                $init_date = date("Y-m-d", strtotime('last Friday', time()));
                $final_date = date('Y-m-d');
            }else{
                $init_date = date("Y-m-d", strtotime('last Friday', time()));
                $final_date = date("Y-m-d", strtotime('next Thursday', time()));
            }
        }
        

        $init_date = $init_date.' 00:00:00';
        $final_date = $final_date.' 23:59:59';
        $data['date_init'] = $init_date;
        $data['date_final'] = $final_date;
        
        // $data['referencesPendings'] = WebhookController::pendingPaysAltan($init_date,$final_date);
        $data['paysCompleted'] = WebhookController::completedPaysAltan($init_date,$final_date);
        $data['paysReferencedCompleted'] = WebhookController::completedPaysReferencedAltan($init_date,$final_date);
        // return $data['paysCompleted'];
        // $data['conectaReferencesPendings'] = WebhookController::pendingPaysConecta($init_date,$final_date);
        $data['paysConectaCompleted'] = WebhookController::completedPaysConecta($init_date,$final_date);
        $data['paysReferencedConectaCompleted'] = WebhookController::completedPaysReferencedConecta($init_date,$final_date);
        // return $data['paysReferencedCompleted'];
        return view('webhooks.openpay',$data);
    }

    public function pendingPaysAltan($init_date,$final_date){
        $data = DB::table('references')
                   ->join('referencestypes','referencestypes.id','=','references.referencestype_id')
                   ->join('channels','channels.id','=','references.channel_id')
                   ->join('rates','rates.id','=','references.rate_id')
                   ->join('numbers','numbers.id','=','references.number_id')
                   ->join('users','users.id','=','references.client_id')
                   ->where('references.status','in_progress')
                   ->whereBetween('references.creation_date',[$init_date,$final_date])
                   ->select('references.reference','references.status','references.creation_date','references.description','references.amount','references.user_id',
                        'channels.name AS channel_name','rates.name AS rate_name',
                        'numbers.MSISDN AS DN','numbers.producto AS number_product',
                        'referencestypes.name AS type_name',
                        'users.name AS user_name')
                        ->get();
        return $data;
    }

    public function completedPaysAltan($init_date,$final_date){
        $data = DB::table('pays')
                   ->join('activations','activations.id','=','pays.activation_id')
                   ->join('numbers','numbers.id','=','activations.numbers_id')
                   ->join('rates','rates.id','=','activations.rate_id')
                   ->whereBetween('pays.updated_at',[$init_date,$final_date])
                   ->where('pays.status','completado')
                   ->where('type_pay','=','deposito')
                   ->orWhere('type_pay','=','transferencia')
                   ->orWhere('type_pay','=','efectivo')
                   ->select('pays.*','numbers.producto AS number_product','rates.price AS amount_waited')
                   ->get();
        return $data;
    }

    public function completedPaysReferencedAltan($init_date,$final_date){
        $data = DB::table('pays')
                   ->join('activations','activations.id','=','pays.activation_id')
                   ->join('numbers','numbers.id','=','activations.numbers_id')
                   ->leftJoin('references','references.reference_id','=','pays.reference_id')
                   ->join('channels','channels.id','=','references.channel_id')
                   ->where('pays.status','completado')
                   ->whereBetween('references.event_date_complete',[$init_date,$final_date])
                   ->where('pays.type_pay','referencia')
                   ->orWhere('pays.type_pay','=','deposito/referencia')
                   ->orWhere('pays.type_pay','=','efectivo/referencia')
                   ->orWhere('pays.type_pay','=','transferencia/referencia')
                   ->select('pays.*','numbers.producto AS number_product','references.amount AS reference_amount',
                   'references.fee_amount AS reference_fee_amount','references.event_date_complete AS reference_date_complete',
                   'channels.name AS channel_name','references.reference AS reference_folio')
                   ->get();
        return $data;
    }

    public function pendingPaysConecta($init_date,$final_date){
        $data = DB::table('references')
                   ->join('referencestypes','referencestypes.id','=','references.referencestype_id')
                   ->join('channels','channels.id','=','references.channel_id')
                   ->join('packs','packs.id','=','references.pack_id')
                   ->join('users','users.id','=','references.client_id')
                   ->where('references.status','in_progress')
                   ->whereBetween('references.creation_date',[$init_date,$final_date])
                   ->select('references.reference','references.status','references.creation_date','references.description','references.amount','references.user_id',
                        'channels.name AS channel_name','packs.name AS pack_name','packs.service_name AS pack_service',
                        'referencestypes.name AS type_name',
                        'users.name AS user_name')
                        ->get();
        return $data;
    }

    public function completedPaysConecta($init_date,$final_date){
        $data = DB::table('ethernetpays')
                   ->join('instalations','instalations.id','=','ethernetpays.instalation_id')
                   ->join('packs','packs.id','=','instalations.pack_id')
                   ->leftJoin('references','references.reference_id','=','ethernetpays.reference_id')
                   ->whereBetween('ethernetpays.updated_at',[$init_date,$final_date])
                   ->where('ethernetpays.status','completado')
                   ->where('type_pay','=','deposito')
                   ->orWhere('type_pay','=','transferencia')
                   ->orWhere('type_pay','=','efectivo')
                   ->orWhere('ethernetpays.type_pay','=','deposito/referencia')
                   ->orWhere('ethernetpays.type_pay','=','efectivo/referencia')
                   ->orWhere('ethernetpays.type_pay','=','transferencia/referencia')
                   ->select('ethernetpays.*','packs.price AS amount_waited','packs.service_name AS service_name','references.amount AS reference_amount')
                   ->get();
        return $data;
    }

    public function completedPaysReferencedConecta($init_date,$final_date){
        $data = DB::table('ethernetpays')
                   ->join('instalations','instalations.id','=','ethernetpays.instalation_id')
                   ->join('references','references.reference_id','=','ethernetpays.reference_id')
                   ->join('channels','channels.id','=','references.channel_id')
                   ->join('packs','packs.id','=','instalations.pack_id')
                   ->where('references.status','completed')
                   ->whereBetween('references.event_date_complete',[$init_date,$final_date])
                   ->where('ethernetpays.type_pay','referencia')
                   ->orWhere('ethernetpays.type_pay','=','deposito/referencia')
                   ->orWhere('ethernetpays.type_pay','=','efectivo/referencia')
                   ->orWhere('ethernetpays.type_pay','=','transferencia/referencia')
                   ->select('ethernetpays.*','references.amount AS amount_waited','references.fee_amount AS reference_fee_amount',
                   'references.event_date_complete AS reference_date_complete','references.reference AS reference_folio','channels.name AS channel_name',
                   'packs.service_name AS service_name')
                   ->get();
        return $data;
    }

    public function notificationWHk(Request $request) {
        
        $fee_amount = round($request['fee_amount'],2);
        $fee_amount = number_format($fee_amount,2);

        $fee_tax = round($request['fee_tax'],4);
        $fee_tax = number_format($fee_tax,4);

        $fee_currency = $request['fee_currency'];

        $event_date = $request['event_date_complete'];
        $reference_id = $request['reference_id'];
        $status = $request['status'];
        $authorization = $request['authorization'];

        $x = Reference::where('reference_id',$reference_id)->first();
            $referencestype_id = $x->referencestype_id;
            $amount_reference = $x->amount;
            
            if($referencestype_id == 2){
                $pack_id = $x->pack_id;
                $pack_data = Pack::where('id',$pack_id)->first();
                $pack_price = $pack_data->price;

                $payment_data = Ethernetpay::where('reference_id',$reference_id)->first();
                $payment_amountReceived = $payment_data->amount_received;
                $payment_amountReceived = $payment_amountReceived == null ? 0 : $payment_amountReceived;
                $payment_type = $payment_data->type_pay;
                $payment_type = $payment_type == null ? 'referencia' : $payment_type.'/referencia';
                
                $monto_recibido = $payment_amountReceived+$amount_reference;


                Ethernetpay::where('reference_id',$reference_id)->update([
                    'status' => 'completado',
                    'type_pay' => $payment_type,
                    'amount_received' => $monto_recibido
                ]);
                $y = Ethernetpay::where('reference_id',$reference_id)->first();

                $instalation_id = $y->instalation_id;
                $fecha_pay = $y->date_pay;
                $fecha_limit = $y->date_pay_limit;
                // Obtenemos el siguiente mes
                $fecha_pay_new = strtotime('+3 days', strtotime($fecha_pay));
                $fecha_pay_new = date('Y-m-d',$fecha_pay_new);
                // Obtenemos su último día
                $fecha_pay_new = new DateTime($fecha_pay_new);
                $fecha_pay_new->modify('last day of this month');
                $fecha_pay_new = $fecha_pay_new->format('Y-m-d');
                // Obtenemos nueva fecha límite de pago
                $fecha_limit_new = strtotime('+5 days', strtotime($fecha_pay_new));
                $fecha_limit_new = date('Y-m-d',$fecha_limit_new);
                
                Ethernetpay::insert([
                    'date_pay' => $fecha_pay_new,
                    'date_pay_limit' => $fecha_limit_new,
                    'instalation_id' => $instalation_id,
                    'status' => 'pendiente',
                    'amount' => $pack_price
                ]);
            }else if($referencestype_id == 1){
                $rate_id = $x->rate_id;
                $rate_data = Rate::where('id',$rate_id)->first();
                $rate_price = $rate_data->price;

                $payment_data = Pay::where('reference_id',$reference_id)->first();
                $payment_amountReceived = $payment_data->amount_received;
                $payment_amountReceived = $payment_amountReceived == null ? 0 : $payment_amountReceived;
                $payment_type = $payment_data->type_pay;
                $payment_type = $payment_type == null ? 'referencia' : $payment_type.'/referencia';
                
                $monto_recibido = $payment_amountReceived+$amount_reference;

                Pay::where('reference_id',$reference_id)->update([
                    'status' => 'completado',
                    'type_pay' => $payment_type,
                    'amount_received' => $monto_recibido
                ]);
                $y = Pay::where('reference_id',$reference_id)->first();

                $activation_id = $y->activation_id;
                $fecha_pay = $y->date_pay;
                $fecha_limit = $y->date_pay_limit;
                // Obtenemos el siguiente mes
                $fecha_pay_new = strtotime('+3 days', strtotime($fecha_pay));
                $fecha_pay_new = date('Y-m-d',$fecha_pay_new);
                // Obtenemos su último día
                $fecha_pay_new = new DateTime($fecha_pay_new);
                $fecha_pay_new->modify('last day of this month');
                $fecha_pay_new = $fecha_pay_new->format('Y-m-d');
                // Obtenemos nueva fecha límite de pago
                $fecha_limit_new = strtotime('+5 days', strtotime($fecha_pay_new));
                $fecha_limit_new = date('Y-m-d',$fecha_limit_new);
                
                Pay::insert([
                    'date_pay' => $fecha_pay_new,
                    'date_pay_limit' => $fecha_limit_new,
                    'activation_id' => $activation_id,
                    'status' => 'pendiente',
                    'amount' => $rate_price
                ]);
            }

            Reference::where('reference_id',$reference_id)->update([
                'event_date_complete' => $event_date,
                'status' => $status,
                'authorizacion' => $authorization,
                'fee_amount' => $fee_amount,
                'fee_tax' => $fee_tax,
                'fee_currency' => $fee_currency
            ]); 
            return response()->json(['http_code'=>'200']);
    }

    // -- --
    public function saveManualPay(Request $request){
        $service = $request['service'];
        $payID = $request['payID'];
        $monto = $request['monto'];
        $typePay = $request['typePay'];
        $folioPay = $request['folioPay'];
        $estadoPay = $request['estadoPay'];
        $montoExtra = $request['montoExtra'];
        $user_id = $request['user_id'];

        $dataUser = User::find($user_id);
        $role = $dataUser->role_id;
        $who_consigned = $role == 1 || $role == 5 ? $user_id : null;
        $status_consigned = $role == 1 || $role == 5 || $role == 8 ? 'completado' : 'pendiente';

        if($service == 'Telmex' || $service == 'SpotMobile'){
            $payment_data = Ethernetpay::where('id',$payID)->first();
            $payment_amountReceived = $payment_data->amount_received;
            $payment_amountReceived = $payment_amountReceived == null ? 0 : $payment_amountReceived;
            $monto_recibido = $payment_amountReceived+$monto;

            $x = Ethernetpay::where('id', $payID)->update([
                'status' => $estadoPay,
                'amount_received' => $monto_recibido,
                'type_pay' => $typePay,
                'folio_pay' => $folioPay,
                'who_did_id' => $user_id,
                'extra' => $montoExtra,
                'status_consigned' => $status_consigned,
                'who_consigned' => $who_consigned
            ]);

            if($montoExtra != 0){
                $status = '';
                $dataPayment = DB::table('ethernetpays')
                                  ->join('instalations','instalations.id','=','ethernetpays.instalation_id')
                                  ->where('ethernetpays.id',$payID)
                                  ->select('ethernetpays.*','instalations.id AS instalationID','instalations.amount_install AS amount_install',
                                  'instalations.amount AS amount_pack','instalations.received_amount_install AS received_amount_install',
                                  'instalations.received_amount AS received_amount_pack')
                                  ->get();
                $instalation_id = $dataPayment[0]->instalationID;
                $amount_install = $dataPayment[0]->amount_install;
                $received_amount_install = $dataPayment[0]->received_amount_install == null ? 0 : $dataPayment[0]->received_amount_install;
                $received_amount_install_new = $received_amount_install+$montoExtra;

                if($received_amount_install_new >= $amount_install){
                    $status = 'completado';
                }else{
                    $status = 'pendiente';
                }
                
                Instalation::where('id',$instalation_id)->update(['received_amount_install'=>$received_amount_install_new,'payment_status'=>$status]);
            }

        }
        if($service == 'MIFI' || $service == 'HBB' || $service == 'MOV'){
            $payment_data = Pay::where('id', $payID)->first();
            $payment_amountReceived = $payment_data->amount_received;
            $payment_amountReceived = $payment_amountReceived == null ? 0 : $payment_amountReceived;
            $monto_recibido = $payment_amountReceived+$monto;
            $activation_id = $payment_data->activation_id;
            $dataActivation = Activation::where('id', $activation_id)->first();
            $recharges = $dataActivation->recharges;
            $offer_id = $dataActivation->offer_id;
            $rate_id = $dataActivation->rate_id;
            $number_id = $dataActivation->numbers_id;

            if($role == 8){
                if($recharges == 5){
                    $recharges = 0;
                }else if($recharges < 5){
                    $recharges+=1;
                    if($recharges == 5){
                        $offer = Offer::where('id',$offer_id)->first();
                        $offerIDAltan = $offer->offerID;
                        $offers = DB::table('offers')->where('offerID_excedente',$offerIDAltan)->orderBy('offerID_excedente','asc')->select('offers.*')->get();
                        $offerIDAltanSurplus = $offers[0]->offerID;
                        $price = $offers[0]->price_sale;
                        $dataNumber = Number::where('id',$number_id)->first();
                        $msisdn = $dataNumber->MSISDN;
                        $service = $dataNumber->producto;
                        $service = trim($service);
                        $response = app('App\Http\Controllers\AltanController')->productPurchaseBonusDealer($msisdn,$offerIDAltanSurplus,$user_id,$price,$offer_id,$rate_id);
                        
                        if($response['http_code'] == 1){
                            $dataClient = DB::table('activations')
                                             ->join('users','users.id','=','activations.client_id')
                                             ->where('activations.id', $activation_id)
                                             ->select('users.name','users.lastname')
                                             ->get();
                            $client_name = $dataClient[0]->name.' '.$dataClient[0]->lastname;

                            $data = [
                                'offerSurplus' => $offers[0]->name,
                                'client_name' => $client_name,
                                'service' => $service,
                                'msisdn' => $msisdn,
                                'subject' => 'BONIFICACIÓN POR QUINTA MENSUALIDAD'
                            ];
                        }
                        $recharges = 0;
                        
                    }
                }
                Activation::where('id',$activation_id)->update(['recharges'=>$recharges]);
            }

            $x = Pay::where('id',$payID)->update([
                'status' => $estadoPay,
                'amount_received' => $monto_recibido,
                'type_pay' => $typePay,
                'folio_pay' => $folioPay,
                'who_did_id' => $user_id,
                'extra' => $montoExtra,
                'status_consigned' => $status_consigned,
                'who_consigned' => $who_consigned
            ]);

            if($montoExtra != 0){
                $status = '';
                $dataPayment = DB::table('pays')
                                  ->join('activations','activations.id','=','pays.activation_id')
                                  ->where('pays.id',$payID)
                                  ->select('pays.*','activations.id AS activationID','activations.amount_device AS amount_device',
                                  'activations.amount_rate AS amount_rate','activations.received_amount_device AS received_amount_device',
                                  'activations.received_amount_rate AS received_amount_rate')
                                  ->get();
                $activation_id = $dataPayment[0]->activationID;
                $amount_device = $dataPayment[0]->amount_device;
                $received_amount_device = $dataPayment[0]->received_amount_device == null ? 0 : $dataPayment[0]->received_amount_device;
                $received_amount_device_new = $received_amount_device+$montoExtra;

                if($received_amount_device_new >= $amount_device){
                    $status = 'completado';
                }else{
                    $status = 'pendiente';
                }
                
                Activation::where('id',$activation_id)->update(['received_amount_device'=>$received_amount_device_new,'payment_status'=>$status]);
            }

        }

        if($x){
            return 1;
        }else{
            return 0;
        }
    }

    public function searchFind(Request $request){
        $user_id = $request->get('user_id');
        $x = User::find($user_id);
        return $x->role_id;
    }

    public function notificationWHkConekta(Request $request){
        $dataFirst = $request->data;
        $object = $dataFirst['object'];
        if(isset($object['payment_status'])){
            $payment_status = $object['payment_status'];
            if($payment_status == 'paid'){
                $id = $object['id'];
                $updated_at = $object['updated_at'];
                $updated_at = date('Y-m-d H:i:s', $updated_at);
                $charges = $object['charges'];
                $data = $charges['data'];
                $data = $data[0];
                $fee_amount = $data['fee'];
                $fee_amount = $fee_amount/100;
                return response()->json([
                    'fee_amount' => $fee_amount,
                    'fee_currency'=>'MXN',
                    'fee_tax' => 0.00,
                    'event_date_complete' => $updated_at,
                    'reference_id' => $id,
                    'status' => $payment_status
                ]);
            }
        }
        
    }

    
    public function handle(Request $request){
        // la forma de pago empieza en oxxo 
        $payment_method = 'oxxo';
        if ($request->type == "checkout.session.completed") {
            $status = $request->data['object']['status'];
            if ($status == 'complete') {
                // Si viene desde el inicio como completado es que se realizo por tarjeta
                $payment_method = 'card';
                $response = $this->notificationWHkStripe(
                // $response = Http::post('127.0.0.1:8000/notificationWHkStripe',
                [
                    'reference_id' => $request->data['object']['payment_link'],
                    'reference'=> $request->data['object']['payment_intent'],
                    'status' => $status,
                    'event_date_create' => date("Y-m-d H:i:s", $request->created),
                    'event_date_complete' => date("Y-m-d H:i:s", $request->data['object']['created']),
                    'payment_method' =>  $payment_method,
                    'offer_id' => $request->data['object']['metadata']['offer_id'],
                    'rate_id' => $request->data['object']['metadata']['rate_id'],
                    'amount' => $request->data['object']['amount_total'],
                    'number_id' => $request->data['object']['metadata']['number_id'],
                ]);
            }else {
                // Si no es que el pago esta pendiente y no se a cobrado
                Log::debug("Wbhk: ", [$request]);
            }
        }elseif ($request->type == "checkout.session.async_payment_succeeded") {
            // Si viene por este metodo es que se realizo por oxxo o que se pago despues de completar el checkout
            $status = $request->data['object']['status'];
            //Log::debug("payment_method: ", [$payment_method]);
            if ($status == 'complete') {
                $payment_method = 'oxxo';
                $response = $this->notificationWHkStripe(
                    // $response = Http::post('127.0.0.1:8000/notificationWHkStripe',
                [
                    'reference_id' => $request->data['object']['payment_link'],
                    'reference'=> $request->data['object']['payment_intent'],
                    'status' => $status,
                    'event_date_create' => date("Y-m-d H:i:s", $request->created),
                    'event_date_complete' => date("Y-m-d H:i:s", $request->data['object']['created']),
                    'payment_method' =>  $payment_method,
                    'offer_id' => $request->data['object']['metadata']['offer_id'],
                    'rate_id' => $request->data['object']['metadata']['rate_id'],
                    'number_id' => $request->data['object']['metadata']['number_id'],
                ]);
            }else {
                return response()->json(['status'=>'Cancelado']);
            }
        }
    }

    public function notificationWHkStripe($request){
        // Log::debug("WHK: ", [$request]);

        $reference_id = $request['reference_id'];
        $reference = $request['reference'];
        $status = $request['status'];
        $event_date_create = $request['event_date_create'];
        $event_date_complete = $request['event_date_complete'];
        $payment_method = $request['payment_method'];
        $offer_id =  $request['offer_id'];
        $rate_id =  $request['rate_id'];
        $number_id =  $request['number_id'];

        // Log::debug("payment_method: ", [$payment_method]);
        $orders = Reference::where('reference_id', $reference_id);

        if ($orders->exists()) {

            $order = $orders->first();
            //Log::debug("order: ", [$order]);

            $referencestype_id = $order->referencestype_id;
            $amount_reference = $order->amount;
            $user_id = $order->user_id;
            
            $dataNumber = Number::where('id', $number_id)->first();
            $dataOffer = Offer::where('id', $offer_id)->first();
            $dataRate = Rate::where('id', $rate_id)->first();

            $MSISDN = $dataNumber->MSISDN;
            $producto = $dataNumber->producto;
            $producto = trim($producto);
            if($referencestype_id == 5){
            //Recargas
                $rate_id = $order->rate_id;

                if($producto == 'MIFI' || $producto == 'HBB'){
                    $offerID = $dataOffer->offerID;
                }else if($producto == 'MOV'){
                    $offerID = $dataOffer->offerID_second;
                }

                $data = array('msisdn' => $MSISDN, 'offer' => $offerID);

                $purchaseProduct = app('App\Http\Controllers\AltanController')->productPurchaseStripe($data);
               
                //Log::debug("Response: ", [$purchaseProduct]);
                
            }elseif ($referencestype_id == 4) {
            //Cambio de producto

                $offerID = $dataOffer->offerID;
                $offer_id = $dataOffer->id;
                $rate_id = $dataRate->id;

                $scheduleDate = '';
                $address = null;

                $dataActivation = Activation::where('numbers_id', $number_id)->first();

                if($producto == 'HBB'){
                    $lat = $dataActivation->lat_hbb;
                    $lng = $dataActivation->lng_hbb;
                    $address = $lat.','.$lng;
                }
                // Consulta si esta suspendido
                $statusAltan = $this->consultUFRuntime($MSISDN, $producto);
                //Log::debug("consultUFRuntime: ", [$statusAltan]);

                if($statusAltan == 1){
                    $type = 'internalExternalChange';

                    $data = [
                        'msisdn' => $MSISDN,
                        'offerID' => $offerID,
                        'offer_id' => $offer_id,
                        'rate_id' => $rate_id,
                        'scheduleDate' => $scheduleDate,
                        'address' => $address,
                        'type' => $type,
                        'comment' => null,
                        'reason' => 'referenciado',
                        'status' => 'completado',
                        'pay_id' => null,
                        'reference_id' => $reference_id,
                        'amount' => $amount_reference,
                        'user_id' => $user_id
                    ];

                    //Cambio de producto
                    $response = app('App\Http\Controllers\AltanController')->changeProductPaymentLink($data);

                    //Log::debug("changeProduct: ", [$response]);

                    // return $response;
                }else{
                    Log::debug("Error: ", $statusAltan);
                    return response()->json(['message' => 'Hubo un error, no se hará cambio alguno', 'http_code'=>0]);
                }

            }
            
            $orders->update([
                'reference' => $reference,
                'event_date_create' => $event_date_create,
                'event_date_complete' => $event_date_complete,
                'status' => $status,
                'payment_method' => $payment_method,
            ]); 
            
        }else {
            return response()->json(['http_code'=>'404']);
        }
       

    }

    public function consultUFRuntime($MSISDN, $producto){
        
        $consultUF = app('App\Http\Controllers\AltanController')->consultUF($MSISDN);
        //Log::debug("consultUF: ", [$consultUF]);
        $responseSubscriber = $consultUF['responseSubscriber'];
        $status = $responseSubscriber['status']['subStatus'];
        $bool = 0;

        if($status == "Suspend (B2W)"){
            //si esta suspendido se activa
            $response = app('App\Http\Controllers\AltanController')->activateDeactivateDNPaymentLink([
                'msisdn' => $MSISDN,
                'type' => 'out_in',
                'status' => 'inactivo'
            ]);

            //Log::debug("activateDeactivateDN: ", [$response]);

            $bool = $response['bool'];
        }else{
            $bool = 1;
        }

        return $bool;

    }
    
}
