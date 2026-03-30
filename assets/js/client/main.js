(function () {
  const header = document.getElementById('site-header');
  const nav = document.getElementById('site-nav');
  const toggle = document.getElementById('nav-toggle');
  const panel = document.getElementById('site-menu');

  if (!header || !nav || !toggle || !panel) {
    return;
  }

  const raw = getComputedStyle(document.documentElement)
    .getPropertyValue('--layout-nav-compact-after')
    .trim();
  const scrollThreshold = parseInt(raw, 10) || 80;

  const setScrolled = () => {
    const scrolled = window.scrollY > scrollThreshold;
    header.classList.toggle('scrolled', scrolled);
    nav.classList.toggle('scrolled', scrolled);
  };

  setScrolled();
  window.addEventListener('scroll', setScrolled, { passive: true });

  const smoothHashes = new Set(['#servicios', '#contacto']);
  document.addEventListener('click', (event) => {
    const link = event.target?.closest?.('a[href]');
    if (!link) return;

    const hash = link.hash;
    if (!smoothHashes.has(hash)) return;
    if (!hash) return;

    const target = document.getElementById(hash.slice(1));
    if (!target) return;

    // Solo suaviza si el enlace apunta a la misma página (mismo pathname).
    const targetUrl = new URL(link.href, window.location.href);
    if (targetUrl.pathname !== window.location.pathname) return;

    event.preventDefault();
    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    history.replaceState(null, '', hash);
  });

  const labelOpen = 'Abrir menú de navegación';
  const labelClose = 'Cerrar menú de navegación';

  const bp =
    getComputedStyle(document.documentElement).getPropertyValue('--breakpoint-md').trim() ||
    '768px';
  const mqDesktop = window.matchMedia(`(min-width: ${bp})`);

  toggle.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    toggle.setAttribute('aria-label', open ? labelClose : labelOpen);
    document.body.style.overflow = open ? 'hidden' : '';
  });

  panel.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
      if (!nav.classList.contains('open')) {
        return;
      }
      nav.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', labelOpen);
      document.body.style.overflow = '';
    });
  });

  mqDesktop.addEventListener('change', (e) => {
    if (e.matches) {
      nav.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', labelOpen);
      document.body.style.overflow = '';
    }
  });
})();
