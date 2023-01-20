<?php

namespace App\Http\Controllers;

use App\Consumption;
use Illuminate\Http\Request;
use DB;

class ConsumptionController extends Controller
{

    public function index()
    {
        $data['clients'] = DB::table('users')
                              ->join('activations','activations.client_id','=','users.id')
                              ->join('numbers','numbers.id','=','activations.numbers_id')
                              ->join('rates','rates.id','=','activations.rate_id')
                              ->leftJoin('devices','devices.id','=','activations.devices_id')
                              ->leftJoin('clients','clients.user_id','=','users.id')
                              ->select('users.name AS name','users.lastname AS lastname',
                              'clients.cellphone AS cellphone','numbers.MSISDN AS MSISDN',
                              'numbers.producto AS service','devices.no_serie_imei AS imei',
                              'rates.name AS rate_name','rates.price_subsequent AS amount_rate','activations.date_activation AS date_activation','activations.amount_device AS amount_device')
                              ->get();
        return view('consumptions.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Consumption $consumption)
    {
        //
    }

    public function edit(Consumption $consumption)
    {
        //
    }

    public function update(Request $request, Consumption $consumption)
    {
        //
    }

    public function destroy(Consumption $consumption)
    {
        //
    }
}
