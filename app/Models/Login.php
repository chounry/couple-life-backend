<?php

namespace App\Models;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class Login extends Authenticatable
{

    use HasApiTokens,Notifiable;

    protected $fillable = ['email','password','verify_number'];

    public function user(){
        return $this->morphOne('App\User', 'login_id');
    }
}
