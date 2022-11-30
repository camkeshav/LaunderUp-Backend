<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopDocument;
use App\Models\ShopLoginCred;
use Illuminate\Validation\ValidationException;
use Response;

class ShopDocumentController extends Controller
{
    // $table->id();
    // $table->string('shid');
    // $table->timestamp('verified_at')->nullable();
    // $table->boolean('gst_registered');
    // $table->boolean('five_percent_gst');
    // $table->string('gst_number');
    // $table->string('pan_number');
    // $table->string('entity_name');
    // $table->string('address_legal_entity');
    // $table->string('pan_image_url');
    // $table->string('shop_license_number');
    // $table->string('shop_licence_image_url');
    // $table->string('bank_name');
    // $table->string('bank_account_number');
    // $table->string('ifsc_code');
    function fetchDocs($shid){
        return ShopDocument::where('shid',$shid)->get();
    }
    function store(Request $request){
        $request->validate([
            'shid' => 'required',
            'gst_registered'=>'required|boolean',
            'five_percent_gst'=>'required|boolean',
            'bank_name'=>'required',
            'bank_account_number'=>'required',
            'ifsc_code'=>'required',
            'pan_image'=>'required',
            'shop_license_image'=>'required',

        ]);
        $user=ShopLoginCred::where('shid', $request->shid)->first();
        if(!$user){
            throw ValidationException::withMessages(['error' => 'Shid is incorrect']);
        }

        //Creating New User
        if($request->pan_number==null&&$request->shop_license_number==null){
            return Response::json(['error'=>['Either Pan or License Number required'],422]);
        }
        $user=ShopDocument::where('shid', $request->shid)->first();

        $new_user=new ShopDocument;
        $new_user->shid=$request->shid;
        
        $new_user->gst_registered=$request->gst_registered;
        $new_user->five_percent_gst=$request->five_percent_gst;
        $new_user->gst_number=$request->gst_number;
        $new_user->pan_number=$request->pan_number;
        $new_user->entity_name=$request->entity_name;
        $new_user->address_legal_entity=$request->address_legal_entity;
        $new_user->pan_image_url= $request->pan_image;
        $new_user->shop_license_number=$request->shop_license_number;
        $new_user->shop_license_image_url=$request->shop_license_image;
        $new_user->bank_name=$request->bank_name;
        $new_user->bank_account_number=$request->bank_account_number;
        $new_user->ifsc_code=$request->ifsc_code;

        
        $check_user;

        if($user){
            $check_user=ShopDocumentController::edit($new_user);
        }else{
            $check_user=$new_user->save();

        }
        if($check_user){
            
            return Response::json(['status'=>"Details Saved"],200);
        }else{
            // $response->status='Details Not Saved';
            //return Response::json($response,500);
            return null;
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopDetails  $shopDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopDocument $request)
    {
        $new_user = ShopDocument::where('shid', $request->shid)->first();
        $new_user->gst_registered=$request->gst_registered;
        $new_user->five_percent_gst=$request->five_percent_gst;
        $new_user->gst_number=$request->gst_number;
        $new_user->pan_number=$request->pan_number;
        $new_user->entity_name=$request->entity_name;
        $new_user->address_legal_entity=$request->address_legal_entity;
        $new_user->pan_image_url= $request->pan_image_url;
        $new_user->shop_license_number=$request->shop_license_number;
        $new_user->shop_license_image_url=$request->shop_license_image_url;
        $new_user->bank_name=$request->bank_name;
        $new_user->bank_account_number=$request->bank_account_number;
        $new_user->ifsc_code=$request->ifsc_code;
        $result = $new_user->save();
        if($result){
            return ["result"=>'updated'];
        }else{
            return null;
        }

    }

    public function verify(Request $request){

        $request->validate([
            'shid' => 'required',
        ]);

        $new_user = ShopDocument::where('shid', $request->shid)->first();
            // $result = $new_user->update(['verified_at' => now()]);
        $result = $new_user->update(['verified_at' => now()]);
        
        if($result){
            return Response::json(["result"=>'Details Updated'],200);
        }
        else{
            return Response::json(["error"=>'Details Not Updated'],500);
        }
    }

   
}
