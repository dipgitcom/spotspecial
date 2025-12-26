<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServicePackage;

class ServicePackageSeeder extends Seeder
{
    public function run()
    {
        ServicePackage::updateOrCreate(
            ['type' => 'start'],
            [
                'title' => 'Startpakken • 6 spots',
                'price' => 'DKK 6.995',
                'subtitle' => 'Til entré, lille stue eller køkkenalrum. Inkl. dæmper og hvid ring.',
                'features' => [
                    'Premium 2700K LED (CRI 90+)',
                    'Udsparing og brandsikring',
                    'Gælder gipsloft'
                ],
                'button_text' => 'Book pakken',
                'button_url' => '#kontakt'
            ]
        );

        ServicePackage::updateOrCreate(
            ['type' => 'design'],
            [
                'title' => 'Designpakken • 10 spots',
                'price' => 'DKK 10.995',
                'subtitle' => 'Perfekt til stue/køkken. Vælg sort, alu eller hvid finish.',
                'features' => [
                    'Dæmpbare zoner (2 kredse)',
                    'Flimmerfri driver',
                    'Udskiftelige ringe'
                ],
                'button_text' => 'Vælg designpakken',
                'button_url' => '#kontakt'
            ]
        );

        ServicePackage::updateOrCreate(
            ['type' => 'bath'],
            [
                'title' => 'Bad & udendørs • IP65',
                'price' => 'Fra DKK 1.295 / spot',
                'subtitle' => 'Vandtætte løsninger til bad, altan og kælder i København.',
                'features' => [
                    'IP65/IP44 efter zone',
                    'Korrosionsbestandig finish',
                    'Siliconeforsegling inkl.'
                ],
                'button_text' => 'Få præcis pris',
                'button_url' => '#kontakt'
            ]
        );
    }
}
