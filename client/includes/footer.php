<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASE_URL')) {
    require_once dirname(__DIR__, 2) . '/config/constants.php';
}

$base = BASE_URL;
$contacto_action = $base . 'client/includes/procesar_contacto.php';
?>
  <footer class="site-footer" role="contentinfo">
    <div class="site-footer__wrap">
      <section class="footer-contact fade-in" aria-labelledby="footer-contact-title">
        <h2 id="footer-contact-title" class="footer-contact__title">Escríbenos</h2>
        <p class="footer-contact__lead">¿Dudas sobre espacios o estancias? Déjanos un mensaje.</p>
        <form class="footer-contact__form" method="post" action="<?php echo htmlspecialchars($contacto_action, ENT_QUOTES, 'UTF-8'); ?>">
          <div class="footer-contact__row">
            <label class="footer-contact__label" for="contacto-nombre">Nombre</label>
            <input class="footer-contact__input" type="text" id="contacto-nombre" name="nombre" required maxlength="100" autocomplete="name">
          </div>
          <div class="footer-contact__row">
            <label class="footer-contact__label" for="contacto-email">Email</label>
            <input class="footer-contact__input" type="email" id="contacto-email" name="email" required maxlength="150" autocomplete="email">
          </div>
          <div class="footer-contact__row">
            <label class="footer-contact__label" for="contacto-mensaje">Mensaje</label>
            <textarea class="footer-contact__textarea" id="contacto-mensaje" name="mensaje" required rows="4"></textarea>
          </div>
          <button class="footer-contact__submit" type="submit">Enviar</button>
        </form>
      </section>

      <div class="site-footer__inner">
        <p class="site-footer__brand">Hotel Salitre</p>
        <p class="site-footer__meta">Espacios de trabajo y estancia · México</p>
      </div>
    </div>
  </footer>
  <script src="<?php echo htmlspecialchars($base, ENT_QUOTES, 'UTF-8'); ?>assets/js/shared/animations.js" defer></script>
  <script src="<?php echo htmlspecialchars($base, ENT_QUOTES, 'UTF-8'); ?>assets/js/client/main.js" defer></script>
</body>
</html>
