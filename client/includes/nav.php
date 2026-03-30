<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASE_URL')) {
    require_once dirname(__DIR__, 2) . '/config/constants.php';
}

$base = BASE_URL;
$home = $base . 'client/';
$nav_espacios_href = $base . 'client/espacios/index.php';
$experiencia = $base . 'client/proyecto/index.php';
$agenda = $base . 'client/agenda/index.php';
$reservar = $base . 'client/carrito/';
$auth_login = $base . 'client/auth/login.php';
$auth_logout = $base . 'client/auth/logout.php';

$cliente_logueado = !empty($_SESSION['cliente_id']);
$cliente_nombre = isset($_SESSION['cliente_nombre']) ? (string) $_SESSION['cliente_nombre'] : '';
?>
<header class="site-header" role="banner">
  <nav class="nav" aria-label="Principal">
    <a class="nav__logo" href="<?php echo htmlspecialchars($home, ENT_QUOTES, 'UTF-8'); ?>">Hotel Salitre</a>
    <ul class="nav__links">
      <li>
        <a href="<?php echo htmlspecialchars($nav_espacios_href, ENT_QUOTES, 'UTF-8'); ?>">Espacios</a>
      </li>
      <li>
        <a href="<?php echo htmlspecialchars($experiencia, ENT_QUOTES, 'UTF-8'); ?>">Experiencia</a>
      </li>
      <li>
        <a href="<?php echo htmlspecialchars($agenda, ENT_QUOTES, 'UTF-8'); ?>">Agenda</a>
      </li>
      <li>
        <a class="nav__cta" href="<?php echo htmlspecialchars($reservar, ENT_QUOTES, 'UTF-8'); ?>">Reservar</a>
      </li>
      <li class="nav__auth">
<?php if ($cliente_logueado) : ?>
        <span class="nav__greeting">Hola, <?php echo htmlspecialchars($cliente_nombre, ENT_QUOTES, 'UTF-8'); ?></span>
        <a class="nav__auth-link" href="<?php echo htmlspecialchars($auth_logout, ENT_QUOTES, 'UTF-8'); ?>">Cerrar sesión</a>
<?php else : ?>
        <a class="nav__auth-link" href="<?php echo htmlspecialchars($auth_login, ENT_QUOTES, 'UTF-8'); ?>">Login / Registro</a>
<?php endif; ?>
      </li>
    </ul>
  </nav>
</header>
