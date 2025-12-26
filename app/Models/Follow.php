<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    // Table name can be set explicitly if needed
    // protected $table = 'follows';

    // Allow mass assignment for columns
    protected $fillable = [
        'follower_id',
        'following_id',
        'status',
    ];

    // Relationship: the user who follows
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    // Relationship: the user being followed
    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
