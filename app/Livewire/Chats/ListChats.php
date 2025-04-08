<?php

declare(strict_types=1);

namespace App\Livewire\Chats;

use App\Models\Chat;
use Livewire\Component;

class ListChats extends Component
{
    public ?int $roomId = null;

    public function render()
    {
        return view('livewire.chats.list-chats', [
            'chats' => $this->roomId !== null ? Chat::query()
                ->where('room_id', $this->roomId)
                ->whereHas('room.users', function ($query) {
                    $query->where('users.id', auth()->id());
                })
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->get() : [],
        ]);
    }
}
