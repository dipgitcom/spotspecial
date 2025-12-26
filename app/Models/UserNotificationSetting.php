<?php

// app/Models/UserNotificationSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    protected $fillable = [
        'user_id',
        'push_notification',
        'sound',
        'vibration',
        'reactions',
        'community_alerts',
        'critical_safety_alerts',
        'proximity_warnings',
        'direct_messages',
        'calls',
        'subscriptions_updates',
        'system_notifications',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
