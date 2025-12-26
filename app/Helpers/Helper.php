<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Helper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function spaces_to_underscores($string)
    {
        return Str::slug($string, '_');
    }

    public static function underscores_to_spaces($string)
    {
        return str_replace('_', ' ', $string);
    }


}
