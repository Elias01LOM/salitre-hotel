<?php
declare(strict_types=1);
require_once dirname(dirname(__DIR__)) . '/config/constants.php';
require_once dirname(dirname(__DIR__)) . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if (empty($nombre) || empty($email) || empty($mensaje)) {
        header('Location: ' . BASE_URL . 'client/index.php?contacto=error#contacto');
        exit;
    }

    try {
        $pdo = conectarDB();
        $stmt = $pdo->prepare('INSERT INTO contacto (nombre, email, mensaje) VALUES (?, ?, ?)');
        $stmt->execute([$nombre, $email, $mensaje]);
        header('Location: ' . BASE_URL . 'client/index.php?contacto=ok#contacto');
        exit;
    } catch (Throwable $e) {
        error_log('Error contacto: ' . $e->getMessage());
        header('Location: ' . BASE_URL . 'client/index.php?contacto=error#contacto');
        exit;
    }
} else {
    header('Location: ' . BASE_URL . 'client/index.php');
    exit;
}
