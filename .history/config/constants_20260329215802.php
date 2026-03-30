<?php
/* Definimos las rutas absolutas y URLs base*/

// Si la carpeta raíz en htdocs tiene otro nombre, ajustarlo aquí.
define('BASE_URL', 'http://localhost/salitre/');

define('BASE_PATH', dirname(__DIR__) . '/');
define('CONFIG_PATH', BASE_PATH . 'config/');
define('INCLUDES_CLIENT_PATH', BASE_PATH . 'client/includes/');
define('INCLUDES_ADMIN_PATH', BASE_PATH . 'admin/includes/');

define('MONEDA', 'USD');
?>