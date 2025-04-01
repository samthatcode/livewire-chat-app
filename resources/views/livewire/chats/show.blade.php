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
        <div @class([
            'flex items-center mb-1',
            'justify-end' => $isCurrentUser,
        ])>
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
                <p class="text-sm">
                    {{ $chat->message }}
                </p>
            </div>

            <button wire:click="edit" class="opacity-0 group-hover:opacity-100 transition-opacity absolute -top-1 left-0 p-1 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L3.586 12.586a1 1 0 00-.293.707V16a2 2 0 002 2h2.707a1 1 0 00.707-.293l11-11a2 2 0 000-2.828zM5.414 15H4v-1.414l10-10L15.414 4l-10 10z" />
                </svg>
            </button>
        </div>

        <div @class([
            'text-xs text-gray-400 mt-1',
            'text-right' => $isCurrentUser,
        ])>
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
