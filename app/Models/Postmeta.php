<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postmeta extends Model
{
    public $timestamps = false;

    protected $fillable = ['post_id','meta_key','meta_value'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
