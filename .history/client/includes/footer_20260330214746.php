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

<script src="<?= $base ?>assets/js/shared/animations.js"></script>
<script src="<?= $base ?>assets/js/client/main.js"></script>

</body>
</html>