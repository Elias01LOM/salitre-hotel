<?php
/* 'client/carrito/confirmacion.php' muestra la página de confirmación y derivados de reserva después de que el cliente ha completado el proceso de reserva */

session_start();

/* Mandamos a llamar a la base de datos y las constantes - requerido obligatoriamente */
require_once "../../config/database.php";
require_once "../../config/constants.php";

/* Validamos la sesión de cliente */
if (!isset($_SESSION["cliente_id"])) {
    header("Location: " . BASE_URL . "client/auth/login.php");
    exit;
}

/* Obtenemos el ID de reserva de la sesión */
$reserva_id = $_SESSION["reserva_confirmacion_id"] ?? null;

if (!$reserva_id) {
    header("Location: " . BASE_URL . "client/espacios/index.php");
    exit;
}

/* Obtenemos los datos de la reserva */
$db = conectarDB();
$stmt = $db->prepare("
    SELECT r.*, e.nombre as espacio_nombre, e.slug as espacio_slug
    FROM reservas r
    JOIN espacios e ON r.espacio_id = e.id
    WHERE r.id = ? AND r.cliente_id = ?
");
$stmt->execute([$reserva_id, $_SESSION["cliente_id"]]);
$reserva = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reserva) {
    header("Location: " . BASE_URL . "client/espacios/index.php");
    exit;
}

/* Limpiamos el ID de confirmación */
unset($_SESSION["reserva_confirmacion_id"]);

$page_title = "Reserva Confirmada — Hotel Salitre";
$extra_stylesheets = ["assets/css/client/carrito.css"];

/* Incluir el encabezado y la navegación */
require_once "../includes/header.php";
require_once "../includes/nav.php";
?>

<main class="confirmacion-page">
    <div class="container container--wide">
        <div class="confirmacion-card">
            <div class="confirmacion-icon">✓</div>
            <h1>¡Reserva Solicitada!</h1>
            <p class="confirmacion-subtitle">
                Hemos recibido tu solicitud. Te contactaremos pronto para confirmar.
            </p>
            
            <div class="confirmacion-detalles">
                <div class="detalle-row">
                    <span class="label">Número de Folio:</span>
                    <span class="value">#<?= str_pad((string)$reserva["id"], 6, "0", STR_PAD_LEFT) ?></span>
                </div>
                <div class="detalle-row">
                    <span class="label">Espacio:</span>
                    <span class="value"><?= htmlspecialchars($reserva["espacio_nombre"]) ?></span>
                </div>
                <div class="detalle-row">
                    <span class="label">Check-in:</span>
                    <span class="value"><?= date("d/m/Y", strtotime($reserva["fecha_entrada"])) ?></span>
                </div>
                <div class="detalle-row">
                    <span class="label">Check-out:</span>
                    <span class="value"><?= date("d/m/Y", strtotime($reserva["fecha_salida"])) ?></span>
                </div>
                <div class="detalle-row">
                    <span class="label">Noches:</span>
                    <span class="value"><?= $reserva["noches"] ?></span>
                </div>
                <div class="detalle-row total">
                    <span class="label">Total pagadero:</span>
                    <span class="value">$<?= number_format((float)$reserva["precio_total"], 2) ?> MXN</span>
                </div>
            </div>
            
            <div class="confirmacion-notas">
                <h3>Próximos pasos:</h3>
                <ol>
                    <li>Recibirás un email de confirmación en las próximas 24 horas.</li>
                    <li>El staff se pondrá en contacto para coordinar detalles.</li>
                    <li>El pago se realiza al momento del check-in.</li>
                </ol>
            </div>
            
            <div class="confirmacion-actions">
                <a href="<?= BASE_URL ?>client/auth/perfil.php" class="btn btn-outline">
                    Ver en Mi Perfil
                </a>
                <a href="<?= BASE_URL ?>client/index.php" class="btn btn-primary">
                    Volver al Inicio
                </a>
            </div>
        </div>
    </div>
</main>

<?php require_once "../includes/footer.php"; ?>
