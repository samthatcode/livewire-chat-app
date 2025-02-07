<?php

declare(strict_types=1);

namespace App\Livewire\Chats;

use App\Models\Chat;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Locked]
    #[Reactive]
    public ?int $roomId = null;

    #[Validate('required|string')]
    public string $message;

    public function create()
    {
        $this->validate();

        // create a new chat in the database
        Chat::factory()->create([
            'room_id' => $this->roomId,
            'user_id' => auth()->id(),
            'message' => $this->message,
        ]);

        $this->dispatch('chat:created');
        // clear the message input
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chats.create');
    }
}
