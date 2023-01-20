<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Number;
use App\Device;
use DB;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{

    public function index()
    {
        $promoters = DB::table('users')->join('roles','roles.id','=','users.role_id')->where('users.role_id',7)->orWhere('users.role_id',4)->select('users.*','roles.rol')->get();
        $data['promoters'] = $promoters;
        $data['numbers'] = Number::all()->where('status','available');
        $data['devices'] = Device::all()->where('status','available');
        $data['resumes'] = [];

        foreach ($promoters as $promoter) {
            $devicesAvailable = Assignment::where('promoter_id',$promoter->id)->where('type','device')->where('status','available')->count();
            $devicesTotal = Assignment::where('promoter_id',$promoter->id)->where('type','device')->count();
            $numbersAvailable = Assignment::where('promoter_id',$promoter->id)->where('type','sim')->where('status','available')->count();
            $numbersTotal = Assignment::where('promoter_id',$promoter->id)->where('type','sim')->count();
            array_push($data['resumes'],array(
                'id' => $promoter->id,
                'name' => $promoter->name.' '.$promoter->lastname,
                'devicesAvailable' => $devicesAvailable,
                'devicesTotal' => $devicesTotal,
                'numbersAvailable' => $numbersAvailable,
                'numbersTotal' => $numbersTotal
            ));
        }

        return view('promoters.index',$data);
    }

    
    public function store(Request $request)
    {
        $request['status'] = 'available';
        $request = request()->except('_token');
        $x = Assignment::insert($request);
        if($x){
            return 1;
        }else{
            return 0;
        }
    }

    public function show(Assignment $assignment)
    {
        
    }

    public function showAssignments($promoter){
        $data['numbers'] = DB::table('assignments')
                              ->join('numbers','numbers.id','=','assignments.number_id')
                              ->where('assignments.type','sim')
                              ->where('assignments.status','available')
                              ->where('assignments.promoter_id',$promoter)
                              ->select('assignments.id AS assignment_id','numbers.icc_id AS ICC','numbers.MSISDN AS MSISDN','numbers.puk AS PUK','numbers.producto AS producto','numbers.id AS number_id')
                              ->get();
        
        $data['devices'] = DB::table('assignments')
                              ->join('devices','devices.id','=','assignments.device_id')
                              ->where('assignments.type','device')
                              ->where('assignments.status','available')
                              ->where('assignments.promoter_id',$promoter)
                              ->select('assignments.id AS assignment_id','devices.no_serie_imei AS imei','devices.material AS material','devices.id AS device_id','devices.price AS price', 'devices.description AS description')
                              ->get();

        return $data;
    }

    public function edit(Assignment $assignment)
    {
        //
    }

    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    public function destroy(Assignment $assignment)
    {
        $id = $assignment->id;
        $x = Assignment::destroy($id);

        if($x){
            return 1;
        }else{
            return 0;
        }
    }
}
