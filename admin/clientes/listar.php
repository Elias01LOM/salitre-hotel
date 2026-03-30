<?php
declare(strict_types=1);
require_once '../includes/auth_check.php';

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

// ---------- Consulta ----------
$clientes = [];
try {
    $pdo  = conectarDB();
    $stmt = $pdo->query(
        'SELECT id, nombre, email, telefono, creado_en FROM clientes ORDER BY creado_en DESC'
    );
    $clientes = $stmt->fetchAll();
} catch (Throwable $e) {
    error_log('Admin clientes/listar: ' . $e->getMessage());
}

// ---------- Layout ----------
$page_title = 'Clientes · Panel Salitre';
$extra_css  = ['assets/css/admin/crud.css'];
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>
<main class="main-content">
  <div class="topbar">
    <h1 class="topbar__title">Clientes</h1>
    <span class="topbar__meta"><?php echo count($clientes); ?> cliente(s) registrado(s)</span>
  </div>

  <div class="content-area">

    <div class="page-header">
      <p class="page-header__title">Listado de Clientes</p>
      <span style="font-size:.8125rem;color:#6b7280;">Solo lectura · Los clientes se autogestionan desde el portal público.</span>
    </div>

    <div class="data-table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Registrado el</th>
          </tr>
        </thead>
        <tbody>
<?php if (empty($clientes)) : ?>
          <tr>
            <td colspan="5" class="table-empty">No hay clientes registrados aún.</td>
          </tr>
<?php else : ?>
<?php foreach ($clientes as $c) : ?>
          <tr>
            <td><?php echo (int) $c['id']; ?></td>
            <td><?php echo htmlspecialchars((string) $c['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars((string) $c['email'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo $c['telefono'] !== null ? htmlspecialchars((string) $c['telefono'], ENT_QUOTES, 'UTF-8') : '<span style="color:#9ca3af;">—</span>'; ?></td>
            <td><?php
                $fecha = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', (string) $c['creado_en']);
                echo $fecha ? htmlspecialchars($fecha->format('d/m/Y H:i'), ENT_QUOTES, 'UTF-8') : htmlspecialchars((string) $c['creado_en'], ENT_QUOTES, 'UTF-8');
            ?></td>
          </tr>
<?php endforeach; ?>
<?php endif; ?>
        </tbody>
      </table>
    </div><!-- /.data-table-wrap -->

<?php require_once '../includes/footer.php'; ?>
