<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showUsers() {
        $current_id = auth()->user()->id;
        // ->where('users.role_id','!=',3)
        $data['users'] = DB::table('users')
                            ->where('users.id','!=',$current_id)
                            ->join('roles','users.role_id' ,'=','roles.id')
                            ->select('users.*','roles.rol')
                            ->get();
        $data['roles'] = Role::all()->where('id','!=',3);
        return view('users.index',$data);
    }

    public function addUser(Request $request){
        $email = $request['email'];
        $password = $request['password'];
        $password = Hash::make($password);
        $request['password'] = $password;
        
        $flag = User::where('email','=',$email)->exists();
        if($flag){
            $mensaje = 'El usuario ya existe.';
            return back()->with('error',$mensaje);
        }else{
            $request = request()->except('_token');
            $x = User::insert($request);
            if($x){
                $mensaje = 'Usuario nuevo añadido.';
                return back()->with('message',$mensaje);
            }else{
                $mensaje = 'Ha ocurrido un error.';
                return back()->with('error',$mensaje);
            }
        }
    }

    public function getUser(Request $request){
        $id = $request->get('id');
        $response = User::where('id',$id)->first();
        return $response;
    }

    public function updateUser(Request $request){
        $password = $request->post('password');
        $id = $request->post('id');
        if($password == null){
            $request = request()->except('_token','password','id');
            User::where('id',$id)->update($request);
            $mensaje = 'Datos actualizados.';
            return back()->with('message',$mensaje);
        }else{
            $request = request()->except('_token','id');
            $request['password'] = Hash::make($password);
            User::where('id',$id)->update($request);
            $mensaje = 'Datos actualizados.';
            return back()->with('message',$mensaje);
        }
    }

    public function changeRolUser(Request $request) {
        $user = $request->post('user');
        $rol = $request->post('rol');
        $x = User::where('id','=',$user)->update(['role_id'=>$rol]);
        return $x;
    }

    public function myProfile(){
        return view('myProfile');
    }

    public function updateMyProfile(Request $request){
        $id = $request->get('id');
        $password = $request->get('password');
        if($password == "null"){
            $request = request()->except('id','password');
            User::where('id',$id)->update($request);
        }else{
            $request = request()->except('id');
            $password = Hash::make($password);
            $request['password'] = $password;
            User::where('id',$id)->update($request);
        }
        return $request;
    }
}
