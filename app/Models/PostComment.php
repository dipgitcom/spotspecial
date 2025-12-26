<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $table = 'post_comments';

    protected $fillable = [
        'comment_time',
        'comment',
        'like',
        'dislike',
        'post_id',
        'user_id',
        'parent_comment_id',
    ];

    public function post()
    {
        return $this->belongsTo(UserPost::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parentComment()
    {
        return $this->belongsTo(PostComment::class, 'parent_comment_id');
    }

    public function childComments()
    {
        return $this->hasMany(PostComment::class, 'parent_comment_id');
    }
}
