<?php

namespace Database\Seeders;

use App\Models\FooterLink;
use Illuminate\Database\Seeder;

class FooterLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FooterLink::truncate();

        FooterLink::insert([
            ['label' => 'GDPR', 'url' => '#', 'order' => 1],
            ['label' => 'Handelsbetingelser', 'url' => '#', 'order' => 2],
            ['label' => 'Cookies', 'url' => '#', 'order' => 3],
        ]);
    }
}
