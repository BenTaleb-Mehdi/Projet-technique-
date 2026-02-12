import { baseLogic } from "./baseComponent.js";
import { showAlert } from "./alerts.js";

const productService = {
    async fetch(url, search, params) {
        const fetchUrl = new URL(url, window.location.origin);
        if (search) fetchUrl.searchParams.set("search", search);
        if (params.category_id)
            fetchUrl.searchParams.set("category_id", params.category_id);

        const response = await fetch(fetchUrl.toString(), {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        });
        return response.json();
    },

    async save(mode, id, storeUrl, formData) {
        let url = mode === "edit" ? `/admin/products/${id}` : storeUrl;
        if (mode === "edit") formData.append("_method", "PUT");

        return fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                )?.content,
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
            body: formData,
        });
    },

    async delete(id) {
        return fetch(`/admin/products/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                )?.content,
                Accept: "application/json",
            },
        });
    },
};

export default (config = {}) => ({
    ...baseLogic(productService),

    products: [],
    allCategories: (config.categories || []).map(c => ({ id: c.id, text: c.label })),
    category: "",
    isProductModalOpen: false,
    mode: "create",
    currentId: null,

    init() {
        this.indexUrl = this.$root.dataset.url;
        this.loadProducts();

        this.$watch("search", () => this.loadProducts());
        this.$watch("category", () => this.loadProducts());
    },

    async loadProducts(url = null) {
        const data = await this.fetchData(url, { category_id: this.category });
        if (data) {
            this.products = this.items;
            if (data.categories) this.allCategories = data.categories.map(c => ({ id: c.id, text: c.label }));
        }
    },

    openCreateModal() {
        this.mode = "create";
        this.currentId = null;
        this.isProductModalOpen = true;
        this.resetForm();
        this.reinitUI();
        this.reinitSelect();
    },

    async saveProduct(e) {
        const res = await productService.save(
            this.mode,
            this.currentId,
            e.target.dataset.storeUrl,
            new FormData(e.target),
        );
        const data = await res.json();

        if (res.ok) {
            this.loadProducts();
            this.isProductModalOpen = false;
            showAlert(data.message || "Success");
        } else {
            this.errors = data.errors || {};
            showAlert(data.message || "Validation Error", "error");
        }
    },

    editProduct(product) {
    this.mode = "edit";
    this.currentId = product.id;
    this.isProductModalOpen = true;
    this.errors = {};

    this.$nextTick(() => {
        const form = document.getElementById("productForm");
        form.name.value = product.name;
        form.price.value = product.price;
        form.description.value = product.description || "";

        // --- ADD THIS FOR CATEGORIES ---
        const selectEl = document.getElementById("categorySelect");
        if (selectEl && product.categories) {
            // Get array of IDs from the product
            const selectedIds = product.categories.map(c => String(c.id));
            
            // Mark the options as selected in the hidden native select
            Array.from(selectEl.options).forEach(opt => {
                opt.selected = selectedIds.includes(String(opt.value));
            });

            // Tell Preline to refresh the UI to show the checkmarks
            if (window.HSSelect) {
                window.HSSelect.getInstance(selectEl, true).reinit();
            }
        }
        // -------------------------------

        const preview = document.getElementById("imagePreview");
        if (product.image_url) {
            preview.src = "/images/" + product.image_url;
            document.getElementById("previewContainer").classList.remove("hidden");
        }
        this.reinitUI();
        this.reinitSelect();
    });
},

    reinitSelect() {
        this.$nextTick(() => {
            const selectEl = document.getElementById("categorySelect");
            if (selectEl && window.HSSelect) {
                const instance = window.HSSelect.getInstance(selectEl, true);
                if (instance) {
                    instance.reinit();
                }
            }
        });
    },

    confirmDelete(id) {
        this.idToDelete = id;
        this.isDeleteModalOpen = true;
    },

    deleteProduct() {
        this.performDelete(this.idToDelete, (msg) => {
            this.products = this.items;
            showAlert(msg);
        });
    },

    resetForm() {
        const form = document.getElementById("productForm");
        if (form) form.reset();
        document.getElementById("previewContainer").classList.add("hidden");
        this.errors = {};
    },
    selectAllCategories() {
    const selectEl = document.getElementById('categorySelect');
    if (!selectEl) return;

    // Select every option
    Array.from(selectEl.options).forEach(opt => opt.selected = true);

    // Refresh Preline
    if (window.HSSelect) {
        window.HSSelect.getInstance(selectEl, true).reinit();
    }
},
});
