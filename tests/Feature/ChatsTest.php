<?php

declare(strict_types=1);

use App\Livewire\Chats\Index;
use App\Livewire\Pages\Chats;
use App\Livewire\Rooms\Create;
use App\Livewire\Rooms\Index as RoomsIndex;
use App\Models\User;

test('Chats page is displayed', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/chats')
        ->assertSeeLivewire(Chats::class)
        ->assertSeeLivewire(Index::class)
        ->assertSeeLivewire(RoomsIndex::class)
        ->assertSeeLivewire(Create::class)
        ->assertOk();
});
