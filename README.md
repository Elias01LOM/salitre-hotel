# Hotel Salitre — Sistema Web

> *"Sal de la oficina. No del trabajo."*

Aplicación web para **Hotel Salitre**, un boutique hotel costero para nómadas digitales y trabajadores remotos.

**Stack:** PHP puro · MySQL (PDO) · HTML5 · CSS3 · JavaScript vanilla · Sin frameworks.

---

## Estructura de carpetas

```
salitre/
├── client/                         # Sitio público
│   ├── index.php                   # Home
│   ├── espacios/                   # Catálogo y detalle
│   ├── carrito/                    # Flujo de reserva
│   ├── auth/                       # Login / Registro
│   ├── agenda/                     # Eventos del hotel
│   ├── proyecto/                   # Página "Acerca de"
│   └── includes/
│       ├── header.php              # CSS compartido + <head>
│       ├── nav.php                 # Navbar (sticky + hamburger)
│       ├── footer.php              # Scripts + cierre HTML
│       └── procesar_contacto.php   # ← movido a client/ raíz
│
├── admin/                          # Panel de gestión (URL directa)
│   ├── login.php
│   ├── index.php                   # Dashboard con stat-cards
│   ├── espacios/                   # CRUD habitaciones
│   ├── reservas/                   # Listado y detalle
│   ├── clientes/                   # Listado de huéspedes
│   ├── eventos/                    # CRUD agenda
│   └── includes/
│       ├── header.php              # shared CSS + admin/main.css
│       ├── sidebar.php             # Navegación lateral
│       ├── footer.php              # Cierre HTML
│       └── auth_check.php          # Guardia de sesión staff
│
├── assets/
│   ├── css/
│   │   ├── shared/
│   │   │   ├── variables.css       ⭐ ÚNICA fuente de verdad visual
│   │   │   └── reset.css           # Normalización cross-browser
│   │   ├── client/
│   │   │   ├── main.css            # Navbar, footer, botones, animaciones
│   │   │   ├── index.css           # Estilos específicos del Home
│   │   │   ├── espacios.css        # Catálogo y detalle de habitaciones
│   │   │   ├── carrito.css         # Flujo de reserva
│   │   │   └── auth.css            # Login / Registro
│   │   └── admin/
│   │       ├── main.css            # Entry point → @import dashboard.css
│   │       ├── dashboard.css       # Layout sidebar + stat-cards
│   │       └── crud.css            # Tablas y formularios CRUD
│   ├── js/
│   │   ├── shared/
│   │   │   └── animations.js       # Intersection Observer (fade-in scroll)
│   │   └── client/
│   │       ├── main.js             # Navbar sticky + Hamburger + Smooth scroll
│   │       ├── espacios.js         # Filtros catálogo
│   │       └── carrito.js          # Lógica del carrito
│   ├── img/
│   │   ├── logo/                   ← PENDIENTE (logo.svg, favicon.png)
│   │   ├── client/hero/            ← PENDIENTE
│   │   └── client/espacios/        ← PENDIENTE
│   └── video/
│       └── hero-bg.mp4             ← PENDIENTE
│
├── config/
│   ├── database.php                # función conectarDB() — PDO singleton
│   ├── constants.php               # BASE_URL, LIMPIEZA_FEE, IVA
│   └── functions.php
│
└── database/
    └── setup.sql                   # Schema completo de salitre_db
```

---

## Orden de carga de CSS (crítico)

Todo `<head>` del proyecto debe cargar en este orden exacto:

```html
<!-- 1. Variables — ÚNICA fuente de verdad -->
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/shared/variables.css">
<!-- 2. Reset (consume las variables) -->
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/shared/reset.css">
<!-- 3. CSS base del área (main.css client o admin) -->
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/client/main.css">
<!-- 4. CSS específico de la página (opcional) -->
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/client/index.css">
```

> ⚠️ **Regla de oro:** Ningún archivo CSS usa colores ni fuentes directamente. Todo usa variables de `variables.css`.

---

## Base de datos — `salitre_db`

| Tabla | Función |
|-------|---------|
| `clientes` | Huéspedes registrados en el sitio público |
| `staff` | Administradores del panel |
| `espacios` | Las 4 habitaciones del hotel |
| `reservas` | Solicitudes — estado `pendiente` por defecto |
| `eventos` | Agenda (yoga, surf, networking) |
| `contacto` | Mensajes del formulario público |

### Conexión

```php
require_once __DIR__ . '/config/database.php';
$pdo = conectarDB();  // PDO con ERRMODE_EXCEPTION + FETCH_ASSOC
```

### Los 4 espacios

| Nombre | Slug | Precio |
|--------|------|--------|
| Estudio Marea | `estudio-marea` | $89/noche |
| Loft Creativo | `loft-creativo` | $129/noche |
| Suite Salitre | `suite-salitre` | $149/noche |
| Villa Conexión | `villa-conexion` | $199/noche |

---

## Sistema de animaciones

```html
<!-- Animación simple (fade) -->
<div data-animate>...</div>

<!-- Con dirección -->
<div data-animate="fade-up">...</div>
<div data-animate="fade-left">...</div>
<div data-animate="fade-right">...</div>
<div data-animate="scale-up">...</div>

<!-- Delay escalonado (ms) -->
<div data-animate="fade-up" data-delay="0">...</div>
<div data-animate="fade-up" data-delay="100">...</div>
<div data-animate="fade-up" data-delay="200">...</div>
```

El observer añade `.is-visible` cuando el elemento entra al 15% del viewport. Para contenido cargado dinámicamente: `window.SalitreAnimations.init()`.

---

## Patrón de archivos PHP

```php
<?php
// 1. SESIÓN Y SEGURIDAD
session_start();
// En admin/: require_once '../includes/auth_check.php';

// 2. DEPENDENCIAS
require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/config/database.php';

// 3. LÓGICA Y QUERIES (antes de cualquier HTML)
$pdo   = conectarDB();
$datos = $pdo->query('SELECT ...');

// 4. VARIABLES DE PÁGINA
$page_title        = 'Título — Hotel Salitre';
$extra_stylesheets = ['assets/css/client/pagina.css'];

// 5. HTML
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/nav.php';
?>

<!-- HTML aquí -->

<?php require __DIR__ . '/includes/footer.php'; ?>
```

---

## Sesiones

### Huésped (cliente)
```php
$_SESSION['cliente_id']     // int
$_SESSION['cliente_nombre'] // string
```

### Staff (admin)
```php
$_SESSION['staff_id']     // int
$_SESSION['staff_nombre'] // string
```

Credenciales de prueba: `admin@salitre.mx` / `admin123`

---

## Acceso al admin

El panel no tiene enlace desde el sitio público. Acceso por URL directa:

```
http://localhost/salitre/admin/login.php
```

---

## Recursos pendientes

| Recurso | Ruta | Estado |
|---------|------|--------|
| Logo SVG | `assets/img/logo/logo.svg` | ⏳ Pendiente |
| Logo blanco | `assets/img/logo/logo-white.svg` | ⏳ Pendiente |
| Favicon | `assets/img/logo/favicon.png` | ⏳ Pendiente |
| Fotos espacios | `assets/img/client/espacios/*.webp` | ⏳ Pendiente |
| Foto hero | `assets/img/client/hero/` | ⏳ Pendiente |
| Vídeo hero | `assets/video/hero-bg.mp4` | ⏳ Pendiente |
