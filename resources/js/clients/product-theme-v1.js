/**
 * VinFast Hải Phòng — Product Detail Theme V1 Engine
 */
export function initProductThemeV1() {
  const root = document.querySelector('.vinfast-autohaiphong_product_app');
  if (!root) return;

  const P = 'vinfast-autohaiphong_product_';
  const $ = (selector, parent = root) => parent.querySelector(selector);
  const $$ = (selector, parent = root) => Array.from(parent.querySelectorAll(selector));
  const pref = (name) => '.' + P + name;

  const cfg = window.VINFAST_PRODUCT_DATA || window.VINFAST_AUTOHAIPHONG_VF3 || {
    model: 'VinFast',
    colors: [
      { name: 'Sky Blue', value: '#8de0e7', filter: 'hue-rotate(102deg) saturate(1.0)' },
      { name: 'Rose Pink', value: '#efafce', filter: 'hue-rotate(242deg) saturate(.55) brightness(1.09)' },
      { name: 'Urban Mint', value: '#829b87', filter: 'hue-rotate(58deg) saturate(.62) brightness(.83)' },
      { name: 'Infinity Blanc', value: '#e3e3e3', filter: 'grayscale(1) brightness(1.62) contrast(.86)' },
      { name: 'Zenith Grey', value: '#8f9293', filter: 'grayscale(1) brightness(.93)' },
      { name: 'Solar Ruby', value: '#be2030', filter: 'hue-rotate(300deg) saturate(2.2) brightness(.92)' },
      { name: 'Summer Yellow', value: '#ffd21f', filter: 'none' }
    ],
    designHighlights: [
      'Dễ dàng quay đầu xe trong không gian đô thị với bán kính quay tối thiểu khoảng 4,5m.',
      'Chiều dài cơ sở tối ưu giúp khoang cabin rộng rãi, tự tin di chuyển trong phố.',
      'La-zăng thể thao tạo nên diện mạo trẻ trung, cá tính và đậm chất công nghệ.'
    ]
  };

  const VND = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', maximumFractionDigits: 0 });
  let lastFocus = null;
  let heroIndex = 0;
  let colorIndex = 3;
  let galleryIndex = 0;
  let lightboxIndex = 0;
  let heroTimer = null;

  const heroSlides = $$(pref('hero-slide'));
  const galleryTrack = $('[data-design-track]');
  const galleryImages = galleryTrack ? $$('img', galleryTrack) : [];
  const lbTriggers = $$('[data-lightbox]');
  const lbImgs = lbTriggers.map(x => {
    const img = x.querySelector('img') || x;
    return {
      src: img.getAttribute('src') || '',
      alt: img.getAttribute('alt') || cfg.model
    };
  });

  // 1. Variant / Trim Selection
  const selectTrim = (key) => {
    const btn = $(`[data-trim="${key}"]`);
    if (!btn) return;

    $$('[data-trim]').forEach(b => {
      const active = b.dataset.trim === String(key);
      b.classList.toggle(P + 'is-active', active);
      b.setAttribute('aria-pressed', String(active));
    });

    const priceFormatted = btn.dataset.priceFormatted;
    const priceVal = btn.dataset.priceVal;
    const name = btn.dataset.name;

    const priceEl = $('[data-price]');
    if (priceEl && priceFormatted) {
      priceEl.textContent = priceFormatted;
    } else if (priceEl && priceVal) {
      priceEl.textContent = VND.format(Number(priceVal));
    }

    const label = $('#vf-selected-variant-label');
    if (label && name) {
      label.textContent = name;
    }

    const inputVariantId = $('#vf-cart-variant-id');
    if (inputVariantId) {
      inputVariantId.value = key;
    }
  };

  // 2. Color Switcher
  const initColors = () => {
    const host = $('[data-swatches]');
    if (!host) return;
    host.replaceChildren();

    (cfg.colors || []).forEach((color, i) => {
      const button = document.createElement('button');
      button.type = 'button';
      button.className = P + 'color-dot';
      button.style.background = color.value;
      button.dataset.color = String(i);
      button.title = color.name;
      button.setAttribute('aria-label', 'Màu ' + color.name);
      host.appendChild(button);
    });

    renderColor(colorIndex);
  };

  const renderColor = (index) => {
    const colors = cfg.colors || [];
    if (!colors.length) return;

    colorIndex = (index + colors.length) % colors.length;
    const color = colors[colorIndex];
    const car = $('[data-color-car]');
    const label = $('[data-color-name]');

    if (car) {
      car.style.filter = color.filter;
      car.alt = 'Mô phỏng màu ' + color.name;
    }
    if (label) {
      label.textContent = color.name;
    }

    $$('[data-color]').forEach(btn => {
      const active = Number(btn.dataset.color) === colorIndex;
      btn.classList.toggle(P + 'is-active', active);
      btn.setAttribute('aria-pressed', String(active));
    });
  };

  // 3. Technical Specifications
  const renderSpecs = (key) => {
    const specGroups = cfg.specGroups || {};
    const block = specGroups[key];

    $$('[data-spec-tab]').forEach(btn => {
      const active = btn.dataset.specTab === key;
      btn.classList.toggle(P + 'is-active', active);
      btn.setAttribute('aria-selected', String(active));
      btn.tabIndex = active ? 0 : -1;
    });

    const title = $('[data-spec-title]');
    const host = $('[data-spec-content]');

    if (block) {
      if (title) title.textContent = block.title;
      if (host && Array.isArray(block.rows)) {
        host.replaceChildren();
        block.rows.forEach(([name, value]) => {
          const row = document.createElement('div');
          row.className = P + 'spec-row';
          const left = document.createElement('span');
          const right = document.createElement('span');
          left.textContent = name;
          right.textContent = value;
          row.append(left, right);
          host.appendChild(row);
        });
      }
    } else {
      // Server-side rendered spec panels
      $$('[data-spec-panel]').forEach(panel => {
        panel.hidden = panel.dataset.specPanel !== key;
      });
    }
  };

  // 4. Design Highlights
  const renderDesign = (i) => {
    const highlights = cfg.designHighlights || [];
    const txt = $('[data-design-description]');
    if (txt && highlights[i]) {
      txt.textContent = highlights[i];
    }

    $$('[data-design-tab]').forEach(btn => {
      const active = Number(btn.dataset.designTab) === i;
      btn.classList.toggle(P + 'is-active', active);
      btn.setAttribute('aria-selected', String(active));
      btn.tabIndex = active ? 0 : -1;
    });
  };

  // 5. Comparison Calculator (EV vs ICE)
  const renderCompare = () => {
    const distInput = $('[data-calc="distance"]');
    const elecInput = $('[data-calc="electricity"]');
    const petInput = $('[data-calc="petrol"]');

    const distance = Number(distInput?.value) || 12000;
    const electricity = Math.max(0, Number(elecInput?.value) || 3000);
    const petrol = Math.max(0, Number(petInput?.value) || 24000);

    const electricCost = (distance / 100) * 12 * electricity;
    const petrolCost = (distance / 100) * 6 * petrol;
    const saving = petrolCost - electricCost;

    const label = $('[data-calc-label="distance"]');
    if (label) label.textContent = distance.toLocaleString('vi-VN') + ' km';

    const elRes = $('[data-calc-result="electric"]');
    if (elRes) elRes.textContent = VND.format(electricCost);

    const petRes = $('[data-calc-result="petrol"]');
    if (petRes) petRes.textContent = VND.format(petrolCost);

    const savRes = $('[data-calc-result="saving"]');
    if (savRes) savRes.textContent = VND.format(saving) + '/năm';
  };

  // 6. Hero Slider
  const setHero = (i) => {
    if (!heroSlides.length) return;
    heroIndex = (i + heroSlides.length) % heroSlides.length;

    heroSlides.forEach((slide, index) => {
      const active = index === heroIndex;
      slide.classList.toggle(P + 'hero-slide-active', active);
      slide.setAttribute('aria-hidden', String(!active));
    });

    $$('[data-hero-dot]').forEach((dot, index) => {
      const active = index === heroIndex;
      dot.classList.toggle(P + 'is-active', active);
      dot.setAttribute('aria-pressed', String(active));
    });
  };

  const restartHero = () => {
    window.clearInterval(heroTimer);
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || heroSlides.length < 2) return;
    heroTimer = window.setInterval(() => {
      if (!document.hidden) setHero(heroIndex + 1);
    }, 7000);
  };

  // 7. Gallery Slider
  const moveGallery = (delta) => {
    if (!galleryImages.length || !galleryTrack) return;
    galleryIndex = (galleryIndex + delta + galleryImages.length) % galleryImages.length;
    galleryTrack.style.transform = `translateX(-${galleryIndex * 100}%)`;
  };

  // 8. Lightbox Modal
  const openLightbox = (i) => {
    if (!lbImgs.length) return;
    lightboxIndex = (i + lbImgs.length) % lbImgs.length;
    lastFocus = document.activeElement;
    const modal = $('[data-lightbox-modal]');
    if (!modal) return;
    modal.hidden = false;
    document.body.style.overflow = 'hidden';
    renderLightbox();
    modal.querySelector(pref('lightbox-close'))?.focus();
  };

  const renderLightbox = () => {
    const record = lbImgs[lightboxIndex];
    if (!record) return;
    const img = $('[data-lightbox-image]');
    const label = $('[data-lightbox-count]');
    if (img) {
      img.src = record.src;
      img.alt = record.alt;
    }
    if (label) {
      label.textContent = `${lightboxIndex + 1} / ${lbImgs.length}`;
    }
  };

  const closeLightbox = () => {
    const modal = $('[data-lightbox-modal]');
    if (modal) modal.hidden = true;
    document.body.style.overflow = '';
    lastFocus?.focus?.();
  };

  const moveLightbox = (delta) => {
    if (!lbImgs.length) return;
    lightboxIndex = (lightboxIndex + delta + lbImgs.length) % lbImgs.length;
    renderLightbox();
  };

  // 9. Floating Buttons & Scroll
  const scrollTop = () => window.scrollTo({ top: 0, behavior: 'smooth' });

  const onScroll = () => {
    const y = window.scrollY;
    $(pref('float-top'))?.classList.toggle(P + 'is-visible', y > 400);
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // 10. Action Dispatcher
  const actions = {
    'consult': () => {
      const carId = root.dataset.carId;
      const carName = root.dataset.carName || cfg.model;
      if (typeof window.openQuoteModal === 'function') {
        window.openQuoteModal(carId, carName);
      } else {
        const modal = $('[data-modal]');
        if (modal) {
          modal.hidden = false;
          document.body.style.overflow = 'hidden';
        }
      }
    },
    'close-modal': () => {
      const modal = $('[data-modal]');
      if (modal) {
        modal.hidden = true;
        document.body.style.overflow = '';
      }
    },
    'close-lightbox': closeLightbox,
    'top': scrollTop,
    'hero-prev': () => { setHero(heroIndex - 1); restartHero(); },
    'hero-next': () => { setHero(heroIndex + 1); restartHero(); },
    'color-prev': () => renderColor(colorIndex - 1),
    'color-next': () => renderColor(colorIndex + 1),
    'gallery-prev': () => moveGallery(-1),
    'gallery-next': () => moveGallery(1),
    'lightbox-prev': () => moveLightbox(-1),
    'lightbox-next': () => moveLightbox(1)
  };

  root.addEventListener('click', (e) => {
    const target = e.target.closest('[data-action]');
    if (target) {
      const action = actions[target.dataset.action];
      if (action) {
        e.preventDefault();
        action();
        return;
      }
    }

    const trim = e.target.closest('[data-trim]');
    if (trim) {
      selectTrim(trim.dataset.trim);
      return;
    }

    const color = e.target.closest('[data-color]');
    if (color) {
      renderColor(Number(color.dataset.color));
      return;
    }

    const spec = e.target.closest('[data-spec-tab]');
    if (spec) {
      renderSpecs(spec.dataset.specTab);
      return;
    }

    const design = e.target.closest('[data-design-tab]');
    if (design) {
      renderDesign(Number(design.dataset.designTab));
      return;
    }

    const dot = e.target.closest('[data-hero-dot]');
    if (dot) {
      setHero(Number(dot.dataset.heroDot));
      restartHero();
      return;
    }

    const lbTrigger = e.target.closest('[data-lightbox]');
    if (lbTrigger) {
      openLightbox(Number(lbTrigger.dataset.lightbox));
      return;
    }
  });

  document.addEventListener('keydown', (e) => {
    const lightbox = $('[data-lightbox-modal]');
    const modal = $('[data-modal]');

    if (e.key === 'Escape') {
      if (lightbox && !lightbox.hidden) closeLightbox();
      else if (modal && !modal.hidden) {
        modal.hidden = true;
        document.body.style.overflow = '';
      }
      return;
    }

    if (lightbox && !lightbox.hidden) {
      if (e.key === 'ArrowRight') moveLightbox(1);
      if (e.key === 'ArrowLeft') moveLightbox(-1);
    }
  });

  // Calculate inputs
  $$('[data-calc]').forEach(input => input.addEventListener('input', renderCompare));

  // Intersection Reveal
  if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.documentElement.classList.add(P + 'js-reveal');
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add(P + 'revealed');
          observer.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -30px 0px', threshold: 0.08 });
    $$('[data-reveal]').forEach(el => observer.observe(el));
  }

  // Remote images check
  $$('img[data-remote-image]').forEach(img => {
    const remote = img.dataset.remoteImage;
    if (!remote || !/^https:\/\//.test(remote)) return;
    const testImg = new Image();
    testImg.referrerPolicy = 'no-referrer';
    testImg.onload = () => {
      if (testImg.naturalWidth > 300) {
        img.src = remote;
      }
    };
    testImg.src = remote;
  });

  // Initialize components
  const firstTrimBtn = $('[data-trim]');
  if (firstTrimBtn) {
    selectTrim(firstTrimBtn.dataset.trim);
  }
  initColors();
  const firstSpecTab = $('[data-spec-tab]');
  if (firstSpecTab) {
    renderSpecs(firstSpecTab.dataset.specTab);
  }
  renderDesign(0);
  renderCompare();
  setHero(0);
  restartHero();

  window.addEventListener('pagehide', () => window.clearInterval(heroTimer), { once: true });
}

