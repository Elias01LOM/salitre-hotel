<?php
declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/config/constants.php';

$pageTitle = $pageTitle ?? 'Hotel Salitre';
$extraCss = $extraCss ?? null;

?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars((string) $pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/shared/variables.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/shared/reset.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/client/main.css">
<?php
if (!empty($extraCss)) {
    $sheets = is_array($extraCss) ? $extraCss : [$extraCss];
    foreach ($sheets as $sheet) {
        // Validamos si la ruta ya trae HTTP (como la seteamos en index.php) o si es relativa
        $href = strpos((string)$sheet, 'http') === 0 ? $sheet : BASE_URL . ltrim((string) $sheet, '/');
        echo '  <link rel="stylesheet" href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . "\">\n";
    }
}
?>
</head>
<body>
    