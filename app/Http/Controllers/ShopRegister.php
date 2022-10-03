<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopLoginCred;

use App\Http\Controllers\ShopOwnerController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\ShopDocumentsController;
use DB;
use Carbon\Carbon;
use Response;

DB::beginTransaction();

class ShopRegister extends Controller
{
    //create a new shop details

    function create(Request $request){
        $request->validate([
            'shid' => 'required',
            'shop_owner_details'=>'required',
            'shop_details'=>'required',
            'shop_documents'=>'required',
            'profile_image'=>'required',
            'pan_image'=>'required',
            'shop_license_image'=>'required'
            
        ]);
        

        $user = ShopLoginCred::where('shid', $request->shid)->first();
        if(!$user){
            return Response::json(["status"=>'Deatails Not Saved',"error"=>"Shid is incorrect"]);
        }
        
        //putting shid in json objects
        $shop_owner_details = $request->shop_owner_details;
        $shop_owner_details["shid"]= $request->shid;
        $shop_owner_details["profile_image"]=$request->file('profile_image')->store('images/profile_images');
        

        $shop_details = $request->shop_details;
        $shop_details["shid"] = $request->shid;
        $shop_owner_details["pan_image"]=$request->file('pan_image')->store("images/documents/$shid");
        
        $shop_documents = $request->shop_documents;
        $shop_documents["shid"] = $request->shid;
        $shop_owner_details["shop_license_image"]=$request->file('shop_license_image')->store("images/documents/$shid");

        DB::beginTransaction();

        $check;

        try {
            $result=(new ShopOwnerController)->store(new Request($shop_owner_details));
            if(!$result) throw "Details Not Saved";

            $result=(new ShopDetailController)->store(new Request($shop_details));
            if(!$result) throw "Details Not Saved";

            $result=(new ShopDocumentController)->store(new Request($shop_documents));
            if(!$result) throw "Details Not Saved";

            
        } catch (Exception $e) {
            DB::rollback();
            return Response::json(["status"=>'Details Not Saved',"error"=>"{$e}"],500);
            
        }
        
        DB::commit();
        DB::commit();
        ShopLoginCred::where('shid', $request->shid)->update(['account_created_at' =>Carbon::now()]);
        return Response::json(["status"=>'Details Saved'],200);
       


    }
}
