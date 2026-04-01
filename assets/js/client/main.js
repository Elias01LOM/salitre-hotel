"use strict";
// main.js — Navbar sticky + Hamburger + Smooth Scroll
// Solo se carga en páginas del cliente (NO en admin)
// Documentación: sección 7.2

(function () {

  /* ------------------------------------------------
     CONSTANTES
  ------------------------------------------------ */
  var SCROLL_THRESHOLD = 80;       // px hasta añadir .scrolled
  var NAV_SEL          = '.nav';   // selector del <nav>
  var TOGGLE_SEL       = '.nav__hamburger';  // botón hamburger
  var MENU_SEL         = '.nav__list';       // lista de links
  var LINK_SEL         = '.nav__link';       // cada link del menú
  var OPEN_CLASS       = 'open';
  var SCROLLED_CLASS   = 'scrolled';
  var BODY_LOCK_CLASS  = 'nav-open';

  /* ------------------------------------------------
     ELEMENTOS
  ------------------------------------------------ */
  var nav    = document.querySelector(NAV_SEL);
  var toggle = document.querySelector(TOGGLE_SEL);
  var menu   = document.querySelector(MENU_SEL);

  /* ------------------------------------------------
     1. NAVBAR STICKY — añade .scrolled al pasar 80px
  ------------------------------------------------ */
  function updateNavScroll() {
    if (!nav) return;
    if (window.scrollY > SCROLL_THRESHOLD) {
      nav.classList.add(SCROLLED_CLASS);
    } else {
      nav.classList.remove(SCROLLED_CLASS);
    }
  }

  // Ejecutar al cargar por si la página empieza con scroll
  updateNavScroll();
  window.addEventListener('scroll', updateNavScroll, { passive: true });

  /* ------------------------------------------------
     2. HAMBURGER MENU
     Toggle .open en .nav__list
     Bloquea scroll del body con .nav-open
  ------------------------------------------------ */
  function openMenu() {
    if (!menu || !toggle) return;
    menu.classList.add(OPEN_CLASS);
    toggle.classList.add(OPEN_CLASS);
    toggle.setAttribute('aria-expanded', 'true');
    document.body.classList.add(BODY_LOCK_CLASS);
  }

  function closeMenu() {
    if (!menu || !toggle) return;
    menu.classList.remove(OPEN_CLASS);
    toggle.classList.remove(OPEN_CLASS);
    toggle.setAttribute('aria-expanded', 'false');
    document.body.classList.remove(BODY_LOCK_CLASS);
  }

  function toggleMenu() {
    if (!menu) return;
    if (menu.classList.contains(OPEN_CLASS)) {
      closeMenu();
    } else {
      openMenu();
    }
  }

  if (toggle) {
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-controls', 'nav-menu');
    toggle.addEventListener('click', toggleMenu);
  }

  // Cerrar al hacer click en cualquier link del menú
  document.querySelectorAll(LINK_SEL).forEach(function (link) {
    link.addEventListener('click', closeMenu);
  });

  // Cerrar al hacer click fuera del nav
  document.addEventListener('click', function (e) {
    if (!nav) return;
    if (!nav.contains(e.target)) {
      closeMenu();
    }
  });

  // Cerrar con Escape
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closeMenu();
    }
  });

  /* ------------------------------------------------
     3. SMOOTH SCROLL para anchors (#seccion)
     Solo actúa en links internos de la misma página.
     Respeta prefers-reduced-motion.
  ------------------------------------------------ */
  var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      var href   = anchor.getAttribute('href');
      var target = document.querySelector(href);

      if (!target) return;

      e.preventDefault();

      // Cerrar menú móvil si está abierto
      closeMenu();

      if (prefersReduced) {
        // Sin animación: salto directo
        target.scrollIntoView();
        target.setAttribute('tabindex', '-1');
        target.focus({ preventScroll: true });
        return;
      }

      // Scroll suave nativo (soportado por reset.css: scroll-behavior: smooth)
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });

      // Mover foco al destino para accesibilidad
      target.setAttribute('tabindex', '-1');
      target.focus({ preventScroll: true });
    });
  });

  /* ------------------------------------------------
     4. RESIZE — cerrar menú si se expande pantalla
  ------------------------------------------------ */
  window.addEventListener('resize', function () {
    // Si el viewport supera 768px, cerrar menú móvil
    if (window.innerWidth > 768) {
      closeMenu();
    }
  }, { passive: true });

})();
