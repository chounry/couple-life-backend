<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // public $timestamps = false;
    // protected $table = 'estates';
    protected $fillable = ['title', 'description', 'date_occure','lat','lng','repetition','remind_before','day_amount','created_at','updated_at'];

    public function medias(){
        return $this->hasMany('App\Models\Media','item_id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function eventType(){
        return $this->belongsTo('App\EventType');
    }

}
