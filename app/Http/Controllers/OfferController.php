<?php

namespace App\Http\Controllers;
use App\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index() {
        $data['offers'] = Offer::all();
        return view('offers.index',$data);
    }

    public function create() {
        return view('offers.create');
    }

    public function store(Request $request) {
        $request = $request->except('_token');
        $x = Offer::insert($request);
        return $x;
    }

    public function update(Request $request, Offer $offer) {
        $id = $offer->id;
        $type = $request->type;
        if($type == 'normal'){
            $request['offerID_excedente'] = null;
        }
        
        $request = request()->except('_method','_token');
        $x = Offer::where('id',$id)->update($request);
        
        if($x){
            $message = 'Cambios guardados.';
            return back()->with('message',$message);
        }else{
            $message = 'Parece que ha ocurrido un error, intente de nuevo.';
            return back()->with('error',$message);
        }
    }

    public function findOffer(Request $request) {
        $id = $request->get('id');
        $offer = Offer::find($id);
        return $offer;
    }

    public function getAllOffer(){
        $response = Offer::all()->where('type','normal');
        return $response;
    }

    public function getAllOfferByType(Request $request){
        $product = $request->get('product');
        $response = Offer::all()->where('product',$product)->where('type','normal');
        return $response;
    }

}
