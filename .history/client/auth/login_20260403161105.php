<?php
/* 'client/auth/login.php' es la página de inicio de sesión para los clientes */
session_start();
require_once dirname(__DIR__) . "/../config/database.php";
require_once dirname(__DIR__) . "/../config/constants.php";

// Si ya hay sesión, redirige según el parámetro 'redirect' o a la página principal
if (isset($_SESSION["cliente_id"])) {
    $redirect = $_GET["redirect"] ?? "home";
    if ($redirect === "carrito") {
        header("Location: " . BASE_URL . "client/carrito/index.php");
    } else {
        header("Location: " . BASE_URL . "client/index.php");
    }
    exit;
}

$page_title = "Iniciar Sesión — Hotel Salitre";
$extra_stylesheets = ["assets/css/client/auth.css"];

require_once dirname(__DIR__) . "/includes/header.php";
require_once dirname(__DIR__) . "/includes/nav.php";
$base = BASE_URL;
?>

<div class="page-offset"></div>

<section class="auth-section section-pad flex-center">
    <div class="auth-card fade-in">
        
        <h1 class="auth-card__title">Iniciar Sesión</h1>
        <p class="auth-card__subtitle text-muted">Accede para gestionar tus reservas.</p>

        <?php if (isset($_GET['error']) && $_GET['error'] === '1') : ?>
            <div class="alert alert--error mb-4">
                <p>Correo o contraseña incorrectos.</p>
            </div>
        <?php endif; ?>

        <form action="<?= $base ?>client/auth/procesar_auth.php" method="POST" class="auth-form">
            <input type="hidden" name="action" value="login">
            <?php if (isset($_GET['redirect'])) : ?>
                <input type="hidden" name="redirect" value="<?= htmlspecialchars((string)$_GET['redirect'], ENT_QUOTES, 'UTF-8') ?>">
            <?php endif; ?>

            <div class="field">
                <label for="email" class="field__label">Correo electrónico</label>
                <input type="email" id="email" name="email" class="field__input" required autocomplete="email" placeholder="hola@ejemplo.com">
            </div>

            <div class="field">
                <label for="password" class="field__label">Contraseña</label>
                <input type="password" id="password" name="password" class="field__input" required autocomplete="current-password" placeholder="Tu clave segura">
            </div>

            <button type="submit" class="btn btn-primary w-full mt-2" style="justify-content:center;">Ingresar</button>
        </form>

        <div class="auth-card__footer mt-6 text-center text-sm">
            <p class="text-muted">¿No tienes cuenta? <a href="<?= $base ?>client/auth/registro.php" class="text-accent fw-600">Regístrate aquí</a></p>
        </div>

    </div>
</section>

<?php require dirname(__DIR__) . "/includes/footer.php"; ?>
