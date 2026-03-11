<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    protected $fillable = [
        'product_category_id',
        'name',
        'slug',
        'description',
        'image'
    ];


    public function product()
    {
        return $this->hasMany(Product::class);
    }
    public function category()
    {
        return $this->belongsTo(ProductCategory::class , 'product_category_id');
    }
}