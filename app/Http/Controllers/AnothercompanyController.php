<?php

namespace App\Http\Controllers;

use DB;
use App\Anothercompany;
use App\Client;
use App\User;
use App\Conekta\ConektaPayment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AnothercompanyController extends Controller
{
    protected $ConektaPayment;

    function __construct(){
        $this->ConektaPayment = new ConektaPayment();
    }

    public function index(Request $request)
    {

        $data['prospects'] = DB::table('prospects')->select('prospects.*')->get();


      //   if(isset($request['state'])){
         //   $myProspects = DB::table('anothercompanies')->where('estado',$request['state'])->where('taken_by',null)->limit($request['quantity'])->select('anothercompanies.*')->get();
            
           /* foreach ($myProspects  as $prospect) {
                $exists = DB::table('anothercompanies')->where('id',$prospect->id)->where('taken_by',null)->exists();
                if($exists){
                    DB::table('anothercompanies')->where('id',$prospect->id)->where('taken_by',null)->update(['taken_by' => auth()->user()->id, 'taken_at' => date('Y-m-d H:i:s')]);
                }
            }*/
/*
            return back()->with('success','Prospectos cargados a tu lista.');
        }else{
            $data['prospects'] = DB::table('anothercompanies')->where('taken_by',auth()->user()->id)->where('status','pendiente')->where('hunted',0)->select('anothercompanies.*')->get();
            $data['contacteds'] = DB::table('anothercompanies')->where('taken_by',auth()->user()->id)->where('status','contactado')->select('anothercompanies.*')->get();
            $data['declineds'] = DB::table('anothercompanies')->where('taken_by',auth()->user()->id)->where('status','rechazado')->select('anothercompanies.*')->get();
            $data['completeds'] = DB::table('anothercompanies')->where('taken_by',auth()->user()->id)->where('status','completado')->select('anothercompanies.*')->get();
        }
*/
        return view('anothercompanies.index',$data);
    }

    public function create()
    {
        return view('anothercompanies.create');
    }

    public function store(Request $request)
    {
        $csv = request()->file('clientsFile');
            // return $csv;
            $fp = fopen ($csv,'r');

            $completedStatus = [];
            $myInsert = [];
            $i = 0;
            while (($data = fgetcsv($fp))) {
                if ($i > 0) {
                    $paterno = $data[0];
                    $materno = $data[1];
                    $nombres = $data[2];
                    $celular = $data[3];
                    $cp = $data[4];
                    $ciudad = $data[5];
                    $calle = $data[6];
                    $domicilio = $calle.', '.$ciudad;

                    Anothercompany::insert(array(
                        'paterno' => $paterno,
                        'materno' => $materno,
                        'nombres' => $nombres,
                        'telefono' => $celular,
                        'cp' => $cp,
                        'domicilio' => $domicilio,
                        'estado' => 'Chiapas'
                    ));
                    array_push($completedStatus,array(
                        'paterno' => $paterno,
                        'materno' => $materno,
                        'nombres' => $nombres,
                        'telefono' => $celular,
                        'cp' => $cp,
                        'domicilio' => $domicilio,
                        'estado' => 'Chiapas'
                    ));
                }
                $i++;

            }
            // Anothercompany::insert($completedStatus);
            return $completedStatus;
    }

    public function storeClientFromAnotherCompany(Request $request){
        // return $request;
        $time = time();
        $h = date("g", $time);
        
        $name = $request->post('name');
        $lastname = $request->post('lastname');
        $email = $request->post('email');

        $rfc = $request->post('rfc');
        $date_born = $request->post('date_born');
        $address = $request->post('address');
        $cellphone = $request->post('celphone');
        $ine_code = $request->post('ine_code');
        $user_id = $request->post('user');
        $anothercompany_id = $request->post('prospect_id');
        $prospect_id = $request->post('prospect_id');
        $interests = $request->post('interests');
        $date_created = date('Y-m-d');
        
         if($email == null){
             $email = str_replace(' ', '', $name).date("YmdHis", $time);
         }

        $x = User::where('email',$email)->exists();
        if($x){
            $error = '<p>El cliente con el email <strong>'.$email.'</strong> ya existe.<p>';
            return back()->with('error',$error);
        }
        

        User::insert([
            'name' => $name,
            'lastname' => $lastname,
            'email' => $email,
            'password' => Hash::make('123456789'),
            'prospect_id' => $prospect_id
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

        Anothercompany::where('id',$anothercompany_id)->update(['hunted'=>1,'contacted_by'=>$user_id,'status'=>'contactado']);

        $success = 'Cliente añadido con éxito.';
        return back()->with('success',$success);
    }

    public function show(Request $request)
    {
        
    }

    public function edit(Anothercompany $anothercompany)
    {
        //
    }

    public function update(Request $request, Anothercompany $anothercompany)
    {
        //
    }

    public function destroy(Anothercompany $anothercompany)
    {
        //
    }

    public function declineProspect(Request $request){
        $id = $request->post('id');
        $comment = $request->post('comment');
        $user_id = $request->post('user_id');

        Anothercompany::where('id',$id)->update(['status'=>'rechazado','comments'=>$comment,'contacted_by'=>$user_id,'updated_at'=>date('Y-m-d H:i:s')]);
        return 1;
    }
}
