<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSectionPanelShot extends Model
{
    protected $fillable = ['hero_section_id', 'caption', 'image'];

    public function heroSection()
    {
        return $this->belongsTo(HeroSection::class);
    }
}
