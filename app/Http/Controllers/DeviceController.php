<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;
use App\Device;
use App\Number;
use App\GuzzleHttp;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function index()
    {
        $products = DB::table('numbers')->select('producto')->distinct()->get();
        $dataproducts['products'] = [];

        foreach($products as $product){
            $producto = $product->producto;
            $productofree = Number::where('producto', 'like', '%'.$producto)
                                   ->where('status', 'available')
                                    ->count();
            $productotaken = Number::where('producto', 'like', '%'.$producto)
                                    ->where('status', 'taken')
                                    ->count();
            array_push($dataproducts['products'], array('producto'=>$producto,
                                                        'available'=>$productofree,
                                                        'taken'=>$productotaken));
        }
        
        $devices = DB::table('devices')->select('material', 'price', 'description')->distinct()->get();
        $data['devices'] = [];

        foreach ($devices as $device) { 
            $material = $device->material;
            $description = $device->description;
            $price = $device->price;
            $devicesFree = Device::where('material', $material)
                                  ->where('status', 'available')
                                  ->count();
         
            array_push($data['devices'], array('material'=> $material,
                                                'description'=>$description,
                                                'price'=>$price,
                                                'available'=> $devicesFree));
        }
        return view('devices.index',$data, $dataproducts);
    }

    public function sim(){
        $products = DB::table('numbers')->selecte('producto')->distinc()->get();
        return $products;
    }

    public function show($device){
        $data = Device::where('material', $device)->first();
        return $data;
    }

    public function updatePriceDevice(Request $request){
        $material = $request->get('material');
        $price = $request->get('price');
        $x = Device::where('material', $material)->update(['price'=> $price]);
        if($x){
            return 1;
        }else{
            return 0;
        }
    }

    public function getImei(Request $request){
        $imei = $request->get('imei');
        $response = Device::where('no_serie_imei','LIKE','%'.$imei.'%')->first();
        return $response;
    }

    public function chargeCSVNIR(Request $request){
        if(request()->file('nirs')){
            $x = asset('storage/uploads/TESTNIR.txt');
            // return $x;
            // return $request->file('nirs');
            // return file_get_contents('storage/uploads/TESTNIR.txt');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer yvHABXCKd11DD19dbEUKu1oscdDy',
                'Content-Type' => 'multipart/form-data'
            ])->post('https://altanredes-prod.apigee.net/cm/v1/subscribers/changesmsisdn',[
                "archivos" => $x
            ]);

            return $response;
        }
    }
}
