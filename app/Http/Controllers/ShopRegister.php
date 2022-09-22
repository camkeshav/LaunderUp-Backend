<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopLoginCred;

use App\Http\Controllers\ShopOwnerController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\ShopDocumentsController;
use Illuminate\Support\Facades\DB;

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
            'shop_documents'=>'required'
            
        ]);
        

        $user = ShopLoginCred::where('shid', $request->shid)->get();
        if(!$user){
            return Response::json(["status"=>'Deatails Not Saved',"error"=>"Shid is incorrect"]);
        }
        
        //putting shid in json objects
        $shop_owner_details = $request->shop_owner_details;
        $shop_owner_details["shid"]= $request->shid;
        

        $shop_details = $request->shop_details;
        $shop_details["shid"] = $request->shid;
        
        $shop_documents = $request->shop_documents;
        $shop_documents["shid"] = $request->shid;
        

        DB::beginTransaction();

        try {
            $result=(new ShopOwnerController)->store(new Request($shop_owner_details));
            if(!$result) throw "Details Not Saved";

            // $result=(new ShopDetailController)->store(new Request($shop_details));
            // if(!$result) throw "Details Not Saved";

            // $result=(new ShopDocumentController)->store(new Request($shop_documents));
            // if(!$result) throw "Details Not Saved";

            
            DB::commit();
            return Response::json(["status"=>'Details Saved'],200);
            
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(["status"=>'Details Not Saved',"error"=>"{$e}"],500);
        }


        }
}
