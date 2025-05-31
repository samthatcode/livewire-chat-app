<div class="bg-white dark:bg-gray-800 w-full md:w-3/4">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                @if ($room !== null)
                    <figure
                        class="rounded-sm h-10 w-10 shrink-0 transition-opacity group-hover:opacity-90 {{ $room->user->profile }}"
                    >
                        <img
                            src="{{ $room->user->profile }}"
                            alt="{{ $room->user->name }}"
                            class="rounded-sm h-10 w-10"
                        />
                    </figure>
                    <p class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $room->name }}</p>
                @else
                    <p class="text-xl font-bold text-gray-800 dark:text-gray-100">
                        Please select room.
                    </p>
                @endif
            </div>
        </div>
        <div
            class="mt-4 h-[calc(100vh-210px)] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 flex flex-col-reverse">
            @if($room !==  null)
                <livewire:chats.list-chats
                    :roomId="$roomId"
                    :key="'list-chats-'.$roomId.'-0'"
                />
            @endif
        </div>
        @if ($room !== null)
            <livewire:chats.save :roomId="$room->id" key="save-chat-{{ $room->id }}" />
        @endif
    </div>
    @script
    <script>
        $wire.on('room-closed', (e) => {
            window.Echo.leave(`chats.${e.roomId}`);
        });
    </script>
    @endscript
</div>
