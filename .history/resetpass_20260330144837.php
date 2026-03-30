<?php
require_once 'config/constants.php';
require_once 'config/database.php';

try {
    $pdo = conectarDB();
    
    // Definimos la nueva contraseña en texto plano
    $nueva_password = 'admin123';
    
    // Generamos el hash seguro
    $hash = password_hash($nueva_password, PASSWORD_DEFAULT);
    
    // Actualizamos el registro del superadmin
    $stmt = $pdo->prepare("UPDATE staff SET password = ? WHERE email = 'admin@salitre.mx'");
    $stmt->execute([$hash]);
    
    echo "<h3 style='color: green; font-family: sans-serif;'>✅ Breach superado. Contraseña actualizada con éxito.</h3>";
    echo "<p style='font-family: sans-serif;'>Email: <strong>admin@salitre.mx</strong></p>";
    echo "<p style='font-family: sans-serif;'>Nueva contraseña: <strong>" . $nueva_password . "</strong></p>";
    echo "<p style='color: red; font-family: sans-serif;'><strong>ATENCIÓN:</strong> Borra este archivo (reset_pass.php) inmediatamente después de leer esto.</p>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>