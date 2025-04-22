<div class="mt-6 relative">
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
                class="absolute -top-24 w-full bg-white dark:bg-gray-800 shadow-lg rounded-xl p-3.5 mb-4 border-l-4 border-blue-500 flex justify-between items-center transition-all duration-200 animate-fade-in">
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    <span class="font-medium text-blue-600 dark:text-blue-400 block mb-1">Replying to:</span>
                    <p class="truncate max-w-[90%]">{{ $replyMessage }}</p>
                </div>
                <button
                    wire:click="cancel"
                    class="text-gray-500 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                    title="Cancel reply"
                >
                    <x-icons.close class="h-4 w-4" />
                </button>
            </div>
        @endif

        <div class="flex items-center gap-2 bg-white dark:bg-gray-800 rounded-xl shadow-md p-2 transition-all animate-fade-in">
            <x-text-input
                wire:model="message"
                id="message"
                name="message"
                type="text"
                autofocus
                class="w-full bg-gray-50 dark:bg-gray-700 rounded-lg px-4 py-3 border-0 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500"
                placeholder="Type your message here..."
                @keydown.enter="save"
            />

            <div class="flex gap-2">
                @if ($chatId !== null)
                    <button
                        type="button"
                        x-on:click="save"
                        class="transition-all duration-200 text-white font-medium bg-blue-500 hover:bg-blue-600 active:bg-blue-700 py-2.5 px-4 rounded-lg flex items-center gap-1.5 shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                        Update
                    </button>

                    <button
                        type="button"
                        wire:click="cancel"
                        class="transition-all duration-200 text-gray-700 dark:text-gray-300 font-medium bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 py-2.5 px-4 rounded-lg flex items-center gap-1.5 shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        Cancel
                    </button>
                @elseif($parentId !== null)
                    <button
                        type="button"
                        x-on:click="save"
                        class="transition-all duration-200 text-white font-medium bg-blue-500 hover:bg-blue-600 active:bg-blue-700 py-2.5 px-4 rounded-lg flex items-center gap-1.5 shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                        Reply
                    </button>
                    <button
                        type="button"
                        wire:click="cancel"
                        class="transition-all duration-200 text-gray-700 dark:text-gray-300 font-medium bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 py-2.5 px-4 rounded-lg flex items-center gap-1.5 shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        Cancel
                    </button>
                @else
                    <button
                        type="button"
                        x-on:click="save"
                        class="transition-all duration-200 text-white font-medium bg-blue-500 hover:bg-blue-600 active:bg-blue-700 py-2.5 px-4 rounded-lg flex items-center gap-1.5 shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 2L11 13"></path>
                            <path d="M22 2l-7 20-4-9-9-4 20-7z"></path>
                        </svg>
                        Send
                    </button>
                @endif
            </div>
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
