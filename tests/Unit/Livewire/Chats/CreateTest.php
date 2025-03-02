<?php

declare(strict_types=1);
use App\Livewire\Chats\Create;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        ->call('store')
        ->assertHasErrors(['message']);

});

it('checks for exception when roomId is null ', function () {
    $this->actingAs(User::factory()->create());

    $this->expectException(ModelNotFoundException::class);

    Livewire::test(Create::class, ['roomId' => null])
        ->set('message', 'test message')
        ->call('store')
        ->assertNotFound();
});

it('checks for exception when roomId is invalid', function () {
    $this->actingAs(User::factory()->create());

    $this->expectException(ModelNotFoundException::class);

    Livewire::test(Create::class, ['roomId' => 123])
        ->set('message', 'test message')
        ->call('store')
        ->assertNotFound();
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
        ->call('store')
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
        ->call('store')
        ->assertStatus(403);

});
