<?php
/* 'admin/espacios/eliminar.php' es la página para eliminar (desactivar) un espacio desde el panel de administración */
declare(strict_types=1);
require_once '../includes/auth_check.php';

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
// Sólo aceptamos POSTpara protección básica contra activación por enlace GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'admin/espacios/listar.php');
    exit();
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    header('Location: ' . BASE_URL . 'admin/espacios/listar.php');
    exit();
}

try {
    $pdo  = conectarDB();
    // Soft delete: desactivar, no borrar físicamente
    // Preserva la integridad referencial con la tabla de reservas
    $stmt = $pdo->prepare('UPDATE espacios SET activo = 0 WHERE id = :id');
    $stmt->execute([':id' => $id]);
} catch (Throwable $e) {
    error_log('Admin espacios/eliminar: ' . $e->getMessage());
}

header('Location: ' . BASE_URL . 'admin/espacios/listar.php?msg=desactivado');
exit();
