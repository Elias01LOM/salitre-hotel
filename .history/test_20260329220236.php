<?php
// Mostrar errores para la prueba
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cargar configuración
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/config/database.php';

echo "<h3>Prueba de Sistema - Hotel Salitre</h3>";

try {
    $pdo = conectarDB();
    if ($pdo) {
        echo "<p style='color: green;'>✅ Conexión a PDO exitosa. La base de datos está respondiendo.</p>";
        
        // Prueba de consulta rápida
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM espacios");
        $resultado = $stmt->fetch();
        echo "<p>Total de espacios en la BD: <strong>" . $resultado['total'] . "</strong></p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Fallo en la prueba: " . $e->getMessage() . "</p>";
}
?>