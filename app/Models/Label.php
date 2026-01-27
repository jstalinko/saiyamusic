<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = ['type', 'name', 'slug', 'description', 'taxonomy', 'parent_id', 'label_order'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_label', 'label_id', 'post_id');
    }

    public function meta()
    {
        return $this->hasMany(Labelmeta::class, 'label_id');
    }
    public static function getCategoryOnly()
    {
        return self::where('taxonomy', 'category')
            ->withCount(['posts as post_count']) // hitung jumlah post
            ->orderBy('name', 'asc')
            ->get([
                'id',
                'name',
                'slug'
            ]);
    }
    public static function getTagsOnly()
    {
        return self::where('taxonomy', 'tag')
            ->withCount(['posts as post_count']) // hitung jumlah post
            ->orderBy('name', 'asc')
            ->get([
                'id',
                'name',
                'slug'
            ]);
    }
}
