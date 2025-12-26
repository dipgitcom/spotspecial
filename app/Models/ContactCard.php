<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ContactCard extends Model {
    protected $fillable = ['title', 'phone', 'email', 'address', 'hours', 'pill_text', 'disclaimer'];
}
