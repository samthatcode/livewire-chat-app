<div class="bg-white dark:bg-gray-800 w-3/4">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                @if ($room !== null)
                {{-- edit group modal trigger --}}
                <div class="flex items-center gap-3 cursor-pointer" x-on:click="$dispatch('open-modal', 'edit-room');  $dispatch('set-tab', 'overview')">

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
                </div>

                <x-modal name="edit-room">
                    <div class="flex h-screen bg-gray-900 text-white"
                        x-data="{ tab: 'overview' }"
                        x-on:set-tab.window="tab = $event.detail"
                    >
                        <!-- Sidebar -->
                        <aside class="w-64 bg-gray-800 p-4">
                            <h2 class="text-lg font-bold mb-4">Menu</h2>
                            <ul class="space-y-2">
                                <li>
                                    <a 
                                        href="#" 
                                        class="block hover:bg-gray-700 p-2 rounded"
                                        :class="{ 'bg-gray-700': tab === 'overview' }"
                                          @click.prevent="tab = 'overview'"
                                        >Overview</a>
                                </li>
                                <li>
                                    <a 
                                        href="#" 
                                        class="block hover:bg-gray-700 p-2 rounded"
                                        :class="{ 'bg-gray-700': tab === 'members' }"
                                        @click.prevent="tab = 'members'"
                                    >Members
                                    </a>
                                </li>
                            </ul>
                        </aside>
                    
                        <!-- Main Content -->
                        <main class="flex-1 p-6">
                            {{-- // Overview --}}
                            <template x-if="tab === 'overview'">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 rounded-full mb-4 border-4 border-gray-600 flex items-center justify-center">
                                        <x-icons.group />
                                    </div>
                
                                    <div class="flex items-center gap-2 mt-2">
                                        <h1 class="text-2xl font-bold">LaraGang</h1>
                                        <button class="text-sm hover:underline text-blue-400">
                                            <x-icons.edit class="h-6 w-6" />
                                        </button>
                                    </div>
                
                                    <div class="flex gap-4 mt-4">
                                        <button class="cursor-not-allowed bg-gray-700 px-4 py-2 rounded" title="coming soon...">📹 Video</button>
                                        <button class="cursor-not-allowed bg-gray-700 px-4 py-2 rounded" title="coming soon...">📞 Voice</button>
                                    </div>
                
                                    <div class="mt-6 w-full max-w-md space-y-4">
                                        <div>
                                            <label class="text-sm text-gray-400">Created</label>
                                            <p>11/23/2024 3:32 PM</p>
                                        </div>
                                        <div>
                                            <label class="text-sm text-gray-400">Description</label>
                                            <div class="flex items-center gap-2">
                                                <p> </p>
                                                <button class="text-blue-400 text-sm hover:underline">
                                                    <x-icons.edit class="h-6 w-6" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Members Tab -->
                            <template x-if="tab === 'members'">
                                <div class="space-y-4">
                                    @foreach($room->users as $member)
                                        <div class="flex items-center gap-4 bg-gray-800 p-3 rounded">
                                            <img src="{{ $member->profile }}" alt="{{ $member->name }}" class="w-10 h-10 rounded-full" />
                                            <span>{{ $member->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </template>
                        </main>
                    </div>
                    
                </x-modal>

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
