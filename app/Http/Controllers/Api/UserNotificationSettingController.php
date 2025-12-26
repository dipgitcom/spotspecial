<?php

// app/Http/Controllers/Api/UserNotificationSettingController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserNotificationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationSettingController extends Controller
{
    public function index()
    {
        $setting = UserNotificationSetting::firstOrCreate(
            ['user_id' => Auth::id()],
            $this->defaultSettings()
        );

        return response()->json($setting);
    }

    public function update(Request $request)
    {
        $setting = UserNotificationSetting::firstOrCreate(['user_id' => Auth::id()]);

        $data = $request->only([
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
        ]);

        $filtered = [];
        foreach ($data as $key => $value) {
            $filtered[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        $setting->update($filtered);

        return response()->json(['status' => true, 'message' => 'Settings updated.']);
    }

    protected function defaultSettings()
    {
        return [
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
        ];
    }
}
