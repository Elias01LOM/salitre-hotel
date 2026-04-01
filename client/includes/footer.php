<?php $base = BASE_URL; ?>
<footer class="footer">
    <div class="footer-container">
        <div class="footer__grid">
            <div class="footer__about">
                <p class="footer__brand">Hotel Salitre</p>
                <p class="footer__tagline">Sal de la oficina. No del trabajo.</p>
            </div>
            <div class="footer__nav">
                <p class="footer__title">Navegación</p>
                <ul class="footer__list">
                    <li><a href="#hero">Inicio</a></li>
                    <li><a href="#espacios">Espacios</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </div>
        </div>
        <div class="footer__bottom">
            <p>&copy; <?= date('Y') ?> Hotel Salitre. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<script src="<?= $base ?>assets/js/shared/animations.js" defer></script>
<script src="<?= $base ?>assets/js/client/main.js" defer></script>

<?php if (isset($extra_scripts) && is_array($extra_scripts)): ?>
    <?php foreach ($extra_scripts as $script): ?>
        <script src="<?= htmlspecialchars($base . $script, ENT_QUOTES, 'UTF-8') ?>" defer></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>