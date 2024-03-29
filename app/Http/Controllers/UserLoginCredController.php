<?php

namespace App\Http\Controllers;
use App\Models\UserLoginCred;
use Illuminate\Http\Request;
use Response;



class UserLoginCredController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $account_type;
        $uid;
        $request->validate([
            'phone' => 'required',
            
            
        ]);


        $user = UserLoginCred::where('phone', $request->phone)->first();

        if($user==null){
            
            $new_user = new UserLoginCred;
            $new_user->phone=$request->phone;
            $new_user->uid="uid".(string)sha1(time());
            $check_user=$new_user->save();
            if($check_user==null){
                $account_type="Problem";
                return Response::json([
                            'error' => ['Problem While Creating User'],
                        ],500);
            }else{
                $user = UserLoginCred::where('phone', $request->phone)->first();
                $account_type="Created";
                $uid=$new_user->uid;
            }
        }else{
            if($user->account_created_at!=null){
                $account_type='Logged In';
                
            }else{
                $account_type="Created but phone number exists";
            }
            $uid=$user->uid;
            
        }

        $token = $user->createToken($request->phone)->plainTextToken;
        $response = [
            'account_status'=>$account_type,
            'token'=>$token,
            'uid'=>$uid,
            "verified_at"=>$user->verfied_at

        ];

        UserLoginCredController::sendNoti("f8E7QiQUTHic4tgBzp-9XD:APA91bFEOTdo6aaGWsXEoImjPoIUFojLA_xnJpfgSsdc5KVNEDybcgDBVl5h2LDbwHa7mmgEj88JPTgMrxEDmrM70LAcOrnPVQ0a37G8-IqI9_kTXGoesAZ-w45hROXluhp9d6Yy9PCq");

        return Response::json( $response,200);
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
     * @param  \App\Http\Requests\StoreUserLoginCredRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserLoginCredRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserLoginCred  $userLoginCred
     * @return \Illuminate\Http\Response
     */
    public function show(UserLoginCred $userLoginCred)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserLoginCred  $userLoginCred
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLoginCred $userLoginCred)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserLoginCredRequest  $request
     * @param  \App\Models\UserLoginCred  $userLoginCred
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserLoginCredRequest $request, UserLoginCred $userLoginCred)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserLoginCred  $userLoginCred
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserLoginCred $userLoginCred)
    {
        //
    }
    public function sendNoti($deviceid){
        // Generated @ codebeautify.org
        $id = 'f7YcqgXZTqyNnxcHf7aU7u:APA91bHPqH8zGmA8smHP3S40lzYSF-Vk0dnJfDvboQsW-tk8almyckIpN_URKr9KYINwuz1wy7ChBpS9Q_5LdDnuxgGtlljWs_9gm0wl1eplCJpV6dFLAP9-DGymZqNE7Cl24k2nN3D-';
        $url='https://fcm.googleapis.com/v1/projects/launderup-fce42/messages:send';
        $api_key='BOLjimDaTy82tf6__scFA02P9hBlRXhfMqd8wsNPhzvUQdyZ4PFdfniIJLkyXqCAQMKs-sseEXVGjcDv_Ou7Ysk';
        $fields="{\n\"message\":{\n  
             \"notification\":{\n   
                  \"title\":\"New Order\",\n  
                  \"body\":\"You Have new Order Click to Open\"\n 
                      },\n 
          \"token\": $deviceid \n}}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);


        $headers = array();
        $headers[] = 'Authorization: Bearer '.$api_key;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

    }
}
