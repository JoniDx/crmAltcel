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
        $data['dealers'] = DB::connection('pos_new')->table('pos_users')
                         ->select('pos_users.*')
                         ->get();

        // return $data['dealers'];
        return view('dealers.index',$data);
    }

    public function create(){
        return view('dealers.create');
    }

    public function store(Request $request){
        // return $request;
        $username = $request['username'];
        $request['password'] = Hash::make($request['password']);
        $request = $request->except('_token');

        $exists = Dealer::where('username',$username)->exists();

        if($exists){
            $status = 'warning';
            $message = 'El distribuidor <strong>'.$username.'</strong> que desea añadir ya existe.';
        }else{
            $x = Dealer::insert($request);

            if($x){
                $status = 'success';
                $message = 'Distribuidor añadido con éxito.';
            }else{
                $status = 'error';
                $message = 'Ocurrió un error, vuelve a intentarlo o consulta a Desarrollo.';
            }
        }

        return back()->with($status,$message);
    }

    public function dealerStoreTwo(Request $request){
        $username = $request['username'];
        $password = $request['password'];
        $id = $request['id'];
        $user_id = $request['user_id'];
        $saldo = $request['saldo'];
        $saldoExtra = $request['saldoExtra'];
        $saldoNew = 0;

        if($saldoExtra > 0 || $saldoExtra == null || $saldoExtra == ''){
            $saldoNew = $saldoExtra+$saldo;
            $request['saldo'] = $saldoNew;
        }

        

        if($password == null){
            unset($request['password']);
        }else{
            $request['password'] = Hash::make($request['password']);
        }

        if($username != null){
            $request = $request->except('_token','id','saldoExtra','user_id');
        }else{
            $request = $request->except('_token','id','saldoExtra','user_id','username');
        }
        

        $exists = Dealer::where('username',$username)->exists();

        if($exists){
            $status = 'warning';
            $message = 'El username de distribuidor <strong>'.$username.'</strong> que desea añadir ya existe.';
        }else{
            $x = Dealer::where('id',$id)->update($request);

            if($x){
                if($saldoExtra > 0 || $saldoExtra == null || $saldoExtra == ''){
                    $x = DB::connection('pos_new')->table('balances')->insert([
                        'saldo' => $saldoExtra,
                        'saldo_old' => $saldo,
                        'user_id' => $user_id,
                        'dealer_id' => $id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }

                
                $status = 'success';
                $message = 'Distribuidor actualizado con éxito.';
            }else{
                $status = 'error';
                $message = 'Ocurrió un error, vuelve a intentarlo o consulta a Desarrollo.';
            }
        }

        return back()->with($status,$message);
    }

    public function update($dealer, Request $request){
        // return $request;
        $saldo = $request['saldo'];
        $user_id = $request['user_id'];
        $balanceExtra = $request['balanceExtra'];
        $newSaldo = $saldo+$balanceExtra;
        $request = $request->except('_token','_method','user_id','balanceExtra');
        
        $x = DB::connection('pos_new')->table('pos_users')->where('id',$dealer)->update(['saldo'=>$newSaldo]);
        
        if($x){
            $x = DB::connection('pos_new')->table('balances')->insert([
                'saldo' => $balanceExtra,
                'saldo_old' => $saldo,
                'user_id' => $user_id,
                'dealer_id' => $dealer,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            return response()->json(['http_code' => 1, 'message' => 'Actualizado con éxito.']);
        }else{
            return response()->json(['http_code' => 0, 'message' => 'Hubo un error, intente de nuevo o consulte a Desarrollo.']);
        }
    }

    public function show(Dealer $dealer){
        // return $dealer;
        $data['dealer'] = $dealer;

        if($dealer->saldo == 0){
            $data['icon'] = "fa fa-frown-o";
        }else if($dealer->saldo > 0 && $dealer->saldo <= 30){
            $data['icon'] = "fa fa-meh-o";
        }else if($dealer->saldo > 30){
            $data['icon'] = "fa fa-smile-o";
        }
        // return $data;
        return view('dealers.show',$data);
        
    }
}
