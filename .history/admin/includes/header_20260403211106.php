<?php
/* Definimos la cabecera común para todas las páginas del admin */
declare(strict_types=1);
$page_title   = $page_title ?? 'Panel · Hotel Salitre';
$staff_nombre = isset($_SESSION['staff_nombre']) ? htmlspecialchars((string) $_SESSION['staff_nombre'], ENT_QUOTES, 'UTF-8') : 'Staff';
$staff_rol    = isset($_SESSION['staff_rol'])    ? htmlspecialchars((string) $_SESSION['staff_rol'],    ENT_QUOTES, 'UTF-8') : '';
$base         = BASE_URL;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?></title>

  <!-- 1. Variables — ÚNICA fuente de verdad visual -->
  <link rel="stylesheet" href="<?= $base ?>assets/css/shared/variables.css">
  <!-- 2. Reset cross-browser (consume variables) -->
  <link rel="stylesheet" href="<?= $base ?>assets/css/shared/reset.css">
  <!-- 3. Admin base (importa dashboard.css) -->
  <link rel="stylesheet" href="<?= $base ?>assets/css/admin/main.css">

  <?php if (!empty($extra_stylesheets) && is_array($extra_stylesheets)) : ?>
    <?php foreach ($extra_stylesheets as $css) : ?>
      <link rel="stylesheet" href="<?= $base . htmlspecialchars(ltrim((string) $css, '/'), ENT_QUOTES, 'UTF-8') ?>">
    <?php endforeach; ?>
  <?php endif; ?>
  <?php // Soporte legacy para $extra_css (páginas admin existentes) ?>
  <?php if (!empty($extra_css) && is_array($extra_css)) : ?>
    <?php foreach ($extra_css as $css) : ?>
      <link rel="stylesheet" href="<?= $base . htmlspecialchars(ltrim((string) $css, '/'), ENT_QUOTES, 'UTF-8') ?>">
    <?php endforeach; ?>
  <?php endif; ?>
</head>
<body class="admin-body">
