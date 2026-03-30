<?php
declare(strict_types=1);

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
        <p class="section-spaces__lead fade-in">Dos propuestas para inspirarte; pronto podrás explorar todo el catálogo.</p>
        <div class="spaces-grid">
          <article class="space-card fade-in">
            <div class="space-card__thumb" role="presentation"></div>
            <div class="space-card__body">
              <h3 class="space-card__name">Estudio Marea</h3>
              <p class="space-card__desc">Luz natural, mesas amplias y silencio concentrado para sesiones profundas.</p>
              <a class="space-card__link" href="<?php echo htmlspecialchars($espacios_url, ENT_QUOTES, 'UTF-8'); ?>">Ver detalle</a>
            </div>
          </article>
          <article class="space-card fade-in">
            <div class="space-card__thumb" role="presentation"></div>
            <div class="space-card__body">
              <h3 class="space-card__name">Suite Salitre</h3>
              <p class="space-card__desc">Privacidad boutique para equipos reducidos y encuentros que merecen foco total.</p>
              <a class="space-card__link" href="<?php echo htmlspecialchars($espacios_url, ENT_QUOTES, 'UTF-8'); ?>">Ver detalle</a>
            </div>
          </article>
        </div>
      </div>
    </section>
  </main>
<?php
require __DIR__ . '/includes/footer.php';
