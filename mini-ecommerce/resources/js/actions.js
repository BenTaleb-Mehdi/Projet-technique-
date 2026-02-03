import { showAlert } from './alearts.js';

document.addEventListener('alpine:init', () => {
    const config = window.adminConfig || {};
    Alpine.data('productManager', (config = {}) => ({
        // --- 1. STATE ---
        products: config.initialProducts || [],
        paginationHtml: config.initialPagination || '',
        isProductModalOpen: false,
        isDeleteModalOpen: false,
        idToDelete: null,
        search: '',
        category: '',
        isLoading: false,
        mode: 'create', // 'create' or 'edit'
        currentId: null,
        
        // --- 2. INIT ---
// Add a console log to see if data is actually arriving
init() {
    console.log("Config detected:", window.adminConfig); 

    if (window.adminConfig) {
        // Force assignment and ensure it's an array
        this.products = Array.isArray(window.adminConfig.initialProducts) 
            ? window.adminConfig.initialProducts 
            : [];
            
        this.paginationHtml = window.adminConfig.initialPagination || '';
    }

    this.$watch('search', () => this.fetchProducts());
    this.$watch('category', () => this.fetchProducts());

    this.$nextTick(() => {
        if (window.createLucideIcons) window.createLucideIcons();
    });
    
},


        // --- 3. FETCHING (Search & Filter) ---
        fetchProducts() {
            const baseUrl = config.indexUrl || '/admin';
            const finalUrl = `${baseUrl}?search=${encodeURIComponent(this.search)}&category_id=${this.category}`;
            
            this.isLoading = true;
            fetch(finalUrl, {
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.products = data.products;
                this.paginationHtml = data.pagination;
                this.$nextTick(() => {
                    if (window.createLucideIcons) window.createLucideIcons();
                });
            })
            .catch(err => console.error('Fetch products failed:', err))
            .finally(() => this.isLoading = false);
        },

        // --- 4. CRUD OPERATIONS ---

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

        editProduct(product) {
            this.mode = 'edit';
            this.currentId = product.id;
            this.isProductModalOpen = true;

            const form = document.getElementById('productForm');
            if (form) form.reset();

            document.getElementById('productId').value = product.id;
            document.getElementById('productName').value = product.name;
            document.getElementById('productPrice').value = product.price;
            document.getElementById('productDescription').value = product.description;

            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn && window.translations) submitBtn.innerText = window.translations.edit;

            const imagePreview = document.getElementById('imagePreview');
            const previewContainer = document.getElementById('previewContainer');
            if (product.image_url && imagePreview && previewContainer) {
                imagePreview.src = `/images/${product.image_url}`;
                previewContainer.classList.remove('hidden');
            } else {
                this.hidePreview();
            }

            const selectedIds = product.categories.map(c => c.id);
            this.resetCategorySelect(selectedIds);
            
            if (window.createLucideIcons) window.createLucideIcons();
        },

        async saveProduct(e) {
            const form = e.target;
            const submitBtn = form.querySelector('[type=\"submit\"]');
            if (submitBtn) submitBtn.disabled = true;

            const formData = new FormData(form);
            let url = form.dataset.storeUrl;
            let method = 'POST';

            if (this.mode === 'edit') {
                url = `/admin/products/${this.currentId}`;
                formData.append('_method', 'PUT');
            }

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                if (response.ok) {
                    const product = await response.json();

                    if (this.mode === 'edit') {
                        const index = this.products.findIndex(p => p.id === this.currentId);
                        if (index !== -1) {
                            this.products[index] = product;
                        }
                        if (window.translations) showAlert(window.translations.product_updated);
                    } else {
                        this.products.unshift(product);
                        if (window.translations) showAlert(window.translations.product_added);
                    }

                    this.closeModalAndReset();
                    this.$nextTick(() => {
                        if (window.createLucideIcons) window.createLucideIcons();
                    });
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

        confirmDelete(id) {
            this.idToDelete = id;
            this.isDeleteModalOpen = true;
        },

        deleteProduct() {
            if (!this.idToDelete) return;

            fetch(`/admin/products/${this.idToDelete}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    this.products = this.products.filter(p => p.id !== this.idToDelete);
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

        resetFilter() {
            this.category = '';
            if (window.HSSelect) {
                const inst = HSSelect.getInstance('#categoryFilter');
                if (inst) inst.setValue('');
            }
        },

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

            if (window.HSSelect) {
                const instance = HSSelect.getInstance(select);
                if (instance) instance.destroy();
                new HSSelect(select);
            }
        },
        // --- ADD THESE TO YOUR productManager OBJECT ---

handlePagination(e) {
    const link = e.target.closest('a');
    if (!link || !link.href) return;

    e.preventDefault(); // Stop page reload
    this.fetchPage(link.href);
},

fetchPage(url) {
    this.isLoading = true;
    
    fetch(url, {
        headers: { 
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        this.products = data.products;
        this.paginationHtml = data.pagination;
        
        // Refresh icons and scroll to top
        this.$nextTick(() => {
            if (window.createLucideIcons) window.createLucideIcons();
            document.getElementById('content').scrollIntoView({ behavior: 'smooth' });
        });
    })
    .catch(err => console.error('Pagination Error:', err))
    .finally(() => this.isLoading = false);
}
    }));
});
