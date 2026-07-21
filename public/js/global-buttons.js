document.addEventListener('click', function(e) {
    const el = e.target.closest('a,button');
    if (!el) return;

    // Open modal when element has data-target or id=open-modal (take precedence)
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

    // Prevent anchors with href="#" from navigating and show generic modal
    if (el.tagName.toLowerCase() === 'a' && el.getAttribute('href') === '#') {
        e.preventDefault();
        // show generic modal with optional data attributes
        const title = el.dataset.title || 'Informasi';
        const body = el.dataset.body || 'Fitur ini belum terhubung. Minta saya untuk mengimplementasikannya.';
        const modal = document.getElementById('modal-generic');
        if (modal) {
            document.getElementById('modal-generic-title').textContent = title;
            document.getElementById('modal-generic-body').textContent = body;
            modal.classList.remove('hidden');
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

// Gizi filter handlers (apply/reset) if present
document.addEventListener('click', function(e) {
    const btn = e.target.closest('button');
    if (!btn) return;
    if (btn.id === 'filter-reset') {
        e.preventDefault();
        const form = btn.closest('form') || document;
        const inputs = ['#filter-date', '#filter-shift', '#filter-kelas'];
        inputs.forEach(sel => {
            const el = document.querySelector(sel);
            if (el) el.value = '';
        });
        // remove query params
        history.replaceState(null, '', location.pathname);
        return;
    }
    if (btn.id === 'filter-apply') {
        e.preventDefault();
        const dateEl = document.querySelector('#filter-date');
        const shiftEl = document.querySelector('#filter-shift');
        const kelasEl = document.querySelector('#filter-kelas');
        const date = dateEl ? (dateEl.value || '') : '';
        const shift = shiftEl ? (shiftEl.value || '') : '';
        const kelas = kelasEl ? (kelasEl.value || '') : '';
        const params = new URLSearchParams();
        if (date) params.set('tanggal', date);
        if (shift) params.set('shift', shift);
        if (kelas) params.set('kelas', kelas);
        const url = location.pathname + (params.toString() ? ('?' + params.toString()) : '');
        window.location.href = url;
        return;
    }
});