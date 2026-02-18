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
    allCategories: (config.categories || []).map((c) => ({
        id: c.id,
        text: c.label,
    })),
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
            if (data.categories) {
                this.allCategories = data.categories.map((c) => ({
                    id: c.id,
                    text: c.label,
                }));
                this.reinitSelect(); // Refresh UI after data load
            }
        }
    },

    openCreateModal() {
        this.mode = "create";
        this.currentId = null;
        this.isProductModalOpen = true;
        this.resetForm();
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

            // Sync Categories
            const selectEl = document.getElementById("categorySelect");
            if (selectEl && product.categories) {
                const selectedIds = product.categories.map((c) => String(c.id));
                Array.from(selectEl.options).forEach((opt) => {
                    opt.selected = selectedIds.includes(String(opt.value));
                });
            }

            // Sync Image Preview
            const preview = document.getElementById("imagePreview");
            const container = document.getElementById("previewContainer");
            if (product.image_url) {
                preview.src = "/images/" + product.image_url;
                container.classList.remove("hidden");
            } else {
                container.classList.add("hidden");
            }

            this.reinitUI(); // From baseLogic
            this.reinitSelect(); // Refresh Select UI specifically
        });
    },

    reinitSelect() {
        this.$nextTick(() => {
            const selectEl = document.getElementById("categorySelect");
            if (selectEl && window.HSSelect) {
                const instance = window.HSSelect.getInstance(selectEl, true);
                if (instance) {
                    instance.reinit();
                } else {
                    window.HSSelect.autoInit();
                }
            }
        });
    },

    resetForm() {
        const form = document.getElementById("productForm");
        if (form) form.reset();

        // Clear Select UI
        const selectEl = document.getElementById("categorySelect");
        if (selectEl) {
            Array.from(selectEl.options).forEach(
                (opt) => (opt.selected = false),
            );
            this.reinitSelect();
        }

        document.getElementById("previewContainer").classList.add("hidden");
        this.errors = {};
    },

    confirmDelete(id) {
        this.idToDelete = id;
        this.isDeleteModalOpen = true;
    },

    async deleteProduct() {
        if (!this.idToDelete) return;
        
        await this.performDelete(this.idToDelete, (message) => {
            showAlert(message || 'Product deleted successfully');
            this.loadProducts();
        });
        
        this.idToDelete = null;
    },

    handleImageChange(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = document.getElementById("imagePreview");
                preview.src = e.target.result;
                document
                    .getElementById("previewContainer")
                    .classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        }
    },
});
