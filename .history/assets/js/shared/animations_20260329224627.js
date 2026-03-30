/* Creamos las animaciones al entrar en viewport sin bloquear el hilo principal. Usa IntersectionObserver (asíncrono respecto al render principal). */
(function () {
  "use strict";

  var selector = ".fade-in";

  function initFadeIn() {
    var nodes = document.querySelectorAll(selector);
    if (!nodes.length) {
      return;
    }

    if (!("IntersectionObserver" in window)) {
      nodes.forEach(function (el) {
        el.classList.add("is-visible");
      });
      return;
    }

    var observer = new IntersectionObserver(
      function (entries, obs) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) {
            return;
          }
          entry.target.classList.add("is-visible");
          obs.unobserve(entry.target);
        });
      },
      {
        root: null,
        rootMargin: "0px 0px -8% 0px",
        threshold: 0.08,
      }
    );

    nodes.forEach(function (el) {
      observer.observe(el);
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initFadeIn);
  } else {
    initFadeIn();
  }
})();
