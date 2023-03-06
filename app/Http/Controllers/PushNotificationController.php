<?php

namespace App\Http\Controllers;

use App\Models\PushNotification;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePushNotificationRequest;
use App\Http\Requests\UpdatePushNotificationRequest;
use Illuminate\Http\Request;
use Response;

class PushNotificationController extends Controller
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
     * @param  \App\Http\Requests\StorePushNotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePushNotificationRequest $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function show(PushNotification $pushNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(PushNotification $pushNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePushNotificationRequest  $request
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'shid' => 'required',
            'token'=> 'required'
        ]);

        $notification = PushNotification::where("shid",$request->shid)->first();
            $notification->token = $request->token;
            $result = $notification->save();

            if($result){
                return Response::json(["result"=>'Details Updated'],200);
            }
            else{
                return Response::json(["error"=>'Details Not Updated'],500);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(PushNotification $pushNotification)
    {
        //
    }
}
