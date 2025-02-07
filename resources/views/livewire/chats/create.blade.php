<div class="mt-4">
    <form wire:submit="create">
        <div class="flex items-center gap-3">
            <input type="text" 
                wire:model.live="message" 
                required
                @class([
                    'w-full rounded-lg px-4 py-2',
                    'border-gray-300' => !$errors->has('message'),
                    'border-2 border-red-500' => $errors->has('message')
                ])

            />
            
            <button type="submit"
                {{ $errors->has('message') || empty($message) ? 'disabled' : '' }}
                @class([
                    'text-white font-bold bg-blue-500 py-2 px-4 rounded disabled:cursor-not-allowed',
                    'disabled:opacity-50' => $errors->has('message') || empty($message)
                ])
            >
                Send
            </button>
        </div>
    </form>
</div>