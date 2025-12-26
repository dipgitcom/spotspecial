<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserNotificationSetting;

class UserNotificationSettingSeeder extends Seeder
{
    public function run()
    {
        UserNotificationSetting::updateOrCreate(
            ['user_id' => 3],
            [
                'push_notification' => true,
                'sound' => true,
                'vibration' => true,
                'reactions' => true,
                'community_alerts' => true,
                'critical_safety_alerts' => true,
                'proximity_warnings' => true,
                'direct_messages' => true,
                'calls' => true,
                'subscriptions_updates' => true,
                'system_notifications' => true,
            ]
        );
    }
}
