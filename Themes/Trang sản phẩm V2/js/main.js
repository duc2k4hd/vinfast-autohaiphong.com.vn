/**
 * VINFAST VF 3 PRODUCT PAGE - PURE VANILLA JAVASCRIPT
 * Class Prefix: vinfast-autohaiphong_product_
 */
(function () {
  'use strict';

  const P = 'vinfast-autohaiphong_product_';
  const cls = (name) => `${P}${name}`;

  document.addEventListener('DOMContentLoaded', () => {
    initHeaderMegaMenu();
    initHamburgerModal();
    initSecondaryStickyNavbar();
    initScrollToTop();
    initProductSummaryVariants();
    initColorCustomizer();
    initFuelCostComparison();
    initImageIntroduceScrollExpand();
    initGallerySwiper();
    initVideoAutoplay();
    initSpecsTabs();
    initLeadForms();
    initFooterAccordions();
  });

  /* ========================================================================
     1. HEADER MEGA MENU (Ô tô, Xe máy điện, Dịch vụ hậu mãi, Pin & trạm sạc)
     ======================================================================== */
  function initHeaderMegaMenu() {
    const triggers = document.querySelectorAll('[data-mega-dropdown-trigger]');
    const closeBtns = document.querySelectorAll('[data-mega-menu-close]');

    function closeAllDropdowns() {
      triggers.forEach((item) => item.classList.remove(cls('is-open')));
    }

    triggers.forEach((item) => {
      const link = item.querySelector(':scope > a');
      if (link) {
        link.addEventListener('click', (e) => {
          e.preventDefault();
          const isOpen = item.classList.contains(cls('is-open'));
          closeAllDropdowns();
          if (!isOpen) {
            item.classList.add(cls('is-open'));
          }
        });
      }

      item.addEventListener('mouseenter', () => {
        if (window.innerWidth >= 1024) {
          closeAllDropdowns();
          item.classList.add(cls('is-open'));
        }
      });

      item.addEventListener('mouseleave', () => {
        if (window.innerWidth >= 1024) {
          item.classList.remove(cls('is-open'));
        }
      });
    });

    closeBtns.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        closeAllDropdowns();
      });
    });

    document.addEventListener('click', (e) => {
      if (!e.target.closest('[data-mega-dropdown-trigger]')) {
        closeAllDropdowns();
      }
    });

    // Vertical sidebar tabs inside Vehicle Mega Menu
    const megaTabs = document.querySelectorAll('[data-mega-tab]');
    megaTabs.forEach((tab) => {
      const activateMegaTab = (e) => {
        e.preventDefault();
        const targetSelector = tab.getAttribute('data-mega-tab');
        const panel = tab.closest(`.${cls('vehicle-megamenu-v2__panel')}`);
        if (!panel || !targetSelector) return;

        panel.querySelectorAll('[data-mega-tab]').forEach((t) => {
          t.classList.remove(cls('is-active'));
          t.setAttribute('aria-selected', 'false');
        });
        panel.querySelectorAll(`.${cls('vehicle-megamenu-v2__tab-pane')}`).forEach((pane) => {
          pane.classList.remove(cls('is-active'), cls('show'));
        });

        tab.classList.add(cls('is-active'));
        tab.setAttribute('aria-selected', 'true');
        const targetPane = panel.querySelector(targetSelector);
        if (targetPane) {
          targetPane.classList.add(cls('is-active'), cls('show'));
        }
      };

      tab.addEventListener('mouseenter', activateMegaTab);
      tab.addEventListener('click', activateMegaTab);
    });

    // Aftersale (Dịch vụ hậu mãi) vehicle switcher
    const dvhmContainers = document.querySelectorAll(`.${cls('dvhm-mega-menu')}`);
    dvhmContainers.forEach((container) => {
      const vBtns = container.querySelectorAll('[data-vehicle].' + cls('dvhm-mega-menu__vehicle-btn'));
      const linkLists = container.querySelectorAll(`.${cls('dvhm-mega-menu__link-list')}`);
      const ctaGroups = container.querySelectorAll(`.${cls('dvhm-mega-menu__ctas')}`);

      vBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
          const vehicle = btn.getAttribute('data-vehicle');
          vBtns.forEach((b) => {
            b.classList.toggle(cls('is-active'), b === btn);
            b.setAttribute('aria-pressed', b === btn ? 'true' : 'false');
          });
          linkLists.forEach((list) => {
            list.hidden = list.getAttribute('data-vehicle') !== vehicle;
          });
          ctaGroups.forEach((group) => {
            group.hidden = group.getAttribute('data-vehicle') !== vehicle;
          });
        });
      });
    });
  }

  /* ========================================================================
     2. HAMBURGER RIGHT DRAWER MODAL
     ======================================================================== */
  function initHamburgerModal() {
    const modal = document.querySelector('[data-hamburger-modal]');
    const openBtns = document.querySelectorAll('[data-hamburger-open]');
    const closeBtns = document.querySelectorAll('[data-hamburger-close]');

    if (!modal) return;

    openBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        modal.classList.add(cls('is-open'));
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
      });
    });

    closeBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        modal.classList.remove(cls('is-open'));
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
      });
    });

    // Mobile accordions inside hamburger drawer
    const accordions = modal.querySelectorAll('[data-hmv2-accordion]');
    accordions.forEach((acc) => {
      const toggle = acc.querySelector('[data-hmv2-toggle]');
      const panel = acc.querySelector('[data-hmv2-panel]');
      if (toggle && panel) {
        toggle.addEventListener('click', () => {
          const isHidden = panel.hidden;
          panel.hidden = !isHidden;
          toggle.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
        });
      }
    });
  }

  /* ========================================================================
     3. SECONDARY STICKY NAVBAR & SCROLLSPY
     ======================================================================== */
  function initSecondaryStickyNavbar() {
    const secondaryNav = document.querySelector('[data-car-pdp-secondary-navbar]');
    const menuList = document.querySelector('[data-car-pdp-secondary-menu]');
    const mobileSelect = document.querySelector('[data-car-pdp-secondary-select]');
    const navSections = Array.from(document.querySelectorAll('[data-car-pdp-nav-label]'));

    if (!secondaryNav || !navSections.length) return;

    // Populate desktop menu and mobile select dynamically from sections
    navSections.forEach((sec, idx) => {
      const label = sec.getAttribute('data-car-pdp-nav-label');
      if (!sec.id) {
        sec.id = `pdp-section-${idx + 1}`;
      }

      if (menuList) {
        const li = document.createElement('li');
        li.className = `${cls('mega_main')} ${cls('menu_special')}`;
        const a = document.createElement('a');
        a.href = `#${sec.id}`;
        a.textContent = label;
        a.setAttribute('data-section-target', sec.id);
        if (idx === 0) a.classList.add(cls('is-active'));
        a.addEventListener('click', (e) => {
          e.preventDefault();
          const y = sec.getBoundingClientRect().top + window.scrollY - 68;
          window.scrollTo({ top: y, behavior: 'smooth' });
        });
        li.appendChild(a);
        menuList.appendChild(li);
      }

      if (mobileSelect) {
        const opt = document.createElement('option');
        opt.value = sec.id;
        opt.textContent = label;
        mobileSelect.appendChild(opt);
      }
    });

    if (mobileSelect) {
      mobileSelect.addEventListener('change', () => {
        const target = document.getElementById(mobileSelect.value);
        if (target) {
          const y = target.getBoundingClientRect().top + window.scrollY - 58;
          window.scrollTo({ top: y, behavior: 'smooth' });
        }
      });
    }

    const updateNavbarState = () => {
      const scrollY = window.scrollY;
      // Show secondary navbar once scrolled past hero (480px)
      if (scrollY > 480) {
        secondaryNav.classList.add(cls('is-visible'));
      } else {
        secondaryNav.classList.remove(cls('is-visible'));
      }

      // Highlight current section
      let currentId = navSections[0].id;
      navSections.forEach((sec) => {
        const rect = sec.getBoundingClientRect();
        if (rect.top <= 140) {
          currentId = sec.id;
        }
      });

      if (menuList) {
        menuList.querySelectorAll('a[data-section-target]').forEach((a) => {
          a.classList.toggle(cls('is-active'), a.getAttribute('data-section-target') === currentId);
        });
      }
      if (mobileSelect && mobileSelect.value !== currentId) {
        mobileSelect.value = currentId;
      }
    };

    window.addEventListener('scroll', updateNavbarState, { passive: true });
    updateNavbarState();
  }

  /* ========================================================================
     4. SCROLL TO TOP BUTTON
     ======================================================================== */
  function initScrollToTop() {
    const btn = document.querySelector('[data-car-pdp-scroll-top]');
    if (!btn) return;

    window.addEventListener('scroll', () => {
      if (window.scrollY > 600) {
        btn.classList.add(cls('is-visible'));
      } else {
        btn.classList.remove(cls('is-visible'));
      }
    }, { passive: true });

    btn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ========================================================================
     5. PRODUCT SUMMARY VARIANTS (VF 3 Eco / VF 3 Plus)
     ======================================================================== */
  function initProductSummaryVariants() {
    const layouts = document.querySelectorAll(`.${cls('car-pdp-v2-product-summary__layout')}`);
    layouts.forEach((layout) => {
      const variants = Array.from(layout.querySelectorAll('[data-car-pdp-product-summary-variant]'));
      if (variants.length < 2) return;

      const labels = variants.map((v) => {
        const btn = v.querySelector(`.${cls('car-pdp-v2-product-summary-variant__selector')}`);
        return btn ? btn.textContent.trim() : 'Phiên bản';
      });

      const activateVariant = (activeIndex) => {
        variants.forEach((v, idx) => {
          const isCurrent = idx === activeIndex;
          v.classList.toggle(cls('is-active'), isCurrent);
          const tabBtns = v.querySelectorAll(`.${cls('car-pdp-v2-product-summary__tab-btn')}`);
          tabBtns.forEach((b, bIdx) => {
            b.classList.toggle(cls('is-active'), bIdx === activeIndex);
            b.setAttribute('aria-pressed', bIdx === activeIndex ? 'true' : 'false');
          });
        });
      };

      // Build selector buttons inside each variant header
      variants.forEach((v) => {
        const selectorMount = v.querySelector('[data-car-pdp-variant-selectors]');
        if (!selectorMount) return;
        selectorMount.innerHTML = '';
        labels.forEach((label, idx) => {
          const tabBtn = document.createElement('button');
          tabBtn.type = 'button';
          tabBtn.className = cls('car-pdp-v2-product-summary__tab-btn');
          tabBtn.textContent = label;
          tabBtn.addEventListener('click', () => activateVariant(idx));
          selectorMount.appendChild(tabBtn);
        });
      });

      activateVariant(0);
    });
  }

  /* ========================================================================
     6. COLOR CUSTOMIZER (7 màu ngoại thất VF 3)
     ======================================================================== */
  function initColorCustomizer() {
    const section = document.querySelector('[data-car-pdp-customizer]');
    if (!section) return;

    const stageImg = section.querySelector('[data-car-pdp-customizer-image]');
    const stageSource = section.querySelector('[data-car-pdp-customizer-image-source]');
    const labelDisplay = section.querySelector('[data-car-pdp-customizer-label]');
    const options = Array.from(section.querySelectorAll('[data-car-pdp-customizer-option]'));
    const prevBtn = section.querySelector('[data-car-pdp-customizer-wheel-prev]');
    const nextBtn = section.querySelector('[data-car-pdp-customizer-wheel-next]');

    if (!stageImg || !options.length) return;

    let currentIdx = 0;

    // Preload all color images for instant switching
    options.forEach((opt) => {
      const desktopUrl = opt.getAttribute('data-option-image');
      const mobileUrl = opt.getAttribute('data-option-image-mobile');
      if (desktopUrl) {
        const img = new Image();
        img.src = desktopUrl;
      }
      if (mobileUrl) {
        const imgM = new Image();
        imgM.src = mobileUrl;
      }
    });

    const selectColor = (index) => {
      currentIdx = (index + options.length) % options.length;
      const activeOpt = options[currentIdx];

      options.forEach((opt, idx) => {
        const isActive = idx === currentIdx;
        opt.classList.toggle(cls('is-active'), isActive);
        opt.setAttribute('aria-pressed', isActive ? 'true' : 'false');
      });

      const desktopSrc = activeOpt.getAttribute('data-option-image');
      const mobileSrc = activeOpt.getAttribute('data-option-image-mobile') || desktopSrc;
      const label = activeOpt.getAttribute('data-option-label') || '';
      const alt = activeOpt.getAttribute('data-option-alt') || label;

      stageImg.classList.add(cls('is-switching'));
      setTimeout(() => {
        if (stageSource && mobileSrc) {
          stageSource.setAttribute('srcset', mobileSrc);
        }
        if (desktopSrc) {
          stageImg.setAttribute('src', desktopSrc);
        }
        stageImg.setAttribute('alt', alt);
        stageImg.classList.remove(cls('is-switching'));
      }, 120);

      if (labelDisplay) {
        labelDisplay.textContent = label;
      }

      activeOpt.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    };

    options.forEach((opt, idx) => {
      opt.addEventListener('click', () => selectColor(idx));
    });

    if (prevBtn) {
      prevBtn.addEventListener('click', () => selectColor(currentIdx - 1));
    }
    if (nextBtn) {
      nextBtn.addEventListener('click', () => selectColor(currentIdx + 1));
    }
  }

  /* ========================================================================
     7. FUEL COST COMPARISON CALCULATOR
     ======================================================================== */
  function initFuelCostComparison() {
    const wrapper = document.querySelector(`.${cls('fcc-wrapper')}`);
    if (!wrapper) return;

    const freeChargeCheckbox = document.getElementById('fcc_free_charging_policy');
    const versionTabs = wrapper.querySelectorAll(`.${cls('fcc-tabs--version')} .${cls('fcc-tab')}`);
    const versionInput = document.getElementById('fcc_version_key');
    const fuelTabs = wrapper.querySelectorAll(`.${cls('fcc-tabs--fuel')} .${cls('fcc-tab')}`);
    const fuelInput = document.getElementById('fcc_fuel_type');
    const kmInput = document.getElementById('fcc_monthly_km');
    const kmError = document.getElementById('fcc_monthly_km_error');
    const consInput = document.getElementById('fcc_fuel_consumption');
    const consError = document.getElementById('fcc_fuel_consumption_error');
    const compareBtn = document.getElementById('fcc_compare_btn');

    const defaultCard = document.getElementById('fcc_result_default');
    const resultCard = document.getElementById('fcc_result_data');
    const valEvMonthly = document.getElementById('fcc_val_ev_monthly');
    const valMonthly = document.getElementById('fcc_val_monthly');
    const valYearly = document.getElementById('fcc_val_yearly');
    const valCampaign = document.getElementById('fcc_val_campaign');

    // Tab switching for Version
    versionTabs.forEach((tab) => {
      tab.addEventListener('click', () => {
        versionTabs.forEach((t) => {
          t.classList.toggle(cls('is-active'), t === tab);
          t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
        });
        if (versionInput) versionInput.value = tab.getAttribute('data-value');
      });
    });

    // Tab switching for Fuel Type (Xăng / Dầu)
    fuelTabs.forEach((tab) => {
      tab.addEventListener('click', () => {
        fuelTabs.forEach((t) => {
          t.classList.toggle(cls('is-active'), t === tab);
          t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
        });
        if (fuelInput) fuelInput.value = tab.getAttribute('data-value');
      });
    });

    const formatVND = (num) => {
      return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    };

    const parseVNNumber = (str) => {
      if (!str) return NaN;
      const normalized = str.trim().replace(/\./g, '').replace(',', '.');
      return parseFloat(normalized);
    };

    if (compareBtn) {
      compareBtn.addEventListener('click', () => {
        let valid = true;
        kmError.textContent = '';
        consError.textContent = '';

        const kmRaw = kmInput.value.trim() || kmInput.getAttribute('placeholder') || '3000';
        const consRaw = consInput.value.trim() || consInput.getAttribute('placeholder') || '8';

        const km = parseVNNumber(kmRaw);
        const cons = parseVNNumber(consRaw);

        if (isNaN(km) || km <= 0 || km > 100000) {
          kmError.textContent = 'Vui lòng nhập quãng đường hợp lệ (ví dụ: 3000).';
          valid = false;
        }
        if (isNaN(cons) || cons <= 0 || cons > 50) {
          consError.textContent = 'Vui lòng nhập mức tiêu thụ nhiên liệu hợp lệ (ví dụ: 6,5).';
          valid = false;
        }

        if (!valid) return;

        if (!kmInput.value.trim()) kmInput.value = kmRaw;
        if (!consInput.value.trim()) consInput.value = consRaw;

        // Prices from page notes:
        // Gasoline: 21.150 VNĐ/lít, Diesel: 30.090 VNĐ/lít
        const fuelType = fuelInput ? fuelInput.value : 'DIESEL';
        const fuelUnitPrice = fuelType === 'GASOLINE' ? 21150 : 30090;

        // ICE monthly cost
        const iceMonthlyCost = (km / 100) * cons * fuelUnitPrice;

        // EV monthly cost:
        // VF 3 battery: 18.64 kWh / 215 km (~8.67 kWh/100km), charging price ~3,858 VNĐ/kWh
        // When V-Green free charging is active, EV cost = 0 VNĐ
        const isFreeCharging = freeChargeCheckbox ? freeChargeCheckbox.checked : false;
        const evMonthlyCost = isFreeCharging ? 0 : (km / 100) * 8.67 * 3858;

        const monthlySaved = Math.max(0, iceMonthlyCost - evMonthlyCost);
        const yearlySaved = monthlySaved * 12;
        // 36 months campaign window (10/02/2026 -> 10/02/2029)
        const campaignSaved = monthlySaved * 36;

        valEvMonthly.textContent = formatVND(evMonthlyCost);
        valMonthly.textContent = formatVND(monthlySaved);
        valYearly.textContent = formatVND(yearlySaved);
        valCampaign.textContent = formatVND(campaignSaved);

        if (defaultCard) defaultCard.hidden = true;
        if (resultCard) resultCard.hidden = false;
      });
    }
  }

  /* ========================================================================
     8. IMAGE INTRODUCE SCROLL EXPAND ANIMATION
     ======================================================================== */
  function initImageIntroduceScrollExpand() {
    const section = document.querySelector('[data-car-pdp-image-introduce]');
    if (!section) return;

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.intersectionRatio >= 0.45) {
            section.classList.add(cls('is-expanded'));
          } else if (entry.intersectionRatio < 0.2) {
            section.classList.remove(cls('is-expanded'));
          }
        });
      },
      { threshold: [0, 0.2, 0.45, 0.75, 1] }
    );

    observer.observe(section);
  }

  /* ========================================================================
     9. GALLERY INTRODUCE SWIPER (Diện mạo)
     ======================================================================== */
  function initGallerySwiper() {
    const swiperEl = document.querySelector('[data-gallery-swiper]');
    if (!swiperEl) return;

    const wrapper = swiperEl.querySelector('[data-swiper-wrapper]');
    const slides = Array.from(swiperEl.querySelectorAll(`.${cls('car-pdp-v2-gallery-introduce__slide')}`));
    const prevBtn = swiperEl.querySelector('[data-swiper-prev]');
    const nextBtn = swiperEl.querySelector('[data-swiper-next]');
    const pagination = swiperEl.querySelector('[data-swiper-pagination]');

    if (!wrapper || !slides.length) return;

    let currentIndex = 1; // Start at slide 2 (red urban car centered) like screenshot

    // Build pagination bullets
    const bullets = slides.map((_, idx) => {
      const b = document.createElement('span');
      b.className = cls('swiper-pagination-bullet');
      b.addEventListener('click', () => goToSlide(idx));
      if (pagination) pagination.appendChild(b);
      return b;
    });

    const updateCarousel = () => {
      const slideWidth = slides[0].offsetWidth;
      const gap = 20;
      const containerWidth = swiperEl.offsetWidth;
      const centerOffset = (containerWidth - slideWidth) / 2;
      const translateX = centerOffset - currentIndex * (slideWidth + gap);

      wrapper.style.transform = `translate3d(${translateX}px, 0, 0)`;

      slides.forEach((s, idx) => {
        s.classList.toggle(cls('is-active'), idx === currentIndex);
      });
      bullets.forEach((b, idx) => {
        b.classList.toggle(cls('is-active'), idx === currentIndex);
      });
    };

    const goToSlide = (idx) => {
      currentIndex = (idx + slides.length) % slides.length;
      updateCarousel();
    };

    if (prevBtn) prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));
    if (nextBtn) nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));

    // Touch swipe support
    let startX = 0;
    wrapper.addEventListener('touchstart', (e) => {
      startX = e.touches[0].clientX;
    }, { passive: true });

    wrapper.addEventListener('touchend', (e) => {
      const diff = e.changedTouches[0].clientX - startX;
      if (Math.abs(diff) > 40) {
        if (diff < 0) goToSlide(currentIndex + 1);
        else goToSlide(currentIndex - 1);
      }
    }, { passive: true });

    window.addEventListener('resize', updateCarousel);
    setTimeout(updateCarousel, 50);
  }

  /* ========================================================================
     10. VIDEO AUTOPLAY ON VIEWPORT
     ======================================================================== */
  function initVideoAutoplay() {
    const videos = document.querySelectorAll('[data-car-pdp-video-autoplay]');
    if (!videos.length) return;

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          const video = entry.target;
          if (entry.isIntersecting) {
            video.play().catch(() => {});
          } else {
            video.pause();
          }
        });
      },
      { threshold: 0.25 }
    );

    videos.forEach((v) => observer.observe(v));
  }

  /* ========================================================================
     11. TECHNICAL SPECS TABS (Kích thước, Pin & Sạc, Công nghệ trang bị)
     ======================================================================== */
  function initSpecsTabs() {
    const specsSection = document.querySelector('[data-car-pdp-specs]');
    if (!specsSection) return;

    const triggers = Array.from(specsSection.querySelectorAll('[data-car-pdp-spec-group-trigger]'));
    const panels = Array.from(specsSection.querySelectorAll('[data-car-pdp-spec-group]'));

    triggers.forEach((trigger) => {
      trigger.addEventListener('click', () => {
        const groupId = trigger.getAttribute('data-car-pdp-spec-group-id');

        triggers.forEach((t) => {
          const isCurrent = t === trigger;
          t.classList.toggle(cls('is-active'), isCurrent);
          t.setAttribute('aria-expanded', isCurrent ? 'true' : 'false');
        });

        panels.forEach((panel) => {
          const isMatch = panel.getAttribute('data-car-pdp-spec-group-id') === groupId;
          panel.classList.toggle(cls('is-active'), isMatch);
          panel.hidden = !isMatch;
        });
      });
    });
  }

  /* ========================================================================
     12. LEAD FORMS (Inline & Modal Dialog)
     ======================================================================== */
  function initLeadForms() {
    const dialog = document.querySelector('[data-car-pdp-lead-dialog]');
    const openBtns = document.querySelectorAll('[data-car-pdp-lead-open]');
    const closeBtn = document.querySelector('[data-car-pdp-lead-dialog-close]');

    if (dialog) {
      openBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
          if (typeof dialog.showModal === 'function') {
            dialog.showModal();
          } else {
            dialog.setAttribute('open', '');
          }
        });
      });

      if (closeBtn) {
        closeBtn.addEventListener('click', () => {
          if (typeof dialog.close === 'function') {
            dialog.close();
          } else {
            dialog.removeAttribute('open');
          }
        });
      }

      dialog.addEventListener('click', (e) => {
        if (e.target === dialog) {
          dialog.close();
        }
      });
    }

    const phoneRegex = /^(03|05|07|08|09|01[2689])[0-9]{8}$/;

    // Inline form validation
    const inlineForm = document.getElementById('lead-pdp-popup-form');
    const inlineTerms = document.getElementById('consult-terms-checkbox');
    const inlineSubmit = document.getElementById('consult-confirm-submit');
    const inlineSuccess = document.getElementById('consult-success-msg');

    if (inlineTerms && inlineSubmit) {
      inlineTerms.addEventListener('change', () => {
        inlineSubmit.disabled = !inlineTerms.checked;
        inlineSubmit.classList.toggle(cls('is-disabled'), !inlineTerms.checked);
      });
    }

    if (inlineForm) {
      inlineForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const nameEl = document.getElementById('consult_field_name');
        const phoneEl = document.getElementById('consult_field_phone_number');
        const nameErr = document.getElementById('error-field_name');
        const phoneErr = document.getElementById('error-field_phone_number');

        nameErr.textContent = '';
        phoneErr.textContent = '';
        let ok = true;

        if (!nameEl.value.trim()) {
          nameErr.textContent = 'Vui lòng nhập họ và tên.';
          ok = false;
        }
        if (!phoneRegex.test(phoneEl.value.trim())) {
          phoneErr.textContent = 'Số điện thoại không hợp lệ (10 số).';
          ok = false;
        }

        if (ok && inlineSuccess) {
          inlineSuccess.hidden = false;
          inlineForm.reset();
          inlineSubmit.disabled = true;
          inlineSubmit.classList.add(cls('is-disabled'));
        }
      });
    }

    // Modal form validation & char counter
    const footerForm = document.getElementById('lead-pdp-footer-form');
    const footerTerms = document.getElementById('footer-terms-checkbox');
    const footerSubmit = document.getElementById('footer-confirm-submit');
    const footerNotes = document.getElementById('footer_field_additional_info');
    const footerCharCount = document.getElementById('footer-char-count');
    const footerSuccess = document.getElementById('footer-success-msg');

    if (footerNotes && footerCharCount) {
      footerNotes.addEventListener('input', () => {
        footerCharCount.textContent = footerNotes.value.length;
      });
    }

    if (footerTerms && footerSubmit) {
      footerTerms.addEventListener('change', () => {
        footerSubmit.disabled = !footerTerms.checked;
        footerSubmit.classList.toggle(cls('is-disabled'), !footerTerms.checked);
      });
    }

    if (footerForm) {
      footerForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const nameEl = document.getElementById('footer_field_name');
        const phoneEl = document.getElementById('footer_field_phone_number');
        const emailEl = document.getElementById('footer_field_email');
        const nameErr = document.getElementById('footer-error-field_name');
        const phoneErr = document.getElementById('footer-error-field_phone_number');
        const emailErr = document.getElementById('footer-error-field_email');

        nameErr.textContent = '';
        phoneErr.textContent = '';
        emailErr.textContent = '';
        let ok = true;

        if (!nameEl.value.trim()) {
          nameErr.textContent = 'Vui lòng nhập họ và tên.';
          ok = false;
        }
        if (!phoneRegex.test(phoneEl.value.trim())) {
          phoneErr.textContent = 'Số điện thoại không hợp lệ.';
          ok = false;
        }
        if (!emailEl.value.trim() || !emailEl.value.includes('@')) {
          emailErr.textContent = 'Vui lòng nhập email hợp lệ.';
          ok = false;
        }

        if (ok && footerSuccess) {
          footerSuccess.hidden = false;
          footerForm.reset();
          if (footerCharCount) footerCharCount.textContent = '0';
          footerSubmit.disabled = true;
          footerSubmit.classList.add(cls('is-disabled'));
        }
      });
    }
  }

  /* ========================================================================
     13. FOOTER ACCORDIONS (Tin tức, Điều khoản chính sách)
     ======================================================================== */
  function initFooterAccordions() {
    const items = document.querySelectorAll('[data-footer-accordion]');
    items.forEach((item) => {
      const header = item.querySelector(`.${cls('header')}`);
      const subMenu = item.querySelector(`.${cls('sub-menu')}`);
      if (header && subMenu) {
        header.addEventListener('click', () => {
          const isHidden = subMenu.classList.contains(cls('d-none'));
          subMenu.classList.toggle(cls('d-none'), !isHidden);
          item.classList.toggle(cls('is-open'), isHidden);
        });
      }
    });
  }
})();
