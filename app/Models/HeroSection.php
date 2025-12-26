<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $fillable = [
        'section_key', 'badge', 'headline', 'description', 'rating', 'panel_kicker', 'features', 'buttons', 'panel'
    ];

    protected $casts = [
    // 'features' => 'array',
    'features' => 'string',
    'buttons'  => 'array',
    'panel'    => 'array',
];


    public function features()
    {
        return $this->hasMany(HeroSectionFeature::class);
    }

    public function buttons()
    {
        return $this->hasMany(HeroSectionButton::class);
    }

    public function panelShots()
    {
        return $this->hasMany(HeroSectionPanelShot::class);
    }

    public function getFeaturesAttribute($value)
    {
        return json_decode($value ?? '[]', true);
    }

    // public function setFeaturesAttribute($value)
    // {
    //     // $this->attributes['features'] = json_encode($value);
    //     // $this->attributes['features'] = json_decode(json_encode($value));
    // }

    // Similarly for buttons and panel...

}
