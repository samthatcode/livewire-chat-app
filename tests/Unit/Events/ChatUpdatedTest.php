<?php

declare(strict_types=1);

use App\Events\ChatUpdated;
use App\Models\Chat;
use Illuminate\Broadcasting\PrivateChannel;

it('sets the data', function () {
    $chat = Chat::factory()->create();
    $event = new ChatUpdated($chat->id, $chat->room_id);

    expect($event->chatId)->toEqual($chat->id);
    expect($event->roomId)->toEqual($chat->room_id);
    expect($event->broadcastOn())->toEqual([
        new PrivateChannel('chats.'.$chat->room_id),
    ]);
    expect($event->broadcastAs())->toEqual('chat-updated');
});

it('can be dispatched', function () {
    Event::fake();
    $chat = Chat::factory()->create();
    ChatUpdated::dispatch($chat->id, $chat->room_id);
    Event::assertDispatched(ChatUpdated::class, function (ChatUpdated $event) use ($chat) {
        return $event->chatId === $chat->id && $event->roomId === $chat->room_id;
    });
});
