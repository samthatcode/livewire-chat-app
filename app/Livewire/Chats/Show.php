<?php

declare(strict_types=1);

namespace App\Livewire\Chats;

use App\Models\Chat;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('chat:updated.{chat.id}')]
class Show extends Component
{
    public Chat $chat;

    public function edit(): void
    {
        $this->dispatch('chat-editing', chatId: $this->chat->id, message: $this->chat->message);
    }

    public function reply(): void
    {
        $this->dispatch('chat-replying', chatId: $this->chat->id, message: $this->chat->message);
    }

    public function render(): View
    {
        if ($this->chat->parent_id !== null) {
            $this->chat->load('parent');
        }

        return view('livewire.chats.show', [
            'chat' => $this->chat,
            'isCurrentUser' => $this->chat->user->id === auth()->id(),
        ]);
    }
}
