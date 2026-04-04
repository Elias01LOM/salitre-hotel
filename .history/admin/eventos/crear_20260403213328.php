<?php
/* 'admin/eventos/crear.php' es la página para crear un nuevo evento desde el panel de administración de Salitre */
declare(strict_types=1);

require_once dirname(__DIR__) . "/includes/auth_check.php";
require_once dirname(__DIR__, 2) . "/config/database.php";
require_once dirname(__DIR__, 2) . "/config/constants.php";

$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["titulo"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $fecha_evento = $_POST["fecha_evento"] ?? "";
    $hora_inicio = !empty($_POST["hora_inicio"]) ? $_POST["hora_inicio"] : null;
    $hora_fin = !empty($_POST["hora_fin"]) ? $_POST["hora_fin"] : null;
    $cupo = !empty($_POST["cupo"]) ? (int)$_POST["cupo"] : null;
    $activo = isset($_POST["activo"]) ? 1 : 0;
    
    // Validaciones
    if (empty($titulo)) $errores[] = "El título es obligatorio.";
    if (empty($fecha_evento)) $errores[] = "La fecha es obligatoria.";
    
    if (empty($errores)) {
        try {
            $pdo = conectarDB();
            $stmt = $pdo->prepare(
                "INSERT INTO eventos (titulo, descripcion, fecha_evento, hora_inicio, hora_fin, cupo, activo) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([$titulo, $descripcion, $fecha_evento, $hora_inicio, $hora_fin, $cupo, $activo]);
            header("Location: listar.php?success=created");
            exit;
        } catch (PDOException $e) {
            $errores[] = "Error de persistencia: " . $e->getMessage();
        }
    }
}

$page_title = "Crear Evento — Panel Salitre";

require_once dirname(__DIR__) . "/includes/header.php";
require_once dirname(__DIR__) . "/includes/sidebar.php";
?>

<main class="main-content">
    <div class="topbar">
        <h1 class="topbar__title">Nuevo Evento</h1>
        <span class="topbar__meta"><a href="listar.php" class="btn btn-outline" style="padding:0.5rem 1rem;">‹ Volver</a></span>
    </div>

    <div class="content-area" style="max-width:800px;">
        
        <?php if (!empty($errores)): ?>
            <div class="alert alert--error mb-6" style="background:var(--color-bg); padding:1rem; border-left:4px solid var(--color-error);">
                <ul style="margin:0; padding-left:1.5rem; color:var(--color-error);">
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card">
            <form method="POST" action="crear.php" class="form-grid" style="display:flex; flex-direction:column; gap:1.5rem;">
                
                <div class="field">
                    <label for="titulo" class="field__label fw-600">Título del Evento <span class="text-error">*</span></label>
                    <input type="text" id="titulo" name="titulo" class="field__input" style="width:100%; padding:0.75rem;" required value="<?= htmlspecialchars($titulo ?? "", ENT_QUOTES, 'UTF-8') ?>">
                </div>
                
                <div class="field">
                    <label for="descripcion" class="field__label fw-600">Descripción Completa</label>
                    <textarea id="descripcion" name="descripcion" class="field__input" style="width:100%; padding:0.75rem; min-height:100px; resize:vertical; font-family:var(--font-body);"><?= htmlspecialchars($descripcion ?? "", ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1.5rem;">
                    <div class="field">
                        <label for="fecha_evento" class="field__label fw-600">Día del Evento <span class="text-error">*</span></label>
                        <input type="date" id="fecha_evento" name="fecha_evento" class="field__input" style="width:100%; padding:0.75rem;" required value="<?= htmlspecialchars($fecha_evento ?? "", ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    
                    <div class="field">
                        <label for="hora_inicio" class="field__label fw-600">Hora de Inicio</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" class="field__input" style="width:100%; padding:0.75rem;" value="<?= htmlspecialchars($hora_inicio ?? "", ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    
                    <div class="field">
                        <label for="hora_fin" class="field__label fw-600">Hora de Cierre</label>
                        <input type="time" id="hora_fin" name="hora_fin" class="field__input" style="width:100%; padding:0.75rem;" value="<?= htmlspecialchars($hora_fin ?? "", ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>
                
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1.5rem; align-items:center; border-top:1px dashed var(--color-border); padding-top:1.5rem;">
                    <div class="field">
                        <label for="cupo" class="field__label fw-600">Límite de Cupo <span class="text-muted fw-400">(Dejar vacío si es ilimitado)</span></label>
                        <input type="number" id="cupo" name="cupo" min="1" class="field__input" style="width:100%; padding:0.75rem;" value="<?= htmlspecialchars($cupo ?? "", ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    
                    <div class="field checkbox-wrapper" style="margin-top:1rem;">
                        <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;" class="fw-600">
                            <input type="checkbox" name="activo" id="activo" style="width:20px; height:20px; accent-color:var(--color-accent);" <?= isset($_POST['titulo']) ? (isset($activo) && $activo ? 'checked' : '') : 'checked' ?>>
                            Evento visible al público
                        </label>
                    </div>
                </div>
                
                <div style="display:flex; justify-content:flex-end; gap:1rem; border-top: 1px solid var(--color-border); padding-top:1.5rem; margin-top:0.5rem;">
                    <a href="listar.php" class="btn btn-outline" style="min-width:120px; justify-content:center;">Cancelar</a>
                    <button type="submit" class="btn btn-primary" style="min-width:150px; justify-content:center;">Publicar Evento</button>
                </div>
            </form>
        </div>
        
    </div>
</main>

<?php require_once dirname(__DIR__) . "/includes/footer.php"; ?>
