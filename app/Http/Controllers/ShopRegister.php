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
use Illuminate\Support\Facades\Storage;



class ShopRegister extends Controller
{
    //create a new shop details

    function create(Request $request){

        
        $request->validate([
            'shid' => 'required',
            'shop_owner_details'=>'required',
            'shop_details'=>'required',
            'shop_documents'=>'required',
            // 'profile_image'=>'required',
            // 'pan_image'=>'required',
            // 'shop_license_image'=>'required'
            
        ]);

        $shid = $request->shid;
        

        $user = ShopLoginCred::where('shid', $request->shid)->first();
        if(!$user){
            return Response::json(["status"=>'Deatails Not Saved',"error"=>"Shid is incorrect"],500);
        }

        DB::beginTransaction();
        try {
        
        //putting shid in json objects
        $shop_owner_details = json_decode($request->shop_owner_details,true);
        $shop_owner_details['shid']= $request->shid;
        //$shop_owner_details["profile_image"]=$request->file('profile_image')->store('images/profile_images');
        
        

        $shop_details = json_decode($request->shop_details,true);
        $shop_details['shid'] = $request->shid;

        $store;
        //$shop_details["profile_image"]=base64_decode($request->filename)->store("images/documents/$shid");
        
        if(!$request->profile_image){
            $store = Storage::disk('s3')->put("images/".$shid, $request->profile_image);
            
            if($store!=null){
                $shop_details['profile_image'] = "https://launderup.s3.ap-south-1.amazonaws.com/".$store;
                Storage::disk('s3')->setVisibility($shop_details['profile_image'] ,'public');
            }else{
                $shop_details['profile_image']="null";
            }
        }
       
        

        // $shop_details["profile_image"]="image";
        

        $shop_documents = json_decode($request->shop_documents,true);
        $shop_documents['shid'] = $request->shid;
        //$shop_owner_details["shop_license_image"]=$request->file('shop_license_image')->store("images/documents/$shid");
        // $shop_documents["pan_image"]="image";
        // $shop_documents["shop_license_image"]="image";

        
        if(!$request->pan_image){
            $store = Storage::disk('s3')->put("images/".$shid, $request->pan_image);

            if($store!=null){
                $shop_documents['pan_image'] = "https://launderup.s3.ap-south-1.amazonaws.com/".$store;
                Storage::disk('s3')->setVisibility($shop_documents['pan_image'] ,'public');
            }else{
                $shop_documents['pan_image'] = "null";
    
            }
        }
        

        
            
        if(!$request->shop_license_image){
            $store = Storage::disk('s3')->put("images/".$shid, $request->shop_license_image);
            
            if($store!=null){
                $shop_documents['shop_license_image'] = "https://launderup.s3.ap-south-1.amazonaws.com/".$store;
                Storage::disk('s3')->setVisibility($shop_documents['shop_license_image'] ,'public');
            }else{
                $shop_documents['shop_license_image'] ="null";
            }
        }

        


        

        $check;

        
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
        ShopLoginCred::where('shid', $request->shid)->update(['account_created_at' =>Carbon::now()]);
        return Response::json(["status"=>'Details Saved'],200);
       


    }

    public function test(Request $request){
        $store = Storage::put('file.jpg', base64_decode($request->profile_image));

        if($store==1){
            return $path = Storage::path('file.jpg');
        }
    }
}
