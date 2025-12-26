<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\WhyUsPanel;

class WhyUsPanelSeeder extends Seeder
{
    public function run()
    {
        WhyUsPanel::truncate();
        WhyUsPanel::create([
            'title' => 'Spots only. No compromises.',
            'description' => 'We specialize 100% in built-in LED spots — it provides a faster, nicer and safer result.',
            'order' => 1,
        ]);
        WhyUsPanel::create([
            'title' => 'Kbh focus = short wait',
            'description' => 'We cover the entire Greater Copenhagen from Valby to Østerbro. Typical time from ordering for mounting: 3–7 business days.',
            'order' => 2,
        ]);
        WhyUsPanel::create([
            'title' => 'Premium products',
            'description' => 'We only use high-CRI LED, flicker-free drivers and metal rings in white, black or brushed aluminum.',
            'order' => 3,
        ]);
    }
}
