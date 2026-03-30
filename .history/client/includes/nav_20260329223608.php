<?php
declare(strict_types=1);

if (!defined('BASE_URL')) {
  require_once dirname(__DIR__, 2) . '/config/constants.php';
  }

$base = BASE_URL;
$home = $base . 'client/';
$espacios = $base . 'client/espacios/';
$experiencia = $base . 'client/proyecto/';
$reservar = $base . 'client/carrito/';
?>
<header class="site-header" role="banner">
  <nav class="nav" aria-label="Principal">
    <a class="nav__logo" href="<?php echo htmlspecialchars($home, ENT_QUOTES, 'UTF-8'); ?>">Hotel Salitre</a>
    <ul class="nav__links">
      <li>
        <a href="<?php echo htmlspecialchars($espacios, ENT_QUOTES, 'UTF-8'); ?>">Espacios</a>
      </li>
      <li>
        <a href="<?php echo htmlspecialchars($experiencia, ENT_QUOTES, 'UTF-8'); ?>">Experiencia</a>
      </li>
      <li>
        <a class="nav__cta" href="<?php echo htmlspecialchars($reservar, ENT_QUOTES, 'UTF-8'); ?>">Reservar</a>
      </li>
    </ul>
  </nav>
</header>
