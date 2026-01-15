let isEditing = false;
let currentProductId = null;
let searchTimer; // Pour le debounce de la recherche

// 1. Ouvrir le modal pour la création
function openCreateModal() {
    isEditing = false;
    currentProductId = null;
    const form = document.getElementById('productForm');
    
    if (form) {
        form.reset();
        // Assurez-vous que l'input caché a le name="_method"
        document.getElementById('methodField').value = 'POST';
        document.getElementById('submitBtn').innerText = 'Créer le Produit';
        
        // Reset des cases à cocher si nécessaire
        document.querySelectorAll('input[name="categories[]"]').forEach(cb => cb.checked = false);
    }
    
    if (window.HSOverlay) {
        HSOverlay.open(document.querySelector('#hs-danger-alert'));
    }
}

// 2. Ouvrir le modal pour l'édition
function editProduct(product) {
    isEditing = true;
    currentProductId = product.id;
    
    const form = document.getElementById('productForm');
    form.reset();
    
    document.getElementById('methodField').value = 'PUT'; 
    document.getElementById('submitBtn').innerText = 'Modifier le Produit';
    
    // Remplissage des champs
    document.getElementById('productName').value = product.name;
    document.getElementById('productPrice').value = product.price;
    document.getElementById('productDescription').value = product.description;
    
    // Gestion des catégories (si présentes dans le JSON)
    if (product.categories) {
        const categoryIds = product.categories.map(c => c.id);
        document.querySelectorAll('input[name="categories[]"]').forEach(cb => {
            cb.checked = categoryIds.includes(parseInt(cb.value));
        });
    }

    if (window.HSOverlay) {
        HSOverlay.open(document.querySelector('#hs-danger-alert'));
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const productForm = document.querySelector('#productForm');
    const tableBody = document.querySelector('#product-table-body');
    const searchInput = document.getElementById('productSearch');
    const categorySelect = document.getElementById('categoryFilter');

    // 3. Gestion de la soumission du formulaire (Create/Update)
    if (productForm) {
        productForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(productForm);

            // URL dynamique selon le mode
            let url = productForm.dataset.storeUrl || '/admin/products';
            if (isEditing && currentProductId) {
                url = `/admin/products/${currentProductId}`; 
            }

            try {
                const response = await fetch(url, {
                    method: "POST", // On reste en POST, Laravel lit le _method dans le FormData
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'text/html' // On attend le HTML de la ligne (row.blade.php)
                    },
                    body: formData
                });

                if (response.ok) {
                    const htmlRow = await response.text();
                    
                    if (isEditing) {
                        const existingRow = document.getElementById(`row-${currentProductId}`);
                        if (existingRow) {
                            existingRow.outerHTML = htmlRow;
                        }
                    } else {
                        tableBody.insertAdjacentHTML('afterbegin', htmlRow);
                    }
                    
                    // Fermer le modal et reset
                    if (window.HSOverlay) HSOverlay.close(document.querySelector('#hs-danger-alert'));
                    productForm.reset();
                    
                    // RÉINITIALISER LES ICÔNES pour la nouvelle ligne
                    if (window.lucide) lucide.createIcons();

                } else {
                    const errorData = await response.json();
                    alert("Erreur: " + (errorData.message || "Impossible d'enregistrer."));
                }
            } catch (error) {
                console.error("Erreur technique:", error);
            }
        });
    }

// ... (reste du code)

    // 4. Gestion de la recherche et du filtrage
    async function fetchProducts() {
        clearTimeout(searchTimer);

        searchTimer = setTimeout(async () => {
            const searchQuery = searchInput ? searchInput.value : '';
            const categoryId = categorySelect ? categorySelect.value : '';
            
            // URL de base depuis l'input de recherche ou le select
            const baseUrl = (searchInput && searchInput.dataset.url) || 
                          (categorySelect && categorySelect.dataset.url) || 
                          '/admin/products';

            // Construction des paramètres URL
            const params = new URLSearchParams();
            if (searchQuery) params.append('search', searchQuery);
            if (categoryId) params.append('category_id', categoryId);

            try {
                const response = await fetch(`${baseUrl}?${params.toString()}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.text();

                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                
                const newTableBody = doc.querySelector('#product-table-body');
                
                if (newTableBody) {
                    tableBody.innerHTML = newTableBody.innerHTML;
                } else {
                    tableBody.innerHTML = data;
                }

                if (window.lucide) lucide.createIcons();

            } catch (err) {
                console.error("Erreur de filtrage:", err);
            }
        }, 300); // Debounce de 300ms
    }

    // Listeners
    if (searchInput) {
        searchInput.addEventListener('input', fetchProducts);
    }

    if (categorySelect) {
        categorySelect.addEventListener('change', fetchProducts);
    }
});