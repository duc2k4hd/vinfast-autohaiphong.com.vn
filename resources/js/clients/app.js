/**
 * VinFast Hải Phòng — Client JavaScript Module
 */
import { initProductThemeV1 } from './product-theme-v1';

document.addEventListener('DOMContentLoaded', () => {
    initProductThemeV1();

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

    const carsMenu = document.querySelector('[data-vf-cars-menu]');
    const carsToggle = document.querySelector('[data-vf-cars-toggle]');
    const carsDropdown = document.getElementById('vf-cars-dropdown');
    if (carsMenu && carsToggle && carsDropdown) {
        let closeTimer;
        let isClickPinned = false;
        let suppressHoverUntilLeave = false;
        const setCarsMenuOpen = (open) => {
            carsToggle.setAttribute('aria-expanded', String(open));
            carsDropdown.hidden = !open;
            carsMenu.classList.toggle('is-hover-open', open);
        };
        carsToggle.addEventListener('click', (event) => {
            event.preventDefault();
            window.clearTimeout(closeTimer);
            isClickPinned = carsDropdown.hidden;
            suppressHoverUntilLeave = !isClickPinned;
            setCarsMenuOpen(isClickPinned);
        });
        const carsCloseBtn = carsDropdown.querySelector('[data-vf-cars-close]');
        carsCloseBtn?.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            window.clearTimeout(closeTimer);
            isClickPinned = false;
            suppressHoverUntilLeave = true;
            setCarsMenuOpen(false);
            carsToggle.focus();
        });
        carsMenu.addEventListener('mouseenter', (event) => {
            if (event.pointerType !== 'touch' && window.matchMedia('(min-width: 861px)').matches && !suppressHoverUntilLeave) {
                window.clearTimeout(closeTimer);
                setCarsMenuOpen(true);
            }
        });
        carsMenu.addEventListener('mouseleave', (event) => {
            if (event.pointerType !== 'touch' && window.matchMedia('(min-width: 861px)').matches) {
                suppressHoverUntilLeave = false;
                if (!isClickPinned) closeTimer = window.setTimeout(() => setCarsMenuOpen(false), 350);
            }
        });
        carsMenu.addEventListener('focusin', () => setCarsMenuOpen(true));
        carsMenu.addEventListener('focusout', (event) => {
            if (!carsMenu.contains(event.relatedTarget) && !isClickPinned) setCarsMenuOpen(false);
        });
        document.addEventListener('click', (event) => {
            if (!carsMenu.contains(event.target)) {
                isClickPinned = false;
                suppressHoverUntilLeave = false;
                setCarsMenuOpen(false);
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !carsDropdown.hidden) {
                window.clearTimeout(closeTimer);
                isClickPinned = false;
                suppressHoverUntilLeave = false;
                setCarsMenuOpen(false);
                carsToggle.focus();
            }
        });
        mobileMenuBtn?.addEventListener('click', () => {
            if (mobileMenuBtn.getAttribute('aria-expanded') === 'false') setCarsMenuOpen(false);
        });
    }

    const productGallery = document.querySelector('[data-vf-product-gallery]');
    if (productGallery) {
        const slides = Array.from(productGallery.querySelectorAll('[data-vf-gallery-slide]'));
        const thumbnails = Array.from(productGallery.querySelectorAll('[data-vf-gallery-thumbnail]'));
        const counter = productGallery.querySelector('[data-vf-gallery-counter]');
        let activeIndex = 0;
        let touchStartX = null;
        const showSlide = (index) => {
            if (slides.length < 2) return;
            activeIndex = (index + slides.length) % slides.length;
            slides.forEach((slide, slideIndex) => slide.classList.toggle('is-active', slideIndex === activeIndex));
            thumbnails.forEach((thumbnail, thumbnailIndex) => {
                const isActive = thumbnailIndex === activeIndex;
                thumbnail.classList.toggle('is-active', isActive);
                thumbnail.setAttribute('aria-selected', String(isActive));
                if (isActive) thumbnail.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'nearest' });
            });
            if (counter) counter.textContent = `${activeIndex + 1} / ${slides.length}`;
        };
        productGallery.querySelector('[data-vf-gallery-previous]')?.addEventListener('click', () => showSlide(activeIndex - 1));
        productGallery.querySelector('[data-vf-gallery-next]')?.addEventListener('click', () => showSlide(activeIndex + 1));
        thumbnails.forEach((thumbnail) => thumbnail.addEventListener('click', () => showSlide(Number(thumbnail.dataset.vfGalleryThumbnail))));
        productGallery.addEventListener('keydown', (event) => {
            if (event.key === 'ArrowLeft') showSlide(activeIndex - 1);
            if (event.key === 'ArrowRight') showSlide(activeIndex + 1);
        });
        productGallery.addEventListener('touchstart', (event) => {
            touchStartX = event.changedTouches[0]?.clientX ?? null;
        }, { passive: true });
        productGallery.addEventListener('touchend', (event) => {
            if (touchStartX === null || slides.length < 2) return;
            const touchEndX = event.changedTouches[0]?.clientX ?? touchStartX;
            const swipeDistance = touchEndX - touchStartX;
            if (Math.abs(swipeDistance) > 45) showSlide(activeIndex + (swipeDistance < 0 ? 1 : -1));
            touchStartX = null;
        }, { passive: true });
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
