<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pack;
use App\Packspolitic;
use App\Radiobase;
use App\Schedule;
use App\User;
use DB;

class ScheduleController extends Controller
{
    public function index(){
        $data['schedules'] = DB::table('schedules')
                                ->join('packs','packs.id','=','schedules.pack_id')
                                ->select('schedules.*','packs.id AS pack_id','packs.name AS pack_name')
                                ->get();

        $data['schedules_pending'] = DB::table('schedules')
                                ->join('packs','packs.id','=','schedules.pack_id')
                                ->where('schedules.status','pendiente')
                                ->select('schedules.*','packs.id AS pack_id','packs.name AS pack_name')
                                ->get();
        return view('schedules.index',$data);
    }

    public function create(){
        $data['packs'] = Pack::all()->where('service_name','Conecta')->where('status','activo');
        return view('schedules.create',$data);
    }

    public function store(Request $request){
        $request = request()->except('_token');
        $request['status'] = 'pendiente';
        // return $request;
        Schedule::insert($request);
        return redirect('/schedules');
    }

    public function show(Schedule $schedule){
        // return $schedule;
        $pack_id = $schedule->pack_id;
        $who_did_id = $schedule->who_did_id;
        $user_id = $schedule->user_id;
        $schedule['user'] = User::find($user_id);
        $schedule['who_did'] = User::find($who_did_id);
        $schedule['pack'] = Pack::find($pack_id);
        return view('schedules.show',$schedule);
    }

    public function update(Schedule $schedule){
        $data['pack_choosed'] = Pack::find($schedule->pack_id);
        $dataPolitic = DB::table('packspolitics')
                                      ->join('packs','packs.id','=','packspolitics.pack_id')
                                      ->where('packspolitics.pack_id',$schedule->pack_id)
                                      ->select('packspolitics.*','packs.price')
                                      ->get();
        $porcent = 0;
        $price = 0;
        $politics = array();
        for ($i=0; $i < sizeof($dataPolitic); $i++) { 
            $porcent = $dataPolitic[$i]->porcent;
            $porcent /= 100;
            $price = $dataPolitic[$i]->price;

            $cobro = $porcent*$price;
            $politics[] = ['cobro'=>$cobro,'description'=>$dataPolitic[$i]->description];
        }
        $client_exist = User::where('email','=',$schedule->email)->exists();
        
        if($client_exist){
            $user = User::where('email',$schedule->email)->first();
            $data['user_flag'] = $user->id;
        }else{
            $data['user_flag'] = 0;
        }

        // return $data['user_flag'];
        
        $data['politics_choosed'] = $politics;
        $data['packs'] = Pack::all()->where('id','!=',$schedule->pack_id);
        $data['radiobases'] = Radiobase::all();
        $data['schedule'] = $schedule;
        return view('schedules.install',$data);
    }
}
