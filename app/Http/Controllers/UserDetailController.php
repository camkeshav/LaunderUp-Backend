<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use App\Models\UserLoginCred;
use App\Http\Requests\StoreUserDetailRequest;
use App\Http\Requests\UpdateUserDetailRequest;
use Illuminate\Http\Request;
use Response;
use Carbon\Carbon;

class UserDetailController extends Controller
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
     * @param  \App\Http\Requests\StoreUserDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // $table->id();
        // $table->string('uid')->unique();
        // $table->string('name');
        // $table->string('phone');
        // $table->string('email');
        // $table->string('city');
        // $table->string('pin');
        // $table->timestamps();

        $request->validate([
            'uid' => 'required',
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'city'=>'required',
            'pin'=>'required',
            
        ]);

        $user = UserLoginCred::where('uid', $request->uid)->first();
        
        if(!$user){
            throw ValidationException::withMessages(['error' => 'Uid is incorrect']);
        }

        $user = UserDetail::where('uid', $request->uid)->first();
            if($user){
                return Response::json(['status'=>"Uid Already Exists"],500);
            }
       
            $new_user = new UserDetail;
            $new_user->uid=$request->uid;
            $new_user->name=$request->name;
            $new_user->email=$request->email;
            $new_user->phone=$request->phone;
            $new_user->city=$request->city;
            $new_user->pin=$request->pin;

            $check_user=$new_user->save();

        
            if($check_user!=null){
                UserLoginCred::where('uid', $request->uid)->update(['account_created_at' => Carbon::now()]);                
                return Response::json(['status'=>" User Details Saved"],200);
            }else{
                
                return Response::json(['status'=>" User Details Not Saved"],500);
            }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function show(UserDetail $userDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(UserDetail $userDetail)
    {
        //
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
            'uid' => 'required',
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'city'=>'required',
            'pin'=>'required',
            

        ]);
        
        $new_user = UserDetail::where('uid',$request->uid)->first();
        if(!$new_user){
            return Response::json(["error"=>'Account Not Found'],404);
        }
        $new_user = UserDetail::where('uid',$request->uid)->first();
        $new_user->name=$request->name;
        $new_user->phone=$request->phone;
        $new_user->email=$request->email;
        $new_user->city=$request->city;
        $new_user->pin=$request->pin;
       
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
     * @param  \App\Models\UserDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDetail $userDetail)
    {
        //
    }
    public function fetch($uid=null){
        if($uid!=null){

            $data = UserDetail::where('uid',$uid)->first();
            if($data==null){
                return Response::json(["error"=>'Uid Not Found'],500);
            }else{
                return $data;
            }
        }
        return UserDetail::all();
    }

    public function fetchAll(){
        return UserDetail::all();
    }

    public function allFetch(){
        return UserDetail::all();
    }
}
