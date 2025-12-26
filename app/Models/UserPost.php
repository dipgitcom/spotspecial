<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PostMultiImageVideo;
use App\Models\Tag;
use App\Models\User;
use App\Models\PostComment;
use App\Models\PostLike;



class UserPost extends Model
{
    use HasFactory;

    protected $table = 'user_posts';

    protected $fillable = [
        'post_type',
        'title',
        'post_latitude',
        'post_longitude',
        'incident_radius',
        'status',
        'user_id',
        'tag_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function media()
    {
        return $this->hasMany(PostMultiImageVideo::class, 'post_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }
}
