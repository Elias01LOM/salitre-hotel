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

$page_title = 'Crear cuenta · Hotel Salitre';
$extra_stylesheets = ['assets/css/client/auth.css'];

$error = isset($_GET['error']) ? (string) $_GET['error'] : '';
$mensajes = [
    'campos' => 'Completa nombre, email y contraseña.',
    'email' => 'El email no es válido.',
    'password' => 'La contraseña debe tener al menos 8 caracteres.',
    'existe' => 'Ya existe una cuenta con ese email.',
    'sistema' => 'Error temporal. Intenta de nuevo.',
];
$msg_error = $mensajes[$error] ?? '';

require dirname(__DIR__) . '/includes/header.php';

$base = BASE_URL;
$action = $base . 'client/auth/procesar_auth.php';
$login = $base . 'client/auth/login.php';
?>
  <main id="contenido-principal" class="auth-page">
    <div class="auth-card fade-in">
      <h1 class="auth-card__title">Crear cuenta</h1>
      <p class="auth-card__lead">Únete para reservar espacios en Hotel Salitre.</p>
<?php if ($msg_error !== '') : ?>
      <p class="auth-alert auth-alert--error" role="alert"><?php echo htmlspecialchars($msg_error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>
      <form class="auth-form" method="post" action="<?php echo htmlspecialchars($action, ENT_QUOTES, 'UTF-8'); ?>" novalidate>
        <input type="hidden" name="accion" value="registro">
        <div class="auth-form__field">
          <label class="auth-form__label" for="nombre">Nombre</label>
          <input class="auth-form__input" type="text" id="nombre" name="nombre" required autocomplete="name" maxlength="100">
        </div>
        <div class="auth-form__field">
          <label class="auth-form__label" for="email">Email</label>
          <input class="auth-form__input" type="email" id="email" name="email" required autocomplete="email">
        </div>
        <div class="auth-form__field">
          <label class="auth-form__label" for="password">Contraseña</label>
          <input class="auth-form__input" type="password" id="password" name="password" required autocomplete="new-password" minlength="8">
        </div>
        <div class="auth-form__field">
          <label class="auth-form__label" for="telefono">Teléfono</label>
          <input class="auth-form__input" type="tel" id="telefono" name="telefono" autocomplete="tel" maxlength="20">
        </div>
        <button class="auth-form__submit" type="submit">Registrarme</button>
      </form>
      <p class="auth-form__footer">¿Ya tienes cuenta? <a href="<?php echo htmlspecialchars($login, ENT_QUOTES, 'UTF-8'); ?>">Inicia sesión</a></p>
    </div>
  </main>
<?php
require dirname(__DIR__) . '/includes/footer.php';
