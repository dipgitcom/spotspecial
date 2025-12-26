<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
   protected $fillable = [
        'title',
        'email',
        'logo',
        'favicon',
        'copyright',
    ];
}
