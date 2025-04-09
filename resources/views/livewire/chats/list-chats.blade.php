<div
    class="flex flex-col-reverse gap-4 px-4"
    id="list-chats-{{ $offset }}"
>
    @foreach ($chats as $chat)
        <livewire:chats.show
            :chat="$chat"
            :key="'chat-' . $chat->id"
        />
    @endforeach

    @if ($offset === 0 && $chats->isEmpty())
        <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg py-4" id="not-chats-found">
            <div class="flex items-center gap-3 px-4">
                <p class="text-gray-500 dark:text-gray-400">No chats found</p>
            </div>
        </div>
    @endif

    @if ($chats->count() === $limit)
        <livewire:chats.list-chats
            :roomId="$roomId"
            :offset="$offset + $limit"
            :key="'list-chats-' . $roomId . '-' . $offset + $limit"
            lazy
        />
    @else
        <div class="flex justify-center gap-3 px-4 w-full">
            <p class="text-gray-500 dark:text-gray-400">End of the chat</p>
        </div>
    @endif

    @script
        <script>
            $wire.on('chats:loaded', (e) => {
                const mainContainer = 'list-chats-0';
                const currentContainer = 'list-chats-' + $wire.offset;

                requestAnimationFrame(() => {
                    const currentElement = document.getElementById(currentContainer);
                    const mainElement = document.getElementById(mainContainer);
                    while (currentElement.firstChild) {
                        mainElement.appendChild(currentElement.firstChild);
                    }
                });
            });
        </script>
    @endscript
</div>
