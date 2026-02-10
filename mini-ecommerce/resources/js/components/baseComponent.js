export const baseLogic = (service) => ({
    items: [],
    paginationHtml: "",
    isLoading: false,
    search: "",
    indexUrl: "",
    idToDelete: null,
    isDeleteModalOpen: false,
    errors: {},

    async fetchData(url = null, extraParams = {}) {
        this.isLoading = true;
        try {
            const fetchUrl = url || this.indexUrl;
            const data = await service.fetch(
                fetchUrl,
                this.search,
                extraParams,
            );

            this.items = data.products || data.data || [];
            this.paginationHtml = data.pagination || "";

            this.$nextTick(() => window.createLucideIcons?.());

            return data;
        } catch (err) {
            console.error("Fetch Error:", err);
            return null;
        } finally {
            this.isLoading = false;
        }
    },

    async performDelete(id, callback) {
        try {
            const res = await service.delete(id);
            const data = await res.json();
            if (res.ok) {
                this.items = this.items.filter((item) => item.id !== id);
                this.isDeleteModalOpen = false;
                if (callback) callback(data.message);
            }
        } catch (err) {
            console.error("Delete Error:", err);
        }
    },

    reinitUI() {
        this.$nextTick(() => {
            if (window.HSStaticMethods) window.HSStaticMethods.autoInit();
        });
    },
});
