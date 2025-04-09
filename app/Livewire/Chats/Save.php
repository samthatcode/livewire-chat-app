<?php

declare(strict_types=1);

namespace App\Livewire\Chats;

use App\Events\ChatCreated;
use App\Events\ChatUpdated;
use App\Models\Chat;
use App\Models\Room;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Save extends Component
{
    #[Locked]
    #[Reactive]
    public int $roomId;

    #[Validate('required|string')]
    public string $message;

    #[Locked]
    public ?int $chatId = null;

    private ?Chat $createdChat = null;

    #[On('chat-editing')]
    public function startEditing(int $chatId, string $message): void
    {
        $this->chatId = $chatId;
        $this->message = $message;
    }

    public function save(): void
    {
        $this->validate();

        $room = Room::query()->findOrFail($this->roomId);

        $memberExists = $room->users()
            ->where('user_id', auth()->id())
            ->exists();

        Gate::denyIf(! $memberExists, 'You are not a member of this room.');

        if ($this->chatId !== null && $this->chatId !== 0) {
            $chat = $room->chats()->findOrFail($this->chatId);
            Gate::denyIf($chat->user_id !== auth()->id(), 'You are not the owner of this chat.');

            $chat->update([
                'message' => $this->pull('message'),
            ]);

            broadcast(new ChatUpdated(
                chatId: $chat->id,
                roomId: $this->roomId,
            ))->toOthers();

            $this->dispatch('chat:updated.'.$this->pull('chatId'));

            return;
        }

        $chat = $room->chats()->create([
            'user_id' => auth()->id(),
            'message' => $this->pull('message'),
        ]);

        broadcast(new ChatCreated(
            chatId: $chat->id,
            roomId: $this->roomId,
        ))->toOthers();

        $this->createdChat = $chat;

        $this->dispatch('chat:created');
    }

    /**
     * @param  array{roomId: int, chatId: int}  $event
     */
    #[On('echo-private:chats.{roomId},.chat-created')]
    public function chatCreated(array $event): void
    {
        $this->createdChat = Chat::query()
            ->whereKey($event['chatId'])
            ->first();

        $this->dispatch('chat:created');
    }

    /**
     * @param  array{roomId: int, chatId: int}  $event
     */
    #[On('echo-private:chats.{roomId},.chat-updated')]
    public function chatUpdated(array $event): void
    {
        $this->dispatch('chat:updated.'.$event['chatId']);
    }

    public function cancel(): void
    {
        $this->message = '';
        $this->chatId = null;
    }

    public function render(): View
    {
        return view('livewire.chats.create', [
            'createdChat' => $this->createdChat,
        ]);
    }
}
