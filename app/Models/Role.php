<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    //create timestamp needed to prevent collumn not found
    public $timestamps = false;

    public function users(){
        //one to many relation user
        return $this->hasMany(User::class);
    }
}
