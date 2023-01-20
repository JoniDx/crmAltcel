<?php

namespace App\Http\Controllers;

use DB;
use DateTime;
use App\Rate;
use App\User;
use App\Offer;
use App\Number;
use App\Activation;
use App\Portability;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AltanController;

class PortabilityController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id == 10) {
            $pendings = Portability::all()->where('status','pendiente')->where('who_did_it', 253)->sortByDesc('created_at');
            $activateds = Portability::all()->where('status','activado')->where('who_did_it', 253)->sortByDesc('created_at');
            $completeds = Portability::all()->where('status','completado')->where('who_did_it', 253)->sortByDesc('created_at');
        } else {
            $pendings = Portability::all()->where('status','pendiente')->sortByDesc('created_at');
            $activateds = Portability::all()->where('status','activado')->sortByDesc('created_at');
            $completeds = Portability::all()->where('status','completado')->sortByDesc('created_at');
        }

        $arrayPending = [];
        $arrayActivated = [];
        $arrayCompleted = [];

        foreach ($pendings as $pending) {
            $who_did_it = User::where('id',$pending->who_did_it)->first();
            $who_attended = User::where('id',$pending->who_attended)->first();
            $client = User::where('id','=',$pending->client_id)->first();
            $rate = Rate::where('id','=',$pending->rate_id)->first();
            $date_format =  $pending->created_at;
            if ($date_format == null) {
                $date_format = 'N/A';
            }
            
            array_push($arrayPending,array(
                'id' => $pending->id,
                'msisdnPorted' => $pending->msisdnPorted,
                'icc' => $pending->icc,
                'msisdnTransitory' => $pending->msisdnTransitory,
                'date' => $pending->date,
                'approvedDateABD' => $pending->approvedDateABD,
                'nip' => $pending->nip,
                'client' => $client->name.' '.$client->lastname,
                'who_did_it' =>$pending->dealer_username == null ? $who_did_it->name.' '.$who_did_it->lastname : $pending->dealer_username,
                'who_attended' => $who_attended = $who_attended == null ? 'N/A' : $who_attended->name.' '.$who_attended->lastname,
                'name_rate' => $rate->name,
                'amount' => number_format($rate->price,2),
                'comments' => $pending->comments,
                'created_at' => $date_format

            ));
        }

        foreach ($activateds as $activated) {
            $who_did_it = User::where('id',$activated->who_did_it)->first();
            $who_attended = User::where('id',$activated->who_attended)->first();
            $client = User::where('id','=',$activated->client_id)->first();
            $rate = Rate::where('id','=',$activated->rate_id)->first();
            $date_format =  $activated->created_at;
            if ($date_format == null) {
                $date_format = 'N/A';
            }
            
            array_push($arrayActivated,array(
                'id' => $activated->id,
                'msisdnPorted' => $activated->msisdnPorted,
                'icc' => $activated->icc,
                'msisdnTransitory' => $activated->msisdnTransitory,
                'date' => $activated->date,
                'approvedDateABD' => $activated->approvedDateABD,
                'nip' => $activated->nip,
                'client' => $client->name.' '.$client->lastname,
                'who_did_it' =>$activated->dealer_username == null ? $who_did_it->name.' '.$who_did_it->lastname : $activated->dealer_username,
                'who_attended' => $who_attended = $who_attended == null ? 'N/A' : $who_attended->name.' '.$who_attended->lastname,
                'name_rate' => $rate->name,
                'amount' => number_format($rate->price,2),
                'comments' => $activated->comments,
                'ABD' => $activated->ABD,
                'created_at' => $date_format
            ));
        }

        foreach ($completeds as $completed) {
            $who_did_it = User::where('id',$completed->who_did_it)->first();
            $who_attended = User::where('id',$completed->who_attended)->first();
            $client = User::where('id',$completed->client_id)->first();
            $rate = Rate::where('id','=',$completed->rate_id)->first();
            $date_format =  $completed->created_at;
            if ($date_format == null) {
                $date_format = 'N/A';
            }
            array_push($arrayCompleted,array(
                'msisdnPorted' => $completed->msisdnPorted,
                'icc' => $completed->icc,
                'msisdnTransitory' => $completed->msisdnTransitory,
                'date' => $completed->date,
                'approvedDateABD' => $completed->approvedDateABD,
                'nip' => $completed->nip,
                'client' => $client->name.' '.$client->lastname,
                'who_did_it' =>$completed->dealer_username == null ? $who_did_it->name.' '.$who_did_it->lastname : $completed->dealer_username,
                'who_attended' => $who_attended = $who_attended == null ? 'N/A' : $who_attended->name.' '.$who_attended->lastname,
                'name_rate' => $rate->name,
                'amount' => number_format($rate->price,2),
                'comments' => $completed->comments,
                'created_at' => $date_format
            ));
        }

        $data['pendings'] = $arrayPending;
        $data['activateds'] = $arrayActivated;
        $data['completeds'] = $arrayCompleted;

        return view('portabilities.index',$data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Portability $portability)
    {
        //
    }

    public function edit(Portability $portability)
    {
        //
    }

    public function update(Request $request, Portability $portability)
    {
        //
    }

    public function destroy(Portability $portability)
    {
        //
    }

    public function destroyPort(Request $request){
        $port=Portability::find($request->id);        
        if ($port->delete()) {
            return true;   
        } else {
            return false;    
        }        
    }

    public function doActivationPort(Request $request){
        $portability = Portability::where('id',$request['id'])->first();
        $number = Number::where('icc_id', $portability->icc)->first();
        if (!($number->status == 'available')) {
            return false;
        }

        $date_portability = date('Y-m-d', strtotime($portability->date));
        $date_portability = Carbon::createFromFormat('Y-m-d', $portability->date);
        $date_now = Carbon::now();

        if ($date_now > $date_portability) {
            $date_portability = date('Y-m-d', strtotime($date_now));
            // Portability::where('id', $request['id'])->update(['date' => $date_portability]);
        } 

        $client_id = $portability->client_id;
        $rate_id = $portability->rate_id;
        $rate = Rate::where('id',$rate_id)->first();
        $offer_id = $rate->alta_offer_id;
        $offer = Offer::where('id',$offer_id)->first();
        $offerID = $offer->offerID;
        $product = $offer->product;
        $product = trim($product);
        $msisdn = $portability->msisdnTransitory;
        $icc = $portability->icc;
        $number = Number::where('icc_id',$icc)->first();
        $number_id = $number->id;
        $who_did_id = $request['user_id'];
        $amount = $rate->price;
        $date_activation = $portability->date;
        $scheduleDate = str_replace('-', '', $date_portability);

        $insertActivation = [
            "client_id" => $client_id,
            "numbers_id" => $number_id,
            "who_did_id" => $who_did_id,
            "offer_id" => $offer_id,
            "rate_id" => $rate_id,
            "amount" => $amount,
            "received_amount_rate" => $amount,
            "date_activation" => $date_activation,
            "rate_subsequent" => $rate_id,
            "flag_rate" => 1,
            "portabilidad" => 1
        ];
        $user = Auth::user();
        if ($user->id != 162) {
            // CODIGO MIENTRAS SE SOLUCIONA PROBLEMA CON LA API
            $activation = Activation::insert($insertActivation);
            Number::where('icc_id', 'like','%'.$icc.'%')->update([
                'status' => 'taken'
            ]);
    
            if($activation){
                // $order_id = $activationAltan['order']['id'];
                Portability::where('id',$request['id'])->update(['status'=>'activado','who_attended'=>$who_did_id,]);
                return response()->json(['http_code' => 200,'message' => 'Activación hecha con éxito.'],200);
            }else{
                return response()->json(['http_code' => 500,'message' => 'La activación se realizó correctamente, pero no se guardo en nuestra DB, NOTIFIQUE A DESARROLLO.']);
            }
        }

        $accessToken = app('App\Http\Controllers\AltanController')->accessTokenRequestPost();
        if($accessToken['status'] == 'approved'){
            $accessToken = $accessToken['accessToken'];
           
            $activationAltan = app('App\Http\Controllers\AltanController')->activationRequestPost($accessToken,$msisdn,$offerID,'','',$product,$scheduleDate);

            $consultUF = app('App\Http\Controllers\AltanController')->consultUF($msisdn);
            $responseSubscriber = $consultUF['responseSubscriber'];
            $status = $responseSubscriber['status']['subStatus'];

            if($status == 'Idle'){
                $activationAltan = app('App\Http\Controllers\AltanController')->activationRequestPost($accessToken,$msisdn,$offerID,'','',$product,$scheduleDate);
            }else if($status == 'Active'){
                $activationAltan['msisdn'] = $msisdn;
                $activationAltan['order']['id'] = $msisdn;
            }
            
            if(isset($activationAltan['msisdn']) && $activationAltan['msisdn'] == $msisdn){
                $activation = Activation::insert($insertActivation);

                if($activation){
                    $order_id = $activationAltan['order']['id'];
                    Number::where('icc_id', 'like','%'.$icc.'%')->update([
                        'status' => 'taken'
                    ]);
                    Portability::where('id',$request['id'])->update(['status'=>'activado','who_attended'=>$who_did_id,'order_id'=>$order_id]);
                    return response()->json(['http_code' => 200,'message' => 'Activación hecha con éxito.'],200);
                }else{
                    return response()->json(['http_code' => 500,'message' => 'La activación se realizó correctamente, pero no se guardo en nuestra DB, NOTIFIQUE A DESARROLLO.']);
                }
            }else{
                return response()->json(['http_code' => 500,'message' => 'No se realizó la activación, intente de nuevo o consulte a Desarrollo.']);
            }
        }else{
            return response()->json(['http_code' => 500,'message' => 'El token de acceso no fue aprobado, intente de nuevo o consulte a Desarrollo.']);
        }

        return $request;
    }

    public function importAllPorts(Request $request){
        $portabilities = Portability::all()->where('import_to_altan',0);
        $errors = [];
        $messages = [];
        $errorBoolean = 0;
        foreach ($portabilities as $port) {
            $date = $port->date;
            $date = str_replace("-","",$date);
            $altan = new AltanController();
            $portInRequest = $altan->importPortInToAltan($port->msisdnTransitory,$port->msisdnPorted,$port->imsi,$date,$port->dida,$port->rida,$port->dcr,$port->rcr);
            if(isset($portInRequest['msisdnPorted'])){
                array_push($messages,array(json_decode($portInRequest)));
                Portability::where('id',$port->id)->update(['import_to_altan' => 1]);
            }else{
                $errorBoolean = 1;
                $portInRequest = json_decode($portInRequest);
                array_push($errors,array('msisdn'=>array('msisdnPorted'=>$port->msisdnPorted,'response'=>$portInRequest)));
            }
            
        }
        return response()->json(['message'=>'Importación terminada','error'=>$errorBoolean,'errors'=>$errors,'messages'=>$messages]);
    }

    public function csvAltan(Request $request){
            $csv = request()->file('file');
            $fp = fopen ($csv,'r');
            $completedStatus = [];
            $i = 0;
            while (($data = fgetcsv($fp))) {
                
                if ($i > 0) {
                    $MSISDNPorted = $data[0];
                    $imsi = $data[1];
                    $dida = $data[3];
                    $rida = $data[4];
                    $dcr = $data[5];
                    $rcr = $data[6];
                    $EjecucionPotabilidad = $data[7];
                    $ResutaldoPortabilidad = $data[8];
                    $MSISDNTransitorio = $data[9];
                    // return $MSISDNPorted.'-'.$imsi.'-'.$MSISDNTransitorio.'-'.$EjecucionPotabilidad;
                    $port = Portability::where('msisdnPorted', $MSISDNPorted)
                                        ->where('msisdnTransitory',$MSISDNTransitorio)
                                        ->where('approvedDateABD', $EjecucionPotabilidad);

                    $x = $port->exists(); 

                    if($x){
                        $port->update([
                            'status' => 'completado'
                        ]);
                        $getPort = $port->first();
                    
                        Number::where('MSISDN', $MSISDNTransitorio)->where('icc_id', 'like','%'.$getPort->icc.'%')->update(['MSISDN'=>$MSISDNPorted]);
                    }
                    array_push($completedStatus,array(
                        'ported'=>$MSISDNPorted,
                        'transitory' => $MSISDNTransitorio,
                        'imsi' => $imsi,
                        'dida' => $dida,
                        'rida' => $rida,
                        'dcr' => $dcr,
                        'rcr' => $rcr,
                        'approvedDateABD' => $EjecucionPotabilidad,
                        'flag'=>$x
                    ));
                }
                $i++;

            }
            return json_encode($completedStatus);
            // return $csv;

    }

    public function portabilitiesAltcel(Request $request){
        if (isset($request['start']) && isset($request['end'])) {
            $status =  $request['status'];
            $year =  substr($request['start'],6,4);
            $month = substr($request['start'],0,2);
            $day = substr($request['start'],3,2);
            $init_date = $year.'-'.$month.'-'.$day;

            $year =  substr($request['end'],6,4);
            $month = substr($request['end'],0,2);
            $day = substr($request['end'],3,2);
            $final_date = $year.'-'.$month.'-'.$day;
            if ($status == 'pendientes') {
                $data['portabilitys'] = DB::connection('corp_portability')->table('por_portabilidades')->where('status','Solicitud')->whereBetween('por_portabilidades.fecha',[$init_date,$final_date])->latest()
                ->take(10)->get();
                $data['portabilitysCompletadas'] = DB::connection('corp_portability')->table('por_portabilidades')->where('status','Terminado')->orderBy('fecha','desc')->latest()->take(10)->get();
            }else if($status == 'completadas'){
                $data['portabilitys'] = DB::connection('corp_portability')->table('por_portabilidades')->where('status','Solicitud')->latest()
                ->take(10)->get();
                $data['portabilitysCompletadas'] = DB::connection('corp_portability')->table('por_portabilidades')->where('status','Terminado')->whereBetween('por_portabilidades.fecha',[$init_date,$final_date])->orderBy('fecha','desc')->latest()->take(10)->get();
            }
        }else{
            $data['portabilitys'] = DB::connection('corp_portability')->table('por_portabilidades')->where('status','Solicitud')->latest()
                ->take(10)->get();
            $data['portabilitysCompletadas'] = DB::connection('corp_portability')->table('por_portabilidades')->where('status','Terminado')->orderBy('fecha','desc')->latest()
            ->take(10)->get();
        }
        // return $data['portabilitys'];
        return view('petitions.portabilityAltcel', $data);
    }

    public function changeStatusPortability(Request $request){
        $petition = $request->idPetion;
        $userId = $request->get('userId');

        $data = DB::table('users')->where('id', $userId)->get();
        $name = $data[0]->name;
        $lastname = $data[0]->lastname;

        $user = $name.' '.$lastname;
        // return $user;

        $x = DB::connection('corp_portability')->table('por_portabilidades')->where('id', $petition)->update([
            'status' => 'Terminado'
        ]);

        if($x){
            return response()->json(['http_code'=>1]);
        }else{
            return response()->json(['http_code'=>0]);
        }
    }

    public function getAllDataPortPendiente(Request $request){
        $icc = $request->icc;
        $msisdn_portado = $request->msisdn_portado;

        
        $dataNumbers = Number::where('numbers.icc_id',$icc)->update(['MSISDN' => $msisdn_portado]);
        // $x = DB::table('numbers')->where('numbers.icc_id',$icc)->select('numbers.*')->get();
        

        if($dataNumbers){
            $dataPortabilities = DB::table('portabilities')
            ->where('portabilities.icc','like','%'.$icc.'%')
            ->update(['status' => 'completado']);
            return $dataPortabilities;
        } else{
            return 0;
        }
    }

    public function getAllDataPorta(Request $request){
        $id = $request->id;
        $dataEditPorta = Portability::find($id);
        return $dataEditPorta;
    }

    public function setAllDataPorta(Request $request){
        $msisdnTransitory = $request->post('msisdnTransitory');
        $icc = $request->post('icc');
        $msisdnPorted = $request->post('msisdnPorted');
        $approvedDateABD = $request->post('approvedDateABD');
        $date = $request->post('date');
        $nip = $request->post('nip');

        // return $request;
        
        $x = Portability::where('icc',$icc)->update([
        'msisdnTransitory' => $msisdnTransitory,
        'msisdnPorted' => $msisdnPorted,
        'approvedDateABD' => $approvedDateABD,
        'date' => $date,
        'nip' => $nip
        ]);
        return $x;
        if($x){
            return 1;
        } else{
            return 0;
        }
        
    }

    public function getAllDataPortaPendiente(Request $request){
        $id = $request->id;
        $dataEditPorta = Portability::find($id);

        $arrayPending = [];

            $who_did_it = User::where('id',$dataEditPorta->who_did_it)->first();
            $client = User::where('id','=',$dataEditPorta->client_id)->first();
            $rate = Rate::where('id','=',$dataEditPorta->rate_id)->first();
            
            $date_format = $dataEditPorta->created_at->toDateTimeString();

            array_push($arrayPending,array(
                'id' => $dataEditPorta->id,
                'msisdnPorted' => $dataEditPorta->msisdnPorted,
                'icc' => $dataEditPorta->icc,
                'msisdnTransitory' => $dataEditPorta->msisdnTransitory,
                'date' => $dataEditPorta->date,
                'approvedDateABD' => $dataEditPorta->approvedDateABD,
                'nip' => $dataEditPorta->nip,
                'client' => $client->name.' '.$client->lastname,
                'who_did_it' => $who_did_it->name.' '.$who_did_it->lastname,
                'rate' => $rate->name.' - $'.number_format($rate->price,2),
                'comments' => $dataEditPorta->comments,
                'created_at' => $date_format
            ));

        return $arrayPending;
    }

    public function setAllDataPortaPendiente(Request $request){
        //return $request;
        $id = $request->post('id');
        $noPortabilidadPendiente = $request->post('noPortabilidadPendiente');
        $iccPendiente = $request->post('iccPendiente');
        $noTransitorioPendiente = $request->post('noTransitorioPendiente');
        $fechaPortarPendiente = $request->post('fechaPortarPendiente');
        $edit_fechaActivarPendiente = $request->post('edit_fechaActivarPendiente');
        $nipPendiente = $request->post('nipPendiente');
        $comentarioPendiente = $request->post('comentarioPendiente');
        
        
        // return $request;
        
        $result = Portability::where('id',$id)->update([
        'msisdnTransitory' => $noTransitorioPendiente,
        'icc' => $iccPendiente,
        'msisdnPorted' => $noPortabilidadPendiente,
        'approvedDateABD' => $fechaPortarPendiente,
        'date' => $edit_fechaActivarPendiente,
        'nip' => $nipPendiente,
        'comments' => $comentarioPendiente
        ]);
        return $result;
        if($result){
            return 1;
        } else{
            return 0;
        }
        
    }

    public function updateABD(Request $request){
        $id_porta = $request->id;
        $ABD = Portability::where('id', $id_porta)->first()->ABD;
        if ($ABD == 1) {
            $portability = Portability::where('id', $id_porta)->update([
                'ABD' => 0
            ]);
        } else {
            $portability = Portability::where('id', $id_porta)->update([
                'ABD' => 1
            ]);
        }
        return $portability;
    }

    public function portado(Request $request){
        $portado = $request->portado;
        $dn = $request->dn;

        $data = DB::table('numbers')->where('MSISDN', $dn)->update([
            'ported' => 1
        ]);
        if ($data == 1) {
            return response()->json(['http_code' => 1, 'message' => 'El número ya no se encuentra con nosotros.']);
        }else{
            return response()->json(['http_code' => 0, 'message' => 'Ocurrio un problema, favor de comunicarse con desarrollo.']);
        }
        return $data;
    }
    
    public function PortabilityStatus(){
        $status_date = Carbon::now();
        $status_date = date('Y-m-d', strtotime($status_date));
        $data['status_portabilitys'] = DB::table('status_portability')
                                        ->where('date_ABD','=', $status_date)
                                        ->selectRaw('DN_portado, DN_transitorio, accion, date_ABD, detalles, estado')
                                        ->get();
        $data['status_date'] = $status_date;
        return view('portabilities.statusPortability', $data);
    }

    public function getPortabilityStatus(Request $request){
        $status_date = date('Y-m-d', strtotime($request -> status_date));
        $data['status_portabilitys'] = DB::table('status_portability')
                                        ->where('date_ABD','=', $status_date)
                                        ->selectRaw('DN_portado, DN_transitorio, accion, date_ABD, detalles, estado')
                                        ->get();
        $data['status_date'] = $status_date;
        return $data;
    }

    public function rechargeDealer(){
        $data['recharges'] = DB::connection('corp_pos')->table('ra_distribuidores')
                    ->join('ra_users', 'ra_distribuidores.user_id', '=', 'ra_users.id')
                    ->join('ra_recargas', 'ra_distribuidores.id', '=', 'ra_recargas.distribuidor_id')
                    ->where('ra_distribuidores.ubicacion', '=', 'Veracruz')
                    ->select('ra_recargas.*', 'ra_users.username AS delearName', 'ra_distribuidores.saldo_conecta AS saldo_conecta')
                    ->get();
        // return $data['recharges'];
        return view('portabilities.rechargeDealers', $data);
    }
}
