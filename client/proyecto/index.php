<?php
/* 
 * client/proyecto/index.php — Información del proyecto Hotel Salitre.
 * Referencia: Documentación Sección 05.1 y 05.5
 */

session_start();
require_once "../../config/database.php";
require_once "../../config/constants.php";

$page_title = "El Proyecto — " . SITE_NAME;
$extra_stylesheets = ["assets/css/client/proyecto.css"];

require_once "../includes/header.php";
require_once "../includes/nav.php";
?>

<main class="proyecto-page" style="padding-top: calc(var(--space-20) + 72px); padding-bottom: var(--space-12); min-height: 100vh;">
    <!-- Sección 1: Intro -->
    <section id="intro" class="proyecto-intro" style="margin-bottom: var(--space-12);">
        <div class="container container--wide">
            <h1 style="font-family: var(--font-display); font-size: var(--text-4xl); margin-bottom: var(--space-4);">Sal de la oficina. No del trabajo.</h1>
            <p class="lead" style="font-size: var(--text-xl); color: var(--color-text-muted); max-width: 800px; margin-bottom: var(--space-8);">
                Hotel Salitre es un boutique hotel costero diseñado para nómadas digitales 
                y trabajadores remotos que buscan productividad sin sacrificar el bienestar.
            </p>
            <div class="pilares-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-6);">
                <div class="pilar" style="background: var(--color-surface); padding: var(--space-6); border-radius: var(--radius-md); box-shadow: var(--shadow-sm);">
                    <h3 style="font-size: var(--text-xl); margin-bottom: var(--space-2);">Conectividad</h3>
                    <p style="color: var(--color-text-muted);">Fibra óptica garantizada. Sin caídas. Tu trabajo nunca se detiene.</p>
                </div>
                <div class="pilar" style="background: var(--color-surface); padding: var(--space-6); border-radius: var(--radius-md); box-shadow: var(--shadow-sm);">
                    <h3 style="font-size: var(--text-xl); margin-bottom: var(--space-2);">Ergonomía</h3>
                    <p style="color: var(--color-text-muted);">Escritorios reales, sillas corporativas, monitores externos.</p>
                </div>
                <div class="pilar" style="background: var(--color-surface); padding: var(--space-6); border-radius: var(--radius-md); box-shadow: var(--shadow-sm);">
                    <h3 style="font-size: var(--text-xl); margin-bottom: var(--space-2);">Diseño sin fricción</h3>
                    <p style="color: var(--color-text-muted);">Entorno que no distrae. Minimalismo funcional.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Sección 2: Conócenos -->
    <section id="conocenos" class="proyecto-conocenos" style="margin-bottom: var(--space-12); background: var(--color-surface); padding: var(--space-12) 0;">
        <div class="container container--wide">
            <h2 style="font-size: var(--text-3xl); margin-bottom: var(--space-8);">Conócenos</h2>
            <div class="conocenos-content" style="display: flex; gap: var(--space-8); align-items: center; flex-wrap: wrap;">
                <div class="conocenos-texto" style="flex: 1; min-width: 300px; color: var(--color-text-muted); font-size: var(--text-lg); line-height: 1.6;">
                    <p style="margin-bottom: var(--space-4);">
                        Nacimos de la necesidad de crear espacios donde el trabajo remoto 
                        se sienta como vacaciones. Donde el mar es tu fondo de pantalla 
                        y la productividad fluye naturalmente.
                    </p>
                    <p>
                        Cada espacio está diseñado pensando en el profesional moderno: 
                        iluminación natural, mobiliario ergonómico, tecnología de punta 
                        y esa tranquilidad que solo el mar puede dar.
                    </p>
                </div>
                <div class="conocenos-imagen" style="flex: 1; min-width: 300px;">
                    <!-- 
                      RECURSO: Imagen del equipo o propiedad
                      FORMATO: WebP con fallback JPG
                      DIMENSIONES: 800x600px
                      UBICACIÓN: assets/img/client/hero/equipo.webp
                      NOTA: El usuario proporcionará este recurso
                      TEMPORAL: Se muestra placeholder mientras no exista
                      -->
                    <div class="img-placeholder" style="width: 100%; aspect-ratio: 4/3; background: var(--color-mid); display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md);">
                        <span style="color: var(--color-text-muted); font-weight: bold;">Hotel Salitre</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Sección 3: Ubicación/Mapa -->
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
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.536988367386!2d-99.16869468509355!3d19.42702058688766!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1ff35f5bd1563%3A0x6c366f0e2de02ff7!2sEl%20%C3%81ngel%20de%20la%20Independencia!5e0!3m2!1ses-419!2smx!4v1647372693441!5m2!1ses-419!2smx"
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
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
