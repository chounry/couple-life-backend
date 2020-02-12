<?php

namespace App\Http\Controllers\PassportAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;

use OneSignal;
use Validator;
use User;

// model
use App\Models\Login;

class RegisterController extends Controller
{
    /* 
            ONE SIGNAL JSON STRUCTURE
            
            type : [ 'verify', 'chat' ]
            {
                'data' : {},
                'type' : 'verify',
                'msg' : '' 
            }
    */

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'min:6',
        ]);

        $response = []; // what will be response
        $data = []; 

        if($validator->fails()){
            $response['errors'] = $validator->errors().'';
            return response()->json($response, 200);
        }

        $users = Login::where("email", $request->email)->get();
        if(count($users) < 1){
            $response['errors'] = "{'email' : ''}";
            return response()->json($response, 200);
        }


        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user();
            $token = $user->createToken('Myapp')->accessToken;
            return [
                'user_id'=>Auth::id(),
                'verify_number' => Auth::user()->verify_number,
                'token'=>$token
            ];
        } 
        else {
            return response()->json(['errors' => "{'password' : 'Wrong password'}"], 200);
        } 
    }

    public function signUp(Request $request){
        // checkEmailExist();
        // checkPassword();
        $validator = Validator::make($request->all(), [
            'email' => 'unique:logins',
            'password' => 'min:6',
        ]);

        $response = []; // what will be response
        $data = []; 

        if($validator->fails()){
            $response['errors'] = $validator->errors().'';
            return response()->json($response, 200);
        }

        // verifyAccount() : next version

        // createUniqueNumberForVerifyWithPartner($length = 6, $email = null);
        // insertToDatabase($email, $password);

        $verifyNumber = $this->createUniqueNumberForVerifyWithPartner( 6, $request->email, $request->password);
        $response['verify_number'] = $verifyNumber;
        // $response['data'] = $data;
        return response()->json($response, 200);
    }


    public function verifyNumber(Request $request){
        /* 
            - check his/her partner with verify number
            - push notification to his/her partner

        */
        
        $selfLoginId = $request->login_id;
        $partnerVerifyNumber = str_replace(" ","",$request->verify_number);

        $partnerLogin = Login::where('verify_number', $verifyNumber)->get()->first();
        $selfLogin = Login::find($selfLoginId);

        if($partnerLogin == null || $selfLogin == null){
            return response()->json(['msg' => 'No user found']);
        }

        if($partnerLogin->partner_id != null){
            return response()->json(['msg'=> 'Your partner already has another partner']);
        }

        if($selfLogin->partner_id != null){
            return response()->json(['msg'=> 'You already has a partner']);
        }

        // this data will send back to the user
        $dataSelf = [
            'type' => 'verify',
            'data' => [
                'partner_id' => $partnerLogin->id
            ],
            'msg' => 'You have been connected'
        ];

        // this data will send to his/her partner with the id of the user that enter the verify number on the device
        $dataPartner = [
            'type' => 'verify',
            'data' => [
                'partner_id' => $selfLogin->id
            ],
            'msg' => 'You have been connected'
        ];

        $this->sendViaOneSignal($selfLogin->verifyNumber, $dataSelf = null, $msg = null);
        $this->sendViaOneSignal($partnerLogin->verifyNumber, $dataPartner = null, $msg = null);

        return response()->json(['msg'=>'success']);
    }

    public function confirm(Request $request){

        $login = Login::find($request->id);
        if($login == null){
            return \response()->json(['msg' => "User doesn't exist"]);
        }

        $login->partner_id = $partnerLogin->id;
        /* 
            set the verify number to null in case
            user delete the app after they have verify the account,
            we can check : 
                if the verifyNumber is null after they have login again at any other time so that
                we can know that they have pass the verify partner account step.
                Then we can set them to the setup info step directly

         */
        $login->verifyNumber = null;
        $login->save();

        return \response()->json('success', 200);

    }

    function sendViaOneSignal($tag, $dataToSend = null, $msg = null){
    
        OneSignal::sendNotificationUsingTags(
            $msg,
            array(["field"=>"tag","key" => "verify_number", "relation" => "=", "value" => $tag]),
            $url = null,
            $data = $dataToSend,
            $buttons = null,
            $schedule = null
        );
    }


    function createUniqueNumberForVerifyWithPartner($length, $email, $passowrd){
        /*
            - create random number for verifying with partner 
            - insert a new row to logins table with email, passwrod and verify number
        */

        $random = ''.mt_rand(000000, 999999);
        $randomNumber = $random;

        $login = Login::where('verify_number', $randomNumber)->get()->first();

        while($login != null){

            $random = ''.mt_rand(000000, 999999);
            $randomNumber = $random;

            $login = Login::where('verify_number', $randomNumber)->get()->first();
        }

        $newLogin = Login::create([
            'email' => $email,
            'password' => bcrypt($passowrd),
            'verify_number' => $randomNumber
        ]);

        return $randomNumber;
    }
}
