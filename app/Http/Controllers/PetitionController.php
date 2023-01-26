<?php

namespace App\Http\Controllers;

use DB;
use Http;
use App\Rate;
use App\User;
use App\Offer;
use App\Client;
use App\Device;
use App\Number;
use App\Petition;
use App\Activation;
use App\Directory;
use App\Mail\SendPetition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class PetitionController extends Controller
{
    public function index()
    {
        $y = DB::table('petitions')
               ->join('users', 'users.id', '=', 'petitions.sender')
               ->join('rates','rates.id','=','petitions.rate_activation')
               ->where('petitions.status', '=', 'solicitud')
               ->select('petitions.*', 'users.name AS name_sender', 'users.lastname AS lastname_sender','rates.name AS rate_name')
               ->get();
        // return $x;
        $data['solicitudes'] = [];
        foreach($y as $x){
            $id = $x->id;
            $id_sender = $x->sender;
            $name_sender = $x->name_sender.' '.$x->lastname_sender;
            $status = $x->status;
            $date_sent = $x->date_sent;
            $comment = $x->comment;
            $product = $x->product;
            $client_id = $x->client_id;
            $type = 'local';

            $icc = $x->icc;
            $imei = $x->imei;
            $serial_number = $x->serial_number;
            $mac_address = $x->mac_address;
            
            
            if($x->number_id != null){
                $type = 'external';
            }

            $client = User::where('id', $client_id)->select('name', 'lastname')->get();

            array_push($data['solicitudes'], array(
                'id'=>$id,
                'id_client'=>$client_id,
                'id_sent'=>$id_sender,
                'name_sender'=>$name_sender,
                'status'=>$status,
                'date_sent'=>$date_sent,
                'comment'=>$comment,
                'product'=>$product,
                'client'=>$client[0]->name.' '.$client[0]->lastname,
                'rate_activation' => $x->rate_name,
                'rate_id' => $x->rate_activation,
                'payment_way' => $x->payment_way,
                'plazo' => $x->plazo,
                'lada' => $x->lada,
                'icc' => $x->icc,
                'imei' => $x->imei,
                'serial_number' => $x->serial_number,
                'mac_address' => $x->mac_address,
                'type' => $type
            ));

        }

        $otherpetitions = DB::table('otherpetitions')
                             ->join('numbers','numbers.id','=','otherpetitions.number_id')
                             ->join('activations','activations.numbers_id','=','numbers.id')
                             ->join('users','users.id','=','activations.client_id')
                             ->where('otherpetitions.status','pendiente')
                             ->select('otherpetitions.*','numbers.MSISDN AS msisdn','users.name AS client_name','users.lastname AS client_lastname','users.email AS client_email')
                             ->get();

        $data['otherpetitions'] = [];
        foreach ($otherpetitions as $otherpetition) {
            $user = User::find($otherpetition->who_did_id);
            array_push($data['otherpetitions'],array(
                'id' => $otherpetition->id,
                'msisdn' => $otherpetition->msisdn,
                'type' => $otherpetition->type,
                'status' => $otherpetition->status,
                'comment' => $otherpetition->comment,
                'client' => $otherpetition->client_name.' '.$otherpetition->client_lastname.' '.$otherpetition->client_email,
                'dealer' => $user->name.' '.$user->lastname.' '.$user->email
            ));
        }
        // return $data;
        return view('petitions.solicitudOperaciones', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request['date_sent'] = date('Y-m-d H:i:s');
        $directory_id = $request['directory_id'];
        $attended_by = $request['sender'];
        $request = request()->except('_token','directory_id');
        $x = Petition::insert($request);
        
        if($x){
            $x = Directory::where('id',$directory_id)->update(['attended_by'=>$attended_by]);
            if($x){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function show(Petition $petition)
    {
        $currentRol = auth()->user()->role_id;
        if ($currentRol == 1 || $currentRol == 6) {
            $x = DB::table('petitions')
                   ->join('users', 'users.id', '=', 'petitions.sender')
                   ->leftJoin('rates','rates.id','=','petitions.rate_activation')
                   ->where('petitions.status', '=', 'recibido')
                   ->orwhere('petitions.status', '=', 'activado')
                   ->select('petitions.*', 'users.name AS name_sender', 'users.lastname AS lastname_sender','rates.name AS rate_name')
                   ->get();
        }elseif ($currentRol == 5) {
            $x = DB::table('petitions')
                   ->join('users', 'users.id', '=', 'petitions.sender')
                   ->join('rates','rates.id','=','petitions.rate_activation')
                   ->where('petitions.status', '=', 'activado')
                   ->select('petitions.*', 'users.name AS name_sender', 'users.lastname AS lastname_sender','rates.name AS rate_name')
                   ->get();
        }
        // return $x;
        $data['completadas'] = [];
        foreach($x as $y){
            $id = $y->id;
            $id_sender = $y->sender;
            $name_sender = $y->name_sender.' '.$y->lastname_sender;
            $status = $y->status;
            $comment = $y->comment;
            $product = $y->product;
            $client_id = $y->client_id;
            $cobroCpe = $y->collected_device;
            $cobroPlan = $y->collected_rate;
            $date_sent = $y->date_sent;
            $who_attended = $y->who_attended;
            $date_activated = $y->date_activated;
            $recibido = $y->who_received;
            $fechaRecibido = $y->date_received;
            $payment_way = $y->payment_way;
            $plazo = $y->plazo;

            $client = User::where('id', $client_id)->select('name', 'lastname')->get();
            $attended = User::where('id', $who_attended)->select('name', 'lastname')->get();

            if($y->who_received != null){
                $recibido1 = User::where('id', $recibido)->select('name', 'lastname')->get();
                $recibido = $recibido1[0]->name.' '.$recibido1[0]->lastname;
            }else{
                $recibido = 'Por recibir';
            }

            if ($status == 'recibido') {
                
                $badgeStatus = 'success';
                
            }else {
                $badgeStatus = 'warning';
            }

            if ($fechaRecibido != null) {
                $badgeFecha = 'success';
                
            }else{
                $fechaRecibido = 'Por Recibir';
                $badgeFecha = 'warning';
            }

            if($payment_way == null){
                $payment_way = 'No elegido';
            }

            if($plazo == null){
                $plazo = 'No elegido';
            }

            array_push($data['completadas'], array(
                'id'=>$id,
                'id_sendt'=>$id_sender,
                'id_client'=>$client_id,
                'client'=>$client[0]->name.' '.$client[0]->lastname,
                'product'=>$product,
                'status'=>$status,
                'cobroCpe'=> $cobroCpe,
                'cobroPlan'=>$cobroPlan,
                'fecha_solicitud'=>$date_sent,
                'activadoPor'=>$attended[0]->name.' '.$attended[0]->lastname,
                'date_activated'=>$date_activated,
                'recibido'=>$recibido,
                'dateRecibido'=>$fechaRecibido,
                'comment'=>$comment,
                'badgeFecha'=>$badgeFecha,
                'badgeStatus'=>$badgeStatus,
                'rate_activation' => $y->rate_name,
                'payment_way' => $payment_way,
                'plazo' => $plazo,
                'name_sender' => $name_sender
            )); 
        }
        // return $data['completadas'];
        
        return view('petitions.completadosOperaciones', $data);
    }

    public function recibidosFinance(Request $request){
        
        if(isset($request['start']) && isset($request['end'])){
            if($request['start'] != null && $request['end'] != null){
                $year =  substr($request['start'],6,4);
                $month = substr($request['start'],0,2);
                $day = substr($request['start'],3,2);
                $date_init = $year.'-'.$month.'-'.$day.' 00:00:00';

                $year =  substr($request['end'],6,4);
                $month = substr($request['end'],0,2);
                $day = substr($request['end'],3,2);
                $date_final = $year.'-'.$month.'-'.$day.' 23:59:59';

                // return $date_init.' y '.$date_final;
                $x = DB::table('petitions')
                        ->join('users', 'users.id', '=', 'petitions.sender')
                        ->join('rates','rates.id','=','petitions.rate_activation')
                        ->where('petitions.status', '=', 'recibido')
                        ->whereBetween('petitions.date_received', [$date_init, $date_final])
                        ->select('petitions.*', 'users.name AS name_sender', 'users.lastname AS lastname_sender','rates.name AS rate_name')
                        ->get();

                $data['fecha'] = 'Mostrando registros en el rango de '.substr($date_init,0,-8).' a '.substr($date_final,0,-8);
                // $data['fechaFinal'] = $;
            }
        }else{
            $x = DB::table('petitions')
                   ->join('users', 'users.id', '=', 'petitions.sender')
                   ->join('rates','rates.id','=','petitions.rate_activation')
                   ->where('petitions.status', '=', 'recibido')
                   ->select('petitions.*', 'users.name AS name_sender', 'users.lastname AS lastname_sender','rates.name AS rate_name')
                   ->get();

            $data['fecha'] = 'Mostrando todos los registros';
        }
        $data['totalcpe'] = 0;
        $data['totalplan'] = 0;
        $data['completadas'] = [];
        foreach($x as $y){
            $id = $y->id;
            $id_sender = $y->sender;
            $name_sender = $y->name_sender.' '.$y->lastname_sender;
            $status = $y->status;
            $comment = $y->comment;
            $product = $y->product;
            $client_id = $y->client_id;
            $cobroCpe = $y->collected_device;
            $cobroPlan = $y->collected_rate;
            $date_sent = $y->date_sent;
            $who_attended = $y->who_attended;
            $date_activated = $y->date_activated;
            $recibido = $y->who_received;
            $fechaRecibido = $y->date_received;
            $payment_way = $y->payment_way;
            $plazo = $y->plazo;

            $client = User::where('id', $client_id)->select('name', 'lastname')->get();
            $attended = User::where('id', $who_attended)->select('name', 'lastname')->get();

            if ($status == 'recibido') {
                $recibido1 = User::where('id', $recibido)->select('name', 'lastname')->get();
                $recibido = $recibido1[0]->name.' '.$recibido1[0]->lastname;
                $badgeStatus = 'success';
            }

            if ($fechaRecibido != null) {
                $badgeFecha = 'success';
            }

            if($payment_way == null){
                $payment_way = 'No elegido';
            }

            if($plazo == null){
                $plazo = 'No elegido';
            }

            array_push($data['completadas'], array(
                'id'=>$id,
                'id_sendt'=>$id_sender,
                'id_client'=>$client_id,
                'client'=>$client[0]->name.' '.$client[0]->lastname,
                'product'=>$product,
                'status'=>$status,
                'cobroCpe'=> $cobroCpe,
                'cobroPlan'=>$cobroPlan,
                'fecha_solicitud'=>$date_sent,
                'activadoPor'=>$attended[0]->name.' '.$attended[0]->lastname,
                'date_activated'=>$date_activated,
                'recibido'=>$recibido,
                'dateRecibido'=>$fechaRecibido,
                'comment'=>$comment,
                'badgeFecha'=>$badgeFecha,
                'badgeStatus'=>$badgeStatus,
                'rate_activation' => $y->rate_name,
                'payment_way' => $payment_way,
                'plazo' => $plazo,
            ));
            $data['totalcpe'] += $y->collected_device;
            $data['totalplan'] += $y->collected_rate;
        }

        return view('petitions.completadosFinanzas', $data);
    }

    public function activationOperaciones(Request $request){
        $id_client = $request['idClient'];

        $data = DB::table('users')
                  ->leftJoin('clients','users.id','=','clients.user_id')
                  ->where('users.id', $id_client)
                  ->select('users.name','users.lastname','users.email','clients.address','clients.rfc','clients.ine_code', 'clients.date_born','clients.cellphone')
                  ->get();  
        return $data;
    }

    public function activateDealerPetition(Petition $petition){
        $data['sender'] = User::where('id',$petition->sender)->first();
        $data['client'] = User::where('id',$petition->client_id)->first();
        $data['dataClient'] = Client::where('user_id',$petition->client_id)->first();
        $data['rate'] = Rate::where('id',$petition->rate_activation)->first();
        $data['offer'] = Offer::where('id',$data['rate']->alta_offer_id)->first();
        $data['number'] = Number::where('id',$petition->number_id)->first();
        $data['device'] = Device::where('id',$petition->device_id)->first();
        // $data['rates'] = Rate::all()->where('id','!=',$petition->rate_activation);
        $data['rates'] = DB::table('rates')
                            ->join('offers','offers.id','=','rates.alta_offer_id')
                            ->where('rates.id','!=',$petition->rate_activation)
                            ->where('offers.product',$petition->product)
                            ->select('rates.*')
                            ->get();
        $data['petition'] = $petition;

        return view('petitions.petitionDealerShow',$data);
    }

    public function changeRatePetition(Request $request){
        $petition_id = $request->post('petition_id');
        $rate_id = $request->post('rate_id');
        $x = Petition::where('id',$petition_id)->update(['rate_activation'=>$rate_id,'rate_secondary'=>$rate_id]);

        if($x){
            return 1;
        }else{
            return 0;
        }
    }

    public function collectMoney(Request $request){
        $collectedCPE = $request->post('collectedCPE');
        $collectedRate = $request->post('collectedRate');
        $petition_id = $request->post('petition_id');
        // return $request;

        $data = DB::table('petitions')
                   ->join('activations','activations.petition_id','=','petitions.id')
                   ->where('petitions.id',$petition_id)
                   ->select('activations.amount_rate AS amount_rate','activations.amount_device AS amount_device', 'activations.id AS activation_id')
                   ->get();

        $amount_rate = $data[0]->amount_rate;
        $amount_device = $data[0]->amount_device;
        $activation_id = $data[0]->activation_id;

        $residuaryRate = $amount_rate-$collectedRate;
        $residuaryDevice = $amount_device-$collectedCPE;

        return response()->json([
            'residuaryRate' => $residuaryRate,
            'residuaryDevice' => $residuaryDevice,
            'petition_id' => $petition_id,
            'activation_id' => $activation_id,
            'amount_rate' => $amount_rate,
            'amount_device' => $amount_device,
        ]);
    }

    public function saveCollected(Request $request){
        $collected_amount_cpe = $request->post('received_amount_cpe');
        $collected_amount_rate = $request->post('received_amount_rate');
        $who_received = $request->post('who_received');
        $activation_id = $request->post('activation_id');
        $petition_id = $request->post('petition_id');

        $dataActivation = Activation::where('id',$activation_id)->first();
        $dataPetition = Petition::where('id',$petition_id)->first();

        $amount_rate = $dataActivation->amount_rate;
        $amount_device = $dataActivation->amount_device;
        $received_amount_rate = $dataActivation->received_amount_rate;
        $received_amount_device = $dataActivation->received_amount_device;

        $received_amount_rate = $received_amount_rate+$collected_amount_rate;
        $received_amount_device = $received_amount_device+$collected_amount_cpe;

        $statusPaymentActivation = 'pendiente';
        $statusPetition = 'activado';
        $date_received = date('Y-m-d H:i:s');

        if(($received_amount_rate >= $amount_rate) && ($received_amount_device >= $amount_device)){
            $statusPaymentActivation = 'completado';
            $statusPetition = 'recibido';
        }

        

        $x = Activation::where('id',$activation_id)->update([
                'received_amount_rate' => $received_amount_rate,
                'received_amount_device' => $received_amount_device,
                'payment_status' => $statusPaymentActivation
            ]);

        $y = Petition::where('id',$petition_id)->update([
                'collected_rate' => $received_amount_rate,
                'collected_device' => $received_amount_device,
                'who_received' => $who_received,
                'status' => $statusPetition,
                'date_received' => $date_received
            ]);

        
            if($statusPetition == 'recibido'){
                $name_remitente = auth()->user()->name;
                $comment = Petition::where('id',$petition_id)->select('comment','client_id','product')->get();
                
                $client = $comment[0]->client_id;
                $user = User::where('id', $client)->select('name', 'lastname','email')->get();
    
                //correos finanzas
                $response = Http::withHeaders([
                    'Conten-Type'=>'application/json'
                ])->get('http://10.44.0.70/petitions-notifications',[
                    'name'=>$user[0]->name,
                    'lastname'=>$user[0]->lastname,
                    'correo'=> $user[0]->email,
                    'comment'=>$comment[0]->comment,
                    'status'=>'recibido',
                    'product'=>$comment[0]->product,
                    'remitente'=>$name_remitente
                ]);
            }

        if($x && $y){
            return 1;
        }else{
            return 0;
        }
    }

    public function getActivation($petition){
        $activation = Activation::where('petition_id',$petition)->first();
        $activation_id = $activation->id;
        return $activation_id;
    }

    public function petitiosNotification(Request $request){
        $status = $request->get('status');
        $name = $request->get('name');
        $lastname = $request->get('lastname');
        $remitente = $request->get('remitente');
        $comment = $request->get('comment');
        $correo = $request->get('correo');
        $product = $request->get('product');
        $email_remitente = $request->get('email_remitente');

        $email = ['armando.g@altcel.com', 'soporte1@altcel.com', 'sandra_corzo@altcel.com', 'keila_vazquez@altcel.com', 'jeremias_vicente@altcel.com', 'jalexis_santana@altcel.com', 'leopoldo_martinez@altcel.com','soporte2@altcel.com','auxiliar_contable@altcel.com'];
        
        if ($status == 'solicitud') {
            $data= [
                "subject"=>"SOLICITUD DE ACTIVACIÓN DE SIM",
                "name" => $name,
                "lastname" => $lastname,
                "comment"=>$comment,
                "remitente"=>$remitente,
                "email_remitente"=>$email_remitente,
                "status"=>$status,
                "correo"=>$correo,
                "product"=>$product,
                "email"=>$email,
                "body"=>$email[1].", ".$email[0]." y ".$email[7].", tienen una nueva solicitud de",
            ];
            Mail::to('charlesrootsman97@gmail.com')->send(new SendPetition($data));
            Mail::to($email[0])->send(new SendPetition($data));
            Mail::to($email[1])->send(new SendPetition($data));
            Mail::to($email[7])->send(new SendPetition($data));
            return response()->json(['http_code'=>'200','message'=>'Correo enviado...']);
        }elseif ($status == 'activado') {
            $data= [
                "subject" => "LA SIM SOLICITADA HA SIDO ACTIVADA",
                "name" => $name,
                "lastname" => $lastname,
                "comment"=>$comment,
                "remitente"=>$remitente,
                "email_remitente"=>$email_remitente,
                "status"=>$status,
                "correo"=>$correo,
                "product"=>$product,
                "email"=>$email,
                "body"=>"para notificarles que se activó"
            ];
            Mail::to($email[2])->send(new SendPetition($data));
            Mail::to($email[3])->send(new SendPetition($data));
            Mail::to($email[4])->send(new SendPetition($data));
            Mail::to($email[5])->send(new SendPetition($data));
            Mail::to($email[6])->send(new SendPetition($data));
            Mail::to($email[8])->send(new SendPetition($data));
            return response()->json(['http_code'=>'200','message'=>'Correo enviado...']);
        }elseif ($status == 'recibido') {
            $data= [
                "subject" => "IMPORTE DE ACTIVACIÓN DE SIM RECIBIDO COMPLETAMENTE",
                "name" => $name,
                "lastname" => $lastname,
                "comment"=>$comment,
                "remitente"=>$remitente,
                "email_remitente"=>$email_remitente,
                "status"=>$status,
                "correo"=>$correo,
                "product"=>$product,
                "email"=>$email,
                "body"=>"para notificarles que se entregó"
            ];
            Mail::to($email[0])->send(new SendPetition($data));
            Mail::to($email[1])->send(new SendPetition($data));
            Mail::to($email[5])->send(new SendPetition($data));
            Mail::to($email[6])->send(new SendPetition($data));
            Mail::to($email[7])->send(new SendPetition($data));
            return response()->json(['http_code'=>'200','message'=>'Correo enviado...']);
        }elseif($status == 'other'){
            $subject = $request->get('subject');
            $description = $request->get('description');
            $data= [
                "subject"=>$subject,
                "name" => $name,
                "lastname" => $lastname,
                "comment"=>$comment,
                "remitente"=>$remitente,
                "email_remitente"=>$email_remitente,
                "status"=>$status,
                "correo"=>$correo,
                "product"=>' ',
                "email"=>$email,
                "body"=>$email[1].", ".$email[0]." y ".$email[7].", ".$description,
            ];
            Mail::to($email[0])->send(new SendPetition($data));
            Mail::to($email[1])->send(new SendPetition($data));
            Mail::to($email[7])->send(new SendPetition($data));
            return response()->json(['http_code'=>'200','message'=>'Correo enviado...']);
        }
    }

    public function lineNewCRM(Request $request){
        $data['lineNews'] = DB::connection('corp_pos')->table('ra_activations')->leftJoin('ra_users','ra_users.id','=','ra_activations.distribuidor_id')->where('ra_activations.tipo', 'activacion')->select('ra_activations.cliente AS client', 'ra_activations.product','ra_activations.msisdn', 'ra_activations.icc', 'ra_activations.amount','ra_users.username', 'ra_activations.rate', 'ra_activations.date')->orderBy('ra_activations.date', 'DESC')->get();
        // return $lineNew;
        
        return view('petitions.lineaNuevaAltcel', $data);
    }

    public function changeStatusLine(Request $request){
        // return $request;
        $petition = $request->idPetion;
        $userId = $request->get('userId');

        $data = DB::table('users')->where('id', $userId)->get();
        $name = $data[0]->name;
        $lastname = $data[0]->lastname;

        $user = $name.' '.$lastname;
        return $user;

        $x = DB::connection('mysql2')->table('alt_solicitudeslineasnuevas')->where('id', $petition)->update([
            'status' => 'Finalizado'
        ]);

        if($x){
            return response()->json(['http_code'=>1]);
        }else{
            return response()->json(['http_code'=>0]);
        }
    }
}

// ->cc($email[5])->cc($email[6]) ->cc($email[4])->cc($email[5])->cc($email[6])