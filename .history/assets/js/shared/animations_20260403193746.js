/* Animaciones de Scroll para Salitre */

(function () {
  'use strict';

  /* Opciones del Intersection Observer */
  var OBSERVER_OPTIONS = {
    threshold: 0.05,
    rootMargin: '0px 0px 50px 0px',
  };
  /* El sistema de animaciones de scroll se basa en Intersection Observer para detectar
  function initScrollAnimations() {
    // Respeto a prefers-reduced-motion
    var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) {
      // Revelar todo inmediatamente sin animación
      document.querySelectorAll('.fade-in').forEach(function (el) {
        el.classList.add('is-visible');
      });
      return;
    }

    var observer = new IntersectionObserver(onIntersect, OBSERVER_OPTIONS);

    /*
     * Se observan todos los elementos con clase .fade-in para aplicar
     * la animacion de aparicion al hacer scroll. Esto coincide con el
     * CSS definido en main.css (.fade-in / .fade-in.is-visible).
     */
    document.querySelectorAll('.fade-in').forEach(function (el) {
      // Aplicar delay escalonado si se especifica data-delay (ms)
      var delay = el.dataset.delay;
      if (delay) {
        el.style.transitionDelay = delay + 'ms';
      }
      observer.observe(el);
    });

    /*
     * Fallback: revelar inmediatamente los elementos que ya están
     * dentro del viewport al cargar la página. El IntersectionObserver
     * no siempre dispara su callback para elementos que ya están
     * visibles en el momento del observe().
     */
    function checkVisibility() {
      var remaining = document.querySelectorAll('.fade-in:not(.is-visible)');
      remaining.forEach(function (el) {
        var rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight + 50 && rect.bottom > -50) {
          el.classList.add('is-visible');
          observer.unobserve(el);
        }
      });
      // Si ya no quedan elementos, quitar el listener de scroll
      if (remaining.length === 0) {
        window.removeEventListener('scroll', onScrollFallback);
      }
    }

    function onScrollFallback() {
      requestAnimationFrame(checkVisibility);
    }

    // Verificar al cargar
    setTimeout(checkVisibility, 100);
    // Verificar al hacer scroll (por si el observer falla)
    window.addEventListener('scroll', onScrollFallback, { passive: true });
  }

  /**
   * Callback del observer.
   * Cuando un elemento es visible → añade "is-visible" y deja de observarlo.
   */
  function onIntersect(entries, observer) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target); // Solo se anima una vez
      }
    });
  }

  /**
   * Inicialización automática al cargar el DOM.
   * También se expone globalmente para uso manual si se carga
   * content dinámico (p. ej. cards cargadas con fetch).
   */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initScrollAnimations);
  } else {
    initScrollAnimations();
  }

  // Exposición global para uso manual
  window.SalitreAnimations = {
    init: initScrollAnimations,
  };

})();
