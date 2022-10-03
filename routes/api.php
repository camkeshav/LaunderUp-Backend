<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopLoginCredController;
use App\Http\Controllers\UserLoginCredController;
use App\Http\Controllers\UserDetailController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopRegister;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("shoplogin",[ShopLoginCredController::class,'index']);
Route::post("register",[ShopRegister::class,'create']);
Route::post("userlogin",[UserLoginCredController::class,'index']);
Route::post("userregister",[UserDetailController::class,'store']);
Route::post("neworder",[OrderController::class,'store']);
Route::post("updateShopDetails",[ShopDetailController::class,'updateDetails']);
Route::post("updateUserDetails",[UserDetailController::class,'updateDetails']);
Route::post("inventory",[ShopDetailController::class,'inventory']);
Route::get("userOrderFetch/{uid}",[OrderController::class,'userFetch']);
Route::get("placeOrder",[OrderController::class,'place']);
 