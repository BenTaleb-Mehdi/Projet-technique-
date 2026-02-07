export const productService = {
    async fetch(url, search = '', category = '') {
        const fetchUrl = new URL(url, window.location.origin);
        
        if (search) fetchUrl.searchParams.set('search', search);
        if (category) fetchUrl.searchParams.set('category_id', category);

        const response = await fetch(fetchUrl.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        return response.json();
    },

    async save(mode, currentId, storeUrl, formData) {
        // Laravel needs _method=PUT for multipart/form-data (images) to work with PUT
        let url = storeUrl;
        if (mode === 'edit') {
            url = `/admin/products/${currentId}`;
            formData.append('_method', 'PUT');
        }

        return fetch(url, {
            method: 'POST', // Always POST, Laravel reads _method
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData,
        });
    },

    async delete(id) {
        return fetch(`/admin/products/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Accept': 'application/json'
            }
        });
    }
};