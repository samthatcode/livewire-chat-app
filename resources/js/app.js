import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm'
import { storeChat } from './store-chat.js'
import { notifications, notify } from './notification.js'

window.Alpine = Alpine

Alpine.data('storeChat', storeChat)
Alpine.data('notifications', notifications)

window.Alpine.plugin(notify)

Livewire.start()
