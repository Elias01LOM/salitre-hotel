<?php
/* 'admin/espacios/editar.php' es la página para editar un espacio existente desde el panel de administración */
declare(strict_types=1);
require_once '../includes/auth_check.php';

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
// Validamos los parámetros de entrada 'GET' (id del espacio a editar)
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    header('Location: ' . BASE_URL . 'admin/espacios/listar.php');
    exit();
}

$pdo     = conectarDB();
$espacio = null;

try {
    $stmt = $pdo->prepare(
        'SELECT id, nombre, slug, tipo, descripcion, precio_noche, capacidad, activo FROM espacios WHERE id = :id LIMIT 1'
    );
    $stmt->execute([':id' => $id]);
    $espacio = $stmt->fetch();
} catch (Throwable $e) {
    error_log('Admin espacios/editar fetch: ' . $e->getMessage());
}

if (!$espacio) {
    header('Location: ' . BASE_URL . 'admin/espacios/listar.php');
    exit();
}

$errors = [];
$values = [
    'nombre'       => (string) $espacio['nombre'],
    'slug'         => (string) $espacio['slug'],
    'tipo'         => (string) $espacio['tipo'],
    'descripcion'  => (string) $espacio['descripcion'],
    'precio_noche' => (string) $espacio['precio_noche'],
    'capacidad'    => (string) $espacio['capacidad'],
    'activo'       => (string) $espacio['activo'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $values['nombre']       = trim((string) ($_POST['nombre']       ?? ''));
    $values['slug']         = trim((string) ($_POST['slug']         ?? ''));
    $values['tipo']         = trim((string) ($_POST['tipo']         ?? ''));
    $values['descripcion']  = trim((string) ($_POST['descripcion']  ?? ''));
    $values['precio_noche'] = trim((string) ($_POST['precio_noche'] ?? ''));
    $values['capacidad']    = trim((string) ($_POST['capacidad']    ?? ''));
    $values['activo']       = isset($_POST['activo']) ? '1' : '0';

    // Validaciones
    if ($values['nombre'] === '') {
        $errors[] = 'El nombre es obligatorio.';
    }
    if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $values['slug'])) {
        $errors[] = 'El slug debe ser url-amigable (solo letras minúsculas, números y guiones).';
    }
    if (!in_array($values['tipo'], ['estudio', 'loft', 'suite', 'villa'], true)) {
        $errors[] = 'Tipo de espacio no válido.';
    }
    $precio = filter_var($values['precio_noche'], FILTER_VALIDATE_FLOAT);
    if ($precio === false || $precio <= 0) {
        $errors[] = 'El precio debe ser un número positivo.';
    }
    $capacidad = filter_var($values['capacidad'], FILTER_VALIDATE_INT);
    if ($capacidad === false || $capacidad < 1) {
        $errors[] = 'La capacidad debe ser al menos 1.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare(
                'UPDATE espacios
                 SET nombre = :nombre, slug = :slug, tipo = :tipo, descripcion = :descripcion,
                     precio_noche = :precio_noche, capacidad = :capacidad, activo = :activo
                 WHERE id = :id'
            );
            $stmt->execute([
                ':nombre'       => $values['nombre'],
                ':slug'         => $values['slug'],
                ':tipo'         => $values['tipo'],
                ':descripcion'  => $values['descripcion'],
                ':precio_noche' => $precio,
                ':capacidad'    => $capacidad,
                ':activo'       => (int) $values['activo'],
                ':id'           => $id,
            ]);
            header('Location: ' . BASE_URL . 'admin/espacios/listar.php?msg=editado');
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $errors[] = 'El slug "' . htmlspecialchars($values['slug'], ENT_QUOTES, 'UTF-8') . '" ya existe. Usa uno diferente.';
            } else {
                error_log('Admin espacios/editar update: ' . $e->getMessage());
                $errors[] = 'Error al guardar. Inténtalo de nuevo.';
            }
        }
    }
}

// ---------- Layout ----------
$page_title = 'Editar Espacio · Panel Salitre';
$extra_css  = ['assets/css/admin/crud.css'];
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>
<main class="main-content">
  <div class="topbar">
    <h1 class="topbar__title">Editar Espacio #<?php echo $id; ?></h1>
    <span class="topbar__meta">
      <a href="<?php echo htmlspecialchars(BASE_URL . 'admin/espacios/listar.php', ENT_QUOTES, 'UTF-8'); ?>"
         style="color:#6b7280;font-size:.875rem;">← Volver al listado</a>
    </span>
  </div>

  <div class="content-area">

    <?php if (!empty($errors)) : ?>
    <div class="flash flash--error" role="alert">
      <strong>Corrige los siguientes errores:</strong>
      <ul style="margin-top:.4rem;padding-left:1.25rem;">
        <?php foreach ($errors as $err) : ?>
        <li><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

    <div class="form-card">
      <form method="post" action="<?php echo htmlspecialchars(BASE_URL . 'admin/espacios/editar.php?id=' . $id, ENT_QUOTES, 'UTF-8'); ?>" novalidate>

        <div class="form-grid">

          <div class="form-group">
            <label class="form-label" for="nombre">Nombre <span>*</span></label>
            <input class="form-input" type="text" id="nombre" name="nombre" required maxlength="100"
                   value="<?php echo htmlspecialchars($values['nombre'], ENT_QUOTES, 'UTF-8'); ?>">
          </div>

          <div class="form-group">
            <label class="form-label" for="slug">Slug <span>*</span></label>
            <input class="form-input" type="text" id="slug" name="slug" required maxlength="100"
                   pattern="[a-z0-9\-]+"
                   value="<?php echo htmlspecialchars($values['slug'], ENT_QUOTES, 'UTF-8'); ?>">
            <span class="form-hint">Formato: estudio-playa (minúsculas, guiones)</span>
          </div>

          <div class="form-group">
            <label class="form-label" for="tipo">Tipo <span>*</span></label>
            <select class="form-select" id="tipo" name="tipo" required>
              <?php foreach (['estudio' => 'Estudio', 'loft' => 'Loft', 'suite' => 'Suite', 'villa' => 'Villa'] as $val => $lbl) : ?>
              <option value="<?php echo $val; ?>" <?php echo ($values['tipo'] === $val) ? 'selected' : ''; ?>>
                <?php echo $lbl; ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="capacidad">Capacidad <span>*</span></label>
            <input class="form-input" type="number" id="capacidad" name="capacidad"
                   min="1" max="20" required
                   value="<?php echo htmlspecialchars($values['capacidad'], ENT_QUOTES, 'UTF-8'); ?>">
          </div>

          <div class="form-group">
            <label class="form-label" for="precio_noche">Precio / noche (USD) <span>*</span></label>
            <input class="form-input" type="number" id="precio_noche" name="precio_noche"
                   min="0" step="0.01" required
                   value="<?php echo htmlspecialchars($values['precio_noche'], ENT_QUOTES, 'UTF-8'); ?>">
          </div>

          <div class="form-group" style="align-self:end;">
            <label class="form-check">
              <input type="checkbox" name="activo" value="1"
                     <?php echo ($values['activo'] === '1') ? 'checked' : ''; ?>>
              Espacio activo (visible para clientes)
            </label>
          </div>

          <div class="form-group form-group--full">
            <label class="form-label" for="descripcion">Descripción</label>
            <textarea class="form-textarea" id="descripcion" name="descripcion" maxlength="2000"><?php echo htmlspecialchars($values['descripcion'], ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>

        </div><!-- /.form-grid -->

        <div class="form-actions">
          <button class="btn btn--primary" type="submit">Guardar cambios</button>
          <a class="btn btn--ghost"
             href="<?php echo htmlspecialchars(BASE_URL . 'admin/espacios/listar.php', ENT_QUOTES, 'UTF-8'); ?>">
            Cancelar
          </a>
        </div>

      </form>
    </div><!-- /.form-card -->

<?php require_once '../includes/footer.php'; ?>
