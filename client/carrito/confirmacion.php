<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/require_cliente_auth.php';

$cliente_id = (int) $_SESSION['cliente_id'];
$carrito_url = BASE_URL . 'client/carrito/';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $carrito_url, true, 302);
    exit;
}

$espacio_id = isset($_POST['espacio_id']) ? (int) $_POST['espacio_id'] : 0;
$fecha_entrada_s = isset($_POST['fecha_entrada']) ? trim((string) $_POST['fecha_entrada']) : '';
$fecha_salida_s = isset($_POST['fecha_salida']) ? trim((string) $_POST['fecha_salida']) : '';

if ($espacio_id < 1 || $fecha_entrada_s === '' || $fecha_salida_s === '') {
    header('Location: ' . $carrito_url, true, 302);
    exit;
}

$dt_entrada = DateTime::createFromFormat('Y-m-d', $fecha_entrada_s);
$dt_salida = DateTime::createFromFormat('Y-m-d', $fecha_salida_s);

if ($dt_entrada === false || $dt_salida === false) {
    header('Location: ' . $carrito_url . '?espacio_id=' . $espacio_id . '&error=fechas', true, 302);
    exit;
}

if ($dt_salida <= $dt_entrada) {
    header('Location: ' . $carrito_url . '?espacio_id=' . $espacio_id . '&error=fechas', true, 302);
    exit;
}

$intervalo = $dt_entrada->diff($dt_salida);
$noches = (int) $intervalo->days;

if ($noches < 1) {
    header('Location: ' . $carrito_url . '?espacio_id=' . $espacio_id . '&error=fechas', true, 302);
    exit;
}

if ($noches > 255) {
    header('Location: ' . $carrito_url . '?espacio_id=' . $espacio_id . '&error=noches', true, 302);
    exit;
}

$pdo = conectarDB();
$stmtEsp = $pdo->prepare(
    'SELECT id, precio_noche FROM espacios WHERE id = ? AND activo = 1 LIMIT 1'
);
$stmtEsp->execute([$espacio_id]);
$fila_espacio = $stmtEsp->fetch(PDO::FETCH_ASSOC);

if ($fila_espacio === false) {
    header('Location: ' . BASE_URL . 'client/espacios/', true, 302);
    exit;
}

$precio_noche = (float) $fila_espacio['precio_noche'];
$precio_total = round($noches * $precio_noche, 2);

$fecha_entrada_sql = $dt_entrada->format('Y-m-d');
$fecha_salida_sql = $dt_salida->format('Y-m-d');

$stmtIns = $pdo->prepare(
    'INSERT INTO reservas (cliente_id, espacio_id, fecha_entrada, fecha_salida, noches, precio_total, estado)
     VALUES (?, ?, ?, ?, ?, ?, ?)'
);
$stmtIns->execute([
    $cliente_id,
    $espacio_id,
    $fecha_entrada_sql,
    $fecha_salida_sql,
    $noches,
    $precio_total,
    'pendiente',
]);

$page_title = 'Reserva confirmada · Hotel Salitre';
$extra_stylesheets = ['assets/css/client/carrito.css'];

require dirname(__DIR__) . '/includes/header.php';

$home = BASE_URL . 'client/';
?>
  <main id="contenido-principal" class="confirm-page">
    <h1 class="confirm-page__title">¡Reserva confirmada!</h1>
    <p class="confirm-page__text">Tu solicitud quedó registrada como pendiente. Nos pondremos en contacto si hace falta confirmar detalles.</p>
    <a class="confirm-page__btn" href="<?php echo htmlspecialchars($home, ENT_QUOTES, 'UTF-8'); ?>">Volver al inicio</a>
  </main>
<?php
require dirname(__DIR__) . '/includes/footer.php';
