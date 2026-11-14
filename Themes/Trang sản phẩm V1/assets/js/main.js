(() => {
  'use strict';
  const P='vinfast-autohaiphong_product_';
  const $=(selector,root=document)=>root.querySelector(selector);
  const $$=(selector,root=document)=>Array.from(root.querySelectorAll(selector));
  const pref=(name)=>'.'+P+name;
  const cfg=window.VINFAST_AUTOHAIPHONG_VF3;
  if(!cfg)return;
  const VND = new Intl.NumberFormat('vi-VN',{style:'currency',currency:'VND',maximumFractionDigits:0});
  let lastFocus=null,heroIndex=0,colorIndex=3,galleryIndex=0,lightboxIndex=0,heroTimer;
  const heroSlides=$$(pref('hero-slide'));
  const galleryTrack=$('[data-design-track]');
  const galleryImages=galleryTrack?$$('img',galleryTrack):[];
  const lbImgs=$$('[data-lightbox] img').map(x=>({src:x.getAttribute('src'),alt:x.alt}));
  const interior=$('[data-lightbox="6"] img');
  if(interior)lbImgs[6]={src:interior.getAttribute('src'),alt:interior.alt};

  const selectTrim=key=>{
    const trim=cfg.trims[key];if(!trim)return;
    $$('[data-trim]').forEach(btn=>{const active=btn.dataset.trim===key;btn.classList.toggle(P+'is-active',active);btn.setAttribute('aria-pressed',String(active));});
    const price=$('[data-price]');if(price)price.textContent=VND.format(trim.price);
    // Giá được thay đổi trong giao diện demo, không tự tính ưu đãi hoặc chi phí thực tế.
  };
  const initColors=()=>{
    const host=$('[data-swatches]');if(!host)return;
    cfg.colors.forEach((color,i)=>{
      const button=document.createElement('button');button.type='button';button.className=P+'color-dot';button.style.background=color.value;
      button.dataset.color=String(i);button.title=color.name;button.setAttribute('aria-label','Màu '+color.name);host.appendChild(button);
    });
    renderColor(colorIndex);
  };
  const renderColor=index=>{
    colorIndex=(index+cfg.colors.length)%cfg.colors.length;
    const color=cfg.colors[colorIndex],car=$('[data-color-car]'),label=$('[data-color-name]');
    if(car){car.style.filter=color.filter;car.alt='Mô phỏng VF 3 màu '+color.name;}
    if(label)label.textContent=color.name;
    $$('[data-color]').forEach(btn=>{const active=Number(btn.dataset.color)===colorIndex;btn.classList.toggle(P+'is-active',active);btn.setAttribute('aria-pressed',String(active));});
  };
  const renderSpecs=key=>{
    const block=cfg.specGroups[key];if(!block)return;
    const title=$('[data-spec-title]'),host=$('[data-spec-content]');
    if(title)title.textContent=block.title;
    if(host){host.replaceChildren();block.rows.forEach(([name,value])=>{
      const row=document.createElement('div');row.className=P+'spec-row';
      const left=document.createElement('span'),right=document.createElement('span');left.textContent=name;right.textContent=value;row.append(left,right);host.appendChild(row);
    });}
    $$('[data-spec-tab]').forEach(btn=>{const active=btn.dataset.specTab===key;btn.classList.toggle(P+'is-active',active);btn.setAttribute('aria-selected',String(active));btn.tabIndex=active?0:-1;});
  };
  const renderDesign=i=>{
    const txt=$('[data-design-description]');if(txt)txt.textContent=cfg.designHighlights[i];
    $$('[data-design-tab]').forEach(btn=>{const active=Number(btn.dataset.designTab)===i;btn.classList.toggle(P+'is-active',active);btn.setAttribute('aria-selected',String(active));btn.tabIndex=active?0:-1;});
  };
  const renderCompare=()=>{
    const distance=Number($('[data-calc="distance"]')?.value)||0;
    const electricity=Math.max(0,Number($('[data-calc="electricity"]')?.value)||0);
    const petrol=Math.max(0,Number($('[data-calc="petrol"]')?.value)||0);
    const electricCost=distance/100*12*electricity;
    const petrolCost=distance/100*6*petrol;
    const label=$('[data-calc-label="distance"]');if(label)label.textContent=distance.toLocaleString('vi-VN')+' km';
    [['electric',electricCost],['petrol',petrolCost],['saving',petrolCost-electricCost]].forEach(([key,val])=>{
      const result=$(`[data-calc-result="${key}"]`);if(result)result.textContent=VND.format(val)+(key==='saving'?'/năm':'');
    });
  };
  const setHero=i=>{
    if(!heroSlides.length)return;
    heroIndex=(i+heroSlides.length)%heroSlides.length;
    heroSlides.forEach((slide,index)=>{slide.classList.toggle(P+'hero-slide-active',index===heroIndex);slide.setAttribute('aria-hidden',String(index!==heroIndex));});
    $$('[data-hero-dot]').forEach((dot,index)=>{const active=index===heroIndex;dot.classList.toggle(P+'is-active',active);dot.setAttribute('aria-pressed',String(active));});
  };
  const restartHero=()=>{
    window.clearInterval(heroTimer);
    if(window.matchMedia('(prefers-reduced-motion: reduce)').matches)return;
    heroTimer=window.setInterval(()=>{if(!document.hidden)setHero(heroIndex+1)},7000);
  };
  const moveGallery=delta=>{if(!galleryImages.length)return;galleryIndex=(galleryIndex+delta+galleryImages.length)%galleryImages.length;galleryTrack.style.transform=`translateX(-${galleryIndex*100}%)`;};
  const openModal=()=>{
    lastFocus=document.activeElement;const modal=$('[data-modal]');if(!modal)return;
    modal.hidden=false;document.body.style.overflow='hidden';modal.querySelector('input')?.focus();
  };
  const closeModal=()=>{
    const modal=$('[data-modal]');if(!modal)return;modal.hidden=true;document.body.style.overflow='';lastFocus?.focus?.();
  };
  const openLightbox=i=>{
    lightboxIndex=(i+lbImgs.length)%lbImgs.length;
    lastFocus=document.activeElement;
    const modal=$('[data-lightbox-modal]');if(!modal)return;
    modal.hidden=false;document.body.style.overflow='hidden';renderLightbox();modal.querySelector(pref('lightbox-close'))?.focus();
  };
  const renderLightbox=()=>{
    const record=lbImgs[lightboxIndex];if(!record)return;
    const img=$('[data-lightbox-image]'),label=$('[data-lightbox-count]');
    if(img){img.src=record.src;img.alt=record.alt;}if(label)label.textContent=`${lightboxIndex+1} / ${lbImgs.length}`;
  };
  const closeLightbox=()=>{
    const modal=$('[data-lightbox-modal]');if(modal)modal.hidden=true;document.body.style.overflow='';lastFocus?.focus?.();
  };
  const moveLightbox=delta=>{lightboxIndex=(lightboxIndex+delta+lbImgs.length)%lbImgs.length;renderLightbox();};
  const setMenu=open=>{
    const mobile=pref('mobile-nav');const nav=$(mobile),btn=$(pref('menu-toggle'));
    if(!nav||!btn)return;nav.hidden=!open;btn.setAttribute('aria-expanded',String(open));btn.setAttribute('aria-label',open?'Đóng menu':'Mở menu');
  };
  const scrollTop=()=>window.scrollTo({top:0,behavior:'smooth'});
  const actions={
    'menu':()=>setMenu($('[data-action="menu"]')?.getAttribute('aria-expanded')!=='true'),
    'consult':openModal,'close-modal':closeModal,'close-lightbox':closeLightbox,
    'top':scrollTop,
    'hero-prev':()=>{setHero(heroIndex-1);restartHero()},'hero-next':()=>{setHero(heroIndex+1);restartHero()},
    'color-prev':()=>renderColor(colorIndex-1),'color-next':()=>renderColor(colorIndex+1),
    'gallery-prev':()=>moveGallery(-1),'gallery-next':()=>moveGallery(1),
    'lightbox-prev':()=>moveLightbox(-1),'lightbox-next':()=>moveLightbox(1)
  };
  document.addEventListener('click',e=>{
    const target=e.target.closest('[data-action]');
    if(target){const action=actions[target.dataset.action];if(action){e.preventDefault();action();return;}}
    const trim=e.target.closest('[data-trim]');if(trim){selectTrim(trim.dataset.trim);return;}
    const color=e.target.closest('[data-color]');if(color){renderColor(Number(color.dataset.color));return;}
    const spec=e.target.closest('[data-spec-tab]');if(spec){renderSpecs(spec.dataset.specTab);return;}
    const design=e.target.closest('[data-design-tab]');if(design){renderDesign(Number(design.dataset.designTab));return;}
    const dot=e.target.closest('[data-hero-dot]');if(dot){setHero(Number(dot.dataset.heroDot));restartHero();return;}
    const img=e.target.closest('[data-lightbox]');if(img){openLightbox(Number(img.dataset.lightbox));return;}
    const nav=e.target.closest(pref('mobile-nav')+' a');if(nav)setMenu(false);
  });
  document.addEventListener('keydown',e=>{
    const modal=$('[data-modal]'),lightbox=$('[data-lightbox-modal]');
    if(e.key==='Escape'){if(lightbox&&!lightbox.hidden)closeLightbox();else if(modal&&!modal.hidden)closeModal();else setMenu(false);return;}
    if(lightbox&&!lightbox.hidden){if(e.key==='ArrowRight')moveLightbox(1);if(e.key==='ArrowLeft')moveLightbox(-1);}
    if((e.key==='Enter'||e.key===' ')&&e.target.matches('[data-lightbox]')){e.preventDefault();openLightbox(Number(e.target.dataset.lightbox));}
  });
  $$('[data-calc]').forEach(input=>input.addEventListener('input',renderCompare));
  const form=$('[data-consult-form]');if(form)form.addEventListener('submit',e=>{
    e.preventDefault();if(!form.reportValidity())return;
    const status=$('[data-form-status]');if(status)status.textContent='Thông tin hợp lệ. Đây chỉ là bản demo giao diện: dữ liệu chưa được gửi đến máy chủ hoặc lưu trữ. Bạn có thể tích hợp API Laravel để xử lý.';
    // Không lưu thông tin cá nhân trong localStorage và không mô phỏng giao dịch thành công.
  });
  const onScroll=()=>{const y=window.scrollY;$(pref('header'))?.classList.toggle(P+'header-scrolled',y>10);$(pref('float-top'))?.classList.toggle(P+'is-visible',y>400);};
  window.addEventListener('scroll',onScroll,{passive:true});
  onScroll();
  if('IntersectionObserver' in window&&!window.matchMedia('(prefers-reduced-motion: reduce)').matches){
    document.documentElement.classList.add(P+'js-reveal');
    const observer=new IntersectionObserver(entries=>entries.forEach(entry=>{if(entry.isIntersecting){entry.target.classList.add(P+'revealed');observer.unobserve(entry.target);}}),{rootMargin:'0px 0px -30px 0px',threshold:.08});
    $$('[data-reveal]').forEach(el=>observer.observe(el));
  }
  // Trên web có mạng có thể thay ảnh chụp fallback bằng ảnh chất lượng cao có URL nguồn.
  $$('img[data-remote-image]').forEach(img=>{
    const remote=img.dataset.remoteImage;
    if(!/^https:\/\//.test(remote))return;
    const candidate=new Image();candidate.referrerPolicy='no-referrer';
    candidate.onload=()=>{if(candidate.naturalWidth>300){img.src=remote;const index=lbImgs.findIndex(o=>o&&o.src===img.getAttribute('src'));if(index>=0)lbImgs[index].src=remote;}};
    candidate.onerror=()=>{};
    candidate.src=remote;
  });
  // Thư viện giữ ảnh offline làm đường lui; đồng bộ ảnh sau khi remote tải thành công.
  $$('[data-lightbox] img').forEach((img)=>img.addEventListener('load',()=>{
    const parent=img.closest('[data-lightbox]');if(!parent)return;
    const n=Number(parent.dataset.lightbox);if(lbImgs[n])lbImgs[n]={src:img.currentSrc||img.src,alt:img.alt};
  }));
  selectTrim('plus');initColors();renderSpecs('dimensions');renderDesign(0);renderCompare();setHero(0);restartHero();
  window.addEventListener('pagehide',()=>window.clearInterval(heroTimer),{once:true});
})();
