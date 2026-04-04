<?php
/* 'admin/espacios/listar.php' es la página para listar todos los espacios registrados desde el panel de administración */
declare(strict_types=1);
require_once '../includes/auth_check.php';

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
// Obtenemos el listado de espacios desde la base de datos
$espacios = [];
try {
    $pdo   = conectarDB();
    $stmt  = $pdo->prepare(
        'SELECT id, nombre, slug, tipo, precio_noche, capacidad, activo FROM espacios ORDER BY id ASC'
    );
    $stmt->execute();
    $espacios = $stmt->fetchAll();
} catch (Throwable $e) {
    error_log('Admin espacios/listar: ' . $e->getMessage());
}
// Mapeo para mensajes flash (usando query param 'msg')
$msg = $_GET['msg'] ?? '';
$flash_map = [
    'creado'      => ['type' => 'success', 'text' => 'Espacio creado correctamente.'],
    'editado'     => ['type' => 'success', 'text' => 'Espacio actualizado correctamente.'],
    'desactivado' => ['type' => 'info',    'text' => 'Espacio desactivado (soft delete).'],
];
$flash = isset($flash_map[$msg]) ? $flash_map[$msg] : null;
// Definimos el titulo de la página y los estilos adicionales, luego incluimos el header y sidebar comunes
$page_title = 'Espacios - Panel Salitre';
$extra_css  = ['assets/css/admin/crud.css'];
require_once '../includes/header.php';
require_once '../includes/sidebar.php';

$tipo_labels = ['estudio' => 'Estudio', 'loft' => 'Loft', 'suite' => 'Suite', 'villa' => 'Villa'];
?>
<main class="main-content">
  <div class="topbar">
    <h1 class="topbar__title">Gestión de Espacios</h1>
    <span class="topbar__meta"><?php echo count($espacios); ?> espacio(s) registrado(s)</span>
  </div>

  <div class="content-area">

    <?php if ($flash) : ?>
    <div class="flash flash--<?php echo htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8'); ?>" role="status">
      <?php echo htmlspecialchars($flash['text'], ENT_QUOTES, 'UTF-8'); ?>
    </div>
    <?php endif; ?>

    <div class="page-header">
      <p class="page-header__title">Listado de Espacios</p>
      <a class="btn btn--primary" href="<?php echo htmlspecialchars(BASE_URL . 'admin/espacios/crear.php', ENT_QUOTES, 'UTF-8'); ?>"> + Nuevo Espacio
      </a>
    </div>

    <div class="data-table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Precio / noche</th>
            <th>Capacidad</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($espacios)) : ?>
          <tr>
            <td colspan="7" class="table-empty">No hay espacios registrados. <a href="<?php echo htmlspecialchars(BASE_URL . 'admin/espacios/crear.php', ENT_QUOTES, 'UTF-8'); ?>">Crear el primero</a>.</td>
          </tr>
          <?php else : ?>
          <?php foreach ($espacios as $e) :
              $id     = (int) $e['id'];
              $nombre = htmlspecialchars((string) $e['nombre'], ENT_QUOTES, 'UTF-8');
              $tipo   = htmlspecialchars($tipo_labels[$e['tipo']] ?? $e['tipo'], ENT_QUOTES, 'UTF-8');
              $precio = number_format((float) $e['precio_noche'], 2);
              $cap    = (int) $e['capacidad'];
              $activo = (bool) $e['activo'];
              $edit_href = htmlspecialchars(BASE_URL . 'admin/espacios/editar.php?id=' . $id, ENT_QUOTES, 'UTF-8');
              $del_action = htmlspecialchars(BASE_URL . 'admin/espacios/eliminar.php', ENT_QUOTES, 'UTF-8');
          ?>
          <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $nombre; ?></td>
            <td><?php echo $tipo; ?></td>
            <td>$<?php echo $precio; ?></td>
            <td><?php echo $cap; ?></td>
            <td>
              <?php if ($activo) : ?>
                <span class="badge badge--active">&#10003; Activo</span>
              <?php else : ?>
                <span class="badge badge--inactive">Inactivo</span>
              <?php endif; ?>
            </td>
            <td>
              <div class="actions-cell">
                <a class="btn btn--edit" href="<?php echo $edit_href; ?>">Editar</a>
                <?php if ($activo) : ?>
                <form method="post" action="<?php echo $del_action; ?>"
                      onsubmit="return confirm('¿Desactivar este espacio?');">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <button class="btn btn--danger" type="submit">Desactivar</button>
                </form>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div><!-- /.data-table-wrap -->

<?php require_once '../includes/footer.php'; ?>
