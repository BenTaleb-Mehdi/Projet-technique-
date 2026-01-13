    document.getElementById('productForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        const url = form.dataset.url;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'text/html' 
                },
                body: formData
            });

            if (response.ok) {
                const htmlRow = await response.text();
                document.getElementById('productBody').insertAdjacentHTML('beforeend', htmlRow);
                alert('Product created successfully!');
                form.reset();
            } else {
                const errorData = await response.json();
                console.error(errorData);
                alert('Error: ' + (errorData.message || 'Check console for details'));
            }
        } catch (error) {
            console.error('Fetch error:', error);
        }
    });