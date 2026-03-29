// resources/js/stars.js
export function initStarfield() { // Added export and renamed to match app.js
    const canvas = document.getElementById('starfield'); // Match the ID in your Blade
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height, stars = [];

    const init = () => {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
        
        stars = Array.from({ length: 150 }, () => ({
            x: Math.random() * width,
            y: Math.random() * height,
            size: Math.random() * 1.2,
            opacity: Math.random() * 0.8,
            speed: (Math.random() * 0.3) + 0.1
        }));
    };

    const animate = () => {
        ctx.fillStyle = '#000000';
        ctx.fillRect(0, 0, width, height);
        stars.forEach(star => {
            star.y -= star.speed;
            if (star.y < 0) {
                star.y = height;
                star.x = Math.random() * width;
            }
            ctx.fillStyle = `rgba(255, 255, 255, ${star.opacity})`;
            ctx.beginPath();
            ctx.arc(star.x, star.y, star.size, 0, Math.PI * 2);
            ctx.fill();
        });
        requestAnimationFrame(animate);
    };

    init();
    animate();
    window.addEventListener('resize', init);
}