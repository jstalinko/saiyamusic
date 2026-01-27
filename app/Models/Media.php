<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    
     protected $fillable = ['user_id','filename','path','mime','size'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
