<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$base = BASE_URL;
?>
<nav class="nav">
    <div class="nav-container">
        <a href="<?= $base ?>client/index.php" class="nav__logo">
            Salitre
        </a>
        <ul class="nav__list" id="nav-menu">
            <li><a href="<?= $base ?>client/index.php#hero" class="nav__link">Inicio</a></li>
            <li><a href="<?= $base ?>client/index.php#espacios" class="nav__link">Espacios</a></li>
            <li><a href="<?= $base ?>client/index.php#servicios" class="nav__link">Servicios</a></li>
            <li><a href="<?= $base ?>client/index.php#contacto" class="nav__link">Contacto</a></li>
            <li><a href="<?= $base ?>client/agenda/index.php" class="nav__link">Agenda</a></li>
        </ul>
        <div class="nav__actions">
            <?php if (isset($_SESSION['cliente_id'])): ?>
                <a href="<?= $base ?>client/perfil.php" class="btn btn-secondary btn-sm">Mi Perfil</a>
                <a href="<?= $base ?>client/auth/logout.php" class="btn btn-outline btn-sm">Salir</a>
            <?php else: ?>
                <a href="<?= $base ?>client/auth/login.php" class="btn btn-outline btn-sm">Ingresar</a>
                <a href="<?= $base ?>client/auth/registro.php" class="btn btn-primary btn-sm">Registrarme</a>
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