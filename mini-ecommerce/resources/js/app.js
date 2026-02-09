import './bootstrap';
import 'preline';
import Alpine from 'alpinejs';
import { createIcons, icons } from "lucide";
import { showAlert } from './components/alerts.js';
import productManager from './components/productManager.js';

window.Alpine = Alpine;


window.createLucideIcons = () => createIcons({ icons });


window.showAlert = showAlert;

document.addEventListener("DOMContentLoaded", () => {
    window.createLucideIcons();
    document.addEventListener("preline:ready", window.createLucideIcons);
});

document.addEventListener('alpine:init', () => {
    Alpine.data('productManager', productManager);
});

Alpine.start();