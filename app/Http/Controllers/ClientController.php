<?php

namespace App\Http\Controllers;
use DB;
use Http;
use App\Offer;
use App\Channel;
use App\User;
use App\Reference;
use App\Pay;
use App\Portability;
use App\Rate;
use App\Ethernetpay;
use App\Client;
use App\Clientsson;
use App\Instalation;
use App\Activation;
use App\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NewclientsExport;
use App\Exports\ConsumosExport;
use App\Exports\ConsumosGeneralExport;
use App\Exports\ReportsActivations;
use App\Exports\ReportsPaymentsActivations;
use App\Exports\ReportsPaymentsMonthly;
use App\Exports\ReportsPaymentsChange;
use App\Exports\ReportsPaymentsReferences;
use App\Exports\ReportsPaymentsPurchases;

class ClientController extends Controller
{
    public function index(){
        $data['clients'] = DB::table('clients')
                              ->join('activations','activations.client_id','=','clients.id')
                              ->join('numbers','numbers.id','=','activations.numbers_id')
                              ->join('rates','rates.id','=','activations.rate_id')
                              ->leftJoin('devices','devices.id','=','activations.devices_id')
                              ->where('activations.deleted_at','=',null)
                              ->select('clients.id AS id','clients.name AS name','clients.lastname AS lastname',
                              'clients.cellphone AS cellphone','numbers.id AS id_dn','numbers.MSISDN AS MSISDN',
                              'numbers.producto AS service','devices.no_serie_imei AS imei',
                              'rates.name AS rate_name','rates.price_subsequent AS amount_rate','activations.date_activation AS date_activation','activations.amount_device AS amount_device','numbers.icc_id AS icc',
                              'numbers.traffic_outbound AS traffic_outbound','numbers.traffic_outbound_incoming AS traffic_outbound_incoming','numbers.status_altan AS status_altan','activations.expire_date AS date_expire',
                              'activations.serial_number AS serial_number','activations.id AS id_act','activations.mac_address AS mac', 'numbers.ported AS portado')
                              ->get();
        $data['clientsTwo'] = DB::table('clients')
                                 ->join('instalations','instalations.client_id','=','clients.id')
                                 ->join('packs','packs.id','=','instalations.pack_id')
                                //  ->leftJoin('clients','clients.user_id','=','users.id')
                                 ->select('clients.name AS name','clients.lastname AS lastname',
                                 'clients.cellphone AS cellphone','instalations.number AS number',
                                 'packs.name AS pack_name','packs.price AS amount_pack',
                                 'packs.service_name AS service','instalations.date_instalation','instalations.amount_install AS amount_install','instalations.serial_number AS serial_number')
                                 ->get();

        return view('clients.index',$data);

    }

    public function reportsFilter(){
        return view('clients.reportsFilter');
    }

    public function repostsPlans(Request $request){
        
        $date_start = date('Y-m-d', strtotime($request -> date_start)); 
        $date_end = date('Y-m-d', strtotime($request -> date_end)); 
        
        if($request ->date_send == "true"){
            $data['clients'] = DB::table('clients')
                                ->join('activations','activations.client_id','=','clients.id')
                                ->join('numbers','numbers.id','=','activations.numbers_id')
                                ->join('rates','rates.id','=','activations.rate_id')
                                ->leftJoin('devices','devices.id','=','activations.devices_id')
                                // ->leftJoin('clients','clients.user_id','=','users.id')
                                ->where('activations.deleted_at','=',null)
                                ->where('activations.offer_id','=', $request->plan)
                                ->whereBetween('activations.date_activation', [ $date_start, $date_end ])
                                ->select('clients.name AS name','clients.lastname AS lastname',
                                'clients.cellphone AS cellphone','numbers.id AS id_dn','numbers.MSISDN AS MSISDN',
                                'numbers.producto AS service','devices.no_serie_imei AS imei',
                                'rates.name AS rate_name','rates.price_subsequent AS amount_rate','activations.date_activation AS date_activation','activations.amount_device AS amount_device','numbers.icc_id AS icc',
                                'numbers.traffic_outbound AS traffic_outbound','numbers.traffic_outbound_incoming AS traffic_outbound_incoming','numbers.status_altan AS status_altan','activations.expire_date AS date_expire',
                                'activations.serial_number AS serial_number','activations.id AS id_act','activations.mac_address AS mac')
                                ->get();
        }else{
            $data['clients'] = DB::table('clients')
                                ->join('activations','activations.client_id','=','clients.id')
                                ->join('numbers','numbers.id','=','activations.numbers_id')
                                ->join('rates','rates.id','=','activations.rate_id')
                                ->leftJoin('devices','devices.id','=','activations.devices_id')
                                // ->leftJoin('clients','clients.user_id','=','users.id')
                                ->where('activations.deleted_at','=',null)
                                ->where('activations.offer_id','=', $request->plan)
                                ->select('clients.name AS name','clients.lastname AS lastname',
                                'clients.cellphone AS cellphone','numbers.id AS id_dn','numbers.MSISDN AS MSISDN',
                                'numbers.producto AS service','devices.no_serie_imei AS imei',
                                'rates.name AS rate_name','rates.price_subsequent AS amount_rate','activations.date_activation AS date_activation','activations.amount_device AS amount_device','numbers.icc_id AS icc',
                                'numbers.traffic_outbound AS traffic_outbound','numbers.traffic_outbound_incoming AS traffic_outbound_incoming','numbers.status_altan AS status_altan','activations.expire_date AS date_expire',
                                'activations.serial_number AS serial_number','activations.id AS id_act','activations.mac_address AS mac')
                                ->get();
        }
        return  $data;
    }

    public function rechargeGenerateClient() {
        $current_id = auth()->user()->id;
        $data['clientDatas'] = DB::table('activations')
                            ->join('numbers','numbers.id','=','activations.numbers_id')
                            ->where('activations.client_id','=',$current_id)
                            ->select('activations.*','numbers.MSISDN', 'numbers.producto', 'numbers.id AS number_id')
                            ->get();
        $data['offers'] = Offer::all()->where('action','=','Recarga');
        $data['channels'] = Channel::all();
        return view('clients.rechargeView',$data);
    }

    public function clientDetails($id){
        $clientData = Client::where('id', $id)->first();
        $data['mypays'] = DB::table('pays')
                             ->join('activations','activations.id','=','pays.activation_id')
                             ->join('numbers','numbers.id','=','activations.numbers_id')
                             ->join('rates','rates.id','=','activations.rate_id')
                             ->where('activations.client_id',$id)
                             ->where('pays.status','pendiente')
                             ->select('pays.*','numbers.MSISDN AS DN','numbers.producto AS number_product','numbers.id AS number_id','activations.id AS activation_id','rates.name AS rate_name','rates.price AS rate_price')
                             ->get();
        $data['my2pays'] = DB::table('ethernetpays')
                              ->join('instalations','instalations.id','=','ethernetpays.instalation_id')
                              ->join('packs','packs.id','=','instalations.pack_id')
                              ->where('instalations.client_id',$id)
                              ->where('ethernetpays.status','pendiente')
                              ->select('ethernetpays.*','packs.name AS pack_name','packs.price AS pack_price','packs.service_name AS service_name','instalations.id AS instalation_id','instalations.number AS instalation_number')
                              ->get();
        
        $data['completemypays'] = DB::table('pays')
                             ->join('activations','activations.id','=','pays.activation_id')
                             ->join('numbers','numbers.id','=','activations.numbers_id')
                             ->join('rates','rates.id','=','activations.rate_id')
                             ->leftJoin('references','references.reference_id','=','pays.reference_id')
                             ->where('activations.client_id',$id)
                             ->where('pays.status','completado')
                             ->select('pays.*','numbers.MSISDN AS DN','numbers.producto AS number_product','rates.name AS rate_name','rates.price AS rate_price','references.reference AS reference_folio')
                             ->get();
                            
        $data['completemy2pays'] = DB::table('ethernetpays')
                              ->join('instalations','instalations.id','=','ethernetpays.instalation_id')
                              ->join('packs','packs.id','=','instalations.pack_id')
                              ->leftJoin('references','references.reference_id','=','ethernetpays.reference_id')
                              ->where('instalations.client_id','=',$id)
                              ->where('ethernetpays.status','completado')
                              ->select('ethernetpays.*','packs.name AS pack_name','packs.price AS pack_price','packs.service_name AS service_name','references.reference AS reference_folio','instalations.number AS instalation_number')
                              ->get();

        $data['activations'] = DB::table('activations')
                                  ->join('numbers','numbers.id','=','activations.numbers_id')
                                  ->join('rates','rates.id','=','activations.rate_id')
                                  ->where('activations.client_id',$id)
                                  ->select('activations.*','numbers.MSISDN AS DN','numbers.producto AS service','rates.name AS pack_name','numbers.icc_id AS icc')
                                  ->get();
        
        $data['instalations'] = DB::table('instalations')
                                   ->join('packs','packs.id','=','instalations.pack_id')
                                   ->where('instalations.client_id',$id)
                                   ->select('instalations.*','packs.service_name AS service','packs.name AS pack_name')
                                   ->get();
        $data['client_id'] = $id;
        $data['client_name'] = $clientData->name.' '.$clientData->lastname;

        $data['clients'] = DB::select('select * from clients');
        // $data['clients'] = $clientData;
        // return $data['completemy2pays'];
        return view('clients.clientDetails',$data);
    }

    public function changeOwner(Request $request){
        $client = $request->get('client');
        $activation = $request->get('activation');
        $type = $request->get('type');

        if($type == 'activation'){
            $x = Activation::where('id',$activation)->update(['client_id'=>$client]);
        }else if($type == 'instalation'){
            $x = Instalation::where('id',$activation)->update(['client_id'=>$client]);
        }
        
        if($x){
            return response()->json(['http_code'=>1]);
        }else{
            return response()->json(['http_code'=>0]);
        }
    }

    public function showReferenceClient(Request $request){
        $reference_id = $request->get('reference_id');
        $response = Reference::where('reference_id',$reference_id)->first();
        return $response;
    }

    public function searchClients(Request $request){
        $term = $request->get('term');
        $querys = DB::table('clients')
                        ->where('name', 'LIKE', '%'. $term. '%')
                        ->orWhere('email','LIKE','%'. $term. '%')
                        ->select('clients.*')
                        ->get();

        return $querys;
    }

    public function searchClientProduct(Request $request) {
        $id = $request->get('id');
        $querys = DB::table('activations')
                     ->join('numbers','numbers.id','=','activations.numbers_id')
                     ->where('activations.client_id','=',$id)
                     ->select('activations.*','numbers.MSISDN', 'numbers.producto', 'numbers.id AS number_id')
                     ->get();
        return $querys;
    }

    public function generateReference($id,$type,$user_id){
        $current_role = auth()->user()->role_id;
        $employe_id = $current_role == 3 ? 'null' : auth()->user()->id;
        // $user = DB::table('users')
        //            ->join('clients','clients.user_id','=','users.id')
        //            ->where('users.id',$user_id)
        //            ->select('users.*','clients.cellphone AS client_cellphone')
        //            ->get();
        $user = DB::table('users')->where('clients.id', $user_id)->select('clients.*')->get();
        $user_name = $user[0]->name;
        $user_lastname = $user[0]->lastname;
        $user_email = $user[0]->email;
        $user_phone = $user[0]->client_cellphone;
        if($type == 'MIFI' || $type == 'HBB' || $type == 'MOV'){
            $referencestype = 1;
            $pay = DB::table('pays')
                      ->join('activations','activations.id','=','pays.activation_id')
                      ->join('rates','rates.id','=','activations.rate_id')
                      ->join('numbers','numbers.id','=','activations.numbers_id')
                      ->join('offers','offers.id','=','rates.alta_offer_id')
                      ->where('pays.id',$id)
                      ->where('activations.client_id',$user_id)
                      ->select('pays.*','activations.numbers_id AS activation_number_id',
                               'numbers.MSISDN AS DN','rates.name AS rate_name','rates.id AS rate_id',
                               'rates.price AS rate_price','offers.id as offer_id')
                               ->get();
            $number_id = $pay[0]->activation_number_id;
            $DN = $pay[0]->DN;
            $rate_id = $pay[0]->rate_id;
            $rate_name = $pay[0]->rate_name;
            
            $amount = $pay[0]->amount;
            $amount_received = $pay[0]->amount_received;
            if($amount_received == null){
                $rate_price = $pay[0]->amount;
            }else{
                $rate_price = $pay[0]->amount - $pay[0]->amount_received;
            }
            // return $rate_price;
            // $rate_price = $pay[0]->amount;
            $offer_id = $pay[0]->offer_id;

            $channels =  Channel::all();
            if($type == 'MIFI'){
                $concepto = 'MIFI';
            }else if($type == 'MOV'){
                $concepto = 'de Telefonía Celular (Movilidad)';
            }

            $rates = DB::table('rates')
                        ->join('offers','offers.id','=','rates.alta_offer_id')
                        ->where('offers.type','normal')
                        ->where('offers.product','like','%'.$type.'%')
                        ->where('rates.id','!=',$rate_id)
                        ->where('rates.status','=','activo')
                        ->where('rates.type','=','publico')
                        ->select('rates.*','offers.id AS offer_id')
                        ->get();

            // $data['rates'] = $rates;

            $data = array(
                'datos' => [
                    "referencestype" => $referencestype,
                    "number_id" => $number_id,
                    "DN" => $DN,
                    "rate_id" => $rate_id,
                    "rate_name" => $rate_name,
                    "rate_price" => $rate_price,
                    "offer_id" => $offer_id,
                    "concepto" => "Pago de Servicio ".$concepto
                ],
                'channels' => $channels,
                'data_client' => [
                    "client_name" => $user_name,
                    "client_lastname" => $user_lastname,
                    "client_email" => $user_email,
                    "client_phone" => $user_phone,
                    "client_id" => $user_id,
                    "employe_id" => $employe_id,
                    "pay_id" => $id,
                    "service" => "Altan Redes"
                ],
                'rates' => $rates
                );
                // return $data;
        }else if($type == 'Conecta' || $type == 'Telmex'){
            $referencestype = 2;
            $pay = DB::table('ethernetpays')
                      ->join('instalations','instalations.id','=','ethernetpays.instalation_id')
                      ->join('packs','packs.id','=','instalations.pack_id')
                      ->where('ethernetpays.id',$id)
                      ->where('instalations.client_id',$user_id)
                      ->select('ethernetpays.*','packs.id AS pack_id','packs.name AS pack_name','packs.price AS pack_price')
                      ->get();
        
            $pack_id = $pay[0]->pack_id;
            $pack_name = $pay[0]->pack_name;

            $amount = $pay[0]->amount;
            $amount_received = $pay[0]->amount_received;
            if($amount_received == null){
                $pack_price = $pay[0]->amount;
            }else{
                $pack_price = $pay[0]->amount - $pay[0]->amount_received;
            }
            // return $pack_price;

            // $pack_price = $pay[0]->amount;
            $channels =  Channel::all();

            $data = array(
                'datos' => [
                    "referencestype" => $referencestype,
                    "pack_id" => $pack_id,
                    "pack_name" => $pack_name,
                    "pack_price" => $pack_price,
                    "concepto" => "Pago de Servicio de Internet."
                ],
                'channels' => $channels,
                'data_client' => [
                    "client_name" => $user_name,
                    "client_lastname" => $user_lastname,
                    "client_email" => $user_email,
                    "client_phone" => $user_phone,
                    "client_id" => $user_id,
                    "employe_id" => $employe_id,
                    "pay_id" => $id,
                    "service" => "Conecta"
                ]
                );
        }

        return view('clients.generatePay')->with($data);
    }

    public function productDetails($id_dn,$id_act,$service){
        if($service == 'MIFI' || $service == 'HBB' || $service == 'MOV'){
            // return 1;
            $data['channels'] = Channel::all();
            $dataQuery = DB::table('activations')
                       ->join('numbers','numbers.id','=','activations.numbers_id')
                       ->join('rates','rates.id','=','activations.rate_id')
                       ->where('activations.id',$id_act)
                       ->where('activations.numbers_id',$id_dn)
                       ->select('numbers.MSISDN AS DN','numbers.traffic_outbound AS traffic_outbound',
                       'numbers.traffic_outbound_incoming AS traffic_outbound_incoming',
                       'rates.name AS rate_name','rates.price AS rate_price',
                       'activations.date_activation AS date_activation','activations.lat_hbb AS lat','activations.lng_hbb AS lng','numbers.id AS number_id')
                       ->get();
            
            $data['DN'] = $dataQuery[0]->DN;
            $data['lat'] = $dataQuery[0]->lat;
            $data['lng'] = $dataQuery[0]->lng;
            $data['service'] = $service;
            $data['pack_name'] = $dataQuery[0]->rate_name;
            $data['pack_price'] = $dataQuery[0]->rate_price;
            $data['date_activation'] = $dataQuery[0]->date_activation;
            $data['traffic_out'] = $dataQuery[0]->traffic_outbound;
            $data['traffic_out_in'] = $dataQuery[0]->traffic_outbound_incoming;
            $number_id = $dataQuery[0]->number_id;
	    $expire_date = "";

            $consultUF = app('App\Http\Controllers\AltanController')->consultUF($data['DN']);
            // return $consultUF;

            $responseSubscriber = $consultUF['responseSubscriber'];
            $information = $responseSubscriber['information'];
            $status = $responseSubscriber['status']['subStatus'];
            $offer = $responseSubscriber['primaryOffering']['offeringId'];
            $freeUnits = $responseSubscriber['freeUnits'];
            $coordinates = $responseSubscriber['information']['coordinates'];
            $char = explode(',',$coordinates);

            if($service == 'HBB'){
                // return $char;
                $lat_hbb = $char[0];
                $lng_hbb = $char[1] == null ? '' : $char[1];
                $data['lat'] = $lat_hbb;
                $data['lng'] = $lng_hbb;
            }else if($service == 'MIFI' || $service == 'MOV'){
                $lat_hbb = null;
                $lng_hbb = null;
            }

            $data['consultUF']['status'] = $status;
            $data['consultUF']['imei'] = $information['IMEI'];
            $data['consultUF']['icc'] = $information['ICCID'];

            if($status == 'Active'){
                $data['consultUF']['status_color'] = 'success';
            }else if($status == 'Suspend (B2W)' || $status == 'Barring (B1W) (Notified by client)' || $status == 'Barring (B1W) (By NoB28)' || $status == 'Suspend (B2W) (By mobility)' || $status = 'Suspend (B2W) (By IMEI locked)' || $status == 'Predeactivate'){
                $data['consultUF']['status_color'] = 'warning';
            }

            if($service == 'MIFI' || $service == 'HBB'){
                $data['FreeUnitsBoolean'] = 0;
                $data['FreeUnits2Boolean'] = 0;
                $data['consultUF']['offerID'] = 0;

                for ($i=0; $i < sizeof($freeUnits); $i++) {
                    if($freeUnits[$i]['name'] == 'Free Units' || $freeUnits[$i]['name'] == 'FU_Altan-RN'){
                        $totalAmt = $freeUnits[$i]['freeUnit']['totalAmt'];
                        $unusedAmt = $freeUnits[$i]['freeUnit']['unusedAmt'];
                        $percentageFree = ($unusedAmt/$totalAmt)*100;
                        $data['FreeUnits'] = array('totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree);
                        $data['FreeUnitsBoolean'] = 1;

                        $detailOfferings = $freeUnits[$i]['detailOfferings'];
                        // return $detailOfferings;

                        $data['effectiveDatePrimary'] = ClientController::formatDateConsultUF($detailOfferings[0]['effectiveDate']);
                        $data['expireDatePrimary'] = ClientController::formatDateConsultUF($detailOfferings[0]['expireDate']);
                        $expire_date = $detailOfferings[0]['expireDate'];
                        // return $expire_date;
                        $expire_date = substr($expire_date,0,8);

                        $data['consultUF']['offerID'] = $detailOfferings[0]['offeringId'];
                    }

                    if($freeUnits[$i]['name'] == 'Free Units 2' || $freeUnits[$i]['name'] == 'FU_Altan-RN_P2'){
                        $totalAmt = $freeUnits[$i]['freeUnit']['totalAmt'];
                        $unusedAmt = $freeUnits[$i]['freeUnit']['unusedAmt'];
                        $percentageFree = ($unusedAmt/$totalAmt)*100;
                        $data['FreeUnits2'] = array('totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree);
                        $data['FreeUnits2Boolean'] = 1;

                        $detailOfferings = $freeUnits[$i]['detailOfferings'];

                        $data['effectiveDateSurplus'] = ClientController::formatDateConsultUF($detailOfferings[0]['effectiveDate']);
                        $data['expireDateSurplus'] = ClientController::formatDateConsultUF($detailOfferings[0]['expireDate']);
                    }
                }

                $rateData = DB::table('numbers')
                                   ->leftJoin('activations','activations.numbers_id','=','numbers.id')
                                   ->leftJoin('rates','rates.id','=','activations.rate_id')
                                   ->where('numbers.MSISDN',$data['DN'])
                                   ->select('rates.name AS rate_name')
                                   ->get();

                if($status == 'Suspend (B2W)' || $status == 'Suspend (B2W) (By mobility)'){
                    $data['consultUF']['rate'] = $rateData[0]->rate_name.'/Suspendido por falta de pago';    
                }else if($status == 'Active'){
                    $data['consultUF']['rate'] = $rateData[0]->rate_name;
                }

                if($status == 'Active'){
                    // return $service;
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'activo',
                        'traffic_outbound_incoming' => 'activo',
                        'status_altan' => 'activo'
                    ]);
    
                    if($service = 'MIFI'){
                        Activation::where('numbers_id',$number_id)->update(['expire_date'=>$expire_date]);
                    }
    
                    // if($service = 'HBB'){
                    //     Activation::where('numbers_id',$number_id)->update(['expire_date'=>$expire_date,'lat_hbb'=>$lat_hbb,'lng_hbb'=>$lng_hbb]);
                    // }
                }else if($status == 'Suspend (B2W)'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'activo',
                        'traffic_outbound_incoming' => 'inactivo',
                        'status_altan' => 'activo'
                    ]);
                    if($service = 'MIFI'){
                        Activation::where('numbers_id',$number_id)->update(['expire_date'=>$expire_date]);
                    }
                    // if($service = 'HBB'){
                    //     Activation::where('numbers_id',$number_id)->update(['expire_date'=>$expire_date,'lat_hbb'=>$lat_hbb,'lng_hbb'=>$lng_hbb]);
                    // }
                }else if($status == 'Predeactivate'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'activo',
                        'traffic_outbound_incoming' => 'activo',
                        'status_altan' => 'predeactivate'
                    ]);
                }else if($status == 'Barring (B1W) (Notified by client)'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'inactivo',
                        'traffic_outbound_incoming' => 'activo',
                        'status_altan' => 'activo'
                    ]);
                }

                if($data['FreeUnits2Boolean'] == 0){
                    $data['FreeUnits2'] = array('totalAmt'=>0,'unusedAmt'=>0,'freePercentage'=>0);
                    $data['effectiveDateSurplus'] = 'No se ha generado recarga.';
                    $data['expireDateSurplus'] = 'No se ha generado recarga.';
                }
            }else if($service == 'MOV'){
                $data['consultUF']['freeUnits']['extra'] = [];
                $data['consultUF']['freeUnits']['nacionales'] = [];
                $data['consultUF']['freeUnits']['ri'] = [];
                $data['consultUF']['offerID'] = 0;
                for ($i=0; $i < sizeof($freeUnits); $i++) {
                    $totalAmt = $freeUnits[$i]['freeUnit']['totalAmt'];
                    $unusedAmt = $freeUnits[$i]['freeUnit']['unusedAmt'];
                    $percentageFree = ($unusedAmt/$totalAmt)*100;
                    $indexDetailtOfferings = sizeof($freeUnits[$i]['detailOfferings']);
                    $indexDetailtOfferings = $indexDetailtOfferings-1;
                    $effectiveDate = ClientController::formatDateConsultUF($freeUnits[$i]['detailOfferings'][$indexDetailtOfferings]['effectiveDate']);
                    $expireDate = ClientController::formatDateConsultUF($freeUnits[$i]['detailOfferings'][$indexDetailtOfferings]['expireDate']);

                    if ($offer == '1709977001') {
                        if ($freeUnits[$i]['name'] == 'FU_Data_Altan-NR-IR_NA_CT') {
                            $data['consultUF']['offerID'] = $freeUnits[$i]['detailOfferings'][$indexDetailtOfferings]['offeringId'];
                            array_push($data['consultUF']['freeUnits']['nacionales'],array(
                                'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Datos Nacionales','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
                        }else if($freeUnits[$i]['name'] == 'FU_ThrMBB_Altan-RN_512kbps_P2'){
                            $data['consultUF']['offerID'] = $freeUnits[$i]['detailOfferings'][$indexDetailtOfferings]['offeringId'];
                            array_push($data['consultUF']['freeUnits']['nacionales'],array(
                                'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Datos Nacionales','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
                        }else if($freeUnits[$i]['name'] == 'FreeData_Altan-RN_P2'){
                            $data['consultUF']['offerID'] = $freeUnits[$i]['detailOfferings'][$indexDetailtOfferings]['offeringId'];
                            array_push($data['consultUF']['freeUnits']['nacionales'],array(
                                'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Datos Nacionales','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
                        }else if($freeUnits[$i]['name'] == 'FreeData_Altan-RN'){
                            $data['consultUF']['offerID'] = $freeUnits[$i]['detailOfferings'][$indexDetailtOfferings]['offeringId'];
                            array_push($data['consultUF']['freeUnits']['nacionales'],array(
                                'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Datos Nacionales','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_SMS_Altan-NR-LDI_NA'){
                            array_push($data['consultUF']['freeUnits']['nacionales'],array(
                                'totalAmt'=>$totalAmt,'unusedAmt'=>$unusedAmt,'freePercentage'=>$percentageFree,'name'=>'SMS Nacionales','description'=>'sms','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_Min_Altan-NR-LDI_NA'){
                            array_push($data['consultUF']['freeUnits']['nacionales'],array(
                                'totalAmt'=>$totalAmt,'unusedAmt'=>$unusedAmt,'freePercentage'=>$percentageFree,'name'=>'Minutos Nacionales','description'=>'min','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_Data_Altan-NR-IR_NA'){
                            array_push($data['consultUF']['freeUnits']['ri'],array(
                                'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Datos RI','description'=>'GB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_SMS_Altan-NR-IR-LDI_NA'){
                            array_push($data['consultUF']['freeUnits']['ri'],array(
                                'totalAmt'=>$totalAmt,'unusedAmt'=>$unusedAmt,'freePercentage'=>$percentageFree,'name'=>'SMS RI','description'=>'sms','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_Min_Altan-NR-IR-LDI_NA'){
                            array_push($data['consultUF']['freeUnits']['ri'],array(
                                'totalAmt'=>$totalAmt,'unusedAmt'=>$unusedAmt,'freePercentage'=>$percentageFree,'name'=>'Minutos RI','description'=>'min','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_Redirect_Altan-RN'){
                            array_push($data['consultUF']['freeUnits']['extra'],array(
                                'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Navegación en Portal Cautivo','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_ThrMBB_Altan-RN_512kbps'){
                            array_push($data['consultUF']['freeUnits']['extra'],array(
                                'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Velocidad Reducida','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }
                    }else{
                        if ($freeUnits[$i]['name'] == 'FU_Data_Altan-NR-IR_NA_CT') {
                            $data['consultUF']['offerID'] = $freeUnits[$i]['detailOfferings'][$indexDetailtOfferings]['offeringId'];
                            array_push($data['consultUF']['freeUnits']['nacionales'],array(
                                'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Datos Nacionales','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
                        }else if($freeUnits[$i]['name'] == 'FreeData_Altan-RN'){
                            $data['consultUF']['offerID'] = $freeUnits[$i]['detailOfferings'][$indexDetailtOfferings]['offeringId'];
                            array_push($data['consultUF']['freeUnits']['nacionales'],array(
                                'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Datos Nacionales','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_SMS_Altan-NR-LDI_NA'){
                            array_push($data['consultUF']['freeUnits']['nacionales'],array(
                                'totalAmt'=>$totalAmt,'unusedAmt'=>$unusedAmt,'freePercentage'=>$percentageFree,'name'=>'SMS Nacionales','description'=>'sms','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_Min_Altan-NR-LDI_NA'){
                            array_push($data['consultUF']['freeUnits']['nacionales'],array(
                                'totalAmt'=>$totalAmt,'unusedAmt'=>$unusedAmt,'freePercentage'=>$percentageFree,'name'=>'Minutos Nacionales','description'=>'min','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_Data_Altan-NR-IR_NA'){
                            array_push($data['consultUF']['freeUnits']['ri'],array(
                                'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Datos RI','description'=>'GB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_SMS_Altan-NR-IR-LDI_NA'){
                            array_push($data['consultUF']['freeUnits']['ri'],array(
                                'totalAmt'=>$totalAmt,'unusedAmt'=>$unusedAmt,'freePercentage'=>$percentageFree,'name'=>'SMS RI','description'=>'sms','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_Min_Altan-NR-IR-LDI_NA'){
                            array_push($data['consultUF']['freeUnits']['ri'],array(
                                'totalAmt'=>$totalAmt,'unusedAmt'=>$unusedAmt,'freePercentage'=>$percentageFree,'name'=>'Minutos RI','description'=>'min','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_Redirect_Altan-RN'){
                            array_push($data['consultUF']['freeUnits']['extra'],array(
                                'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Navegación en Portal Cautivo','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }else if($freeUnits[$i]['name'] == 'FU_ThrMBB_Altan-RN_512kbps'){
                            array_push($data['consultUF']['freeUnits']['extra'],array(
                                'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Velocidad Reducida','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                            ));
    
                        }
                    }
                    
                    
                    // else if($freeUnits[$i]['name'] == 'FU_Data_Altan-RN_RG18'){
                    //     array_push($data['consultUF']['freeUnits']['extra'],array('totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'no sabe','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate));
                    // }
                    // print_r($freeUnits[$i]['name'].'  --  ');
                    // print_r($freeUnits[$i]['freeUnit']['totalAmt'].'  --  ');
                    // print_r($freeUnits[$i]['freeUnit']['unusedAmt'].'<br>');
                    
                }

                if($data['consultUF']['offerID'] == 0){
                    $data['consultUF']['rate'] = 'PLAN NO CONTRATADO';    
                }else{
                    // return $data['consultUF']['offerID'];
                    $rateData = Offer::where('offerID',$offer)->first();
                    $data['consultUF']['rate'] = $rateData->name_second;
                }

                if($status == 'Active'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'activo',
                        'traffic_outbound_incoming' => 'activo',
                        'status_altan' => 'activo'
                    ]);
                }else if($status == 'Suspend (B2W)'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'activo',
                        'traffic_outbound_incoming' => 'inactivo',
                        'status_altan' => 'activo'
                    ]);
                }else if($status == 'Predeactivate'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'activo',
                        'traffic_outbound_incoming' => 'activo',
                        'status_altan' => 'predeactivate'
                    ]);
                }else if($status == 'Barring (B1W) (Notified by client)'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'inactivo',
                        'traffic_outbound_incoming' => 'activo',
                        'status_altan' => 'activo'
                    ]);
                }
            }

            // return $data['consultUF']['freeUnits'];

            $data['monthlies'] = DB::table('pays')
                           ->join('activations','activations.id','=','pays.activation_id')
                           ->leftJoin('references','references.reference_id','=','pays.reference_id')
                           ->where('activations.numbers_id',$number_id)
                           ->where('pays.status','completado')
                           ->select('pays.date_pay','pays.date_pay_limit','pays.amount_received AS amount','pays.type_pay AS type','references.reference AS reference','pays.updated_at AS date_paid')
                           ->get();
            
            $data['purchases'] = DB::table('purchases')
                            ->join('offers','offers.id','=','purchases.offer_id')
                            ->join('users','users.id','=','purchases.who_did_id')
                            ->where('purchases.number_id',$number_id)
                            ->select('purchases.date','purchases.reason','purchases.amount','purchases.comment','offers.name','users.name AS user_name','users.lastname AS user_lastname')
                            ->get();

            $data['referencePurchases'] = DB::table('references')
                                             ->join('channels','channels.id','=','references.channel_id')
                                             ->join('offers','offers.id','=','references.offer_id')
                                             ->leftJoin('users','users.id','=','references.user_id')
                                             ->where('references.number_id',$number_id)
                                             ->where('references.referencestype_id',5)
                                             ->where(function($query){
                                                 $query->where('references.status','paid')->orWhere('references.status','completed');
                                             })
                                             ->select('references.updated_at AS date','offers.name','references.amount','references.reference','users.name AS user_name','users.lastname AS user_lastname','channels.name AS channel','references.event_date_complete AS date_complete')
                                             ->get();

            $data['changes'] = DB::table('changes')
                                  ->join('offers','offers.id','=','changes.offer_id')
                                  ->join('rates','rates.id','=','changes.rate_id')
                                  ->leftJoin('users','users.id','=','changes.who_did_id')
                                  ->leftJoin('references','references.reference_id','=','changes.reference_id')
                                  ->leftJoin('channels','channels.id','=','references.channel_id')
                                  ->where('changes.status','completado')
                                  ->where('changes.number_id',$number_id)
                                  ->select('changes.date','rates.name AS rate','offers.name AS offer','changes.amount','references.reference','changes.reason','changes.comment','users.name AS user_name','users.lastname AS user_lastname','channels.name AS channel')
                                  ->get();

            $data['historics'] = DB::table('historics')
                                  ->join('numbers','numbers.id','=','historics.number_id')
                                  ->join('users','users.id','=','historics.who_did_id')
                                  ->where('historics.number_id',$number_id)
                                  ->select('historics.*','users.name AS user_name','users.lastname AS user_lastname')
                                  ->get();


        }else if($service == 'Conecta' || $service == 'Telmex'){
            $dataQuery = DB::table('instalations')
                            ->join('packs','packs.id','=','instalations.pack_id')
                            ->where('instalations.id',$id_act)
                            ->select('instalations.*','packs.name AS pack_name','packs.price AS pack_price')
                            ->get();
            
            $data['service'] = $service;
            $data['pack_name'] = $dataQuery[0]->pack_name;
            $data['pack_price'] = $dataQuery[0]->pack_price;
            $data['date_activation'] = $dataQuery[0]->date_instalation;
        }
        return view('clients.productDetails',$data);
    }

    public function create(){
        return view('clients.create');
    }

    public function store(Request $request){
        $time = time();
        $h = date("g", $time);
        
        $name = $request->post('name');
        $lastname = $request->post('lastname');
        $email = $request->post('email');
        $rfc = $request->post('rfc');
        $date_born = $request->post('date_born');
        $address = $request->post('address');
        $cellphone = $request->post('cellphone');
        $ine_code = $request->post('ine_code');
        $user_id = $request->post('user');
        $interests = $request->post('interests');
        
         if($email == null){
             $email = str_replace(' ', '', $name).date("YmdHis", $time);
         }

        $client = Client::where('email', $email)->exists();

        if($client){
            $error = 'El usuario con el email '.$email.' ya existe.';
            return back()->withInput()->withErrors([$error]);
        }
        
        Client::insert([
            'name' => $name,
            'lastname' => $lastname,
            'email' => $email,
            'password' => Hash::make('123456789'),
            'address' => $address,
            'ine_code' => $ine_code,
            'date_born' => $date_born,
            'rfc' => $rfc,
            'cellphone' => $cellphone,
            'who_did_id' => $user_id,
            'interests' => $interests
        ]);

        $success = 'Cliente añadido con éxito.';
        return back()->with('success', $success);
    }

    public function storeAsync(Request $request){
        $time = time();
        $h = date("g", $time);

        $name = $request->get('name');
        $lastname = $request->get('lastname');
        $email = $request->get('email');

        $rfc = $request->get('rfc');
        $date_born = $request->get('date_born');
        $address = $request->get('address');
        $cellphone = $request->get('cellphone');
        $ine_code = $request->get('ine_code');
        $user_id = $request->get('user_id');
        $interests = $request->post('interests');
        $date_created = date('Y-m-d');
        
         if($email == null){
             $email = str_replace(' ', '', $name).date("YmdHis", $time);
         }

        $x = User::where('email',$email)->exists();
        if($x){
            $error = 'El usuario con el email <strong>'.$email.'</strong> ya existe.';
            return response()->json(['error'=>1, 'message'=>$error]);
        }
        

        User::insert([
            'name' => $name,
            'lastname' => $lastname,
            'email' => $email,
            'password' => Hash::make('123456789')
        ]);

        $client_id = User::where('email',$email)->first();
        $client_id = $client_id->id;

        Client::insert([
            'address' => $address,
            'ine_code' => $ine_code,
            'date_born' => $date_born,
            'rfc' => $rfc,
            'cellphone' => $cellphone,
            'user_id' => $client_id,
            'who_did_id' => $user_id,
            'interests' => $interests,
            'date_created' => $date_created
        ]);

        $success = 'Cliente añadido con éxito.';
        return response()->json(['error'=>0,'message'=>$success]);
    }

    public function getNumberInstalation(Request $request){
        $id = $request->id;
        $type = $request->type;
        if ($type == 'activation') {
            $response = Activation::findOrFail($id);
        }else if($type == 'instalation'){
            $response = Instalation::findOrFail($id);
        }
        
        return $response;
    }

    public function setNumberInstalation(Request $request){
        $id = $request->id;
        $number = $request->number;
        $serial_number = $request->serial_number;
        $type = $request->type;
        
        // return $request;
        //TODO VALIDACION PARA UPDATE
        if ($type == 'instalation') {
            Instalation::where('id',$id)->update(['number'=>$number,'serial_number'=>$serial_number]);
        }else if($type == 'activation'){
            Activation::where('id',$id)->update(['serial_number'=>$serial_number]);
        }
        return 1;
    }

    public function prospects(){
        $news = DB::table('clients')
                        ->select('clients.*')
                        ->get();

        $newsMOV = DB::table('users')
                          ->leftJoin('activations','activations.client_id','=','users.id')
                          ->leftJoin('instalations','instalations.client_id','=','users.id')
                          ->join('clients','clients.user_id','=','users.id')
                          ->where('role_id',3)
                          ->where('activations.client_id',null)
                          ->where('instalations.client_id',null)
                          ->where('clients.interests','MOV')
                          ->select('users.id')
                          ->get();
        
        // $newsHBB = DB::table('users')
        //                   ->leftJoin('activations','activations.client_id','=','users.id')
        //                   ->leftJoin('instalations','instalations.client_id','=','users.id')
        //                   ->join('clients','clients.user_id','=','users.id')
        //                   ->where('role_id',3)
        //                   ->where('activations.client_id',null)
        //                   ->where('instalations.client_id',null)
        //                   ->where('clients.interests','HBB')
        //                   ->select('users.name','users.lastname','users.email','clients.address AS address','clients.cellphone AS phone','clients.who_did_id AS who_added','clients.interests AS interests')
        //                   ->get();

        $newsMIFI = DB::table('users')
                          ->leftJoin('activations','activations.client_id','=','users.id')
                          ->leftJoin('instalations','instalations.client_id','=','users.id')
                          ->join('clients','clients.user_id','=','users.id')
                          ->where('role_id',3)
                          ->where('activations.client_id',null)
                          ->where('instalations.client_id',null)
                          ->where('clients.interests','MIFI')
                          ->select('users.id')
                          ->get();
        
        $newsTelmex = DB::table('users')
                          ->leftJoin('activations','activations.client_id','=','users.id')
                          ->leftJoin('instalations','instalations.client_id','=','users.id')
                          ->join('clients','clients.user_id','=','users.id')
                          ->where('role_id',3)
                          ->where('activations.client_id',null)
                          ->where('instalations.client_id',null)
                          ->where('clients.interests','Portabilidad Telmex')
                          ->select('users.id')
                          ->get();

        $data['MOV'] = sizeof($newsMOV);
        $data['MIFI'] = sizeof($newsMIFI);
        $data['Telmex'] = sizeof($newsTelmex);
        $data['prospects'] = $news;
        return view('clients.prospects',$data);
    }

    public function getAllDataClient(Request $request){
        $id = $request->id;
        $dataClient = DB::table('clients')
                            ->where('clients.id', $id)
                            ->select('clients.*')
                            ->get();

        $id = $dataClient[0]->id;
        $name = $dataClient[0]->name;
        $lastname = $dataClient[0]->lastname;
        $email = $dataClient[0]->email;
        $address = $dataClient[0]->address;
        $ine_code = $dataClient[0]->ine_code;
        $rfc = $dataClient[0]->rfc;
        $cellphone = $dataClient[0]->cellphone;
        $date_born = $dataClient[0]->date_born;
        $who_did_id = $dataClient[0]->who_did_id;
        
        if($who_did_id == null){
            $who_did = 'ESTA PERSONA ES UN EMPLEADO';
        }else{
            $dataUser = User::where('id', $who_did_id)->first();
            $who_did = $dataUser->name.' '.$dataUser->lastname;
        }

        $response = array([
            'id' => $id,
            'name' => $name,
            'lastname' => $lastname,
            'email' => $email,
            'address' => $address,
            'ine_code' => $ine_code,
            'rfc' => $rfc,
            'cellphone' => $cellphone,
            'date_born' => $date_born,
            'who_did' => $who_did
        ]);

        return $response;
    }

    public function setAllDataClient(Request $request){
        $name = $request->post('name');
        $lastname = $request->post('lastname');
        $email = $request->post('email');
        $address = $request->post('address');
        $cellphone = $request->post('cellphone');
        $date_born = $request->post('date_born');
        $ine_code = $request->post('ine_code');
        $rfc = $request->post('rfc');
        $id = $request->post('id');

        $client = Client::where('id', $id);
        if($client->exists()){
            $client->update([
                'name' => $name,
                'lastname' => $lastname,
                'email' => $email,
                'address' => $address,
                'ine_code' => $ine_code,
                'rfc' => $rfc,
                'cellphone' => $cellphone,
                'date_born' => $date_born
            ]);
        }else{
            $client = Client::insert([
                'name' => $name,
                'lastname' => $lastname,
                'email' => $email,
                'address' => $address,
                'ine_code' => $ine_code,
                'rfc' => $rfc,
                'cellphone' => $cellphone,
                'date_born' => $date_born
            ]);
        }
        
        if($client){
            return 1;
        }else{
            return 0;
        }
        return 2;
    }

    public function exportNewClients(){
        return Excel::download(new NewclientsExport, 'new-clients.xlsx');
    }

    public function specialOperations(){
        $data['channels'] = Channel::all();
        $data['clients'] = DB::table('activations')
                              ->join('numbers','numbers.id','=','activations.numbers_id')
                              ->join('users','users.id','=','activations.client_id')
                              ->select('users.name AS name','users.lastname AS lastname','users.email AS email','numbers.MSISDN AS msisdn','numbers.producto AS producto')
                              ->get();
        return view('clients.specialsOperations',$data);
    }

    public function getInfoUF($msisdn){
        $bool = Number::where('MSISDN',$msisdn)->exists();

        if($bool){
            $numberData = Number::where('MSISDN',$msisdn)->first();
            $service = $numberData->producto;
            $number_id = $numberData->id;
            $service = trim($service);

            $consultUF = app('App\Http\Controllers\AltanController')->consultUF($msisdn);
            // return $consultUF;
            $responseSubscriber = $consultUF['responseSubscriber'];
            $information = $responseSubscriber['information'];
            $status = $responseSubscriber['status']['subStatus'];
            $freeUnits = $responseSubscriber['freeUnits'];

            $coordinates = $responseSubscriber['information']['coordinates'];
            $char = explode(',',$coordinates);

            if($service == 'HBB'){
                $lat_hbb = $char[0];
                $lng_hbb = $char[1];
            }else if($service == 'MIFI' || $service == 'MOV'){
                $lat_hbb = null;
                $lng_hbb = null;
            }

            $data = [];
            $data['status'] = $status;
            $data['imei'] = $information['IMEI'];
            $data['icc'] = $information['ICCID'];
            // return $status;
            if($status == 'Active'){
                $data['status_color'] = 'success';
            }else if($status == 'Suspend (B2W)' || $status == 'Barring (B1W) (Notified by client)'){
                $data['status_color'] = 'warning';
            }

            $data['service'] = $service;

            if($service == 'MIFI' || $service == 'HBB'){
                $data['FreeUnitsBoolean'] = 0;
                $data['FreeUnits2Boolean'] = 0;
                $data['consultUF']['offerID'] = 0;

                for ($i=0; $i < sizeof($freeUnits); $i++) {
                    if($freeUnits[$i]['name'] == 'Free Units' || $freeUnits[$i]['name'] == 'FU_Altan-RN'){
                        $totalAmt = $freeUnits[$i]['freeUnit']['totalAmt'];
                        $unusedAmt = $freeUnits[$i]['freeUnit']['unusedAmt'];
                        $percentageFree = ($unusedAmt/$totalAmt)*100;
                        $data['FreeUnits'] = array('totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree);
                        $data['FreeUnitsBoolean'] = 1;

                        $detailOfferings = $freeUnits[$i]['detailOfferings'];

                        $data['effectiveDatePrimary'] = ClientController::formatDateConsultUF($detailOfferings[0]['effectiveDate']);
                        $data['expireDatePrimary'] = ClientController::formatDateConsultUF($detailOfferings[0]['expireDate']);
                        $expire_date = $detailOfferings[0]['expireDate'];
                        $expire_date = substr($expire_date,0,8);

                        $data['consultUF']['offerID'] = $detailOfferings[0]['offeringId'];
                    }

                    if($freeUnits[$i]['name'] == 'Free Units 2' || $freeUnits[$i]['name'] == 'FU_Altan-RN_P2'){
                        $totalAmt = $freeUnits[$i]['freeUnit']['totalAmt'];
                        $unusedAmt = $freeUnits[$i]['freeUnit']['unusedAmt'];
                        $percentageFree = ($unusedAmt/$totalAmt)*100;
                        $data['FreeUnits2'] = array('totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree);
                        $data['FreeUnits2Boolean'] = 1;

                        $detailOfferings = $freeUnits[$i]['detailOfferings'];

                        $data['effectiveDateSurplus'] = ClientController::formatDateConsultUF($detailOfferings[0]['effectiveDate']);
                        $data['expireDateSurplus'] = ClientController::formatDateConsultUF($detailOfferings[0]['expireDate']);
                    }
                }

                $rateData = DB::table('numbers')
                                   ->leftJoin('activations','activations.numbers_id','=','numbers.id')
                                   ->leftJoin('rates','rates.id','=','activations.rate_id')
                                   ->where('numbers.MSISDN',$msisdn)
                                   ->select('rates.name AS rate_name')
                                   ->get();

                if($status == 'Suspend (B2W)'){
                    $data['consultUF']['rate'] = $rateData[0]->rate_name.'/Suspendido por falta de pago';    
                }else if($status == 'Active'){
                    $data['consultUF']['rate'] = $rateData[0]->rate_name;
                }

                if($status == 'Active'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'activo',
                        'traffic_outbound_incoming' => 'activo',
                        'status_altan' => 'activo'
                    ]);
    
                    if($service = 'MIFI'){
                        Activation::where('numbers_id',$number_id)->update(['expire_date'=>$expire_date]);
                    }
    
                    if($service = 'HBB'){
                        Activation::where('numbers_id',$number_id)->update(['expire_date'=>$expire_date,'lat_hbb'=>$lat_hbb,'lng_hbb'=>$lng_hbb]);
                    }
                }else if($status == 'Suspend (B2W)'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'activo',
                        'traffic_outbound_incoming' => 'inactivo',
                        'status_altan' => 'activo'
                    ]);
                    if($service = 'MIFI'){
                        Activation::where('numbers_id',$number_id)->update(['expire_date'=>$expire_date]);
                    }
                    if($service = 'HBB'){
                        Activation::where('numbers_id',$number_id)->update(['expire_date'=>$expire_date,'lat_hbb'=>$lat_hbb,'lng_hbb'=>$lng_hbb]);
                    }
                }else if($status == 'Predeactivate'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'activo',
                        'traffic_outbound_incoming' => 'activo',
                        'status_altan' => 'predeactivate'
                    ]);
                }else if($status == 'Barring (B1W) (Notified by client)'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'inactivo',
                        'traffic_outbound_incoming' => 'activo',
                        'status_altan' => 'activo'
                    ]);
                }

                if($data['FreeUnits2Boolean'] == 0){
                    $data['FreeUnits2'] = array('totalAmt'=>0,'unusedAmt'=>0,'freePercentage'=>0);
                    $data['effectiveDateSurplus'] = 'No se ha generado recarga.';
                    $data['expireDateSurplus'] = 'No se ha generado recarga.';
                }
            }else if($service == 'MOV'){
                $data['consultUF']['freeUnits']['extra'] = [];
                $data['consultUF']['freeUnits']['nacionales'] = [];
                $data['consultUF']['freeUnits']['ri'] = [];
                $data['consultUF']['offerID'] = 0;
                for ($i=0; $i < sizeof($freeUnits); $i++) {
                    $totalAmt = $freeUnits[$i]['freeUnit']['totalAmt'];
                    $unusedAmt = $freeUnits[$i]['freeUnit']['unusedAmt'];
                    $percentageFree = ($unusedAmt/$totalAmt)*100;
                    $indexDetailtOfferings = sizeof($freeUnits[$i]['detailOfferings']);
                    $indexDetailtOfferings = $indexDetailtOfferings-1;
                    $effectiveDate = ClientController::formatDateConsultUF($freeUnits[$i]['detailOfferings'][$indexDetailtOfferings]['effectiveDate']);
                    $expireDate = ClientController::formatDateConsultUF($freeUnits[$i]['detailOfferings'][$indexDetailtOfferings]['expireDate']);

                    if($freeUnits[$i]['name'] == 'FreeData_Altan-RN'){
                        $data['consultUF']['offerID'] = $freeUnits[$i]['detailOfferings'][$indexDetailtOfferings]['offeringId'];
                        array_push($data['consultUF']['freeUnits']['nacionales'],array(
                            'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Datos Nacionales','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                        ));

                    }else if($freeUnits[$i]['name'] == 'FU_SMS_Altan-NR-LDI_NA'){
                        array_push($data['consultUF']['freeUnits']['nacionales'],array(
                            'totalAmt'=>$totalAmt,'unusedAmt'=>$unusedAmt,'freePercentage'=>$percentageFree,'name'=>'SMS Nacionales','description'=>'sms','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                        ));

                    }else if($freeUnits[$i]['name'] == 'FU_Min_Altan-NR-LDI_NA'){
                        array_push($data['consultUF']['freeUnits']['nacionales'],array(
                            'totalAmt'=>$totalAmt,'unusedAmt'=>$unusedAmt,'freePercentage'=>$percentageFree,'name'=>'Minutos Nacionales','description'=>'min','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                        ));

                    }else if($freeUnits[$i]['name'] == 'FU_Data_Altan-NR-IR_NA'){
                        array_push($data['consultUF']['freeUnits']['ri'],array(
                            'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Datos RI','description'=>'GB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                        ));

                    }else if($freeUnits[$i]['name'] == 'FU_SMS_Altan-NR-IR-LDI_NA'){
                        array_push($data['consultUF']['freeUnits']['ri'],array(
                            'totalAmt'=>$totalAmt,'unusedAmt'=>$unusedAmt,'freePercentage'=>$percentageFree,'name'=>'SMS RI','description'=>'sms','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                        ));

                    }else if($freeUnits[$i]['name'] == 'FU_Min_Altan-NR-IR-LDI_NA'){
                        array_push($data['consultUF']['freeUnits']['ri'],array(
                            'totalAmt'=>$totalAmt,'unusedAmt'=>$unusedAmt,'freePercentage'=>$percentageFree,'name'=>'Minutos RI','description'=>'min','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                        ));

                    }else if($freeUnits[$i]['name'] == 'FU_Redirect_Altan-RN'){
                        array_push($data['consultUF']['freeUnits']['extra'],array(
                            'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Navegación en Portal Cautivo','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                        ));

                    }else if($freeUnits[$i]['name'] == 'FU_ThrMBB_Altan-RN_512kbps'){
                        array_push($data['consultUF']['freeUnits']['extra'],array(
                            'totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'Velocidad Reducida','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate
                        ));

                    }
                    // else if($freeUnits[$i]['name'] == 'FU_Data_Altan-RN_RG18'){
                    //     array_push($data['consultUF']['freeUnits']['extra'],array('totalAmt'=>$totalAmt/1024,'unusedAmt'=>$unusedAmt/1024,'freePercentage'=>$percentageFree,'name'=>'no sabe','description'=>'MB','effectiveDate'=>$effectiveDate,'expireDate'=>$expireDate));

                    // }
                    // print_r($freeUnits[$i]['name'].'  --  ');
                    // print_r($freeUnits[$i]['freeUnit']['totalAmt'].'  --  ');
                    // print_r($freeUnits[$i]['freeUnit']['unusedAmt'].'<br>');
                    
                }

                if($data['consultUF']['offerID'] == 0){
                    $data['consultUF']['rate'] = 'PLAN NO CONTRATADO';    
                }else{
                    $rateData = Offer::where('offerID_second',$data['consultUF']['offerID'])->first();
                    $data['consultUF']['rate'] = $rateData->name_second;
                }

                if($status == 'Active'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'activo',
                        'traffic_outbound_incoming' => 'activo',
                        'status_altan' => 'activo'
                    ]);
                }else if($status == 'Suspend (B2W)'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'activo',
                        'traffic_outbound_incoming' => 'inactivo',
                        'status_altan' => 'activo'
                    ]);
                }else if($status == 'Predeactivate'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'activo',
                        'traffic_outbound_incoming' => 'activo',
                        'status_altan' => 'predeactivate'
                    ]);
                }else if($status == 'Barring (B1W) (Notified by client)'){
                    Number::where('id',$number_id)->update([
                        'traffic_outbound' => 'inactivo',
                        'traffic_outbound_incoming' => 'activo',
                        'status_altan' => 'activo'
                    ]);
                }
            }

            return view('clients.consumptions',$data);
        }else{
            return view('layouts.404');
        }
    }

    public function formatDateConsultUF($date){
        $year = substr($date,0,4);
        $month = substr($date,4,2);
        $day = substr($date,6,2);
        $hour = substr($date,8,2);
        $minute = substr($date,10,2);
        $second = substr($date,12,2);
        $date = $day.'-'.$month.'-'.$year.' '.$hour.':'.$minute.':'.$second;
        return $date;
    }

    public function getDataClientChangeProduct(Request $request){
        $msisdn = $request->get('msisdn');

        $response = DB::table('numbers')
                       ->join('activations','activations.numbers_id','=','numbers.id')
                       ->join('users','users.id','=','activations.client_id')
                       ->join('clients','clients.user_id','=','users.id')
                       ->where('MSISDN',$msisdn)
                       ->select('users.name AS name','users.lastname AS lastname',
                       'users.email AS email','clients.cellphone AS cellphone',
                       'users.id AS client_id','numbers.id AS number_id')
                       ->get();

        $response = $response[0];
        return response()->json($response);
    }

    public function getDataClientBySIM(Request $request){
        $number_id = $request->get('number_id');

        $response = DB::table('numbers')
                       ->join('activations','activations.numbers_id','=','numbers.id')
                       ->join('clients','clients.id','=','activations.client_id')
                    //    ->join('clients','clients.user_id','=','clients.id')
                       ->where('numbers.id',$number_id)
                       ->select('clients.name AS name','clients.lastname AS lastname',
                       'clients.email AS email','clients.cellphone AS cellphone',
                       'clients.id AS client_id','numbers.id AS number_id')
                       ->get();

        $response = $response[0];
        return response()->json($response);
    }

    public function reports(Request $request){
        $data['clients'] = DB::table('clients')
                              ->join('activations','activations.client_id','=','clients.id')
                              ->join('numbers','numbers.id','=','activations.numbers_id')
                              ->join('rates','rates.id','=','activations.rate_id')
                              ->leftJoin('devices','devices.id','=','activations.devices_id')
                            //   ->leftJoin('clients','clients.user_id','=','clients.id')
                              ->select('clients.name AS name','clients.lastname AS lastname',
                              'clients.cellphone AS cellphone','numbers.MSISDN AS MSISDN',
                              'numbers.producto AS service','devices.no_serie_imei AS imei',
                              'rates.name AS rate_name','rates.price_subsequent AS amount_rate','activations.date_activation AS date_activation','activations.amount_device AS amount_device')
                              ->get();
        return view('clients.reports', $data);
    }

    public function consumos(Request $request){
        $type = $request['type'];
        $num = $request['msisdn'];
        $msisdn= '52'.$num;
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $ano = substr($date_start, -4);
        $mes = substr($date_start, 0,2);
        $dia = substr($date_start, 3, -5);
        $dateStart = $ano. '-'. $mes.'-'.$dia;
        $anoEnd = substr($date_end, -4);
        $mesEnd = substr($date_end, 0,2);
        $diaEnd = substr($date_end, 3, -5);
        $dateEnd = $anoEnd. '-'. $mesEnd.'-'.$diaEnd;

        // return $dateStart.'  -  '.$dateEnd;
        // $consumos = DB::select("CALL sftp_altan.consumos_datos('".$msisdn."','".$dateStart."','".$dateEnd."')");
        if ($type == 'datosIndividual') {
            $group = 'individual';
            $consumos = DB::connection('cdrs')->select("SELECT CUST_LOCAL_START_DATE AS START_DATE, (((SUM(CHG_AMOUNT)/1024)/1024)/1024) AS consumos, 'GB' AS UNIDAD FROM datos WHERE PRI_IDENTITY = ? AND CUST_LOCAL_START_DATE BETWEEN ? AND ? GROUP BY CUST_LOCAL_START_DATE",[$msisdn,$dateStart,$dateEnd]);
            // $consumos = DB::select("CALL sftp_altan.consumos_datos('".$msisdn."','".$dateStart."','".$dateEnd."')");
            $data = [$group, $consumos];
            return $data;
        }elseif ($type == 'datosgeneral') {
            $group = 'general';
            $consumos = DB::connection('cdrs')->select("SELECT PRI_IDENTITY, CUST_LOCAL_START_DATE AS START_DATE, (((SUM(CHG_AMOUNT)/1024)/1024)/1024) AS consumos, 'GB' AS UNIDAD FROM datos WHERE CUST_LOCAL_START_DATE BETWEEN ? AND ? GROUP BY START_DATE, PRI_IDENTITY",[$dateStart,$dateEnd]);
            // $consumos = DB::select("CALL sftp_altan.consumos_datos_general('".$dateStart."','".$dateEnd."')");
            $data = [$group, $consumos];
            return $data;
        }elseif ($type == 'smsIndividual') {
            $group = 'individual';
            $consumos = DB::connection('cdrs')->select("SELECT CUST_LOCAL_START_DATE AS START_DATE, SUM(CHG_AMOUNT) AS consumos, 'SMS' AS UNIDAD FROM sms WHERE PRI_IDENTITY = ? AND CUST_LOCAL_START_DATE BETWEEN ? AND ? GROUP BY CUST_LOCAL_START_DATE",[$msisdn,$dateStart,$dateEnd]);
            // $consumos = DB::select("CALL sftp_altan.consumos_sms('".$msisdn."','".$dateStart."','".$dateEnd."')");
            $data = [$group, $consumos];
            return $data;
        }elseif ($type == 'smsGeneral') {
            $group = 'general';
            $consumos = DB::connection('cdrs')->select("SELECT PRI_IDENTITY, CUST_LOCAL_START_DATE AS START_DATE, SUM(CHG_AMOUNT) AS consumos, 'SMS' AS UNIDAD FROM sms WHERE CUST_LOCAL_START_DATE BETWEEN ? AND ? GROUP BY START_DATE, PRI_IDENTITY",[$dateStart,$dateEnd]);
            // $consumos = DB::select("CALL sftp_altan.consumos_sms_general('".$dateStart."','".$dateEnd."')");
            $data = [$group, $consumos];
            return $data;
        }elseif ($type == 'minIndividual') {
            $group = 'individual';
            $consumos = DB::connection('cdrs')->select("SELECT CUST_LOCAL_START_DATE AS START_DATE, SUM(CHG_AMOUNT) AS consumos, 'Min' AS UNIDAD FROM voz WHERE PRI_IDENTITY = ? AND CUST_LOCAL_START_DATE BETWEEN ? AND ? GROUP BY CUST_LOCAL_START_DATE",[$msisdn,$dateStart,$dateEnd]);
            // $consumos = DB::select("CALL sftp_altan.consumos_voz('".$msisdn."','".$dateStart."','".$dateEnd."')");
            $data = [$group, $consumos];
            return $data;
        }elseif ($type == 'minGeneral') {
            $group = 'general';
            $consumos = DB::connection('cdrs')->select("SELECT PRI_IDENTITY, CUST_LOCAL_START_DATE AS START_DATE, SUM(CHG_AMOUNT) AS consumos, 'Min' AS UNIDAD FROM voz WHERE CUST_LOCAL_START_DATE BETWEEN ? AND ? GROUP BY START_DATE, PRI_IDENTITY",[$dateStart,$dateEnd]);
            // $consumos = DB::select("CALL sftp_altan.consumos_voz_general('".$dateStart."','".$dateEnd."')");
            $data = [$group, $consumos];
            return $data;
        }elseif ($type == 'datosAnual') {
            $group = 'general';
            $consumos = DB::select("CALL sftp_altan.consumos_datos_monthly('".$dateStart."','".$dateEnd."')");
            $data = [$group, $consumos];
            return $data;
        }

    }

    public function exportConsumos(Request $request){
        $msisdn = $request['MSISDN'];
        
        
        $data = [
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'MSISDN' => $request->get('MSISDN'),
            'type'=>$request->get('type')
        ];
        // return $data;
        return Excel::download(new ConsumosExport($data), 'Consumos_'.$msisdn.'.xlsx');
    }

    public function exportConsumosGeneral(Request $request){
        $date_start = $request['start_dateG'];
        $date_end = $request['end_dateG'];
        $año = substr($date_start, -4);
        $mes = substr($date_start, 0,2);
        $dia = substr($date_start, 3, -5);
        $dateStart = $año. '_'. $mes.'_'.$dia;
        $añoEnd = substr($date_end, -4);
        $mesEnd = substr($date_end, 0,2);
        $diaEnd = substr($date_end, 3, -5);
        $dateEnd = $añoEnd. '_'. $mesEnd.'_'.$diaEnd;
        $data = [
            'start_date' => $request->get('start_dateG'),
            'end_date' => $request->get('end_dateG'),
            'type' => $request->get('type')
        ];
        // return $data;
        return Excel::download(new ConsumosGeneralExport($data), 'ConsumosGeneral_'.$dateStart.'-'.$dateEnd.'.xlsx');
    }

    public function reportsActivations(Request $request){
        $type = $request['type'];
        $date_start = $request['start'];
        $date_end = $request['end'];
        $año = substr($date_start, -4);
        $mes = substr($date_start, 0,2);
        $dia = substr($date_start, 3, -5);
        $dateStart = $año. '_'. $mes.'_'.$dia;
        $añoEnd = substr($date_end, -4);
        $mesEnd = substr($date_end, 0,2);
        $diaEnd = substr($date_end, 3, -5);
        $dateEnd = $añoEnd. '_'. $mesEnd.'_'.$diaEnd;
        $data = [
            'start_date' => $request->get('start'),
            'end_date' => $request->get('end'),
            'type'=> $request->get('type')
        ];
        // return $data;

        if ($type == 'general') {
            return Excel::download(new ReportsActivations($data), 'Reportes_Activaciones_General_'.$dateStart.'-'.$dateEnd.'.xlsx');
        }else{
            return Excel::download(new ReportsActivations($data), 'Reportes_Activaciones_'.$type.'_'.$dateStart.'-'.$dateEnd.'.xlsx');
        }
    }

    public function reportMoney(Request $request){
        return view('clients.reportMoney');
    }

    public function consultMoney(Request $request){
        $type = $request['type'];
        $date_start = $request['start'];
        $date_end = $request['end'];

        $año = substr($date_start, -4);
        $mes = substr($date_start, 0,2);
        $dia = substr($date_start, 3, -5);
        $dateStart = $año. '_'. $mes.'_'.$dia;
        $añoEnd = substr($date_end, -4);
        $mesEnd = substr($date_end, 0,2);
        $diaEnd = substr($date_end, 3, -5);
        $dateEnd = $añoEnd. '_'. $mesEnd.'_'.$diaEnd;

        if ($type == 'activations') {
            $data = DB::table('activations_cash')->whereBetween('date_activation',[$dateStart,$dateEnd])->get();
            return $data;
        }elseif ($type == 'change') {
            $data = DB::table('changes_dayli')->whereBetween('fecha',[$dateStart,$dateEnd])->get();
            return $data;
        }elseif ($type == 'monthly') {
            $data = DB::table('monthly_payments_dayli')->whereBetween('fecha',[$dateStart,$dateEnd])->get();
            return $data;
        }elseif ($type == 'reference') {
            $data = DB::table('surplus_reference_payments_dayli')->whereBetween('fecha',[$dateStart,$dateEnd])->get();
            return $data;
        }elseif ($type == 'purchases') {
            $data = DB::table('purchases_dayli')->whereBetween('fecha',[$dateStart,$dateEnd])->get();
            return $data;
        }
    }

    public function exportReportMoney(Request $request){
        $type = $request['type'];
        $date_start = $request['start'];
        $date_end = $request['end'];
        $año = substr($date_start, -4);
        $mes = substr($date_start, 0,2);
        $dia = substr($date_start, 3, -5);
        $dateStart = $año. '-'. $mes.'-'.$dia;
        $añoEnd = substr($date_end, -4);
        $mesEnd = substr($date_end, 0,2);
        $diaEnd = substr($date_end, 3, -5);
        $dateEnd = $añoEnd. '-'. $mesEnd.'-'.$diaEnd;

        $data = [
            'start'=>$dateStart,
            'end'=>$dateEnd,
            'type'=>$type
        ];

        if ($type == 'activations') {
            return Excel::download(new ReportsPaymentsActivations($data), 'Reportes_Pagos_'.$type.'_'.$dateStart.'-'.$dateEnd.'.xlsx');
        }elseif ($type == 'change') {
            return Excel::download(new ReportsPaymentsChange($data), 'Reportes_Pagos_'.$type.'_'.$dateStart.'-'.$dateEnd.'.xlsx');
        }elseif ($type == 'monthly') {
            return Excel::download(new ReportsPaymentsMonthly($data), 'Reportes_Pagos_'.$type.'_'.$dateStart.'-'.$dateEnd.'.xlsx');
        }elseif ($type == 'reference') {
            return Excel::download(new ReportsPaymentsReferences($data), 'Reportes_Pagos_'.$type.'_'.$dateStart.'-'.$dateEnd.'.xlsx');
        }elseif ($type == 'purchases') {
            return Excel::download(new ReportsPaymentsPurchases($data), 'Reportes_Pagos_'.$type.'_'.$dateStart.'-'.$dateEnd.'.xlsx');
        }
    }

    public function searchMoralPerson(Request $request){
        $id = $request->get('id');
        $id = $id[0];

        $x = DB::table('clientssons')->where('user_id',$id)->select('clientssons.*')->get();
        return $x;
    }

    public function findClientSon(Request $request){
        $client_id = $request->get('client_id');
        $data = [];
        $clientssons = Clientsson::all()->where('user_id',$client_id);

        foreach ($clientssons as $clientsson) {
            array_push($data,array(
                'id' => $clientsson->id,
                'name' => $clientsson->name,
                'lastname' => $clientsson->lastname,
            ));
        }
        
        return $data;
    }

    public function unbarring(Request $request){
        $payID = $request->get('payID');
        $dataPayment = Pay::where('id',$payID)->first();
        $activation_id = $dataPayment->activation_id;
        $dataActivation = Activation::where('id',$activation_id)->first();
        $number_id = $dataActivation->numbers_id;
        $dataNumber = Number::where('id',$number_id)->first();
    
        $msisdn = $dataNumber->MSISDN;
        $producto = $dataNumber->producto;
        $producto = trim($producto);

        $consultUF = app('App\Http\Controllers\AltanController')->consultUF($msisdn);
        $responseSubscriber = $consultUF['responseSubscriber'];
        $status = $responseSubscriber['status']['subStatus'];
        $bool = 0;
        
        if($status == "Suspend (B2W)"){
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post('http://10.44.0.70/activate-deactivate/DN-api',[
                'msisdn' => $msisdn,
                'type' => 'out_in',
                'status' => 'inactivo'
            ]);
            $bool = $response['bool'];
        }else{
            $bool = 1;
        }

        if($bool == 1){
            if($producto == 'MIFI' || $producto == ' HBB'){
                Number::where('id',$number_id)->update(['traffic_outbound_incoming'=>'activo']);
            }
        }

        return $bool;

    }

    public function reportLinePorta(Request $request){
        if(isset($request['start']) && isset($request['end'])){
            if($request['start'] != null && $request['end'] != null){
                $product = $request->type;
                $date_start = $request['start'];
                $date_end = $request['end'];
                $año = substr($date_start, -4);
                $mes = substr($date_start, 0,2);
                $dia = substr($date_start, 3, -5);
                $dateStart = $año. '-'. $mes.'-'.$dia;
                $añoEnd = substr($date_end, -4);
                $mesEnd = substr($date_end, 0,2);
                $diaEnd = substr($date_end, 3, -5);
                $dateEnd = $añoEnd. '-'. $mesEnd.'-'.$diaEnd;

                if ($product == 'New') {
                    // $data['linesNews'] = DB::connection('corp_pos')->table('ra_activations')->leftJoin('ra_users','ra_users.id','=','ra_activations.distribuidor_id')->where('ra_activations.tipo', 'activacion')->whereBetween('ra_activations.date',[$dateStart,$dateEnd])->where('ra_activations.product', 'MOV')->select('ra_activations.*','ra_users.username','ra_users.first_name','ra_users.last_name','ra_users.wholesaler')->get();
                    $data['linesNews'] = [];
                    $completeds = Portability::all();
                    $arrayCompleted = [];


                    foreach ($completeds as $completed) {
                        $who_did_it = User::where('id',$completed->who_did_it)->first();
                        $who_attended = User::where('id',$completed->who_attended)->first();
                        $client = User::where('id',$completed->client_id)->first();
                        $client_data = Client::where('user_id',$completed->client_id)->first();
                        // return $client_data->address;
                        $rate = Rate::where('id','=',$completed->rate_id)->first();
                        array_push($arrayCompleted,array(
                            'msisdnPorted' => $completed->msisdnPorted,
                            'icc' => $completed->icc,
                            'msisdnTransitory' => $completed->msisdnTransitory,
                            'date' => $completed->date,
                            'approvedDateABD' => $completed->approvedDateABD,
                            'nip' => $completed->nip,
                            'client' => $client->name.' '.$client->lastname,
                            'who_did_it' => $completed->dealer_username == null ? 'N/A' : $completed->dealer_username,
                            'who_attended' => $who_attended = $who_attended == null ? 'N/A' : $who_attended->name.' '.$who_attended->lastname,
                            'name_rate' => $rate->name,
                            'amount' => number_format($rate->price,2)
                        ));
                    }
                    $data['portabilitys'] = $arrayCompleted;
                    return view('clients.lineNewPort', $data);

                }else if ($product == 'Porta') {
                    // $data['linesNews'] = DB::connection('corp_pos')->table('ra_activations')->leftJoin('ra_users','ra_users.id','=','ra_activations.distribuidor_id')->where('ra_activations.tipo', 'activacion')->where('ra_activations.product', 'MOV')->select('ra_activations.*','ra_users.username','ra_users.first_name','ra_users.last_name','ra_users.wholesaler')->get();
                    $data['linesNews'] = [];
                    $completeds = Portability::all()->whereBetween('created_at',[$dateStart,$dateEnd]);
                    $arrayCompleted = [];

                    foreach ($completeds as $completed) {
                        $who_did_it = User::where('id',$completed->who_did_it)->first();
                        $who_attended = User::where('id',$completed->who_attended)->first();
                        $client = User::where('id',$completed->client_id)->first();
                        $client_data = Client::where('user_id',$completed->client_id)->first();
                        // return $client_data->address;
                        $rate = Rate::where('id','=',$completed->rate_id)->first();
                        array_push($arrayCompleted,array(
                            'msisdnPorted' => $completed->msisdnPorted,
                            'icc' => $completed->icc,
                            'msisdnTransitory' => $completed->msisdnTransitory,
                            'date' => $completed->date,
                            'approvedDateABD' => $completed->approvedDateABD,
                            'nip' => $completed->nip,
                            'client' => $client->name.' '.$client->lastname,
                            'who_did_it' => $completed->dealer_username == null ? 'N/A' : $completed->dealer_username,
                            'who_attended' => $who_attended = $who_attended == null ? 'N/A' : $who_attended->name.' '.$who_attended->lastname,
                            'name_rate' => $rate->name,
                            'amount' => number_format($rate->price,2)
                        ));
                    }
                    $data['portabilitys'] = $arrayCompleted;
                    return view('clients.lineNewPort', $data);
                }
            }
        }else{
            $completeds = Portability::all();
            // return $completeds;
            // $data['linesNews'] = DB::connection('corp_pos')->table('ra_activations')->leftJoin('ra_users','ra_users.id','=','ra_activations.distribuidor_id')->where('ra_activations.tipo', 'activacion')->where('ra_activations.product', 'MOV')->select('ra_activations.*','ra_users.username','ra_users.first_name','ra_users.last_name','ra_users.wholesaler')->get();
            // return $data['linesNews'];
            $data['linesNews'] = [];
            $arrayCompleted = [];


            foreach ($completeds as $completed) {
                $who_did_it = User::where('id',$completed->who_did_it)->first();
                $who_attended = User::where('id',$completed->who_attended)->first();
                $client = User::where('id',$completed->client_id)->first();
                $client_data = Client::where('user_id',$completed->client_id)->first();
                // return $client_data->address;
                $rate = Rate::where('id','=',$completed->rate_id)->first();
                array_push($arrayCompleted,array(
                    'msisdnPorted' => $completed->msisdnPorted,
                    'icc' => $completed->icc,
                    'msisdnTransitory' => $completed->msisdnTransitory,
                    'date' => $completed->date,
                    'approvedDateABD' => $completed->approvedDateABD,
                    'nip' => $completed->nip,
                    'client' => $client->name.' '.$client->lastname,
                    'who_did_it' => $completed->dealer_username == null ? 'N/A' : $completed->dealer_username,
                    'who_attended' => $who_attended = $who_attended == null ? 'N/A' : $who_attended->name.' '.$who_attended->lastname,
                    'name_rate' => $rate->name,
                    'amount' => number_format($rate->price,2)
                ));
            }
            $data['portabilitys'] = $arrayCompleted;
            // return $data['completeds'];

            return view('clients.lineNewPort', $data);
        }
                
    }

    public function preRegistro(){
        return view('clients.preRegistro');
    }

    public function reportsConsumoVeracruz(){
        return view('clients.reportsVeracruz');
    }

    public function getConsumoVeracruz(Request $request){
        $type = $request['type'];
        $num = $request['msisdn'];
        $msisdn= '52'.$num;
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $ano = substr($date_start, -4);
        $mes = substr($date_start, 0,2);
        $dia = substr($date_start, 3, -5);
        $dateStart = $ano. '-'. $mes.'-'.$dia;
        $anoEnd = substr($date_end, -4);
        $mesEnd = substr($date_end, 0,2);
        $diaEnd = substr($date_end, 3, -5);
        $dateEnd = $anoEnd. '-'. $mesEnd.'-'.$diaEnd;

        $veracruzServices = DB::table('portabilities')
                                ->selectRaw('numbers.MSISDN')
                                ->join('numbers','portabilities.icc', '=', 'numbers.icc_id')
                                ->join('activations','numbers.id', '=', 'activations.numbers_id')
                                ->whereRaw('portabilities.dealer_username LIKE "%promotor%"')
                                ->get();
        $array_msisdn = [];

        foreach ($veracruzServices as $msisdn) {
            array_push($array_msisdn, "52".$msisdn->MSISDN);
        }

        if ($type == 'datosgeneral') {
            $group = 'general';
            $consumos = DB::connection('cdrs')->table('datos')
                                              ->selectRaw("PRI_IDENTITY, CUST_LOCAL_START_DATE AS START_DATE, (SUM(CHG_AMOUNT)/1024) AS consumos, 'MB' AS UNIDAD")
                                              ->whereRaw("PRI_IDENTITY IN (".implode(", ", $array_msisdn).")")
                                              ->whereBetween('CUST_LOCAL_START_DATE', [ $dateStart, $dateEnd ])
                                              ->groupBy('START_DATE', 'PRI_IDENTITY')
                                              ->get();
            $data = [$group, $consumos];
            return $data;
        }elseif ($type == 'smsGeneral') {
            $group = 'general';
            $consumos = DB::connection('cdrs')->table('sms')
                                              ->selectRaw("PRI_IDENTITY, CUST_LOCAL_START_DATE AS START_DATE, SUM(CHG_AMOUNT) AS consumos, 'SMS' AS UNIDAD")
                                              ->whereRaw("PRI_IDENTITY IN (".implode(", ", $array_msisdn).")")
                                              ->whereBetween('CUST_LOCAL_START_DATE', [ $dateStart, $dateEnd ])
                                              ->groupBy('START_DATE', 'PRI_IDENTITY')
                                              ->get();
            // $consumos = DB::connection('cdrs')->select("SELECT PRI_IDENTITY, CUST_LOCAL_START_DATE AS START_DATE, SUM(CHG_AMOUNT) AS consumos, 'SMS' AS UNIDAD FROM sms WHERE CUST_LOCAL_START_DATE BETWEEN ? AND ? GROUP BY START_DATE, PRI_IDENTITY",[$dateStart,$dateEnd]);
            $data = [$group, $consumos];
            return $data;
        }elseif ($type == 'minGeneral') {
            $group = 'general';
            $consumos = DB::connection('cdrs')->table('voz')
                                              ->selectRaw("PRI_IDENTITY, CUST_LOCAL_START_DATE AS START_DATE, SUM(CHG_AMOUNT) AS consumos, 'Min' AS UNIDAD")
                                              ->whereRaw("PRI_IDENTITY IN (".implode(", ", $array_msisdn).")")
                                              ->whereBetween('CUST_LOCAL_START_DATE', [ $dateStart, $dateEnd ])
                                              ->groupBy('START_DATE', 'PRI_IDENTITY')
                                              ->get();
            // $consumos = DB::connection('cdrs')->select("SELECT PRI_IDENTITY, CUST_LOCAL_START_DATE AS START_DATE, SUM(CHG_AMOUNT) AS consumos, 'Min' AS UNIDAD FROM voz WHERE CUST_LOCAL_START_DATE BETWEEN ? AND ? GROUP BY START_DATE, PRI_IDENTITY",[$dateStart,$dateEnd]);
            $data = [$group, $consumos];
            return $data;
        }

    }
    public function rechargeVeracruz(){
        $veracruzServices = DB::table('portabilities')                                
                                ->join('numbers','portabilities.icc', '=', 'numbers.icc_id')
                                ->join('activations','numbers.id', '=', 'activations.numbers_id')
                                ->whereRaw('portabilities.dealer_username LIKE "%promotor%"')
                                ->select('numbers.id AS id')
                                ->get();
        $veracruzServices = [];      
        $array_veracruz = [];

        foreach ($veracruzServices as $number) {
            array_push($array_veracruz, $number->id);
        }

        // $data['data'] = DB::table('purchases')->join('offers','offers.id','=','purchases.offer_id')
        //                                       ->join('users','users.id','=','purchases.who_did_id')
        //                                       ->join('numbers','numbers.id','=','purchases.number_id')
        //                                       ->whereRaw("purchases.number_id IN (".implode(", ", $array_veracruz).")")
        //                                       ->select('numbers.MSISDN', 'purchases.date','purchases.reason','purchases.amount','purchases.comment','offers.name','users.name AS user_name','users.lastname AS user_lastname')
        //                                       ->get();
        $data['data'] = [];
        // return view('clients.rechargeCliens', $data);

        // $data['referencePurchases'] = DB::table('references')
        //                                     ->join('channels','channels.id','=','references.channel_id')
        //                                     ->join('offers','offers.id','=','references.offer_id')
        //                                     ->join('numbers','numbers.id','=','references.number_id')
        //                                     ->leftJoin('users','users.id','=','references.user_id')
        //                                     ->whereRaw("references.number_id IN (".implode(", ", $array_veracruz).")")
        //                                     ->where('references.referencestype_id',5)
        //                                     ->where(function($query){
        //                                         $query->where('references.status','paid')->orWhere('references.status','completed');
        //                                     })
        //                                     ->select('numbers.MSISDN','references.updated_at AS date','offers.name','references.amount','references.reference','users.name AS user_name','users.lastname AS user_lastname','channels.name AS channel','references.event_date_complete AS date_complete')
        //                                     ->get();
        $data['referencePurchases'] = [];

                                            
        return view('clients.rechargeCliens', $data);

    }

    public function createClient(Request $request){
        $name = $request->get('name');
        $lastname = $request->get('lastname');
        $address = $request->get('address');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $rfc = $request->get('rfc');
        $date_born = $request->get('date_born');

        $x = Client::insert([
            'name' => $name,
            'lastname' => $lastname,
            'email' => $email,
            'address' => $address,
            'rfc' => $rfc,
            'date_born' => $date_born,
            'cellphone' => $phone
        ]);
        return $x;
    }
}
