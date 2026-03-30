<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/config/constants.php';

if (!empty($_SESSION['cliente_id'])) {
    header('Location: ' . BASE_URL . 'client/', true, 302);
    exit;
}

$page_title = 'Iniciar sesión · Hotel Salitre';
$extra_stylesheets = ['assets/css/client/auth.css'];

$error = isset($_GET['error']) ? (string) $_GET['error'] : '';
$mensajes = [
  'credenciales' => 'Email o contraseña incorrectos.',
  'campos' => 'Completa todos los campos.',
  'sistema' => 'Error temporal. Intenta de nuevo.',
];
$msg_error = $mensajes[$error] ?? '';

require dirname(__DIR__) . '/includes/header.php';

$base = BASE_URL;
$action = $base . 'client/auth/procesar_auth.php';
$registro = $base . 'client/auth/registro.php';
?>
  <main id="contenido-principal" class="auth-page">
    <div class="auth-card fade-in">
      <h1 class="auth-card__title">Iniciar sesión</h1>
      <p class="auth-card__lead">Accede para gestionar tus reservas.</p>
<?php if ($msg_error !== '') : ?>
      <p class="auth-alert auth-alert--error" role="alert"><?php echo htmlspecialchars($msg_error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>
      <form class="auth-form" method="post" action="<?php echo htmlspecialchars($action, ENT_QUOTES, 'UTF-8'); ?>" novalidate>
        <input type="hidden" name="accion" value="login">
        <div class="auth-form__field">
          <label class="auth-form__label" for="email">Email</label>
          <input class="auth-form__input" type="email" id="email" name="email" required autocomplete="email">
        </div>
        <div class="auth-form__field">
          <label class="auth-form__label" for="password">Contraseña</label>
          <input class="auth-form__input" type="password" id="password" name="password" required autocomplete="current-password">
        </div>
        <button class="auth-form__submit" type="submit">Entrar</button>
      </form>
      <p class="auth-form__footer">¿No tienes cuenta? <a href="<?php echo htmlspecialchars($registro, ENT_QUOTES, 'UTF-8'); ?>">Regístrate</a></p>
    </div>
  </main>
<?php
require dirname(__DIR__) . '/includes/footer.php';
