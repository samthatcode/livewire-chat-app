export const storeChat = () => ({
    async store() {
        if (this.$wire.message === '') return;
        await this.$wire.store();
        this.$wire.message = '';
    }
})
