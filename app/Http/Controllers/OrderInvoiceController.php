<?php

namespace App\Http\Controllers;

use App\Models\OrderInvoice;
use App\Models\Order;
use App\Models\UserDetail;
use App\Http\Requests\StoreOrderInvoiceRequest;
use App\Http\Requests\UpdateOrderInvoiceRequest;
use Illuminate\Http\Request;
use Response;

class OrderInvoiceController extends Controller
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
     * @param  \App\Http\Requests\StoreOrderInvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $request->validate([
            'shid' => 'required',
            'order_id'=>'required',
            'uid'=>'required',
            'customer_name'=>'required',
            'cloth_types'=>'required',
            'total_amount'=>'required',
            'delivery_charge'=>'required',

        ]);

        $order = Order::where('order_id', $request->order_id)->first();
        if(!$order){
            return Response::json(['status'=>"Order Not Found"],404);
        }


        //check if shop exists
        $user = UserDetail::where('uid', $request->uid)->first();
        if(!$user){
            return Response::json(['status'=>"User Not Found "],404);
        }

        $order_invoice = OrderInvoice::where('order_id', $request->order_id)->first();
        if($order_invoice){
            return Response::json(['status'=>"Invoice for order already exists"],404);
        }

        $oi = new OrderInvoice;

        //total amount charged on order 
        $total_amount = (int)$request->total_amount;
        $gst = (float)$total_amount - ($total_amount/1.18);



        //assigning data
        $oi->invoice_id= "invoice".(string)sha1(time());
        $oi->shid=$request->shid;
        $oi->uid=$request->uid;
        $oi->order_id=$request->order_id;
        $oi->customer_name=$request->customer_name;
        $oi->cloth_types=$request->cloth_types;
        $oi->total_amount=$request->total_amount;
        $oi->delivery_charge=$request->delivery_charge;
        $oi->gst_no="NOT AVAILABLE";
        $oi->utgst="NOT APPLICABLE";
        $oi->sgst= $gst/2;
        $oi->cgst= $gst/2;
        $oi->service_amount= $total_amount-(int)$gst-($request->delivery_charge);
        $oi->service_charge= 0;
        
        $check_user=$oi->save();

        if($check_user){
            
            return Response::json(['status'=>"Details Saved"],200);
        }else{
            // $response->status='Details Not Saved';
            //return Response::json($response,500);
            return null;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderInvoice  $orderInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(OrderInvoice $orderInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *

     * @return \Illuminate\Http\Response
     */
    public function edit($order_id,$status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderInvoiceRequest  $request
     * @param  \App\Models\OrderInvoice  $orderInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderInvoiceRequest $request, OrderInvoice $orderInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderInvoice  $orderInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderInvoice $orderInvoice)
    {
        //
    }

    public function getInvoiceShop($shid){
        $orders = Order::where('shid', $shid)->get();
        return $orders;
    }

    public function getInvoice($order_id){
        $order_invoice = OrderInvoice::where('order_id', $order_id)->first();
        if(!$order_invoice){
            return Response::json(['status'=>"Order Not Found"],404);
        }

        return Response::json($order_invoice,200);
        
    }

    public function test(){
        $fcm_token;
        FCMService::send(
            $fcm_token,
            [
                'title' => 'New Order',
                'body' => 'You Received a New Order',
            ]
        );
    }
}
