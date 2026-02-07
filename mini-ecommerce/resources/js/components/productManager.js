import { productService } from '../services/productService.js';
import { showAlert } from './alerts.js';

export default () => ({
    products: [],
    paginationHtml: '',
    isProductModalOpen: false,
    isDeleteModalOpen: false,
    idToDelete: null,
    search: '',
    category: '',
    isLoading: false,
    mode: 'create',
    currentId: null,
    indexUrl: '',
    errors: {},
    allCategories: [],

    init() {
        this.indexUrl = this.$root.dataset.url;
        this.fetchProducts();
        
        this.$watch('search', () => this.fetchProducts());
        this.$watch('category', () => this.fetchProducts());
        this.refreshIcons();
    },

    async fetchProducts(url = null) {
        this.isLoading = true;
        try {
            const fetchUrl = url || this.indexUrl;
            const data = await productService.fetch(fetchUrl, this.search, this.category);
            this.products = data.products;
            this.allCategories = data.categories || [];
            this.paginationHtml = data.pagination;
            this.refreshIcons();
        } catch (err) {
            console.error(err);
        } finally {
            this.isLoading = false;
        }
    },

    changePage(url) {
        if (!url) return;
        this.fetchProducts(url);
    },

    openCreateModal() {
        this.mode = 'create';
        this.currentId = null;
        this.isProductModalOpen = true;
        this.resetForm();
        
        // Re-initialize Preline UI components
        this.$nextTick(() => {
            if (window.HSStaticMethods) {
                window.HSStaticMethods.autoInit();
            }
        });
    },

    editProduct(product) {
        this.mode = 'edit';
        this.currentId = product.id;
        this.isProductModalOpen = true;
        this.errors = {}; // Clear errors when opening edit
        
        this.$nextTick(() => {
            const form = document.getElementById('productForm');
            form.querySelector('[name="name"]').value = product.name;
            form.querySelector('[name="price"]').value = product.price;
            form.querySelector('[name="description"]').value = product.description || '';
            
            // Handle Image Preview
            const preview = document.getElementById('imagePreview');
            const container = document.getElementById('previewContainer');
            if (product.image_url) {
                preview.src = '/images/' + product.image_url;
                container.classList.remove('hidden');
            }

            // Sync Multi-select Categories
            const categoryIds = product.categories.map(c => String(c.id));
            this.syncCategories(categoryIds);

            // Re-initialize Preline UI components
            if (window.HSStaticMethods) {
                window.HSStaticMethods.autoInit();
            }
        });
    },

    async saveProduct(e) {
        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = document.getElementById('submitBtn');
        
        if (submitBtn) submitBtn.disabled = true;
        this.errors = {}; // Clear previous errors

        try {
            const res = await productService.save(this.mode, this.currentId, form.dataset.storeUrl, formData);
            const data = await res.json();

            if (res.ok) {
                // Refresh list to show new/updated data
                this.fetchProducts();
                
                showAlert(data.message || 'Success');
                this.isProductModalOpen = false;
            } else {
                if (res.status === 422 && data.errors) {
                    this.errors = data.errors;
                }
                showAlert(data.message || "Validation Error", 'error');
            }
        } catch (err) {
            showAlert("An error occurred", 'error');
        } finally {
            if (submitBtn) submitBtn.disabled = false;
        }
    },

    confirmDelete(id) {
        this.idToDelete = id;
        this.isDeleteModalOpen = true;
    },

    async deleteProduct() {
        try {
            const res = await productService.delete(this.idToDelete);
            const data = await res.json();

            if (res.ok) {
                this.products = this.products.filter(p => p.id !== this.idToDelete);
                this.isDeleteModalOpen = false;
                showAlert(data.message || 'Deleted successfully');
            }
        } catch (err) {
            showAlert("Delete failed", 'error');
        }
    },

    // UI Helpers
    handleImageChange(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (ex) => {
                document.getElementById('imagePreview').src = ex.target.result;
                document.getElementById('previewContainer').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    },

    resetForm() {
        const form = document.getElementById('productForm');
        if (form) form.reset();
        document.getElementById('previewContainer').classList.add('hidden');
        this.syncCategories([]);
        this.errors = {};
    },

    syncCategories(ids) {
        const select = document.getElementById('categorySelect');
        if (select && window.HSSelect) {
            const instance = HSSelect.getInstance(select);
            if (instance) instance.setValue(ids);
        }
    },

    refreshIcons() {
        this.$nextTick(() => window.createLucideIcons?.());
    }
});
