/* TNS Card landing page behaviour */
(function () {
  'use strict';
  var D = window.TNS || { bands: [], i18n: { en: {} } };
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isMobile = function () { return window.innerWidth <= 768; };
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

  /* ---------- adaptive rem (scale up above 1920) ---------- */
  function fitRem() {
    var FONT_BASE = 16, BASE_W = 1920, COEF = 0.6666;
    var reduction = ((BASE_W - window.innerWidth) / BASE_W) * 100 * COEF;
    var size = FONT_BASE - (FONT_BASE * reduction) / 100;
    if (size > FONT_BASE) document.documentElement.style.fontSize = size + 'px';
    else document.documentElement.style.removeProperty('font-size');
  }
  fitRem(); window.addEventListener('resize', fitRem);
  function fitTitle() {
    var h = $('#heroTitle'); if (!h) return;
    if (window.innerWidth < 768) { h.style.removeProperty('font-size'); return; }
    h.style.fontSize = '12.5vw';
    var cs = getComputedStyle(h); var pad = parseFloat(cs.paddingLeft) + parseFloat(cs.paddingRight);
    var avail = h.clientWidth - pad, need = h.scrollWidth - pad;
    if (need > avail) h.style.fontSize = (12.5 * avail / need * 0.985) + 'vw';
  }
  window.addEventListener('resize', fitTitle);

  /* ---------- smooth scroll ---------- */
  var lenis = null;
  if (window.Lenis && !reduce) {
    lenis = new window.Lenis({ smoothWheel: true });
    (function raf(t) { lenis.raf(t); requestAnimationFrame(raf); })(0);
  }
  var locks = 0;
  function lockScroll() { locks++; if (lenis) lenis.stop(); document.documentElement.style.overflow = 'hidden'; }
  function unlockScroll() { locks = Math.max(0, locks - 1); if (locks) return; if (lenis) lenis.start(); document.documentElement.style.removeProperty('overflow'); }
  function scrollToHash(hash) {
    var el = hash && hash !== '#' ? $(hash) : null; if (!el) return;
    if (lenis) lenis.scrollTo(el, { offset: -12 }); else el.scrollIntoView({ behavior: 'smooth' });
  }
  document.addEventListener('click', function (e) {
    var a = e.target.closest('a[href^="#"]'); if (!a) return;
    var hash = a.getAttribute('href'); if (hash.length < 2) return;
    e.preventDefault(); closeMenu(); scrollToHash(hash); history.replaceState(null, '', hash);
  });

  /* ---------- language ---------- */
  var lang = 'en';
  try {
    var q = new URLSearchParams(location.search).get('lang');
    lang = q || localStorage.getItem('tns_lang') || (navigator.language || '').slice(0, 2);
  } catch (e) { /* ignore */ }
  if (!D.i18n[lang]) lang = 'en';
  function t(key) { var d = D.i18n[lang] || {}; return key in d ? d[key] : (D.i18n.en[key] !== undefined ? D.i18n.en[key] : ''); }

  function applyLang() {
    document.documentElement.lang = lang;
    try { localStorage.setItem('tns_lang', lang); } catch (e) { /* ignore */ }
    $$('[data-lang]').forEach(function (b) { b.setAttribute('aria-pressed', String(b.getAttribute('data-lang') === lang)); });
    $$('[data-i18n]').forEach(function (el) {
      var v = t(el.getAttribute('data-i18n'));
      if (typeof v !== 'string') return;
      if (el.tagName === 'OPTION') el.textContent = v;
      else el.textContent = v;
    });
    var fl = $('#formLang'); if (fl) fl.value = lang;
    renderProducts(); renderColorCard(); renderShow(true);
    $$('[data-reveal]').forEach(prepareReveal);
    fitTitle();
    $$('[data-reveal]').forEach(function (el) { if (el.__seen && !el.hasAttribute('data-gated')) playReveal(el); });
    if (ready) $$('[data-reveal][data-gated]').forEach(playReveal);
  }
  $$('[data-lang]').forEach(function (b) { b.addEventListener('click', function () { lang = b.getAttribute('data-lang'); applyLang(); }); });

  /* ---------- reveals ---------- */
  function prepareReveal(el) {
    var mode = el.getAttribute('data-reveal');
    if (mode === 'words') {
      var text = el.textContent.trim();
      el.textContent = '';
      text.split(/\s+/).forEach(function (w, i, arr) {
        var clip = document.createElement('span'); clip.className = el.classList.contains('hero__title') ? 'clip' : 'word';
        if (clip.className === 'clip') { var inner = document.createElement('span'); inner.textContent = w; clip.appendChild(inner); }
        else clip.textContent = w;
        el.appendChild(clip);
        if (i < arr.length - 1) el.appendChild(document.createTextNode(' '));
      });
    } else if (mode === 'lines') {
      $$(':scope > span, :scope > .clip', el).forEach(function (line) {
        if (line.classList.contains('clip')) { var txt = line.textContent; line.innerHTML = ''; var s = document.createElement('span'); s.textContent = txt; line.appendChild(s); return; }
        var key = line.getAttribute('data-i18n'); var txt2 = line.textContent;
        var clip = document.createElement('span'); clip.className = 'clip'; if (key) clip.setAttribute('data-i18n', key);
        var inner = document.createElement('span'); inner.textContent = txt2; clip.appendChild(inner);
        line.replaceWith(clip);
      });
    }
    el.__prepared = true;
  }
  function playReveal(el) {
    var mode = el.getAttribute('data-reveal');
    var stagger = +el.getAttribute('data-stagger') || (mode === 'words' ? 60 : 120);
    var base = +el.getAttribute('data-base') || 0;
    var dur = el.getAttribute('data-duration');
    var items = mode === 'words' ? $$('.clip, .word', el) : $$('.clip', el);
    items.forEach(function (it, i) {
      it.classList.remove('is-in'); void it.offsetWidth;
      it.style.setProperty('--delay', (base + i * stagger) + 'ms'); if (dur) it.style.setProperty('--d', dur + 'ms');
      it.classList.add('is-in');
    });
  }
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (en) {
      if (!en.isIntersecting) return;
      var el = en.target; io.unobserve(el); el.__seen = true;
      if (el.hasAttribute('data-reveal')) { if (!el.hasAttribute('data-gated')) playReveal(el); }
      else { el.style.setProperty('--delay', (el.getAttribute('data-delay') || 0) + 'ms'); el.classList.add('is-in'); }
    });
  }, { threshold: 0.15 });

  /* ---------- parallax ---------- */
  var plx = $$('[data-parallax]').map(function (el) { var p = el.getAttribute('data-parallax').split(','); return { el: el, from: +p[0], to: +p[1], sec: el.closest('section') || el }; });
  function parallax() {
    if (reduce) return;
    plx.forEach(function (p) {
      var r = p.sec.getBoundingClientRect(); var h = window.innerHeight;
      var prog = Math.min(1, Math.max(0, (h - r.top) / (h + r.height)));
      p.el.style.transform = 'translateY(' + (p.from + (p.to - p.from) * prog) + '%)';
    });
  }
  window.addEventListener('scroll', parallax, { passive: true }); window.addEventListener('resize', parallax);

  /* ---------- hero color carousel ---------- */
  var colorIdx = 0, colorTimer = null;
  function renderColorCard() {
    var b = D.bands[colorIdx]; if (!b) return;
    var img = $('#colorImg'), title = $('#colorTitle'); if (img) { img.src = b.img; img.alt = t('band.' + b.key); } if (title) title.textContent = t('band.' + b.key);
    var dots = $('#colorDots'); if (dots) { dots.innerHTML = ''; D.bands.forEach(function (_, i) { var btn = document.createElement('button'); btn.type = 'button'; btn.setAttribute('aria-label', t('band.' + D.bands[i].key)); if (i === colorIdx) btn.setAttribute('aria-current', 'true'); btn.innerHTML = '<span></span>'; btn.addEventListener('click', function () { setColor(i); }); dots.appendChild(btn); }); }
  }
  function setColor(i) {
    var card = $('#colorCard'); colorIdx = (i + D.bands.length) % D.bands.length;
    if (!card || reduce) { renderColorCard(); return; }
    card.classList.add('is-swapping'); setTimeout(function () { renderColorCard(); card.classList.remove('is-swapping'); }, 220);
  }
  function startColors() { if (colorTimer || reduce) return; colorTimer = setInterval(function () { setColor(colorIdx + 1); }, 3800); }

  /* ---------- showcase carousel ---------- */
  var showIdx = 0;
  var ghostKeys = ['show.ghost', 'show.ghost2', 'show.ghost3', 'show.ghost4'];
  function renderShow(noAnim) {
    var b = D.bands[showIdx]; if (!b) return;
    var words = t(ghostKeys[showIdx % ghostKeys.length]) || t('show.ghost');
    $$('[data-ghost]').forEach(function (clip, i) {
      var inner = clip.firstElementChild; inner.textContent = words[i] || '';
      clip.classList.remove('is-in'); void clip.offsetWidth; clip.style.setProperty('--d', '700ms'); clip.style.setProperty('--delay', (i * 80) + 'ms');
      if ($('#ghost').__seen || noAnim === false) clip.classList.add('is-in');
    });
    var img = $('#showImg'); var name = $('#showName'), role = $('#showRole');
    if (name) name.textContent = t('band.' + b.key); if (role) role.textContent = t('show.role');
    if (img) { if (reduce) { img.src = b.img; } else { img.classList.add('is-swapping'); setTimeout(function () { img.src = b.img; img.alt = t('band.' + b.key) + ' TNS Card NFC wristband'; img.classList.remove('is-swapping'); }, 200); } }
    var dots = $('#showDots'); if (dots) { dots.innerHTML = ''; D.bands.forEach(function (_, i) { var btn = document.createElement('button'); btn.type = 'button'; btn.setAttribute('aria-label', t('band.' + D.bands[i].key)); if (i === showIdx) btn.setAttribute('aria-current', 'true'); btn.innerHTML = '<span></span>'; btn.addEventListener('click', function () { showIdx = i; renderShow(false); }); dots.appendChild(btn); }); }
  }
  var prev = $('#showPrev'), next = $('#showNext');
  if (prev) prev.addEventListener('click', function () { showIdx = (showIdx - 1 + D.bands.length) % D.bands.length; renderShow(false); });
  if (next) next.addEventListener('click', function () { showIdx = (showIdx + 1) % D.bands.length; renderShow(false); });
  var ghostEl = $('#ghost');
  if (ghostEl) {
    var gio = new IntersectionObserver(function (en) { if (en[0].isIntersecting) { ghostEl.__seen = true; gio.disconnect(); renderShow(false); } }, { threshold: 0.2 });
    gio.observe(ghostEl);
  }

  /* ---------- products list ---------- */
  var products = ['wrist', 'card', 'sticker', 'keychain'];
  var arrowSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
  function renderProducts() {
    var ul = $('#productsList'); if (!ul) return;
    var seen = ul.__seen; ul.innerHTML = '';
    products.forEach(function (p, i) {
      var li = document.createElement('li');
      li.innerHTML = '<a class="products__row rise" data-delay="' + (i * 90) + '" href="#contact" data-open-contact data-product="' + (p === 'wrist' ? 'wristband' : p) + '">' +
        '<div class="products__body"><div class="products__name"></div><div class="products__desc"></div><div class="products__tag"></div></div>' +
        '<span class="products__arrow">' + arrowSvg + '</span></a>';
      $('.products__name', li).textContent = t('products.' + p + '.n');
      $('.products__desc', li).textContent = t('products.' + p + '.d');
      $('.products__tag', li).textContent = t('products.' + p + '.t');
      ul.appendChild(li);
      var row = $('a', li); if (seen) { row.style.setProperty('--delay', (i * 90) + 'ms'); row.classList.add('is-in'); } else io.observe(row);
    });
    ul.__seen = true;
  }

  /* ---------- menu ---------- */
  var menu = $('#menu');
  function openMenu() { if (!menu) return; menu.classList.add('is-open'); menu.setAttribute('aria-hidden', 'false'); lockScroll(); }
  function closeMenu() { if (!menu || !menu.classList.contains('is-open')) return; menu.classList.remove('is-open'); menu.setAttribute('aria-hidden', 'true'); unlockScroll(); }
  var mo = $('#menuOpen'); if (mo) mo.addEventListener('click', openMenu);
  $$('[data-close-menu]').forEach(function (b) { b.addEventListener('click', closeMenu); });

  /* ---------- contact modal + form ---------- */
  var modal = $('#contactModal'), form = $('#leadForm'), success = $('#formSuccess'), err = $('#formError'), submitBtn = $('#formSubmit');
  function openContact(product) {
    if (!modal) return; closeMenu();
    form.style.display = ''; success.classList.remove('is-visible'); err.classList.remove('is-visible');
    if (product) { var sel = $('#f-product'); if (sel) sel.value = product; }
    $('#formOpenedAt').value = String(Math.floor(Date.now() / 1000));
    modal.classList.add('is-open'); modal.setAttribute('aria-hidden', 'false'); lockScroll();
    var title = $('#contactTitle'); prepareReveal(title); setTimeout(function () { playReveal(title); }, 50);
    setTimeout(function () { var n = $('#f-name'); if (n && !isMobile()) n.focus(); }, 150);
  }
  function closeContact() { if (!modal || !modal.classList.contains('is-open')) return; modal.classList.remove('is-open'); modal.setAttribute('aria-hidden', 'true'); unlockScroll(); setTimeout(function () { form.reset(); }, 350); }
  document.addEventListener('click', function (e) {
    var o = e.target.closest('[data-open-contact]'); if (o) { e.preventDefault(); openContact(o.getAttribute('data-product')); return; }
    if (e.target.closest('[data-close-contact]')) closeContact();
  });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { closeContact(); closeMenu(); } });
  if (form) form.addEventListener('submit', function (e) {
    e.preventDefault(); err.classList.remove('is-visible');
    var fd = new FormData(form);
    if (!fd.get('name') || !fd.get('phone') || !/.+@.+\..+/.test(fd.get('email') || '')) { err.classList.add('is-visible'); return; }
    var label = $('span', submitBtn); var old = label.textContent; label.textContent = t('form.sending'); submitBtn.disabled = true;
    fetch(form.action, { method: 'POST', body: fd, headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
      .then(function (r) { if (!r.ok) throw new Error(r.status); return r.json(); })
      .then(function () {
        var first = String(fd.get('name') || '').trim().split(/\s+/)[0] || '';
        $('#successText').textContent = t('form.doneText').replace('{name}', first);
        form.style.display = 'none'; success.classList.add('is-visible');
      })
      .catch(function () { err.classList.add('is-visible'); })
      .then(function () { label.textContent = old; submitBtn.disabled = false; });
  });

  /* ---------- loader ---------- */
  var ready = false, loader = $('#loader');
  var MIN = reduce ? 200 : 1400, MAX = 2600, EXIT = reduce ? 0 : 850;
  function go() {
    if (ready) return; ready = true;
    $$('[data-reveal][data-gated]').forEach(playReveal);
    $$('.hero .rise').forEach(function (el) { el.style.setProperty('--delay', (el.getAttribute('data-delay') || 0) + 'ms'); el.classList.add('is-in'); });
    startColors();
    if (loader) { loader.classList.add('is-exiting'); setTimeout(function () { loader.remove(); }, EXIT + 50); }
    unlockScroll();
  }
  function startCountdown() { setTimeout(go, MIN); }
  lockScroll(); window.scrollTo(0, 0);
  requestAnimationFrame(function () {
    if (loader) { loader.classList.add('is-ready'); var b = $('#loaderBrand'); b.style.transition = 'opacity 500ms, transform 700ms cubic-bezier(0.16,1,0.3,1)'; b.style.opacity = '1'; b.style.transform = 'none'; }
  });
  if (document.readyState === 'complete') startCountdown(); else window.addEventListener('load', startCountdown, { once: true });
  setTimeout(go, MAX + MIN);

  /* ---------- init ---------- */
  applyLang();
  $$('[data-reveal]:not([data-gated])').forEach(function (el) { io.observe(el); });
  $$('.rise').forEach(function (el) { if (!el.closest('.hero')) io.observe(el); });
  parallax();
})();
