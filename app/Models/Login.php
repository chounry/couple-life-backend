<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $fillable = ['email','password','verify_number'];

    public function user(){
        return $this->morphOne('App\User', 'login_id');
    }
}
