<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded=[];

    //hide password from display
    protected $hidden =['password'];

    public function role(){
        //one to many relation role
        return $this->belongsTo(Role::class);
    }

    public function hasAccess($access){
        // get permission has access view pluck them by name check access is belong them
        // dd($access);
        return $this ->role->permissions->pluck('name')->contains($access);
    }
}
