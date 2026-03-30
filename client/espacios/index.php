<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

$espacios = [];

try {
    $pdo = conectarDB();
    $stmt = $pdo->prepare(
        'SELECT id, nombre, slug, tipo, descripcion, precio_noche FROM espacios WHERE activo = 1 ORDER BY nombre ASC'
    );
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (is_array($rows)) {
        $espacios = $rows;
    }
} catch (Throwable $e) {
    error_log('Catálogo espacios: ' . $e->getMessage());
    $espacios = [];
}

$tipo_labels = [
    'estudio' => 'Estudio',
    'loft' => 'Loft',
    'suite' => 'Suite',
    'villa' => 'Villa',
];

$page_title = 'Catálogo de Espacios · Hotel Salitre';
$extra_stylesheets = ['assets/css/client/espacios.css'];

require dirname(__DIR__) . '/includes/header.php';

$base = BASE_URL;
?>
  <main id="contenido-principal" class="catalog-page">
    <header class="catalog-page__header fade-in">
      <h1 class="catalog-page__title">Catálogo de Espacios</h1>
      <p class="catalog-page__intro">Todos los espacios activos para trabajo y estancia.</p>
    </header>

    <div class="catalog-grid">
<?php foreach ($espacios as $espacio) :
    $tipo_key = (string) ($espacio['tipo'] ?? '');
    $tipo_txt = $tipo_labels[$tipo_key] ?? $tipo_key;
    $detalle_href = $base . 'client/espacios/detalle.php?slug=' . rawurlencode((string) ($espacio['slug'] ?? ''));
    $precio_fmt = number_format((float) ($espacio['precio_noche'] ?? 0), 2, ',', '.');
    ?>
      <article class="space-card space-card--catalog fade-in">
        <div class="space-card__thumb" role="presentation"></div>
        <div class="space-card__body">
          <p class="space-card__tipo"><?php echo htmlspecialchars($tipo_txt, ENT_QUOTES, 'UTF-8'); ?></p>
          <h2 class="space-card__name"><?php echo htmlspecialchars((string) ($espacio['nombre'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></h2>
          <p class="space-card__desc"><?php echo htmlspecialchars((string) ($espacio['descripcion'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
          <p class="space-card__price">
            <span class="space-card__price-label">Desde</span>
            <span class="space-card__price-value"><?php echo htmlspecialchars($precio_fmt, ENT_QUOTES, 'UTF-8'); ?></span>
            <span class="space-card__price-currency"><?php echo htmlspecialchars(MONEDA, ENT_QUOTES, 'UTF-8'); ?> / noche</span>
          </p>
          <a class="space-card__link" href="<?php echo htmlspecialchars($detalle_href, ENT_QUOTES, 'UTF-8'); ?>">Ver detalles</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>

<?php if (count($espacios) === 0) : ?>
    <p class="catalog-page__empty" role="status">No hay espacios en el catálogo por el momento.</p>
<?php endif; ?>
  </main>
<?php
require dirname(__DIR__) . '/includes/footer.php';
