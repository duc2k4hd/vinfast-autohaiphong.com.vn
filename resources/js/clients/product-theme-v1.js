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

  // 1. Variant / Trim Selection & Sliding Background Indicator
  const updateTrimIndicator = (immediate = false) => {
    const activeBtn = $('[data-trim].' + P + 'is-active');
    const indicator = $('.' + P + 'trim-indicator');
    if (!activeBtn || !indicator) return;

    if (immediate) {
      indicator.style.transition = 'none';
    }

    const left = activeBtn.offsetLeft;
    const top = activeBtn.offsetTop;
    const width = activeBtn.offsetWidth;
    const height = activeBtn.offsetHeight;

    indicator.style.transform = `translate3d(${left}px, ${top}px, 0)`;
    indicator.style.width = `${width}px`;
    indicator.style.height = `${height}px`;
    indicator.style.opacity = '1';

    if (immediate) {
      void indicator.offsetHeight;
      indicator.style.transition = '';
    }
  };

  const switchCarVariantImage = (newSrc, altText = '') => {
    if (!newSrc) return;
    const visual = $('.' + P + 'intro-visual');
    if (!visual) return;

    const currentImg = visual.querySelector('.' + P + 'intro-car:not(.' + P + 'car-exiting)');
    if (currentImg) {
      const curSrc = currentImg.getAttribute('src');
      if (curSrc === newSrc || (curSrc && curSrc.endsWith(newSrc))) return;

      // Ảnh cũ: đi hẳn sang bên trái và biến mất mượt mà
      currentImg.classList.add(P + 'car-exiting');
      currentImg.style.transition = 'transform 0.55s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.45s cubic-bezier(0.4, 0, 0.2, 1)';
      currentImg.style.transform = 'translate3d(-120%, 0, 0) scale(var(--vf-car-scale, 1.05))';
      currentImg.style.opacity = '0';
      currentImg.style.pointerEvents = 'none';

      setTimeout(() => {
        currentImg.remove();
      }, 580);
    }

    // Ảnh mới: rơi từ trên cao nhất xuống và xuất hiện mượt mà
    const newImg = document.createElement('img');
    newImg.className = P + 'intro-car ' + P + 'car-entering';
    newImg.src = newSrc;
    newImg.alt = altText || 'VinFast';
    newImg.loading = 'eager';

    newImg.style.opacity = '0';
    newImg.style.transform = 'translate3d(0, -130%, 0) scale(var(--vf-car-scale, 1.18))';
    newImg.style.transition = 'transform 0.65s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.45s ease-out';
    newImg.style.pointerEvents = 'none';

    visual.appendChild(newImg);

    void newImg.offsetHeight;

    requestAnimationFrame(() => {
      newImg.style.opacity = '1';
      newImg.style.transform = 'translate3d(0, 0, 0) scale(var(--vf-car-scale, 1.12))';
      setTimeout(() => {
        newImg.classList.remove(P + 'car-entering');
        newImg.style.transition = '';
        newImg.style.transform = '';
        newImg.style.opacity = '';
        newImg.style.pointerEvents = '';
      }, 680);
    });
  };

  const selectTrim = (key, isInit = false) => {
    const btn = $(`[data-trim="${key}"]`);
    if (!btn) return;

    $$('[data-trim]').forEach(b => {
      const active = b.dataset.trim === String(key);
      b.classList.toggle(P + 'is-active', active);
      b.setAttribute('aria-pressed', String(active));
    });

    updateTrimIndicator(isInit);

    const priceFormatted = btn.dataset.priceFormatted;
    const priceVal = btn.dataset.priceVal;
    const name = btn.dataset.name;
    const imageSrc = btn.dataset.image;

    if (!isInit && imageSrc) {
      switchCarVariantImage(imageSrc, name || btn.textContent.trim());
    }

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

  // 2. Color Studio Switcher with Slide-Left / Drop-Down Animation
  const switchColorStageCar = (newSrc, altText = '') => {
    if (!newSrc) return;
    const stageWrapper = $('[data-color-car-wrapper]');
    if (!stageWrapper) return;

    const currentCar = stageWrapper.querySelector('.' + P + 'color-car:not(.' + P + 'color-car-exiting)');
    if (currentCar) {
      const curSrc = currentCar.getAttribute('src');
      if (curSrc === newSrc || (curSrc && curSrc.endsWith(newSrc))) return;

      // Xe trước đi hẳn sang bên trái và mờ dần biến mất
      currentCar.classList.add(P + 'color-car-exiting');
      currentCar.style.transition = 'transform 0.55s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.45s cubic-bezier(0.4, 0, 0.2, 1)';
      currentCar.style.transform = 'translate3d(-120%, 0, 0) scale(1.05)';
      currentCar.style.opacity = '0';
      currentCar.style.pointerEvents = 'none';

      setTimeout(() => {
        currentCar.remove();
      }, 580);
    }

    // Xe mới rơi từ trên cao nhất xuống và xuất hiện mượt mà
    const newCar = document.createElement('img');
    newCar.className = P + 'color-car ' + P + 'color-car-entering';
    newCar.src = newSrc;
    newCar.alt = altText || 'Mô phỏng màu xe';
    newCar.loading = 'eager';

    newCar.style.opacity = '0';
    newCar.style.transform = 'translate3d(0, -135%, 0) scale(1.15)';
    newCar.style.transition = 'transform 0.65s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.45s ease-out';
    newCar.style.pointerEvents = 'none';

    stageWrapper.appendChild(newCar);

    void newCar.offsetHeight;

    requestAnimationFrame(() => {
      newCar.style.opacity = '1';
      newCar.style.transform = 'translate3d(0, 0, 0) scale(1.12)';
      setTimeout(() => {
        newCar.classList.remove(P + 'color-car-entering');
        newCar.style.transition = '';
        newCar.style.transform = '';
        newCar.style.opacity = '';
        newCar.style.pointerEvents = '';
      }, 680);
    });
  };

  const renderColor = (index, isInit = false) => {
    const colorButtons = $$('[data-color]');
    if (!colorButtons.length) return;

    colorIndex = (index + colorButtons.length) % colorButtons.length;
    const activeBtn = colorButtons[colorIndex];
    if (!activeBtn) return;

    colorButtons.forEach((btn, i) => {
      const active = i === colorIndex;
      btn.classList.toggle(P + 'is-active', active);
      btn.setAttribute('aria-pressed', String(active));
    });

    const newImage = activeBtn.dataset.image;
    const colorName = activeBtn.dataset.name;

    if (!isInit && newImage) {
      switchColorStageCar(newImage, 'Mô phỏng màu ' + (colorName || ''));
    }
  };

  const initColors = () => {
    const colorButtons = $$('[data-color]');
    if (colorButtons.length) {
      renderColor(0, true);
      return;
    }

    const host = $('[data-swatches]');
    if (!host) return;
    host.replaceChildren();

    (cfg.colors || []).forEach((color, i) => {
      const button = document.createElement('button');
      button.type = 'button';
      button.className = P + 'color-dot';
      button.dataset.color = String(i);
      button.dataset.name = color.name;
      button.title = color.name;
      button.setAttribute('aria-label', 'Màu ' + color.name);

      const circle = document.createElement('span');
      circle.className = P + 'color-circle';
      circle.style.backgroundColor = color.value;

      const label = document.createElement('span');
      label.className = P + 'color-label';
      label.textContent = color.name;

      button.append(circle, label);
      host.appendChild(button);
    });

    renderColor(0, true);
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

  // 5. Comparison Calculator (EV vs ICE) - Chuẩn hóa theo định mức phân khúc từng dòng xe
  const renderCompare = () => {
    const compareSection = $('[data-calc-ev-rate]') || $('.' + P + 'compare');
    const evRate = Number(compareSection?.dataset?.calcEvRate) || 8.9;
    const iceRate = Number(compareSection?.dataset?.calcIceRate) || 5.5;

    const distInput = $('[data-calc="distance"]');
    const elecInput = $('[data-calc="electricity"]');
    const petInput = $('[data-calc="petrol"]');

    const distance = Number(distInput?.value) || 12000;
    const electricity = Math.max(0, Number(elecInput?.value) || 3500);
    const petrol = Math.max(0, Number(petInput?.value) || 23000);

    const electricCost = Math.round((distance / 100) * evRate * electricity);
    const petrolCost = Math.round((distance / 100) * iceRate * petrol);
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
    selectTrim(firstTrimBtn.dataset.trim, true);
    requestAnimationFrame(() => updateTrimIndicator(true));
  }
  window.addEventListener('resize', () => updateTrimIndicator(true));

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

