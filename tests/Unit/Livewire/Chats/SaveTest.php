<?php

declare(strict_types=1);
use App\Livewire\Chats\Save;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Livewire;

it('can render the create chat component', function () {
    Livewire::actingAs(User::factory()->create())
        ->test(Save::class, ['roomId' => Room::factory()->create()->getKey()])
        ->assertStatus(200)
        ->assertViewIs('livewire.chats.create');
});

it('validates the message field', function () {
    Livewire::actingAs(User::factory()->create())
        ->test(Save::class, ['roomId' => Room::factory()->create()->getKey()])
        ->set('message', '')
        ->call('save')
        ->assertHasErrors(['message']);
});

it('checks for exception when roomId is invalid', function () {
    $this->actingAs(User::factory()->create());

    $this->expectException(ModelNotFoundException::class);

    Livewire::test(Save::class, ['roomId' => 123])
        ->set('message', 'test message')
        ->call('save')
        ->assertNotFound();
});

it('can create a chat', function () {

    $john = User::factory()->create(['name' => 'John Doe']);

    // other user
    $jane = User::factory()->create(['name' => 'Jane Doe']);

    $this->actingAs($john);

    $room = Room::factory()->create(['user_id' => $jane->id]);

    $room->users()->attach($john->id);

    $component = Livewire::test(Save::class, ['roomId' => $room->id])
        ->set('message', 'message from John')
        ->call('save')
        ->assertDispatched('chat:created');

    expect($component->invade()->createdChat)->not->toBeNull();

    $this->assertDatabaseHas('chats', ['message' => 'message from John']);
});

it('can not create a chat as an invalid user/member ', function () {

    $john = User::factory()->create(['name' => 'John Doe']);

    // other user
    $jane = User::factory()->create(['name' => 'Jane Doe']);

    $this->actingAs($john);

    $room = Room::factory()->create(['user_id' => $jane->id]);

    Livewire::test(Save::class, ['roomId' => $room->id])
        ->set('message', 'message from John')
        ->call('save')
        ->assertStatus(403);

});

it('can edit a chat', function () {

    $john = User::factory()->create(['name' => 'John Doe']);

    // other user
    $jane = User::factory()->create(['name' => 'Jane Doe']);

    $this->actingAs($john);

    $room = Room::factory()->create(['user_id' => $jane->id]);

    $room->users()->attach([$john->id, $jane->id]);

    Livewire::test(Save::class, ['roomId' => $room->id])
        ->set('message', 'message from John')
        ->call('save')
        ->assertDispatched('chat:created');

    Livewire::test(Save::class, ['roomId' => $room->id])
        ->set('message', 'edited message from John')
        ->dispatch('chat-editing', chatId: 1, message: 'edited message from John')
        ->call('save')
        ->assertDispatched('chat:updated.1');

    $this->assertDatabaseHas('chats', ['message' => 'edited message from John']);
});

it('can not edit a chat as an invalid user/member ', function () {

    $john = User::factory()->create(['name' => 'John Doe']);

    // other user
    $jane = User::factory()->create(['name' => 'Jane Doe']);

    $this->actingAs($john);

    $room = Room::factory()->create(['user_id' => $jane->id]);

    $room->users()->attach([$john->id, $jane->id]);

    Livewire::test(Save::class, ['roomId' => $room->id])
        ->set('message', 'message from John')
        ->call('save')
        ->assertDispatched('chat:created');

    Livewire::actingAs($jane)
        ->test(Save::class, ['roomId' => $room->id])
        ->set('message', 'edited message from John')
        ->dispatch('chat-editing', chatId: 1, message: 'edited message from John')
        ->call('save')
        ->assertStatus(403);
});

it('sets chatId and message for chat-editing event', function () {
    $john = User::factory()->create(['name' => 'John Doe']);

    $this->actingAs($john);

    $room = Room::factory()->create(['user_id' => $john->id]);

    $room->users()->attach([$john->id]);

    Livewire::test(Save::class, ['roomId' => $room->id])
        ->set('message', 'message from John')
        ->call('save')
        ->assertDispatched('chat:created');

    Livewire::test(Save::class, ['roomId' => $room->id])
        ->dispatch('chat-editing', chatId: 1, message: 'edited message from John')
        ->assertSet('chatId', 1)
        ->assertSet('message', 'edited message from John');
});

it('can listen to echo events', function (): void {
    $user = User::factory()->create();
    $room = Room::factory()->create();
    $chat = $room->chats()->create([
        'user_id' => $user->id,
        'message' => 'test message',
    ]);

    $component = Livewire::actingAs($user)
        ->test(Save::class, ['roomId' => $room->id])
        ->call('chatCreated', [
            'roomId' => $room->id,
            'chatId' => $chat->id,
        ])
        ->assertDispatched('chat:created');
    expect($component->invade()->createdChat)->not->toBeNull();

    $component->call('chatUpdated', [
        'roomId' => 1,
        'chatId' => 1,
    ])
    ->assertDispatched('chat:updated.1');
});

it('can cancel the editing', function (): void {
    Livewire::actingAs(User::factory()->create())
        ->test(Save::class, [
            'roomId' => Room::factory()->create()->getKey(),
            'chatId' => 1,
            'message' => 'test message',
        ])
        ->assertSet('chatId', 1)
        ->assertSet('message', 'test message')
        ->call('cancel')
        ->assertSet('chatId', null)
        ->assertSet('message', '');
});
