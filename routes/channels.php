<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chats.{roomId}', function (User $user, int $roomId) {
    return $user->rooms()
        ->where('rooms.id', $roomId)
        ->exists();
});
