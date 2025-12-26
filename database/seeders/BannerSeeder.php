<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner; // Make sure this matches your model path
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            Banner::create([
                'banner_title'    => $faker->sentence(3),
                'banner_subtitle' => $faker->optional()->sentence(5),
                'button_text'     => 'Button Text',
                'button_url'      => $faker->url,
                'banner_image'    => 'default.jpg',
                'status'          => $faker->randomElement(['1', '0']),
            ]);
        }
    }
}
