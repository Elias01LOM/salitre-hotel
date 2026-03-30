<?php
declare(strict_types=1);

/* Declaramos nuestra constante '' URLs de las páginas principales */
$homeUrl = BASE_URL . 'client/index.php';
$espaciosUrl = BASE_URL . 'client/espacios/index.php';
$agendaUrl = BASE_URL . 'client/agenda/index.php';
$proyectoUrl = BASE_URL . 'client/proyecto/index.php';
$logoUrl = BASE_URL . 'assets/img/logo/logo.svg';
$year = date('Y');
?>
<footer class="site-footer">
  <div class="site-footer__inner">
    <div class="site-footer__brand">
      <a class="site-footer__logo-link" href="<?= htmlspecialchars($homeUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Hotel Salitre — inicio">
        <img class="site-footer__logo" src="<?= htmlspecialchars($logoUrl, ENT_QUOTES, 'UTF-8') ?>" width="140" height="36" alt="Hotel Salitre">
      </a>
      <p class="site-footer__tagline">Sal de la oficina. No del trabajo.</p>
    </div>
    <div class="site-footer__columns">
      <div class="site-footer__col">
        <h2 class="site-footer__heading">Links rápidos</h2>
        <ul class="site-footer__list" role="list">
          <li><a class="site-footer__link" href="<?= htmlspecialchars($homeUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Ir al inicio">Inicio</a></li>
          <li><a class="site-footer__link" href="<?= htmlspecialchars($espaciosUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Ver espacios">Espacios</a></li>
          <li><a class="site-footer__link" href="<?= htmlspecialchars($agendaUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Ver agenda">Agenda</a></li>
          <li><a class="site-footer__link" href="<?= htmlspecialchars($proyectoUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Información del proyecto">Proyecto</a></li>
        </ul>
      </div>
      <div class="site-footer__col">
        <h2 class="site-footer__heading">Servicios</h2>
        <ul class="site-footer__list" role="list">
          <li><a class="site-footer__link" href="<?= htmlspecialchars(BASE_URL . 'client/index.php#servicios', ENT_QUOTES, 'UTF-8') ?>" aria-label="Coworking en la página de inicio">Coworking abierto</a></li>
          <li><a class="site-footer__link" href="<?= htmlspecialchars(BASE_URL . 'client/index.php#servicios', ENT_QUOTES, 'UTF-8') ?>" aria-label="Café Salitre en la página de inicio">Café Salitre</a></li>
          <li><a class="site-footer__link" href="<?= htmlspecialchars(BASE_URL . 'client/index.php#servicios', ENT_QUOTES, 'UTF-8') ?>" aria-label="Surf en la página de inicio">Clases de surf</a></li>
          <li><a class="site-footer__link" href="<?= htmlspecialchars(BASE_URL . 'client/index.php#servicios', ENT_QUOTES, 'UTF-8') ?>" aria-label="Yoga en la página de inicio">Yoga frente al mar</a></li>
        </ul>
      </div>
      <div class="site-footer__col">
        <h2 class="site-footer__heading">Contacto del hotel</h2>
        <ul class="site-footer__list site-footer__list--contact" role="list">
          <li><a class="site-footer__link" href="<?= htmlspecialchars(BASE_URL . 'client/index.php#contacto', ENT_QUOTES, 'UTF-8') ?>" aria-label="Formulario de contacto">Escríbenos</a></li>
          <li><span class="site-footer__text">Costa del Pacífico, México</span></li>
          <li><span class="site-footer__text">Reservas: hola@salitre.mx</span></li>
        </ul>
      </div>
    </div>
    <nav class="site-footer__subnav" aria-label="Información del proyecto">
      <ul class="site-footer__sublist" role="list">
        <li><a class="site-footer__sublink" href="<?= htmlspecialchars($proyectoUrl, ENT_QUOTES, 'UTF-8') ?>#intro" aria-label="Introducción del proyecto">Intro del Proyecto</a></li>
        <li><a class="site-footer__sublink" href="<?= htmlspecialchars($proyectoUrl, ENT_QUOTES, 'UTF-8') ?>#conocenos" aria-label="Conócenos">Conócenos</a></li>
        <li><a class="site-footer__sublink" href="<?= htmlspecialchars($proyectoUrl, ENT_QUOTES, 'UTF-8') ?>#ubicacion" aria-label="Ubicación en mapa">Ubicación</a></li>
      </ul>
    </nav>
    <p class="site-footer__legal">© <?= htmlspecialchars((string)$year, ENT_QUOTES, 'UTF-8') ?> Hotel Salitre. Todos los derechos reservados.</p>
  </div>
</footer>
<script src="<?= htmlspecialchars(BASE_URL . 'assets/js/shared/animations.js', ENT_QUOTES, 'UTF-8') ?>" defer></script>
<script src="<?= htmlspecialchars(BASE_URL . 'assets/js/client/main.js', ENT_QUOTES, 'UTF-8') ?>" defer></script>
</body>
</html>
