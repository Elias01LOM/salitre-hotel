<?php
declare(strict_types=1);
require_once '../includes/auth_check.php';

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

// Solo acepta POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'admin/contacto/listar.php');
    exit();
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    header('Location: ' . BASE_URL . 'admin/contacto/listar.php');
    exit();
}

try {
    $pdo  = conectarDB();
    $stmt = $pdo->prepare('UPDATE contacto SET leido = 1 WHERE id = :id');
    $stmt->execute([':id' => $id]);
} catch (Throwable $e) {
    error_log('Admin contacto/procesar_lectura: ' . $e->getMessage());
}

header('Location: ' . BASE_URL . 'admin/contacto/listar.php?msg=leido');
exit();
