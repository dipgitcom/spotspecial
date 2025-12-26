<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    protected $fillable = [
        'title', 'price', 'subtitle', 'features', 'button_text', 'button_url', 'type'
    ];
    protected $casts = [
        'features' => 'array',
    ];
}
