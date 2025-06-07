<div @class([
    'flex items-start gap-3 mb-4 animate-fade-in group',
    'flex-row-reverse' => $isCurrentUser,
])>
    <figure class="flex shrink-0 self-start">
        <img
            src="{{ $chat->user->profile }}"
            alt="{{ $chat->user->name }}"
            class="h-10 w-10 object-cover rounded-full ring-2 ring-offset-2 ring-opacity-50 {{ $isCurrentUser ? 'ring-blue-400' : 'ring-gray-300' }}"
        >
    </figure>

    <div class="flex flex-col max-w-md relative">
        <div @class(['flex items-center mb-1.5', 'justify-end' => $isCurrentUser])>
            <small class="font-medium text-xs text-gray-600 dark:text-gray-300">
                {{ $chat->user->name }}
            </small>
            @if ($chat->updated_at > $chat->created_at)
                <span class="text-xs text-gray-400 dark:text-gray-500 mx-1.5 italic">(edited)</span>
            @endif
        </div>

        <div @class([
            'relative rounded-lg',
            'text-right' => $isCurrentUser,
        ])>
            <!-- Action buttons made smaller -->
            <div @class([
                'absolute top-8 flex gap-1 opacity-0 group-hover:opacity-100 transition-all duration-200 z-10 flex-col',
                '-left-5 -translate-x-full' => !$isCurrentUser,
                '-right-5 translate-x-full' => $isCurrentUser,
            ])>
                @if($isCurrentUser)
                    <button
                        wire:click="edit"
                        class="p-1 rounded-full bg-white dark:bg-gray-800 text-gray-500 hover:text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/30 dark:hover:text-blue-400 shadow-sm"
                        title="Edit message"
                    >
                        <x-icons.edit class="h-3 w-3" />
                    </button>

                    @if($chat->deleted_at === null)
                        <button
                            wire:click="delete"
                            class="p-1 rounded-full bg-white dark:bg-gray-800 text-gray-500 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 dark:hover:text-red-400 shadow-sm"
                            title="Delete message"
                        >
                            <x-icons.trash class="h-3 w-3" />
                        </button>
                    @endif
                @endif

                <button
                    wire:click="reply"
                    class="p-1 rounded-full bg-white dark:bg-gray-800 text-gray-500 hover:text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/30 dark:hover:text-blue-400 shadow-sm"
                    title="Reply to message"
                >
                    <x-icons.reply class="h-3 w-3"/>
                </button>
                <button
                    wire:click="toggleFavourite"
                    @class([
                        'p-1 rounded-full text-gray-500 shadow-sm',
                        'bg-white dark:bg-gray-800 hover:text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/30 dark:hover:text-blue-400' => $chat->favouritedBy->doesntContain(auth()->id()),
                        'bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400' => $chat->favouritedBy->contains(auth()->id())
                    ])
                    title="{{ $chat->favouritedBy->contains(auth()->id()) ? 'Remove from favourite chats' : 'Mark as favourite' }}"
                >
                    <x-icons.star @class([
                        'h-3 w-3',
                        'text-blue-500' => $chat->favouritedBy->contains(auth()->id()),
                    ])
                    />
                </button>
            </div>

            <div @class([
                'inline-block p-3.5 rounded-xl shadow-md',
                'bg-blue-500 text-white rounded-tr-none' => $isCurrentUser,
                'bg-gray-100 dark:bg-gray-700 dark:text-gray-200 rounded-tl-none' => !$isCurrentUser,
            ])>
                @if($chat->deleted_at === null)
                    @if ($chat->parent)
                        <div
                            class="mb-3 p-2.5 border-l-3 rounded-md text-xs bg-opacity-25 dark:bg-opacity-25 border-gray-400 bg-gray-200 dark:bg-gray-600 dark:border-gray-500">
                            <p
                                class="truncate text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                                <x-icons.reply
                                    class="text-gray-400 dark:text-gray-500 h-3.5 w-3.5"
                                />
                                @if ($chat->parent->deleted_at === null)
                                    {{ Str::limit($chat->parent->message, 100) }}
                                @else
                                    <span class="text-red-400 dark:text-red-500">
                                        This message has been deleted.
                                    </span>
                                @endif
                            </p>
                        </div>
                    @endif
                    <p class="text-sm leading-relaxed">
                        {{ $chat->message }}
                    </p>
                @else
                    <p class="text-sm leading-relaxed text-red-400 dark:text-red-500">
                        This message has been deleted.
                    </p>
                @endif
            </div>
        </div>

        <div @class(['text-xs text-gray-400 mt-1.5', 'text-right' => $isCurrentUser])>
            {{ $chat->updated_at->diffForHumans() }}
        </div>
    </div>
</div>
