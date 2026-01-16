// --- VARIABLES GLOBALES ---
let mode = 'create'; // 'create' or 'edit'
let currentProductId = null;
let timer;

// DOM Elements
const form = document.getElementById("productForm");
const productBody = document.getElementById("product-table-body");
const submitBtn = document.getElementById("submitBtn");
const methodField = document.getElementById("methodField");
const searchInput = document.getElementById("productSearch");
const categoryFilter = document.getElementById("categoryFilter");
const imageInput = document.getElementById("af-submit-app-upload-images");
const modalOverlay = document.getElementById("hs-danger-alert");

// --- 1. GESTION DU SUBMIT (Routeur) ---
if (form) {
    form.addEventListener("submit", function(e) {
        e.preventDefault();

        // Disable button to prevent double-submit
        submitBtn.disabled = true;

        const formData = new FormData(form);

        if (mode === 'create') {
            insertProduct(formData);
        } else {
            updateProduct(currentProductId, formData);
        }
    });
}

// --- 2. FONCTIONS CRUD ---

// Insert Product (POST)
// Insert Product (POST)
async function insertProduct(formData) {
    const url = form.dataset.storeUrl;
    console.log("Adding Product to URL:", url);
    console.log("Data:", Object.fromEntries(formData)); // Debug info

    try {
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "X-Requested-With": "XMLHttpRequest",
                Accept: "text/html",
            },
            body: formData,
        });

        console.log("Response Status:", response.status);
        await handleResponse(response, 'create');
    } catch (error) {
        console.error("Insert Error:", error);
        alert("Erreur JS lors de l'ajout (voir console).");
    } finally {
        submitBtn.disabled = false;
    }
}

// Update Product (PUT/POST logic)
async function updateProduct(id, formData) {
    const url = `/admin/products/${id}`;

    try {
        const response = await fetch(url, {
            method: "POST", // Laravel spoofing used via _method field
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "X-Requested-With": "XMLHttpRequest",
                Accept: "text/html",
            },
            body: formData,
        });

        await handleResponse(response, 'update');
    } catch (error) {
        console.error("Update Error:", error);
    } finally {
        submitBtn.disabled = false;
    }
}

// Shared Response Handler
async function handleResponse(response, action) {
    if (response.ok) {
        const htmlRow = await response.text();

        if (action === 'update') {
            document.getElementById(`row-${currentProductId}`).outerHTML = htmlRow;
            alert("Produit modifié avec succès !");
        } else {
            productBody.insertAdjacentHTML("afterbegin", htmlRow);
             alert("Produit ajouté avec succès !");
        }

        resetForm();
        
        if (window.HSOverlay) HSOverlay.close(modalOverlay);
        if (window.createLucideIcons) window.createLucideIcons();
    } else {
        handleError(response);
    }
}

// Error Handler
async function handleError(response) {
    console.error("Server Error:", response.status, response.statusText);
    
    if (response.status === 422) {
        const data = await response.json();
        let messages = "Erreur de validation:\n";
        for (const [key, errors] of Object.entries(data.errors)) {
            messages += `- ${errors.join(', ')}\n`;
        }
        alert(messages);
    } else {
        const errorText = await response.text();
        console.error("Response Body:", errorText);
        alert(`Une erreur est survenue (${response.status}). Vérifiez la console.`);
    }
}

// --- 3. GESTION DE L'INTERFACE (Reset / Prepare) ---

// Reset Form (pour Create)
function resetForm() {
    form.reset();
    mode = 'create';
    currentProductId = null;
    methodField.value = "POST";
    submitBtn.innerText = "Ajouter";

    // Reset Image Preview
    const previewContainer = document.getElementById("previewContainer");
    const imagePreview = document.getElementById("imagePreview");
    if (previewContainer && imagePreview) {
        imagePreview.src = "";
        previewContainer.classList.add("hidden");
    }

    // Reset Select
    resetCategorySelect([]);
}

// Prepare Edit (pour Update)
function prepareEdit(product) {
    resetForm(); // Clean inputs first
    
    mode = 'edit';
    currentProductId = product.id;
    methodField.value = "PUT";
    submitBtn.innerText = "Modifier";

    // Fill Inputs
    document.getElementById("productName").value = product.name;
    document.getElementById("productPrice").value = product.price;
    document.getElementById("productDescription").value = product.description;

    // Fill Image Preview
    if (product.image_url) {
        const previewContainer = document.getElementById("previewContainer");
        const imagePreview = document.getElementById("imagePreview");
        if (previewContainer && imagePreview) {
            imagePreview.src = `/images/${product.image_url}`;
            previewContainer.classList.remove("hidden");
        }
    }

    // Fill Categories
    if (product.categories) {
        const categoryIds = product.categories.map(c => c.id);
        resetCategorySelect(categoryIds);
    }
}

function resetCategorySelect(selectedIds = []) {
    const select = document.getElementById("categorySelect");
    if (!select) return;

    Array.from(select.options).forEach(opt => {
        opt.selected = selectedIds.includes(parseInt(opt.value));
    });

    if (window.HSSelect) {
        const instance = HSSelect.getInstance(select);
        if (instance) instance.destroy();
        new HSSelect(select);
    } else {
        select.dispatchEvent(new Event('change', { bubbles: true }));
    }
}


// --- 4. EXPOSED FUNCTIONS (Global Access) ---

window.openCreateModal = function() {
    resetForm();
    // Modal is opened via HTML data attributes, no JS needed for open
};

window.editProduct = function(product) {
    prepareEdit(product);
};

window.deleteProduct = async function(id) {
    if (!confirm("Êtes-vous sûr de vouloir supprimer ce produit ?")) return;

    try {
        const response = await fetch(`/admin/products/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        });

        if (response.ok) {
            const row = document.getElementById(`row-${id}`);
            if (row) row.remove();
            if (window.createLucideIcons) window.createLucideIcons();
             alert("Produit supprimé !");
        } else {
            alert("Erreur lors de la suppression.");
        }
    } catch (error) {
        console.error(error);
        alert("Une erreur est survenue.");
    }
};

// --- 5. SEARCH & FILTER ---

async function fetchProducts() {
    const search = searchInput ? searchInput.value : '';
    const categoryId = categoryFilter ? categoryFilter.value : '';
    const url = searchInput ? searchInput.dataset.url : '/admin';

    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (categoryId) params.append('category_id', categoryId);

    try {
        const response = await fetch(`${url}?${params.toString()}`, {
            headers: { "X-Requested-With": "XMLHttpRequest" }
        });

        if (response.ok) {
            productBody.innerHTML = await response.text();
            if (window.createLucideIcons) window.createLucideIcons();
        }
    } catch (error) {
        console.error("Filter Error:", error);
    }
}

if (searchInput) {
    searchInput.addEventListener("input", (e) => {
        clearTimeout(timer);
        timer = setTimeout(fetchProducts, 300);
    });
}

if (categoryFilter) {
    categoryFilter.addEventListener("change", fetchProducts);
}

// --- 6. UTILS (Image Preview, Modal Close) ---

if (imageInput) {
    imageInput.addEventListener("change", function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewContainer = document.getElementById("previewContainer");
                const imagePreview = document.getElementById("imagePreview");
                if (previewContainer && imagePreview) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove("hidden");
                }
            }
            reader.readAsDataURL(file);
        }
    });
}

if (modalOverlay) {
    modalOverlay.addEventListener("click", function(e) {
        if (e.target === this) {
            if (window.HSOverlay) HSOverlay.close(this);
        }
    });
}
