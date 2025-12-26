<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\GallerySection;

class GallerySeeder extends Seeder
{
    public function run()
    {
        GallerySection::truncate();
        GallerySection::create([
            'title' => 'Gallery',
            'subtitle' => 'Excerpt from setups in apartments and houses in Copenhagen.',
        ]);

        Gallery::truncate();
        $data = [
            ['caption' => 'Kitchenroom • Østerbro'],
            ['caption' => 'Entrance • Amager'],
            ['caption' => 'Bad • Frederiksberg'],
            ['caption' => 'Living room • Valby'],
            ['caption' => 'Gang • Nørrebro'],
            ['caption' => 'Altan • Sydhavn'],
        ];
        foreach($data as $k => $item) {
            Gallery::create([
                'caption' => $item['caption'],
                'image' => '', // Add image seed path if you want
                'order' => $k+1
            ]);
        }
    }
}
