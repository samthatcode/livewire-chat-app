<div
    x-data="notifications"
    class="fixed top-4 right-4 z-[9999] space-y-3"
>
    <template
        x-for="notification in notifications"
        :key="notification.id"
    >
        <div
            x-show="notification.visible"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-y-2 opacity-0 scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="max-w-sm w-full backdrop-blur-sm backdrop-filter shadow-xl rounded-lg pointer-events-auto ring-1 ring-black/5"
            :class="{
                'bg-green-500/10 ring-green-500/20': notification.type === 'success',
                'bg-red-500/10 ring-red-500/20': notification.type === 'error',
                'bg-yellow-500/10 ring-yellow-500/20': notification.type === 'warning',
                'bg-blue-500/10 ring-blue-500/20': notification.type === 'info'
            }"
        >
            <div class="p-4">
                <div class="flex items-start">
                    <!-- Type-specific icons -->
                    <div class="flex-shrink-0">
                        <template x-if="notification.type === 'success'">
                            <x-icons.check class="text-green-500" />
                        </template>
                        <template x-if="notification.type === 'error'">
                            <x-icons.close class="text-red-500" />
                        </template>
                        <template x-if="notification.type === 'warning'">
                            <x-icons.warning class="text-yellow-500" />
                        </template>
                        <template x-if="notification.type === 'info'">
                            <x-icons.info class="text-blue-500" />
                        </template>
                    </div>
                    <div class="ml-3 flex-1">
                        <p
                            class="text-sm font-medium"
                            :class="{
                                'text-green-900 dark:text-green-100': notification.type === 'success',
                                'text-red-900 dark:text-red-100': notification.type === 'error',
                                'text-yellow-900 dark:text-yellow-100': notification.type === 'warning',
                                'text-blue-900 dark:text-blue-100': notification.type === 'info'
                            }"
                            x-text="notification.message"
                        ></p>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <button
                            x-on:click="remove(notification.id)"
                            class="rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            :class="{
                                'focus:ring-green-500': notification.type === 'success',
                                'focus:ring-red-500': notification.type === 'error',
                                'focus:ring-yellow-500': notification.type === 'warning',
                                'focus:ring-blue-500': notification.type === 'info'
                            }"
                        >
                            <span class="sr-only">Close</span>
                            <x-icons.x class="h-4 w-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
