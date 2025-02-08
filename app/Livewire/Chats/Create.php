<?php

declare(strict_types=1);

namespace App\Livewire\Chats;

use App\Models\Chat;
use App\Models\Room;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Locked]
    #[Reactive]
    #[Validate('required|integer|exists:rooms,id')]
    public ?int $roomId = null;

    #[Validate('required|string')]
    public string $message;

    public function create(): void
    {
        $this->validate();

        $room = Room::query()->findOrFail($this->roomId);

        $users = $room->users;

        Gate::denyIf(! $users->contains('id', '==', auth()->id()), 'You are not a member of this room.');

        Chat::factory()->create([
            'room_id' => $this->roomId,
            'user_id' => auth()->id(),
            'message' => $this->message,
        ]);

        $this->dispatch('chat:created');

        $this->reset('message');
    }

    public function render(): View
    {
        return view('livewire.chats.create');
    }
}
