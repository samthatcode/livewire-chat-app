<div @class([
    'flex items-center space-x-2',
    'justify-end' => $isCurrentUser,
])>
    @if (!$isCurrentUser)
        <figure class="flex shrink-0 self-start">
            <img
                src="{{ $chat->user->profile }}"
                alt="{{ $chat->user->name }}"
                class="h-8 w-8 object-cover rounded-full"
            >
        </figure>
    @endif
    <div class="flex flex-col max-w-md">
        <div @class(['flex items-center mb-1', 'justify-end' => $isCurrentUser])>
            <small class="text-xs text-gray-500 dark:text-gray-400">
                {{ $chat->user->name }}
            </small>
            @if ($chat->updated_at > $chat->created_at)
                <span class="text-xs text-gray-400 dark:text-gray-500 mx-1">(edited)</span>
            @endif
        </div>

        <div @class([
            'relative group ps-6 rounded-lg',
            'text-right' => $isCurrentUser,
        ])>
            <div @class([
                'inline-block p-3 rounded-lg shadow-sm',
                'bg-blue-500 text-white rounded-tr-none' => $isCurrentUser,
                'bg-gray-100 dark:bg-gray-700 dark:text-gray-200 rounded-tl-none' => !$isCurrentUser,
            ])>
                @if ($chat->parent)
                    <div
                        class="mb-3 p-2 border-l-2 rounded-sm text-xs bg-opacity-20 dark:bg-opacity-20 border-gray-400 bg-gray-200 dark:bg-gray-600 dark:border-gray-500">
                        <p
                            class="truncate text-gray-500 dark:text-gray-400 flex items-center gap-1">
                            <x-icons.reply
                                class="text-gray-400 dark:text-gray-500"
                            />
                            {{ Str::limit($chat->parent->message, 100) }}
                        </p>
                    </div>
                @endif
                <p class="text-sm">
                    {{ $chat->message }}
                </p>
            </div>

            <button
                wire:click="edit"
                class="opacity-0 group-hover:opacity-100 transition-opacity absolute -top-1 left-0 p-1 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300"
            >
                <x-icons.edit />
            </button>

            <button
                wire:click="reply"
                class="opacity-0 group-hover:opacity-100 transition-opacity absolute top-5 left-0 p-1 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300"
            >
                <x-icons.reply />
            </button>
        </div>

        <div @class(['text-xs text-gray-400 mt-1', 'text-right' => $isCurrentUser])>
            {{ $chat->updated_at->diffForHumans() }}
        </div>
    </div>
    @if ($isCurrentUser)
        <figure class="flex shrink-0 self-start">
            <img
                src="{{ $chat->user->profile }}"
                alt="{{ $chat->user->name }}"
                class="h-8 w-8 object-cover rounded-full"
            >
        </figure>
    @endif
</div>
