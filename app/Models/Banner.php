<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'subtitle',
        'title',
        'description',
        'url',
        'image'
    ];
}
