<?php
declare(strict_types=1);
// Note: auth_check.php already called by the parent page before this include.
// constants.php is also already loaded.
$page_title   = $page_title ?? 'Panel · Hotel Salitre';
$admin_nombre = isset($_SESSION['admin_nombre']) ? htmlspecialchars((string) $_SESSION['admin_nombre'], ENT_QUOTES, 'UTF-8') : 'Admin';
$admin_rol    = isset($_SESSION['admin_rol'])    ? htmlspecialchars((string) $_SESSION['admin_rol'],    ENT_QUOTES, 'UTF-8') : '';
$base         = BASE_URL;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?></title>
  <link rel="stylesheet" href="<?php echo $base; ?>assets/css/admin/dashboard.css">
<?php if (!empty($extra_css) && is_array($extra_css)) : ?>
<?php   foreach ($extra_css as $css) : ?>
  <link rel="stylesheet" href="<?php echo $base . htmlspecialchars(ltrim((string) $css, '/'), ENT_QUOTES, 'UTF-8'); ?>">
<?php   endforeach; ?>
<?php endif; ?>
</head>
<body class="admin-body">
