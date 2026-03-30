<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'client/auth/login.php', true, 302);
    exit;
}

$accion = isset($_POST['accion']) ? (string) $_POST['accion'] : '';

$pdo = conectarDB();

if ($accion === 'registro') {
    $nombre = isset($_POST['nombre']) ? trim((string) $_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim((string) $_POST['email']) : '';
    $password = isset($_POST['password']) ? (string) $_POST['password'] : '';
    $telefono = isset($_POST['telefono']) ? trim((string) $_POST['telefono']) : '';

    if ($nombre === '' || $email === '' || $password === '') {
        header('Location: ' . BASE_URL . 'client/auth/registro.php?error=campos', true, 302);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ' . BASE_URL . 'client/auth/registro.php?error=email', true, 302);
        exit;
    }

    if (strlen($password) < 8) {
        header('Location: ' . BASE_URL . 'client/auth/registro.php?error=password', true, 302);
        exit;
    }

    $stmtExiste = $pdo->prepare('SELECT id FROM clientes WHERE email = ? LIMIT 1');
    $stmtExiste->execute([$email]);
    if ($stmtExiste->fetch() !== false) {
        header('Location: ' . BASE_URL . 'client/auth/registro.php?error=existe', true, 302);
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmtIns = $pdo->prepare(
        'INSERT INTO clientes (nombre, email, password, telefono) VALUES (?, ?, ?, ?)'
    );
    $stmtIns->execute([
        $nombre,
        $email,
        $hash,
        $telefono === '' ? null : $telefono,
    ]);

    $id = (int) $pdo->lastInsertId();
    $_SESSION['cliente_id'] = $id;
    $_SESSION['cliente_nombre'] = $nombre;

    header('Location: ' . BASE_URL . 'client/', true, 302);
    exit;
}

if ($accion === 'login') {
    $email = isset($_POST['email']) ? trim((string) $_POST['email']) : '';
    $password = isset($_POST['password']) ? (string) $_POST['password'] : '';

    if ($email === '' || $password === '') {
        header('Location: ' . BASE_URL . 'client/auth/login.php?error=campos', true, 302);
        exit;
    }

    $stmt = $pdo->prepare('SELECT id, nombre, password FROM clientes WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false || !password_verify($password, (string) $row['password'])) {
        header('Location: ' . BASE_URL . 'client/auth/login.php?error=credenciales', true, 302);
        exit;
    }

    $_SESSION['cliente_id'] = (int) $row['id'];
    $_SESSION['cliente_nombre'] = (string) $row['nombre'];

    header('Location: ' . BASE_URL . 'client/', true, 302);
    exit;
}

header('Location: ' . BASE_URL . 'client/auth/login.php', true, 302);
exit;
