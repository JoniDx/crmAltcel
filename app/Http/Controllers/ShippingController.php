<?php

namespace App\Http\Controllers;

use DB;
use App\Directory;
use App\Number;
use App\Shipping;
use App\Rate;
use App\User;
use Illuminate\Http\Request;

use Http;
use App\Conekta\ConektaPayment;
use App\Mail\NotifyShipping;

class ShippingController extends Controller
{
    protected $ConektaPayment;

    function __construct(){
        $this->ConektaPayment = new ConektaPayment();
    }

    public function index(Request $request)
    {

        if(isset($request['start']) && isset($request['end'])){
            if($request['start'] != null && $request['end'] != null){
                $year =  substr($request['start'],6,4);
                $month = substr($request['start'],0,2);
                $day = substr($request['start'],3,2);
                $date_init = $year.'-'.$month.'-'.$day;

                $year =  substr($request['end'],6,4);
                $month = substr($request['end'],0,2);
                $day = substr($request['end'],3,2);
                $date_final = $year.'-'.$month.'-'.$day;

                $date_init = $date_init.' 00:00:00';
                $date_final = $date_final.' 23:59:59';

                $pendings = Shipping::all()->where('status','pendiente')->whereBetween('created_at',[$date_init,$date_final]);
                $progresses = Shipping::all()->where('status','progress')->whereBetween('created_at',[$date_init,$date_final]);
                $completes = Shipping::all()->where('status','completado')->whereBetween('created_at',[$date_init,$date_final]);

                // return "BY DATE";
            }else{
                
                $pendings = Shipping::all()->where('status','pendiente');
                $progresses = Shipping::all()->where('status','progress');
                $completes = Shipping::all()->where('status','completado');
                // return "ONLY";
            }
        }else{
            $pendings = Shipping::all()->where('status','pendiente');
            $progresses = Shipping::all()->where('status','progress');
            $completes = Shipping::all()->where('status','completado');
        }
        
        $data['pendings'] = [];
        $data['progresses'] = [];
        $data['completes'] = [];

        foreach ($pendings as $pending) {
            $createdData = User::where('id',$pending->created_by)->first();
            $soldData = User::where('id',$pending->sold_by)->first();
            $toData = User::where('id',$pending->to_id)->first();

            array_push($data['pendings'],array(
                'id' => $pending->id,
                'cp' => $pending->cp,
                'estado' => $pending->estado,
                'municipio' => $pending->municipio,
                'canal' => $pending->canal,
                'to' => $toData->name.' '.$toData->lastname,
                'created_by' => $createdData->name.' '.$createdData->lastname,
                'sold_by' => $soldData->name.' '.$soldData->lastname,
                'created_at' => $pending->created_at,
                'phone_contact' => $pending->phone_contact
            ));
        }

        foreach ($progresses as $progress) {
            $createdData = User::where('id',$progress->created_by)->first();
            $attendedData = User::where('id',$progress->attended_by)->first();
            $soldData = User::where('id',$progress->sold_by)->first();
            $toData = User::where('id',$progress->to_id)->first();

            array_push($data['progresses'],array(
                'id' => $progress->id,
                'cp' => $progress->cp,
                'estado' => $progress->estado,
                'municipio' => $progress->municipio,
                'canal' => $progress->canal,
                'to' => $toData->name.' '.$toData->lastname,
                'created_by' => $createdData->name.' '.$createdData->lastname,
                'sold_by' => $soldData->name.' '.$soldData->lastname,
                'attended_by' => $attendedData->name.' '.$attendedData->lastname,
                'created_at' => $progress->created_at,
                'phone_contact' => $progress->phone_contact
            ));
        }

        foreach ($completes as $complete) {
            $createdData = User::where('id',$complete->created_by)->first();
            $soldData = User::where('id',$complete->sold_by)->first();
            $toData = User::where('id',$complete->to_id)->first();

            array_push($data['completes'],array(
                'id' => $complete->id,
                'cp' => $complete->cp,
                'estado' => $complete->estado,
                'municipio' => $complete->municipio,
                'canal' => $complete->canal,
                'to' => $toData->name.' '.$toData->lastname,
                'created_by' => $createdData->name.' '.$createdData->lastname,
                'sold_by' => $soldData->name.' '.$soldData->lastname,
                'created_at' => $complete->created_at,
                'phone_contact' => $complete->phone_contact
            ));
        }
        return view('shippings.index',$data);
    }

    public function create()
    {
        $data['flagMessage'] = 0;
        if(isset($request['phone'])){
            $data['message'] = 'HEY! Tu envío debe ser para '.$request['name'].' con teléfono '.$request['phone'];
            $data['flagMessage'] = 1;
        }
        $data['clients'] = DB::table('users')
                              ->leftJoin('clients','clients.user_id','=','users.id')
                              ->select('users.*','clients.rfc','clients.date_born','clients.address','clients.ine_code','clients.cellphone')
                              ->orderBy('users.name','asc')
                              ->get();

        $data['employes'] = User::all()->where('role_id','!=',3);
        return view('shippings.create',$data);
    }

    public function store(Request $request)
    {
        $no_interior = $request->no_interior;
        $referencias = $request->referencias;
        $recibe = $request->recibe;
        $phone_alternative = $request->phone_alternative;
        $comments = $request->comments;

        $to_id = $request->to_id;
        $sold_by = $request->sold_by;
        $created_by = $request->created_by;
        $phone = $request->phone_contact;
        $zona = $request->zona;
        $device_price = $request->device_price;
        $shipping_price = 0;

        if($zona == 'Local'){
            $shipping_price = $request->shippingTagValue;
        }else if($zona == 'Fuera'){
            $shipping_price = $request->shippingTagValue;
        }

        $status = $request->flag_link == 1 ? 'por pagar' : 'pendiente';
        $rate_id = $request->flag_link == 1 ? $request->rate_id : null;

        $clientData = User::where('id',$to_id)->first();

        $anothercompany_id = $clientData->anothercompany_id;
        $nameLink = $clientData->name;
        $lastnameLink = $clientData->lastname;
        $emailLink = $clientData->email;
        $clientData = $clientData->name.' '.$clientData->lastname;
        $userData = User::where('id',$sold_by)->first();
        $userData = $userData->name.' '.$userData->lastname;
        $createdData = User::where('id',$created_by)->first();
        $createdEmail = $createdData->email;
        

        if($no_interior == null || $no_interior == ''){
            $request['no_interior'] = 'N/A';
        }

        if($referencias == null || $referencias == ''){
            $request['referencias'] = 'N/A';
        }

        if($recibe == null || $recibe == ''){
            $request['recibe'] = 'N/A';
        }

        if($phone_alternative == null || $phone_alternative == ''){
            $request['phone_alternative'] = 'N/A';
        }

        if($comments == null || $comments == ''){
            $request['comments'] = 'N/A';
        }
        // $request = request()->except('_token');
        // Shipping::insert($request);
        $shipping = new Shipping;
        // $shipping = $request;
        $shipping->cp = $request->cp;
        $shipping->colonia = $request->colonia;
        $shipping->tipo_asentamiento = $request->tipo_asentamiento;
        $shipping->municipio = $request->municipio;
        $shipping->estado = $request->estado;
        $shipping->ciudad = $request->ciudad;
        $shipping->no_exterior = $request->no_exterior;
        $shipping->phone_contact = $request->phone_contact;
        $shipping->canal = $request->canal;
        $shipping->status = $status;
        $shipping->created_by = $request->created_by;
        $shipping->sold_by = $request->sold_by;
        $shipping->to_id = $request->to_id;
        $shipping->zona = $request->zona;
        $shipping->rate_id = $rate_id;
        $shipping->rate_price = $request->rate_price;
        $shipping->device_price = $request->device_price;
        $shipping->shipping_price = $shipping_price;
        $shipping->no_interior = $request['no_interior'];
        $shipping->referencias = $request['referencias'];
        $shipping->recibe = $request['recibe'];
        $shipping->phone_alternative = $request['phone_alternative'];
        $shipping->comments = $request['comments'];
        $shipping->save();

        $id = $shipping->id;
        if($anothercompany_id != null){
            DB::table('anothercompanies')->where('id',$anothercompany_id)->update(['status'=>'completado']);
        }

        if($request->flag_link == 1){
            $data = [
                "pay_id" => $id,
                "client_id" => $request->to_id,
                "type" => 7,
                "offer_id" => 0,
                "number_id" => 0,
                "rate_id" => 0,
                "user_id" => $request->created_by,
                "pack_id" => 0,
                "channel_system" => 'crm_clientes',
                "method" => null,
                "concepto" => 'Contratación de Servicio Conecta Altcel',
                "amount" => $shipping_price+$request->rate_price+$device_price,
                "name" => $nameLink,
                "lastname" => $lastnameLink,
                "email" => $emailLink,
                "cel_destiny_reference" => $request->phone_contact
            ];
            $x = $this->ConektaPayment->createPaymentLinkAllMethods($data);
            $link = $x->url;
            return back()->with('success','Envío guardado con éxito, lo único que falta es completar el pago, envía al cliente el siguiente link <a href="'.$link.'" target="_blank">'.$link.'</a>.');
        }else{
            $data = [
                "clientData" => $clientData,
                "userData" => $userData,
                "phone" => $phone,
                "shippingID" => $id,
            ];
            
            return back()->with('success','Envío guardado con éxito.');
        }
    }

    public function show(Shipping $shipping)
    {
        $userData = User::where('id',$shipping->to_id)->first();
        $createdData = User::where('id',$shipping->created_by)->first();
        $soldData = User::where('id',$shipping->sold_by)->first();
        $data['userData'] = $userData;
        $data['createdData'] = $createdData;
        $data['soldData'] = $soldData;

        if($shipping->attended_by != null){
            $attendedData = User::where('id',$shipping->attended_by)->first();
            $data['attendedData'] = $attendedData;
        }

        if($shipping->completed_by != null){
            $completedData = User::where('id',$shipping->completed_by)->first();
            $data['completedData'] = $completedData;
        }

        if($shipping->rate_id != null){
            $rateData = DB::table('rates')
                           ->join('offers','offers.id','=','rates.alta_offer_id')
                           ->where('rates.id',$shipping->rate_id)
                           ->select('rates.*','offers.product AS producto')
                           ->get();
            $data['rateData'] = $rateData[0];
        }

        $created_at = $shipping->created_at;
        $attended_at = $shipping->attended_at;
        $completed_at = $shipping->completed_at;
        $updated_at = $shipping->updated_at;

        $created_at = str_replace('T',' ',$created_at);
        $attended_at = str_replace('T',' ',$attended_at);
        $completed_at = str_replace('T',' ',$completed_at);
        $updated_at = str_replace('T',' ',$updated_at);

        $data['creationDate'] = $created_at;
        $data['attendDate'] = $attended_at;
        $data['completeDate'] = $completed_at;
        $data['updateDate'] = $updated_at;
        
        return view('shippings.show',$shipping,$data);
    }

    public function showAsync(Shipping $shipping){
        $userData = User::where('id',$shipping->to_id)->first();
        $createdData = User::where('id',$shipping->created_by)->first();
        $soldData = User::where('id',$shipping->sold_by)->first();
        $data['userData'] = $userData;
        $data['createdData'] = $createdData;
        $data['soldData'] = $soldData;

        $icc = $shipping->icc;
        $icc = strtoupper($icc);
        $numberData = Number::where('icc_id','like','%'.$icc.'%')->where('deleted_at',null)->first();
        $producto = $numberData->producto;
        $producto = trim($producto);

        if($shipping->attended_by != null){
            $attendedData = User::where('id',$shipping->attended_by)->first();
            $data['attendedData'] = $attendedData;
        }

        if($shipping->completed_by != null){
            $completedData = User::where('id',$shipping->completed_by)->first();
            $data['completedData'] = $completedData;
        }

        $created_at = $shipping->created_at;
        $attended_at = $shipping->attended_at;
        $completed_at = $shipping->completed_at;
        $updated_at = $shipping->updated_at;

        $created_at = str_replace('T',' ',$created_at);
        $attended_at = str_replace('T',' ',$attended_at);
        $completed_at = str_replace('T',' ',$completed_at);
        $updated_at = str_replace('T',' ',$updated_at);

        $data['creationDate'] = $created_at;
        $data['attendDate'] = $attended_at;
        $data['completeDate'] = $completed_at;
        $data['updateDate'] = $updated_at;
        $data['producto'] = $producto;

        $data['shipping'] = $shipping;

        return $data;
    }

    public function edit(Shipping $shipping)
    {
        //
    }

    public function update(Request $request, Shipping $shipping)
    {
        $request['updated_at'] = date('Y-m-d H:i:s');
        if($request->status == 'progress'){
            $request['attended_at'] = date('Y-m-d H:i:s');
            $request = request()->except('_token','_method');
            $id = $shipping->id;
            Shipping::where('id',$id)->update($request);
            return response()->json(['http_code' => 200,'message' => 'Datos guardados con éxito.']);
        }else if($request->status == 'completado'){
            $request['completed_at'] = date('Y-m-d H:i:s');
            $completed_by = $request['completed_by'];
            $to_id = $request['to_id'];
            $reason = 'El cliente ya recibió la SIM que se solicitó enviar.';
            $observations = $request['observations'];
            $request = request()->except('_token','_method','to_id','observations');
            $id = $shipping->id;
            Shipping::where('id',$id)->update($request);
            Directory::insert([
                'to_id' => $to_id,
                'reason' => $reason,
                'observations' => $observations,
                'shipping_id' => $id,
                'created_by' => $completed_by,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            return response()->json(['http_code' => 200,'message' => 'Completado con éxito.']);
        }
        
    }

    public function destroy(Shipping $shipping)
    {
        //
    }
    public function consultCP(Request $request){
        $cp = $request->cp;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->get('https://api.copomex.com/query/info_cp/'.$cp.'?token=0fdba07b-c507-4a6c-9de6-fc533f413577');

        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json'
        // ])->get('https://api.copomex.com/query/info_cp/'.$cp.'?token=pruebas');

        return $response;
    }
}
