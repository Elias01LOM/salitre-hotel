<?php
/* Definimos el nav común para todas las páginas del cliente - 'client/includes/nav.php' */
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$base = BASE_URL;
?>
<nav class="nav-main" role="navigation" aria-label="Navegación principal">
    <!-- Logo -->
    <a href="<?= BASE_URL ?>client/index.php" class="nav-logo">
        <img src="<?= BASE_URL ?>assets/img/logo/logo.svg"
             alt="Salitre"
             width="120"
             height="40">
    </a>
    
    <!-- Definimos el menú de navegación -->
    <ul class="nav-menu" id="nav-menu">
        <li><a href="<?= BASE_URL ?>client/index.php" class="nav-link">Inicio</a></li>
        <li><a href="<?= BASE_URL ?>client/espacios/index.php" class="nav-link">Espacios</a></li>
        <li><a href="<?= BASE_URL ?>client/index.php#servicios" class="nav-link">Servicios</a></li>
        <li><a href="<?= BASE_URL ?>client/agenda/index.php" class="nav-link">Agenda</a></li>
        <li><a href="<?= BASE_URL ?>client/index.php#contacto" class="nav-link">Contacto</a></li>
        <li><a href="<?= BASE_URL ?>client/proyecto/index.php" class="nav-link">Proyecto</a></li>
        <li><a href="<?= BASE_URL ?>client/ayuda/index.php" class="nav-link">Ayuda</a></li>
    </ul>
    
    <!-- Definimos los botones de 'acción' y el 'hamburger' -->
    <div class="nav-actions">
        <?php if(isset($_SESSION["cliente_id"])): ?>
            <a href="<?= BASE_URL ?>client/auth/perfil.php" class="btn btn-outline">Mi Perfil</a>
            <a href="<?= BASE_URL ?>client/auth/logout.php" class="btn btn-outline">Salir</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>client/auth/login.php" class="btn btn-outline">Iniciar</a>
            <a href="<?= BASE_URL ?>client/espacios/index.php" class="btn btn-primary">Reservar</a>
        <?php endif; ?>
        
        <!-- Definimos el botón hamburger – SIEMPRE VISIBLE -->
        <button class="nav-burger" 
                aria-expanded="false" 
                aria-controls="nav-menu" 
                aria-label="Abrir menú"
                type="button">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </div>
</nav>

<!-- Menú desplegable independiente (solo desktop) -->
<div class="nav-dropdown" id="nav-dropdown" aria-hidden="true">
    <div class="dropdown-container">
        <div class="dropdown-logo">
            <img src="<?= BASE_URL ?>/assets/img/logo/logo.svg" alt="Salitre" width="120" height="40">
        </div>
        <hr class="dropdown-divider">
        <ul class="dropdown-menu">
            <li><a href="<?= BASE_URL ?>/client/index.php">Inicio</a></li>
            <li><a href="<?= BASE_URL ?>/client/espacios/index.php">Espacios</a></li>
            <li><a href="<?= BASE_URL ?>/client/index.php#servicios">Servicios</a></li>
            <li><a href="<?= BASE_URL ?>/client/agenda/index.php">Agenda</a></li>
            <li><a href="<?= BASE_URL ?>/client/index.php#contacto">Contacto</a></li>
            <li><a href="<?= BASE_URL ?>/client/proyecto/index.php">Proyecto</a></li>
            <li><a href="<?= BASE_URL ?>/client/ayuda/index.php">Ayuda</a></li>
            <li class="dropdown-auth">
                <?php if(isset($_SESSION["cliente_id"])): ?>
                    <a href="<?= BASE_URL ?>/client/auth/perfil.php">Mi Cuenta</a>
                    <a href="<?= BASE_URL ?>/client/auth/logout.php">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/client/auth/login.php">Iniciar Sesión</a>
                    <a href="<?= BASE_URL ?>/client/auth/registro.php">Registrarse</a>
                <?php endif; ?>
            </li>
            <li><a href="<?= BASE_URL ?>/client/espacios/index.php" class="dropdown-cta">Reservar</a></li>
        </ul>
    </div>
</div>

<!-- Overlay para cerrar el dropdown -->
<div class="nav-overlay" id="nav-overlay" aria-hidden="true"></div>