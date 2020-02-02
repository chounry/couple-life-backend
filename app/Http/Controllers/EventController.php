<?php

namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Event;
use App\Models\Media;
use App\Models\EventType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
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

            if($request->hasFile('imgs')) {
                foreach($request->file('imgs') as $file) {
                    $fileNameWithExt = $file->getClientOriginalName();
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                    $path = $file->storeAs('public/event_imgs', $fileNameToStore);
                    
                    // save image path 
                    $img = new Media;
                    $img->url = "storage/event_imgs/" . $fileNameToStore;
                    $img->is_event = true;
                    $img->item_id = $new_event->id;
                    $img->media_type_id = 2;
                    $img->save();
                }   
            }
            return response()->json(true, 200);
        } 
    }
    public function Update (Request $request)
    {
        # code...
        $update_event = Event::find($request->id);

        if ($update_event != null) {
            $update_event->title = $request->title;
            $update_event->date_occure = $request->date_occure;
            $update_event->repetition = $request->repetition;
            $update_event->remind_before = $request->remind_before;
            $update_event->description = $request->description;
            $update_event->lat = $request->lat;
            $update_event->lng = $request->lng;
            $update_event->day_amount = $request->day_amount;
    
            $update_event->user_id = $request->user_id;
            $update_event->event_type_id = $request->event_type_id;
    
            $update_event->save();
    
            foreach ($request->delete_img as $key) {
                # code...
                $img = Media::find($key);
                $img->delete();
            }
    
            if($request->hasFile('new_imgs')) {
                foreach($request->file('new_imgs') as $file) {
                    $fileNameWithExt = $file->getClientOriginalName();
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                    $path = $file->storeAs('public/event_imgs', $fileNameToStore);
                    
                    // save image path 
                    $img = new Media;
                    $img->url = "storage/event_imgs/" . $fileNameToStore;
                    $img->is_event = true;
                    $img->item_id = $update_event->id;
                    $img->media_type_id = 2;
                    $img->save();
                }   
            }
            return response()->json(true, 200);
        } else {
            return response()->json(false, 400);
        }

        
    }
    public function Delete(Request $request)
    {
        # code...
        $delete_event = Event::find($request->id);
        if ($delete_event != null) {
            $delete_event->delete();
            return response()->json(true, 200);
        } else {
            return response()->json(false, 400);
        }
    }
    public function Read (Request $request)
    {
        # code...
        $all_event = Event::where('user_id', $request->user_id)->get();
        return response()->json($all_event, 200);
    }
}