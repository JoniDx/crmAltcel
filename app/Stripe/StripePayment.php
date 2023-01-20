<?php

namespace App\Stripe;
use Stripe\Stripe;
use App\Reference;
use App\Pay;
use App\Ethernetpay;
use App\Number;
use Http;
use Illuminate\Support\Facades\Log;

class StripePayment{

    function __construct(){
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY_SANDBOX'));
        //$this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
    }

    function createPaymentLinkStripe($request){       
        $name = $request->name;
        $lastname = $request->lastname;
        $myproduct = $request->myproduct;
        $email = $request->email;
        $cel_destiny_reference = $request->cel_destiny_reference;
        $amount = $request->amount;
        $amount = $amount*100;
        $quantity = $request->quantity;
        $concepto = $request->concepto;
        $type = $request->type;
        $channel = $request->channel;
        $user = $request->user_id;
        $client = $request->client_id;
        $pay_id = $request->pay_id;

        if($type == 1 || $type == 4 || $type == 5){
            $number_id = $request->number_id;
            $offerID = $request->offer_id;
            $rate = $request->rate_id;
        }else if($type == 2){
            $pack_id = $request->pack_id;
        }
        
        $time = time();
        $h = date("g", $time)+7;
        $h = $h < 10 ? '0'.$h : $h;
        $creation_date = date("Ymd").$h.date("is", $time);

        try {

            $stripe_order = $this->stripe->paymentLinks->create(
                [   
                    'line_items' => [['price' => $request->stripe_id, 'quantity' => 1]],
                    'metadata' => [
                        'pay_id' => $request['pay_id'],
                        'client_id' => $request['client_id'],
                        'referencestype_id' => $request['type'],
                        'offer_id' => $request['offer_id'],
                        'number_id' => $request['number_id'],
                        'rate_id' => $request['rate_id'],
                        'user_id' => $request['user_id'],
                        'pack_id' => $request['pack_id'],
                    ]
                ],            
            );
            
            if($type == 1 || $type == 4 || $type == 5){
                if(isset($stripe_order->id)){
                    $dataReference = [
                        'reference_id' => $stripe_order->id,
                        'transaction_type' => $stripe_order->object,
                        'status' => "pending_payment",
                        'creation_date' => $creation_date,
                        'payment_method' => $stripe_order->object,
                        'amount' => $amount/100,
                        'currency' => $stripe_order->currency,
                        'name' => $name,
                        'lastname' => $lastname,
                        'email' => $email,
                        'channel_id' => $channel,
                        'referencestype_id' => $type,
                        'number_id' => $number_id,
                        'offer_id' => $offerID,
                        'rate_id' => $rate,
                        'user_id' => $user = $user == 'null' ? null : $user,
                        'client_id' => $client
                    ];
                    Reference::insert($dataReference);   
                }
            }

            return $stripe_order;

        } catch (\Throwable $th) {
          return $th;
        }
    }

}