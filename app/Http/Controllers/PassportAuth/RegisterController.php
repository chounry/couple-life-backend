<?php

namespace App\Http\Controllers\PassportAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OneSignal;
use Validator;
use User;

// model
use App\Models\Login;

class RegisterController extends Controller
{
    //
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

    }


    function createUniqueNumberForVerifyWithPartner($length, $email, $passowrd){
        /*
            - create random number for verifying with partner 
            - insert a new row to logins table with email, passwrod and verify number
        */

        $randomNumber = mt_rand(000000, 999999).'';
        $login = Login::where('verify_number', $randomNumber)->get()->first();

        while($login != null){
            $randomNumber = mt_rand(000000, 999999).'';
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
