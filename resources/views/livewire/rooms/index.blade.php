<aside class="bg-white dark:bg-gray-800 w-16 md:w-1/4  border-r border-gray-700">
    <div class="mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <h1 class="hidden md:block text-2xl font-bold text-gray-800 dark:text-gray-100">Chats</h1>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 md:py-2 md:px-2 rounded-sm"
                x-on:click="$dispatch('open-modal', 'create-room')"
                title="Create Room"
            >
                <x-icons.add class="h-6 w-6" />
            </button>
            <x-modal name="create-room">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                            Create Room
                        </h2>
                        <button x-on:click="$dispatch('close-modal', 'create-room')"
                            x-on:room-created.window="$dispatch('close-modal', 'create-room')"
                            class="text-gray-500 dark:text-gray-400">
                            <x-icons.x class="h-6 w-6" />
                        </button>
                    </div>

                    <livewire:rooms.create />
                </div>
            </x-modal>
        </div>
        <div
            class="mt-4 h-[calc(100vh-155px)] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            <div class="flex justify-center md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                @class([
                    'size-8',
                    'text-blue-500' => true,
                    'text-white' => false,
                ])
                class="">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"></path>
                </svg>
            </div>            
            <div class="hidden md:flex flex-col gap-4">
                @forelse ($rooms as $room)
                    <div
                        @class([
                            'shadow-md rounded-lg py-4 cursor-pointer',
                            'bg-gray-50 dark:bg-gray-600 border border-1 dark:border-blue-300' => $room->id == $activeRoomId,
                            'bg-white dark:bg-gray-700' => $room->id != $activeRoomId,
                        ]) 
                        x-on:click="$dispatch('room-selected', { id: {{ $room->id }} })">
                        <div class="group flex items-center gap-3 px-4">
                            <figure
                                class="rounded-sm h-10 w-10 shrink-0 transition-opacity group-hover:opacity-90 {{ $room->user->profile }}">
                                <img src="{{ $room->user->profile }}" alt="{{ $room->user->name }}"
                                    class="rounded-sm h-10 w-10" />
                            </figure>

                            <div class="overflow-hidden text-sm dark:text-gray-100">
                                <div class="flex items-center gap-2 justify-between">
                                    <p class="truncate font-medium" title="{{ $room->name }}">
                                        {{ $room->name }}
                                    </p>

                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-auto">
                                        {{ $room->created_at->diffForHumans(short: true) }}
                                    </span>
                                </div>
                                <p class="truncate text-gray-500 dark:text-gray-400">
                                    last message
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg py-4">
                        <div class="flex items-center gap-3 px-4">
                            <p class="text-gray-500 dark:text-gray-400">No rooms found</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</aside>
