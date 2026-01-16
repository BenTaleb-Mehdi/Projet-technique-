let isEditing = false;
let currentProductId = null;

const productForm = document.getElementById("productForm");
const productBody = document.getElementById("product-table-body");
const methodField = document.getElementById("methodField");
const submitBtn = document.getElementById("submitBtn");

// --- 1. MODAL CONTROL (Open for Create/Edit) ---
function openProductModal(product = null) {
    isEditing = !!product;
    currentProductId = product?.id || null;

    productForm.reset();

    if (isEditing) {
        methodField.value = "PUT";
        submitBtn.innerText = "Modifier";
        // Remplissage rapide
        document.getElementById("productName").value = product.name;
        document.getElementById("productPrice").value = product.price;
        document.getElementById("productDescription").value =
            product.description;
    } else {
        methodField.value = "POST";
        submitBtn.innerText = "Ajouter";
    }

    if (window.HSOverlay)
        HSOverlay.open(document.querySelector("#hs-danger-alert"));
}

// --- 2. SUBMIT (Create & Update) ---
productForm?.addEventListener("submit", async (e) => {
    e.preventDefault();

    const url = isEditing
        ? `/admin/products/${currentProductId}`
        : productForm.dataset.storeUrl;

    try {
        const response = await fetch(url, {
            method: "POST", // Laravel reads _method (PUT/POST)
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "text/html",
            },
            body: new FormData(productForm),
        });

        if (response.ok) {
            const htmlRow = await response.text();

            if (isEditing) {
                document.getElementById(`row-${currentProductId}`).outerHTML =
                    htmlRow;
            } else {
                productBody.insertAdjacentHTML("afterbegin", htmlRow);
            }

            productForm.reset();
            if (window.HSOverlay)
                HSOverlay.close(document.querySelector("#hs-danger-alert"));
            if (window.lucide) lucide.createIcons();
        }
    } catch (error) {
        console.error("Error:", error);
    }
});

// --- 3. SEARCH (Debounce) ---
let timer;
document.getElementById("productSearch")?.addEventListener("input", (e) => {
    clearTimeout(timer);
    timer = setTimeout(async () => {
        const url = e.target.dataset.url;
        const response = await fetch(`${url}?search=${e.target.value}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        });
        productBody.innerHTML = await response.text();
        if (window.lucide) lucide.createIcons();
    }, 300);
});

// Expose functions to global scope for HTML onclick access
window.openCreateModal = function() {
    openProductModal(null);
};

window.editProduct = function(product) {
    openProductModal(product);
};
