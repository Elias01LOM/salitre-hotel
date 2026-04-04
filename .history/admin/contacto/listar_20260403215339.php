<?php
/* 'admin/contacto/listar.php' es la página para listar todos los mensajes de contacto desde el panel de administración */
declare(strict_types=1);
require_once '../includes/auth_check.php';

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
// Declaramos un array vacío para almacenar los mensajes que se obtendrán de la base de datos
$mensajes = [];
try {
    $pdo  = conectarDB();
    $stmt = $pdo->prepare(
        'SELECT id, nombre, email, mensaje, leido, creado_en
         FROM contacto
         ORDER BY leido ASC, creado_en DESC'
    );
    $stmt->execute();
    $mensajes = $stmt->fetchAll();
} catch (Throwable $e) {
    error_log('Admin contacto/listar: ' . $e->getMessage());
}

$no_leidos = count(array_filter($mensajes, fn($m) => !(bool) $m['leido']));

$flash = (isset($_GET['success']) && $_GET['success'] === 'marked_read')
    ? ['type' => 'success', 'text' => 'Mensaje marcado como leído']
    : null;
// Configuramos el título de la página y los estilos adicionales, luego incluimos el header y sidebar del admin
$page_title = 'Mensajes - Panel Salitre';
$extra_css  = ['assets/css/admin/crud.css'];
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>
<main class="main-content">
  <div class="topbar">
    <h1 class="topbar__title">Bandeja de Mensajes</h1>
    <span class="topbar__meta">
      <?php if ($no_leidos > 0) : ?>
        <strong style="color:#1d4ed8;"><?php echo $no_leidos; ?> sin leer</strong>
        &nbsp;·&nbsp; <?php echo count($mensajes); ?> en total
      <?php else : ?>
        <?php echo count($mensajes); ?> mensaje(s) &nbsp;·&nbsp; Todos leídos
      <?php endif; ?>
    </span>
  </div>

  <div class="content-area">

    <?php if ($flash) : ?>
    <div class="flash flash--<?php echo htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8'); ?>" role="status">
      <?php echo htmlspecialchars($flash['text'], ENT_QUOTES, 'UTF-8'); ?>
    </div>
    <?php endif; ?>

    <div class="data-table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Mensaje</th>
            <th>Estado</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
<?php if (empty($mensajes)) : ?>
          <tr>
            <td colspan="6" class="table-empty">No hay mensajes de contacto aún.</td>
          </tr>
<?php else : ?>
<?php foreach ($mensajes as $m) :
    $id    = (int) $m['id'];
    $leido = (bool) $m['leido'];
    // Preparamos una versión corta del mensaje para mostrar en la tabla - solo 80 caracteres
    $msg_raw    = (string) $m['mensaje'];
    $msg_corto  = mb_strlen($msg_raw) > 80
        ? htmlspecialchars(mb_substr($msg_raw, 0, 80), ENT_QUOTES, 'UTF-8') . '&hellip;'
        : htmlspecialchars($msg_raw, ENT_QUOTES, 'UTF-8');
    // Formateamos la fecha de creación del mensaje para mostrarla en formato 'd/m/Y H:i'
    $fecha_obj = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', (string) $m['creado_en']);
    $fecha_fmt = $fecha_obj
        ? $fecha_obj->format('d/m/Y H:i')
        : htmlspecialchars((string) $m['creado_en'], ENT_QUOTES, 'UTF-8');

    $proc_action = htmlspecialchars(BASE_URL . 'admin/contacto/procesar_lectura.php', ENT_QUOTES, 'UTF-8');
?>
          <tr<?php echo !$leido ? ' style="background:#eff6ff;"' : ''; ?>>
            <td style="white-space:nowrap;"><?php echo $fecha_fmt; ?></td>
            <td><?php echo htmlspecialchars((string) $m['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
              <a href="mailto:<?php echo htmlspecialchars((string) $m['email'], ENT_QUOTES, 'UTF-8'); ?>"
                 style="color:#3b82f6;">
                <?php echo htmlspecialchars((string) $m['email'], ENT_QUOTES, 'UTF-8'); ?>
              </a>
            </td>
            <td style="max-width:22rem;"
                title="<?php echo htmlspecialchars($msg_raw, ENT_QUOTES, 'UTF-8'); ?>">
              <?php echo $msg_corto; ?>
            </td>
            <td>
              <?php if (!$leido) : ?>
                <span class="badge" style="background-color: var(--color-warning); color: #000; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Nuevo</span>
              <?php else : ?>
                <span class="badge" style="background-color: var(--color-mid); color: var(--color-text-muted); padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Leído</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if (!$leido) : ?>
                <a class="btn btn--edit" href="<?php echo $proc_action; ?>?id=<?php echo $id; ?>">Marcar como leído</a>
              <?php endif; ?>
            </td>
          </tr>
<?php endforeach; ?>
<?php endif; ?>
        </tbody>
      </table>
    </div><!-- /.data-table-wrap -->

<?php require_once '../includes/footer.php'; ?>
