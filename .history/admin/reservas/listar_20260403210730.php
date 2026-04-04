<?php
/* Permite visualizar el listado de reservas en el panel de administración con toda la información disponible */
declare(strict_types=1);
require_once '../includes/auth_check.php';

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
// 
$reservas = [];
try {
    $pdo  = conectarDB();
    $stmt = $pdo->prepare(
        'SELECT
           r.id,
           c.nombre  AS cliente,
           e.nombre  AS espacio,
           r.fecha_entrada,
           r.fecha_salida,
           r.noches,
           r.precio_total,
           r.estado
         FROM reservas r
         JOIN clientes  c ON r.cliente_id  = c.id
         JOIN espacios  e ON r.espacio_id  = e.id
         ORDER BY r.creado_en DESC'
    );
    $stmt->execute();
    $reservas = $stmt->fetchAll();
} catch (Throwable $e) {
    error_log('Admin reservas/listar: ' . $e->getMessage());
}

$estados_validos = ['pendiente', 'confirmada', 'cancelada', 'completada'];

// ---------- Layout ----------
$page_title = 'Reservas · Panel Salitre';
$extra_css  = ['assets/css/admin/crud.css'];
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>
<main class="main-content">
  <div class="topbar">
    <h1 class="topbar__title">Reservas</h1>
    <span class="topbar__meta"><?php echo count($reservas); ?> reserva(s) en total</span>
  </div>

  <div class="content-area">

    <div class="page-header">
      <p class="page-header__title">Listado de Reservas</p>
    </div>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'updated') : ?>
        <div class="alert alert--success mb-4" style="background:var(--color-bg); padding:1rem; border-left:4px solid var(--color-success);">
            <p>Estado de la reserva actualizado exitosamente.</p>
        </div>
    <?php endif; ?>

    <div class="data-table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Espacio</th>
            <th>Entrada</th>
            <th>Salida</th>
            <th>Noches</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
<?php if (empty($reservas)) : ?>
          <tr>
            <td colspan="9" class="table-empty">No hay reservas registradas aún.</td>
          </tr>
<?php else : ?>
<?php foreach ($reservas as $r) :
    $id      = (int) $r['id'];
    $estado  = in_array($r['estado'], $estados_validos, true) ? $r['estado'] : 'pendiente';
    $detalle = htmlspecialchars(BASE_URL . 'admin/reservas/detalle.php?id=' . $id, ENT_QUOTES, 'UTF-8');
?>
          <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo htmlspecialchars((string) $r['cliente'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) $r['espacio'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) $r['fecha_entrada'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) $r['fecha_salida'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo (int) $r['noches']; ?></td>
            <td>$<?php echo number_format((float) $r['precio_total'], 2); ?></td>
            <td>
              <?php 
                $badge_bg = '';
                $badge_color = '#fff';
                switch($estado) {
                    case 'pendiente': $badge_bg = '#f59e0b'; break;
                    case 'confirmada': $badge_bg = '#22c55e'; break;
                    case 'cancelada': $badge_bg = '#ef4444'; break;
                    case 'completada': $badge_bg = '#6b7280'; break;
                }
              ?>
              <span class="badge" style="background-color: <?php echo $badge_bg; ?>; color: <?php echo $badge_color; ?>; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                <?php echo ucfirst($estado); ?>
              </span>
            </td>
            <td>
              <div class="actions-cell">
                <a class="btn btn--edit" href="<?php echo $detalle; ?>">Ver detalle</a>
              </div>
            </td>
          </tr>
<?php endforeach; ?>
<?php endif; ?>
        </tbody>
      </table>
    </div><!-- /.data-table-wrap -->

<?php require_once '../includes/footer.php'; ?>
