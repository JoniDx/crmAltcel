<?php

namespace App\Http\Controllers;
use App\Pack;
use App\Radiobase;
use App\Rate;
use App\Politic;
use App\Pay;
use App\Ethernetpay;
use App\User;
use App\Number;
use App\Device;
use App\Change;
use App\Purchase;
use App\Assignment;
use DB;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncomesExport;
use App\Exports\Purchases;
use App\Exports\MonthlyPayments;
use App\Exports\SurplusReferencePayments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function index() {
        $data['packs'] = Pack::all();
        $data['radiobases'] = Radiobase::all();
        return view('ethernet.administration',$data);
    }

    public function createPack(Request $request) {
        Pack::insert([
            'name' => $request->post('name'),
            'description' => $request->post('description'),
            'service_name' => $request->post('service_name'),
            'recurrency' => $request->post('recurrency'),
            'price' => $request->post('price'),
            'price_s_iva' => $request->post('price_s_iva'),
            'price_install' => $request->post('price_install')
        ]);
    }

    public function createRadiobase(Request $request) {
        Radiobase::insert([
            'name' => $request->post('name'),
            'address' => $request->post('address'),
            'ip_address' => $request->post('ip_address'),
            'lat' => $request->post('lat'),
            'lng' => $request->post('lng')
        ]);
    }

    public function createPoliticRate() {
        $data['politics'] = Politic::all();
        return view('rates.politics',$data);
    }

    public function insertPoliticRate(Request $request) {
        $request = request()->except('_token');
        $x = Politic::insert($request);
        if($x){
            return 1;
        }else{
            return 0;
        }
    }

    public function destroy($politic_id){
        Politic::where('id', $politic_id)->delete();
        return back();
    }

    public function getPolitic($politic_id){
        $response = Politic::find($politic_id);;
        return $response;
    }

    public function updatePolitic(Request $request,Politic $politic){
        $id = $politic->id;
        $request = request()->except('_method','_token');
        $x = Politic::where('id',$id)->update($request);

        if($x){
            $message = 'Cambios guardados.';
            return back()->with('message',$message);
        }else{
            $message = 'Parece que ha ocurrido un error, intente de nuevo.';
            return back()->with('error',$message);
        }
    }

    public function changeStatusPacksRates(Request $request){
        $status = $request['status'];
        $id = $request['id'];
        $type = $request['type'];

        if($type == 'ethernet'){
            if($status == 'activo'){
                Pack::where('id',$id)->update(['status' => 'inactivo']);
            }else if($status == 'inactivo'){
                Pack::where('id',$id)->update(['status' => 'activo']);
            }
        }else if($type == 'altan'){
            if($status == 'activo'){
                Rate::where('id',$id)->update(['status' => 'inactivo']);
            }else if($status == 'inactivo'){
                Rate::where('id',$id)->update(['status' => 'activo']);
            }
        }
    }

    public function getPackEthernet(Request $request){
        $response = Pack::find($request->get('id'));
        return $response;
    }
    
    public function updatePackEthernet(Pack $pack_id, Request $request){
        $id = $pack_id->id;
        $price_install = $request->post('price_install');
        $request = request()->except('_token','id');
        if($price_install == null){
            $price_install = 0;
            $request['price_install'] = $price_install;
        }
        Pack::where('id',$id)->update($request);
        return back();
    }

    public function checkOverduePayments(Request $request){
        $response = Pay::all();
        return $response;
    }

    public function concesionesGeneral(){
        $data['concesiones'] = DB::table('users')
                                 ->leftJoin('purchases','purchases.who_did_id', '=', 'users.id')
                                 ->leftJoin('changes','changes.who_did_id', '=', 'users.id')
                                 ->leftJoin('pays','pays.who_did_id', '=', 'users.id')
                                 ->leftJoin('ethernetpays','ethernetpays.who_did_id', '=', 'users.id')
                                 ->where('purchases.who_did_id', '!=', 'null')
                                 ->orWhere('changes.who_did_id', '!=', 'null')
                                 ->select('users.name','users.id')
                                 ->distinct()
                                 ->get();
        return view('finance.cute',$data);
    }
    public function consulta($id ){
        $data['users'] = User::where('id', $id)->get();
        return view('finance.detalles',$data);
    }
    public function indexConcesiones(){
        $changes = DB::table('changes')
                      ->join('numbers','numbers.id', '=', 'changes.number_id')
                      ->join('rates','rates.id', '=', 'changes.rate_id')
                      ->join('activations','activations.numbers_id', '=', 'changes.number_id')
                      ->join('users', 'users.id', '=', 'changes.who_did_id')
                      ->where('changes.status', '=', 'pendiente')
                      ->where('changes.reason', '=', 'cobro')
                      ->select('changes.id', 'changes.status','changes.who_did_id', 'changes.reason', 'changes.amount', 'rates.name AS name_rate','numbers.MSISDN','users.name AS user_name','users.lastname AS user_lastname','changes.date AS date','activations.client_id AS client')
                      ->get();

        $data['changes'] = [];
        $data['changesTotal'] = 0;
        $data['changesCount'] = 0;
        foreach ($changes as $change) {
            $clientData = User::where('id',$change->client)->first();
            $clientname = $clientData->name. ' '.$clientData->lastname;
            array_push($data['changes'],array(
                'id' => $change->id,
                'status' => $change->status,
                'who_did_id' => $change->who_did_id,
                'reason' => $change->reason,
                'amount' => $change->amount,
                'name_rate' => $change->name_rate,
                'MSISDN' => $change->MSISDN,
                'user' => $change->user_name.' '.$change->user_lastname,
                'date' => $change->date,
                'client' => $clientname
            ));
            $data['changesTotal']+=$change->amount;
            $data['changesCount']+=1;
        }
        
        $purchases = DB::table('purchases')
                        ->join('numbers','numbers.id', '=', 'purchases.number_id')
                        ->join('offers','offers.id', '=', 'purchases.offer_id')
                        ->join('activations','activations.numbers_id', '=', 'purchases.number_id')
                        ->join('users', 'users.id', '=', 'purchases.who_did_id')
                        ->where('purchases.status', '=', 'pendiente')
                        ->where('purchases.reason', '=', 'cobro')
                        ->select('purchases.id', 'purchases.status', 'purchases.who_did_id', 'purchases.reason', 'purchases.amount', 'offers.name AS name_rate','numbers.MSISDN','users.name AS user_name', 'users.lastname AS user_lastname','purchases.date AS date','activations.client_id AS client')
                        ->get();

        $data['purchases'] = [];
        $data['purchasesTotal'] = 0;
        $data['purchasesCount'] = 0;
        foreach ($purchases as $purchase) {
            $clientData = User::where('id',$purchase->client)->first();
            $clientname = $clientData->name. ' '.$clientData->lastname;
            array_push($data['purchases'],array(
                'id' => $purchase->id,
                'status' => $purchase->status,
                'who_did_id' => $purchase->who_did_id,
                'reason' => $purchase->reason,
                'amount' => $purchase->amount,
                'name_rate' => $purchase->name_rate,
                'MSISDN' => $purchase->MSISDN,
                'user' => $purchase->user_name.' '.$purchase->user_lastname,
                'date' => $purchase->date,
                'client' => $clientname
            ));
            $data['purchasesTotal']+=$purchase->amount;
            $data['purchasesCount']+=1;
        }

        $data['pays'] = [];
        $data['paysTotal'] = 0;
        $data['paysCount'] = 0;
        $pays = DB::table('pays')
                   ->join('activations','activations.id', '=', 'pays.activation_id')
                   ->join('rates','rates.id', '=', 'activations.rate_id')
                   ->join('numbers','numbers.id', '=', 'activations.numbers_id')
                   ->join('users','users.id', '=', 'pays.who_did_id')
                   ->where('pays.status_consigned', 'pendiente')
                   ->select('pays.amount_received AS amount','pays.who_did_id', 'pays.status_consigned AS status','users.name AS  user_name', 'pays.id', 'numbers.MSISDN', 'rates.name AS name_rate', 'users.lastname AS user_lastname','pays.date_pay AS date','activations.client_id AS client')
                   ->get();

        foreach ($pays as $pay) {
            $clientData = User::where('id',$pay->client)->first();
            $clientname = $clientData->name. ' '.$clientData->lastname;
            array_push($data['pays'],array(
                'id' => $pay->id,
                'status' => $pay->status,
                'who_did_id' => $pay->who_did_id,
                'amount' => $pay->amount,
                'name_rate' => $pay->name_rate,
                'MSISDN' => $pay->MSISDN,
                'user' => $pay->user_name.' '.$pay->user_lastname,
                'date' => $pay->date,
                'client' => $clientname
            ));
            $data['paysTotal']+=$pay->amount;
            $data['paysCount']+=1;
        }
        return view('finance.index',$data);
    }

    public function consultaCortes(Request $request){
        $id = $request['id'];
        $status = $request['status'];
        $type = $request['type'];
        $bonificacion = $request['bonificacion'];
        $start = $request['start'];
        $año = substr($start, -4);
        $mes = substr($start, 0,2);
        $dia = substr($start, 3, -5);
        $dateStart = $año. '-'. $mes.'-'.$dia;
        $dateStart = $dateStart.' 00:00:00';
        $end = $request['end'];
        $añoEnd = substr($end, -4);
        $mesEnd = substr($end, 0,2);
        $diaEnd = substr($end, 3, -5);
        $dateEnd = $añoEnd. '-'. $mesEnd.'-'.$diaEnd;
        $dateEnd = $dateEnd.' 23:59:59';

        if ($type == 'purchases') {
            $resp['consultas'] = DB::table('purchases')
                                    ->join('numbers','numbers.id', '=', 'purchases.number_id')
                                    ->join('offers','offers.id', '=', 'purchases.offer_id')
                                    ->join('activations','activations.numbers_id', '=', 'purchases.number_id')
                                    ->join('users', 'users.id', '=', 'activations.client_id')
                                    ->where('purchases.who_did_id', '=', $id)
                                    ->where('purchases.status', '=', $status)
                                    ->where('purchases.reason', '=', $bonificacion)
                                    ->whereBetween('date', [$dateStart, $dateEnd])
                                    ->select('purchases.id', 'purchases.status', 'purchases.reason', 'purchases.amount', 'offers.name AS name_product','numbers.MSISDN','users.name AS client', 'users.lastname AS lastname','purchases.date AS date')
                                    ->get();
        }elseif ($type == 'changes') {
            $resp['consultas'] = DB::table('changes')
                                    ->join('numbers','numbers.id', '=', 'changes.number_id')
                                    ->join('rates','rates.id', '=', 'changes.rate_id')
                                    ->join('activations','activations.numbers_id', '=', 'changes.number_id')
                                    ->join('users', 'users.id', '=', 'activations.client_id')
                                    ->where('changes.who_did_id', $id)
                                    ->where('changes.status', '=', $status)
                                    ->where('changes.reason', '=', $bonificacion)
                                    ->whereBetween('date', [$dateStart, $dateEnd])
                                    ->select('changes.id', 'changes.status', 'changes.reason', 'changes.amount', 'rates.name AS name_product','numbers.MSISDN','users.name AS client', 'users.lastname AS lastname','changes.date AS date')
                                    ->get();
        }elseif ($type == 'monthly') {
            $resp['consultas'] = DB::table('pays')
                                   ->join('activations','activations.id', '=', 'pays.activation_id')
                                   ->join('rates','rates.id', '=', 'activations.rate_id')
                                   ->join('numbers','numbers.id', '=', 'activations.numbers_id')
                                   ->join('users','users.id', '=', 'activations.client_id')
                                   ->where('pays.status_consigned', $status)
                                   ->where('pays.who_did_id', $id)
                                   ->whereBetween('date_pay', [$dateStart, $dateEnd])
                                   ->select('pays.amount_received AS amount', 'pays.status_consigned AS status','users.name AS client', 'pays.id', 'numbers.MSISDN', 'rates.name AS name_product', 'users.lastname AS lastname','pays.date_pay AS date')
                                   ->get();
        }
        return $resp;
    }

    public function statusCortes(Request $request){
        $id = $request['idpay'];
        $user_consigned = $request['id_consigned'];
        $type = $request['type'];
        $status = $request['status'];
        $x = false;

        if ($type == 'purchases') {
            if ($status =='pendiente') {
                $x = Purchase::where('id', $id)->update(['status'=>'completado', 'who_consigned'=>$user_consigned]);
            }elseif ($status == 'completado') {
                $x = Purchase::where('id', $id)->update(['status'=>'pendiente', 'who_consigned'=>$user_consigned]);
            }
        }elseif ($type == 'changes') {
            if ($status =='pendiente') {
                $x = Change::where('id', $id)->update(['status'=>'completado', 'who_consigned'=>$user_consigned]);
            }elseif ($status == 'completado') {
                $x = Change::where('id', $id)->update(['status'=>'pendiente', 'who_consigned'=>$user_consigned]);
            }
        }elseif ($type == 'monthly') {
            if ($status =='pendiente') {
                $x = Pay::where('id', $id)->update(['status_consigned'=>'completado', 'who_consigned'=>$user_consigned]);
            }elseif ($status == 'completado') {
                $x = Pay::where('id', $id)->update(['status_consigned'=>'pendiente', 'who_consigned'=>$user_consigned]);
            }
        }

        if ($x) {
            return 1;
        }else {
            return 0;
        }
    }

    public function payAll(Request $request){
        $id = $request['id'];
        $user_consigned = $request['id_consigned'];
        $status = $request['status'];
        $type = $request['type'];
        $start = $request['start'];
        $año = substr($start, -4);
        $mes = substr($start, 0,2);
        $dia = substr($start, 3, -5);
        $dateStart = $año. '-'. $mes.'-'.$dia;
        $end = $request['end'];
        $añoEnd = substr($end, -4);
        $mesEnd = substr($end, 0,2);
        $diaEnd = substr($end, 3, -5);
        $dateEnd = $añoEnd. '-'. $mesEnd.'-'.$diaEnd;
        $x = false;

        if ($type == 'changes') {
            if ($status == 'pendiente') {
                // return $dateStart.' // '.$dateEnd;
                $x = Change::where('who_did_id', $id)->where('status', $status)->whereBetween('date', [$dateStart,$dateEnd])->update(['status'=>'completado', 'who_consigned'=>$user_consigned]);
            }else if ($status == 'completado') {
                // return $dateStart.' // '.$dateEnd;
                $x = Change::where('who_did_id', $id)->where('status', $status)->whereBetween('date', [$dateStart, $dateEnd])->update(['status'=>'pendiente', 'who_consigned'=>$user_consigned]);
            }
        }else if ($type == 'purchases') {
            if ($status == 'pendiente') {
                $x = Purchase::where('who_did_id', $id)->where('status', $status)->whereBetween('date', [$dateStart, $dateEnd])->update(['status'=>'completado', 'who_consigned'=>$user_consigned]);
            }else if ($status == 'completado') {
                $x = Purchase::where('who_did_id', $id)->where('status', $status)->whereBetween('date', [$dateStart, $dateEnd])->update(['status'=>'pendiente', 'who_consigned'=>$user_consigned]);
            }
        }elseif ($type == 'monthly') {
            if ($status == 'pendiente') {
                $x = Pay::where('who_did_id', $id)->where('status_consigned', $status)->whereBetween('date_pay', [$dateStart, $dateEnd])->update(['status_consigned'=>'completado', 'who_consigned'=>$user_consigned]);
            }elseif ($status == 'completado') {
                $x = Pay::where('who_did_id', $id)->where('status_consigned', $status)->whereBetween('date_pay', [$dateStart, $dateEnd])->update(['status_consigned'=>'pendiente', 'who_consigned'=>$user_consigned]);
            }
        }
        if ($x) {
            return 1;
        }else {
            return 0;
        }
    }

    public function income(Request $request){
        $type = $request->get('type');
        $date_start = '';
        $date_end = '';
        
        switch ($type) {
            case 'today':
                $date_start = date('Y-m-d');
                $date_end = $date_start.' 23:59:59';
                $date_start = $date_start.' 00:00:00';
                break;
            case 'yesterday':
                $date_start = date('Y-m-d');
                $date_start = strtotime('-1 days', strtotime($date_start));
                $date_start = date('Y-m-d',$date_start);
                $date_end = $date_start.' 23:59:59';
                $date_start = $date_start.' 00:00:00';

                break;
            case 'last7':
                $date_start = date('Y-m-d');
                $date_start = strtotime('-7 days', strtotime($date_start));
                $date_start = date('Y-m-d',$date_start);
                $date_start = $date_start.' 00:00:00';

                $date_end = date('Y-m-d');
                $date_end = $date_end.' 23:59:59';
                break;
            case 'last30':
                $date_start = date('Y-m-d');
                $date_start = strtotime('-30 days', strtotime($date_start));
                $date_start = date('Y-m-d',$date_start);
                $date_start = $date_start.' 00:00:00';

                $date_end = date('Y-m-d');
                $date_end = $date_end.' 23:59:59';
                break;
            case 'thisMonth':
                $date_now = date("Y-m-d");

                $date_start = new DateTime($date_now);
                $date_start->modify('first day of this month');
                $date_start = $date_start->format('Y-m-d');
                $date_start = $date_start.' 00:00:00';

                $date_end = $date_now.' 23:59:59';
                break;
            case 'pastMonth':
                $lastMonth = date('Y-m', strtotime('-1 month'));
                $date_start = $lastMonth.'-01 00:00:00';

                $date_end = new DateTime($date_start);
                $date_end->modify('last day of this month');
                $date_end = $date_end->format('Y-m-d');
                $date_end = $date_end.' 23:59:59';

                break;
            case 'personalized':
                $date_start = $request->get('start');
                $date_start = substr($date_start,6,4).'-'.substr($date_start,0,2).'-'.substr($date_start,3,2);

                $date_end = $request->get('end');
                $date_end = substr($date_end,6,4).'-'.substr($date_end,0,2).'-'.substr($date_end,3,2);
                break;
        }

        $data['incomes'] = DB::table('incomes')->whereBetween('fecha',[$date_start,$date_end])->select('incomes.*')->get();
        
        $data['start'] = $date_start;
        $data['end'] = $date_end;

        return view('webhooks.income',$data);
    }

    public function incomesExport(Request $request){
        $data = [
            'date_start' => $request->get('start'),
            'date_end' => $request->get('end')
        ];
        return Excel::download(new IncomesExport($data), 'ingresos.xlsx');
    }

    public function linesAdministration(Request $request){
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

                // return $init_date.' y '.$final_date;
            }else{
                
                $init_date = date('Y-m-d');
                $final_date = date('Y-m-d');
            }
        }else{
            $init_date = date('Y-m-d');
            $final_date = date('Y-m-d');
        }

        $init_date = $init_date.' 00:00:00';
        $final_date = $final_date.' 23:59:59';
        $data['date_init'] = $init_date;
        $data['date_final'] = $final_date;

        // $data['lines'] = DB::connection('corp_pos')->table('ra_activations')->leftJoin('ra_users','ra_users.id','=','ra_activations.distribuidor_id')->whereBetween('ra_activations.date',[$init_date,$final_date])->select('ra_activations.*','ra_users.username','ra_users.first_name','ra_users.last_name','ra_users.wholesaler')->get();
        $data['lines'] = [];
        return view('administration.lines',$data);
    }

    public function promotores_view(){
        $id_user = Auth::user()->id;

        if ($id_user == 1565 || $id_user == 1824 || Auth::user()->role_id == 5|| Auth::user()->role_id == 1 )  {
            $id_user = 1565;
        }elseif ($id_user == 1567 || $id_user == 1825 ) {
            $id_user = 1567;
        }elseif ($id_user == 2253) {
            $id_user = 2253;
        }

        $data["supervisor"] = $id_user;
        $date_start = Carbon::now();
        $date_end = Carbon::now();
        $date_start->day(1)->hour(0)->minute(0);
        $date_start = date('Y-m-d H:i:s', strtotime($date_start));
        $date_end = date('Y-m-d H:i:s', strtotime($date_end));

        // $data["promotores"] = DB::connection('corp_pos')->table('ra_distribuidores')
        //                                                 ->join('ra_users', 'ra_distribuidores.user_id', '=', 'ra_users.id')
        //                                                 ->leftJoin('ra_activations', 'ra_users.id', '=', 'ra_activations.distribuidor_id')                                                    
        //                                                 ->where("ra_distribuidores.supervisor", '=', $id_user)
        //                                                 ->select("ra_users.username AS username", 'ra_users.id AS id')
        //                                                 ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "portabiilidad" THEN 1 ELSE 0 END) AS portabilidad')
        //                                                 ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "activacion" THEN 1 ELSE 0 END) AS lineaNueva')
        //                                                 ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "portabiilidad" THEN ra_activations.amount ELSE 0 END) AS portabilidadMoneyTotal')
        //                                                 ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "portabiilidad" AND ra_activations.rate != "PROMOCION EXCLUSIVA PORTABILIDAD - $100" THEN ra_activations.amount ELSE 0 END) AS portabilidadMoney')
        //                                                 ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "portabiilidad" AND ra_activations.rate = "PROMOCION EXCLUSIVA PORTABILIDAD - $100" THEN ra_activations.amount/2 ELSE 0 END) AS portabilidaPromo')                                                       
        //                                                 ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "activacion" THEN ra_activations.amount ELSE 0 END) AS lineaNuevaMoney')
        //                                                 ->groupBy('ra_users.id')
        //                                                 ->get();
        $data["promotores"] = [];
        

        // $data["proyecciones"] = DB::connection('corp_pos')->table('ra_activations')
        //                                                   ->selectRaw('COUNT(ra_activations.id) AS lineas ,  ra_distribuidores.supervisor AS supervisor')
        //                                                   ->join('ra_distribuidores', 'ra_distribuidores.user_id', '=', 'ra_activations.distribuidor_id')                                                    
        //                                                   ->where("ra_distribuidores.supervisor", '!=', '""')
        //                                                   ->where("ra_distribuidores.supervisor", '!=', '1')
        //                                                   ->whereBetween('ra_activations.created_at', [ $date_start, $date_end ])
        //                                                   ->groupBy('ra_distribuidores.supervisor')
        //                                                   ->get();

        $data["proyecciones"] = [];
        
        return view('administration.promotores', $data);
    }

    public function reportsVeracruz(Request $request){
        $id_user = $request->supervisor;
        $date_start = date('Y-m-d', strtotime($request -> date_start)); 
        $date_end = date('Y-m-d', strtotime($request -> date_end));

        if($request ->date_send == "true"){
            // $data["promotores"] = DB::connection('corp_pos')->table('ra_distribuidores')
            //                         ->join('ra_users', 'ra_distribuidores.user_id', '=', 'ra_users.id')
            //                         ->leftJoin('ra_activations', 'ra_users.id', '=', 'ra_activations.distribuidor_id')                                                    
            //                         ->where("ra_distribuidores.supervisor", '=', $id_user)
            //                         ->select("ra_users.username AS username", 'ra_users.id AS id')
            //                         ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "portabiilidad" AND ra_activations.created_at BETWEEN "'.$date_start.'" AND "'.$date_end.'" THEN 1 ELSE 0 END) AS portabilidad')
            //                         ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "activacion" AND ra_activations.created_at BETWEEN "'.$date_start.'" AND "'.$date_end.'" THEN 1 ELSE 0 END) AS lineaNueva')
            //                         ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "portabiilidad" AND ra_activations.created_at BETWEEN "'.$date_start.'" AND "'.$date_end.'" THEN ra_activations.amount ELSE 0 END) AS portabilidadMoneyTotal')
            //                         ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "portabiilidad"  AND ra_activations.rate != "PROMOCION EXCLUSIVA PORTABILIDAD - $100" AND ra_activations.created_at BETWEEN "'.$date_start.'" AND "'.$date_end.'" THEN ra_activations.amount ELSE 0 END) AS portabilidadMoney')
            //                         ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "portabiilidad" AND ra_activations.rate = "PROMOCION EXCLUSIVA PORTABILIDAD - $100" AND ra_activations.created_at BETWEEN "'.$date_start.'" AND "'.$date_end.'" THEN ra_activations.amount/2 ELSE 0 END) AS portabilidaPromo')
            //                         ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "activacion" AND ra_activations.created_at BETWEEN "'.$date_start.'" AND "'.$date_end.'" THEN ra_activations.amount ELSE 0 END) AS lineaNuevaMoney')
            //                         ->groupBy('ra_users.id')
            //                         ->get();
            $data["promotores"] = [];
        }else {
            // $data["promotores"] = DB::connection('corp_pos')->table('ra_distribuidores')
            //                         ->join('ra_users', 'ra_distribuidores.user_id', '=', 'ra_users.id')
            //                         ->leftJoin('ra_activations', 'ra_users.id', '=', 'ra_activations.distribuidor_id')                                                    
            //                         ->where("ra_distribuidores.supervisor", '=', $id_user)
            //                         ->select("ra_users.username AS username", 'ra_users.id AS id')
            //                         ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "portabiilidad" THEN 1 ELSE 0 END) AS portabilidad')
            //                         ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "activacion" THEN 1 ELSE 0 END) AS lineaNueva')
            //                         ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "portabiilidad" THEN ra_activations.amount ELSE 0 END) AS portabilidadMoneyTotal')
            //                         ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "portabiilidad" AND ra_activations.rate != "PROMOCION EXCLUSIVA PORTABILIDAD - $100" THEN ra_activations.amount ELSE 0 END) AS portabilidadMoney')
            //                         ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "portabiilidad" AND ra_activations.rate = "PROMOCION EXCLUSIVA PORTABILIDAD - $100" THEN ra_activations.amount/2 ELSE 0 END) AS portabilidaPromo')
            //                         ->selectRaw('SUM(CASE WHEN ra_activations.tipo = "activacion" THEN ra_activations.amount ELSE 0 END) AS lineaNuevaMoney')
            //                         ->groupBy('ra_users.id')
            //                         ->get();
            $data["promotores"] = [];
        }

        return $data;
    }

    public function modalReportVeracruz(Request $request){
        $date_start = date('Y-m-d', strtotime($request -> date_start)); 
        $date_end = date('Y-m-d', strtotime($request -> date_end));
        $id_distribuidor = $request->distribuidor;
        if($request ->date_send == "true"){
            // $data["portas"] = DB::connection('corp_pos')->table('ra_activations')
            //                         ->select('amount', 'date', 'rate', 'company', 'msisdn', 'icc', 'cliente', 'product', 'tipo')
            //                         ->where("distribuidor_id", '=', $id_distribuidor)
            //                         ->whereBetween('ra_activations.created_at', [ $date_start, $date_end ])
            //                         ->orderBy('date', 'DESC')
            //                         ->get();
            $data["portas"] = [];

        }else {
            // $data["portas"] = DB::connection('corp_pos')->table('ra_activations')
            //                         ->select('amount', 'date', 'rate', 'company', 'icc', 'msisdn', 'cliente', 'product', 'tipo')
            //                         ->where("distribuidor_id", '=', $id_distribuidor)    
            //                         ->orderBy('date', 'DESC')                             
            //                         ->get();
            $data["portas"] = [];
        }                            
        return $data;
    }



    // public function exportChangesDayli(Request $request){
    //     $data = [
    //         'date_start' => $request->get('start'),
    //         'date_end' => $request->get('end')
    //     ];
    //     return Excel::download(new ChangesProducts($data), 'changes_dayli.xlsx');
    // }

    // public function exportPurchasesDayli(Request $request){
    //     $data = [
    //         'date_start' => $request->get('start'),
    //         'date_end' => $request->get('end')
    //     ];
    //     return Excel::download(new Purchases($data), 'purchases_dayli.xlsx');
    // }

    // public function exportMonthlyPaymentsDayli(Request $request){
    //     $data = [
    //         'date_start' => $request->get('start'),
    //         'date_end' => $request->get('end')
    //     ];
    //     return Excel::download(new MonthlyPayments($data), 'monthly_payments_dayli.xlsx');
    // }
    
    // public function exportSurplusReferencePaymentsDayli(Request $request){
    //     $data = [
    //         'date_start' => $request->get('start'),
    //         'date_end' => $request->get('end')
    //     ];
    //     return Excel::download(new SurplusReferencePayments($data), 'surplus_reference_payments_dayli.xlsx');
    // }
}