<?php
// Sidebar: variables ya disponibles desde header.php ($base, $staff_nombre, $staff_rol)
$current = basename($_SERVER['PHP_SELF']);

$nav_items = [
    ['href' => $base . 'admin/index.php',                  'label' => 'Dashboard', 'file' => 'index.php',
     'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>'],
    ['href' => $base . 'admin/espacios/listar.php',        'label' => 'Espacios',  'file' => 'listar.php',
     'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>'],
    ['href' => $base . 'admin/reservas/listar.php',        'label' => 'Reservas',  'file' => 'listar.php',
     'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>'],
    ['href' => $base . 'admin/clientes/listar.php',        'label' => 'Clientes',  'file' => 'listar.php',
     'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>'],
    ['href' => $base . 'admin/eventos/listar.php',         'label' => 'Agenda',    'file' => 'listar.php',
     'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><circle cx="12" cy="16" r="2"/></svg>'],
    ['href' => $base . 'admin/contacto/listar.php',        'label' => 'Mensajes',  'file' => 'listar.php',
     'icon' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>'],
];
?>
<aside class="sidebar" role="complementary" aria-label="Menú de administración">

  <div class="sidebar__brand">
    <svg class="sidebar__brand-icon" width="22" height="22" viewBox="0 0 24 24" fill="none">
      <path d="M12 2.5c3.9 0 7 3.1 7 7 0 5.5-7 12-7 12S5 15 5 9.5c0-3.9 3.1-7 7-7Z"
            stroke="currentColor" stroke-width="1.5"/>
      <path d="M9.2 10.3c.6-1.5 2.1-2.6 3.8-2.6 1.2 0 2.3.5 3 1.4"
            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
    </svg>
    <span class="sidebar__brand-name">Panel Salitre</span>
  </div>

  <div class="sidebar__user">
    <span class="sidebar__user-role"><?php echo $staff_rol; ?></span>
    <span class="sidebar__user-name"><?php echo $staff_nombre; ?></span>
  </div>

  <nav class="sidebar__nav" aria-label="Navegación principal del admin">
    <p class="sidebar__nav-section">Menú</p>
    <ul class="sidebar__nav-list">
<?php foreach ($nav_items as $item) :
    $is_active = ($current === $item['file'] || strpos($_SERVER['PHP_SELF'], '/' . $item['file'] . '/') !== false);
    $active_class = $is_active ? ' active' : '';
?>
      <li class="sidebar__nav-item">
        <a href="<?php echo htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8'); ?>"
           class="<?php echo $active_class; ?>"
           <?php echo $is_active ? 'aria-current="page"' : ''; ?>>
          <?php echo $item['icon']; ?>
          <?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
        </a>
      </li>
<?php endforeach; ?>
    </ul>
  </nav>

  <div class="sidebar__logout">
    <a href="<?php echo htmlspecialchars($base . 'admin/logout.php', ENT_QUOTES, 'UTF-8'); ?>">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
        <polyline points="16 17 21 12 16 7"/>
        <line x1="21" y1="12" x2="9" y2="12"/>
      </svg>
      Cerrar sesión
    </a>
  </div>

</aside>
