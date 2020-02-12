<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    // public $timestamps = false;
    protected $table = 'medias';
    protected $fillable = ['url','is_event','media_type_id','item_id','created_at','updated_at'];

    public function mediaType(){
        return $this->belongsTo('App\Model\MediaType');
    }
}
