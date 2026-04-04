<?php
/* Definimos las variables para la página principal de Salitre */
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/config/database.php';

$espacios = [];
try {
    $pdo  = conectarDB();
    $stmt = $pdo->prepare(
        'SELECT id, nombre, slug, tipo, precio_noche, foto_principal
         FROM espacios WHERE activo = 1 ORDER BY precio_noche ASC LIMIT 4'
    );
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (is_array($rows)) { $espacios = $rows; }
} catch (Throwable $e) {
    error_log('Index espacios: ' . $e->getMessage());
}

$page_title        = 'Salitre';
$extra_stylesheets = ['assets/css/client/index.css'];

require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/nav.php';

$base = BASE_URL;
?>

/* Definimos las secciones hero de video, recursos adicionales y otras secciones */
<section id="hero" class="hero">
  <video class="hero__video" autoplay muted loop playsinline>
    <source src="<?= $base ?>assets/video/hero-bg.mp4" type="video/mp4">
    <source src="<?= $base ?>assets/video/hero-bg.webm" type="video/webm">
  </video>
  <div class="hero__overlay" aria-hidden="true"></div>
  <div class="hero__content">
    <div class="index-container">
      <p class="hero__tag">Hotel Boutique · Costa Mexicana</p>
      <h1 class="hero__title">Sal de la oficina.<br>
      <span class="hero__title-accent">No del trabajo.</span></h1>
      <p class="hero__lead">Fibra óptica garantizada. Mobiliario ergonómico. El mar a metros.</p>
      <div class="hero__actions">
        <a class="btn btn-primary" href="<?= htmlspecialchars($base . 'client/espacios/', ENT_QUOTES, 'UTF-8') ?>">
          Ver Espacios
        </a>
        <a class="btn btn-secondary" href="#propuesta">Conocer más</a>
      </div>
    </div>
  </div>
</section>

<section id="propuesta" class="propuesta fade-in">
  <div class="index-container">
    <div class="propuesta__grid">

      <article class="feature">
        <div class="feature__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12.55a11 11 0 0 1 14.08 0"/>
            <path d="M1.42 9a16 16 0 0 1 21.16 0"/>
            <path d="M8.53 16.11a6 6 0 0 1 6.95 0"/>
            <circle cx="12" cy="20" r="1" fill="currentColor"/>
          </svg>
        </div>
        <h3 class="feature__title">Conectividad</h3>
        <p class="feature__text">Fibra óptica garantizada en cada espacio.</p>
      </article>

      <article class="feature">
        <div class="feature__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="3" width="20" height="14" rx="2"/>
            <line x1="8" y1="21" x2="16" y2="21"/>
            <line x1="12" y1="17" x2="12" y2="21"/>
          </svg>
        </div>
        <h3 class="feature__title">Ergonomía</h3>
        <p class="feature__text">Escritorios reales. Sillas corporativas. Monitores externos.</p>
      </article>

      <article class="feature">
        <div class="feature__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="6"  x2="21" y2="6"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
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
<?php if (empty($espacios)) : ?>
      <p>Espacios disponibles próximamente.</p>
<?php else : ?>
<?php foreach ($espacios as $espacio) :
    $detalle_href = htmlspecialchars(
        $base . 'client/espacios/detalle.php?slug=' . rawurlencode((string) $espacio['slug']),
        ENT_QUOTES, 'UTF-8'
    );
?>
      <article class="space-card">
        <div class="space-card__media">
<?php if (!empty($espacio['foto_principal'])) : ?>
          <picture>
            <source srcset="<?= htmlspecialchars($base . $espacio['foto_principal'], ENT_QUOTES, 'UTF-8') ?>"
                    type="image/webp">
            <img src="<?= htmlspecialchars($base . $espacio['foto_principal'], ENT_QUOTES, 'UTF-8') ?>"
                 alt="<?= htmlspecialchars((string) $espacio['nombre'], ENT_QUOTES, 'UTF-8') ?>"
                 loading="lazy">
          </picture>
<?php else : ?>
          <div class="space-card__placeholder" aria-hidden="true"></div>
<?php endif; ?>
        </div>
        <div class="space-card__body">
          <span class="space-card__badge"><?= htmlspecialchars((string) $espacio['tipo'], ENT_QUOTES, 'UTF-8') ?></span>
          <h3 class="space-card__name"><?= htmlspecialchars((string) $espacio['nombre'], ENT_QUOTES, 'UTF-8') ?></h3>
          <p class="space-card__price">$<?= number_format((float) $espacio['precio_noche'], 0) ?>/noche</p>
          <a class="btn btn-primary space-card__button" href="<?= $detalle_href ?>">Ver espacio</a>
        </div>
      </article>
<?php endforeach; ?>
<?php endif; ?>
    </div>
  </div>
</section>

<?php
$services = [
    ['key' => 'coworking', 'nombre' => 'Coworking Abierto',    'descripcion' => 'Área común con vistas al mar.'],
    ['key' => 'cafe',      'nombre' => 'Café Salitre',         'descripcion' => 'Café de especialidad. 7am-8pm.'],
    ['key' => 'surf',      'nombre' => 'Clases de Surf',       'descripcion' => 'Instructor certificado. 7am. Incluidas 3+ noches.'],
    ['key' => 'yoga',      'nombre' => 'Yoga Frente al Mar',   'descripcion' => 'Sesiones grupales en terraza. Lun/Mié/Vie 6:30am.'],
    ['key' => 'transfer',  'nombre' => 'Transfer Aeropuerto',  'descripcion' => 'Traslado programable. Precio según destino.'],
    ['key' => 'late',      'nombre' => 'Late Checkout',        'descripcion' => 'Disponible hasta 3pm según disponibilidad.'],
];

$service_icons = [
    'coworking' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
    'cafe'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>',
    'surf'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12c2-4 6-6 10-3s8 3 10-1"/><path d="M2 18c2-4 6-6 10-3s8 3 10-1"/></svg>',
    'yoga'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="4" r="1.5"/><path d="M7 21l3-7 2 3 2-3 3 7"/><path d="M4 12c2-2 4-3 8-3s6 1 8 3"/></svg>',
    'transfer'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 5v4h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
    'late'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
];
?>
<section id="servicios" class="servicios fade-in">
  <div class="index-container">
    <h2 class="section-title">Más que una habitación</h2>
    <div class="servicios__grid">
<?php foreach ($services as $svc) : ?>
      <article class="service-card">
        <div class="service-card__icon" aria-hidden="true">
          <?= $service_icons[$svc['key']] ?? '' ?>
        </div>
        <h3 class="service-card__title"><?= htmlspecialchars($svc['nombre'], ENT_QUOTES, 'UTF-8') ?></h3>
        <p class="service-card__text"><?= htmlspecialchars($svc['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>

<section class="tagline fade-in" aria-hidden="true">
  <div class="index-container">
    <h2 class="tagline__text">El mar de fondo.<br>Tú en primer plano.</h2>
  </div>
</section>

<section id="contacto" class="contacto fade-in">
  <div class="index-container">
    <div class="contacto__grid">

      <div class="contacto__left">
        <h2 class="section-title">¿Tienes dudas?</h2>

<?php if (isset($_GET['contacto']) && $_GET['contacto'] === 'ok') : ?>
        <p class="contacto__text alert--success" role="status">Tu mensaje fue enviado. Te respondemos pronto.</p>
<?php elseif (isset($_GET['contacto']) && $_GET['contacto'] === 'error') : ?>
        <p class="contacto__text alert--error" role="alert">No pudimos enviar tu mensaje. Inténtalo de nuevo.</p>
<?php endif; ?>

        <!-- Formulario de contacto: procesar_contacto.php en client/includes/ -->
        <form class="contact-form" method="post"
              action="<?= htmlspecialchars($base . 'client/includes/procesar_contacto.php', ENT_QUOTES, 'UTF-8') ?>">
          <div class="field">
            <label class="field__label" for="contacto-nombre">Nombre</label>
            <input class="field__input" type="text" id="contacto-nombre" name="nombre"
                   required maxlength="100" autocomplete="name">
          </div>
          <div class="field">
            <label class="field__label" for="contacto-email">Email</label>
            <input class="field__input" type="email" id="contacto-email" name="email"
                   required maxlength="150" autocomplete="email">
          </div>
          <div class="field">
            <label class="field__label" for="contacto-mensaje">Mensaje</label>
            <textarea class="field__textarea" id="contacto-mensaje" name="mensaje"
                      maxlength="500" required></textarea>
          </div>
          <button class="contact-form__button" type="submit">Enviar</button>
        </form>
      </div>

      <div class="contacto__right">
        <h3 class="contacto__heading">Contacto del hotel</h3>
        <p class="contacto__text">Costa del Pacífico, México</p>
        <p class="contacto__text">+52 (55) 0000 0000</p>
        <p class="contacto__text">hola@salitre.mx</p>
        <p class="contacto__text">Check-in: 3:00pm · Check-out: 12:00pm</p>
      </div>

    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>