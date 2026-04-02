<?php
session_start();
require_once dirname(__DIR__) . "/../config/database.php";
require_once dirname(__DIR__) . "/../config/constants.php";

$slug = filter_var($_GET["slug"] ?? "", FILTER_SANITIZE_SPECIAL_CHARS);
if (empty($slug)) { header("Location: index.php"); exit; }

$pdo = conectarDB();
$stmt = $pdo->prepare("SELECT * FROM espacios WHERE slug = ? AND activo = 1");
$stmt->execute([$slug]);
$espacio = $stmt->fetch();

if (!$espacio) { header("Location: index.php"); exit; }

$page_title = $espacio["nombre"] . " — Hotel Salitre";
$extra_stylesheets = ["assets/css/client/espacios.css"];
$extra_scripts = ["assets/js/client/espacios.js"];

require_once dirname(__DIR__) . "/includes/header.php";
require_once dirname(__DIR__) . "/includes/nav.php";
$base = BASE_URL;

// Parse data
$amenidades = json_decode((string)$espacio['amenidades'], true) ?? [];
$fotos_galeria = !empty($espacio['fotos_galeria']) ? json_decode((string)$espacio['fotos_galeria'], true) : [];
if (!is_array($fotos_galeria)) $fotos_galeria = [];

$foto_primaria = !empty($espacio['foto_principal']) ? $espacio['foto_principal'] : null;

// Preparar lista total de fotos para la galeria
$todas_fotos = [];
if ($foto_primaria) $todas_fotos[] = $foto_primaria;
foreach ($fotos_galeria as $f) {
    if (!empty($f)) $todas_fotos[] = $f;
}
?>

<div class="page-offset"></div>

<section class="detalle section-pad">
    <div class="container container--wide detalle__layout">
        
        <!-- Galería (60%) -->
        <div class="detalle-galeria fade-in" data-delay="0">
            <div class="detalle-galeria__main">
                <!-- 
                  RECURSO: Imagen de <?= htmlspecialchars((string)$espacio["nombre"], ENT_QUOTES, 'UTF-8') ?>
                  FORMATO: WebP con fallback JPG
                  DIMENSIONES: 1200x800px
                  UBICACIÓN: assets/img/client/espacios/<?= htmlspecialchars((string)$espacio["slug"], ENT_QUOTES, 'UTF-8') ?>.webp
                  NOTA: El usuario proporcionará este recurso (Tarea 6)
                  TEMPORAL: Se muestra placeholder mientras no exista
                -->
                <?php if (!empty($todas_fotos)) : ?>
                    <picture>
                        <source srcset="<?= htmlspecialchars($base . $todas_fotos[0], ENT_QUOTES, 'UTF-8') ?>" type="image/webp">
                        <img id="main-gallery-img" src="<?= htmlspecialchars($base . $todas_fotos[0], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars((string)$espacio['nombre'], ENT_QUOTES, 'UTF-8') ?>" data-idx="0">
                    </picture>
                <?php else : ?>
                    <div class="img-placeholder" style="aspect-ratio: 4/3;">
                        <span><?= htmlspecialchars((string)$espacio['nombre'], ENT_QUOTES, 'UTF-8') ?> - Principal</span>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (count($todas_fotos) > 1) : ?>
                <div class="detalle-galeria__thumbs">
                    <?php foreach ($todas_fotos as $idx => $foto) : ?>
                        <div class="detalle-galeria__thumb <?= $idx === 0 ? 'active' : '' ?>">
                            <img src="<?= htmlspecialchars($base . $foto, ENT_QUOTES, 'UTF-8') ?>" alt="Miniatura <?= $idx+1 ?>" data-full="<?= htmlspecialchars($base . $foto, ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Info (40%) -->
        <div class="detalle-info fade-in" data-delay="100">
            <span class="badge badge--accent"><?= htmlspecialchars((string)$espacio['tipo'], ENT_QUOTES, 'UTF-8') ?></span>
            <h1 class="detalle-info__title"><?= htmlspecialchars((string)$espacio['nombre'], ENT_QUOTES, 'UTF-8') ?></h1>
            <p class="detalle-info__desc text-muted"><?= nl2br(htmlspecialchars((string)$espacio['descripcion'], ENT_QUOTES, 'UTF-8')) ?></p>
            
            <div class="detalle-info__meta grid grid-2 gap-4">
                <div class="meta-card">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="meta-icon"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span><strong>Capacidad:</strong> <?= (int)$espacio['capacidad'] ?> pers.</span>
                </div>
                <!-- Aquí se incluirían amenities de alto nivel como WiFi si se guardaran por separado,
                     usaremos el array existente para todos. -->
            </div>

            <div class="divider"></div>
            
            <h3 class="detalle-info__subtitle">Amenidades</h3>
            <?php if (!empty($amenidades)) : ?>
                <ul class="detalle-info__amenities">
                    <?php foreach ($amenidades as $amenidad) : ?>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <?= htmlspecialchars((string)$amenidad, ENT_QUOTES, 'UTF-8') ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="text-muted">No indicadas.</p>
            <?php endif; ?>

        </div>

        <!-- 
          Panel de Reserva — Fuera del wrapper .fade-in para ser siempre visible.
          El botón inicia disabled y se habilita vía JS (espacios.js) al seleccionar fechas.
          Referencia: Documentación Sección 05.2 (Flujo Principal)
        -->
        <div class="detalle-booking-panel">
            <div class="detalle-booking-panel__header flex-between mb-4">
                <div class="detalle-booking-price">
                    <strong>$<?= number_format((float)$espacio['precio_noche'], 0) ?></strong> <small>/noche</small>
                </div>
            </div>

            <form id="booking-form" action="<?= $base ?>client/carrito/agregar.php" method="POST">
                <input type="hidden" name="espacio_id" value="<?= (int)$espacio['id'] ?>">
                
                <div class="booking-dates">
                    <div class="field">
                        <label for="fecha_entrada" class="field__label">Check-in</label>
                        <input type="date" id="fecha_entrada" name="fecha_entrada" class="field__input required" min="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="field">
                        <label for="fecha_salida" class="field__label">Check-out</label>
                        <input type="date" id="fecha_salida" name="fecha_salida" class="field__input required" disabled required>
                    </div>
                </div>
                
                <div id="booking-total-preview" class="booking-preview mt-4" style="display:none;">
                    <div class="flex-between">
                        <span><span id="booking-nights">0</span> noches</span>
                        <strong>$ <span id="booking-subtotal">0</span></strong>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-full mt-6" id="btn-add-cart" disabled>
                    Reservar Fechas
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Variables for JS -->
<script>
    window.ESPACIO_PRECIO = <?= (float)$espacio['precio_noche'] ?>;
</script>

<?php require dirname(__DIR__) . "/includes/footer.php"; ?>
