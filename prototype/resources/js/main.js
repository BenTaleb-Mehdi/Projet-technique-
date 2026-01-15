document.getElementById("Formproduct").addEventListener("submit", async (e) => {
    e.preventDefault();
    e.stopImmediatePropagation();
    const form = e.target;

    try {
        const response = await fetch(form.dataset.url, {
            method: "POST",
            headers: {
                // Fixed the selector here as well
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                Accept: "text/html",
            },
            body: new FormData(form),
        });

        if (response.ok) {
            const htmlRow = await response.text();
            document
                .getElementById("productBody")
                .insertAdjacentHTML("beforeend", htmlRow);
            form.reset();
            const model = document.getElementById("hs-scroll-inside-body-modal");
            if(model && typeof HSOverlay !== "undefined"){
                HSOverlay.close(model)
            }


            console.log("product added");
        }
    } catch (error) {
        console.error("Error details:", error);
    }
});

// --- 2. RECHERCHE (Search with Debounce) ---
let timer;

document.getElementById("searchInput").addEventListener("input", async (e) => {
    clearTimeout(timer);
    timer = setTimeout(async () => {
        const url = e.target.dataset.url;
        const response = await fetch(`${url}?search=${e.target.value}`);
        const roeHtml = await response.text();

        document.getElementById("productBody").innerHTML = new DOMParser()
            .parseFromString(roeHtml, "text/html")
            .getElementById("productBody").innerHTML;
    }, 300);
});
