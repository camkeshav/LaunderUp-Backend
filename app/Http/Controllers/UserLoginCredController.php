<?php

namespace App\Http\Controllers;

use App\Models\UserLoginCred;
use App\Http\Requests\StoreUserLoginCredRequest;
use App\Http\Requests\UpdateUserLoginCredRequest;

class UserLoginCredController extends Controller
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
}
