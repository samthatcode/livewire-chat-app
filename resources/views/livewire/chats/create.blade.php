<div class="mt-4">
    <form wire:submit="create">
        <div class="flex items-center gap-3">
            <input type="text" wire:model="message" class="w-full rounded-lg border-gray-300" />
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Send</button>
        </div>
    </form>
</div>