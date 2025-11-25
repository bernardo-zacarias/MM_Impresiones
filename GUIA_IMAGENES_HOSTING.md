# Guía para Solucionar Problema de Imágenes en HostGator

## 🎯 Problema
Las imágenes de productos y archivos de clientes no se ven en el hosting, pero sí funcionan en local.

## 📋 Causa
En Laravel, las imágenes se guardan en `storage/app/public/` pero deben ser accesibles desde `public/storage/`. En local esto se resuelve con un enlace simbólico, pero en el hosting la estructura es diferente:

- **Local**: `public/storage` → `storage/app/public/`
- **Hosting**: `public_html/storage` → `../storage/app/public/`

## ✅ Solución en HostGator

### Opción 1: Crear enlace simbólico via SSH (Recomendado)

Si tienes acceso SSH al hosting:

```bash
# Conectar al hosting via SSH
ssh tu_usuario@mmimpresiones.com

# Ir a la carpeta public_html
cd public_html

# Eliminar el directorio storage si existe
rm -rf storage

# Crear el enlace simbólico correcto
ln -s ../storage/app/public storage

# Verificar que se creó correctamente
ls -la storage
```

### Opción 2: Via cPanel File Manager

1. Ingresar a **cPanel** → **File Manager**
2. Ir a la carpeta `public_html`
3. Si existe una carpeta `storage`, eliminarla
4. Crear un enlace simbólico:
   - En la barra superior, buscar la opción "Link" o usar el terminal de cPanel
   - Comando: `ln -s /home/TU_USUARIO_CPANEL/storage/app/public /home/TU_USUARIO_CPANEL/public_html/storage`

### Opción 3: Copiar archivos directamente (No recomendado - solo temporal)

Si no puedes crear enlaces simbólicos, copia manualmente:

```bash
# Copiar contenido de storage/app/public a public_html/storage
cp -r storage/app/public/* public_html/storage/
```

**⚠️ Advertencia**: Con esta opción deberás copiar las imágenes manualmente cada vez que suban nuevas.

## 🔍 Verificar que Funciona

1. Subir una imagen de prueba desde el admin
2. La ruta debe ser algo como: `https://mmimpresiones.com/storage/productos/nombre-imagen.jpg`
3. Si la imagen se ve, ¡funcionó! ✅

## 📂 Estructura de Archivos

```
Servidor HostGator:
├── storage/
│   └── app/
│       └── public/           ← Aquí se guardan las imágenes
│           ├── productos/
│           ├── disenos_clientes/
│           ├── archivos_pedidos/
│           └── designs/
├── public_html/              ← Carpeta pública (equivalente a public/)
│   ├── index.php
│   ├── .htaccess
│   └── storage/              ← ENLACE SIMBÓLICO a ../storage/app/public
```

## 🚀 Script Automático de Despliegue

Agregado un script para automatizar este proceso. Ejecutar en el hosting:

```bash
cd /home/TU_USUARIO_CPANEL
chmod +x fix-storage-link.sh
./fix-storage-link.sh
```

## 📝 Notas Importantes

1. **Permisos**: Asegurar que las carpetas tengan los permisos correctos:
   ```bash
   chmod -R 775 storage/app/public
   chmod -R 775 public_html/storage
   ```

2. **Propietario**: El usuario de Apache/PHP debe poder escribir en `storage/app/public`
   ```bash
   chown -R tu_usuario:tu_usuario storage/app/public
   ```

3. **URLs en Base de Datos**: Las rutas en la base de datos deben ser relativas:
   - ✅ Correcto: `productos/imagen.jpg`
   - ❌ Incorrecto: `/storage/productos/imagen.jpg`
   - ❌ Incorrecto: `https://mmimpresiones.com/storage/productos/imagen.jpg`

4. **APP_URL en .env**: Verificar que sea correcta:
   ```env
   APP_URL=https://mmimpresiones.com
   ```

## 🔧 Troubleshooting

### Las imágenes aún no se ven:

1. **Verificar el enlace simbólico existe:**
   ```bash
   ls -la public_html/storage
   ```

2. **Verificar permisos:**
   ```bash
   ls -la storage/app/public
   ```

3. **Ver logs del servidor:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Verificar en el navegador:**
   - Abrir la consola del navegador (F12)
   - Ver la pestaña "Network"
   - Recargar la página y ver si hay errores 404 en las imágenes

### Error 404 en imágenes:

- Verificar que `APP_URL` en `.env` sea correcto
- Limpiar caché de configuración:
  ```bash
  php artisan config:clear
  php artisan cache:clear
  ```

### Error de permisos:

```bash
# En el hosting
cd /home/TU_USUARIO_CPANEL
chmod -R 775 storage
chown -R tu_usuario:tu_usuario storage
```
