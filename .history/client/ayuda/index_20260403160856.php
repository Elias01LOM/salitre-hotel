<?php
/* 'client/ayuda/index.php' sera la página de Ayuda - en construcción */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../config/database.php";
require_once "../../config/constants.php";

$page_title = "Ayuda — " . SITE_NAME;
$extra_stylesheets = ["assets/css/client/ayuda.css"];

require_once "../includes/header.php";
require_once "../includes/nav.php";
?>

<main class="ayuda-page">
    <div class="container">
        <div class="ayuda-card fade-in">
            
            <h1>Centro de Ayuda</h1>
            <p class="ayuda-subtitle">Estamos trabajando en esta sección</p>
            
            <div class="ayuda-content">
                <p>
                    Muy pronto encontrarás aquí respuestas a tus preguntas, guías de uso y todo el soporteque necesitas para tu estancia.
                </p>
                <p>
                    Mientras tanto, puedes contactarnos directamente:
                </p>
            </div>
            
            <div class="ayuda-contacto">
                <div class="contacto-item">
                    <span class="icon">✉️</span>
                    <a href="mailto:contacto@salitre.mx">contacto@salitre.mx</a>
                </div>
                <div class="contacto-item">
                    <span class="icon">📞</span>
                    <a href="tel:+525551234567">+52 (555) 123-4567</a>
                </div>
            </div>
            
            <a href="<?= BASE_URL ?>client/index.php" class="btn btn-primary">
                Volver al Inicio
            </a>
        </div>
    </div>
</main>

<?php require_once "../includes/footer.php"; ?>
