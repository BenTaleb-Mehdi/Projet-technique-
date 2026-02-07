export function showAlert(message, type = "success") {
    const container = document.getElementById("alert-container");
    if (!container) return;

    const id = Date.now();
    const themes = {
        success: { iconBg: "bg-emerald-100", iconText: "text-emerald-600", border: "border-emerald-100", icon: `<path d="M5 13l4 4L19 7"></path>` },
        error: { iconBg: "bg-rose-100", iconText: "text-rose-600", border: "border-rose-100", icon: `<path d="M6 18L18 6M6 6l12 12"></path>` }
    };

    const theme = themes[type] || themes.success;
    const alertHtml = `
        <div id="alert-${id}" class="flex items-center justify-between p-4 mb-4 text-slate-800 border ${theme.border} rounded-xl bg-white/90 backdrop-blur-md shadow-sm transition-all duration-500">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 flex items-center justify-center rounded-lg ${theme.iconBg} ${theme.iconText}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">${theme.icon}</svg>
                </div>
                <span class="text-sm font-medium">${message}</span>
            </div>
            <button onclick="closeAlert('${id}')" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>`;

    container.insertAdjacentHTML("afterbegin", alertHtml);
    const timer = setTimeout(() => window.closeAlert(id), 5000);
    const el = document.getElementById(`alert-${id}`);
    if (el) el._timer = timer;
}

window.closeAlert = function (id) {
    const el = document.getElementById(`alert-${id}`);
    if (el) {
        clearTimeout(el._timer);
        el.style.opacity = "0";
        el.style.transform = "translateX(20px)";
        setTimeout(() => el.remove(), 500);
    }
};