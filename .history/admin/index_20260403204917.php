<?php
declare(strict_types=1);
require_once 'includes/auth_check.php';

require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/config/database.php';
// Definimos variables para las estadísticas, con valores por defecto en caso de error
$stat_reservas_pendientes = 0;
$stat_espacios_activos    = 0;
$stat_clientes            = 0;

try {
    $pdo = conectarDB();

    // Vamos a obtener las estadísticas principales de reservas pendientes
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM reservas WHERE estado = :estado');
    $stmt->execute([':estado' => 'pendiente']);
    $stat_reservas_pendientes = (int) $stmt->fetchColumn();
    // Vamos a obtener las estadísticas principales de espacios activos
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM espacios WHERE activo = 1');
    $stmt->execute();
    $stat_espacios_activos = (int) $stmt->fetchColumn();
    // Vamos a obtener las estadísticas principales de clientes registrados
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM clientes');
    $stmt->execute();
    $stat_clientes = (int) $stmt->fetchColumn();

} catch (Throwable $e) {
    error_log('Admin dashboard stats: ' . $e->getMessage());
}
// Definimos el título de la página y cargamos el header y sidebar
$page_title = 'Salitre';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>
<main class="main-content">
  <div class="topbar">
    <h1 class="topbar__title">Dashboard</h1>
    <span class="topbar__meta">Bienvenido, <?php echo $staff_nombre; ?></span>
  </div>

  <div class="content-area">

    <!-- Stat cards -->
    <div class="stats-grid">

      <div class="stat-card stat-card--pending">
        <span class="stat-card__label">Reservas pendientes</span>
        <span class="stat-card__value"><?php echo $stat_reservas_pendientes; ?></span>
        <span class="stat-card__desc">Requieren confirmación</span>
      </div>

      <div class="stat-card stat-card--active">
        <span class="stat-card__label">Espacios activos</span>
        <span class="stat-card__value"><?php echo $stat_espacios_activos; ?></span>
        <span class="stat-card__desc">Disponibles para reserva</span>
      </div>

      <div class="stat-card stat-card--clients">
        <span class="stat-card__label">Clientes registrados</span>
        <span class="stat-card__value"><?php echo $stat_clientes; ?></span>
        <span class="stat-card__desc">Total en base de datos</span>
      </div>

    </div><!-- /.stats-grid -->

<?php require_once 'includes/footer.php'; ?>
