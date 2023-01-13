<?php

namespace App\Http\Controllers;

use App\Models\ShopService;
use App\Models\ShopLoginCred;
use App\Http\Requests\StoreShopServiceRequest;
use App\Http\Requests\UpdateShopServiceRequest;
use Illuminate\Http\Request;

class ShopServiceController extends Controller
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
    public function create(Request $request)
    {

        $request->validate([
            'shid' => 'required',
        ]);
        $new_user = new ShopService;
        $new_user->shid = $request->shid;
        $new_user->status = false;


        
            $check_user=$new_user->save();

        
        if($check_user){
            
            return Response::json(['status'=>"Details Saved"],200);
        }else{
            // $response->status='Details Not Saved';
            //return Response::json($response,500);
            return null;
        }
         
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreShopServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShopServiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopService  $shopService
     * @return \Illuminate\Http\Response
     */
    public function show(ShopService $shopService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopService  $shopService
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopService $shopService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShopServiceRequest  $request
     * @param  \App\Models\ShopService  $shopService
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShopServiceRequest $request, ShopService $shopService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopService  $shopService
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopService $shopService)
    {
        //
    }

    public function statusChange($shid,$status){
        $new_user = ShopLoginCred::where('shid',$shid)->first();
        if(!$new_user){
            return Response::json(["error"=>'Account Not Found'],404);
        }
        if(!$new_user->verified_at){
            return Response::json(["error"=>'Account Not Verified'],500);
        }

        $new_user = ShopService::where('shid',$shid)->first();
        if(!$new_user){
            return Response::json(["error"=>'Account Not Found'],404);
        }

        
        $new_user->status = filter_var($status, FILTER_VALIDATE_BOOLEAN);  
        $result = $new_user->save();
        if($result){
            return Response::json(["result"=>'Status Changed'],200);
        }else{
            return Response::json(["error"=>'Status Not Changed'],500);
        }
        
    }
}
