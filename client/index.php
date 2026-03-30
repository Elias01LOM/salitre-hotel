<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/config/database.php';

$espacios_landing = [];

try {
    $pdo = conectarDB();
    $stmt_espacios = $pdo->prepare(
        'SELECT nombre, slug, descripcion, tipo FROM espacios WHERE activo = 1 LIMIT 2'
    );
    $stmt_espacios->execute();
    $rows = $stmt_espacios->fetchAll(PDO::FETCH_ASSOC);
    if (is_array($rows)) {
        $espacios_landing = $rows;
    }
} catch (Throwable $e) {
    error_log('Landing espacios: ' . $e->getMessage());
    $espacios_landing = [];
}

$tipo_labels = [
    'estudio' => 'Estudio',
    'loft' => 'Loft',
    'suite' => 'Suite',
    'villa' => 'Villa',
];

$page_title = 'Hotel Salitre · Inicio';
$extra_stylesheets = ['assets/css/client/index.css'];

require __DIR__ . '/includes/header.php';

$base = BASE_URL;
$espacios_url = $base . 'client/espacios/';
?>
  <main id="contenido-principal">
    <section class="hero" aria-labelledby="hero-title">
      <!-- Imagen de fondo futura: asignar background-image a .hero__bg (o imagen dentro de este bloque) -->
      <div class="hero__bg hero__bg-slot" aria-hidden="true"></div>
      <div class="hero__overlay" aria-hidden="true"></div>
      <div class="hero__inner">
        <div class="hero__content">
          <h1 id="hero-title" class="hero__title fade-in">Sal de la oficina. No del trabajo.</h1>
          <p class="hero__subtitle fade-in">Espacios serenos para equipos que piensan en grande — sin renunciar al confort.</p>
          <a class="hero__cta fade-in" href="<?php echo htmlspecialchars($espacios_url, ENT_QUOTES, 'UTF-8'); ?>">Ver Espacios</a>
        </div>
      </div>
    </section>

    <section class="section-spaces" aria-labelledby="spaces-title">
      <div class="section-spaces__inner">
        <h2 id="spaces-title" class="section-spaces__title fade-in">Nuestros Espacios</h2>
        <p class="section-spaces__lead fade-in">Una muestra de nuestro catálogo; explora todos los espacios disponibles.</p>
        <div class="spaces-grid">
<?php foreach ($espacios_landing as $espacio) :
    $tipo_key = (string) ($espacio['tipo'] ?? '');
    $tipo_txt = $tipo_labels[$tipo_key] ?? $tipo_key;
    $detalle_href = $base . 'client/espacios/detalle.php?slug=' . rawurlencode((string) ($espacio['slug'] ?? ''));
    ?>
          <article class="space-card fade-in">
            <div class="space-card__thumb" role="presentation"></div>
            <div class="space-card__body">
              <p class="space-card__tipo"><?php echo htmlspecialchars($tipo_txt, ENT_QUOTES, 'UTF-8'); ?></p>
              <h3 class="space-card__name"><?php echo htmlspecialchars((string) ($espacio['nombre'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></h3>
              <p class="space-card__desc"><?php echo htmlspecialchars((string) ($espacio['descripcion'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
              <a class="space-card__link" href="<?php echo htmlspecialchars($detalle_href, ENT_QUOTES, 'UTF-8'); ?>">Ver detalles</a>
            </div>
          </article>
<?php endforeach; ?>
<?php if (count($espacios_landing) === 0) : ?>
          <p class="section-spaces__empty" role="status">No hay espacios disponibles por el momento. Vuelve pronto.</p>
<?php endif; ?>
        </div>
      </div>
    </section>
  </main>
<?php
require __DIR__ . '/includes/footer.php';
