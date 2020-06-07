<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin(){
        if(auth()->user()->admin == 1)
            return true;
        return false;
    }
    public function isDoctor(){
        if(auth()->user()->admin == 2)
            return true;
        return false;
    }
    public function isStudentAffair(){
        if(auth()->user()->admin == 3)
            return true;
        return false;
    }
    public function isStudent(){
        if(auth()->user()->admin == 4)
            return true;
        return false;
    }
    public function staff(){
        return $this->hasOne('App\Staff','user_id');
    }
    public function student(){
        return $this->hasOne('App\Student','user_id');
    }
}
