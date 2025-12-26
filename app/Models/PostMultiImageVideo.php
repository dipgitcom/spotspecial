<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostMultiImageVideo extends Model
{
    use HasFactory;

    protected $table = 'post_multi_image_video';

    protected $fillable = ['image_url', 'video_url', 'media_type', 'post_id'];

    public function post()
    {
        return $this->belongsTo(UserPost::class, 'post_id');
    }
}
