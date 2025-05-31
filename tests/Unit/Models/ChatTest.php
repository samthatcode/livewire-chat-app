<?php

declare(strict_types=1);

use App\Models\Chat;
use App\Models\Room;
use App\Models\User;

test('to array', function () {
    $chat = Chat::factory()->create()->fresh();
    expect(array_keys($chat->toArray()))->toEqual([
        'id',
        'parent_id',
        'user_id',
        'room_id',
        'message',
        'created_at',
        'updated_at',
        'deleted_at',
    ]);
});

test('relationships', function () {
    $chat = Chat::factory()
        ->for(Chat::factory(), 'parent')
        ->create();

    expect($chat->user)->toBeInstanceOf(User::class);
    expect($chat->room)->toBeInstanceOf(Room::class);
    expect($chat->parent)->toBeInstanceOf(Chat::class);
});
