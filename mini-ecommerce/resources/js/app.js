import './bootstrap';
import 'preline'
import { createIcons } from "lucide";
import * as icons from "lucide";
import Alpine from 'alpinejs'
 
window.Alpine = Alpine
 
Alpine.start()


// --- Lucide Icons ---
const initLucide = () => {
    // Handle both {icons} and * as icons structures
    const iconsToUse = icons.icons || icons;
    createIcons({ icons: iconsToUse }); 
};

// Expose globally if needed
window.createLucideIcons = initLucide;

// --- DOMContentLoaded ---
document.addEventListener("DOMContentLoaded", () => {
    initLucide(); // Icons on page load
    document.addEventListener("preline:ready", initLucide);
});