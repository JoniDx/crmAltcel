<?php

namespace App\Http\Controllers;

use DB;
use App\Pay;
use App\Pack;
use App\Rate;
use App\User;
use DateTime;
use App\Offer;
use App\Client;
use App\Device;
use App\Number;
use App\Petition;
use App\Schedule;
use App\Promotion;
use App\Radiobase;
use App\Activation;
use App\Assignment;
use App\Clientsson;
use App\GuzzleHttp;
use App\Ethernetpay;
use App\Instalation;
use App\Simexternal;
use App\Deactivation;
use App\Mail\SendAccess;
use App\Numberstemporarie;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ActivationController extends Controller
{
    public function index(Request $request){
        if(isset($request['start']) && isset($request['end'])){
            if($request['start'] != null && $request['end'] != null){
                $year =  substr($request['start'], 6, 4);
                $month = substr($request['start'], 0, 2);
                $day = substr($request['start'], 3, 2);
                $date_init = $year.'-'.$month.'-'.$day;

                $year =  substr($request['end'], 6, 4);
                $month = substr($request['end'], 0, 2);
                $day = substr($request['end'], 3, 2);
                $date_final = $year.'-'.$month.'-'.$day;

                // return $date_init.' y '.$date_final;
            }else{
                
                $date_final = date('Y-m-d');
                $date_init = strtotime('-30 days', strtotime($date_final));
                $date_init = date('Y-m-d', $date_init);
            }
        }else{
            $date_final = 'none';
            $date_init = 'none';
        }

        $data = $this->indexFilter($date_init, $date_final);
        $data['date_init'] = $date_init;
        $data['date_final'] = $date_final;
        $current_role = auth()->user()->role_id;
        // return $date_init.' - '.$date_final;
        return view('activations.index', $data);
    }

    public function create(Request $request){
        if(isset($request['from'])){
            $data['name'] = $request->get('name');
            $data['lastname'] = $request->get('lastname');
            $data['rfc'] = $request->get('rfc');
            $data['date_born'] = $request->get('date_born');
            $data['address'] = $request->get('address');
            $data['email'] = $request->get('email');
            $data['ine_code'] = $request->get('ine_code');
            $data['cellphone'] = $request->get('cellphone');
            $data['petition'] = $request->get('petition');
            $data['lada'] = $request->get('lada');
            $data['icc'] = $request->get('icc');
            $data['imei'] = $request->get('imei');
            $data['no_serie'] = $request->get('no_serie');
            $data['mac'] = $request->get('mac');
            $data['rate_name'] = $request->get('rate_name');
            $data['rate_id'] = $request->get('rate_id');


            if($data['mac'] == "N/A" || $data['no_serie'] == "N/A" || $data['imei'] == "N/A"){
                $data['mac'] = '';
                $data['imei'] = '';
                $data['no_serie'] = '';

            }

            // return $request;
            $petitionData = Petition::where('id',$data['petition'])->first();
            // return $petitionData;
            $rate_activation_id = $petitionData->rate_activation;
            $rate_secondary_id = $petitionData->rate_secondary;

            $data['flag_rate'] = $rate_activation_id == $rate_secondary_id ? 1 : 0;

            $rateData = Rate::where('id',$rate_activation_id)->first();
            $data['rate_activation'] = $rateData->name;
            $data['rate_subsequent'] = $rate_secondary_id;
        }else{
            $data['name'] = '';
            $data['lastname'] = '';
            $data['rfc'] = '';
            $data['date_born'] = '';
            $data['address'] = '';
            $data['email'] = '';
            $data['ine_code'] = '';
            $data['cellphone'] = '';
            $data['petition'] = 0;
            $data['flag_rate'] = 1;
            $data['rate_subsequent'] = 0;
            $data['icc'] = '';
            $data['imei'] = '';
            $data['no_serie'] = '';
            $data['mac'] = '';
            $data['rate_name'] = '';
            $data['rate_id'] = '';
        }
        $data['packs'] = Pack::all()->where('status','activo');
        $data['radiobases'] = Radiobase::all();
        // $current_role = auth()->user()->role_id;

        return view('activations.create',$data);
    }

    public function activationGeneral(Request $request) {
        $scheduleDate = $request->get('scheduleDateFirst');
        $dateActivation = str_replace('-', '' ,$scheduleDate);
        $offer_id = $request->get('offer_id');
        $rate_id = $request->get('rate_id');
        $rate_recurrency = $request->get('rate_recurrency');
        $imei = $request->get('imei');
        $serial_number = $request->get('serial_number');
        $mac_address = $request->get('mac_address');
        $icc_id = $request->get('icc_id');
        $msisdn = $request->get('msisdn');
        $price = $request->get('amount');
        $price_rate = $request->get('price_rate');
        $price_device = $request->get('price_device');
        $clientName = $request->get('name');
        $clientLastname = $request->get('lastname');
        $email = $request->get('email');
        $cellphone = $request->get('cellphone');
        $from = $request->get('from');
        $address = $request->get('address');
        $ine_code = $request->get('ine_code');
        $rfc = $request->get('rfc');
        $date_born = $request->get('date_born');
        $sim_altcel = $request->get('sim_altcel');
        $user_id = $request->get('who_did_id');
        $status = $request->get('statusActivation');
        $product = $request->get('product');
        $promo_bool = $request->get('promo_bool');
        $petition = $request->get('petition');
        $flag_rate = $request->get('flag_rate');
        $rate_subsequent = $request->get('rate_subsequent');
        $activate_bool = 0;

        if (Rate::where('id', $rate_id)->exists() && Number::where('icc_id', $icc_id)->exists() ) {
            $pack_altcel = Rate::where('id', $rate_id)->first();
            $pack_id = $pack_altcel->altcel_pack_id;
        } else {
            return 0;
        }

        $number = Number::where('icc_id', $icc_id)->where('MSISDN', $msisdn)->first();
        $number_id = $number->id;
        $number_status = $number->status;

      

        $rate_price = $pack_altcel->price;
        // return $pack_id;
        
        if($number_status == 'taken'){
            return 0;
        }

        if($status == 'activated'){
            if($activate_bool == 0){
                $accessToken = app('App\Http\Controllers\AltanController')->accessTokenRequestPost();
                if($accessToken['status'] == 'approved'){
                    $accessToken = $accessToken['accessToken'];
                    $activationAltan = app('App\Http\Controllers\AltanController')->activationRequestPost($accessToken, $msisdn, $offer_id, $product, $dateActivation);
                    // return $activationAltan;
                    if($activationAltan['msisdn'] == $msisdn){
                        $order_id_activation =  $activationAltan["order"]["id"];
                    }else{
                        return 2;
                    }
                }else{
                    return 3;
                }
            }
        }
            
        // Verificar existencia de cliente en DB
        $flag = Client::where('email', $email)->exists();
        if($flag){
            $clientData = Client::where('email', $email)->first();
            $idClient = $clientData->id;
        }else {
            return 0;
        }  

        // Actualización de status de SIM en DB
        // Number::where('icc_id', $icc_id)->where('MSISDN', $msisdn)->update(['status'=>'taken']);
        
        // Extracción de ID Oferta
        $offer_id = Offer::where('offerID', $offer_id)->first();
        $offer_id = $offer_id->id;

        // Actualización de status de Dispositivo en DB
        if($imei != null){
            if (Device::where('no_serie_imei','like','%'.$imei.'%')->exists()) {
                Device::where('no_serie_imei','like','%'.$imei.'%')->update(['status'=>'taken']);
                $device_id = Device::where('no_serie_imei','like','%'.$imei.'%')->first();
                $device_id = $device_id->id;
            } else {
                return 0;
            }

        }else{
            $device_id = null;
        }
        
        if($scheduleDate == ''){
            $now = now();
        }else{
            $now = $scheduleDate;
        }
        // $user_id = auth()->user()->id;
        if ($order_id_activation != "") {
            $payment_status = 'activado';
        }else {
            $payment_status = 'pendiente';
        }

        $dataActivation = [
            'client_id' => $idClient,
            'numbers_id' => $number_id,
            'devices_id' => $device_id,
            'serial_number' => $serial_number,
            'mac_address' => $mac_address,
            'date_activation' => $now,
            'who_did_id' => $user_id,
            'offer_id' => $offer_id,
            'rate_id' => $rate_id,
            'dependence_id' => $dependence = $from == 'self' || $from == 'promoters' ? null : $from,
            'amount' => $price,
            'amount_rate' => $price_rate,
            'amount_device' => $price_device,
            'payment_status' => $payment_status,
            'status' => $status,
            'petition_id' => $petition,
            'flag_rate' => $flag_rate,
            'rate_subsequent' => $rate_subsequent,
            'order_id_activation' => $order_id_activation,
        ];

        // return $dataActivation;

        if($petition != 0){
            $name_remitente = auth()->user()->name;
            $email_remitente = auth()->user()->email;

            $date = date('Y-m-d H:i:s');
            DB::table('petitions')->where('id', $petition)->update([
                'status' => 'activado',
                'who_attended' => $user_id,
                'date_activated' => $date
            ]);

            $comment = DB::table('petitions')->where('id', $petition)->get('comment');
                //correos operaciones
            // $response = Http::withHeaders([
            //     'Conten-Type'=>'application/json'
            // ])->get('http://10.44.0.70/petitions-notifications',[
            //     'name'=> $name,
            //     'lastname'=>$lastname,
            //     'correo'=> $email,
            //     'comment'=>$comment[0]->comment,
            //     'status'=>'activado',
            //     'remitente'=>$name_remitente,
            //     'email_remitente'=>$email_remitente,
            //     'product'=> $product
            // ]);
        }

        Activation::insert($dataActivation);
        $activationID = Activation::latest('id')->first();
        $activationID = $activationID->id;

        if($promo_bool == 1){
            $dataRate = Rate::where('id', $rate_id)->first();
            $promotion_id = $dataRate->promotion_id;

            $dataPromotion = Promotion::where('id', $promotion_id)->first();
            $device_quantity = $dataPromotion->device_quantity;

            $device_quantity = $device_quantity-1;
            Promotion::where('id', $promotion_id)->update([
                'device_quantity' => $device_quantity
            ]);
        }

        if($from == 'promoters'){
            $x = Assignment::where('promoter_id',$user_id)
                            ->where('number_id',$number_id)
                            ->where('type','sim')
                            ->update(['status'=>'taken']);
            $y = Assignment::where('promoter_id',$user_id)->where('device_id',$device_id)->where('type','device')->update(['status'=>'taken']);
            if(!$x || !$y){
                return 4;
            }
        }

        if($petition != 0){
            $activationData = Activation::where('petition_id', $petition)->first();
            $activation_id = $activationData->id;
            return response()->json(['http_code'=>1, 'activation_id'=>$activation_id]);
        }
        
        return 1;
    }

    public function activationEthernet(Request $request) {
        // Datos personales del cliente
        $name = $request->get('name');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        // Usuario que ejecutó el movimiento
        $who_did_id = $request->get('who_did_id');

        // Datos de vivienda y extras del cliente
        $address = $request->get('client_address');
        $ine_code = $request->get('ine_code');
        $rfc = $request->get('rfc');
        $date_born = $request->get('date_born');
        $cellphone = $request->get('cellphone');
        $number = $request->get('number');

        // Dato de Paquete
        $pack_id = $request->get('pack_id');
        $packDB = Pack::where('id',$pack_id)->first();
        $recurrency = $packDB->recurrency;
        $pack_price = $packDB->price;
        $pack_service = $request->get('pack_service');

        // Datos de Cliente Child
        $name_child = $request->get('name_child');
        $lastname_child = $request->get('lastname_child');
        $rfc_child = $request->get('rfc_child');
        $date_born_child = $request->get('date_born_child');
        $client_address_child = $request->get('client_address_child');
        $ine_code_child = $request->get('ine_code_child');
        $email_child = $request->get('email_child');
        $cellphone_child = $request->get('cellphone_child');
        $type_person = $request->get('type_person');
        $email_not = $request->get('email_not');

        $client_id = $request->get('client_id');
        $schedule_flag = $request->get('schedule_flag');
        $schedule_id = 0;
        
        if($pack_service == 'Conecta'){
            if($schedule_flag == 1){
                $schedule_id = $request->get('schedule_id');
                $request = request()->except(
                    '_token','name','lastname','email','rfc','date_born',
                    'ine_code','cellphone','client_address','name_child',
                    'lastname_child','email_child','rfc_child','date_born_child',
                    'ine_code_child','cellphone_child','client_address_child',
                    'pack_service','schedule_flag','schedule_id','type_person','email_not'); 
            }else if($schedule_flag == 0){
                $schedule_id = null;
                $request = request()->except(
                    '_token','name','lastname','email','rfc','date_born',
                    'ine_code','cellphone','client_address','name_child',
                    'lastname_child','email_child','rfc_child','date_born_child',
                    'ine_code_child','cellphone_child','client_address_child',
                    'pack_service','schedule_flag','type_person','email_not');  
            }
                    
        }else{
            $request = request()->except(
                '_token','name','lastname','email','rfc','date_born',
                'ine_code','cellphone','client_address','pack_service',
                'no_serie_antena','mac_address_antena','model_antena',
                'ip_address_antena','no_serie_router','mac_address_router',
                'model_router','radiobase_id','name_child','lastname_child',
                'email_child','rfc_child','date_born_child','ine_code_child',
                'cellphone_child','client_address_child','schedule_flag','type_person','email_not');
        }

        $client_flag = User::where('email',$email)->exists();

        if($client_flag){
            $client_id = User::where('email',$email)->first();
            $client_id = $client_id->id;
            $request['client_id'] = $client_id;
        }else{
            $namePass = ActivationController::exceptSpecials($name);
            $lastnamePass = ActivationController::exceptSpecials($lastname);
            $pass = substr($namePass,0,2).$lastnamePass;
            $pass = strtolower($pass);

            User::insert([
                'name' => $name,
                'lastname' => $lastname,
                'email' => $email,
                'password' => Hash::make($pass),
                'role_id' => 3
            ]);

            $client_id = User::where('email',$email)->first();
            $client_id = $client_id->id;

            Client::insert([
                'address' => $address,
                'ine_code' => $ine_code,
                'rfc' => $rfc,
                'date_born' => $date_born,
                'cellphone' => $cellphone,
                'user_id' => $client_id,
                'who_did_id' => $who_did_id
            ]);

            $request['client_id'] = $client_id;
            if($email_not == 0){
                ActivationController::sendCredentials($email,$pass,$name,$lastname);
            }
        }

        // Verificación de existencia de Clientson
        if($type_person == 'moral'){
            $client_son = Clientsson::where('rfc','=',$rfc_child)->exists();
        }else{
            $client_son = Clientsson::where('email','=',$email_child)->exists();
        }

        // Inserción/Extracción de id de Clientson, según status de existencia (true/false)
        if($client_son){
            if($type_person == 'moral'){
                $client_son = Clientsson::where('rfc','=',$rfc_child)->first();
            }else{
                $client_son = Clientsson::where('email','=',$email_child)->first();
            }
            $client_son_id = $client_son->id;
        }else{
            Clientsson::insert([
                'name' => $name_child,
                'lastname' => $lastname_child,
                'rfc' => $rfc_child,
                'date_born' => $date_born_child,
                'address' => $client_address_child,
                'email' => $email_child,
                'ine_code' => $ine_code_child,
                'cellphone' => $cellphone_child,
                'type_person' => $type_person
            ]);

            if($type_person == 'moral'){
                $client_son = Clientsson::where('rfc','=',$rfc_child)->first();
            }else{
                $client_son = Clientsson::where('email','=',$email_child)->first();
            }
            $client_son_id = $client_son->id;
        }

        $flag_client_child = Clientsson::where('email','=',$email_child)->exists();
        if($flag_client_child){
            $client_child = Clientsson::where('email',$email_child)->first();
            $client_child_id = $client_child->id;
        }else{
            Clientsson::insert([
                'name' => $name_child,
                'lastname' => $lastname_child,
                'rfc' => $rfc_child,
                'date_born' => $date_born_child,
                'address' => $client_address_child,
                'email' => $email_child,
                'ine_code' => $ine_code_child,
                'cellphone' => $cellphone_child,
                'type_person' => $type_person
            ]);
            $client_child = Clientsson::where('email',$email_child)->first();
            $client_child_id = $client_child->id;
        }

        $request['date_instalation'] = $now = now();
        $request['clientson_id'] = $client_child_id;
        $request['payment_status'] = 'pendiente';
        $x = Instalation::insert($request);
        $activationID = Instalation::latest('id')->first();
        $activationID = $activationID->id;
        if($x){

            /* $date_now = date("Y-m-d");

            $date_pay = new DateTime($date_now);
            // $date_pay = $date_pay->format('Y-m-d');
            $date_pay->modify('last day of this month');
            $date_pay = $date_pay->format('Y-m-d');

            $date_limit = strtotime('+5 days', strtotime($date_pay));
            $date_limit = date('Y-m-d', $date_limit);

            Ethernetpay::insert([
                'date_pay' => $date_pay,
                'date_pay_limit' => $date_limit,
                'status' => 'pendiente',
                'instalation_id' => $activationID,
                'amount' => $pack_price
            ]); */

            if($schedule_flag == 1){
                Schedule::where('id',$schedule_id)->update([
                    'status' => 'completado',
                    'user_id' => $who_did_id,
                    'instalation_id' => $activationID
                ]);
            }

            $response = 'Instalación añadida con éxito.';
        }else{
            $response = 'Parece que hubo un error.';
        }
        return $response;
    }


    public function exceptSpecials($string){
        
        $string = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $string
        );
    
        //Reemplazamos la E y e
        $string = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $string );
    
        //Reemplazamos la I y i
        $string = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $string );
    
        //Reemplazamos la O y o
        $string = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $string );
    
        //Reemplazamos la U y u
        $string = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $string );
    
        //Reemplazamos la N, n, C y c
        $string = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç'),
        array('N', 'n', 'C', 'c'),
        $string
        );
        return $string;
    }

    public function sendCredentials($email,$pass,$name,$lastname) {
        $data= [
            "subject" => "Accesos ",
            "name" => $name,
            "lastname" => $lastname,
            "user" => $email,
            "password" => $pass
        ];
        Mail::to($email)->send(new SendAccess($data));
    }
    
    //-- --
    public function indexFilter($date_init,$date_final){
        if($date_init == 'none'){

            $data['clients'] = DB::table('activations')
                              ->join('users','users.id','=','activations.client_id')
                              ->leftJoin('numbers', 'activations.numbers_id', '=', 'numbers.id')
                              ->leftJoin('devices', 'activations.devices_id', '=', 'devices.id')
                              ->join('pays','pays.activation_id','=','activations.id')
                              ->join('rates', 'rates.id', '=', 'activations.rate_id')
                              ->join('clients','activations.client_id','=','user_id')
                              ->where('pays.status','pendiente')
                              ->select('activations.*', 'users.name','users.lastname',
                              'numbers.MSISDN','numbers.producto AS pack_service', 
                              'devices.description AS device_desc', 'users.name as promotor',
                              'rates.name AS name_rate','clients.address as address',
                              'clients.cellphone AS client_cellphone','pays.amount_received AS payment_amount',
                              'pays.status AS payment_status','pays.date_pay AS payment_date')
                              ->get();

            $data['clients2'] = DB::table('activations')
                                ->join('users','users.id','=','activations.client_id')
                                ->leftJoin('numbers', 'activations.numbers_id', '=', 'numbers.id')
                                ->leftJoin('devices', 'activations.devices_id', '=', 'devices.id')
                                ->leftJoin('pays','pays.activation_id','=','activations.id')
                                ->join('rates', 'rates.id', '=', 'activations.rate_id')
                                ->join('clients','activations.client_id','=','user_id')
                                ->where('pays.id', null)
                                ->select('activations.*', 'users.name','users.lastname',
                                'numbers.MSISDN','numbers.producto AS pack_service', 
                                'devices.description AS device_desc', 'users.name as promotor',
                                'rates.name AS name_rate','clients.address as address',
                                'clients.cellphone AS client_cellphone','pays.amount_received AS payment_amount',
                                'pays.status AS payment_status','pays.date_pay AS payment_date')
                                ->get();

            $data['instalations'] = DB::table('instalations')
                                   ->join('packs','packs.id','=','instalations.pack_id')
                                   ->join('radiobases','radiobases.id','=','instalations.radiobase_id')
                                   ->join('users','users.id','=','instalations.client_id')
                                   ->join('clients','clients.user_id','=','users.id')
                                   ->leftJoin('ethernetpays','ethernetpays.instalation_id','=','instalations.id')
                                   ->where('service_name','Conecta')
                                   ->select('instalations.*','packs.name AS pack_name','packs.service_name AS pack_service',
                                   'radiobases.name as radiobase_name','users.name AS client_name',
                                   'users.lastname AS client_lastname','clients.cellphone AS client_cellphone','ethernetpays.amount_received AS payment_amount',
                                   'ethernetpays.status AS payment_status','ethernetpays.date_pay AS payment_date')
                                   ->get();

            $data['instalations2'] = DB::table('instalations')
                                   ->join('packs','packs.id','=','instalations.pack_id')
                                   ->join('radiobases','radiobases.id','=','instalations.radiobase_id')
                                   ->join('users','users.id','=','instalations.client_id')
                                   ->join('clients','clients.user_id','=','users.id')
                                   ->leftJoin('ethernetpays','ethernetpays.instalation_id','=','instalations.id')
                                   ->where('service_name','Conecta')
                                   ->where('ethernetpays.id', null)
                                   ->select('instalations.*','packs.name AS pack_name','packs.service_name AS pack_service',
                                   'radiobases.name as radiobase_name','users.name AS client_name',
                                   'users.lastname AS client_lastname','clients.cellphone AS client_cellphone','ethernetpays.amount_received AS payment_amount',
                                   'ethernetpays.status AS payment_status','ethernetpays.date_pay AS payment_date')
                                   ->get();

            $data['TELMEXinstalations'] = DB::table('instalations')
                                   ->join('packs','packs.id','=','instalations.pack_id')
                                   ->join('users','users.id','=','instalations.client_id')
                                   ->join('clients','clients.user_id','=','users.id')
                                   ->leftJoin('ethernetpays','ethernetpays.instalation_id','=','instalations.id')
                                   ->where('service_name','Telmex')
                                   ->where('ethernetpays.status','pendiente')
                                   ->select('instalations.*','packs.name AS pack_name','packs.service_name AS pack_service',
                                   'users.name AS client_name','users.lastname AS client_lastname',
                                   'clients.cellphone AS client_cellphone','ethernetpays.amount_received AS payment_amount',
                                   'ethernetpays.status AS payment_status','ethernetpays.date_pay AS payment_date')
                                   ->get();

            $data['TELMEXinstalations2'] = DB::table('instalations')
                                   ->join('packs','packs.id','=','instalations.pack_id')
                                   ->join('users','users.id','=','instalations.client_id')
                                   ->join('clients','clients.user_id','=','users.id')
                                   ->leftJoin('ethernetpays','ethernetpays.instalation_id','=','instalations.id')
                                   ->where('service_name','Telmex')
                                   ->where('ethernetpays.id', null)
                                   ->select('instalations.*','packs.name AS pack_name','packs.service_name AS pack_service',
                                   'users.name AS client_name','users.lastname AS client_lastname',
                                   'clients.cellphone AS client_cellphone','ethernetpays.amount_received AS payment_amount',
                                   'ethernetpays.status AS payment_status','ethernetpays.date_pay AS payment_date')
                                   ->get();

        }else{
            $data['clients'] = DB::table('activations')
                              ->join('users','users.id','=','activations.client_id')
                              ->leftJoin('numbers', 'activations.numbers_id', '=', 'numbers.id')
                              ->leftJoin('devices', 'activations.devices_id', '=', 'devices.id')
                              ->leftJoin('pays','pays.activation_id','=','activations.id')
                              ->join('rates', 'rates.id', '=', 'activations.rate_id')
                              ->join('clients','activations.client_id','=','user_id')
                              ->where('pays.status','pendiente')
                              ->whereBetween('pays.date_pay', [$date_init, $date_final])
                              ->select('activations.*', 'users.name','users.lastname',
                              'numbers.MSISDN','numbers.producto AS pack_service', 
                              'devices.description AS device_desc', 'users.name as promotor',
                              'rates.name AS name_rate','clients.address as address',
                              'clients.cellphone AS client_cellphone','pays.amount_received AS payment_amount',
                              'pays.status AS payment_status','pays.date_pay AS payment_date')
                              ->get();

            $data['clients2'] = DB::table('activations')
                                ->join('users','users.id','=','activations.client_id')
                                ->leftJoin('numbers', 'activations.numbers_id', '=', 'numbers.id')
                                ->leftJoin('devices', 'activations.devices_id', '=', 'devices.id')
                                ->leftJoin('pays','pays.activation_id','=','activations.id')
                                ->join('rates', 'rates.id', '=', 'activations.rate_id')
                                ->join('clients','activations.client_id','=','user_id')
                                ->whereBetween('activations.date_activation',[$date_init, $date_final])
                                ->where('pays.id', null)
                                ->select('activations.*', 'users.name','users.lastname',
                                'numbers.MSISDN','numbers.producto AS pack_service', 
                                'devices.description AS device_desc', 'users.name as promotor',
                                'rates.name AS name_rate','clients.address as address',
                                'clients.cellphone AS client_cellphone','pays.amount_received AS payment_amount',
                                'pays.status AS payment_status','pays.date_pay AS payment_date')
                                ->get();

            $data['instalations'] = DB::table('instalations')
                                   ->join('packs','packs.id','=','instalations.pack_id')
                                   ->join('radiobases','radiobases.id','=','instalations.radiobase_id')
                                   ->join('users','users.id','=','instalations.client_id')
                                   ->join('clients','clients.user_id','=','users.id')
                                   ->leftJoin('ethernetpays','ethernetpays.instalation_id','=','instalations.id')
                                   ->where('service_name','Conecta')
                                   ->whereBetween('ethernetpays.date_pay', [$date_init, $date_final])
                                   ->select('instalations.*','packs.name AS pack_name','packs.service_name AS pack_service',
                                   'radiobases.name as radiobase_name','users.name AS client_name',
                                   'users.lastname AS client_lastname','clients.cellphone AS client_cellphone','ethernetpays.amount_received AS payment_amount',
                                   'ethernetpays.status AS payment_status','ethernetpays.date_pay AS payment_date')
                                   ->get();

            $data['instalations2'] = DB::table('instalations')
                                   ->join('packs','packs.id','=','instalations.pack_id')
                                   ->join('radiobases','radiobases.id','=','instalations.radiobase_id')
                                   ->join('users','users.id','=','instalations.client_id')
                                   ->join('clients','clients.user_id','=','users.id')
                                   ->leftJoin('ethernetpays','ethernetpays.instalation_id','=','instalations.id')
                                   ->where('service_name','Conecta')
                                   ->whereBetween('instalations.date_instalation', [$date_init, $date_final])
                                   ->where('ethernetpays.id', null)
                                   ->select('instalations.*','packs.name AS pack_name','packs.service_name AS pack_service',
                                   'radiobases.name as radiobase_name','users.name AS client_name',
                                   'users.lastname AS client_lastname','clients.cellphone AS client_cellphone','ethernetpays.amount_received AS payment_amount',
                                   'ethernetpays.status AS payment_status','ethernetpays.date_pay AS payment_date')
                                   ->get();

            $data['TELMEXinstalations'] = DB::table('instalations')
                                   ->join('packs','packs.id','=','instalations.pack_id')
                                   ->join('users','users.id','=','instalations.client_id')
                                   ->join('clients','clients.user_id','=','users.id')
                                   ->leftJoin('ethernetpays','ethernetpays.instalation_id','=','instalations.id')
                                   ->where('service_name','Telmex')
                                   ->where('ethernetpays.status','pendiente')
                                   ->whereBetween('ethernetpays.date_pay', [$date_init, $date_final])
                                   ->select('instalations.*','packs.name AS pack_name','packs.service_name AS pack_service',
                                   'users.name AS client_name','users.lastname AS client_lastname',
                                   'clients.cellphone AS client_cellphone','ethernetpays.amount_received AS payment_amount',
                                   'ethernetpays.status AS payment_status','ethernetpays.date_pay AS payment_date')
                                   ->get();

            $data['TELMEXinstalations2'] = DB::table('instalations')
                                   ->join('packs','packs.id','=','instalations.pack_id')
                                   ->join('users','users.id','=','instalations.client_id')
                                   ->join('clients','clients.user_id','=','users.id')
                                   ->leftJoin('ethernetpays','ethernetpays.instalation_id','=','instalations.id')
                                   ->where('service_name','Telmex')
                                   ->whereBetween('instalations.date_instalation', [$date_init, $date_final])
                                   ->where('ethernetpays.id', null)
                                   ->select('instalations.*','packs.name AS pack_name','packs.service_name AS pack_service',
                                   'users.name AS client_name','users.lastname AS client_lastname',
                                   'clients.cellphone AS client_cellphone','ethernetpays.amount_received AS payment_amount',
                                   'ethernetpays.status AS payment_status','ethernetpays.date_pay AS payment_date')
                                   ->get();
        }
           
        return $data;
    }

    public function preactivationsIndex(){
        $data['preactivations'] = DB::table('activations')
                                     ->join('users','users.id','=','activations.client_id')
                                     ->join('numbers','numbers.id','=','activations.numbers_id')
                                     ->join('devices','devices.id','=','activations.devices_id')
                                     ->join('rates','rates.id','=','activations.rate_id')
                                     ->where('activations.status','preactivated')
                                     ->select('activations.*','rates.name AS rate_name','numbers.MSISDN AS MSISDN','numbers.icc_id AS ICC','numbers.producto AS producto',
                                     'devices.no_serie_imei AS IMEI','devices.description AS description_device','users.name AS client_name','users.lastname AS client_lastname','users.email AS client_email')
                                     ->get();
        return view('activations.preactivationsIndex',$data);
    }

    public function show(Activation $activation){
        $data['client'] = User::where('id',$activation->client_id)->first();
        $data['number'] = Number::where('id',$activation->numbers_id)->first();
        $data['device'] = Device::where('id',$activation->devices_id)->first();
        $data['rate'] = Rate::where('id',$activation->rate_id)->first();
        $data['offer'] = Offer::where('id',$activation->offer_id)->first();
        $data['user'] = User::where('id',$activation->who_did_id)->first();
        $data['dataClient'] = Client::where('user_id',$activation->client_id)->first();
        $data['activation'] = $activation;
        $producto = $data['number']->producto;
        $producto = trim($producto);
        $data['rates'] = DB::table('rates')
                            ->join('offers','offers.id','=','rates.alta_offer_id')
                            ->where('rates.id','!=',$activation->rate_id)
                            ->where('offers.product','=',$producto)
                            ->where('offers.type','normal')
                            ->select('rates.*')
                            ->get();
        // return $data;
        return view('activations.preactivationShow',$data);
    }

    public function changeRatePreactivate(Request $request){
        $activation = $request->post('activation_id');
        $request = request()->except('_token','activation_id');
        $x = Activation::where('id',$activation)->update($request);

        if($x){
            return 1;
        }else{
            return 0;
        }
    }

    public function rollbackPreactivate(Activation $activation){
        $number_id = $activation->numbers_id;
        $device_id = $activation->devices_id;
        $user_id = $activation->who_did_id;
        $id = $activation->id;
        Number::where('id',$number_id)->update(['status'=>'available']);
        Device::where('id',$device_id)->update(['status'=>'available']);

        if($number_id != null){
            Assignment::where('promoter_id',$user_id)->where('number_id',$number_id)->update(['status'=>'available']);
        }

        if($device_id != null){
            Assignment::where('promoter_id',$user_id)->where('device_id',$device_id)->update(['status'=>'available']);
        }
        $x = Activation::destroy($id);

        if($x){
            return 1;
        }else{
            return 0;
        }
    }

    public function executeActivation(Petition $petition){
        $id = $petition->id;
        $number_id = $petition->number_id;
        $device_id = $petition->device_id;
        $date_to_activate = $petition->date_to_activate;
        $client_id = $petition->client_id;
        $rate_activation = $petition->rate_activation;
        $serial_number = $petition->serial_number;
        $mac_address = $petition->mac_address;

        $numberData = Number::where('id',$number_id)->first();
        $msisdn = $numberData->MSISDN;
        $product = $numberData->producto;
        $product = trim($product);

        $rateData = Rate::where('id',$petition->rate_activation)->first();
        $offer_id = $rateData->alta_offer_id;
        $offerData = Offer::where('id',$offer_id)->first();
        $offerID = $offerData->offerID;

        $today = date('Y-m-d');
        if($date_to_activate == $today){
            $scheduleDate = '';
        }else{
            $date_to_activate = str_replace('-','',$date_to_activate);
            $scheduleDate = $date_to_activate;
        }

        if($product == 'HBB'){
            $lat_hbb = $petition->lat_hbb;
            $lng_hbb = $petition->lng_hbb;
        }else{
            $lat_hbb = '';
            $lng_hbb = '';
        }

        //CODIGO TEMPORAL 19/12/2022

        $user_id = auth()->user()->id;

        $clientData = User::where('id',$client_id)->first();
        $dataClient = Client::where('user_id',$client_id)->first();

        $clientSonExists = Clientsson::where('email',$clientData->email)->exists();

        if(!$clientSonExists){
            Clientsson::insert([
                'name' => $clientData->name,
                'lastname' => $clientData->lastname,
                'rfc' => $dataClient->rfc,
                'date_born' => $dataClient->date_born,
                'address' => $dataClient->address,
                'email' => $clientData->email,
                'ine_code' => $dataClient->ine_code,
                'cellphone' => $dataClient->cellphone,
                'type_person' => $dataClient->type_person,
                'user_id' => $client_id
            ]);
        }

        $clientSon = Clientsson::where('email',$clientData->email)->first();

        $dataActivation = [
            'client_id' => $client_id,
            'numbers_id' => $number_id,
            'devices_id' => $device_id,
            'serial_number' => $serial_number,
            'mac_address' => $mac_address,
            'date_activation' => $date_to_activate,
            'who_did_id' => $user_id,
            'offer_id' => $offer_id,
            'rate_id' => $rate_activation,
            'amount' => 0,
            'amount_rate' => 0,
            'amount_device' => 0,
            'clientson_id' => $clientSon->id,
            'lat_hbb' => $lat_hbb,
            'lng_hbb' => $lng_hbb,
            'payment_status' => 'pendiente',
            'status' => 'activated',
            'petition_id' => $id,
            'flag_rate' => 1,
            'rate_subsequent' => $rate_activation
        ];
        Activation::insert($dataActivation);


        Number::where('id',$number_id)->update(['status'=>'taken']);
        if($device_id != null){
            Device::where('id',$device_id)->update(['status'=>'taken']);
        }

        $name_remitente = auth()->user()->name;
        $email_remitente = auth()->user()->email;

        $date = date('Y-m-d H:i:s');
        DB::table('petitions')->where('id',$id)->update([
            'status' => 'activado',
            'who_attended' => $user_id,
            'date_activated' => $date
        ]);

        $comment = DB::table('petitions')->where('id', $id)->get('comment');
            //correos operaciones
        $response = Http::withHeaders([
            'Conten-Type'=>'application/json'
        ])->get('http://10.44.0.70/petitions-notifications',[
            'name'=> $clientData->name,
            'lastname'=>$clientData->lastname,
            'correo'=> $clientData->email,
            'comment'=>$comment[0]->comment,
            'status'=>'activado',
            'remitente'=>$name_remitente,
            'email_remitente'=>$email_remitente,
            'product'=> $product
        ]);

        return response()->json(['http_code'=>1,'message'=>'Activación exitosa.']);

        //CODIGO TEMPORAL 19/12/2022

        $accessToken = app('App\Http\Controllers\AltanController')->accessTokenRequestPost();
        if($accessToken['status'] == 'approved'){
            $accessToken = $accessToken['accessToken'];
            $activationAltan = app('App\Http\Controllers\AltanController')->activationRequestPost($accessToken,$msisdn,$offerID,$lat_hbb,$lng_hbb,$product,$scheduleDate);
            // return $activationAltan;
            if(isset($activationAltan['msisdn'])){
                // Activation::where('id',$id)->update(['status'=>'activated']);
                $user_id = auth()->user()->id;

                $clientData = User::where('id',$client_id)->first();
                $dataClient = Client::where('user_id',$client_id)->first();

                $clientSonExists = Clientsson::where('email',$clientData->email)->exists();

                if(!$clientSonExists){
                    Clientsson::insert([
                        'name' => $clientData->name,
                        'lastname' => $clientData->lastname,
                        'rfc' => $dataClient->rfc,
                        'date_born' => $dataClient->date_born,
                        'address' => $dataClient->address,
                        'email' => $clientData->email,
                        'ine_code' => $dataClient->ine_code,
                        'cellphone' => $dataClient->cellphone,
                        'type_person' => $dataClient->type_person,
                        'user_id' => $client_id
                    ]);
                }

                $clientSon = Clientsson::where('email',$clientData->email)->first();

                $dataActivation = [
                    'client_id' => $client_id,
                    'numbers_id' => $number_id,
                    'devices_id' => $device_id,
                    'serial_number' => $serial_number,
                    'mac_address' => $mac_address,
                    'date_activation' => $date_to_activate,
                    'who_did_id' => $user_id,
                    'offer_id' => $offer_id,
                    'rate_id' => $rate_activation,
                    'amount' => 0,
                    'amount_rate' => 0,
                    'amount_device' => 0,
                    'clientson_id' => $clientSon->id,
                    'lat_hbb' => $lat_hbb,
                    'lng_hbb' => $lng_hbb,
                    'payment_status' => 'pendiente',
                    'status' => 'activated',
                    'petition_id' => $id,
                    'flag_rate' => 1,
                    'rate_subsequent' => $rate_activation
                ];
                Activation::insert($dataActivation);
                Number::where('id',$number_id)->update(['status'=>'taken']);
                if($device_id != null){
                    Device::where('id',$device_id)->update(['status'=>'taken']);
                }

                $name_remitente = auth()->user()->name;
                $email_remitente = auth()->user()->email;

                $date = date('Y-m-d H:i:s');
                DB::table('petitions')->where('id',$id)->update([
                    'status' => 'activado',
                    'who_attended' => $user_id,
                    'date_activated' => $date
                ]);

                $comment = DB::table('petitions')->where('id', $id)->get('comment');
                    //correos operaciones
                $response = Http::withHeaders([
                    'Conten-Type'=>'application/json'
                ])->get('http://10.44.0.70/petitions-notifications',[
                    'name'=> $clientData->name,
                    'lastname'=>$clientData->lastname,
                    'correo'=> $clientData->email,
                    'comment'=>$comment[0]->comment,
                    'status'=>'activado',
                    'remitente'=>$name_remitente,
                    'email_remitente'=>$email_remitente,
                    'product'=> $product
                ]);

                return response()->json(['http_code'=>1,'message'=>'Activación exitosa.']);
            }else if(isset($activationAltan['errorCode'])){
                return response()->json(['http_code'=>0,'message'=>$activationAltan['description']]);
            }
        }else{
            return response()->json(['http_code'=>2,'message'=>'No se pudo realizar la activación, consulte a Desarrollo.']);
        }
        return $petition;

    }

    public function datePay(){
        $date_now = date("Y-m-d");

        $date_pay = new DateTime($date_now);
        // $date_pay = $date_pay->format('Y-m-d');
        $date_pay->modify('last day of this month');
        $date_pay = $date_pay->format('Y-m-d');

        $date_limit = strtotime('+5 days', strtotime($date_pay));
        $date_limit = date('Y-m-d', $date_limit);

        return $date_pay.' - '.$date_limit;

        // $fecha_pay = '2021-06-30';
        // $fecha_limit = '2021-07-05';
        // // Obtenemos el siguiente mes
        // $fecha_pay_new = strtotime('+3 days', strtotime($fecha_pay));
        // $fecha_pay_new = date('Y-m-d',$fecha_pay_new);
        // // Obtenemos su último día
        // $fecha_pay_new = new DateTime($fecha_pay_new);
        // $fecha_pay_new->modify('last day of this month');
        // $fecha_pay_new = $fecha_pay_new->format('Y-m-d');
        // // Obtenemos nueva fecha límite de pago
        // $fecha_limit_new = strtotime('+5 days', strtotime($fecha_pay_new));
        // $fecha_limit_new = date('Y-m-d',$fecha_limit_new);
        // return $fecha_pay_new.' - '.$fecha_limit_new;
        
    }

    public function getDataPayment(Request $request){
        $id = $request->get('id');
        $type = $request->get('type');

        if($type == 'activation'){
            $response = DB::table('activations')
                           ->join('users','users.id','=','activations.client_id')
                           ->join('rates','rates.id','=','activations.rate_id')
                           ->join('offers','offers.id','=','rates.alta_offer_id')
                           ->join('devices','devices.id','=','activations.devices_id')
                           ->where('activations.id',$id)
                           ->select('activations.*','users.name AS name','users.lastname AS lastname','rates.name AS rate_name','offers.product AS service','devices.description AS device_description')
                           ->get();
            // $response = Activation::where('id',$id)->first();
        }else if($type == 'instalation'){
            $response = DB::table('instalations')
                           ->join('users','users.id','=','instalations.client_id')
                           ->join('packs','packs.id','=','instalations.pack_id')
                           ->where('instalations.id',$id)
                           ->select('instalations.amount AS amount_pack','instalations.amount_install AS amount_install',
                           'users.name AS name','users.lastname AS lastname','packs.name AS pack_name','packs.service_name AS service',
                           'instalations.received_amount AS received_amount','instalations.received_amount_install AS received_amount_install')
                           ->get();
            // $response = Instalation::where('id',$id)->first();
        }
        return $response;
    }

    public function setPaymentStatus(Request $request){
        // return $request;
        $id = $request->get('id');
        $type = $request->get('type');
        $x = false;

        $waited_amount_rate = $request->get('waited_amount_rate');
        $waited_amount_device = $request->get('waited_amount_device');

        $received_amount_rate = $request->get('received_amount_rate');
        $received_amount_device = $request->get('received_amount_device');

        $collected_amount_rate = $request->get('collected_amount_rate');
        $collected_amount_device = $request->get('collected_amount_device');

        $collected_amount_rate = $received_amount_rate+$collected_amount_rate;
        $collected_amount_device = $received_amount_device+$collected_amount_device;

        $statusPayment = 'pendiente';
        $statusPetition = 'activado';

        if(($collected_amount_rate >= $waited_amount_rate) && ($collected_amount_device >= $waited_amount_device)){
            $statusPayment = 'completado';
            $statusPetition = 'recibido';
        }

        // return response()->json(['new_amount_rate'=>$collected_amount_rate,'new_amount_device'=>$collected_amount_device]);

        if($type == 'activation'){
            // return $request;
            $x = Activation::where('id',$id)->update([
                'received_amount_rate' => $collected_amount_rate,
                'received_amount_device' => $collected_amount_device,
                'payment_status' => $statusPayment
            ]);

            $dataActivation = Activation::where('id',$id)->first();
            $petition_id = $dataActivation->petition_id;

            if($petition_id != null){
                $current_id = auth()->user()->id;
                $date_received = date('Y-m-d H:i:s');
                Petition::where('id',$petition_id)->update([
                    'collected_rate' => $collected_amount_rate,
                    'collected_device' => $collected_amount_device,
                    'status' => $statusPetition,
                    'who_received' => $current_id,
                    'date_received' => $date_received
                ]);

                if($statusPetition == 'recibido'){
                    $name_remitente = auth()->user()->name;
                    $email_remitente = auth()->user()->email;

                    $comment = DB::table('petitions')->where('id', $petition_id)->select('product','comment', 'client_id')->get();
                    $id_client = $comment[0]->client_id;
                    $client = DB::table('users')->where('id', $id_client)->select('name','lastname','email')->get();
                    // AQUÍ VA EL ENVÍO DE CORREO
                    
                    $response = Http::withHeaders([
                        'Conten-Type'=>'application/json'
                    ])->get('http://10.44.0.70/petitions-notifications',[
                        'name'=> $client[0]->name,
                        'lastname'=>$client[0]->lastname,
                        'correo'=> $client[0]->email,
                        'comment'=>$comment[0]->comment,
                        'status'=>'recibido',
                        'remitente'=>$name_remitente,
                        'email_remitente'=>$email_remitente,
                        'product'=> $comment[0]->product
                    ]);

                    // return $response;
                    if($response['http_code'] == 200){
                        $x = true;
                    }

                }
            }

        }else if($type == 'instalation'){
            // return $request;
            $x = Instalation::where('id',$id)->update([
                'received_amount' => $collected_amount_rate,
                'received_amount_install' => $collected_amount_device,
                'payment_status' => $statusPayment
            ]);
        }
        
        if($x){
            return 1;
        }else{
            return 0;
        }
    }

    public function getDataMonthly(Request $request){
        // FALTA EXTRAER EL PAGO
        // QUEDA PENDIENTE CORROBORAR DE QUE MANERA SE VALIDA SI HABRÁ PAGO DE MENSUALIDAD O NO
        
        $act_inst_id = $request->get('id');
        $type = $request->get('type');

        if($type == 'activation'){
            $dataMSISDN = DB::table('numbers')
                         ->join('activations','activations.numbers_id','=','numbers.id')
                         ->join('users','users.id','=','activations.client_id')
                         ->join('clients','clients.user_id','=','users.id')
                         ->where('activations.id',$act_inst_id)
                         ->select('numbers.id AS number_id','activations.expire_date AS expire_date','activations.id AS activation_id',
                         'users.name AS name_user','users.lastname AS lastname_user','users.email AS email_user','clients.cellphone AS cellphone_user',
                         'activations.id AS activation_id')
                         ->get();

            $expire_date = $dataMSISDN[0]->expire_date;
            $activation_id = $dataMSISDN[0]->activation_id;

            $date_limit = strtotime('-1 days', strtotime($expire_date));
            $date_limit = date('Y-m-d', $date_limit);

            $date_beforeFiveDays = strtotime('-5 days', strtotime($date_limit));
            $date_beforeFiveDays = date('Y-m-d', $date_beforeFiveDays);

            $now = date('Y-m-d');
            // return $now. ' . '.$date_beforeFiveDays;
            $now = new DateTime($now);
            $date_beforeFiveDays = new DateTime($date_beforeFiveDays);

            $timeDiff = $now->diff($date_beforeFiveDays);
            $paymentData = array();

            

            if($now >= $date_beforeFiveDays){
                $payment = DB::table('pays')
                              ->join('activations','activations.id','=','pays.activation_id')
                              ->join('rates','rates.id','=','activations.rate_id')
                              ->join('numbers','numbers.id','=','activations.numbers_id')
                              ->where('pays.activation_id',$activation_id)
                              ->where('pays.status','pendiente')
                              ->select('pays.*','rates.name AS rate_name','numbers.MSISDN AS sim')
                              ->orderBy('pays.date_pay','desc')
                              ->limit(1)
                              ->get();
                if(sizeof($payment) == 0){
                    $paymentData = array(
                        'http_monthly_code' => 0
                    );
                }else{
                    $paymentData = array(
                        'payment_id' => $payment[0]->id,
                        'amount' => $payment[0]->amount,
                        'date_pay' => $payment[0]->date_pay,
                        'date_pay_limit' => $payment[0]->date_pay_limit,
                        'status' => $payment[0]->status,
                        'rate_name' => $payment[0]->rate_name,
                        'sim' => $payment[0]->sim,
                        'http_monthly_code' => 1
                    );
                }
                
                return $paymentData;
            }else{
                $payment = DB::table('pays')
                              ->join('activations','activations.id','=','pays.activation_id')
                              ->join('rates','rates.id','=','activations.rate_id')
                              ->join('numbers','numbers.id','=','activations.numbers_id')
                              ->where('pays.activation_id',$activation_id)
                              ->where('pays.status','pendiente')
                              ->select('pays.*','rates.name AS rate_name','numbers.MSISDN AS sim')
                              ->orderBy('pays.date_pay','desc')
                              ->limit(1)
                              ->get();
                if(sizeof($payment) == 0){
                    $paymentData = array(
                        'http_monthly_code' => 0
                    );
                }else{
                    $paymentData = array(
                        'payment_id' => $payment[0]->id,
                        'amount' => $payment[0]->amount,
                        'date_pay' => $payment[0]->date_pay,
                        'date_pay_limit' => $payment[0]->date_pay_limit,
                        'status' => $payment[0]->status,
                        'rate_name' => $payment[0]->rate_name,
                        'sim' => $payment[0]->sim,
                        'http_monthly_code' => 1
                    );
                }
                
                return $paymentData;
            }
        }else if($type == 'instalation'){
            $payment = DB::table('ethernetpays')
                              ->join('instalations','instalations.id','=','ethernetpays.instalation_id')
                              ->join('packs','packs.id','=','instalations.pack_id')
                              ->where('ethernetpays.instalation_id',$act_inst_id)
                              ->where('ethernetpays.status','pendiente')
                              ->select('ethernetpays.*','packs.name AS rate_name','instalations.number AS sim')
                              ->orderBy('ethernetpays.date_pay','desc')
                              ->limit(1)
                              ->get();
            
            $paymentData = array();
            if(sizeof($payment) == 0){
                $paymentData = array(
                'http_monthly_code' => 0
            );
            }else{
                $paymentData = array(
                    'payment_id' => $payment[0]->id,
                    'amount' => $payment[0]->amount,
                    'date_pay' => $payment[0]->date_pay,
                    'date_pay_limit' => $payment[0]->date_pay_limit,
                    'status' => $payment[0]->status,
                    'rate_name' => $payment[0]->rate_name,
                    'sim' => $payment[0]->sim,
                    'http_monthly_code' => 1
                );
            }

            return $paymentData;
        }
    }

    public function setDataMonthly(Request $request){
        $payment_id = $request->get('payment_id');
        $amount = $request->get('amount');
        $type = $request->get('type');
        $msisdn = $request->get('msisdn');
        $current_id = auth()->user()->id;

        if($type == 'activation'){
            $x = Pay::where('id',$payment_id)->update([
                'amount_received' => $amount,
                'status' => 'completado',
                'status_consigned' => 'completado',
                'who_did_id' => $current_id,
                'who_consigned' => $current_id
            ]);

            if($x){
                $consultUF = app('App\Http\Controllers\AltanController')->consultUF($msisdn);
                $responseSubscriber = $consultUF['responseSubscriber'];
                $statusDN = $responseSubscriber['status'];

                if($statusDN ['subStatus'] == 'Suspend (B2W)' ){
                    
                    $responseUnbarring = Http::withHeaders([
                        'Content-type' => 'application/json'
                    ])->get('http://127.0.0.1/crm_altcel2/public/activate-deactivate/DN-finance',[
                        'msisdn' => $msisdn,
                        'type' => 'out_in',
                        'status' => 'inactivo'
                    ]);

                    return response()->json(['bool'=>$responseUnbarring['bool'],'message'=>$responseUnbarring['message']]);
                }

                return response()->json(['bool'=>1,'message'=>'La mensualidad se ha guardado con éxito.']);
            }else{
                return 0;
            }
        }else if($type == 'instalation'){
            $x = Ethernetpay::where('id',$payment_id)->update([
                'amount_received' => $amount,
                'status' => 'completado',
                'status_consigned' => 'completado',
                'who_did_id' => $current_id,
                'who_consigned' => $current_id
            ]);
            return response()->json(['bool'=>1,'message'=>'La mensualidad se ha guardado con éxito.']);
        }

        return $request;
    }

    public function createDeliveryFormat($activation){
        $deliveryData = DB::table('activations')
                    ->join('numbers','numbers.id','=','activations.numbers_id')
                    ->leftJoin('devices','devices.id','=','activations.devices_id')
                    ->join('petitions','petitions.id','=','activations.petition_id')
                    ->join('rates','rates.id','=','activations.rate_id')
                    ->where('activations.id',$activation)
                    ->select('numbers.icc_id','numbers.MSISDN','devices.no_serie_imei','devices.description AS especifications','activations.serial_number','activations.mac_address',
                    'petitions.who_attended','petitions.sender','activations.client_id','rates.name AS rate_name','petitions.payment_way','petitions.plazo')
                    ->get();

        $data['ICC'] = $deliveryData[0]->icc_id;
        $data['MSISDN'] = $deliveryData[0]->MSISDN;
        $data['rate_name'] = $deliveryData[0]->rate_name;

        $data['IMEI'] = $deliveryData[0]->no_serie_imei;
        $data['device_quantity'] = $data['IMEI'] == null ? 0 : 1;
        $data['IMEI'] = $data['IMEI'] == null ? 'No Asignado' : $deliveryData[0]->no_serie_imei;

        $data['especifications'] = $deliveryData[0]->especifications;
        $data['especifications'] = $data['especifications'] == null ? 'No Asignado' : $deliveryData[0]->especifications;

        $data['serial_number'] = $deliveryData[0]->serial_number;
        $data['serial_number'] = $data['serial_number'] == null ? 'No Asignado' : $deliveryData[0]->serial_number;

        $data['payment_way'] = $deliveryData[0]->payment_way;
        $data['payment_way'] = $data['payment_way'] == null ? 'No elegido' : $deliveryData[0]->payment_way;

        $data['plazo'] = $deliveryData[0]->plazo;
        $data['plazo'] = $data['plazo'] == null ? 'Sin plazo' : $deliveryData[0]->plazo;

        $mac_address = $deliveryData[0]->mac_address;

        if($mac_address == null){
            $mac_address_reverse = strrev($mac_address);
            $afterPrefix = substr($mac_address_reverse,4,1).substr($mac_address_reverse,3,1).substr($mac_address_reverse,1,1).substr($mac_address_reverse,0,1);
            $data['password'] = 'No Asignado';
            $data['red'] = 'No Asignado';
        }else{
            $mac_address_reverse = strrev($mac_address);
            $afterPrefix = substr($mac_address_reverse,4,1).substr($mac_address_reverse,3,1).substr($mac_address_reverse,1,1).substr($mac_address_reverse,0,1);
            $data['password'] = 'Altcel_'.$afterPrefix;
            $data['red'] = 'Altcel'.$afterPrefix;
        }
        

        $who_attended = $deliveryData[0]->who_attended;
        $who_attendedData = User::where('id',$who_attended)->first();
        $data['who_attended_name'] = strtoupper($who_attendedData->name.' '.$who_attendedData->lastname);

        $sender = $deliveryData[0]->sender;
        $senderData = User::where('id',$sender)->first();
        $data['sender_name'] = strtoupper($senderData->name.' '.$senderData->lastname);

        $client = $deliveryData[0]->client_id;
        $clientData = User::where('id',$client)->first();
        $data['client_name'] = strtoupper($clientData->name.' '.$clientData->lastname);

        $data['fecha'] = date('Y-M-d H:i:s');

        return view('activations.deliveryFormat',$data);
    }

    public function bulkActivations(){
        $data['clients'] = User::all();
        $data['rates'] = DB::table('rates')
                            ->join('offers','offers.id','=','rates.alta_offer_id')
                            ->where('rates.status','activo')
                            ->select('rates.id AS id','rates.name AS name','rates.price_subsequent AS price','offers.offerID AS offerID','offers.id AS offer_id')
                            ->get();
        return view('activations.createBatch',$data);
    }

    public function extractCSV(Request $request){
        if(request()->hasFile('file')){
            // Extracción de datos del request
            $offerID = $request->post('offerID');
            $scheduleDate = $request->post('scheduleDate');
            $client_id = $request->post('client_id');
            $clientson_id = $request->post('clientson_id');
            $offer_id = $request->post('offer_id');
            $rate_id = $request->post('rate_id');
            $csv = request()->file('file');
            // Apertura de archivo cargado con ICC's
            $fp = fopen ($csv,'r');
            $dataOffer = Offer::where('id',$offer_id)->first();
            $producto = $dataOffer->product;

            $response = [];
            $response['rowsInvalid'] = 0;
            $response['records'] = [];
            $length = 'bad';
            $msisdnBool = 0;
            $offerBool = 1;
            $coordinatesBool = 0;
            $dateBool = 0;
            $numberLine = 0;
            $flagValidateFile = 0;
            $msisdnExistente = '';
            $dateActivation = "";
            $count = 0;
            $arrayCSV = [];
            $errorDescription= "";

            // Iteración sobre los registros del CSV con ICC's
            while ($data = fgetcsv ($fp, 1000, ",")) {
                $numberLine++;
                $errorDescription= "";
                // Si la longitud de la fila es igual a 1, verificamos el datos existente en el índice 0
                if(sizeof($data) == 1){
                    $length = 'good';
                    // Validación de la existencia del ICC y extracción del MSISDN
                    $msisdnExists = Number::where('icc_id',$data[0])->exists();
                    if($msisdnExists){
                        $msisdnExistenteData = Number::where('icc_id',$data[0])->first();
                        $msisdnExistente = $msisdnExistenteData->MSISDN;
                        $msisdnStatus = $msisdnExistenteData->status;
                        $msisdnProducto = $msisdnExistenteData->producto;
                        $msisdnProducto = trim($msisdnProducto);
                        $msisdnBool = 1;

                        if($msisdnStatus == 'taken'){
                            $msisdnExists = false;
                            $errorDescription = "El MSISDN ya ha sido tomado.";
                            $msisdnBool = 0;
                        }

                        if($msisdnProducto != $producto){
                            $msisdnExists = false;
                            $errorDescription.= " La oferta elegida no es de tipo ".$msisdnProducto.".";
                            $msisdnBool = 0;
                        }
                    }else{
                        $msisdnExistente = $data[0];
                        $msisdnBool = 0;
                    }

                    // Validación de que la fecha de activación sea válida
                    $dateActivation = $scheduleDate;
                    $dateActivation = str_replace("/","",$dateActivation);
                    $dateActivation = str_replace("-","",$dateActivation);
                    $yearActivation = substr($dateActivation,0,4);
                    $monthActivation = substr($dateActivation,4,2);
                    $dayActivation = substr($dateActivation,6,2);
                    $dateValid = checkdate($monthActivation, $dayActivation, $yearActivation);
                    if($dateValid){
                        $dateBool = 1;
                    }else{
                        $dateBool = 0;
                        $errorDescription.= " La fecha de activación no es válida.";
                    }

                    // Sí el MSISDN no existe o si la fecha de activación no es válida, se guardará el registro como erróneo, de lo contrario se añadirá a un array para ser guardado en el archivo para Altán
                    if(!$msisdnExists || !$dateValid){
                        $flagValidateFile+=1;
                    }else{
                        $arrayCSV[$count] = array($msisdnExistente,$offerID,"",$dateActivation);
                        $count++;
                    }
                }else{
                    $length = 'bad';
                    $msisdnBool = 0;
                    $offerBool = 0;
                    $coordinatesBool = 1;
                    $dateBool = 0;
                    $flagValidateFile+=1;
                    $msisdnExistente = $data[0];
                    $errorDescription = "El tamaño de las filas no es el adecuado, debe ser 1 registro por fila.";
                }

                // Rellenado de array para mostrar los resultados de los registros extraídos respecto al CSV con ICC's
                array_push($response['records'],array(
                    'length' => $length,
                    'msisdnBool' => $msisdnBool,
                    'offerBool' => $offerBool,
                    'coordinatesBool' => $coordinatesBool,
                    'dateBool' => $dateBool,
                    'numberLine' => $numberLine,
                    'msisdn' => $msisdnExistente,
                    'offerID' => $offerID,
                    'coordinates' => "",
                    'scheduleDate' => $dateActivation,
                    'errorDescription' => $errorDescription
                ));
                
            }
            // Ruta del archivo a enviar a Altan
            $ruta = "storage/mibatch.csv";
            
            $delimitador = ",";
            $encapsulador = '"';
            // Apertura de archivo para su escritura
            $file_handle = fopen($ruta, 'w');
            foreach ($arrayCSV as $linea) {
                fputcsv($file_handle, $linea, $delimitador, $encapsulador);
            }
            rewind($file_handle);
            fclose($file_handle);

            // Cantidad de registros inválidos
            $response['rowsInvalid'] = $flagValidateFile;
            
            // Apertura de archivo CSV generado para Altán para su lectura
            $fpT = fopen ($ruta,'r');
            // Si el tamaño del array guardado en el CSV es mayor a 0, se hará la petición Altán
            if(sizeof($arrayCSV) > 0){
                $accessToken = app('App\Http\Controllers\AltanController')->accessTokenRequestPost();
                if($accessToken['status'] == 'approved'){
                    $accessToken = $accessToken['accessToken'];
                    $url_production = 'https://altanredes-prod.apigee.net/cm-sandbox/v1/subscribers/activations';
                
                    $res = Http::withHeaders([
                        'Authorization' => 'Bearer '.$accessToken,
                        'Content-Type' => 'multipart/form-data'
                    ])->post($url_production,[
                        'archivos' => file_get_contents($ruta)
                    ]);

                    $response['REQUEST_RESULT']['status'] = 0;
                    if(isset($res['transaction'])){
                        $transaction = $res['transaction'];
                        $id = $transaction['id'];
                        $response['REQUEST_RESULT']['status'] = 1;
                        $response['REQUEST_RESULT']['lines'] = $res['lines'];
                        $response['REQUEST_RESULT']['effectiveDate'] = $res['effectiveDate'];
                        $response['REQUEST_RESULT']['transaction_id'] = $id;
                        $response['recordsDB'] = [];
                        $who_did_id = auth()->user()->id;

                        // Iteración de los registros guardados en el CSV para su inserción en la DB como activaciones
                        while ($data = fgetcsv ($fpT, 1000, ",")) {
                            $msisdn = $data[0];
                            $dataNumber = Number::where('MSISDN',$msisdn)->first();
                            $number_id = $dataNumber->id;
                            $offerID = $data[1];
                            $scheduleDate = $data[3];
                            $dataRate = Rate::where('id',$rate_id)->first();
                            $price = $dataRate->price;


                            Activation::insert([
                                'client_id' => $client_id,
                                'numbers_id' => $number_id,
                                'who_did_id' => $who_did_id,
                                'offer_id' => $offer_id,
                                'rate_id' => $rate_id,
                                'amount' => 0.00,
                                'amount_device' => 0.00,
                                'amount_rate' => $price,
                                'date_activation' => $scheduleDate,
                                'clientson_id' => $clientson_id,
                                'payment_status' => 'pendiente',
                                'status' => 'activated',
                                'flag_rate' => 1,
                                'rate_subsequent' => $rate_id
                            ]);

                            Number::where('MSISDN',$msisdn)->update(['status' => 'taken']);

                            array_push($response['recordsDB'],array(
                                'msisdn' => $msisdn,
                                'offerID' => $offerID,
                                'scheduleDate' => $scheduleDate
                            ));
                        }
                    }
                    
                    return $response;
                }
            }

            return $response;
        }
    }

    public function deleteActivation(Request $request){
        $activation_id = $request->get('activation_id');
        $type = $request->get('type');
        $reason = $request->get('reason');
        $amount = $request->get('amount');
        $amount = $amount == null || $amount == '' ? 0 : $amount;
        $dataActivation = Activation::where('id',$activation_id)->first();
        $device_id = $dataActivation->devices_id;
        $dataNumber = Number::where('id',$dataActivation->numbers_id)->first();
        $msisdn = $dataNumber->MSISDN;

        $accessToken = app('App\Http\Controllers\AltanController')->accessTokenRequestPost();
        if($accessToken['status'] == 'approved'){
            $accessToken = $accessToken['accessToken'];
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$accessToken,
                'Content-Type' => 'application/json'
            ])->post('https://altanredes-prod.apigee.net/cm/v1/subscribers/'.$msisdn.'/deactivate',[
                'scheduleDate' => null
            ]);

            if(isset($response['order'])){
                $dataDeactivation = [
                    'MSISDN' => $response['msisdn'],
                    'effectiveDate' => $response['effectiveDate'],
                    'order_id' => $response['order']['id'],
                    'reason' => $reason,
                    'activation_id' => $activation_id,
                    'who_did_id' => auth()->user()->id,
                    'amount' => $amount
                ];

                Number::where('id',$dataActivation->numbers_id)->update(['status_altan'=>'deactivated']);
                
                if($type == 'restore'){
                    if($device_id != null){
                        Device::where('id',$device_id)->update(['status'=>'available']);
                    }
                }
    
                $x = Deactivation::insert($dataDeactivation);
                Activation::destroy($activation_id);
                if($x){
                    return response()->json(['http_code'=>1,'message'=>'Baja de la SIM '.$msisdn.' hecha con éxito']);
                }else{
                    return response()->json(['http_code'=>0,'message'=>'La baja de la SIM '.$msisdn.' se realizó, pero no se guardó el registro en el sistema.']);
                }
            }else{
                return response()->json(['http_code'=>0,'message'=>$response['description']]);
            }
            

            
        }else{
            return response()->json(['http_code'=>0,'message'=>'Solicitud de Token no aprobada.']);
        }
    }
}
