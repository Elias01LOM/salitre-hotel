<?php
/* 'admin/eventos/editar.php' es la página para editar un evento existente desde el panel de administración de Salitre */
declare(strict_types=1);

require_once dirname(__DIR__) . "/includes/auth_check.php";
require_once dirname(__DIR__, 2) . "/config/database.php";
require_once dirname(__DIR__, 2) . "/config/constants.php";

$errores = [];

// Obtener ID
$id = filter_var($_GET["id"] ?? 0, FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: listar.php");
    exit;
}

try {
    $pdo = conectarDB();
    
    // Obtener evento original
    $stmt = $pdo->prepare("SELECT * FROM eventos WHERE id = ?");
    $stmt->execute([$id]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$evento) {
        header("Location: listar.php");
        exit;
    }
} catch (PDOException $e) {
    error_log("Error cargando evento: " . $e->getMessage());
    header("Location: listar.php");
    exit;
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["titulo"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $fecha_evento = $_POST["fecha_evento"] ?? "";
    $hora_inicio = !empty($_POST["hora_inicio"]) ? $_POST["hora_inicio"] : null;
    $hora_fin = !empty($_POST["hora_fin"]) ? $_POST["hora_fin"] : null;
    $cupo = !empty($_POST["cupo"]) ? (int)$_POST["cupo"] : null;
    $activo = isset($_POST["activo"]) ? 1 : 0;
    
    if (empty($titulo)) $errores[] = "El título es obligatorio.";
    if (empty($fecha_evento)) $errores[] = "La fecha es obligatoria.";
    
    if (empty($errores)) {
        try {
            $stmt = $pdo->prepare(
                "UPDATE eventos SET titulo=?, descripcion=?, fecha_evento=?, hora_inicio=?, hora_fin=?, cupo=?, activo=? 
                 WHERE id=?"
            );
            $stmt->execute([$titulo, $descripcion, $fecha_evento, $hora_inicio, $hora_fin, $cupo, $activo, $id]);
            header("Location: listar.php?success=updated");
            exit;
        } catch (PDOException $e) {
            $errores[] = "Error guardando evento: " . $e->getMessage();
        }
    }
}

$page_title = "Editar Evento — Panel Salitre";

require_once dirname(__DIR__) . "/includes/header.php";
require_once dirname(__DIR__) . "/includes/sidebar.php";
?>

<main class="main-content">
    <div class="topbar">
        <h1 class="topbar__title">Modificar Evento (#<?= $id ?>)</h1>
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
            <form method="POST" action="editar.php?id=<?= $id ?>" class="form-grid" style="display:flex; flex-direction:column; gap:1.5rem;">
                
                <div class="field">
                    <label for="titulo" class="field__label fw-600">Título del Evento <span class="text-error">*</span></label>
                    <input type="text" id="titulo" name="titulo" class="field__input" style="width:100%; padding:0.75rem;" required value="<?= htmlspecialchars($_POST['titulo'] ?? $evento["titulo"], ENT_QUOTES, 'UTF-8') ?>">
                </div>
                
                <div class="field">
                    <label for="descripcion" class="field__label fw-600">Descripción Completa</label>
                    <textarea id="descripcion" name="descripcion" class="field__input" style="width:100%; padding:0.75rem; min-height:100px; resize:vertical; font-family:var(--font-body);"><?= htmlspecialchars($_POST['descripcion'] ?? $evento["descripcion"], ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1.5rem;">
                    <div class="field">
                        <label for="fecha_evento" class="field__label fw-600">Día del Evento <span class="text-error">*</span></label>
                        <input type="date" id="fecha_evento" name="fecha_evento" class="field__input" style="width:100%; padding:0.75rem;" required value="<?= htmlspecialchars($_POST['fecha_evento'] ?? $evento["fecha_evento"], ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    
                    <div class="field">
                        <label for="hora_inicio" class="field__label fw-600">Hora de Inicio</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" class="field__input" style="width:100%; padding:0.75rem;" value="<?= htmlspecialchars($_POST['hora_inicio'] ?? $evento["hora_inicio"], ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    
                    <div class="field">
                        <label for="hora_fin" class="field__label fw-600">Hora de Cierre</label>
                        <input type="time" id="hora_fin" name="hora_fin" class="field__input" style="width:100%; padding:0.75rem;" value="<?= htmlspecialchars($_POST['hora_fin'] ?? $evento["hora_fin"], ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>
                
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1.5rem; align-items:center; border-top:1px dashed var(--color-border); padding-top:1.5rem;">
                    <div class="field">
                        <label for="cupo" class="field__label fw-600">Límite de Cupo <span class="text-muted fw-400">(Dejar vacío si es ilimitado)</span></label>
                        <input type="number" id="cupo" name="cupo" min="1" class="field__input" style="width:100%; padding:0.75rem;" value="<?= htmlspecialchars((string)($_POST['cupo'] ?? $evento["cupo"]), ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    
                    <div class="field checkbox-wrapper" style="margin-top:1rem;">
                        <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;" class="fw-600">
                            <!-- Helper booleano: si hay POST manda el valor del checkbox o 0, sino la DB original -->
                            <?php $isActivo = isset($_POST['titulo']) ? isset($_POST['activo']) : (bool)$evento['activo']; ?>
                            <input type="checkbox" name="activo" id="activo" style="width:20px; height:20px; accent-color:var(--color-accent);" <?= $isActivo ? 'checked' : '' ?>>
                            Evento visible al público
                        </label>
                    </div>
                </div>
                
                <div style="display:flex; justify-content:flex-end; gap:1rem; border-top: 1px solid var(--color-border); padding-top:1.5rem; margin-top:0.5rem;">
                    <a href="listar.php" class="btn btn-outline" style="min-width:120px; justify-content:center;">Cancelar</a>
                    <button type="submit" class="btn btn-primary" style="min-width:150px; justify-content:center;">Guardar Cambios</button>
                </div>
            </form>
        </div>
        
    </div>
</main>

<?php require_once dirname(__DIR__) . "/includes/footer.php"; ?>
