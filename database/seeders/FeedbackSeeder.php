<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        Feedback::insert([
            ['feedback' => 'Great dashboard, very user-friendly!', 'created_at' => now(), 'updated_at' => now()],
            ['feedback' => 'Please add search functionality to reports.', 'created_at' => now(), 'updated_at' => now()],
            ['feedback' => 'Dark mode looks awesome!', 'created_at' => now(), 'updated_at' => now()],
            ['feedback' => 'Sometimes page load is slow, please optimize.', 'created_at' => now(), 'updated_at' => now()],
            ['feedback' => 'Love the layout and color scheme.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
