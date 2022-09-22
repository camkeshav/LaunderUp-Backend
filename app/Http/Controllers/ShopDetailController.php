<?php

namespace App\Http\Controllers;

use App\Models\ShopDetail;
use Illuminate\Http\Request;
use App\Models\ShopLoginCred;
use Illuminate\Validation\ValidationException;
use Response;

class ShopDetailsController extends Controller
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
            'services_available'=>'required',
            'cloth_types'=>'required',

        ]);

        $user = ShopLoginCred::where('shid', $request->shid)->get();
        if(!$user){
            throw ValidationException::withMessages(['error' => 'Shid is incorrect']);
        }
        $user=ShopDetail::where('shid', $request->shid)->get();
        
    

            $new_user = new ShopDetail;
            $new_user->shid=$request->shid;
            $new_user->shop_name=$request->shop_name;
            $new_user->shop_address=$request->shop_address;
            $new_user->shio_phone_number=$request->shop_phone_no;
            $new_user->operational_hours=$request->operation_hours;
            $new_user->days_open=$request->days_open;
            $new_user->services_available=$request->service_available;
            $new_user->cloth_types=$request->cloth_types;
            $new_user->images_url = $request->file('profile_image')->store("images/$shid");
                


            
            $check_user;

            if($user){
                $check_user=edit($new_user);
            }else{
                $check_user=$new_user->save();

            }
            if($check_user){
                
                return Response::json(['status'=>"Details Saved"],200);
            }else{
                //$response->status='Details Not Saved';
                //return Response::json($response,500);
                return null;
            }



    }

    /**
     * Display the specified resource.
     
     * @param  \App\Models\ShopDetails  $shopDetails
     * @return \Illuminate\Http\Response
     */
    public function show(ShopDetails $shopDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopDetails  $shopDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopDetails $request)
    {
        $new_user = ShopDetail::find($request->shid);
        $new_user->shop_name=$request->shop_name;
        $new_user->shop_address=$request->shop_address;
        $new_user->shio_phone_number=$request->shop_phone_no;
        $new_user->operational_hours=$request->operation_hours;
        $new_user->days_open=$request->days_open;
        $new_user->services_available=$request->service_available;
        $new_user->cloth_types=$request->cloth_types;
        $new_user->images_url = $request->file('image')->store("images/$shid");
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
     * @param  \App\Models\ShopDetails  $shopDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopDetails $shopDetails)
    {   

        $request->validate([
            'shid' => 'required',
            'shop_name'=>'required',
            'shop_address'=>'required',
            'shop_phone_no'=>'required',
            'operational_hours'=>'required',
            'days_open'=>'required',
            'services_available'=>'required',
            'cloth_types'=>'required',

        ]);
        
        $new_user = ShopDetail::find($request->shid);
        if(!$new_user){
            return Response::json(["error"=>'Account Not Found'],404);
        }
        $$new_user = ShopDetail::find($request->shid);
        $new_user->shop_name=$request->shop_name;
        $new_user->shop_address=$request->shop_address;
        $new_user->shio_phone_number=$request->shop_phone_no;
        $new_user->operational_hours=$request->operation_hours;
        $new_user->days_open=$request->days_open;
        $new_user->services_available=$request->service_available;
        $new_user->cloth_types=$request->cloth_types;
        $new_user->images_url = $request->file('image')->store("images/$shid");
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
     * @param  \App\Models\ShopDetails  $shopDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopDetails $shopDetails)
    {
        //
    }
}
