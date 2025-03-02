import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm'
import { notifications, notify } from './notification.js'

window.Alpine = Alpine

Alpine.data('notifications', notifications)

window.Alpine.plugin(notify)

Livewire.start()
