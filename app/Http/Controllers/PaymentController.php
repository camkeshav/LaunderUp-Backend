<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\IndexPaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Http\Request;
use Response;
use Razorpay\Api\Api;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \App\Http\Requests\IndexPaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
            

        $request->validate([
            'total_amount'=>'required',
            'cloth_order_id'=>'required',
            
        ]);
        $new_payment = new Payment();
        $payment_id="pid".sha1(time());

        $key_id = "rzp_test_fsINoU7sl53QSj";
        $secret = "oQn36juzoWgmk3O70P69wDhY";

        $api = new Api($key_id, $secret);
        $order=$api->order->create(
            ['receipt' => '11510sdsd515',
             'amount' => (int)($request->total_amount), 
             'currency' => 'INR']);


        $new_payment->payment_id = $payment_id;
        $new_payment->total_amount= $request->total_amount;
        $new_payment->cloth_order_id = $request->cloth_order_id;
        $new_payment->order_id = $order->id;
        $new_payment->status= "Created";

        $check_payment=$new_payment->save();
        
        $response;

        if($check_payment){
            $response = [
                "status"=>"Payment Placed",
                "pid"=>$payment_id,
                "order_id"=>$order->id,
            ];
            return Response::json($response,200);
        }else{
            return null;
        }
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
     * @param  \App\Http\Requests\StorePaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentRequest  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $request->validate([
            'payment_id'=>'required',
            'cloth_order_id'=>'required',
            'razorpay_payment_id'=>'required',
            'razorpay_order_id'=>'required',
            'razorpay_signature'=>'required',    
        ]);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
