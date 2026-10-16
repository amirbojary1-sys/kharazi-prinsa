/* ============================================================
   Prinsa FX — 3D scroll decorations · day/night theme · UI
   Pure vanilla JS, no dependencies
   ============================================================ */
(function () {
  'use strict';

  /* ---------------- theme (day / night) ---------------- */
  const root = document.documentElement;
  const savedTheme = localStorage.getItem('prinsa_theme') || 'light';
  root.setAttribute('data-theme', savedTheme);

  function toggleTheme() {
    const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    root.setAttribute('data-theme', next);
    localStorage.setItem('prinsa_theme', next);
    const label = document.getElementById('themeLabel');
    if (label) label.textContent = next === 'dark' ? label.dataset.day : label.dataset.night;
    const icon = document.getElementById('themeIcon');
    if (icon) icon.textContent = next === 'dark' ? '☀️' : '🌙';
  }

  /* ---------------- scroll progress ---------------- */
  const progress = document.getElementById('scrollProgress');

  /* ---------------- reveal on scroll ---------------- */
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) {
        e.target.classList.add('in');
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  document.querySelectorAll('.reveal').forEach((el) => io.observe(el));

  /* ---------------- 3D floating shapes (parallax + rotate) ---------------- */
  const shapes = Array.from(document.querySelectorAll('[data-speed]')).map((el) => ({
    el,
    speed: parseFloat(el.dataset.speed) || 0.2,
    rot: parseFloat(el.dataset.rot) || 0.04,
    baseX: el.offsetLeft,
    baseY: el.offsetTop,
  }));

  /* ---------------- hero depth layers ---------------- */
  const heroVisual = document.querySelector('.hero-visual');
  const heroTitle = document.querySelector('.hero h1');
  const heroSection = document.querySelector('.hero');

  /* ---------------- scroll-rotate cards ---------------- */
  const scrubCards = Array.from(document.querySelectorAll('.scr-rotate'));

  /* ---------------- animated counters ---------------- */
  const counters = document.querySelectorAll('[data-count]');
  if (counters.length) {
    const cio = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (!e.isIntersecting) return;
        const el = e.target;
        cio.unobserve(el);
        const target = parseFloat(el.dataset.count) || 0;
        const dur = 1600;
        const t0 = performance.now();
        (function tick(now) {
          const p = Math.min((now - t0) / dur, 1);
          const eased = 1 - Math.pow(1 - p, 3);
          el.textContent = Math.round(target * eased).toLocaleString(document.documentElement.lang === 'fa' ? 'fa-IR' : 'en-US');
          if (p < 1) requestAnimationFrame(tick);
        })(t0);
      });
    }, { threshold: 0.4 });
    counters.forEach((el) => cio.observe(el));
  }

  /* ---------------- parallax banner backgrounds ---------------- */
  const parallaxBgs = Array.from(document.querySelectorAll('[data-bg-parallax]')).map((el) => ({
    el,
    speed: parseFloat(el.dataset.bgParallax) || 0.12,
  }));

  /* ---------------- rAF scroll loop ---------------- */
  let ticking = false;
  function onScroll() {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(() => {
      const y = window.scrollY;
      const vh = window.innerHeight;

      if (progress) {
        const max = document.documentElement.scrollHeight - vh;
        progress.style.width = (max > 0 ? (y / max) * 100 : 0) + '%';
      }

      // floating 3D shapes
      shapes.forEach((s) => {
        const ty = y * s.speed;
        const rx = y * s.rot;
        const ry = y * s.rot * 1.35;
        s.el.style.transform =
          `translate3d(0, ${ty}px, 0) rotateX(${rx}deg) rotateY(${ry}deg) rotateZ(${rx * 0.6}deg)`;
      });

      // hero parallax depth
      if (heroSection && y < vh * 1.2) {
        if (heroVisual) {
          heroVisual.style.transform = `translate3d(0, ${y * 0.16}px, 0) rotateX(${Math.min(y * 0.012, 7)}deg)`;
        }
        if (heroTitle) {
          heroTitle.style.transform = `translate3d(0, ${y * -0.06}px, 0)`;
          heroTitle.style.opacity = String(Math.max(1 - y / (vh * 0.9), 0));
        }
      }

      // parallax banner backgrounds
      parallaxBgs.forEach((b) => {
        const r = b.el.getBoundingClientRect();
        if (r.bottom > 0 && r.top < vh) {
          const offset = (r.top + r.height / 2 - vh / 2) * b.speed;
          b.el.style.transform = `translate3d(0, ${offset}px, 0) scale(1.08)`;
        }
      });

      // scroll-driven 3D rotation of product cards
      scrubCards.forEach((card) => {
        const r = card.getBoundingClientRect();
        const center = r.top + r.height / 2;
        const dist = (center - vh / 2) / vh;      // -1 .. 1
        const rotY = Math.max(-10, Math.min(10, dist * -14));
        const rotX = Math.max(-8, Math.min(8, dist * 10));
        const scale = 1 - Math.min(Math.abs(dist) * 0.05, 0.05);
        card.style.transform = `rotateY(${rotY}deg) rotateX(${rotX}deg) scale(${scale})`;
      });

      ticking = false;
    });
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);
  onScroll();

  /* ---------------- 3D tilt on mouse ---------------- */
  document.querySelectorAll('.tilt').forEach((card) => {
    card.addEventListener('mousemove', (e) => {
      const r = card.getBoundingClientRect();
      const px = (e.clientX - r.left) / r.width - 0.5;
      const py = (e.clientY - r.top) / r.height - 0.5;
      card.style.transform = `perspective(900px) rotateY(${px * 14}deg) rotateX(${-py * 14}deg) translateY(-6px)`;
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
    });
  });

  /* ---------------- header / menu ---------------- */
  document.addEventListener('click', (e) => {
    const themeBtn = e.target.closest('[data-action="toggle-theme"]');
    if (themeBtn) { toggleTheme(); return; }

    const burger = e.target.closest('[data-action="toggle-menu"]');
    if (burger) {
      const nav = document.getElementById('mainNav');
      if (nav) nav.classList.toggle('open');
      return;
    }

    // footer accordion (mobile)
    const ft = e.target.closest('.footer-toggle');
    if (ft) {
      ft.closest('.footer-col').classList.toggle('open');
      return;
    }

    // qty + / −
    const q = e.target.closest('[data-action="qty"]');
    if (q) {
      const input = q.parentElement.querySelector('input');
      const d = parseInt(q.dataset.d || '1', 10);
      const v = Math.max(1, (parseInt(input.value, 10) || 1) + d);
      input.value = v;
      return;
    }

    const closeBtn = e.target.closest('[data-action="close-modal"]');
    if (closeBtn) {
      const wrap = document.getElementById('modalWrap');
      if (wrap) wrap.innerHTML = '';
    }
  });

  /* ---------------- checkout: pay method selection ---------------- */
  document.querySelectorAll('.pay-option input[type="radio"]').forEach((r) => {
    r.addEventListener('change', () => {
      document.querySelectorAll('.pay-option').forEach((el) => el.classList.remove('selected'));
      r.closest('.pay-option').classList.add('selected');
      const cardInfo = document.getElementById('cardInfo');
      if (cardInfo) cardInfo.style.display = r.value === 'card' ? 'block' : 'none';
    });
  });

  /* ---------------- toasts ---------------- */
  document.querySelectorAll('.toast').forEach((el) => {
    setTimeout(() => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(10px)';
      setTimeout(() => el.remove(), 300);
    }, 3200);
  });

  /* ---------------- admin status selects ---------------- */
  document.querySelectorAll('select[data-autosubmit]').forEach((sel) => {
    sel.addEventListener('change', () => sel.closest('form').submit());
  });
})();
