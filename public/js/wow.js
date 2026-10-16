/* ============================================================
   Prinsa WOW — 3D scroll story · coverflow · color studio ·
   preloader · mega menu (mobile)
   ============================================================ */
(function () {
  'use strict';

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------------- preloader ---------------- */
  window.addEventListener('load', () => {
    const pre = document.getElementById('preloader');
    if (pre) setTimeout(() => pre.remove(), 400);
  });

  /* ---------------- mega menu (mobile accordion) ---------------- */
  document.addEventListener('click', (e) => {
    const trg = e.target.closest('.mega-trigger');
    if (trg && window.innerWidth <= 880) {
      e.preventDefault();
      trg.closest('.has-mega').classList.toggle('open');
    }
  });

  /* ============================================================
     PHOTO STORY — real photos crossfade + Ken Burns with scroll
     (cinematic, photography-first — no cartoons)
     ============================================================ */
  const psStory = document.querySelector('[data-photo-story]');
  if (psStory) {
    const slides = Array.from(psStory.querySelectorAll('[data-ps]'));
    const bgs = slides.map((sl) => sl.querySelector('.bg'));
    const caps = Array.from(psStory.querySelectorAll('[data-ps-cap]'));
    const bars = Array.from(psStory.querySelectorAll('.ps-bar i'));

    let ticking = false;
    function psUpdate() {
      const r = psStory.getBoundingClientRect();
      const total = Math.max(1, r.height - window.innerHeight);
      const p = Math.min(1, Math.max(0, -r.top / total));
      const n = slides.length;
      const pos = p * n;

      slides.forEach((s, i) => {
        const local = pos - i;
        let o = 0;
        if (local > -0.4 && local < 1.4) {
          o = Math.max(0, 1 - Math.abs(local - 0.5) / 0.9);
        }
        s.style.opacity = o.toFixed(3);
        if (bgs[i]) {
          const sc = 1.16 - Math.min(Math.max(local, 0), 1) * 0.14;
          bgs[i].style.transform = 'scale(' + sc.toFixed(3) + ')';
        }
      });

      const idx = Math.min(n - 1, Math.floor(p * n * 0.999));
      caps.forEach((c, i) => c.classList.toggle('active', i === idx));
      bars.forEach((b, i) => b.classList.toggle('on', i === idx));
    }

    window.addEventListener('scroll', () => {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () { psUpdate(); ticking = false; });
    }, { passive: true });
    window.addEventListener('resize', psUpdate);
    psUpdate();
  }

  /* ---------------- 3D coverflow ---------------- */
  const cfRoot = document.querySelector('[data-cf-stage]');
  if (cfRoot) {
    const items = Array.from(cfRoot.querySelectorAll('[data-cf-item]'));
    const dotsWrap = document.querySelector('[data-cf-dots]');
    let current = Math.min(2, items.length - 1);
    let dragging = false, startX = 0, deltaX = 0;

    items.forEach((_, i) => {
      if (dotsWrap) {
        const b = document.createElement('button');
        b.addEventListener('click', () => { current = i; update(); });
        dotsWrap.appendChild(b);
      }
    });

    function update() {
      items.forEach((item, i) => {
        const off = i - current;
        const abs = Math.abs(off);
        const x = off * 230;
        const z = -abs * 180;
        const ry = off * -32;
        const sc = abs === 0 ? 1 : Math.max(0.68, 0.88 - abs * 0.08);
        item.style.transform = 'translateX(' + x + 'px) translateZ(' + z + 'px) rotateY(' + ry + 'deg) scale(' + sc + ')';
        item.style.opacity = abs > 2 ? 0 : (abs === 0 ? 1 : 0.55 + 0.15 * (2 - abs));
        item.style.zIndex = String(50 - abs);
        item.style.filter = abs === 0 ? 'none' : 'brightness(.82)';
        item.classList.toggle('is-center', abs === 0);
        item.style.pointerEvents = abs > 2 ? 'none' : 'auto';
      });
      if (dotsWrap) {
        Array.from(dotsWrap.children).forEach((d, i) => d.classList.toggle('active', i === current));
      }
    }
    update();

    const prevBtn = document.querySelector('[data-cf-prev]');
    const nextBtn = document.querySelector('[data-cf-next]');
    if (prevBtn) prevBtn.addEventListener('click', () => { current = Math.max(0, current - 1); update(); });
    if (nextBtn) nextBtn.addEventListener('click', () => { current = Math.min(items.length - 1, current + 1); update(); });

    cfRoot.addEventListener('pointerdown', (e) => {
      dragging = true; startX = e.clientX; deltaX = 0;
      cfRoot.setPointerCapture(e.pointerId);
    });
    cfRoot.addEventListener('pointermove', (e) => {
      if (!dragging) return;
      deltaX = e.clientX - startX;
    });
    const endDrag = () => {
      if (!dragging) return;
      dragging = false;
      if (deltaX > 60) current = Math.max(0, current - 1);
      else if (deltaX < -60) current = Math.min(items.length - 1, current + 1);
      update();
    };
    cfRoot.addEventListener('pointerup', endDrag);
    cfRoot.addEventListener('pointercancel', endDrag);

    window.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowLeft') { current = Math.max(0, current - 1); update(); }
      if (e.key === 'ArrowRight') { current = Math.min(items.length - 1, current + 1); update(); }
    });

    if (!reduceMotion) {
      setInterval(() => {
        current = current >= items.length - 1 ? 0 : current + 1;
        update();
      }, 5200);
    }
  }

  /* ---------------- color studio ---------------- */
  const studioImg = document.getElementById('studioImg');
  const studioName = document.getElementById('studioColorName');
  if (studioImg) {
    document.querySelectorAll('[data-hue]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const hue = btn.dataset.hue || '0';
        const sat = btn.dataset.sat || '1.12';
        studioImg.style.filter = 'hue-rotate(' + hue + 'deg) saturate(' + sat + ')';
        document.querySelectorAll('[data-hue]').forEach((b) => b.classList.remove('active'));
        btn.classList.add('active');
        if (studioName) studioName.textContent = btn.dataset.name || '';
      });
    });
  }
})();
