<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FCMService
{ 
    public static function send($token, $notification)
    {
        $apiKey = "AAAAB1br0Ds:APA91bFlWCzZ3-DBqso589y1QpkMDxu4XzbMwFnYhiunNose05Cx7ziIa-u9aIG54FoAyJDhEZZI5iP6hF-YD3a56iS5LoDhkm2GYivezLSHAgrohMAxo21bjWVFvaIdLEhO5b2DiJnP";
        
        Http::acceptJson()->withToken($apiKey)->post(
            'https://fcm.googleapis.com/fcm/send',
            [
                'to' => $token,
                'notification' => $notification,
            ]
        );
    }
}