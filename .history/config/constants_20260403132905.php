<?php
/* Definimos las rutas absolutas y URLs bases de direcc */
define('BASE_URL', 'http://localhost/salitre/');

define('BASE_PATH', dirname(__DIR__) . '/');
define('CONFIG_PATH', BASE_PATH . 'config/');
define('INCLUDES_CLIENT_PATH', BASE_PATH . 'client/includes/');
define('INCLUDES_ADMIN_PATH', BASE_PATH . 'admin/includes/');

define('MONEDA', 'USD');

/* 
 * Constantes de negocio para cálculos de reserva.
 * IVA y LIMPIEZA_FEE se usan en client/carrito/agregar.php (línea 60).
 * Referencia: Documentación Sección 03.4 y 10 (Prompt 0.2)
 */
define('SITE_NAME', 'Hotel Salitre');
define('SITE_TAGLINE', 'Sal de la oficina. No del trabajo.');
define('IVA', 0.16);
define('LIMPIEZA_FEE', 25.00);
define('UPLOAD_PATH', __DIR__ . '/../assets/img/client/espacios/');
?>
