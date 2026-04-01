<?php
session_start();
require_once dirname(__DIR__) . "/../config/database.php";
require_once dirname(__DIR__) . "/../config/constants.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . BASE_URL . "client/auth/login.php");
    exit;
}

$action = $_POST["action"] ?? "";

try {
    $pdo = conectarDB();
} catch (PDOException $e) {
    // Si la DB falla temporalmente, pateamos al index (o log genérico)
    error_log("Fallo Auth DB: " . $e->getMessage());
    header("Location: " . BASE_URL . "client/auth/login.php");
    exit;
}

// ============================================
// REGISTRO
// ============================================
if ($action === "registro") {
    // Sanitizar inputs
    $nombre = trim($_POST["nombre"] ?? "");
    $email = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirmar_password"] ?? "";
    
    // Validar campos
    if (empty($nombre) || empty($email) || empty($password)) {
        header("Location: " . BASE_URL . "client/auth/registro.php?error=empty_fields");
        exit;
    }
    
    // Validar email formato
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: " . BASE_URL . "client/auth/registro.php?error=invalid_email");
        exit;
    }
    
    // Validar passwords iguales
    if ($password !== $confirm_password) {
        header("Location: " . BASE_URL . "client/auth/registro.php?error=passwords_mismatch");
        exit;
    }
    
    // Validar password longitud (mínimo 6 caracteres)
    if (strlen($password) < 6) {
        header("Location: " . BASE_URL . "client/auth/registro.php?error=short_password");
        exit;
    }
    
    // Verificar que el email no exista
    $stmt = $pdo->prepare("SELECT id FROM clientes WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        header("Location: " . BASE_URL . "client/auth/registro.php?error=email_exists");
        exit;
    }
    
    // Hash de contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // INSERT
    $stmt = $pdo->prepare(
        "INSERT INTO clientes (nombre, email, password) VALUES (?, ?, ?)"
    );
    $stmt->execute([$nombre, $email, $password_hash]);
    
    // Iniciar sesión
    $_SESSION["cliente_id"] = $pdo->lastInsertId();
    $_SESSION["cliente_nombre"] = $nombre;
    session_regenerate_id(true);
    
    // Redirect a home o carrito si quedó pendiente (opcional, pero solo login envía ?redirect natural, revisamos sesión si la metimos)
    if (isset($_SESSION["redirect_after_login"]) && $_SESSION["redirect_after_login"] === "carrito") {
        unset($_SESSION["redirect_after_login"]);
        header("Location: " . BASE_URL . "client/carrito/index.php");
    } else {
        header("Location: " . BASE_URL . "client/index.php");
    }
    exit;
}

// ============================================
// LOGIN
// ============================================
if ($action === "login") {
    $email = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"] ?? "";
    
    // Validar campos
    if (empty($email) || empty($password)) {
        header("Location: " . BASE_URL . "client/auth/login.php?error=1");
        exit;
    }
    
    // Buscar usuario
    $stmt = $pdo->prepare("SELECT id, nombre, password FROM clientes WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verificar contraseña (mensaje genérico para no revelar si email existe)
    if (!$usuario || !password_verify($password, $usuario["password"])) {
        header("Location: " . BASE_URL . "client/auth/login.php?error=1");
        exit;
    }
    
    // Iniciar sesión (regenerate evita session fixation)
    $_SESSION["cliente_id"] = $usuario["id"];
    $_SESSION["cliente_nombre"] = $usuario["nombre"];
    session_regenerate_id(true);
    
    // Reconstruir carrito si quedó posteado temporalmente antes del login
    if (isset($_SESSION["carrito_pendiente"])) {
        // Podríamos procesar dinámicamente el carrito, pero como el agregar.php original no esperaba esto directo 
        // y solo usaba SESSION["carrito"], lo redirigimos directo al endpoint si es posible, o simplemente lo dejamos en carrito
        // Nota: para no complicar el requerimiento 05.3, la lógica estricta pide redirigir:
        unset($_SESSION["carrito_pendiente"]); // clear temporal
    }

    // Redirect según ?redirect originado del input hidden
    $redirect = $_POST["redirect"] ?? "home";
    if ($redirect === "carrito") {
        header("Location: " . BASE_URL . "client/carrito/index.php");
    } else {
        header("Location: " . BASE_URL . "client/index.php");
    }
    exit;
}

// Si llega aquí, action inválido
header("Location: " . BASE_URL . "client/auth/login.php");
exit;
