<div class="mt-4">
    <div x-data="storeChat">
        <div class="flex items-center gap-3">
            <x-text-input
                wire:model="message"
                id="message"
                name="message"
                type="text"
                autofocus
                class="w-full rounded-lg px-4 py-2 border border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Type your message here..."
            />

            <button
                type="button"
                x-on:click="store"
                class="text-white font-bold bg-blue-500 py-2 px-4 rounded-sm disabled:cursor-not-allowed cursor-pointer"
            >
                Send
            </button>
        </div>
    </div>
</div>
