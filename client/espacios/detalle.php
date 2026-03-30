<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

$slug = isset($_GET['slug']) ? trim((string) $_GET['slug']) : '';
if ($slug === '') {
    header('Location: ' . BASE_URL . 'client/espacios/', true, 302);
    exit;
}

$pdo = conectarDB();
$stmt = $pdo->prepare(
    'SELECT id, nombre, slug, tipo, descripcion, precio_noche, capacidad, amenidades
     FROM espacios WHERE slug = ? AND activo = 1 LIMIT 1'
);
$stmt->execute([$slug]);
$espacio = $stmt->fetch(PDO::FETCH_ASSOC);

if ($espacio === false) {
    header('Location: ' . BASE_URL . 'client/espacios/', true, 302);
    exit;
}

$amenidades_raw = $espacio['amenidades'] ?? '[]';
$amenidades = json_decode(is_string($amenidades_raw) ? $amenidades_raw : json_encode($amenidades_raw), true);
if (!is_array($amenidades)) {
    $amenidades = [];
}

$tipo_labels = [
    'estudio' => 'Estudio',
    'loft' => 'Loft',
    'suite' => 'Suite',
    'villa' => 'Villa',
];
$tipo_key = (string) ($espacio['tipo'] ?? '');
$tipo_txt = $tipo_labels[$tipo_key] ?? $tipo_key;

$precio_fmt = number_format((float) ($espacio['precio_noche'] ?? 0), 2, ',', '.');
$capacidad = (int) ($espacio['capacidad'] ?? 0);

$page_title = (string) ($espacio['nombre'] ?? 'Espacio') . ' · Hotel Salitre';
$extra_stylesheets = ['assets/css/client/espacios.css'];

require dirname(__DIR__) . '/includes/header.php';

$base = BASE_URL;
$reservar_href = $base . 'client/carrito/index.php?espacio_id=' . rawurlencode((string) ($espacio['id'] ?? ''));
?>
  <main id="contenido-principal" class="detail-page">
    <article class="detail-article fade-in">
      <header class="detail-article__header">
        <p class="detail-article__tipo"><?php echo htmlspecialchars($tipo_txt, ENT_QUOTES, 'UTF-8'); ?></p>
        <h1 class="detail-article__title"><?php echo htmlspecialchars((string) ($espacio['nombre'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></h1>
      </header>

      <div class="detail-article__thumb" role="presentation" aria-hidden="true"></div>

      <dl class="detail-meta">
        <div class="detail-meta__row">
          <dt>Precio por noche</dt>
          <dd><?php echo htmlspecialchars($precio_fmt, ENT_QUOTES, 'UTF-8'); ?> <?php echo htmlspecialchars(MONEDA, ENT_QUOTES, 'UTF-8'); ?></dd>
        </div>
        <div class="detail-meta__row">
          <dt>Capacidad</dt>
          <dd><?php echo htmlspecialchars((string) $capacidad, ENT_QUOTES, 'UTF-8'); ?> <?php echo $capacidad === 1 ? 'persona' : 'personas'; ?></dd>
        </div>
      </dl>

      <div class="detail-body">
        <h2 class="detail-body__title">Descripción</h2>
        <p class="detail-body__text"><?php echo nl2br(htmlspecialchars((string) ($espacio['descripcion'] ?? ''), ENT_QUOTES, 'UTF-8')); ?></p>
      </div>

      <section class="detail-amenities" aria-labelledby="amenities-title">
        <h2 id="amenities-title" class="detail-amenities__title">Amenidades</h2>
<?php if (count($amenidades) > 0) : ?>
        <ul class="detail-amenities__list">
<?php foreach ($amenidades as $item) :
    if (!is_string($item) && !is_numeric($item)) {
        continue;
    }
    $item_txt = (string) $item;
    ?>
          <li><?php echo htmlspecialchars($item_txt, ENT_QUOTES, 'UTF-8'); ?></li>
<?php endforeach; ?>
        </ul>
<?php else : ?>
        <p class="detail-amenities__empty">Sin amenidades registradas.</p>
<?php endif; ?>
      </section>

      <p class="detail-actions">
        <a class="btn-reservar" href="<?php echo htmlspecialchars($reservar_href, ENT_QUOTES, 'UTF-8'); ?>">Reservar este espacio</a>
      </p>
    </article>
  </main>
<?php
require dirname(__DIR__) . '/includes/footer.php';
