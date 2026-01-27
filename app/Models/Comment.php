<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
     protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
        'author_name',
        'author_email',
        'author_ip',
        'status'
    ];

    /** Belongs to Post */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /** Belongs to User */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Parent */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /** Children */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /** Readable attribute (author name) */
    public function getAuthorAttribute()
    {
        return $this->user->name ?? $this->author_name ?? 'Guest';
    }

    public function getPostTitleAttribute()
    {
        return $this->post->title;
    }
}
