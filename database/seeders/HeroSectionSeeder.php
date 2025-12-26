<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSection;

class HeroSectionSeeder extends Seeder
{
    public function run()
    {
        HeroSection::updateOrCreate(
            ['section_key' => 'main'],
            [
                'badge' => 'Elektriker i København • LED-spots',
                'headline' => "Premium installation af LED-spots\ni hjem og erhverv — kun i København",
                'description' => "Vi er autoriserede elektrikere, der udelukkende monterer indbyggede spots i lofter og nichebelysning. Pænt arbejde, skarpe linjer og produkter i topklasse.",
                'features' => json_encode([
                    ['icon' => 'tick', 'text' => 'Fast pris på pakkeløsninger'],
                    ['icon' => 'clock', 'text' => 'Typisk montering på én dag'],
                    ['icon' => 'shield', 'text' => '3 års håndværkergaranti']
                ]),
                'buttons' => json_encode([
                    ['text' => 'Få tilbud', 'type' => 'primary', 'url' => '#kontakt'],
                    ['text' => 'Se priser', 'type' => 'ghost', 'url' => '#services']
                ]),
                'rating' => '⭐ 4.9/5 blandt københavnske kunder',
                'panel' => json_encode([
                    'kicker' => 'Diskret, varm belysning med høj CRI',
                    'shots' => [
                        [
                            'caption' => 'Indbygget i gips',
                            'image' => '/images/indbygget-i-gips.jpg'
                        ],
                        [
                            'caption' => 'Dæmpbare zoner',
                            'image' => '/images/daempbare-zoner.jpg'
                        ],
                        [
                            'caption' => 'IP-klassede spots',
                            'image' => '/images/ip-klassede-spots.jpg'
                        ],
                        [
                            'caption' => 'Alu & sort finish',
                            'image' => '/images/alu-sort-finish.jpg'
                        ],
                    ]
                ]),
            ]
        );
    }
}
