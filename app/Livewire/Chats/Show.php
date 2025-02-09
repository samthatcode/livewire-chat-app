<?php

declare(strict_types=1);

namespace App\Livewire\Chats;

use App\Models\Chat;
use Illuminate\View\View;
use Livewire\Component;

class Show extends Component
{
    public Chat $chat;

    public function render(): View
    {
        return view('livewire.chats.show', [
            'chat' => $this->chat,
            'isCurrentUser' => $this->chat->user->id === auth()->id(),
        ]);
    }
}
