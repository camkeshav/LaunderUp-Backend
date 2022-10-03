<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\ShopLoginCred; 
use App\Models\UserLoginCred; 
use Illuminate\Http\Request;
use App\Http\Controllers\PaymentController;
use DB;
use Response;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * 
     */
    public function place(Request $request){
        $request->validate([
            'cloth_order_id'=>'required',
            'payment_id'=>'required',
            'razorpay_payment_id'=>'required',
            'razorpay_order_id'=>'required',
            'razorpay_signature'=>'required',
        ]);

        $user = ShopLoginCred::where('shid', $request->shid)->first();
            if(!$user){
                return Response::json(['error'=>['ShId is not valid'],422]);
            }

        $user = UserLoginCred::where('uid', $request->uid)->first();
        if(!$user){
            return Response::json(['error'=>['UId is not valid'],422]);
        }



        $generated_signature = hmac_sha256($request->razorpay_order_id
         + "|" + $request->razorpay_payment_id, $secret);

    

        if ($generated_signature == $request->razorpay_signature) {
            $payment = Payment::where('payment_id', $request->payment_id)->first();

            $payment->razorpay_payment_id = $request->razorpay_payment_id;
            $payment->razorpay_order_id = $request->razorpay_order_id;
            $payment->razorpay_signature = $request->razorpay_signature;
            $payment->status = "Completed";

            $order = Order::where('order_id', $request->order_id)->first();
            $order->status = "Confirm";
            



            $check = $payment->save();
            $check2 = $order->save();




            if($check && $check2){
                return Response::json(["status"=>'Order Placed ',"error"=>"{$e}"],500);

            }else{
                return Response::json(["status"=>'Order Confirm'],200);
            }


            
        }else{
            return Response::json(["status"=>'Order Not Confirm, Something Wrong ',"error"=>"{$e}"],500);
        }


        

    }
    
    public function store(Request $request)
    {

        $request->validate([
            'uid'=>'required',
            'shid'=>'required',
            'pickup_dt'=>'required',
            'delivery_dt'=>'required',
            'geolocation'=>'required',
            'address'=>'required',
            'status'=>'required',
            'service_type'=>'required',
            'total_cost'=>'required',
            'clothes_types'=>'required',
            'express'=>'required|boolean',
        ]);

            $user = ShopLoginCred::where('shid', $request->shid)->first();
            if(!$user){
                return Response::json(['error'=>['ShId is not valid'],422]);
            }

            $user = UserLoginCred::where('uid', $request->uid)->first();
            if(!$user){
                return Response::json(['error'=>['UId is not valid'],422]);
            }
            

            $user=Order::where('order_id', $request->shid)->first();

            //create new order model instance
            $order_id="order_id".sha1(time());
            $new_user=new Order();
            $new_user->shid=$request->shid;
            $new_user->uid=$request->uid;
            $new_user->order_id=$order_id;
            $new_user->pickup_dt=$request->pickup_dt;
            $new_user->delivery_dt=$request->delivery_dt;
            $new_user->geolocation=$request->geolocation;
            $new_user->address=$request->address;
            $new_user->status=$request->status;
            $new_user->total_cost=$request->total_cost;
            $new_user->clothes_types=json_encode($request->clothes_types);
            $new_user->service_type=$request->service_type;
            $new_user->express=$request->express;
                
            DB::beginTransaction();
            $result = new JsonResponse();
            try{
                $result=(new PaymentController)->index(new Request([
                    'total_amount'=>$request->total_cost,
                    'cloth_order_id'=>$order_id,
                ]));
                
                if(!$result) return Response::json(["status"=>'Order Not Placed',"error"=>"{$e}"],500);
                
            }
             catch (Exception $e) {

                DB::rollback();
                
                return Response::json(["status"=>'Order Not Placed',"error"=>"{$e}"],500);
                
            }
            $temp = $result->getData();
            $new_user->payment_id = $temp->pid;
            
            $check_user=$new_user->save();
            DB::commit();
            if($check_user){
                $response = [
                    "status"=>"Order Placed, Payment Initiated",
                    "cloth_order_id"=>$order_id,
                    "payment_id"=>$temp->pid,
                    "payment_order_id"=>$temp->order_id,
                ];
                return Response::json($response,200);
            }else{
                $response = [
                    "status"=>"Order Failed",
                ];
                return Response::json($response,200);
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }


    public function userFetch($uid){
        
        return Order::where('uid',$uid);
    }


}
