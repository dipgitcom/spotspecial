<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    protected $fillable = [
        'title',
        'email',
        'logo',
        'favicon',
        'copyright',
        'hotline',
        'address',
    ];

    protected $casts = [
        'title' => 'string',
        'email' => 'string',
        'logo' => 'string',
        'favicon' => 'string',
        'copyright' => 'string',
        'hotline' => 'string',
        'address' => 'string',
    ];
}
