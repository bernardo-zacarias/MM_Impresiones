# 📁 Guía de Imágenes del Sitio

## 🗂️ Estructura de Carpetas

```
public/images/
├── assets/          → Logo y recursos corporativos
├── banners/         → Banners y fondos del home y welcome
├── site/            → Imágenes generales del sitio
└── productos/       → Imágenes de productos (creado automáticamente)
```

---

## 🖼️ Cómo Cambiar las Imágenes

### Método 1: Reemplazar el archivo directamente (Más fácil)

1. **Para cambiar el fondo del HOME:**
   - Sube tu imagen a: `public/images/banners/home-bg.png`
   - Formato: PNG (recomendado), JPG o WebP
   - Tamaño recomendado: 1920x1080px

2. **Para cambiar el banner del HOME:**
   - Sube tu imagen a: `public/images/banners/home-banner.png`
   - Formato: PNG (recomendado) o JPG
   - Tamaño recomendado: 1200x600px

3. **Para cambiar el logo:**
   - Sube tu imagen a: `public/images/assets/logo.png`
   - Formato: PNG con fondo transparente
   - Tamaño recomendado: 300x100px

### Método 2: Usar nombres personalizados

Si quieres usar un nombre diferente de archivo:

1. Edita el archivo `.env` y agrega:

```env
# Imágenes del sitio
HOME_BACKGROUND=/images/banners/mi-fondo-personalizado.png
HOME_BANNER=/images/banners/mi-banner.png
SITE_LOGO=/images/assets/mi-logo.png
```

2. Sube tus archivos con esos nombres

3. Limpia la caché:
```bash
php artisan config:clear
php artisan config:cache
```

---

## 📸 Tamaños Recomendados

| Tipo de Imagen | Tamaño Recomendado | Formato | Peso Máximo |
|----------------|-------------------|---------|-------------|
| Logo | 300x100px | PNG | 100 KB |
| Fondo Home | 1920x1080px | JPG/WebP | 500 KB |
| Banner Home | 1200x600px | JPG/PNG | 300 KB |
| Banner Welcome | 1920x600px | JPG/WebP | 500 KB |
| Producto | 800x800px | JPG/PNG | 200 KB |

---

## 🚀 Subir Imágenes en Producción (HostGator)

### Opción A: Usando cPanel File Manager

1. Ingresa a cPanel
2. Ve a "Administrador de archivos"
3. Navega a: `public_html/images/banners/`
4. Haz clic en "Subir"
5. Selecciona tu imagen
6. Renombra el archivo si es necesario

### Opción B: Usando FTP (FileZilla)

1. Conecta con FileZilla
2. Navega a: `/public_html/images/banners/`
3. Arrastra tu imagen desde tu PC
4. Listo!

---

## 🔄 Aplicar Cambios

Después de subir nuevas imágenes:

```bash
# Limpiar caché (en Terminal de cPanel o SSH)
cd ~/laravel_app/disenos-graficos
php artisan cache:clear
php artisan view:clear
```

O simplemente recarga la página con `Ctrl+F5` (refresco forzado)

---

## ⚙️ Configuración Avanzada

Si necesitas más control, edita el archivo:
`config/images.php`

Ejemplo para agregar una nueva imagen:

```php
// En config/images.php
'mi_nueva_imagen' => env('MI_IMAGEN', '/images/site/default.jpg'),
```

Luego úsala en cualquier vista con:

```php
<img src="{{ asset(config('images.mi_nueva_imagen')) }}" alt="Mi imagen">
```

---

## 🎨 Optimizar Imágenes (Antes de Subir)

**Herramientas gratuitas:**
- https://tinypng.com - Comprime PNG y JPG
- https://squoosh.app - Comprime y convierte a WebP
- https://imagecompressor.com - Compresor online

**Tips:**
- Usa formato WebP para menor peso
- Comprime las imágenes al 80-85% de calidad
- Redimensiona al tamaño exacto que necesitas

---

## 📝 Lista de Verificación

Antes de subir una imagen:

- [ ] ¿El tamaño es el recomendado?
- [ ] ¿El peso es menor a 500 KB?
- [ ] ¿El nombre es correcto o está configurado en .env?
- [ ] ¿La imagen tiene buena resolución?
- [ ] ¿Está optimizada/comprimida?

---

## 🆘 Problemas Comunes

### La imagen no se muestra

1. Verifica que el archivo exista en la ruta correcta
2. Verifica permisos: `chmod 755 public/images -R`
3. Limpia caché: `php artisan cache:clear`
4. Refresca el navegador con Ctrl+F5

### La imagen se ve pixelada

- Sube una imagen de mayor resolución
- Usa al menos el doble de tamaño para pantallas Retina

### La página carga lento

- Comprime las imágenes más
- Usa formato WebP
- Reduce el tamaño de archivo

---

¡Listo! Ahora puedes personalizar fácilmente todas las imágenes del sitio. 🎨✨
