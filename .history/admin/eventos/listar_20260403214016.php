<?php
/* 'admin/eventos/listar.php' es la página para listar, editar y gestionar los eventos desde el panel de administración */
declare(strict_types=1);

require_once dirname(__DIR__) . "/includes/auth_check.php";
require_once dirname(__DIR__, 2) . "/config/database.php";
require_once dirname(__DIR__, 2) . "/config/constants.php";

$page_title = "Agenda — Panel Salitre";
// Cargamos los eventos desde la base de datos
$extra_stylesheets = ["assets/css/admin/dashboard.css"];

require_once dirname(__DIR__) . "/includes/header.php";
require_once dirname(__DIR__) . "/includes/sidebar.php";

$eventos = [];
try {
    $pdo = conectarDB();
    $stmt = $pdo->prepare("SELECT * FROM eventos ORDER BY fecha_evento DESC");
    $stmt->execute();
    $eventos = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Error listando eventos: " . $e->getMessage());
}
?>

<main class="main-content">
    <div class="topbar">
        <h1 class="topbar__title">Gestión de Eventos</h1>
        <span class="topbar__meta"><a href="crear.php" class="btn btn-primary" style="padding: 0.5rem 1rem;">+ Nuevo Evento</a></span>
    </div>

    <div class="content-area">
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert--success mb-4" style="background:var(--color-bg); padding:1rem; border-left:4px solid var(--color-success);">
                <?php if ($_GET['success'] === 'created'): ?>
                    <p>Evento creado exitosamente.</p>
                <?php elseif ($_GET['success'] === 'updated'): ?>
                    <p>Evento actualizado exitosamente.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="card p-0">
            <div style="overflow-x:auto;">
                <table class="data-table" style="width:100%; text-align:left; border-collapse:collapse;">
                    <thead style="background:var(--color-surface); border-bottom:2px solid var(--color-border);">
                        <tr>
                            <th style="padding:1rem;">ID</th>
                            <th style="padding:1rem;">Título</th>
                            <th style="padding:1rem;">Fecha</th>
                            <th style="padding:1rem;">Horario</th>
                            <th style="padding:1rem;">Cupo</th>
                            <th style="padding:1rem;">Estado</th>
                            <th style="padding:1rem;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($eventos)): ?>
                            <tr>
                                <td colspan="7" style="padding:2rem; text-align:center; color:var(--color-text-muted);">
                                    No hay eventos registrados.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($eventos as $evento): ?>
                                <tr style="border-bottom:1px solid var(--color-border);">
                                    <td style="padding:1rem; font-family:monospace; color:var(--color-text-muted);">#<?= str_pad((string)$evento["id"], 4, "0", STR_PAD_LEFT) ?></td>
                                    <td style="padding:1rem; font-weight:600;"><?= htmlspecialchars((string)$evento["titulo"], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td style="padding:1rem;"><?= date('d M Y', strtotime((string)$evento["fecha_evento"])) ?></td>
                                    <td style="padding:1rem; color:var(--color-text-muted);">
                                        <?= !empty($evento["hora_inicio"]) ? date('H:i', strtotime((string)$evento["hora_inicio"])) : "—" ?> 
                                        <?= !empty($evento["hora_fin"]) ? " a " . date('H:i', strtotime((string)$evento["hora_fin"])) : "" ?>
                                    </td>
                                    <td style="padding:1rem; color:var(--color-text-muted);"><?= (int)$evento["cupo"] > 0 ? (int)$evento["cupo"] : "∞" ?></td>
                                    <td style="padding:1rem;">
                                        <span class="badge" style="background:<?= $evento["activo"] ? 'var(--color-success)' : 'var(--color-mid)' ?>; color:<?= $evento["activo"] ? 'white' : 'var(--color-text-muted)' ?>; font-size:0.75rem;">
                                            <?= $evento["activo"] ? "Activo" : "Inactivo" ?>
                                        </span>
                                    </td>
                                    <td class="actions" style="padding:1rem;">
                                        <a href="editar.php?id=<?= $evento["id"] ?>" class="btn btn-outline" style="padding:0.25rem 0.75rem; font-size:0.875rem;">Editar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php require_once dirname(__DIR__) . "/includes/footer.php"; ?>
