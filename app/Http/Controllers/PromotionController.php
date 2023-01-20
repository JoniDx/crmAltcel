<?php

namespace App\Http\Controllers;

use App\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{

    public function index()
    {
        $data['promotions'] = Promotion::all();
        return view('promotions.index',$data);
    }

    public function create()
    {
        return view('promotions.create');
    }

    public function store(Request $request)
    {
        $request = request()->except('_token');
        $x = Promotion::insert($request);

        if($x){
            return back()->with('success','Promoción añadida con éxito.');
        }else{
            return back()->with('error','Hubo un error, intente de nuevo o consulte a Desarrollo.');
        }
    }

    public function show(Promotion $promotion)
    {
        return view('promotions.show',$promotion);
    }

    public function edit(Promotion $promotion)
    {
        //
    }

    public function update(Request $request, Promotion $promotion)
    {
        $id = $promotion->id;
        $request = request()->except('_token','_method');
        $x = Promotion::where('id',$id)->update($request);

        if($x){
            return back()->with('success','Cambios guardados exitosamente.');
        }else{
            return back()->with('error','Hubo un error, intente de nuevo o consulte a Desarrollo.');
        }
    }

    public function destroy(Promotion $promotion)
    {
        //
    }
}
