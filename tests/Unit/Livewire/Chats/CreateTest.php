<?php

declare(strict_types=1);
use App\Livewire\Chats\Create;
use App\Models\Room;
use App\Models\User;
use Livewire\Livewire;

it('can render the create chat component', function () {
    Livewire::actingAs(User::factory()->create())
        ->test(Create::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.chats.create');
});

it('validates the message field', function () {

    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('message', '')
        ->call('create')
        ->assertHasErrors(['message', 'roomId']);

});

it('validates the roomId field', function () {
    $this->actingAs(User::factory()->create());

    $room = Room::factory()->create();

    // test if the roomId is required
    Livewire::test(Create::class, ['roomId' => null])
        ->set('message', 'test message')
        ->call('create')
        ->assertHasErrors(['roomId']);

    // test if the roomId is not an integer
    Livewire::test(Create::class, ['roomId' => '123'])
        ->set('message', 'test message')
        ->call('create')
        ->assertHasErrors(['roomId']);

    // test if the roomId is not exists
    Livewire::test(Create::class, ['roomId' => 123])
        ->set('message', 'test message')
        ->call('create')
        ->assertHasErrors(['roomId']);

});

it('can create a chat', function () {

    $john = User::factory()->create(['name' => 'John Doe']);

    // other user
    $jane = User::factory()->create(['name' => 'Jane Doe']);

    $this->actingAs($john);

    $room = Room::factory()->create(['user_id' => $jane->id]);

    $room->users()->attach($john->id);

    Livewire::test(Create::class, ['roomId' => $room->id])
        ->set('message', 'message from John')
        ->call('create')
        ->assertDispatched('chat:created');

    $this->assertDatabaseHas('chats', ['message' => 'message from John']);
});

it('can not create a chat as an invalid user/member ', function () {

    $john = User::factory()->create(['name' => 'John Doe']);

    // other user
    $jane = User::factory()->create(['name' => 'Jane Doe']);

    $this->actingAs($john);

    $room = Room::factory()->create(['user_id' => $jane->id]);

    Livewire::test(Create::class, ['roomId' => $room->id])
        ->set('message', 'message from John')
        ->call('create')
        ->assertStatus(403);

});
