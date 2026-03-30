<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
// Usamos nuestra arquitectura nueva
require_once dirname(__DIR__) . '/config/constants.php';
require_once CONFIG_PATH . 'database.php';

try {
    $pdo = conectarDB();
    $stmt = $pdo->prepare(
        "SELECT nombre, slug, tipo, precio_noche, foto_principal
         FROM espacios
         WHERE activo = 1
         LIMIT 4"
    );
    $stmt->execute();
    $espacios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $espacios = [];
}

$pageTitle = 'Salitre';
$extraCss = BASE_URL . 'assets/css/client/index.css';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
<main>
  <section id="hero" class="hero">
    <video class="hero__video" autoplay muted loop playsinline aria-hidden="true">
      <source src="<?= BASE_URL ?>assets/video/hero-bg.mp4" type="video/mp4">
    </video>
    <div class="hero__overlay" aria-hidden="true"></div>
    <div class="hero__content">
      <div class="index-container">
        <p class="hero__tag">HOTEL BOUTIQUE · COSTA</p>
        <h1 class="hero__title">Sal de la oficina<br>
        <span class="hero__title-accent">No del trabajo</span>
      </h1>
      <p class="hero__lead">Fibra óptica garantizada. Mobiliario ergonómico. El mar a metros.</p>
      <div class="hero__actions">
        <a class="btn btn-primary" href="<?= BASE_URL ?>client/espacios/" aria-label="Ver espacios disponibles">Ver Espacios</a>
        <a class="btn btn-secondary" href="#propuesta" aria-label="Conocer más sobre el hotel">Conocer más</a>
      </div>
    </div>
  </div>
</section>

<section id="propuesta" class="propuesta fade-in">
  <div class="index-container">
    <div class="propuesta__grid">
      <article class="feature">
        <div class="feature__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 12a8 8 0 0 1 16 0" />
            <path d="M8 12a4 4 0 0 1 8 0" />
            <circle cx="12" cy="16" r="1.5" />
          </svg>
        </div>
        <h3 class="feature__title">Conectividad</h3>
        <p class="feature__text">Fibra óptica garantizada en cada espacio.</p>
      </article>
      <article class="feature">
        <div class="feature__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M7 7h10l-1 6H8L7 7Z" />
            <path d="M9 19h6" />
            <path d="M12 13v6" />
          </svg>
        </div>
        <h3 class="feature__title">Ergonomía</h3>
        <p class="feature__text">Escritorios reales. Sillas corporativas. Monitores externos.</p>
      </article>
      <article class="feature">
        <div class="feature__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 20h16" />
            <path d="M7 17l10-10" />
            <path d="M9 7h8v8" />
          </svg>
        </div>
        <h3 class="feature__title">Diseño</h3>
        <p class="feature__text">Minimalismo funcional. Sin distracciones.</p>
      </article>
    </div>
  </div>
</section>

<section id="espacios" class="espacios fade-in">
  <div class="index-container">
    <h2 class="section-title">Elige tu espacio</h2>
    <div class="espacios__grid">
      <?php foreach ($espacios as $espacio): ?>
      <?php
      $nombre = (string) ($espacio['nombre'] ?? '');
      $slug = (string) ($espacio['slug'] ?? '');
      $tipo = (string) ($espacio['tipo'] ?? '');
      $precio = (float) ($espacio['precio_noche'] ?? 0);
      $fotoPrincipal = $espacio['foto_principal'] ?? null;
      
      $fotoWebp = null;
      $fotoJpg = null;
      
      if (!empty($fotoPrincipal)) {
        $fotoWebp = (string) $fotoPrincipal;
        if (preg_match('/\.webp$/i', $fotoWebp)) {
          $fotoJpg = preg_replace('/\.webp$/i', '.jpg', $fotoWebp);
        } elseif (preg_match('/\.jpe?g$/i', $fotoWebp)) {
          $fotoJpg = $fotoWebp;
          $fotoWebp = preg_replace('/\.jpe?g$/i', '.webp', $fotoWebp);
        } else {
          $fotoJpg = $fotoWebp;
        }
      }
      $precioFormateado = number_format($precio, 0, ',', '.');
      $detalleUrl = BASE_URL . 'client/espacios/detalle.php?slug=' . rawurlencode($slug);
      ?>
      <article class="space-card">
        <div class="space-card__media">
          <?php if (!empty($fotoWebp) && !empty($fotoJpg)): ?>
            <picture>
              <source srcset="<?= BASE_URL . htmlspecialchars($fotoWebp, ENT_QUOTES, 'UTF-8') ?>" type="image/webp">
              <img src="<?= BASE_URL . htmlspecialchars($fotoJpg, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
            </picture>
          <?php else: ?>
            <div class="space-card__placeholder" aria-hidden="true"></div>
          <?php endif; ?>
        </div>

        <div class="space-card__body">
          <span class="space-card__badge"><?= htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8') ?></span>
          <h3 class="space-card__name"><?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?></h3>
          <p class="space-card__price">$<?= htmlspecialchars($precioFormateado, ENT_QUOTES, 'UTF-8') ?>/noche</p>
          <a class="btn btn-primary space-card__button" href="<?= htmlspecialchars($detalleUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Ver espacio: <?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>">Ver espacio</a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="servicios" class="servicios fade-in">
  <div class="index-container">
    <h2 class="section-title">Más que una habitación</h2>

    <?php
      $services = [
        [
          'key' => 'coworking',
          'nombre' => 'Coworking Abierto',
          'descripcion' => 'Área común de trabajo con vistas al mar.',
        ],
        [
          'key' => 'cafe',
          'nombre' => 'Café Salitre',
          'descripcion' => 'Café de especialidad para videollamadas matutinas.',
        ],
        [
          'key' => 'surf',
          'nombre' => 'Clases de Surf',
          'descripcion' => 'Sesiones con instructor incluidas en estancias 3+ noches.',
        ],
        [
          'key' => 'yoga',
          'nombre' => 'Yoga Frente al Mar',
          'descripcion' => 'Sesiones grupales en terraza con enfoque en movilidad.',
        ],
        [
          'key' => 'transfer',
          'nombre' => 'Transfer Aeropuerto',
          'descripcion' => 'Traslado programable desde la app, según destino.',
        ],
        [
          'key' => 'late',
          'nombre' => 'Late Checkout',
          'descripcion' => 'Disponible hasta las 3:00pm con confirmación según ocupación.',
        ],
      ];
    ?>

    <div class="servicios__grid">
      <?php foreach ($services as $service): ?>
        <?php $key = (string) ($service['key'] ?? ''); ?>
        <article class="service-card">
          <div class="service-card__icon" aria-hidden="true">
            <?php if ($key === 'coworking'): ?>
              <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4.5" width="18" height="15" rx="2" />
                <path d="M8 9h8" />
                <path d="M8 13h5" />
              </svg>
            <?php elseif ($key === 'cafe'): ?>
              <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 8h13v6a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V8Z" />
                <path d="M16 10h2a3 3 0 0 1 0 6h-2" />
                <path d="M6 3c1 1 1 2 0 3" />
              </svg>
            <?php elseif ($key === 'surf'): ?>
              <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 18c3-6 7-9 16-10-3 9-6 14-16 10Z" />
                <path d="M14 8l4 6" />
              </svg>
            <?php elseif ($key === 'yoga'): ?>
              <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="5.5" r="1.5" />
                <path d="M8 22c1-4 2-7 4-7s3 3 4 7" />
                <path d="M7 12c2 1 3 1 5 0s3-1 5 0" />
              </svg>
            <?php elseif ($key === 'transfer'): ?>
              <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 7h13l-1 10H5L3 7Z" />
                <path d="M16 9h2l3 3v5h-5" />
                <circle cx="7" cy="20" r="1.5" />
                <circle cx="18" cy="20" r="1.5" />
              </svg>
            <?php else: ?>
              <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 8v4l3 2" />
                <circle cx="12" cy="12" r="9" />
              </svg>
            <?php endif; ?>
          </div>

          <h3 class="service-card__title"><?= htmlspecialchars((string) ($service['nombre'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h3>
          <p class="service-card__text"><?= htmlspecialchars((string) ($service['descripcion'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="tagline fade-in">
  <div class="index-container">
    <h2 class="tagline__text">
      El mar de fondo.
      <br>
      Tú en primer plano.
    </h2>
  </div>
</section>

<section id="contacto" class="contacto fade-in">
  <div class="index-container">
    <div class="contacto__grid">
      <div class="contacto__left">
        <h2 class="section-title">¿Tienes dudas?</h2>

        <form class="contact-form" action="<?= BASE_URL ?>client/includes/procesar_contacto.php" method="post">
          <label class="field">
            <span class="field__label">Nombre</span>
            <input class="field__input" type="text" name="nombre" required autocomplete="name">
          </label>

          <label class="field">
            <span class="field__label">Email</span>
            <input class="field__input" type="email" name="email" required autocomplete="email">
          </label>

          <label class="field">
            <span class="field__label">Mensaje</span>
            <textarea class="field__textarea" name="mensaje" rows="5" required></textarea>
          </label>

          <button class="btn btn-primary contact-form__button" type="submit">Enviar</button>
        </form>
      </div>

      <aside class="contacto__right" aria-label="Información del hotel">
        <div class="contacto__info">
          <h3 class="contacto__heading">Contacto del hotel</h3>
          <p class="contacto__text">Costa del Pacífico, México</p>
          <p class="contacto__text">Teléfono: +52 (55) 0000 0000</p>
          <p class="contacto__text">Email: hola@salitre.mx</p>
          <p class="contacto__text">Check-in: 3:00pm · Check-out: 12:00pm</p>
        </div>
      </aside>
    </div>
  </div>
</section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
