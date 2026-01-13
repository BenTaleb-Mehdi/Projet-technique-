   let debounceTimer;

    document.getElementById('searchInput').addEventListener('input', (e) => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(async () => {
            const url = e.target.dataset.url;
            const response = await fetch(`${url}?search=${e.target.value}`);
            const html = await response.text();
            const doc = new DOMParser().parseFromString(html, 'text/html');
            const newRows = doc.getElementById('productBody').innerHTML;
            document.getElementById('productBody').innerHTML = newRows;
        }, 300);
    });