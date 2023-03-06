<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use App\Models\UserDetail;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use Response;
use Illuminate\Http\Request;

class FeedbackController extends Controller
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
     * @param  \App\Http\Requests\StoreFeedbackRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([
            
            'order_id'=>'required',
            'uid'=>'required',
            'rating'=>'required',
            'comment'=>'required',
            
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

        $feedback = Feedback::where('order_id', $request->order_id)->first();
        if($feedback){
            return Response::json(['status'=>"Feedback for order already exists"],500);
        }

      
        
    

            $new_user = new Feedback;
            $new_user->shid = $order->shid;
            $new_user->uid = $request->uid;
            $new_user->order_id = $request->order_id;
            $new_user->rating = $request->rating;
            $new_user->comment = $request->comment;
            $new_user->client_name = $user->name;

            $check_user;



            
                $check_user=$new_user->save();

            
            if($check_user!=null){
                
                return Response::json(['status'=>"Details Saved"],200);
            }else{
                
                return null;
            }
    }

    public function getCummulativeRating($shid){
        $avg = Feedback::where('shid', $shid)->avg('rating');

        if($avg == null ){
            return Response::json(['rating'=>"0"],200);
        }
        return Response::json(['rating'=>$avg],200);

    }

    public function feedbackOrder($order_id){
        
        $feedback = Feedback::where('order_id', $order_id)->first();
        if(!$feedback){
            return Response::json(['status'=>"Feedback doesn't exists"],404);
        }
        return Response::json($feedback,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFeedbackRequest  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}


