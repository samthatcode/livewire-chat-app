<div class="mt-4">
    <form wire:submit="create">
        <div class="flex items-center gap-3">
            <input type="text" 
                wire:model="message"                
                required
                @class([
                    'w-full rounded-lg px-4 py-2',
                    'border-gray-300' => !$errors->has('message'),
                    'border-2 border-red-500' => $errors->has('message')
                ])

            />
            
            <button type="submit"
            class="text-white font-bold bg-blue-500 py-2 px-4 rounded disabled:cursor-not-allowed"
                :class="$wire.message.length === 0 ? 'disabled:opacity-50' : '' "
                :disabled="$wire.message.length === 0"         
            >
                Send                
            </button>
        </div>
    </form>
</div>