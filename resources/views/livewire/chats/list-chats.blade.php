<div class="flex flex-col-reverse gap-4" id="list-chats">
    @forelse ($chats as $chat)
        <livewire:chats.show
            :chat="$chat"
            :key="'chat-'.$chat->id"
        />
    @empty
        <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg py-4">
            <div class="flex items-center gap-3 px-4">
                <p class="text-gray-500 dark:text-gray-400">No chats found</p>
            </div>
        </div>
    @endforelse
</div>
