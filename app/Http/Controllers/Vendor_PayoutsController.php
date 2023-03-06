<?php

namespace App\Http\Controllers;
use App\Models\Vendor_Payouts;
use Illuminate\Http\Request;
use Response;

class Vendor_PayoutsController extends Controller
{

    public function create(Request $request){

        $request->validate([
            'shid' => 'required',
            'pid'=>'required',
            'amount'=>'required',
            'status' => 'required',
            
        ]);

        $pout = Vendor_Payouts::where('razorpay_payout_id', $request->pid)->first();
        if($pout == NULL){
            $newpout = new Vendor_Payouts();
            $newpout->shid = $request->shid;
            $newpout->razorpay_payout_id = $request->pid;
            $newpout->total_amount = $request->amount;
            $newpout->status = $request->status;
            //$newpout->created_at = now();
            $checkpout = $newpout->save();

            if($checkpout!=null){
                Vendor_Payouts::where('razorpay_payout_id', $request->pid)->update(['created_at' => now()]);                
                return Response::json(['status'=>" Payment Details Saved"],200);
            }else{
                
                return Response::json(['status'=>" Payment Details Not Saved"],500);
            }
        }
    }

    function update(Request $request){
        $request->validate([
            'shid' => 'required',
            'pid'=>'required',
            'utr'=>'required',
            'status'=>'required',
            
        ]);

        $instance = Vendor_Payouts::where('razorpay_payout_id', $request->pid)->first();
        if($instance != NULL){
            $instance->razorpay_utr = $request->utr;
            $instance->status = $request->status;
            $checkpout = $instance->save();

            if($checkpout!=null){
                Vendor_Payouts::where('razorpay_payout_id', $request->pid)->update(['updated_at' => now()]);                
                return Response::json(['status'=>" Payment Details Updated"],200);
            }else{
                
                return Response::json(['status'=>" Payment Details Not Updated"],500);
            }
        }
        

    }

    public function fetchAll(){
        return Vendor_Payouts::all();
    }

    public function fetchAllPay($shid){
        $amount =  Vendor_Payouts::where('shid', $shid)->where('status', 'processed')->sum('total_amount');
        return $amount;
    }


    public function fetchPayouts($pid){
        // Generated @ codebeautify.org
        //echo($pid);
        $url ="https://api.razorpay.com/v1/payouts/$pid";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_USERPWD, 'rzp_live_nXaG0Q7sHwmmVR' . ':' . '5a24KpedwnoPdvKCBObzEsBA');

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;

    }
    function payout(Request $request){
        // Generated @ codebeautify.org
        //echo($request->mobno);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payouts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"account_number\": \"2323230014428679\",\n    \"amount\": $request->amount,\n    \"currency\": \"INR\",\n    \"mode\": \"NEFT\",\n    \"purpose\": \"payout\",\n   \"fund_account\": {\n        \"account_type\": \"bank_account\",\n        \"bank_account\": {\n            \"name\": \"$request->name\",\n            \"ifsc\": \"$request->ifsc\",\n            \"account_number\": \"$request->accno\"\n        },\n        \"contact\": {\n            \"name\": \"$request->name\",\n            \"email\": \"\",\n            \"contact\": \"$request->mobno\",\n            \"type\": \"vendor\",\n            \"reference_id\": \"Acme Contact ID 12345\",\n            \"notes\": {\n                \"notes_key_1\": \"\",\n                \"notes_key_2\": \"\"\n            }\n        }\n    },\n    \"queue_if_low_balance\": false,\n    \"reference_id\": \"\",\n    \"narration\": \"Payment by LaunderUp\",\n    \"notes\": {\n        \"notes_key_1\": \"\",\n        \"notes_key_2\": \"\"\n    }\n}");
        curl_setopt($ch, CURLOPT_USERPWD, 'rzp_live_nXaG0Q7sHwmmVR' . ':' . '5a24KpedwnoPdvKCBObzEsBA');

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;

    }
}
