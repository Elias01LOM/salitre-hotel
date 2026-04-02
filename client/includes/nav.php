<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$base = BASE_URL;
?>
<nav class="nav">
    <div class="nav-container">
        <a href="<?= $base ?>client/index.php" class="nav__logo">
            <img src="<?= $base ?>assets/img/logo/logo.svg" 
                 alt="Hotel Salitre" class="nav__logo-img"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='inline'">
            <span class="nav__logo-fallback" style="display:none;">Salitre</span>
        </a>
        <ul class="nav__list" id="nav-menu">
            <li><a href="<?= $base ?>client/index.php" class="nav__link">Inicio</a></li>
            <li><a href="<?= $base ?>client/espacios/index.php" class="nav__link">Espacios</a></li>
            <li><a href="<?= $base ?>client/index.php#servicios" class="nav__link">Servicios</a></li>
            <li><a href="<?= $base ?>client/agenda/index.php" class="nav__link">Agenda</a></li>
            <li><a href="<?= $base ?>client/index.php#contacto" class="nav__link">Contacto</a></li>
            <li><a href="<?= $base ?>client/proyecto/index.php" class="nav__link">Proyecto</a></li>
        </ul>
        <div class="nav__actions">
            <?php if (isset($_SESSION['cliente_id'])): ?>
                <a href="<?= $base ?>client/auth/perfil.php" class="btn btn-outline btn-sm">Mi Perfil</a>
                <a href="<?= $base ?>client/auth/logout.php" class="btn btn-outline btn-sm">Salir</a>
            <?php else: ?>
                <a href="<?= $base ?>client/auth/login.php" class="btn btn-outline btn-sm">Iniciar</a>
                <a href="<?= $base ?>client/espacios/index.php" class="btn btn-primary btn-sm">Reservar</a>
            <?php endif; ?>
        </div>
        <button class="nav__hamburger" id="nav-toggle"
                aria-label="Abrir menú"
                aria-expanded="false"
                aria-controls="nav-menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>