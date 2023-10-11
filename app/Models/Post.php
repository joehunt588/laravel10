<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    //change model table locations
    protected $table = 'posts';
    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    public function userNameGroup(){
        return $this->belongsTo(User::class,'user_id');
    }
}
