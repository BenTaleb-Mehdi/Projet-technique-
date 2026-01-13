  let debounceTimer;

    document.getElementById('searchInput').addEventListener('input', (e) => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(async () => {
            const response = await fetch(`{{ route('admin.products.index') }}?search=${e.target.value}`);
            const html = await response.text();
            const doc = new DOMParser().parseFromString(html, 'text/html');
            const newRows = doc.getElementById('productBody').innerHTML;
            document.getElementById('productBody').innerHTML = newRows;
        }, 300);
    });