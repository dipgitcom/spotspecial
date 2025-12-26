<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;
use Illuminate\Support\Facades\Log;
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('notification-channel{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat-conversation.{conversationId}', function ($user, $conversationId) {
    return $user ? Chat::where('conversation_id', $conversationId)
      ->where(function ($query) use ($user) {
        $query->where('sender_id', $user->id)
              ->orWhere('receiver_id', $user->id);
      })->exists() : false;
});


Broadcast::channel('shop.{shopId}', function ($user, $shopId) {

    return (int) $user->id === (int) $shopId && $user->hasRole('shop');
});

Broadcast::channel('user.{id}', function ($user, $id) {

    return (int) $user->id === (int) $id;
});
