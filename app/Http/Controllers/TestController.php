<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OneSignal;

class TestController extends Controller
{




    public function test(){

        // $data = ['soemthing' => 'nothing'];

        $userId = 'example@domain.com';
        OneSignal::sendNotificationUsingTags(
            "Some Message",
            array(["field"=>"tag","key" => "userId", "relation" => "=", "value" => "email@gmail.com"]),
            $url = null,
            $data = ['my_name' =>'is'],
            $buttons = null,
            $schedule = null
        );
        
    }

}



