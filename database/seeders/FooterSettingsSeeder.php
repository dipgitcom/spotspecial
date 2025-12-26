<?php

namespace Database\Seeders;

use App\Models\FooterSetting;
use Illuminate\Database\Seeder;

class FooterSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FooterSetting::truncate();
        FooterSetting::create([
            'copyright' => '© 2025 SpotSpecialisten.dk • LED-spots i København',
            'left_link' => '#', // add any left link URL if needed
            'right_links' => json_encode([
                ['label' => 'GDPR', 'url' => '#'],
                ['label' => 'Handelsbetingelser', 'url' => '#'],
                ['label' => 'Cookies', 'url' => '#'],
            ]),
        ]);
    }
}
