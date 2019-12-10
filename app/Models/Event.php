<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // public $timestamps = false;
    // protected $table = 'estates';
    protected $fillable = ['title', 'description', 'date_occure','lat','lng','repetition','remind_before'];

}
