<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSectionFeature extends Model
{
    protected $fillable = ['hero_section_id', 'icon', 'text'];

    public function heroSection()
    {
        return $this->belongsTo(HeroSection::class);
    }
}
