<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserPost;
use App\Models\Tag;

class UserPostsTestSeeder extends Seeder
{
    public function run()
    {
        // Create or get a user (for simplicity, use ID 1)
        $user = User::first() ?? User::factory()->create();

        // Create a tag
        $tag = Tag::create(['tag_name' => 'TestTag']);

        // Create a user post
        $post = UserPost::create([
            'post_type' => 'incident_post',
            'title' => 'Seeder Test Post',
            'post_latitude' => 23.777176,
            'post_longitude' => 90.399452,
            'incident_radius' => 5.0,
            'status' => 'published',
            'user_id' => $user->id,
            'tag_id' => $tag->id,
        ]);
    }
}
