<?php
/* 'client/ayuda/index.php' sera la página de 'Ayuda' - en construcción */

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
            <!-- Ícono de engranajes -->
            <div class="ayuda-icon">
                <svg viewBox="0 0 100 100" width="120" height="120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="40" stroke="var(--color-accent)" stroke-width="4" fill="none"/>
                    <circle cx="50" cy="50" r="15" fill="var(--color-accent)"/>
                    <line x1="50" y1="10" x2="50" y2="25" stroke="var(--color-accent)" stroke-width="4"/>
                    <line x1="50" y1="75" x2="50" y2="90" stroke="var(--color-accent)" stroke-width="4"/>
                    <line x1="10" y1="50" x2="25" y2="50" stroke="var(--color-accent)" stroke-width="4"/>
                    <line x1="75" y1="50" x2="90" y2="50" stroke="var(--color-accent)" stroke-width="4"/>
                    <line x1="22" y1="22" x2="32" y2="32" stroke="var(--color-accent)" stroke-width="4"/>
                    <line x1="68" y1="68" x2="78" y2="78" stroke="var(--color-accent)" stroke-width="4"/>
                    <line x1="22" y1="78" x2="32" y2="68" stroke="var(--color-accent)" stroke-width="4"/>
                    <line x1="68" y1="32" x2="78" y2="22" stroke="var(--color-accent)" stroke-width="4"/>
                </svg>
            </div>
            
            <h1>Centro de Ayuda</h1>
            <p class="ayuda-subtitle">Estamos trabajando en esta sección</p>
            
            <div class="ayuda-content">
                <p>
                    Muy pronto encontrarás aquí respuestas a tus preguntas, 
                    guías de uso y todo el soporte que necesitas para tu estancia.
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
