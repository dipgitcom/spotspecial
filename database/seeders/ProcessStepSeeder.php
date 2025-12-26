<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\ProcessStep;

class ProcessStepSeeder extends Seeder
{
    public function run()
    {
        ProcessStep::truncate();
        ProcessStep::create([
            'title' => '1. Rådgivning',
            'description' => 'Vi afklarer behov, lysniveau og zoner — evt. videobesøg om aftenen.',
            'step_number' => 1
        ]);
        ProcessStep::create([
            'title' => '2. Fast pris',
            'description' => 'Du får en skriftlig, fast pris med det samme. Ingen overraskelser.',
            'step_number' => 2
        ]);
        ProcessStep::create([
            'title' => '3. Montering',
            'description' => 'Smuk montering med minimal støv — vi dækker af og støvsuger.',
            'step_number' => 3
        ]);
        ProcessStep::create([
            'title' => '4. Gennemgang',
            'description' => 'Vi tester og gennemgår lys-zoner og dæmpning. 3 års garanti.',
            'step_number' => 4
        ]);
    }
}

