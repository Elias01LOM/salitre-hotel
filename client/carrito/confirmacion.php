<?php
session_start();
require_once dirname(__DIR__) . "/../config/database.php";
require_once dirname(__DIR__) . "/../config/constants.php";

// Verificar sesión cliente
if (!isset($_SESSION["cliente_id"])) {
    header("Location: " . BASE_URL . "client/auth/login.php");
    exit;
}

// Obtener folio de URL
$reserva_id = filter_var($_GET["id"] ?? 0, FILTER_VALIDATE_INT);
if (!$reserva_id) {
    header("Location: " . BASE_URL . "client/espacios/index.php");
    exit;
}

// Consultar reserva
try {
    $pdo = conectarDB();
    $stmt = $pdo->prepare(
        "SELECT r.*, e.nombre as espacio_nombre, e.tipo as espacio_tipo 
         FROM reservas r 
         JOIN espacios e ON r.espacio_id = e.id 
         WHERE r.id = ? AND r.cliente_id = ?"
    );
    $stmt->execute([$reserva_id, $_SESSION["cliente_id"]]);
    $reserva = $stmt->fetch();

    if (!$reserva) {
        header("Location: " . BASE_URL . "client/espacios/index.php");
        exit;
    }
} catch (PDOException $e) {
    error_log("Error al consultar reserva para folio $reserva_id: " . $e->getMessage());
    header("Location: " . BASE_URL . "client/index.php");
    exit;
}

$page_title = "Reserva Confirmada — Hotel Salitre";
$extra_stylesheets = ["assets/css/client/carrito.css"];

require_once dirname(__DIR__) . "/includes/header.php";
require_once dirname(__DIR__) . "/includes/nav.php";
$base = BASE_URL;
?>

<div class="page-offset"></div>

<section class="confirmacion section-pad" style="min-height: 70vh; display: flex; align-items: center; justify-content: center;">
    <div class="container" style="max-width: 600px; text-align: center;">
        
        <div class="confirm-icon fade-in mb-6" style="display:inline-flex; align-items:center; justify-content:center; width:80px; height:80px; border-radius:50%; background:var(--color-mid); color:var(--color-success); border:3px solid var(--color-success);">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        
        <h1 class="section-title fade-in" data-delay="100">¡Reserva Solicitada!</h1>
        <p class="text-lg text-muted fade-in mb-8" data-delay="150" style="line-height:1.6;">
            Tu reserva ha ingresado correctamente al sistema.<br>
            El folio asignado es: <strong style="color:var(--color-text); font-family:monospace; font-size:1.2em;">#<?= str_pad((string)$reserva['id'], 6, '0', STR_PAD_LEFT) ?></strong>
        </p>

        <div class="summary-card text-left fade-in" data-delay="200" style="margin-bottom:var(--space-8);">
            <h3 class="mb-4 text-accent" style="font-family:var(--font-display); font-size:var(--text-xl);">Resumen</h3>
            <ul style="list-style:none; padding:0; margin:0;" class="gap-3 flex-col">
                <li class="flex-between">
                    <span class="text-muted">Espacio</span>
                    <strong><?= htmlspecialchars((string)$reserva['espacio_nombre'], ENT_QUOTES, 'UTF-8') ?></strong>
                </li>
                <li class="flex-between">
                    <span class="text-muted">Check-in</span>
                    <span><?= date('d M, Y', strtotime($reserva['fecha_entrada'])) ?></span>
                </li>
                <li class="flex-between">
                    <span class="text-muted">Check-out</span>
                    <span><?= date('d M, Y', strtotime($reserva['fecha_salida'])) ?></span>
                </li>
                <li class="flex-between">
                    <span class="text-muted">Estancia</span>
                    <span><?= (int)$reserva['noches'] ?> noches</span>
                </li>
                <li class="flex-between" style="border-top:1px dashed var(--color-border); padding-top:var(--space-3); margin-top:var(--space-3);">
                    <span class="fw-600 text-lg">Total</span>
                    <strong class="text-accent text-lg">$<?= number_format((float)$reserva['precio_total'], 2) ?></strong>
                </li>
            </ul>
        </div>
        
        <div class="alert fade-in text-left mb-8" data-delay="250" style="background:var(--color-bg); border-left:3px solid var(--color-accent);">
            <p class="text-sm text-muted">Te contactaremos en las próximas 24-48 horas a través de los datos de tu perfil para confirmar disponibilidad definitiva y los pasos para el pago.</p>
        </div>

        <div class="fade-in" data-delay="300">
            <a href="<?= $base ?>client/index.php" class="btn btn-outline btn-lg" style="width:100%; justify-content:center;">Volver al Home</a>
        </div>

    </div>
</section>

<?php require dirname(__DIR__) . "/includes/footer.php"; ?>
