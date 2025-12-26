<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class FooterSetting extends Model {
    protected $fillable = ['copyright', 'left_link', 'right_links'];
    protected $casts = [
        'right_links' => 'array',
    ];
}
