<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // SocialSeeder::class,
            // OrderSeeder::class
            ReportUserSeeder::class,
            UserPostsDemoSeeder::class,
            FeedbackSeeder::class,
            UserNotificationSettingSeeder::class,
            HeroSectionSeeder::class,
            ServicePackageSeeder::class,
            WhyUsPanelSeeder::class,
            ProcessStepSeeder::class,
            GallerySeeder::class
        ]);
        // $this->call(BannerSeeder::class);
    }
}
