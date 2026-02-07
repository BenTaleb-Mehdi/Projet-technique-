export function showAlert(message, type = 'success') {
    const container = document.getElementById('alert-container');
    if (!container) return;

    const alert = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    
    alert.className = `${bgColor} text-white px-6 py-4 rounded-lg shadow-lg mb-4 transition-all duration-300 transform translate-x-full`;
    alert.innerHTML = `
        <div class="flex items-center justify-between">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 hover:text-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

    container.appendChild(alert);

    // Animate in
    requestAnimationFrame(() => {
        alert.classList.remove('translate-x-full');
    });

    // Auto remove
    setTimeout(() => {
        alert.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => alert.remove(), 300);
    }, 3000);
}
