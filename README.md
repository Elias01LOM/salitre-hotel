HOTEL SALITRE
Boutique hotel costero para nomadas digitales
"Sal de la oficina. No del trabajo."

REQUISITOS

- XAMPP (Apache + MySQL/MariaDB)
- PHP 8.0 o superior
- Navegador moderno (Chrome, Firefox, Safari)

INSTALACION

1. Clonar repositorio en htdocs/salitre/
2. Importar database/schema.sql en phpMyAdmin
3. Importar database/seed.sql en phpMyAdmin
4. Configurar config/constants.php (BASE_URL segun entorno)
5. Acceder:
   - Cliente: http://localhost/salitre/client/index.php
   - Admin: http://localhost/salitre/admin/login.php

CREDENCIALES DE PRUEBA

Admin (Staff):
- Email: admin@salitre.mx
- Password: admin123

Cliente (ejemplo en seed.sql):
- Email: cliente@ejemplo.mx
- Password: cliente123

ESTRUCTURA DEL PROYECTO

salitre/
├── client/          Vista publica (huespedes)
├── admin/           Panel privado (staff)
├── assets/          CSS, JS, imagenes, video
├── config/          Configuracion y conexion BD
├── database/        Scripts SQL (schema + seed)
└── docs/            Documentacion tecnica

NOTAS IMPORTANTES

- Los recursos visuales (logo, imagenes de espacios, video hero) deben colocarse en sus carpetas respectivas
- Ver documentacion_salitre_universal.pdf para especificaciones completas
- Base de datos: salitre_db (utf8mb4, InnoDB)

STACK TECNOLOGICO

- PHP 8+ (puro, sin frameworks)
- MySQL/MariaDB con PDO y prepared statements
- HTML5, CSS3, JavaScript Vanilla
- XAMPP para entorno local
