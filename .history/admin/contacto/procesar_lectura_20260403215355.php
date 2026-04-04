<?php
/* 
declare(strict_types=1);

require_once dirname(__DIR__) . "/includes/auth_check.php";
require_once dirname(__DIR__, 2) . "/config/database.php";

$id = filter_var($_GET["id"] ?? 0, FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: listar.php");
    exit;
}

try {
    $pdo = conectarDB();
    $stmt = $pdo->prepare("UPDATE contacto SET leido = 1 WHERE id = ?");
    $stmt->execute([$id]);
} catch (PDOException $e) {
    error_log("Error al procesar lectura de contacto: " . $e->getMessage());
}

header("Location: listar.php?success=marked_read");
exit;
