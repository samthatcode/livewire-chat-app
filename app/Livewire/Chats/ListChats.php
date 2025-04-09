<?php

declare(strict_types=1);

namespace App\Livewire\Chats;

use App\Models\Chat;
use Livewire\Component;

class ListChats extends Component
{
    public int $roomId;

    public int $limit = 10;

    public int $offset = 0;

    public function placeholder(): string
    {
        return <<<'HTML'
            <div class="flex items-center justify-center w-full h-full">
                <div class="animate-pulse">
                    <div class="flex space-x-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                        <div class="flex-1 space-y-4 py-1">
                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            <div class="space-y-2">
                                <div class="h-4 bg-gray-200 rounded"></div>
                                <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }

    public function render()
    {
        if ($this->offset > 0) {
            $this->dispatch('chats:loaded')->self();
        }

        return view('livewire.chats.list-chats', [
            'chats' => Chat::query()
                ->where('room_id', $this->roomId)
                ->whereHas('room.users', function ($query): void {
                    $query->where('users.id', auth()->id());
                })
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->limit($this->limit)
                ->offset($this->offset)
                ->get(),
        ]);
    }
}
