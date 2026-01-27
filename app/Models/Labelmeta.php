<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Labelmeta extends Model
{
    
     protected $fillable = ['label_id','meta_key','meta_value'];
     public $timestamps = false;
    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id');
    }
}
