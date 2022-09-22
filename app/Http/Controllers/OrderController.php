<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\ShopLoginCred; 

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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {

    //     $table->id();
    //         $table->string("order_id");
    //         $table->foreign('uid')->references('uid')->on('users');
    //         $table->foreign('shid')->references('shid')->on('users');
    //         $table->string('pickup_dt');
    //         $table->string('delivery_dt');
    //         $table->string('geolocation');
    //         $table->string('address');
    //         $table->string('status');
    //  //service?
    //         $table->string('type');
    //         $table->string('total_cost');
    //         $table->string('quantity');
    //         $table->string('clothes_types');
    //         $table->timestamps();
    
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
            'quantity'=>'required',
            'express'=>'required|boolean',
        ]);

            $user = ShopLoginCred::where('shid', $request->shid)->get();
            if(!$user){
                return Response::json(['error'=>['ShId is not valid'],422]);
            }
            $user=Order::where('shid', $request->shid)->get();

            //create new order model instance
            $order_id="order_id"+sha1(time());
            $new_user=new OrderController;
            $new_user->shid=$request->shid;
            $new_user->uid=$request->uid;
            $new_user->order_id=$order_id;
            $new_user->pickup_dt=$request->pickup_dt;
            $new_user->delivery_dt=$request->delivery_dt;
            $new_user->geolocation=$request->geolocation;
            $new_user->address=$request->address;
            $new_user->status=$request->status;
            $new_user->type=$request->type;
            $new_user->total_cost=$request->total_cost;
            $new_user->cloths_types=$request->cloths_types;
            $new_user->quantity=$request->quantity;
            $new_user->express=$request->express;

            $check_user=$new_user->save();
            if($check_user){
                $response = [
                    "status"=>"Order Placed",
                    "order_id"=>$order_id,
                ];
                return Response::json($response,200);
            }else{
                $response = [
                    "status"=>"Order Failed",
                    "order_id"=>$order_id,
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
}
