<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopLoginCred;
use Illuminate\Routing\ResponseFactory;
use Response;

class ShopLoginCredController extends Controller
{
    function index(Request $request){
        $account_type;
        $shid;
        $request->validate([
            'phone' => 'required',
            
        ]);


        $user = ShopLoginCred::where('phone', $request->phone)->first();

        if($user==null){
            
            $new_user = new ShopLoginCred;
            $new_user->phone=$request->phone;
            $new_user->shid="shid".(string)sha1(time());
            $check_user=$new_user->save();
            if($check_user==null){
                $account_type="Problem";
                return Response::json([
                            'error' => ['Problem While Creating User'],
                        ],500);
            }else{
                $user = ShopLoginCred::where('phone', $request->phone)->first();
                $account_type="Created";
                $shid=$new_user->shid;
            }
        }else{
            if($user->account_created_at!=null){
                $account_type='Logged In';
                
            }else{
                $account_type="Created but phone number exists";
            }
            $shid=$user->shid;
            
        }

        $token = $user->createToken($request->phone)->plainTextToken;
        $response = [
            'account_status'=>$account_type,
            'token'=>$token,
            'shid'=>$shid,
            "verified_at"=>$user->verfied_at

        ];
     
        return Response::json( $response,200 );
   
  

       
    }


    public function verify(Request $request){

        $request->validate([
            'shid' => 'required',
        ]);

        $new_user = ShopLoginCred::where('shid', $request->shid)->first();
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
