<?php

namespace App\Http\Controllers;
use App\Conekta\ConektaPayment;
use Illuminate\Http\Request;
use App\Offer;

class CheckoutController extends Controller
{
    protected $Request;
    protected $ConektaPayment;

    function __construct(){
        $this->Request = new Request();
        $this->ConektaPayment = new ConektaPayment();
    }

    public function buying(){
        $product_name = $this->Request->json('product_name');
        $product_price = $this->Request->json('product_price');
        $product_currency = $this->Request->json('product_currency');
        $product_piece = $this->Request->json('product_piece');
        $order = $this->ConektaPayment->createOrder($product_name,$product_price,$product_currency,$product_piece);
        
        return $order;
    }

    public function notification(Request $request){
        Offer::insert([
            'offerID' => 'oxxo_pay',
            'name' => 'oxxo_pay',
            'description' => $request,
            'product_altan' => 'oxxo_pay',
            'action' => 'notification_oxxo_pay',
            'product' => 'oxxo_pay',
            'recurrency' => 'MXN',
            'price_s_iva' => 5.00,
            'price_c_iva' => 5.00,
            'price_sale' => 5.00
        ]);
        return $request;
    }
}
