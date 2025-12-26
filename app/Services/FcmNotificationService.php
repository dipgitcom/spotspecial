<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FcmNotificationService
{
    public function sendNotification(string $fcmToken, string $title, string $body, array $data = []): bool
    {
        $serverKey = env('FCM_SERVER_KEY');

        if (!$serverKey) {
            \Log::error('FCM Server Key is not set in .env');
            return false;
        }

        $payload = [
            'to' => $fcmToken,
            'notification' => [
                'title' => $title,
                'body'  => $body,
            ],
            'data' => $data,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $serverKey,
            'Content-Type'  => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', $payload);

        if ($response->successful()) {
            \Log::info('FCM notification sent successfully', ['response' => $response->json()]);
            return true;
        } else {
            \Log::error('FCM notification failed', ['response' => $response->json()]);
            return false;
        }
    }
}
