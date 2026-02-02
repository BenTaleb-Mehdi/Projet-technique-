import { showAlert } from './alearts.js';

document.addEventListener('alpine:init', () => {
    Alpine.data('productManager', (config = {}) => ({
        // --- 1. STATE ---
        isProductModalOpen: false,
        isDeleteModalOpen: false,
        idToDelete: null,
        search: '',
        category: '',
        isLoading: false,
        mode: 'create', // 'create' or 'edit'
        currentId: null,
        
        // --- 2. INIT ---
        init() {
            // Watchers for reactive fetching (Search & Category)
            this.$watch('search', () => this.fetchProducts());
            this.$watch('category', () => this.fetchProducts());
            
            // Initial Lucide Icons
            if (window.createLucideIcons) window.createLucideIcons();

            // Sync with Preline HSSelect (Dynamic Select UI)
            this.$nextTick(() => {
                const filterSelect = document.getElementById('categoryFilter');
                if (filterSelect) {
                    filterSelect.addEventListener('change', (e) => {
                        this.category = e.target.value;
                    });
                }
            });
        },

        // --- 3. FETCHING (Search & Filter) ---
        fetchProducts() {
            const baseUrl = config.indexUrl || '/admin';
            const finalUrl = `${baseUrl}?search=${encodeURIComponent(this.search)}&category_id=${this.category}`;
            
            this.isLoading = true;
            fetch(finalUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                const tableBody = document.getElementById('product-table-body');
                if (tableBody) tableBody.innerHTML = html;
                if (window.createLucideIcons) window.createLucideIcons();
            })
            .catch(err => console.error('Fetch products failed:', err))
            .finally(() => this.isLoading = false);
        },

        // --- 4. CRUD OPERATIONS ---

        // Open Create Modal
        openCreateModal() {
            this.mode = 'create';
            this.currentId = null;
            this.isProductModalOpen = true;
            
            const form = document.getElementById('productForm');
            if (form) form.reset();
            
            const pidField = document.getElementById('productId');
            if (pidField) pidField.value = '';
            
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn && window.translations) submitBtn.innerText = window.translations.add;
            
            this.hidePreview();
            this.resetCategorySelect([]);
            
            if (window.createLucideIcons) window.createLucideIcons();
        },

        // Open Edit Modal
        editProduct(product) {
            this.mode = 'edit';
            this.currentId = product.id;
            this.isProductModalOpen = true;

            const form = document.getElementById('productForm');
            if (form) form.reset();

            // Populate Fields
            document.getElementById('productId').value = product.id;
            document.getElementById('productName').value = product.name;
            document.getElementById('productPrice').value = product.price;
            document.getElementById('productDescription').value = product.description;

            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn && window.translations) submitBtn.innerText = window.translations.edit;

            // Handle Image Preview
            const imagePreview = document.getElementById('imagePreview');
            const previewContainer = document.getElementById('previewContainer');
            if (product.image_url && imagePreview && previewContainer) {
                imagePreview.src = `/images/${product.image_url}`;
                previewContainer.classList.remove('hidden');
            } else {
                this.hidePreview();
            }

            // Handle Categories
            const selectedIds = product.categories.map(c => c.id);
            this.resetCategorySelect(selectedIds);
            
            if (window.createLucideIcons) window.createLucideIcons();
        },

        // Save Product (Create/Update)
        async saveProduct(e) {
            const form = e.target;
            const submitBtn = form.querySelector('[type=\"submit\"]');
            if (submitBtn) submitBtn.disabled = true;

            const formData = new FormData(form);
            let url = form.dataset.storeUrl;
            let method = 'POST';

            if (this.mode === 'edit') {
                url = `/admin/products/${this.currentId}`;
                formData.append('_method', 'PUT'); // Laravel Method Spoofing
            }

            try {
                const response = await fetch(url, {
                    method: 'POST', // Always POST for FormData uploads
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html',
                    },
                    body: formData,
                });

                if (response.ok) {
                    const html = await response.text();
                    const tableBody = document.getElementById('product-table-body');

                    if (this.mode === 'edit') {
                        const row = document.getElementById(`row-${this.currentId}`);
                        if (row) row.outerHTML = html;
                        if (window.translations) showAlert(window.translations.product_updated);
                    } else {
                        if (tableBody) tableBody.insertAdjacentHTML('afterbegin', html);
                        if (window.translations) showAlert(window.translations.product_added);
                    }

                    this.closeModalAndReset();
                } else {
                    this.handleError(response);
                }
            } catch (error) {
                console.error(error);
                if (window.translations) showAlert(window.translations.error_occurred, 'error');
            } finally {
                if (submitBtn) submitBtn.disabled = false;
            }
        },

        // Delete Product
        deleteProduct() {
            if (!this.idToDelete) return;

            fetch(`/admin/products/${this.idToDelete}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    const row = document.getElementById(`row-${this.idToDelete}`);
                    if (row) row.remove();
                    if (window.showAlert) showAlert(window.translations.product_deleted);
                } else {
                    if (window.showAlert) showAlert(window.translations.error_occurred, 'error');
                }
            })
            .finally(() => {
                this.isDeleteModalOpen = false;
                this.idToDelete = null;
            });
        },

        // Confirm Delete (Open Modal)
        confirmDelete(id) {
            this.idToDelete = id;
            this.isDeleteModalOpen = true;
        },

        // Reset Category Filter
        resetFilter() {
            this.category = '';
            if (window.HSSelect) {
                const inst = HSSelect.getInstance('#categoryFilter');
                if (inst) inst.setValue('');
            }
        },

        // --- 5. HELPERS ---

        // Handle Image Input Change
        handleImageChange(e) {
            const file = e.target.files[0];
            const imagePreview = document.getElementById('imagePreview');
            const previewContainer = document.getElementById('previewContainer');
            if (file && imagePreview && previewContainer) {
                imagePreview.src = URL.createObjectURL(file);
                previewContainer.classList.remove('hidden');
            }
        },

        // --- 5. HELPERS ---

        closeModalAndReset() {
            this.isProductModalOpen = false;
            const form = document.getElementById('productForm');
            if (form) form.reset();
            this.hidePreview();
            this.resetCategorySelect([]);
            if (window.createLucideIcons) window.createLucideIcons();
        },

        hidePreview() {
            const imagePreview = document.getElementById('imagePreview');
            const previewContainer = document.getElementById('previewContainer');
            if (imagePreview) imagePreview.src = '';
            if (previewContainer) previewContainer.classList.add('hidden');
        },

        handleError(response) {
            if (response.status === 422) {
                response.json().then(data => {
                    const message = data.message || (window.translations ? window.translations.validation_error : 'Validation Error');
                    showAlert(message, 'error');
                });
            } else {
                const errorMsg = (window.translations ? window.translations.server_error : 'Server Error') + ' ' + response.status;
                showAlert(errorMsg, 'error');
            }
        },

        resetCategorySelect(ids) {
            const select = document.getElementById('categorySelect');
            if (!select) return;

            for (let i = 0; i < select.options.length; i++) {
                const option = select.options[i];
                option.selected = ids.includes(parseInt(option.value));
            }

            // Refresh Preline HSSelect if exists
            if (window.HSSelect) {
                const instance = HSSelect.getInstance(select);
                if (instance) instance.destroy();
                new HSSelect(select);
            }
        }
    }));
});
