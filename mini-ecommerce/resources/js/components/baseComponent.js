/**
 * baseComponent.js
 * Hada fih l-logic l-mushtaraka li ghadi t-khdem biha f'ga3 l-modules
 */
export const baseLogic = (service) => ({
    items: [],
    paginationHtml: '',
    isLoading: false,
    search: '',
    indexUrl: '',
    idToDelete: null,
    isDeleteModalOpen: false,
    errors: {},

    // Function dyal Fetching m3a l-Pagination o Search
    async fetchData(url = null, extraParams = {}) {
        this.isLoading = true;
        try {
            const fetchUrl = url || this.indexUrl;
            // Kan-3ayto l-service li ghadi n-passiw f'productManager
            const data = await service.fetch(fetchUrl, this.search, extraParams);
            
            // Kan-stockiw l-data li jatna
            this.items = data.products || data.data || [];
            this.paginationHtml = data.pagination || '';
            
            // Refresh l-icons (Lucide) f-l'interface
            this.$nextTick(() => window.createLucideIcons?.());
            
            return data;
        } catch (err) {
            console.error("Fetch Error:", err);
            return null;
        } finally {
            this.isLoading = false;
        }
    },

    // Logic dyal Delete li kat-te3awed dima
    async performDelete(id, callback) {
        try {
            const res = await service.delete(id);
            const data = await res.json();
            if (res.ok) {
                // Kan-ms-ho l-item mn l-array f-l'front bla ma n-refresh-iw
                this.items = this.items.filter(item => item.id !== id);
                this.isDeleteModalOpen = false;
                if (callback) callback(data.message);
            }
        } catch (err) {
            console.error("Delete Error:", err);
        }
    },

    // Re-initialize Preline UI components
    reinitUI() {
        this.$nextTick(() => {
            if (window.HSStaticMethods) window.HSStaticMethods.autoInit();
        });
    }
});