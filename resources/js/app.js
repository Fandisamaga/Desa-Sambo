const sidebar = document.querySelector('#mobile-sidebar');
const overlay = document.querySelector('#sidebar-overlay');

const setSidebar = (isOpen) => {
    if (!sidebar || !overlay) return;
    sidebar.classList.toggle('-translate-x-full', !isOpen);
    overlay.classList.toggle('hidden', !isOpen);
    document.body.classList.toggle('overflow-hidden', isOpen);
};

document.querySelectorAll('[data-sidebar-open]').forEach((button) => button.addEventListener('click', () => setSidebar(true)));
document.querySelectorAll('[data-sidebar-close]').forEach((button) => button.addEventListener('click', () => setSidebar(false)));
overlay?.addEventListener('click', () => setSidebar(false));
