<?php

declare(strict_types=1);

use App\Livewire\Chats\Show;
use App\Models\Chat;
use Livewire\Livewire;

it('can render', function (): void {
    $chat = Chat::factory()->create();

    Livewire::test(Show::class, ['chat' => $chat])
        ->assertSee($chat->message)
        ->assertSee($chat->user->name);
});

it('can edit', function (): void {
    $chat = Chat::factory()->create();

    Livewire::actingAs($chat->user)
        ->test(Show::class, ['chat' => $chat])
        ->call('edit')
        ->assertDispatched('chat-editing',
            chatId: $chat->id,
            message: $chat->message,
        );
});

it('can reply', function (): void {
    $chat = Chat::factory()->create();

    Livewire::actingAs($chat->user)
        ->test(Show::class, ['chat' => $chat])
        ->call('reply')
        ->assertDispatched('chat-replying',
            chatId: $chat->id,
            message: $chat->message,
        );
});
