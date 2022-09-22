<?php

namespace App\Http\Controllers;

use App\Models\ShopOwner;
use App\Models\ShopLoginCred;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Response;

class ShopOwnerController extends Controller
{
    /**
     * Display a listing of the rnpesource.
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'shid' => 'required',
            'owner_name'=>'required',
            'owner_address'=>'required',
            'owner_phone'=>'required',

        ]);

        $user = ShopLoginCred::where('shid', $request->shid)->get();
        if(!$user){
            throw ValidationException::withMessages(['error' => 'Shid is incorrect']);
        }
        $user = ShopOwner::where('shid', $request->shid)->first();

        
            $new_user = new ShopOwner;
            $new_user->owner_name=$request->owner_name;
            $new_user->owner_address=$request->owner_address;
            $new_user->owner_phone=$request->owner_phone;
            $new_user->shid=$request->shid;
        
            $check_user;
        if($user==null){
            $check_user=$new_user->save();

        }else{
            $check_user=edit($new_user);
        }
        
        
        if($check_user){
           
            return Response::json(['status'=>"Details Saved"],200);
        }else{
            //$response->status='Deatils Not Saved';
            //return Response::json($response,500);
            return null;
        }
        



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopOwner  $shopOwner
     * @return \Illuminate\Http\Response
     */
    public function show(ShowOwner $showOwner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShowOwner  $shopOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopOwner $shopOwner)
    {
        $new_user = ShopOwner::find($shopOwner->shid);
        $new_user->owner_name=$shopOwner->owner_name;
        $new_user->owner_address=$shopOwner->owner_address;
        $new_user->owner_phone=$shopOwner->owner_phone;
        $result = $new_user->save();
        if(result){
            return ["result"=>'updated'];
        }else{
            return null;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShopOwner  $showOwner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopOwner $shopOwner)
    {
        $request->validate([
            'shid' => 'required',
            'owner_name'=>'required',
            'address'=>'required',
            'phone_no'=>'required',

        ]);
        
        $new_user = ShopOwner::find($request->shid);
        if(!$new_user){
            return Response::json(["error"=>'Account Not Found'],404);
        }
        $new_user->owner_name=$request->owner_name;
        $new_user->owner_address=$request->owner_address;
        $new_user->owner_phone=$request->owner_phone;
        $result = $new_user->save();
        if(result){
            return Response::json(["result"=>'Details Updated'],200);
        }else{
            return Response::json(["error"=>'Deatails Not Saved'],500);
        }
    
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopOwner  $shopOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopOwner $shopOwner)
    {
        //
    }
}
