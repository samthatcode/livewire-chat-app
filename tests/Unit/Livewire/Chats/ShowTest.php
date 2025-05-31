<?php

declare(strict_types=1);

use App\Events\ChatUpdated;
use App\Livewire\Chats\Show;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

beforeEach(function (): void {
    Event::fake();
});

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

it('can refresh when parent chat is updated', function (): void {
    $parentChat = Chat::factory()->create();
    $chat = Chat::factory()->create([
        'parent_id' => $parentChat->id,
        'message' => 'Original message',
    ]);

    $component = Livewire::actingAs($chat->user)
        ->test(Show::class, ['chat' => $chat]);

    $parentChat->update(['message' => 'Updated message']);

    $component->assertSee('Original message')
        ->dispatch('chat:updated.'.$parentChat->id)
        ->assertSee('Updated message');
});

it('only shows the edit button if the user is the owner of the chat', function (): void {
    $chat = Chat::factory()->create();

    Livewire::actingAs($chat->user)
        ->test(Show::class, ['chat' => $chat])
        ->assertSeeHtml('wire:click="edit"');

    Livewire::actingAs(User::factory()->create())
        ->test(Show::class, ['chat' => $chat])
        ->assertDontSeeHtml('wire:click="edit"');
});

it('can delete', function (): void {
    $chat = Chat::factory()->create();

    Livewire::actingAs($chat->user)
        ->test(Show::class, ['chat' => $chat])
        ->call('delete')
        ->assertDispatched('chat:updated.'.$chat->id);

    expect($chat->fresh()->deleted_at)->not()->toBeNull();

    Event::assertDispatched(ChatUpdated::class, function (ChatUpdated $event) use ($chat): bool {
        return $event->chatId === $chat->id && $event->roomId === $chat->room_id;
    });
});

it('can not delete if the user is not the owner of the chat', function (): void {
    $chat = Chat::factory()->create();

    Livewire::actingAs(User::factory()->create())
        ->test(Show::class, ['chat' => $chat])
        ->call('delete')
        ->assertForbidden();
});

it('only shows the delete button if the user is the owner of the chat', function (): void {
    $chat = Chat::factory()->create();

    Livewire::actingAs($chat->user)
        ->test(Show::class, ['chat' => $chat])
        ->assertSeeHtml('wire:click="delete"');

    Livewire::actingAs(User::factory()->create())
        ->test(Show::class, ['chat' => $chat])
        ->assertDontSeeHtml('wire:click="delete"');
});

it('only shows the delete button if the chat is not deleted', function (): void {
    $chat = Chat::factory()->create();

    Livewire::actingAs($chat->user)
        ->test(Show::class, ['chat' => $chat])
        ->assertSeeHtml('wire:click="delete"');

    $chat->touch('deleted_at');

    Livewire::actingAs($chat->user)
        ->test(Show::class, ['chat' => $chat])
        ->assertDontSeeHtml('wire:click="delete"');
});
