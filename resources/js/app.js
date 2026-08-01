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

document.querySelectorAll('[data-hero-background]').forEach((hero) => {
    const slides = Array.from(hero.querySelectorAll('[data-hero-slide]'));

    if (slides.length <= 1 || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    let activeIndex = slides.findIndex((slide) => slide.classList.contains('is-active'));
    activeIndex = activeIndex >= 0 ? activeIndex : 0;
    slides[activeIndex]?.classList.add('is-active');

    window.setInterval(() => {
        slides[activeIndex].classList.remove('is-active');
        activeIndex = (activeIndex + 1) % slides.length;
        slides[activeIndex].classList.add('is-active');
    }, 6500);
});

document.querySelectorAll('[data-infographic-tabs]').forEach((tablist) => {
    const tabs = tablist.querySelectorAll('[data-infographic-tab]');
    const panels = document.querySelectorAll('[data-infographic-panel]');

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.infographicTab;

            tabs.forEach((item) => {
                const isActive = item === tab;
                item.setAttribute('aria-selected', isActive ? 'true' : 'false');
                item.classList.toggle('border-emerald-700', isActive);
                item.classList.toggle('text-slate-700', isActive);
                item.classList.toggle('border-transparent', !isActive);
                item.classList.toggle('text-slate-500', !isActive);
            });

            panels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.dataset.infographicPanel !== target);
            });
        });
    });
});

document.querySelectorAll('[data-apbdes-section]').forEach((section) => {
    const select = section.querySelector('[data-apbdes-year-select]');
    const yearPanels = section.querySelectorAll('[data-apbdes-year-panel]');

    const setYear = (year) => {
        yearPanels.forEach((panel) => {
            panel.classList.toggle('hidden', panel.dataset.apbdesYearPanel !== year);
        });
    };

    select?.addEventListener('change', () => setYear(select.value));

    if (select?.value) {
        setYear(select.value);
    }
});

const deleteDialog = document.querySelector('#delete-confirmation-dialog');
const deleteConfirmButton = document.querySelector('[data-delete-confirm]');
let pendingDeleteForm = null;

const closeDeleteDialog = () => {
    if (!deleteDialog) return;

    deleteDialog.classList.add('hidden');
    deleteDialog.classList.remove('flex');
    deleteDialog.setAttribute('aria-hidden', 'true');
    pendingDeleteForm = null;
};

document.querySelectorAll('[data-delete-form]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        if (!deleteDialog) {
            form.submit();
            return;
        }

        pendingDeleteForm = form;
        deleteDialog.classList.remove('hidden');
        deleteDialog.classList.add('flex');
        deleteDialog.setAttribute('aria-hidden', 'false');
        deleteConfirmButton?.focus();
    });
});

document.querySelectorAll('[data-delete-cancel]').forEach((button) => {
    button.addEventListener('click', closeDeleteDialog);
});

deleteConfirmButton?.addEventListener('click', () => {
    const form = pendingDeleteForm;
    closeDeleteDialog();
    form?.submit();
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && pendingDeleteForm) {
        closeDeleteDialog();
    }
});
