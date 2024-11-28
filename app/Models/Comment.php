<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = [
        'post_id',
        'content',
        'user_id',
    ];
    public function post(){
        return $this->hasOne(Post::class,'post_id','id');
    }
    public function user(){
        return $this->hasOne(Comment::class,'post_id','id');
    }
}
