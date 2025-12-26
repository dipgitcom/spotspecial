<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('socials')->insert([
            [
                'name'       => 'Instagram',
                'url'        => 'https://instagram.com/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Facebook',
                'url'        => 'https://facebook.com/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Twitter',
                'url'        => 'https://twitter.com/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'TikTok',
                'url'        => 'https://tiktok.com/',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
