<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopLoginCredController;
use App\Http\Controllers\UserLoginCredController;
use App\Http\Controllers\UserDetailController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopRegister;
use App\Http\Controllers\Vendor_PayoutsController;
use App\Http\Controllers\ShopDocumentController;
use App\Http\Controllers\AdminPayouts;
use App\Http\Controllers\ShopOwnerController;
use App\Http\Controllers\ShopServiceController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\OrderInvoiceController;
use App\Http\Controllers\PushNotificationController;

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
Route::get("userFetch/{uid?}",[UserDetailController::class,'fetch']);
Route::post("userregister",[UserDetailController::class,'store']);
Route::post("neworder",[OrderController::class,'store']);
Route::post("updateShopDetails",[ShopDetailController::class,'updateDetails']);
Route::post("updateUserDetails",[UserDetailController::class,'updateDetails']);
Route::post("inventory",[ShopDetailController::class,'inventory']);
Route::get("userOrderFetch/{uid}/{page}",[OrderController::class,'userFetch']);
Route::post("placeOrder",[OrderController::class,'place']);
Route::post("cancelOrder",[OrderController::class,'cancel']);
Route::post("updateOrder",[OrderController::class,'update']);
Route::get("shopOrderFetch/{shid}/{type}",[OrderController::class,'shopFetch']);
Route::get("orderFetch/{order_id}",[OrderController::class,'fetch']);
Route::get("shopFetch/{shid}",[ShopDetailController::class,'fetch']);
Route::get("shopUserFetch/{express}/{service}/{search?}",[ShopDetailController::class,'userFetch']);
Route::post("test",[ShopRegister::class,'test']);
Route::get("userFetch/{uid}}",[UserDetailController::class,'fetch']);
Route::post("vendorPayment", [VendorPayoutController::class, 'insert']);
Route::get("shopFetchData/{shid}",[ShopDetailController::class, 'index']);
Route::get("fetchShops",[ShopDetailController::class, 'fetchShop']);
Route::get("fetchShopDocs/{shid}",[ShopDocumentController::class, 'fetchDocs']);
Route::get("payout",[AdminPayouts::class, 'makePayment']);
Route::get("orderFetchListCompleted",[OrderController::class, 'ordersFetchCompleted']);
Route::get("orderFetchListPending",[OrderController::class, 'ordersFetchPending']);
Route::get("orderFetchList",[OrderController::class, 'ordersFetchAll']);
Route::post("updateVerification",[ShopDocumentController::class, 'verify']);
Route::post("makePayout",[Vendor_PayoutsController::class, 'payout']);
Route::get("getOwnerDetails/{shid}",[ShopOwnerController::class, 'display']);
Route::post("updateVerificationCred",[ShopLoginCredController::class,'verify']);
Route::get("fetchUtr/{pid}",[Vendor_PayoutsController::class, 'fetchPayouts']);
Route::post("createPayout", [Vendor_PayoutsController::class, 'create']);
Route::post("updatePayout", [Vendor_PayoutsController::class, 'update']);
Route::get("fetchPayments", [Vendor_PayoutsController::class, 'fetchAll']);
Route::get("fetchPayments/{shid}", [Vendor_PayoutsController::class, 'fetchAllPay']);
Route::get("stats/{shid}/{type}",[OrderController::class,'stats']);
Route::get("expressChange/{shid}/{express}",[ShopDetailController::class,'expressChange']);
Route::post("invoice",[OrderController::class,'invoice']);
Route::post("changeProfile",[ShopDetailController::class,'changeProfile']);
Route::post("changeProfileForm",[ShopDetailController::class,'changeProfileForm']);
Route::get("orderFetchList/{shid}",[OrderController::class, 'ordersFetch']);
Route::get("orderFetchListProcessed/{shid}",[OrderController::class, 'ordersFetchProcessed']);
Route::get("statusChange/{shid}/{status}",[ShopDetailController::class,'statusChange']);

//Feedback
Route::post("giveFeedback",[FeedbackController::class,'store']);
Route::get("feedbackForOrder/{orderid}",[FeedbackController::class,'feedbackOrder']);
Route::get("getCummulativeRating/{shid}",[FeedbackController::class,'getCummulativeRating']);


//Update Docs
Route::get("getDocDetails/{shid}",[ShopDocumentController::class, 'get']);
Route::post("changeDocsDetails",[ShopDocumentController::class, 'edit']);


//order invoice
Route::get("getInvoice/{order_id}",[OrderInvoiceController::class, 'getInvoice']);

//notification
Route::get("notification",[OrderController::class,'sendNotification']);
Route::post("updateToken",[PushNotificationController::class,'update']);
