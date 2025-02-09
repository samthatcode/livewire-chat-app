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
