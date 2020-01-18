<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Event;
use App\Models\EventType;

class EventController extends Controller {
    
    public function Create (Request $request)
    {
        # code...
        $datas = [
            'a', 'b'
        ];
        $data = [
            'code' => 200,
            'm' => "ssd",
            'data' => $datas
        ];
        return response()->json($data,400);
    }
}