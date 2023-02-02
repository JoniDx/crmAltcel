<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Dealer;
use App\Pack;
use App\Packsdealer;
use DB;

class DealerController extends Controller
{
    public function index(){
        $data['dealers'] = User::where("role_id", '=', 8)
                                ->select('users.*')
                                ->get();
        return view('dealers.index', $data);
    }

    public function create(){
        // return view('dealers.create');
    }

    public function store(Request $request){
        $name = $request->name;
        $lastname = $request->lastname;
        $email = $request->email;
        $password = $request->password;
        $saldo = $request->saldo;
        $telefono = $request->telefono;
        $wholesaler = $request->wholesaler;
        $salesforce = $request->salesforce;

        if ($name == "" || $lastname == "" || $email == "" || $password == "" ) {
            $status = 'error';
            $message = 'Ingrese los datos correspondientes.';
            return back()->with($status, $message);
        }

        $exists = User::where("email", $email)->exists();

        if($exists){
            $status = 'warning';
            $message = 'El distribuidor con el correo: <strong>'.$email.'</strong>, ya existe.';
        }else{
            $password = Hash::make($password);

            $data = [
                'name' => $name,
                'lastname' => $lastname,
                'email' => $email,
                'telefono' => $telefono,
                'password' => $password,
                'saldo' => $saldo,
                'wholesaler' => $wholesaler,                
                'salesforce' => $salesforce,
                'role_id' => 8
            ];
                    
            $distribuidor = User::insert($data);

            if($distribuidor){
                $status = 'success';
                $message = 'Distribuidor añadido con éxito.';
            }else{
                $status = 'error';
                $message = 'Ocurrió un error, vuelve a intentarlo o consulta a Desarrollo.';
            }
        }

        return back()->with($status, $message);
    }

    public function update(Request $request){
        $id = $request->id;
        $name = $request->name;
        $lastname = $request->lastname;
        $email = $request->email;
        $telefono = $request->telefono;
        $password = $request->password;
        $saldo = $request->saldo;
        $wholesaler = $request->wholesaler;
        $salesforce = $request->salesforce;
        $recharge = $request->recharge;

        $distribuidor = User::where("id", $id);

        if ($recharge == 1) {
            if ($distribuidor->update(['saldo' => $saldo])) {
                return response()->json(['http_code' => 1, 'message' => 'Actualizado con éxito.']);
            }else {
                return response()->json(['http_code' => 0, 'message' => 'Hubo un error, intente de nuevo o consulte a Desarrollo.']);
            }
        }

        $data = [
            'name' => $name,
            'lastname' => $lastname,
            'email' => $email,
            'telefono' => $telefono,
            'password' => $password,
            'saldo' => $saldo,
            'wholesaler' => $wholesaler,                
            'salesforce' => $salesforce,            
        ];


        if($distribuidor->exists()){

            if ($distribuidor->update($data)) {
                $status = 'success';
                $message = 'Actualizado con éxito.';
            }else {
                $status = 'error';
                $message = 'Hubo un error, intente de nuevo o consulte a Desarrollo.';
            }            

        }else{
            $status = 'error';
            $message = 'Hubo un error, intente de nuevo o consulte a Desarrollo.';            
        }

        return back()->with($status, $message);
    }

    public function show($dealer){
        // return $dealer;
        $dealer = User::find($dealer);
        $data['dealer'] = $dealer;
        // return $dealer;
        if($dealer->saldo == 0){
            $data['icon'] = "fa fa-frown-o";
        }else if($dealer->saldo > 0 && $dealer->saldo <= 30){
            $data['icon'] = "fa fa-meh-o";
        }else if($dealer->saldo > 30){
            $data['icon'] = "fa fa-smile-o";
        }
        // return $data;
        return view('dealers.show', $data);
    }

    public function get($id){
        $dealer = User::find($id);
        return $dealer;
    }
}
