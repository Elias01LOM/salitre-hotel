<?php
declare(strict_types=1);

if (!defined('BASE_URL')) {
  require_once dirname(__DIR__, 2) . '/config/constants.php';
  }

$base = BASE_URL;
?>
  <footer class="site-footer" role="contentinfo">
    <div class="site-footer__inner">
      <p class="site-footer__brand">Hotel Salitre</p>
      <p class="site-footer__meta">Espacios de trabajo y estancia · México</p>
    </div>
  </footer>
  <script src="<?php echo htmlspecialchars($base, ENT_QUOTES, 'UTF-8'); ?>assets/js/shared/animations.js" defer></script>
  <script src="<?php echo htmlspecialchars($base, ENT_QUOTES, 'UTF-8'); ?>assets/js/client/main.js" defer></script>
</body>
</html>
