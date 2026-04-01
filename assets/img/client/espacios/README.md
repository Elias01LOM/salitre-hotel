# Recursos de Espacios -- Hotel Salitre

## Archivos requeridos

| Archivo | Formato | Dimensiones | Notas |
|---------|---------|-------------|-------|
| estudio-marea.webp | WebP | 1200x800px | Foto principal del Estudio Marea |
| loft-creativo.webp | WebP | 1200x800px | Foto principal del Loft Creativo |
| suite-salitre.webp | WebP | 1200x800px | Foto principal de la Suite Salitre |
| villa-conexion.webp | WebP | 1200x800px | Foto principal de la Villa Conexion |

## Galeria (opcional)

Cada espacio puede tener fotos adicionales para la galeria del detalle.
Nombrar como: [slug]-01.webp, [slug]-02.webp, etc.

## Referencia

- Documentacion Seccion 09.1 (Especificaciones de Imagenes)
- Formato WebP con fallback JPG
- Peso maximo: 150KB por imagen
- La columna foto_principal en la BD almacena la ruta relativa
- El usuario proporcionara estos recursos
- Mientras no existan, se muestra un placeholder gris con el nombre del espacio
