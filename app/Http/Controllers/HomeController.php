<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use App\Directory;
use App\Pay;
use App\Ethernetpay;
use App\Rate;
use App\Activation;
use App\Instalation;
use App\Change;
use App\Purchase;
use App\Reference;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $current_id = auth()->user()->id;
        $current_role = auth()->user()->role_id;
        $data['references'] = DB::table('references')
                                ->join('referencestypes','referencestypes.id','=','references.referencestype_id')
                                ->join('channels','channels.id','=','references.channel_id')
                                ->join('rates','rates.id','=','references.rate_id')
                                ->join('numbers','numbers.id','=','references.number_id')
                                ->where('referencestypes.name','Recarga')
                                ->where('references.user_id',$current_id)
                                ->select('references.*','referencestypes.name AS referencestype_name','channels.name AS channel_name','rates.name AS rate_name','numbers.MSISDN AS number_dn')
                                ->get();

        $data['mypays'] = DB::table('pays')
                             ->join('activations','activations.id','=','pays.activation_id')
                             ->join('numbers','numbers.id','=','activations.numbers_id')
                             ->join('rates','rates.id','=','activations.rate_id')
                             ->where('activations.client_id',$current_id)
                             ->select('pays.*','numbers.MSISDN AS DN','numbers.producto AS number_product','rates.name AS rate_name','rates.price AS rate_price')
                             ->get();
        $data['my2pays'] = DB::table('ethernetpays')
                              ->join('instalations','instalations.id','=','ethernetpays.instalation_id')
                              ->join('packs','packs.id','=','instalations.pack_id')
                              ->where('instalations.client_id',$current_id)
                              ->select('ethernetpays.*','packs.name AS pack_name','packs.price AS pack_price','packs.service_name AS service_name')
                              ->get();

        $data['activations'] = DB::table('activations')
                                  ->join('numbers','numbers.id','=','activations.numbers_id')
                                  ->join('rates','rates.id','=','activations.rate_id')
                                  ->where('activations.client_id',$current_id)
                                  ->select('activations.*','numbers.MSISDN AS DN','numbers.producto AS service','rates.name AS pack_name')
                                  ->get();
        
        $data['instalations'] = DB::table('instalations')
                                   ->join('packs','packs.id','=','instalations.pack_id')
                                   ->where('instalations.client_id',$current_id)
                                   ->select('instalations.*','packs.service_name AS service','packs.name AS pack_name')
                                   ->get();

        $data['HBB'] = DB::table('activations')
                                ->selectRaw('COUNT(activations.id) AS HBB')
                                ->join('numbers','numbers.id','=','activations.numbers_id')
                                ->whereRaw('numbers.producto LIKE "%HBB%"')
                                ->get();

        $data['MOV'] = DB::table('activations')
                                ->selectRaw('COUNT(activations.id) AS MOV')
                                ->join('numbers','numbers.id','=','activations.numbers_id')
                                ->whereRaw('numbers.producto LIKE "%MOV%"')
                                ->get();

        $data['MIFI'] = DB::table('activations')
                                ->selectRaw('COUNT(activations.id) AS MIFI')
                                ->join('numbers','numbers.id','=','activations.numbers_id')
                                ->whereRaw('numbers.producto LIKE "%MIFI%"')
                                ->get();
                                

        if($current_role == 3){
            $data['products'] = sizeof($data['instalations']) + sizeof($data['activations']);
            $data['pendingPays'] = sizeof($data['mypays']) + sizeof($data['my2pays']);
            $data['consumer'] = sizeof($data['activations']);
        }else if($current_role == 1 || $current_role == 4 || $current_role == 5 || $current_role == 2){

            // Fechas del mes en curso
            $date_now = date("Y-m-d");
            $date = new DateTime($date_now);
            $date->modify('first day of this month');
            $day = $date->format('d');
            $month = $date->format('M');
            $year = $date->format('Y');
            $date = $date->format('Y-m-d');
            $date_limit = strtotime($date_now);
            $dayTwo = date('d', $date_limit);

            // Fechas del día en curso en regresión a un mes
            $date_final = date('Y-m-d');
            $date_init = strtotime('-30 days', strtotime($date_final));
            $date_init = date('Y-m-d', $date_init);

            $statement = Pay::all();
            $statement2 = Ethernetpay::all();
            $changes = Change::all();
            $purchases = Purchase::all();
            $references = Reference::all();
            $toCall = Directory::all()->where('attended_by',null);

            $pendingPayments = $statement->where('status','pendiente');
            $pendingPayments2 = $statement2->where('status','pendiente');

            $completePayments = $statement->where('status','completado')->whereBetween('updated_at',[$date.' 00:00:00',$date_now.' 23:59:59']);
            $changesAll = $changes->where('reason','!=','bonificacion')->whereBetween('date',[$date.' 00:00:00',$date_now.' 23:59:59']);
            $purchasesAll = $purchases->where('reason','!=','bonificacion')->whereBetween('date',[$date.' 00:00:00',$date_now.' 23:59:59']);
            $referencesPurchasesAll = $references->where('status','!=','pending_payment')->where('status','!=','in_progress')->where('referencestype_id',5)->whereBetween('updated_at',[$date.' 00:00:00',$date_now.' 23:59:59']);
            
            $completePayments2 = $statement2->where('status','completado')->whereBetween('updated_at',[$date,$date_now]);

            $newClients = DB::table('users')
                                     ->leftJoin('activations','activations.client_id','=','users.id')
                                     ->leftJoin('instalations','instalations.client_id','=','users.id')
                                     ->where('role_id',3)
                                     ->where('activations.client_id',null)
                                     ->where('instalations.client_id',null)
                                     ->select('users.*','activations.*','instalations.*')
                                     ->get();

            $ratesActives = Rate::all()->where('status','activo');
            // Sumatoria de Ventas del último mes
            $salesActivation = Activation::where('payment_status','completado')->whereBetween('date_activation',[$date_init,$date_final])->sum('amount');
            $salesInstalation = Instalation::where('payment_status','completado')->whereBetween('date_instalation',[$date_init,$date_final])->sum('amount');
            $sales = $salesActivation+$salesInstalation;

            $data['pendings'] =  sizeof($pendingPayments)+sizeof($pendingPayments2);
            $data['completes'] =  sizeof($completePayments)+sizeof($completePayments2)+sizeof($changesAll)+sizeof($purchasesAll)+sizeof($referencesPurchasesAll);
            $data['newClients'] = sizeof($newClients);
            $data['ratesActives'] = sizeof($ratesActives);
            $data['sales'] = $sales;
            $data['toCall'] = sizeof($toCall);

            $data['formatDate'] = 'Del '.$day.' al '.$dayTwo.' de '.$month.' de '.$year;
        }
        // return sizeof($data['instalations']);
        return view('home',$data);
    }
}
