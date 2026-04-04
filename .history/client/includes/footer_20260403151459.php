<?php $base = BASE_URL; ?>
<footer class="footer" role="contentinfo">
    <div class="container container--wide">
        <!-- Definimos la franja superior (logo + tagline -->
        <div class="footer-top">
            <div class="footer-logo">
                <img src="<?= BASE_URL ?>assets/img/logo/logo.svg" 
                     alt="Hotel Salitre" 
                     width="120" 
                     height="40">
                <p class="footer-tagline">"Sal de la oficina. No del trabajo."</p>
            </div>
        </div>
        
        <!-- Tres columnas de enlaces -->
        <div class="footer-grid">
            <!-- Columna 1: Explorar -->
            <div class="footer-col">
                <h3>Explorar</h3>
                <ul>
                    <li><a href="<?= BASE_URL ?>client/espacios/index.php">Espacios</a></li>
                    <li><a href="<?= BASE_URL ?>client/index.php#servicios">Servicios</a></li>
                    <li><a href="<?= BASE_URL ?>client/agenda/index.php">Agenda</a></li>
                    <li><a href="<?= BASE_URL ?>client/proyecto/index.php">Proyecto</a></li>
                </ul>
            </div>
            
            <!-- Columna 2: Información -->
            <div class="footer-col">
                <h3>Información</h3>
                <ul>
                    <li><a href="<?= BASE_URL ?>client/proyecto/index.php#intro">Intro del Proyecto</a></li>
                    <li><a href="<?= BASE_URL ?>client/proyecto/index.php#conocenos">Conócenos</a></li>
                    <li><a href="<?= BASE_URL ?>client/proyecto/index.php#ubicacion">Ubicación</a></li>
                    <li><a href="<?= BASE_URL ?>client/index.php#contacto">Contacto</a></li>
                </ul>
            </div>
            
            <!-- Columna 3: Contacto -->
            <div class="footer-col">
                <h3>Contáctanos</h3>
                <ul class="footer-contact">
                    <li>📍 Costa Mexicana, México</li>
                    <li>📞 +52 (555) 123-4567</li>
                    <li>✉️ contacto@salitre.mx</li>
                    <li>🕐 Check-in: 15:00 · Check-out: 11:00</li>
                </ul>
            </div>
        </div>
        
        <!-- Franja inferior: Copyright + Redes -->
        <div class="footer-bottom">
            <p>&copy; <?= date("Y") ?> Hotel Salitre. Todos los derechos reservados.</p>
            <div class="footer-social">
                <a href="#" aria-label="Facebook">FB</a>
                <a href="#" aria-label="Instagram">IG</a>
                <a href="#" aria-label="Twitter">TW</a>
            </div>
        </div>
    </div>
</footer>

<script src="<?= $base ?>assets/js/shared/animations.js" defer></script>
<script src="<?= $base ?>assets/js/shared/alerts.js" defer></script>
<script src="<?= $base ?>assets/js/client/main.js" defer></script>

<?php if (isset($extra_scripts) && is_array($extra_scripts)): ?>
    <?php foreach ($extra_scripts as $script): ?>
        <script src="<?= htmlspecialchars($base . $script, ENT_QUOTES, 'UTF-8') ?>" defer></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>