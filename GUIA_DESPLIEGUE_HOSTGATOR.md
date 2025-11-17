# 🚀 Guía de Despliegue en HostGator (cPanel) - MM Impresiones

## 📋 INFORMACIÓN DEL PROYECTO
- **Dominio**: mmimpresiones.com
- **Hosting**: HostGator cPanel (Compartido)
- **Framework**: Laravel 12
- **Situación**: Reemplazar página actual por nueva versión

---

## ⚠️ IMPORTANTE: ANTES DE EMPEZAR

### 1. Hacer Backup de la Página Actual
```
1. Entrar a cPanel (mmimpresiones.com/cpanel)
2. Ir a "Administrador de archivos" (File Manager)
3. Seleccionar la carpeta public_html
4. Clic en "Comprimir" y descargar el archivo .zip
5. En "Bases de datos MySQL" → phpMyAdmin
6. Exportar la base de datos actual
7. Guardar ambos backups en tu computadora
```

### 2. Verificar Requisitos del Hosting
```
En cPanel, verifica:
- PHP Version: Debe ser 8.2 o superior
  (En "Selector de versión de PHP" o "MultiPHP Manager")
- MySQL: 5.7 o superior
- Extensiones PHP necesarias:
  ✓ BCMath
  ✓ Ctype
  ✓ JSON
  ✓ Mbstring
  ✓ OpenSSL
  ✓ PDO
  ✓ Tokenizer
  ✓ XML
```

---

## 🔧 PASO 1: PREPARAR EL PROYECTO LOCALMENTE

### 1.1 Actualizar el archivo .env con datos de producción

```bash
# En tu computadora, edita el archivo .env
nano .env
```

Cambia estas líneas:

```env
APP_NAME="MM Impresiones"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://mmimpresiones.com

# Base de datos (usa los datos que te da HostGator)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nombre_base_datos_hostgator
DB_USERNAME=usuario_base_datos
DB_PASSWORD=contraseña_base_datos

# Transbank (cuando tengas las credenciales)
TRANSBANK_COMMERCE_CODE=tu_codigo_comercio
TRANSBANK_API_KEY=tu_api_key
TRANSBANK_ENVIRONMENT=production

# Emails (usar el email de tu dominio)
MAIL_MAILER=smtp
MAIL_HOST=mail.mmimpresiones.com
MAIL_PORT=587
MAIL_USERNAME=contacto@mmimpresiones.com
MAIL_PASSWORD=tu_password_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contacto@mmimpresiones.com
MAIL_FROM_NAME="MM Impresiones"
```

### 1.2 Optimizar el proyecto

```bash
# Limpiar cachés de desarrollo
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Instalar dependencias de producción
composer install --optimize-autoloader --no-dev

# (Opcional) Compilar assets si usas npm/vite
npm install
npm run build
```

### 1.3 Crear archivo ZIP del proyecto

```bash
# En Linux/Mac
cd /home/bernardo/Escritorio/MM_impresionesWeb/
zip -r disenos-graficos.zip disenos-graficos/ -x "disenos-graficos/node_modules/*" "disenos-graficos/vendor/*" "disenos-graficos/.git/*" "disenos-graficos/storage/logs/*"

# O usa tu gestor de archivos para crear un ZIP excluyendo:
# - node_modules/
# - vendor/
# - .git/
# - storage/logs/
```

---

## 📤 PASO 2: SUBIR EL PROYECTO A HOSTGATOR

### 2.1 Acceder a cPanel

1. Ve a: `https://mmimpresiones.com:2083` o `https://tu-servidor.hostgator.com/cpanel`
2. Ingresa con tu usuario y contraseña de cPanel

### 2.2 Limpiar public_html actual (DESPUÉS DEL BACKUP)

1. En cPanel → "Administrador de archivos" (File Manager)
2. Navega a `public_html`
3. **Selecciona TODO** y elimina (o mueve a una carpeta backup_old)
4. Crea una carpeta nueva llamada `laravel_app` en el directorio raíz (mismo nivel que public_html)

### 2.3 Subir el proyecto

**Opción A: Usando el Administrador de Archivos de cPanel**

1. En "Administrador de archivos", navega a la carpeta `laravel_app`
2. Clic en "Subir" (Upload)
3. Selecciona el archivo `disenos-graficos.zip`
4. Espera a que termine la subida
5. Clic derecho en el archivo ZIP → "Extraer" (Extract)
6. Elimina el archivo ZIP después de extraer

**Opción B: Usando FTP (FileZilla)**

1. Descargar FileZilla: https://filezilla-project.org/
2. Conectar con estos datos:
   - Host: ftp.mmimpresiones.com
   - Usuario: tu usuario de cPanel
   - Contraseña: tu contraseña de cPanel
   - Puerto: 21
3. Subir todos los archivos del proyecto a `/laravel_app/`

### 2.4 Instalar dependencias de Composer

HostGator normalmente tiene Composer instalado. Usa el Terminal de cPanel:

1. En cPanel → "Terminal" o "SSH Access"
2. Ejecutar:

```bash
cd laravel_app/disenos-graficos
composer install --optimize-autoloader --no-dev
```

Si no tienes acceso a Terminal, puedes:
- Subir la carpeta `vendor` completa desde tu local (será más pesado)

---

## 🗄️ PASO 3: CONFIGURAR LA BASE DE DATOS

### 3.1 Crear Base de Datos MySQL

1. En cPanel → "Bases de datos MySQL" (MySQL Databases)
2. Crear nueva base de datos:
   - Nombre: `mmimp_produccion` (cPanel agregará un prefijo automático)
3. Crear nuevo usuario:
   - Usuario: `mmimp_admin`
   - Contraseña: (genera una segura)
4. Agregar usuario a la base de datos:
   - Selecciona el usuario y la base de datos
   - Marca "TODOS LOS PRIVILEGIOS"

### 3.2 Actualizar .env en el servidor

1. En "Administrador de archivos", navega a:
   `/laravel_app/disenos-graficos/.env`
2. Edita el archivo con los datos reales de la base de datos:

```env
DB_DATABASE=nombredeusuario_mmimp_produccion
DB_USERNAME=nombredeusuario_mmimp_admin
DB_PASSWORD=la_contraseña_que_creaste
```

### 3.3 Migrar la base de datos

En Terminal de cPanel:

```bash
cd laravel_app/disenos-graficos
php artisan migrate --force
php artisan db:seed --force  # Solo si tienes seeders
```

O si prefieres, importa un dump SQL:
1. cPanel → phpMyAdmin
2. Selecciona tu base de datos
3. Pestaña "Importar"
4. Selecciona el archivo backup_antes_deploy.sql (si tienes datos que migrar)

---

## 🔗 PASO 4: CONFIGURAR EL DOMINIO

### 4.1 Redirigir public_html a la carpeta public de Laravel

Tienes 2 opciones:

**Opción A: Usando enlace simbólico (Recomendado)**

En Terminal de cPanel:

```bash
# Eliminar public_html vacío
rm -rf ~/public_html

# Crear enlace simbólico
ln -s ~/laravel_app/disenos-graficos/public ~/public_html
```

**Opción B: Copiar contenido de public/**

1. Copia TODO el contenido de `/laravel_app/disenos-graficos/public/`
2. Pégalo en `/public_html/`
3. Edita `public_html/index.php`:

```php
<?php

// Cambia estas líneas:
require __DIR__.'/../laravel_app/disenos-graficos/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel_app/disenos-graficos/bootstrap/app.php';

// Resto del código igual...
```

### 4.2 Configurar permisos

En Terminal de cPanel:

```bash
cd ~/laravel_app/disenos-graficos
chmod -R 755 storage bootstrap/cache
```

### 4.3 Crear enlace de storage

```bash
cd ~/laravel_app/disenos-graficos
php artisan storage:link
```

---

## 🔐 PASO 5: CONFIGURAR SSL (HTTPS)

### 5.1 Activar SSL gratuito de HostGator

1. En cPanel → "SSL/TLS Status" o "Let's Encrypt™ SSL"
2. Selecciona tu dominio `mmimpresiones.com`
3. Clic en "Run AutoSSL"
4. Espera 5-10 minutos

### 5.2 Forzar HTTPS

Edita o crea el archivo `.htaccess` en `public_html/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Forzar HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Resto de reglas de Laravel
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

## ⚡ PASO 6: OPTIMIZAR PARA PRODUCCIÓN

En Terminal de cPanel:

```bash
cd ~/laravel_app/disenos-graficos

# Generar clave de aplicación (si no la tienes)
php artisan key:generate

# Cachear configuración
php artisan config:cache

# Cachear rutas
php artisan route:cache

# Cachear vistas
php artisan view:cache

# Optimización general
php artisan optimize
```

---

## 📧 PASO 7: CONFIGURAR EMAIL

### 7.1 Crear cuenta de email en cPanel

1. cPanel → "Cuentas de correo" (Email Accounts)
2. Crear nueva cuenta:
   - Email: `contacto@mmimpresiones.com`
   - Contraseña: (genera una segura)

### 7.2 Configurar en .env

Edita `/laravel_app/disenos-graficos/.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.mmimpresiones.com
MAIL_PORT=587
MAIL_USERNAME=contacto@mmimpresiones.com
MAIL_PASSWORD=la_contraseña_del_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contacto@mmimpresiones.com
MAIL_FROM_NAME="MM Impresiones"
```

### 7.3 Probar envío de email

En Terminal:

```bash
php artisan tinker
>>> Mail::raw('Test desde producción', function($m) { $m->to('tu-email-personal@gmail.com')->subject('Test MM Impresiones'); });
```

---

## ✅ PASO 8: VERIFICAR QUE TODO FUNCIONA

### Checklist de pruebas:

1. [ ] Visita `https://mmimpresiones.com` - ¿Carga la página principal?
2. [ ] ¿El SSL funciona? (candado verde en el navegador)
3. [ ] ¿Se muestran las imágenes de productos?
4. [ ] Registra un usuario nuevo
5. [ ] Inicia sesión
6. [ ] Agrega productos al carrito
7. [ ] Haz checkout (aún sin pagar si no tienes Transbank)
8. [ ] Accede al panel admin (`https://mmimpresiones.com/administracion`)
9. [ ] ¿Se envían los emails?

### Si algo no funciona:

**Ver errores:**
```bash
# En Terminal de cPanel
cd ~/laravel_app/disenos-graficos
tail -50 storage/logs/laravel.log
```

**Limpiar cachés:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 🔄 PASO 9: CONFIGURAR TRANSBANK (Cuando tengas credenciales)

### 9.1 Actualizar .env

```env
TRANSBANK_COMMERCE_CODE=123456789012
TRANSBANK_API_KEY=ABC123...XYZ789
TRANSBANK_ENVIRONMENT=production
```

### 9.2 Limpiar caché

```bash
php artisan config:clear
php artisan config:cache
```

### 9.3 Probar con una compra real

Haz una compra de $500 CLP para verificar que todo funcione.

---

## 🎯 COMANDOS ÚTILES PARA MANTENIMIENTO

```bash
# Conectar por SSH a HostGator
ssh usuario@mmimpresiones.com -p 2222

# Ver logs en tiempo real
tail -f ~/laravel_app/disenos-graficos/storage/logs/laravel.log

# Limpiar cachés cuando hagas cambios
cd ~/laravel_app/disenos-graficos
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Actualizar el proyecto (después de hacer cambios)
# 1. Sube los archivos modificados por FTP
# 2. Ejecuta:
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📞 SOPORTE HOSTGATOR

- **Teléfono**: 1-866-96-GATOR (1-866-964-2867)
- **Chat**: Disponible en el panel de cPanel
- **Tickets**: A través de tu portal de cliente

---

## 🚨 SOLUCIÓN DE PROBLEMAS COMUNES

### Error 500 - Internal Server Error

```bash
# Ver el error real
cat ~/laravel_app/disenos-graficos/storage/logs/laravel.log

# Verificar permisos
chmod -R 755 ~/laravel_app/disenos-graficos/storage
chmod -R 755 ~/laravel_app/disenos-graficos/bootstrap/cache

# Limpiar cachés
php artisan config:clear
php artisan cache:clear
```

### "Base de datos no encontrada"

- Verifica que el nombre de la base de datos en `.env` incluya el prefijo de cPanel
- Ejemplo: Si tu usuario es `mmimp123`, la BD será `mmimp123_produccion`

### Imágenes no se muestran

```bash
# Verificar enlace simbólico
ls -la ~/public_html/storage

# Si no existe:
cd ~/laravel_app/disenos-graficos
php artisan storage:link
```

### Composer no funciona

Si no tienes acceso a Terminal o Composer:
1. En tu PC local, ejecuta: `composer install --no-dev`
2. Sube la carpeta `vendor` completa vía FTP a `/laravel_app/disenos-graficos/`

---

## ✅ LISTO!

Tu página estará en línea en `https://mmimpresiones.com` con:
- ✅ SSL activado (HTTPS)
- ✅ Base de datos funcionando
- ✅ Sistema de emails configurado
- ✅ Listo para recibir pagos cuando configures Transbank

**¡Éxito con el despliegue! 🎉**
