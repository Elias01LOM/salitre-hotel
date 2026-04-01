<?php
session_start();
require_once dirname(__DIR__) . "/../config/database.php";
require_once dirname(__DIR__) . "/../config/constants.php";

// 1. Session state check
if (!isset($_SESSION["cliente_id"])) {
    header("Location: " . BASE_URL . "client/auth/login.php?redirect=carrito");
    exit;
}

// 2. Cart logic
if (!isset($_SESSION["carrito"]) || empty($_SESSION["carrito"])) {
    header("Location: " . BASE_URL . "client/espacios/index.php");
    exit;
}

$pdo = conectarDB();
$stmt = $pdo->prepare("SELECT * FROM espacios WHERE id = ? AND activo = 1");
$stmt->execute([$_SESSION["carrito"]["espacio_id"]]);
$espacio = $stmt->fetch();

if (!$espacio) {
    unset($_SESSION["carrito"]);
    header("Location: " . BASE_URL . "client/espacios/index.php");
    exit;
}

$page_title = "Mi Reserva — Hotel Salitre";
$extra_stylesheets = ["assets/css/client/carrito.css"];
$extra_scripts = ["assets/js/client/carrito.js"]; // Para validar boton confirm

require_once dirname(__DIR__) . "/includes/header.php";
require_once dirname(__DIR__) . "/includes/nav.php";
$base = BASE_URL;
$cart = $_SESSION["carrito"];

$amenidades = json_decode((string)$espacio['amenidades'], true) ?? [];
?>

<div class="page-offset"></div>

<section class="carrito section-pad">
    <div class="container container--wide">
        
        <div class="carrito-header text-center mb-8 fade-in">
            <h1 class="section-title">Confirma tu reserva</h1>
            <p class="text-muted">Asegura tu lugar en la costa y mejora tu productividad.</p>
        </div>

        <div class="carrito-layout grid">
            
            <!-- Col Izquierda (65%) -->
            <div class="carrito-info fade-in" data-delay="100">
                <div class="carrito-info__card space-card">
                    <div class="carrito-info__media">
                        <?php if (!empty($espacio['foto_principal'])) : ?>
                            <picture>
                                <img src="<?= htmlspecialchars($base . $espacio['foto_principal'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars((string)$espacio['nombre'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                            </picture>
                        <?php else : ?>
                            <div class="img-placeholder" style="aspect-ratio:3/2;">
                                <span><?= htmlspecialchars((string)$espacio['nombre'], ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="carrito-info__details">
                        <span class="badge badge--accent mb-2"><?= htmlspecialchars((string)$espacio['tipo'], ENT_QUOTES, 'UTF-8') ?></span>
                        <h2 class="text-xl fw-600 mb-2"><?= htmlspecialchars((string)$espacio['nombre'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <ul class="meta-list mb-4 text-sm text-muted">
                            <li>Check-in: <strong><?= date('d M, y', strtotime($cart['fecha_entrada'])) ?></strong> a las 15:00 hrs.</li>
                            <li>Check-out: <strong><?= date('d M, y', strtotime($cart['fecha_salida'])) ?></strong> a las 11:00 hrs.</li>
                            <li>Noches totales: <strong><?= $cart['noches'] ?></strong></li>
                        </ul>
                        
                        <div class="divider"></div>
                        
                        <h3 class="mb-2 fw-600 text-sm">El espacio incluye:</h3>
                        <div class="carrito-amenities text-sm">
                            <?php if (!empty($amenidades)) : ?>
                                <ul style="display:flex; flex-wrap:wrap; gap:12px; color:var(--color-text-muted);">
                                    <?php foreach (array_slice($amenidades, 0, 4) as $am) : ?>
                                        <li style="display:inline-flex; align-items:center; gap:6px;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            <?= htmlspecialchars((string)$am, ENT_QUOTES, 'UTF-8') ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Col Derecha (35%) Sticky -->
            <div class="carrito-summary fade-in" data-delay="200">
                <div class="summary-card">
                    <h2 class="summary-card__title">Desglose de Costos</h2>
                    
                    <ul class="summary-list">
                        <li class="flex-between">
                            <span>$<?= number_format((float)$espacio['precio_noche'], 0) ?> x <?= $cart['noches'] ?> noches</span>
                            <span>$<?= number_format((float)$cart['subtotal'], 2) ?></span>
                        </li>
                        <li class="flex-between text-muted">
                            <span>Fee de limpieza e integración</span>
                            <span>$<?= number_format((float)$cart['limpieza'], 2) ?></span>
                        </li>
                        <li class="flex-between text-muted pb-3" style="border-bottom:1px solid var(--color-border);">
                            <span>Impuestos (IVA <?= IVA * 100 ?>%)</span>
                            <span>$<?= number_format((float)$cart['iva'], 2) ?></span>
                        </li>
                        <li class="flex-between summary-total pt-3">
                            <span class="text-lg fw-600">Total</span>
                            <span class="text-xl fw-700 text-accent">$<?= number_format((float)$cart['total'], 2) ?></span>
                        </li>
                    </ul>

                    <form id="form-carrito-checkout" action="<?= $base ?>client/carrito/confirmacion.php" method="POST">
                        <input type="hidden" name="cart_intent" value="1">
                        <!-- Redirige solo directo a reserva para Fase 7 -->
                        <button type="submit" class="btn btn-primary btn-lg w-full mt-6" id="btn-request">Solicitar Reserva</button>
                    </form>

                    <div class="summary-policies mt-8 alert" style="flex-direction:column; background:var(--color-bg); border-left:3px solid var(--color-accent);">
                        <h4 class="fw-600 mb-1 text-sm text-accent">Políticas de Cancelación</h4>
                        <p class="text-xs text-muted">Reembolso del 100% si cancelas al menos 72 horas antes del check-in. De lo contrario se cobrará la primera noche.</p>
                    </div>

                    <div class="summary-trust mt-6 flex-center gap-4 text-muted">
                        <div class="trust-icons flex gap-2">
                            <!-- Los placeholder apegados a reglas (SVG css inline fallback o clase) -->
                            <div class="img-placeholder" style="width:36px; height:24px; font-size:9px; font-weight:bold; aspect-ratio:3/2; display:flex; justify-content:center; align-items:center;">VISA</div>
                            <div class="img-placeholder" style="width:36px; height:24px; font-size:9px; font-weight:bold; aspect-ratio:3/2; display:flex; justify-content:center; align-items:center;">MC</div>
                            <div class="img-placeholder" style="width:36px; height:24px; font-size:9px; font-weight:bold; aspect-ratio:3/2; display:flex; justify-content:center; align-items:center;">AMEX</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require dirname(__DIR__) . "/includes/footer.php"; ?>
