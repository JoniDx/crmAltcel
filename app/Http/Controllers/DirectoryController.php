<?php

namespace App\Http\Controllers;

use DB;
use App\Directory;
use App\User;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function index()
    {
        $clients = DB::table('directories')
                      ->join('users','users.id','=','directories.created_by')
                      ->where('directories.attended_by',null)
                      ->select('directories.*','users.name','users.lastname')
                      ->get();

        $clientsAttended = DB::table('directories')
                              ->join('users','users.id','=','directories.created_by')
                              ->where('directories.attended_by','!=',null)
                              ->select('directories.*','users.name','users.lastname')
                              ->get();

        $data['clients'] = [];
        $data['clientsAttended'] = [];

        foreach ($clients as $client) {
            $clientData = User::where('id',$client->to_id)->first();
            array_push($data['clients'],array(
                'id' => $client->id,
                'name' => $clientData->name.' '.$clientData->lastname,
                'reason' => $client->reason,
                'observations' => $client->observations,
                'sender' => $client->name.' '.$client->lastname,
                'created_at' => $client->created_at,
                'shipping_id' => $client->shipping_id
            ));
        }

        foreach ($clientsAttended as $client) {
            $clientData = User::where('id',$client->to_id)->first();
            $attendedData = User::where('id',$client->attended_by)->first();
            array_push($data['clientsAttended'],array(
                'id' => $client->id,
                'name' => $clientData->name.' '.$clientData->lastname,
                'reason' => $client->reason,
                'observations' => $client->observations,
                'sender' => $client->name.' '.$client->lastname,
                'attended_by' => $attendedData->name.' '.$attendedData->lastname,
                'created_at' => $client->created_at,
                'attended_at' => $client->updated_at,
                'shipping_id' => $client->shipping_id
            ));
        }

        return view('directories.index',$data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Directory $directory)
    {
        //
    }

    public function edit(Directory $directory)
    {
        //
    }

    public function update(Request $request, Directory $directory)
    {
        //
    }

    public function destroy(Directory $directory)
    {
        //
    }
}
