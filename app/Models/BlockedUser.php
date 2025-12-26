<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedUser extends Model
{
    protected $fillable = ['block_by', 'blocked_user_id'];

    public function blocker()
    {
        return $this->belongsTo(User::class, 'block_by');
    }

    public function blockedUser()
    {
        return $this->belongsTo(User::class, 'blocked_user_id');
    }
}
