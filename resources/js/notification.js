export const notifications = () => ({
    notifications: [],
    init() {
        window.addEventListener('notify', ({ detail }) => this.add(detail.message, detail.type))
    },
    add(message, type = 'success') {
        const id = Math.random().toString(36).substr(2, 9)
        this.notifications.push({
            id,
            message,
            type,
            visible: true
        })
        setTimeout(() => this.remove(id), 3000)
    },
    remove(id) {
        this.notifications = this.notifications.filter(n => n.id !== id)
    }
})

export const notify = function (Alpine) {
    Alpine.magic('notify', () => (message, type) =>
        window.dispatchEvent(new CustomEvent('notify', {
            detail: { message, type }
        }))
    )
}
