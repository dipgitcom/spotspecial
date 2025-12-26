<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class ContactField extends Model
{
    protected $fillable = [
        'key',
        'label',
        'placeholder',
        'button_text',
        'type',
        'required',
        'order',
    ];

    public function getKeyAttribute($value): string
    {
        return Helper::spaces_to_underscores($value);
    }

    public function getLabelTextAttribute(): string
    {
        return $this->label;
    }

    public function getPlaceholderTextAttribute(): string
    {
        return $this->placeholder;
    }

    public function getLabelAttribute($value): string
    {
        return Helper::spaces_to_underscores($value);
    }

    public function getPlaceholderAttribute($value): string
    {
        return Helper::spaces_to_underscores($value);
    }
}
