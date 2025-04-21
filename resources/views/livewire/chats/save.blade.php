<div class="mt-4">
    <div
        class="hidden"
        id="created-chat"
    >
        @if ($createdChat)
            <livewire:chats.show
                :chat="$createdChat"
                :key="'chat-' . $createdChat->id"
            />
        @endif
    </div>

    <div x-data="saveChat" class="relative">
        @if ($parentId)
            <div
                class="absolute -top-20 w-full bg-white dark:bg-gray-700 shadow-md rounded-lg p-3 mb-4 border-l-4 border-blue-500 flex justify-between items-center">
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    <span class="font-medium text-blue-600 dark:text-blue-400 block">Replying to:</span>
                    {{ $replyMessage }}
                </div>
                <button
                    wire:click="cancel"
                    class="text-gray-500 hover:text-red-500"
                    title="Cancel reply"
                >
                    <x-icons.close />
                </button>
            </div>
        @endif

        <div class="flex items-center gap-3">
            <x-text-input
                wire:model="message"
                id="message"
                name="message"
                type="text"
                autofocus
                class="w-full rounded-lg px-4 py-2 border border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Type your message here..."
            />

            @if ($chatId !== null)
                <button
                    type="button"
                    x-on:click="save"
                    class="text-white font-bold bg-blue-500 py-2 px-4 rounded-sm disabled:cursor-not-allowed cursor-pointer"
                >
                    Update
                </button>

                <button
                    type="button"
                    wire:click="cancel"
                    class="text-white font-bold bg-red-500 py-2 px-4 rounded-sm disabled:cursor-not-allowed cursor-pointer"
                >
                    Cancel
                </button>
            @elseif($parentId !== null)
                <button
                    type="button"
                    x-on:click="save"
                    class="text-white font-bold bg-blue-500 py-2 px-4 rounded-sm disabled:cursor-not-allowed cursor-pointer"
                >
                    Reply
                </button>
                <button
                    type="button"
                    wire:click="cancel"
                    class="text-white font-bold bg-red-500 py-2 px-4 rounded-sm disabled:cursor-not-allowed cursor-pointer"
                >
                    Cancel
                </button>
            @else
                <button
                    type="button"
                    x-on:click="save"
                    class="text-white font-bold bg-blue-500 py-2 px-4 rounded-sm disabled:cursor-not-allowed cursor-pointer"
                >
                    Send
                </button>
            @endif
        </div>
    </div>

    @script
        <script>
            $wire.on('chat:created', (e) => {
                const mainContainer = 'list-chats-0';
                const currentContainer = 'created-chat';

                requestAnimationFrame(() => {
                    document.getElementById("not-chats-found")?.remove();
                    const currentElement = document.getElementById(currentContainer);
                    const mainElement = document.getElementById(mainContainer);
                    while (currentElement.firstChild) {
                        mainElement.prepend(currentElement.firstChild);
                    }
                });
            });
        </script>
    @endscript
</div>
