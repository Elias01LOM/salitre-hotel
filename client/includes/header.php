<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/config/constants.php';

$page_title = $page_title ?? 'Hotel Salitre'; ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?></title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8'); ?>assets/css/shared/reset.css">
        <link rel="stylesheet" href="<?php echo htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8'); ?>assets/css/shared/variables.css">
        <link rel="stylesheet" href="<?php echo htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8'); ?>assets/css/client/main.css">
        <?php
        if (!empty($extra_stylesheets) && is_array($extra_stylesheets)) {
            foreach ($extra_stylesheets as $sheet) {
                $href = BASE_URL . ltrim((string) $sheet, '/'); ?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($href, ENT_QUOTES, 'UTF-8'); ?>">
                <?php
            }
        }
        ?>
    </head>
    <body class="page">
        <?php require INCLUDES_CLIENT_PATH . 'nav.php'; ?>
