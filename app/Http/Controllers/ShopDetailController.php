<?php

namespace App\Http\Controllers;

use App\Models\ShopDetail;
use Illuminate\Http\Request;
use App\Models\ShopLoginCred;
use Illuminate\Validation\ValidationException;
use Response;

class ShopDetailController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /*     $table->id();
        $table->string('shop_name');
        $table->string('shop_address');
        $table->string('shop_phone');
        $table->string('operational_hours');
        $table->string('days_open');
        $table->string('images_url');
        $table->string('services_available');
        $table->string('cloth_types');
        $table->timestamps();*/

        $request->validate([
            'shid' => 'required',
            'shop_name'=>'required',
            'shop_address'=>'required',
            'shop_phone_no'=>'required',
            'operational_hours'=>'required',
            'days_open'=>'required',
            'express'=>'required|boolean',
            'services_available'=>'required',
            'cloth_types'=>'required',

        ]);

        $user = ShopLoginCred::where('shid', $request->shid)->first();
        if(!$user){
            throw ValidationException::withMessages(['error' => 'Shid is incorrect']);
        }
        $user=ShopDetail::where('shid', $request->shid)->first();
        
    

            $new_user = new ShopDetail;
            $new_user->shid=$request->shid;
            $new_user->shop_name=$request->shop_name;
            $new_user->shop_address=$request->shop_address;
            $new_user->shop_phone_no=$request->shop_phone_no;
            $new_user->operational_hours=$request->operational_hours;
            $new_user->days_open=$request->days_open;
            $new_user->express=$request->express;
            $new_user->services_available=$request->services_available;
            $new_user->cloth_types=json_encode($request->cloth_types);
            $new_user->image_url = $request->profile_image;
                

            $check_user;

            if($user){
                $check_user=ShopDetailController::edit($new_user);
            }else{
                $check_user=$new_user->save();

            }
            if($check_user!=null){
                
                return Response::json(['status'=>"Details Saved"],200);
            }else{
                
                return null;
            }



    }

    /**
     * Display the specified resource.
     
     * @param  \App\Models\ShopDetail  $shopDetails
     * @return \Illuminate\Http\Response
     */
    public function show(ShopDetail $shopDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopDetail  $shopDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopDetail $request)
    {
        $new_user = ShopDetail::find($request->shid);
        $new_user->shop_name=$request->shop_name;
        $new_user->shop_address=$request->shop_address;
        $new_user->shio_phone_number=$request->shop_phone_no;
        $new_user->operational_hours=$request->operational_hours;
        $new_user->days_open=$request->days_open;
        $new_user->express=$request->express;
        $new_user->services_available=$request->services_available;
        $new_user->cloth_types=json_encode($request->cloth_types);
        $new_user->image_url =$request->profile_image;
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
     * @return \Illuminate\Http\Response
     */
    public function updateDetails(Request $request)
    {   

        $request->validate([
            'shid' => 'required',
            'shop_name'=>'required',
            'shop_address'=>'required',
            'shop_phone_no'=>'required',
            'operational_hours'=>'required',
            'days_open'=>'required',
            'services_available'=>'required',
            

        ]);
        
        $new_user = ShopDetail::where('shid',$request->shid)->first();
        if(!$new_user){
            return Response::json(["error"=>'Account Not Found'],404);
        }
        $new_user = ShopDetail::where('shid',$request->shid)->first();
        $new_user->shop_name=$request->shop_name;
        $new_user->shop_address=$request->shop_address;
        $new_user->shop_phone_no=$request->shop_phone_no;
        $new_user->operational_hours=$request->operational_hours;
        $new_user->days_open=$request->days_open;
        $new_user->express=$request->express;
        $new_user->services_available=$request->services_available;
       
        // $new_user->cloth_types=$request->cloth_types;
        // $new_user->image_url = $request->profile_image;
        
        $result = $new_user->save();
        if($result){
            return Response::json(["result"=>'Details Updated'],200);
        }else{
            return Response::json(["error"=>'Details Not Updated'],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopDetail  $shopDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopDetail $shopDetails)
    {
        //
    }

    public function inventory(Request $request){

        $request->validate([
            'shid'=>'required',
            'cloth_types'=>'required',

        ]);

        $new_user = ShopDetail::where('shid',$request->shid)->first();
        if(!$new_user){
            return Response::json(["error"=>'Account Not Found'],404);
        }
        $new_user = ShopDetail::where('shid',$request->shid)->first();
        $new_user->cloth_types=$request->cloth_types;

        $result = $new_user->save();
        if($result){
            return Response::json(["result"=>'Details Updated'],200);
        }else{
            return Response::json(["error"=>'Details Not Updated'],500);
        }

    }

    public function fetch($shid){
        return ShopDetail::where('shid',$shid)->first();
    }

    public function userFetch($express,$service,$search=null){

        return $search?ShopDetail::where('express',filter_var($express, FILTER_VALIDATE_BOOLEAN))
                        ->where('services_available',"like","%".$service."%")
                        ->where('shop_name',"like","%".$search."%")
                        ->paginate(20):
                        ShopDetail::where('express',filter_var($express, FILTER_VALIDATE_BOOLEAN))
                        ->where('services_available',"like","%".$service."%")->paginate(20);

        
        


    }
}
