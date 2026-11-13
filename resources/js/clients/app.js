/**
 * VinFast Hải Phòng — Client JavaScript Module
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile Menu Toggle
    const mobileMenuBtn = document.querySelector('[data-vf-mobile-toggle]');
    const mobileMenu = document.querySelector('[data-vf-mobile-menu]');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
            mobileMenuBtn.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('active');
            document.body.classList.toggle('overflow-hidden');
        });
    }

    // 2. Modal Báo Giá Lăn Bánh
    const quoteModal = document.getElementById('vf-quote-modal');
    const quoteCarNameInput = document.getElementById('vf-quote-car-name');
    const quoteCarIdInput = document.getElementById('vf-quote-car-id');

    window.openQuoteModal = function(carId, carName) {
        if (!quoteModal) return;
        if (quoteCarIdInput) quoteCarIdInput.value = carId;
        if (quoteCarNameInput) quoteCarNameInput.value = carName;
        
        const modalCarDisplay = document.getElementById('vf-modal-car-display');
        if (modalCarDisplay) modalCarDisplay.textContent = carName;

        quoteModal.style.display = 'flex';
        document.body.classList.add('overflow-hidden');
    };

    window.closeQuoteModal = function() {
        if (!quoteModal) return;
        quoteModal.style.display = 'none';
        document.body.classList.remove('overflow-hidden');
    };

    // Đóng khi click ngoài modal content hoặc phím Escape
    if (quoteModal) {
        quoteModal.addEventListener('click', (e) => {
            if (e.target === quoteModal) {
                window.closeQuoteModal();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && quoteModal.style.display === 'flex') {
                window.closeQuoteModal();
            }
        });
    }
});
