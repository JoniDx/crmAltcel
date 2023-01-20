<?php

namespace App\Http\Controllers;

use App\User;
use App\Activation;
use App\Notification;
use App\Number;
use Illuminate\Http\Request;
use App\Http\Controllers\AltanController;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['notifications'] = Notification::all()->where('status','pendiente');
        $data['twoNotifications'] = Notification::all()->where('status','completado');
        return view('notifications.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        if($notification->who_attended != null){
            $dataAttended = User::where('id',$notification->who_attended)->first();
            $notification['attendedBy'] = 'Atendido por: '.$dataAttended->name.' '.$dataAttended->lastname.' - '.$dataAttended->email;
        }

        if($notification->eventType == 'SUSPEND_MOVILITY'){
            $dataNumber = Number::where('MSISDN',$notification->identifier)->first();
            $dataActivation = Activation::where('numbers_id',$dataNumber->id)->first();
            $notification['lat'] = $dataActivation->lat_hbb;
            $notification['lng'] = $dataActivation->lng_hbb;
        }
        return view('notifications.show',$notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        $eventType = $request->input('eventType');
        $seen = $request->input('seen');
        $status = $request->input('status');
        $id = $request->input('id');

        if($eventType == 'EVENT_UNITS' || $eventType == 'ACTIVATION'){
            if($seen == 0){
                Notification::where('id',$id)->update([
                    'seen' => true,
                    'status' => 'completado'
                ]);
            }
        }else if($eventType == 'noneEvent'){
            Notification::where('id',$id)->update([
                'seen' => true,
                'status' => 'completado'
            ]);
        }


        return response()->json(['message'=>'OK'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }

    public function notificationSolution(Request $request){
        $type = $request->get('type');
        $msisdn = $request->get('msisdn');
        $id = $request->get('id');
        $who_attended = $request->get('who_attended');

        if($type == 'suspend-movility'){
            $coordinates = $request->get('coordinates');
            $x = app('App\Http\Controllers\AltanController')->resumeSuspendMovility($msisdn, $coordinates);
            if(isset($x['msisdn'])){
                Notification::where('id',$id)->update(['status'=>'completado','seen'=>true,'who_attended'=>$who_attended]);
                Number::where('MSISDN',$msisdn)->update(['traffic_outbound_incoming'=>'activo']);
                $dataNumber = Number::where('MSISDN',$msisdn)->first();
                $coordinates = explode(",", $coordinates);
                Activation::where('numbers_id',$dataNumber->id)->update(['lat_hbb'=>$coordinates[0],'lng_hbb'=>$coordinates[1]]);
                return response()->json(['status'=>'OK'],200);
            }else{
                return response()->json(['status'=>'BAD', 'description' => $x['description']]);
            }
            return $x;
        }
    }
}
