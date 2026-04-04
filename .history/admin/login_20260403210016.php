<?php
/* 'admin/login.php' es la página de inicio de sesión para el panel de administración de Salitre */
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/config/constants.php';

// Si ya hay sesión activa, redireccionamos al dashboard
if (isset($_SESSION['staff_id'])) {
    header('Location: ' . BASE_URL . 'admin/index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $pass  = (string) ($_POST['password'] ?? '');

    if ($email === '' || $pass === '') {
        $error = 'Completa todos los campos.';
    } else {
        require_once dirname(__DIR__) . '/config/database.php';
        try {
            $pdo  = conectarDB();
            $stmt = $pdo->prepare(
                'SELECT id, nombre, password, rol FROM staff WHERE email = :email AND activo = 1 LIMIT 1'
            );
            $stmt->execute([':email' => $email]);
            $staff = $stmt->fetch();

            if ($staff && password_verify($pass, (string) $staff['password'])) {
                session_regenerate_id(true);
                $_SESSION['staff_id']     = (int) $staff['id'];
                $_SESSION['staff_nombre'] = (string) $staff['nombre'];
                $_SESSION['staff_rol']    = (string) $staff['rol'];
                header('Location: ' . BASE_URL . 'admin/index.php');
                exit();
            } else {
                $error = 'Credenciales incorrectas.';
            }
        } catch (Throwable $e) {
            error_log('Admin login error: ' . $e->getMessage());
            $error = 'Error de conexión. Inténtalo de nuevo.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acceso - Panel Salitre</title>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/admin/auth.css">
</head>
<body class="auth-body">

  <div class="auth-card">
    <div class="auth-card__brand">
      /* <svg class="auth-card__icon" width="32" height="32" viewBox="0 0 24 24" fill="none">
        <path d="M12 2.5c3.9 0 7 3.1 7 7 0 5.5-7 12-7 12S5 15 5 9.5c0-3.9 3.1-7 7-7Z"
              stroke="currentColor" stroke-width="1.5"/>
        <path d="M9.2 10.3c.6-1.5 2.1-2.6 3.8-2.6 1.2 0 2.3.5 3 1.4"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
      </svg> */
      <span class="auth-card__title">Panel de Administración</span>
    </div>

    <p class="auth-card__subtitle">Acceso Restringido - Solo Personal Autorizado</p>

<?php if ($error !== '') : ?>
    <p class="auth-error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

    <form class="auth-form" method="post" action="" novalidate>
      <div class="auth-form__group">
        <label class="auth-form__label" for="email">Correo electrónico</label>
        <input
          class="auth-form__input"
          type="email"
          id="email"
          name="email"
          required
          maxlength="150"
          autocomplete="email"
          value="<?php echo htmlspecialchars((string) ($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
      </div>
      <div class="auth-form__group">
        <label class="auth-form__label" for="password">Contraseña</label>
        <input
          class="auth-form__input"
          type="password"
          id="password"
          name="password"
          required
          maxlength="100"
          autocomplete="current-password">
      </div>
      <button class="auth-form__submit" type="submit">Ingresar</button>
    </form>
  </div>

</body>
</html>
