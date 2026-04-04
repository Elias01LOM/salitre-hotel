/* 

/**
 * initScrollAnimations()
 * ─────────────────────
 * Observa todos los elementos con clase .fade-in y les añade
 * la clase "is-visible" cuando entran en el viewport.
 *
 * Uso en HTML:
 *   <div data-animate>...</div>
 *   <div data-animate="fade-up">...</div>    ← sube + aparece
 *   <div data-animate="fade-left">...</div>  ← desliza derecha→izq
 *   <div data-animate="fade-right">...</div> ← desliza izq→der
 *   <div data-animate="scale-up">...</div>   ← crece al aparecer
 *
 * Delay escalonado para grupos:
 *   <div data-animate data-delay="0">...</div>
 *   <div data-animate data-delay="100">...</div>
 *   <div data-animate data-delay="200">...</div>
 *
 * CSS requerido (incluir en el CSS de cada página o en main.css):
 *
 *   [data-animate] {
 *     opacity: 0;
 *     transition: opacity 0.6s ease, transform 0.6s ease;
 *   }
 *   [data-animate="fade-up"]    { transform: translateY(32px); }
 *   [data-animate="fade-left"]  { transform: translateX(32px); }
 *   [data-animate="fade-right"] { transform: translateX(-32px); }
 *   [data-animate="scale-up"]   { transform: scale(0.92); }
 *
 *   [data-animate].is-visible {
 *     opacity: 1;
 *     transform: none;
 *   }
 */

(function () {
  'use strict';

  /**
   * Opciones del Intersection Observer.
   * threshold: 0.15 = el elemento debe ser 15% visible para activarse.
   * rootMargin: dispara un poco antes de que aparezca en pantalla.
   */
  var OBSERVER_OPTIONS = {
    threshold: 0.05,
    rootMargin: '0px 0px 50px 0px',
  };

  /**
   * initScrollAnimations
   * Inicializa el observer. Seguro llamar múltiples veces;
   * los elementos ya observados no se duplican.
   */
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
