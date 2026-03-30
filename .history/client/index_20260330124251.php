<?php
session_start();
require_once dirname(__DIR__) . '/config/constants.php';
require_once CONFIG_PATH . 'database.php';

try {
    $pdo = conectarDB();
    $stmt = $pdo->prepare("SELECT nombre, slug, descripcion, tipo FROM espacios WHERE activo = 1 LIMIT 2");
    $stmt->execute();
    $espacios_destacados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $espacios_destacados = [];
}
?>