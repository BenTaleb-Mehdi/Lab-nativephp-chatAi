import './bootstrap';
import Alpine from 'alpinejs';
import { chatApp } from './chat.js'; 
import { initIntro } from './intro.js';
import { initStarfield } from './stars.js';

// Attach to window so x-data="chatApp()" works
window.chatApp = chatApp;
window.initIntro = initIntro;
window.Alpine = Alpine;

Alpine.start();

// Initialize stars
document.addEventListener('DOMContentLoaded', () => {
    initStarfield();
    initIntro();
});