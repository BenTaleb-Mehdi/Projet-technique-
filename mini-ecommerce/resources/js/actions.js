import { showAlert } from './alearts';
// Translations
 window.translations = {
               product_updated: "{{ __('actions.product_updated') }}",
               product_added: "{{ __('actions.product_added') }}",
               product_deleted: "{{ __('actions.product_deleted') }}",
               confirm_delete: "{{ __('actions.confirm_delete') }}",
               error_occurred: "{{ __('actions.error_occurred') }}",
               validation_error: "{{ __('actions.validation_error') }}",
               server_error: "{{ __('actions.server_error') }}",
               add: "{{ __('actions.add') }}",
               edit: "{{ __('actions.edit') }}",
           };


// --- 1. VARIABLES & ELEMENTS ---
let mode = "create";
let currentId = null;
let searchTimeout;

const form = document.getElementById("productForm");
const tableBody = document.getElementById("product-table-body");
const submitBtn = document.getElementById("submitBtn");
const searchInput = document.getElementById("productSearch");
const categoryFilter = document.getElementById("categoryFilter");
const imageInput = document.getElementById("af-submit-app-upload-images");
const imagePreview = document.getElementById("imagePreview");
const previewContainer = document.getElementById("previewContainer");

// --- 2. MAIN FORM SUBMIT ---
if (form) {
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        submitBtn.disabled = true;

        const formData = new FormData(form);

        // Decide URL and Method based on mode
        let url = form.dataset.storeUrl;
        let method = "POST";

        if (mode === "edit") {
            url = `/admin/products/${currentId}`;
            formData.append("_method", "PUT"); // Laravel trick
        }

        saveProduct(url, method, formData);
    });
}

// --- 3. SAVE FUNCTION (Create & Edit) ---
async function saveProduct(url, method, formData) {
    try {
        const response = await fetch(url, {
            method: "POST", // Always POST for FormData (Laravel handles PUT via _method)
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
                "X-Requested-With": "XMLHttpRequest",
                Accept: "text/html",
            },
            body: formData,
        });

        if (response.ok) {
            const html = await response.text();

            if (mode === "edit") {
                document.getElementById(`row-${currentId}`).outerHTML = html;
                showAlert(window.translations.product_updated);
            } else {
                tableBody.insertAdjacentHTML("afterbegin", html);
                showAlert(window.translations.product_added);
            }

            closeModalAndReset();
        } else {
            handleError(response);
        }
    } catch (error) {
        console.error(error);
        showAlert(window.translations.error_occurred, "error");
    } finally {
        submitBtn.disabled = false;
    }
}

// --- 4. DELETE FUNCTION ---
window.deleteProduct = async function (id) {
    if (!confirm(window.translations.confirm_delete)) return;

    try {
        const response = await fetch(`/admin/products/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        if (response.ok) {
            if (row) row.remove();
            showAlert(window.translations.product_deleted);
        } else {
           showAlert(window.translations.error_occurred, "error");
        }
    } catch (error) {
        console.error(error);
    }
};

// --- 5. SEARCH & FILTER ---
function fetchProducts() {
    const url = searchInput.dataset.url || "/admin";
    const search = searchInput.value;
    const category = categoryFilter.value;

    // Build URL: /admin?search=abc&category_id=1
    const finalUrl = `${url}?search=${search}&category_id=${category}`;

    fetch(finalUrl, {
         headers: { "X-Requested-With": "XMLHttpRequest" } 
        })
        .then((response) => response.text())
        .then((html) => {
            tableBody.innerHTML = html;
            // Reload icons if needed
            if (window.createLucideIcons) window.createLucideIcons();
        });
}

if (searchInput) {
    searchInput.addEventListener("input", function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(fetchProducts, 300);
    });
}

if (categoryFilter) {
    categoryFilter.addEventListener("change", fetchProducts);
}

window.resetCategoryFilter = function () {
    const select = document.getElementById("categoryFilter");
    if (!select) return;

    // 1. Reje3 l-valeur l khawa (vaut "")
    select.value = "";

    // 2. Ila knti khdam b Preline HSSelect, khassna n-updatew l-interface
    if (window.HSSelect) {
        const instance = HSSelect.getInstance(select);
        if (instance) {
            // Reje3 selection l-placeholder
            instance.setValue("");
        }
    }

    // 3. Dir l-appel l fetchProducts bach y-reje3 lina ga3 l-produits
    fetchProducts();
};
// --- 6. UTILITIES & UI ---

// Reset Form (Create Mode)
window.openCreateModal = function () {
    form.reset();
    mode = "create";
    currentId = null;
    submitBtn.innerText = window.translations.add;
    hidePreview();
    resetCategorySelect([]);
};

// Fill Form (Edit Mode)
window.editProduct = function (product) {
    form.reset();
    mode = "edit";
    currentId = product.id;
    submitBtn.innerText = window.translations.edit;

    // Simple value assignment
    document.getElementById("productName").value = product.name;
    document.getElementById("productPrice").value = product.price;
    document.getElementById("productDescription").value = product.description;

    // Handle Image
    if (product.image_url) {
        imagePreview.src = `/images/${product.image_url}`;
        previewContainer.classList.remove("hidden");
    } else {
        hidePreview();
    }

    // Handle Categories
    const ids = product.categories.map(function (c) {
        return c.id;
    });
    resetCategorySelect(ids);
};

function closeModalAndReset() {
    window.openCreateModal(); // Resets vars
    const modal = document.getElementById("hs-danger-alert");
    if (window.HSOverlay) HSOverlay.close(modal);
    if (window.createLucideIcons) window.createLucideIcons();
}

function hidePreview() {
    imagePreview.src = "";
    previewContainer.classList.add("hidden");
}

function handleError(response) {
    if (response.status === 422) {
        response.json().then((data) => {
            alert(window.translations.validation_error);
        });
    } else {
        alert(window.translations.server_error + " " + response.status);
    }
}

// Image Preview Listener
if (imageInput) {
    imageInput.addEventListener("change", function (e) {
        const file = e.target.files[0];
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            previewContainer.classList.remove("hidden");
        }
    });
}

// Helper to handle the UI Library Select
function resetCategorySelect(ids) {
    const select = document.getElementById("categorySelect");
    if (!select) return;

    for (let i = 0; i < select.options.length; i++) {
        const option = select.options[i];
        option.selected = ids.includes(parseInt(option.value));
    }

    // Refresh UI Library (Preline UI)
    if (window.HSSelect) {
        const instance = HSSelect.getInstance(select);
        if (instance) instance.destroy();
        new HSSelect(select);
    }
}
