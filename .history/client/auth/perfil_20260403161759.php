<?php
/* 'client/auth/perfil.php' es la página de perfil del cliente, muestra toda su información */

session_start();
require_once "../../config/database.php";
require_once "../../config/constants.php";

/* Se valida la sesión de cliente antes de mostrar información personal, si no hay sesión va a 'login.php' */
if (!isset($_SESSION["cliente_id"])) {
    header("Location: " . BASE_URL . "client/auth/login.php");
    exit;
}

$cliente_id = $_SESSION["cliente_id"];
$db = conectarDB();

/* Obtenemos los datos del cliente con 'prepared statement' */
$stmt = $db->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->execute([$cliente_id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

/* Obtenemos las reservas del cliente con 'JOIN' a espacios */
$stmt = $db->prepare("
    SELECT r.*, e.nombre as espacio_nombre, e.slug as espacio_slug
    FROM reservas r
    JOIN espacios e ON r.espacio_id = e.id
    WHERE r.cliente_id = ?
    ORDER BY r.creado_en DESC
    LIMIT 10
");
$stmt->execute([$cliente_id]);
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "Mi Perfil — " . SITE_NAME;
$extra_stylesheets = ["assets/css/client/auth.css"];

require_once "../includes/header.php";
require_once "../includes/nav.php";
?>

<main class="perfil-page">
    <div class="container container--wide">
        <h1>Mi Perfil</h1>
        
        <section class="perfil-info">
            <h2>Información Personal</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>Nombre:</label>
                    <span><?= htmlspecialchars($cliente["nombre"]) ?></span>
                </div>
                <div class="info-item">
                    <label>Email:</label>
                    <span><?= htmlspecialchars($cliente["email"]) ?></span>
                </div>
                <div class="info-item">
                    <label>Teléfono:</label>
                    <span><?= htmlspecialchars($cliente["telefono"] ?? "No registrado") ?></span>
                </div>
                <div class="info-item">
                    <label>Cliente desde:</label>
                    <span><?= date("d/m/Y", strtotime($cliente["creado_en"])) ?></span>
                </div>
            </div>
        </section>
        
        <section class="perfil-reservas">
            <h2>Mis Reservas</h2>
            <?php if (count($reservas) > 0): ?>
                <table class="reservas-table">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Espacio</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Noches</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservas as $reserva): ?>
                            <tr>
                                <td>#<?= str_pad((string)$reserva["id"], 6, "0", STR_PAD_LEFT) ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>client/espacios/detalle.php?slug=<?= htmlspecialchars($reserva["espacio_slug"]) ?>">
                                        <?= htmlspecialchars($reserva["espacio_nombre"]) ?>
                                    </a>
                                </td>
                                <td><?= date("d/m/Y", strtotime($reserva["fecha_entrada"])) ?></td>
                                <td><?= date("d/m/Y", strtotime($reserva["fecha_salida"])) ?></td>
                                <td><?= $reserva["noches"] ?></td>
                                <td>$<?= number_format((float)$reserva["precio_total"], 2) ?></td>
                                <td>
                                    <span class="badge badge-<?= $reserva["estado"] ?>">
                                        <?= htmlspecialchars($reserva["estado"]) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-reservas">No tienes reservas registradas.</p>
                <a href="<?= BASE_URL ?>client/espacios/index.php" class="btn btn-primary">
                    Ver espacios disponibles
                </a>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php require_once "../includes/footer.php"; ?>
