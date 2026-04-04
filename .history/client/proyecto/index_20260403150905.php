<?php
/* Definimos las variables para la información del proyecto - 'client/proyecto/index.php' */

session_start();
require_once "../../config/database.php";
require_once "../../config/constants.php";

$page_title = "Proyecto - " . SITE_NAME;
$extra_stylesheets = ["assets/css/client/proyecto.css"];

require_once "../includes/header.php";
require_once "../includes/nav.php";
?>

<main class="proyecto-page" style="padding-top: calc(var(--space-.5) + 72px); padding-bottom: var(--space-12); min-height: 100vh;">
    <section id="intro" class="proyecto-intro">
        <div class="container">
            
            <!-- Introducción el Proyecto (sección 1) -->
            <div class="proyecto-info-section fade-in">
                <h2>Introducción al Proyecto</h2>
                <p>
                    Salitre nace para ofrecer estancias donde el trabajo remoto y el bienestar convivan sin fricción. Aquí encontrarás fibra óptica garantizada, mobiliario pensado para jornadas largas y espacios minimalistas que favorecen la concentración. El sitio y la experiencia están diseñados desde cero para que el profesional pueda mantener su ritmo productivo sin renunciar al mar como telón de fondo.
                </p>
            </div>
            
            <!-- Herramientas y Tecnologías (sección 1.1) -->
            <div class="herramientas-section fade-in">
                <h2>Herramientas y Tecnologías</h2>
                <div class="herramientas-grid">
                    <div class="herramienta-item">
                        <div class="herramienta-icon"></div>
                        <h3>Frontend</h3>
                        <p>HTML5 · CSS3 · JavaScript Vanilla</p>
                    </div>
                    <div class="herramienta-item">
                        <div class="herramienta-icon"></div>
                        <h3>Backend</h3>
                        <p>PHP 8+ · PDO · MySQL</p>
                    </div>
                    <div class="herramienta-item">
                        <div class="herramienta-icon"></div>
                        <h3>Base de Datos</h3>
                        <p>MySQL · MariaDB (Xampp)</p>
                    </div>
                    <div class="herramienta-item">
                        <div class="herramienta-icon"></div>
                        <h3>Desarrollo</h3>
                        <p>VS Code · Git · GitHub</p>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    
    <!-- Sección Conocenos (sección 2) -->
    <section id="conocenos" class="proyecto-conocenos" style="margin-bottom: var(--space-12); background: var(--color-surface); padding: var(--space-12) 0;">
        <div class="container container--wide">
            <h2 style="font-size: var(--text-3xl); margin-bottom: var(--space-8);">Conócenos</h2>
            <div class="conocenos-content" style="display: flex; gap: var(--space-8); align-items: center; flex-wrap: wrap;">
                <div class="conocenos-texto" style="flex: 1; min-width: 300px; color: var(--color-text-muted); font-size: var(--text-lg); line-height: 1.6;">
                    <p style="margin-bottom: var(--space-4);">
                        Somos un equipo que diseña estancias para profesionales que trabajan en remoto; menos ruido, más foco, y todas las herramientas para que tu trabajo fluya.
                    </p>
                    <p>
                        En Salitre combinamos hospitalidad y productividad. Nuestro equipo proviene de experiencias en hospitalidad boutique y producto digital; entendemos las necesidades del nómada moderno. Somos un lugar pensado para que tu trabajo rinda y tu descanso sea real.
                    </p>
                </div>
                <div class="conocenos-imagen" style="flex: 1; min-width: 300px;">
                    <div class="img-placeholder" style="width: 100%; aspect-ratio: 4/3; background: var(--color-mid); display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md);">
                        <span style="color: var(--color-text-muted); font-weight: bold;">Elías Ochoa</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Sección de la Ubicación (sección 3) -->
    <section id="ubicacion" class="proyecto-ubicacion">
        <div class="container container--wide">
            <h2 style="font-size: var(--text-3xl); margin-bottom: var(--space-4);">Ubicación</h2>
            <p class="ubicacion-texto" style="color: var(--color-text-muted); margin-bottom: var(--space-6); font-size: var(--text-lg);">
                Frente al mar, a minutos del centro. El equilibrio perfecto entre 
                tranquilidad y accesibilidad.
            </p>
            <div class="mapa-container" style="border-radius: var(--radius-md); overflow: hidden; margin-bottom: var(--space-8); box-shadow: var(--shadow-sm);">
                <!-- 
                  MAPA EMBEBIDO — Google Maps o similar
                  Reemplazar src con el embed real de la ubicación
                  -->
                <iframe 
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3398.2684633353406!2d-106.40883842453454!3d31.599102774177982!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86e766e2aee37dd7%3A0x33a53ddce213988c!2sUniversidad%20Tecnol%C3%B3gica%20de%20Ciudad%20Ju%C3%A1rez.%20(UTCJ)!5e0!3m2!1ses-419!2smx!4v1775250462603!5m2!1ses-419!2smx"
                    width="600"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </iframe>
            </div>
            <div class="ubicacion-detalles" style="display: flex; gap: var(--space-6); flex-wrap: wrap;">
                <div class="detalle-item" style="background: var(--color-surface); padding: var(--space-4) var(--space-6); border-radius: var(--radius-full); box-shadow: var(--shadow-sm);">
                    <strong>Check-in:</strong> 15:00 hrs
                </div>
                <div class="detalle-item" style="background: var(--color-surface); padding: var(--space-4) var(--space-6); border-radius: var(--radius-full); box-shadow: var(--shadow-sm);">
                    <strong>Check-out:</strong> 11:00 hrs
                </div>
                <div class="detalle-item" style="background: var(--color-surface); padding: var(--space-4) var(--space-6); border-radius: var(--radius-full); box-shadow: var(--shadow-sm);">
                    <strong>Contacto:</strong> contacto@salitre.mx
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once "../includes/footer.php"; ?>
