export function initIntro() {
    setTimeout(() => {
        document.getElementById('intro').classList.add('fade-out');
        setTimeout(() => {
            window.location.href = '/chat';
        }, 600);
    }, 2500);
}