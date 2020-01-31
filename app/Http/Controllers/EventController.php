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
        
        $data = $request->validate([
            'title' => 'required',
            'date_occure' => 'required'
        ]);
        


        return response()->json($data,200);
    }
}