<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    // public $timestamps = false;
    // protected $table = 'estates';
    protected $fillable = ['url','created_at','updated_at'];

    public function mediaType(){
        return $this->belongsTo('App\Model\MediaType');
    }
}
