export function showAlert(message, type = "success") {
    const container = document.getElementById("alert-container");
    if (!container) return; // Guard clause

    const id = Date.now();

    // Map types to modern color schemes
    const themes = {
        success: {
            iconBg: "bg-emerald-100",
            iconText: "text-emerald-600",
            border: "border-emerald-100",
            icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>`,
        },
        error: {
            iconBg: "bg-rose-100",
            iconText: "text-rose-600",
            border: "border-rose-100",
            icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>`,
        },
        info: {
            iconBg: "bg-blue-100",
            iconText: "text-blue-600",
            border: "border-blue-100",
            icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>`,
        },
    };

    const theme = themes[type] || themes.info;

    const alertHtml = `
        <div id="alert-${id}" class="flex items-center justify-between p-4 mb-4 text-slate-800 border ${theme.border} rounded-xl bg-white/90 backdrop-blur-md shadow-sm transition-all duration-500 ease-in-out">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg ${theme.iconBg} ${theme.iconText}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${theme.icon}
                    </svg>
                </div>
                <span class="text-sm font-medium leading-relaxed">${message}</span>
            </div>
            <button onclick="closeAlert('${id}')" class="ml-4 -mr-1 p-1.5 inline-flex items-center justify-center h-8 w-8 rounded-lg text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

    container.insertAdjacentHTML("afterbegin", alertHtml); // New alerts appear at the top

    // Auto-remove logic
    const timer = setTimeout(() => closeAlert(id), 5000);

    // Store timer on element so manual close can clear it if needed
    document.getElementById(`alert-${id}`)._timer = timer;
}

// Ensure this is globally available for the onclick attribute
window.closeAlert = function (id) {
    const el = document.getElementById(`alert-${id}`);
    if (el) {
        clearTimeout(el._timer); // Prevent double-triggering
        el.style.opacity = "0";
        el.style.transform = "translateX(20px)"; // Smooth slide-out effect
        setTimeout(() => el.remove(), 500);
    }
};
