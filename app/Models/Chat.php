<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    // public $timestamps = false;
    // protected $table = 'estates';
    protected $fillable = ['text','seen','created_at','updated_at'];

    public function medias(){
        return $this->hasMany('App\Models\Media', 'item_id');
    }

    public function chatType(){
        return $this->belongsTo('App\Models\ChatType');
    }

    public function fromUser(){
        return $this->belongsTo('App\User','from_user_id');
    }

    public function toUser(){
        return $this->belongsTo('App\User','to_user_id');
    }
}
