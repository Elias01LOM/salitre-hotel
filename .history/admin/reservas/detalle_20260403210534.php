<?php
/* 'admin/reservas/detalle.php' muestra el detalle completo de una reserva específica */
declare(strict_types=1);
require_once '../includes/auth_check.php';

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

const ESTADOS_RESERVA = ['pendiente', 'confirmada', 'cancelada', 'completada'];
// Validamos los parámetros de entrada 'GET'
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    header('Location: ' . BASE_URL . 'admin/reservas/listar.php');
    exit();
}

$pdo     = conectarDB();
$msg_ok  = isset($_GET['msg']) && $_GET['msg'] === 'actualizado';
$error   = '';
// Actualizamos el estado de la reserva usando lógica 'POST' (si se envió el formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_estado = trim((string) ($_POST['estado'] ?? ''));
    if (!in_array($nuevo_estado, ESTADOS_RESERVA, true)) {
        $error = 'Estado no válido.';
    } else {
        try {
            $st = $pdo->prepare('UPDATE reservas SET estado = :estado WHERE id = :id');
            $st->execute([':estado' => $nuevo_estado, ':id' => $id]);
            header('Location: ' . BASE_URL . 'admin/reservas/listar.php?success=updated');
            exit();
        } catch (Throwable $e) {
            error_log('Admin reservas/detalle UPDATE: ' . $e->getMessage());
            $error = 'Error al actualizar el estado.';
        }
    }
}
// Obtenemos el detalle completo de la reserva, con JOINs para traer datos relacionados de cliente y espacio
$reserva = null;
try {
    $stmt = $pdo->prepare(
        'SELECT
           r.id,
           r.fecha_entrada,
           r.fecha_salida,
           r.noches,
           r.precio_total,
           r.estado,
           r.notas,
           r.creado_en,
           c.id        AS cliente_id,
           c.nombre    AS cliente_nombre,
           c.email     AS cliente_email,
           c.telefono  AS cliente_telefono,
           e.id        AS espacio_id,
           e.nombre    AS espacio_nombre,
           e.tipo      AS espacio_tipo,
           e.precio_noche
         FROM reservas r
         JOIN clientes  c ON r.cliente_id  = c.id
         JOIN espacios  e ON r.espacio_id  = e.id
         WHERE r.id = :id
         LIMIT 1'
    );
    $stmt->execute([':id' => $id]);
    $reserva = $stmt->fetch();
} catch (Throwable $e) {
    error_log('Admin reservas/detalle SELECT: ' . $e->getMessage());
}

if (!$reserva) {
    header('Location: ' . BASE_URL . 'admin/reservas/listar.php');
    exit();
}
// Validamos que el estado actual de la reserva sea uno de los estados permitidos, si no, asignamos 'pendiente' por defecto
$estado_actual = in_array($reserva['estado'], ESTADOS_RESERVA, true)
    ? $reserva['estado']
    : 'pendiente';

$tipo_labels = ['estudio' => 'Estudio', 'loft' => 'Loft', 'suite' => 'Suite', 'villa' => 'Villa'];

$created = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', (string) $reserva['creado_en']);
// Definimos el título de la página, cargamos el header y sidebar
$page_title = 'Reserva #' . $id . ' · Panel Salitre';
$extra_css  = ['assets/css/admin/crud.css'];
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>
<main class="main-content">
  <div class="topbar">
    <h1 class="topbar__title">Detalle de Reserva #<?php echo $id; ?></h1>
    <span class="topbar__meta">
      <a href="<?php echo htmlspecialchars(BASE_URL . 'admin/reservas/listar.php', ENT_QUOTES, 'UTF-8'); ?>"
         style="color:#6b7280;font-size:.875rem;">← Volver al listado</a>
    </span>
  </div>

  <div class="content-area">

    <?php if ($msg_ok) : ?>
    <div class="flash flash--success" role="status">Estado actualizado correctamente.</div>
    <?php endif; ?>

    <?php if ($error !== '') : ?>
    <div class="flash flash--error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <!-- Definimos el grid de paneles -->
    <div class="detail-grid">

      <!-- Definimos el panel del cliente -->
      <div class="detail-panel">
        <p class="detail-panel__title">Cliente</p>
        <dl class="detail-dl">
          <dt>Nombre</dt>
          <dd><?php echo htmlspecialchars((string) $reserva['cliente_nombre'], ENT_QUOTES, 'UTF-8'); ?></dd>
          <dt>Email</dt>
          <dd><?php echo htmlspecialchars((string) $reserva['cliente_email'], ENT_QUOTES, 'UTF-8'); ?></dd>
          <dt>Teléfono</dt>
          <dd><?php echo $reserva['cliente_telefono']
              ? htmlspecialchars((string) $reserva['cliente_telefono'], ENT_QUOTES, 'UTF-8')
              : '<span style="color:#9ca3af">—</span>'; ?></dd>
        </dl>
      </div>

      <!-- Panel: Espacio -->
      <div class="detail-panel">
        <p class="detail-panel__title">Espacio</p>
        <dl class="detail-dl">
          <dt>Nombre</dt>
          <dd><?php echo htmlspecialchars((string) $reserva['espacio_nombre'], ENT_QUOTES, 'UTF-8'); ?></dd>
          <dt>Tipo</dt>
          <dd><?php echo htmlspecialchars($tipo_labels[$reserva['espacio_tipo']] ?? $reserva['espacio_tipo'], ENT_QUOTES, 'UTF-8'); ?></dd>
          <dt>Precio / noche</dt>
          <dd>$<?php echo number_format((float) $reserva['precio_noche'], 2); ?> USD</dd>
        </dl>
      </div>

      <!-- Panel: Desglose de reserva -->
      <div class="detail-panel">
        <p class="detail-panel__title">Desglose de Reserva</p>
        <dl class="detail-dl">
          <dt>Entrada</dt>
          <dd><?php echo htmlspecialchars((string) $reserva['fecha_entrada'], ENT_QUOTES, 'UTF-8'); ?></dd>
          <dt>Salida</dt>
          <dd><?php echo htmlspecialchars((string) $reserva['fecha_salida'], ENT_QUOTES, 'UTF-8'); ?></dd>
          <dt>Noches</dt>
          <dd><?php echo (int) $reserva['noches']; ?></dd>
          <dt>Precio total</dt>
          <dd><strong>$<?php echo number_format((float) $reserva['precio_total'], 2); ?> USD</strong></dd>
          <dt>Creada el</dt>
          <dd><?php echo $created ? htmlspecialchars($created->format('d/m/Y H:i'), ENT_QUOTES, 'UTF-8') : htmlspecialchars((string) $reserva['creado_en'], ENT_QUOTES, 'UTF-8'); ?></dd>
        </dl>
      </div>

      <!-- Panel: Notas -->
      <div class="detail-panel">
        <p class="detail-panel__title">Notas del cliente</p>
        <?php if (!empty($reserva['notas'])) : ?>
        <div class="detail-notes"><?php echo htmlspecialchars((string) $reserva['notas'], ENT_QUOTES, 'UTF-8'); ?></div>
        <?php else : ?>
        <p style="font-size:.875rem;color:#9ca3af;">Sin notas.</p>
        <?php endif; ?>
      </div>

      <!-- Panel: Gestión de estado — full width -->
      <div class="detail-panel detail-panel--span2">
        <p class="detail-panel__title">Gestión de Estado</p>
        <p style="margin-bottom:.875rem;font-size:.875rem;color:#6b7280;">
          Estado actual:
          <?php 
            $badge_bg = '';
            switch($estado_actual) {
                case 'pendiente': $badge_bg = '#f59e0b'; break;
                case 'confirmada': $badge_bg = '#22c55e'; break;
                case 'cancelada': $badge_bg = '#ef4444'; break;
                case 'completada': $badge_bg = '#6b7280'; break;
            }
          ?>
          <span class="badge" style="background-color: <?php echo $badge_bg; ?>; color: #fff; padding: 0.25rem 0.5rem; border-radius: 9999px; margin-left: 0.25rem; font-size: 0.75rem; font-weight: 600;">
            <?php echo ucfirst($estado_actual); ?>
          </span>
        </p>
        <form class="status-form" method="post"
              action="<?php echo htmlspecialchars(BASE_URL . 'admin/reservas/detalle.php?id=' . $id, ENT_QUOTES, 'UTF-8'); ?>">
          <select class="form-select" name="estado" id="estado" required>
            <?php foreach (ESTADOS_RESERVA as $opt) : ?>
            <option value="<?php echo $opt; ?>" <?php echo ($opt === $estado_actual) ? 'selected' : ''; ?>>
              <?php echo ucfirst($opt); ?>
            </option>
            <?php endforeach; ?>
          </select>
          <button class="btn btn--primary" type="submit">Actualizar estado</button>
        </form>
      </div>

    </div><!-- /.detail-grid -->

<?php require_once '../includes/footer.php'; ?>
