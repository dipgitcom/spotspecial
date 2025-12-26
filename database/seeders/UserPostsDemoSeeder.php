<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserPost;
use App\Models\Tag;
use App\Models\PostMultiImageVideo;
use App\Models\PostComment;

class UserPostsDemoSeeder extends Seeder
{
    public function run()
    {
        $user = User::first() ?? User::factory()->create(['name' => 'Dipraj Dhar']);

        $tag = Tag::create(['tag_name' => 'TestTag']);

        $post = UserPost::create([
            'post_type' => 'incident_post',
            'title' => 'Baby lost in the crowd',
            'post_latitude' => 23.777176,
            'post_longitude' => 90.399452,
            'incident_radius' => 5.0,
            'status' => 'published',
            'user_id' => $user->id,
            'tag_id' => $tag->id,
        ]);

        // Attach image
        PostMultiImageVideo::create([
            'image_url' => 'uploads/baby.webp',
            'media_type' => 'image',
            'post_id' => $post->id,
        ]);

        // Attach video
        PostMultiImageVideo::create([
            'video_url' => 'uploads/demovideo.',
            'media_type' => 'video',
            'post_id' => $post->id,
        ]);

        // Add comments
        PostComment::create([
            'comment_time' => now(),
            'comment' => 'where is the baby!',
            'like' => 2,
            'dislike' => 0,
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
        PostComment::create([
            'comment_time' => now(),
            'comment' => 'OMG Baby was missed!',
            'like' => 1,
            'dislike' => 1,
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
    }
}
