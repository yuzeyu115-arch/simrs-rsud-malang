document.addEventListener('click', function(e) {
    const el = e.target.closest('a,button');
    if (!el) return;

    // Prevent anchors with href="#" from navigating
    if (el.tagName.toLowerCase() === 'a' && el.getAttribute('href') === '#') {
        e.preventDefault();
    }

    // Open modal when element has data-target or id=open-modal
    const targetSelector = el.dataset.target || (el.id === 'open-modal' ? '#modal-create' : null);
    if (targetSelector) {
        const modal = document.querySelector(targetSelector);
        if (modal) {
            modal.classList.remove('hidden');
            // focus first input if any
            const focusEl = modal.querySelector('input,select,textarea,button');
            if (focusEl) focusEl.focus();
        }
        return;
    }

    // Close modal when element has data-close-modal
    if (el.dataset.closeModal !== undefined) {
        const modal = el.closest('[id^="modal-"]');
        if (modal) {
            modal.classList.add('hidden');
        } else {
            // if clicked backdrop overlay
            const openModal = document.querySelector('.fixed.inset-0.z-50:not(.hidden)');
            if (openModal) openModal.classList.add('hidden');
        }
        return;
    }

    // Navigation via data-route attribute
    if (el.dataset.route) {
        window.location.href = el.dataset.route;
        return;
    }
});

// Close modal on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const openModal = document.querySelector('[id^="modal-"]:not(.hidden)');
        if (openModal) openModal.classList.add('hidden');
    }
});