<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/config/constants.php';

session_unset();
session_destroy();

header('Location: ' . BASE_URL . 'admin/login.php');
exit();
