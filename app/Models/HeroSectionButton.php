<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSectionButton extends Model
{
    protected $fillable = ['hero_section_id', 'text', 'type', 'url'];

    public function heroSection()
    {
        return $this->belongsTo(HeroSection::class);
    }
}
