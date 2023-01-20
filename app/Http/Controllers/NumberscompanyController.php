<?php

namespace App\Http\Controllers;

use DB;
use Http;

use App\Rate;
use App\User;
use App\Offer;
use App\Number;
use App\Company;
use App\Activation;
use App\Rechargesbulk;
use App\Numberscompany;
use Illuminate\Http\Request;
use App\Http\Controllers\AltanController;

class NumberscompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $companies = DB::table('numberscompanies')
        ->select('numberscompanies.company_id')
        ->distinct()
        ->get();
        // return $companies;
        $data['companies'] = [];

        foreach ($companies as $company) {
            $company_id = $company;
            $companyData = Company::where('id',$company->company_id)->first();

            $quantityByCompany = Numberscompany::all()
            ->where('company_id',$company->company_id)
            ->count();

            array_push($data['companies'],array(
                'company_id' => $company_id->company_id,
                'company' => $companyData->name,
                'quantity' => $quantityByCompany
            ));
        }
        // return $data;

        $dataCompanies['companiesEmpre'] = DB::table('companies')
        ->select('id','name')
        ->get();

        return view('numberscompany.index', $data, $dataCompanies);
    }

    public function allDataLinea(Request $request){

        $msisdn = $request->post('msisdn');
        $x = Number::where('MSISDN','=',$msisdn)
        // ->where('status','available')
        ->first();
        return $x;
    }

    public function numberCompany(Request $request){

        $empresa_number = $request->get('empresa_number');
        $new_create = $request->get('new_create');
        $date_recarga = $request->get('date_recarga');
        $id_number = $request->get('id_number');

        
        Numberscompany::insert([
            'number_id' => $id_number,
            'company_id' => $empresa_number,
            'created_by' => $new_create,
            'date_to_reharge' => $date_recarga,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $success = 'Numero añadido con éxito.';
        return response()->json(['error'=>0,'message'=>$success]);

        // return $request;
    }

    public function idCompany(Request $request){
        $company_id = $request->company_id;

        $dataNumber = DB::table('numberscompanies')
        ->join('companies','numberscompanies.company_id' ,'=','companies.id')
        ->join('numbers','numberscompanies.number_id' ,'=','numbers.id')
        ->join('users','numberscompanies.created_by' ,'=','users.id')
        ->where('numberscompanies.company_id', $company_id)
        ->select('companies.name','numbers.MSISDN','users.name AS nombre','users.lastname','numberscompanies.created_at','numbers.producto')
        ->get();

        $packs = DB::table('offers')
        ->where('product','MOV')
        ->where('convivencia',1)
        ->select('offers.offerID_second AS offerID','offers.price_sale','offers.id','offers.name_second AS name')
        ->get();

        $packsFFM = DB::table('offers')
        ->where('product','MOV')
        ->where('convivencia',0)
        ->select('offers.offerID_second AS offerID','offers.price_sale','offers.id','offers.name_second AS name')
        ->get();

        $data['dataNumber'] = $dataNumber;
        $data['packs'] = $packs;
        $data['packsFFM'] = $packsFFM;

        return $data;

        
    }

    public function csvNumber(Request $request){
        // return $request;
        $csv = request()->file('file');

        $empresa_number = $request->get('empresa_number');
        $user_create = $request->get('user_create');
        $date_recarga = $request->get('date_recarga');

        
        $fp = fopen ($csv,'r');
        $completedStatus = [];
        $i = 0;
        while (($data = fgetcsv($fp))) {
                
            if ($i > 0) {
                $msisdn = $data[0];
                $id_number = Number::where('MSISDN','=',$msisdn)
                ->where('status','available')
                ->first();
                
               $completedStatus = Numberscompany::insert([
                    'number_id' => $id_number->id,
                    'company_id' => $empresa_number,
                    'created_by' => $user_create,
                    'date_to_reharge' => $date_recarga,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                
            }
            $i++;

        }
        // return response()->json(['error'=>0,'message'=>$success]);
        return $completedStatus;
        // return $csv;

    }

    public function rechargeBulk(Request $request){
        $offerID = $request['offerID'];
        $id = $request['id'];
        $offerIDFFM = $request['offerIDFFM'];
        $idFFM = $request['idFFM'];
        $company = $request['company'];
        $user_id = $request['user_id'];
        $msisdn = '';
        $effectiveDate = '';
        $order = '';
        $order_id = '';
        $statusCode = '';
        $description = '';
        $offerIDToSave = 0;
        $accessTokenResponse = app('App\Http\Controllers\AltanController')->accessTokenRequestPost();
        $accesToken = '';
        $url_prelaunch = "https://altanredes-prod.apigee.net/cm-sandbox/v1/products/purchase";
        $url_production = "https://altanredes-prod.apigee.net/cm/v1/products/purchase";
        $url_prelaunchFFM = "https://altanredes-prod.apigee.net/cm-sandbox/v1/subscribers/";
        $url_productionFFM = "https://altanredes-prod.apigee.net/cm/v1/subscribers/";

        if($accessTokenResponse['status'] == 'approved'){
            $accessToken = $accessTokenResponse['accessToken'];
        }else{
            return "El token no fue aprovado";
        }
        
        $numbers = DB::table('numberscompanies')
                  ->leftJoin('numbers','numbers.id','=','numberscompanies.number_id')
                  ->where('numberscompanies.company_id',$company)
                  ->select('numbers.MSISDN AS number', 'numberscompanies.number_id')
                  ->get();
        
        $records = [];
        for($i = 0; $i < sizeof($numbers); $i++){
            $msisdn = '';
            $effectiveDate = '';
            $order = '';
            $order_id = '';
            $statusCode = '';
            $description = '';

            if($offerID != 0){

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer '.$accessToken
                ])->post($url_production,[
                    "msisdn" => $numbers[$i]->number,
                    "offerings" => array(
                        $offerID
                    ),
                    "startEffectiveDate" => "",
                    "expireEffectiveDate" => "",
                    "scheduleDate" => ""
                ]);
                $offerIDToSave = $id;
                
            }else if($offerIDFFM != 0){

                $url_prelaunchFFM = "https://altanredes-prod.apigee.net/cm-sandbox/v1/subscribers/".$numbers[$i]->number;
                $url_productionFFM = "https://altanredes-prod.apigee.net/cm/v1/subscribers/".$numbers[$i]->number;
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer '.$accessToken,
                    'Content-Type' => 'application/json'
                ])->patch($url_productionFFM,[
                    'primaryOffering' => array(
                        'offeringId' => $offerIDFFM,
                        'address' => "",
                        'scheduleDate' => '',
                        'startEffectiveDate' => '',
                        'expireEffectiveDate' => ''
                    )
                ]);
                $offerIDToSave = $idFFM;

            }
            

            $response = $response->json();

            if(isset($response['msisdn'])){
                $msisdn = $response['msisdn'];
                $effectiveDate = $response['effectiveDate'];
                $order = $response['order'];
                $order_id = $order['id'];
                $statusCode = '200';
            }else if($response['errorCode']){
                $statusCode = $response['errorCode'];
                $description = $response['description'];
            }else{
                $statusCode = 'DESCONOCIDO';
                $description = 'Algo salió mal, comuníquese con Desarrollo.';
            }
            

            array_push($records,array(
                'msisdn' => $numbers[$i]->number,
                'effectiveDate' => $effectiveDate,
                'order_id' => $order_id,
                'statusCode' => $statusCode,
                'description' => $description,
                'user_id' => $user_id,
                'number_id' => $numbers[$i]->number_id,
                'offer_id' => $offerIDToSave
            ));

        }

        Rechargesbulk::insert($records);
        $dataCompany = Company::find($company);

        $dataResponse['records'] = $records;
        $dataResponse['company'] = $dataCompany;
        $dataResponse['http_code'] = 200;

        return $dataResponse;
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
     * @param  \App\Numberscompany  $numberscompany
     * @return \Illuminate\Http\Response
     */
    public function show(Numberscompany $numberscompany)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Numberscompany  $numberscompany
     * @return \Illuminate\Http\Response
     */
    public function edit(Numberscompany $numberscompany)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Numberscompany  $numberscompany
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Numberscompany $numberscompany)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Numberscompany  $numberscompany
     * @return \Illuminate\Http\Response
     */
    public function destroy(Numberscompany $numberscompany)
    {
        //
    }
}
