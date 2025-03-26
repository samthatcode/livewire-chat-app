<?php

declare(strict_types=1);

namespace App\Livewire\Chats;

use App\Events\ChatCreated;
use App\Models\Room;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Locked]
    #[Reactive]
    public int $roomId;

    #[Validate('required|string')]
    public string $message;

    public function store(): void
    {
        $this->validate();

        $room = Room::query()->findOrFail($this->roomId);

        $memberExists = $room->users()
            ->where('user_id', auth()->id())
            ->exists();

        Gate::denyIf(! $memberExists, 'You are not a member of this room.');

        $chat = $room->chats()->create([
            'user_id' => auth()->id(),
            'message' => $this->pull('message'),
        ]);

        broadcast(new ChatCreated(
            chatId: $chat->id,
            roomId: $this->roomId,
        ))->toOthers();

        $this->dispatch('chat:created');
    }

    #[On('echo-private:chats.{roomId},.chat-created')]
    public function chatCreated($event): void {
        $this->dispatch('chat:created');
    }

    public function render(): View
    {
        return view('livewire.chats.create');
    }
}
