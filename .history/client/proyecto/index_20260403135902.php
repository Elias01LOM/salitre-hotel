<?php
/* Definimos las variables para la información del proyecto - 'client/proyecto/index.php' */

session_start();
require_once "../../config/database.php";
require_once "../../config/constants.php";

$page_title = "El Proyecto — " . SITE_NAME;
$extra_stylesheets = ["assets/css/client/proyecto.css"];

require_once "../includes/header.php";
require_once "../includes/nav.php";
?>

<main class="proyecto-page" style="padding-top: calc(var(--space-) + 72px); padding-bottom: var(--space-12); min-height: 100vh;">
    <section id="intro" class="proyecto-intro">
        <div class="container">
            <h1>Sal de la oficina. No del trabajo.</h1>
            <p class="lead">
                Hotel Salitre es un boutique hotel costero diseñado para nómadas digitales 
                y trabajadores remotos que buscan productividad sin sacrificar el bienestar.
            </p>
            
            <!-- Subsección: Sobre el Desarrollador -->
            <div class="desarrollador-section fade-in">
                <div class="desarrollador-content">
                    <div class="desarrollador-foto">
                        <!-- 
                          RECURSO: Foto del desarrollador
                          FORMATO: WebP con fallback JPG
                          DIMENSIONES: 400x400px (cuadrada)
                          UBICACIÓN: assets/img/client/team/desarrollador.webp
                          NOTA: El usuario proporcionará este recurso
                          TEMPORAL: Se muestra placeholder mientras no exista
                          -->
                        <div class="img-placeholder img-circular">
                            <span>Foto</span>
                        </div>
                    </div>
                    <div class="desarrollador-info">
                        <h2>Sobre el Desarrollador</h2>
                        <p>
                            [TEXTO DE PRUEBA — El usuario editará después]
                            Soy un desarrollador apasionado por crear experiencias digitales 
                            que combinan funcionalidad con diseño. Este proyecto representa 
                            mi compromiso con la excelencia técnica y la innovación.
                        </p>
                        <p>
                            Especializado en desarrollo web full-stack con enfoque en 
                            arquitecturas limpias y experiencias de usuario intuitivas.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Subsección: Sobre el Proyecto -->
            <div class="proyecto-info-section fade-in">
                <h2>Sobre el Proyecto</h2>
                <p>
                    Hotel Salitre nació como una respuesta a la creciente necesidad de 
                    espacios que integren trabajo y bienestar. Este sitio web fue 
                    desarrollado desde cero siguiendo las mejores prácticas de la industria.
                </p>
            </div>
            
            <!-- Subsección: Herramientas y Tecnologías -->
            <div class="herramientas-section fade-in">
                <h2>Herramientas y Tecnologías</h2>
                <div class="herramientas-grid">
                    <div class="herramienta-item">
                        <div class="herramienta-icon">🌐</div>
                        <h3>Frontend</h3>
                        <p>HTML5 · CSS3 · JavaScript Vanilla</p>
                    </div>
                    <div class="herramienta-item">
                        <div class="herramienta-icon">⚙️</div>
                        <h3>Backend</h3>
                        <p>PHP 8+ · PDO · MySQL</p>
                    </div>
                    <div class="herramienta-item">
                        <div class="herramienta-icon">🗄️</div>
                        <h3>Base de Datos</h3>
                        <p>MySQL · MariaDB (XAMPP)</p>
                    </div>
                    <div class="herramienta-item">
                        <div class="herramienta-icon">🛠️</div>
                        <h3>Desarrollo</h3>
                        <p>VS Code · Git · GitHub</p>
                    </div>
                </div>
            </div>
            
            <div class="pilares-grid">
                <div class="pilar">
                    <h3>Conectividad</h3>
                    <p>Fibra óptica garantizada. Sin caídas. Tu trabajo nunca se detiene.</p>
                </div>
                <div class="pilar">
                    <h3>Ergonomía</h3>
                    <p>Escritorios reales, sillas corporativas, monitores externos.</p>
                </div>
                <div class="pilar">
                    <h3>Diseño sin fricción</h3>
                    <p>Entorno que no distrae. Minimalismo funcional.</p>
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
