# 🎯 Pasos para Solucionar Imágenes en el Hosting - MM Impresiones

## ✅ ¿Qué se ha hecho?

1. ✅ Configurado Git y el repositorio está actualizado en GitHub
2. ✅ Creada la guía completa: `GUIA_IMAGENES_HOSTING.md`
3. ✅ Creado el script automático: `fix-storage-link.sh`
4. ✅ Mejorado `.gitignore` para no subir imágenes de clientes
5. ✅ Agregada documentación de Git: `GUIA_GIT.md`

## 🔧 Pasos para Aplicar en el Hosting

### Opción 1: Via SSH (Recomendado) ⭐

Si tienes acceso SSH a tu hosting de HostGator:

```bash
# 1. Conectar al hosting
ssh tu_usuario@mmimpresiones.com

# 2. Ir a la carpeta del proyecto
cd ~/proyecto

# 3. Descargar los últimos cambios desde GitHub
git pull origin improve/user-profile-edit

# 4. Ejecutar el script de fix
chmod +x fix-storage-link.sh
./fix-storage-link.sh

# 5. Verificar que funcionó
ls -la public_html/storage
# Debería mostrar un enlace simbólico a ../storage/app/public

# 6. Limpiar caché de Laravel
php artisan config:clear
php artisan cache:clear
```

### Opción 2: Via cPanel (Sin SSH)

1. **Subir archivos actualizados**:
   - Usa FileZilla o el File Manager de cPanel
   - Sube la carpeta completa del proyecto al servidor
   - Copia el contenido de `public/` a `public_html/`

2. **Crear enlace simbólico manualmente**:
   - En cPanel, ir a **File Manager**
   - Abrir el Terminal de cPanel
   - Ejecutar:
   ```bash
   cd /home/TU_USUARIO_CPANEL/public_html
   rm -rf storage
   ln -s ../storage/app/public storage
   ls -la storage
   ```

3. **Verificar permisos**:
   ```bash
   chmod -R 775 storage/app/public
   ```

### Opción 3: Copiar Manualmente (Temporal)

Si no puedes crear enlaces simbólicos:

```bash
# En el hosting
cp -r storage/app/public/* public_html/storage/
chmod -R 775 public_html/storage
```

⚠️ **Advertencia**: Con esta opción deberás copiar las imágenes cada vez que se suban nuevas.

## 🔍 Verificar que Funciona

1. Subir una imagen de prueba desde el admin:
   - Ve a: https://mmimpresiones.com/admin/productos
   - Crea o edita un producto
   - Sube una imagen

2. Verificar que la URL funciona:
   - La imagen debería verse en: `https://mmimpresiones.com/storage/productos/nombre-imagen.jpg`

3. Revisar la página principal:
   - Las imágenes de productos deberían mostrarse correctamente

## 🐛 Si Aún No Funciona

### Revisar Logs
```bash
# En el hosting
tail -f storage/logs/laravel.log
```

### Verificar APP_URL en .env
```bash
# Debe ser:
APP_URL=https://mmimpresiones.com
```

### Limpiar Caché
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Verificar Permisos
```bash
ls -la storage/app/public
ls -la public_html/storage
# Ambas deben tener permisos 775
```

### Verificar en el Navegador
1. Abrir Consola del Navegador (F12)
2. Ir a la pestaña "Network"
3. Recargar la página
4. Ver si hay errores 404 en las imágenes
5. Revisar la URL completa de las imágenes

## 📚 Documentación Adicional

- **GUIA_IMAGENES_HOSTING.md** - Guía completa con troubleshooting
- **GUIA_GIT.md** - Cómo trabajar con Git en el proyecto
- **DESPLIEGUE_HOSTGATOR.md** - Instrucciones de despliegue completo

## 💡 Comandos Git Útiles

```bash
# Ver estado
git status

# Ver cambios
git log --oneline -5

# Actualizar desde GitHub
git pull origin improve/user-profile-edit

# Subir cambios
git add .
git commit -m "Descripción del cambio"
git push origin improve/user-profile-edit
```

## 🎓 Próximos Pasos Recomendados

1. ✅ **Aplicar la solución de imágenes en el hosting**
2. ✅ **Verificar que todo funciona correctamente**
3. 📝 **Familiarizarte con Git usando GUIA_GIT.md**
4. 🔄 **Hacer commits regulares de tus cambios**
5. 🚀 **Cuando todo esté estable, fusionar a la rama main**

## 🆘 ¿Necesitas Ayuda?

Si algo no funciona:
1. Revisar `GUIA_IMAGENES_HOSTING.md` - Sección "Troubleshooting"
2. Verificar los logs del servidor
3. Revisar los permisos de las carpetas
4. Asegurarte de que el enlace simbólico existe

---

**¡Éxito! 🚀**

Una vez que funcionen las imágenes, el proyecto estará 100% operativo en producción.
