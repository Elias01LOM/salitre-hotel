<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'client/', true, 302);
    exit;
}

$nombre = trim((string) ($_POST['nombre'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$mensaje = trim((string) ($_POST['mensaje'] ?? ''));

if ($nombre === '' || $email === '' || $mensaje === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ' . BASE_URL . 'client/?contacto=error', true, 302);
    exit;
}

$lenNombre = function_exists('mb_strlen') ? mb_strlen($nombre, 'UTF-8') : strlen($nombre);
$lenEmail = function_exists('mb_strlen') ? mb_strlen($email, 'UTF-8') : strlen($email);
if ($lenNombre > 100 || $lenEmail > 150) {
    header('Location: ' . BASE_URL . 'client/?contacto=error', true, 302);
    exit;
}

try {
    $pdo = conectarDB();
    $stmt = $pdo->prepare(
        'INSERT INTO contacto (nombre, email, mensaje) VALUES (?, ?, ?)'
    );
    $stmt->execute([$nombre, $email, $mensaje]);
} catch (Throwable $e) {
    error_log('Contacto: ' . $e->getMessage());
    header('Location: ' . BASE_URL . 'client/?contacto=error', true, 302);
    exit;
}

header('Location: ' . BASE_URL . 'client/index.php?contacto=ok', true, 302);
exit;
