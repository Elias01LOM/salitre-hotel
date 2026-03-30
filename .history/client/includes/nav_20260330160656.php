<?php
declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/config/constants.php';

/* Declaramos nuestra constante 'BASE_URL' a las páginas correspondientes */
$homeUrl = BASE_URL . 'client/index.php';
$espaciosUrl = BASE_URL . 'client/espacios/index.php';
$agendaUrl = BASE_URL . 'client/agenda/index.php';
$serviciosUrl = BASE_URL . 'client/index.php#servicios';
$contactoUrl = BASE_URL . 'client/index.php#contacto';
$logoUrl = BASE_URL . 'assets/img/logo/logo.svg';
?>
<header class="site-header" id="site-header">
  <nav class="site-nav" id="site-nav" aria-label="Principal">
    <div class="site-nav__inner">
      <a class="site-nav__brand" href="<?= htmlspecialchars($homeUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Hotel Salitre — inicio">
        <img class="site-nav__logo" src="<?= htmlspecialchars($logoUrl, ENT_QUOTES, 'UTF-8') ?>" width="160" height="40" alt="Hotel Salitre">
      </a>
      <button
        type="button"
        class="site-nav__toggle"
        id="nav-toggle"
        aria-controls="site-menu"
        aria-expanded="false"
        aria-label="Abrir menú de navegación"
      >
        <svg class="site-nav__toggle-icon" width="28" height="28" viewBox="0 0 28 28" aria-hidden="true" focusable="false">
          <path fill="currentColor" d="M4 7h20v2H4V7zm0 6h20v2H4v-2zm0 6h20v2H4v-2z"/>
        </svg>
      </button>
      <div class="site-nav__panel" id="site-menu">
        <ul class="site-nav__links" role="list">
          <li>
            <a class="site-nav__link" href="<?= htmlspecialchars($espaciosUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Ver espacios del hotel">Espacios</a>
          </li>
          <li>
            <a class="site-nav__link" href="<?= htmlspecialchars($serviciosUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Ir a servicios en la página de inicio">Servicios</a>
          </li>
          <li>
            <a class="site-nav__link" href="<?= htmlspecialchars($agendaUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Ver agenda del hotel">Agenda</a>
          </li>
          <li>
            <a class="site-nav__link" href="<?= htmlspecialchars($contactoUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Ir a contacto en la página de inicio">Contacto</a>
          </li>
        </ul>
        <a class="btn btn-primary site-nav__cta" href="<?= htmlspecialchars($espaciosUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Reservar — ver espacios disponibles">Reservar</a>
      </div>
    </div>
  </nav>
</header>
