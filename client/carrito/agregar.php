<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__) . '/includes/require_cliente_auth.php';

header('Location: ' . BASE_URL . 'client/espacios/', true, 302);
exit;
