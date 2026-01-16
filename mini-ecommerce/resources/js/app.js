import './bootstrap';
import 'preline'
import { createIcons, icons } from "lucide";



// --- Lucide Icons ---
const initLucide = () => {
    createIcons({ icons }); // Always pass icons
};

// Expose globally if needed
window.createLucideIcons = initLucide;

// --- DOMContentLoaded ---
document.addEventListener("DOMContentLoaded", () => {
    initLucide(); // Icons on page load
    document.addEventListener("preline:ready", initLucide);
});