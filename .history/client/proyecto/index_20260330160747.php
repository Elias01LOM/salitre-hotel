<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/config/constants.php';

$page_title = 'Experiencia · Hotel Salitre';
$extra_stylesheets = ['assets/css/client/proyecto.css'];

require dirname(__DIR__) . '/includes/header.php';
?>
  <main id="contenido-principal" class="proyecto-page">
    <section class="proyecto-hero" aria-labelledby="proyecto-hero-title">
      <div class="proyecto-hero__inner fade-in">
        <h1 id="proyecto-hero-title" class="proyecto-hero__title">Diseñado para nómadas digitales</h1>
        <p class="proyecto-hero__subtitle">Salitre es un refugio donde el trabajo remoto encuentra ritmo de costa, luz medida y espacios que respetan tu concentración.</p>
      </div>
    </section>

    <section class="proyecto-split fade-in" aria-labelledby="proyecto-filosofia">
      <div class="proyecto-split__col proyecto-split__col--text">
        <h2 id="proyecto-filosofia" class="proyecto-split__heading">Filosofía</h2>
        <p class="proyecto-split__p">Creemos que “salir de la oficina” no significa dejar de crear. Significa elegir un entorno que alimente ideas sin el ruido de la ciudad.</p>
        <p class="proyecto-split__p">Cada espacio desde estudios íntimos hasta suites para equipos— está pensado para videollamadas estables, descanso real y encuentros que importan.</p>
      </div>
      <div class="proyecto-split__col proyecto-split__col--media">
        <!-- Imagen futura: reemplazar por <img> con foto de ambientes / terraza -->
        <div class="proyecto-split__placeholder" role="presentation" aria-hidden="true"></div>
      </div>
    </section>

    <section class="proyecto-split proyecto-split--reverse fade-in" aria-labelledby="proyecto-comunidad">
      <div class="proyecto-split__col proyecto-split__col--media">
        <!-- Imagen futura: galería o detalle de cowork frente al mar -->
        <div class="proyecto-split__placeholder proyecto-split__placeholder--alt" role="presentation" aria-hidden="true"></div>
      </div>
      <div class="proyecto-split__col proyecto-split__col--text">
        <h2 id="proyecto-comunidad" class="proyecto-split__heading">Comunidad</h2>
        <p class="proyecto-split__p">Aquí conviven freelancers, startups y equipos distribuidos. La agenda de eventos y los espacios comunes invitan a conectar sin perder foco.</p>
        <p class="proyecto-split__p">Salitre no es solo hospedaje: es una base para quien trabaja desde cualquier lugar y elige el mar como vecino.</p>
      </div>
    </section>
  </main>
<?php
require dirname(__DIR__) . '/includes/footer.php';
