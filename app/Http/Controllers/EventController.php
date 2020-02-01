<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Event;
use App\Models\EventType;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EventController extends Controller {
    
    public function Create (Request $request)
    {
        # code...
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'date_occure' => 'required'
        ]);
        
        if($validator->fails()){
            $error['errors'] = $validator->errors();
            return response()->json($error, 400);
        } else {


            $new_event = new Event;

            $new_event->title = $request->title;
            $new_event->date_occure = $request->date_occure;
            $new_event->repetition = $request->repetition;
            $new_event->remind_before = $request->remind_before;
            $new_event->description = $request->description;
            $new_event->lat = $request->lat;
            $new_event->lng = $request->lng;
            $new_event->day_amount = $request->day_amount;

            $new_event->user_id = $request->user_id;
            $new_event->event_type_id = $request->event_type_id;

            $new_event->save();

            if ($request->has('images')) {
                # code...
                foreach ($request->file('images') as $key) {
                    # code...
                    $fileName = Media::uploadFile('/Event_images',$key,$request->tmp_file);
                    $image = new Media;
                    $gallery->path = 'uploads/Event_images/'.'/'.$fileName;
                    $gallery->save();
                    $control++;
                }
            }

            return response()->json(true, 200);
        } 
    }
    public function Update (Request $request)
    {
        # code...

    }
}