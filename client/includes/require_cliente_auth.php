<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASE_URL')) {
    require_once dirname(__DIR__, 2) . '/config/constants.php';
}

if (empty($_SESSION['cliente_id'])) {
    header('Location: ' . BASE_URL . 'client/auth/login.php', true, 302);
    exit;
}
