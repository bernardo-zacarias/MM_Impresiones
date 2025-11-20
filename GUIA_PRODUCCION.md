# 🚀 Guía de Despliegue a Producción

## ✅ Estado Actual

Tu aplicación está **100% lista** para producción. Todos los componentes funcionan correctamente:

- ✅ Sistema de carritos
- ✅ Cotizador
- ✅ Catálogo de productos
- ✅ Subida de archivos
- ✅ Integración con Webpay Plus (Transbank)
- ✅ Gestión de pedidos
- ✅ Panel de administración
- ✅ Sistema de usuarios con ubicaciones (región/ciudad/comuna)

---

## 📋 Pasos para Subir a Producción

### 1️⃣ **Preparar el Servidor**

#### Requisitos del Hosting:
- PHP 8.2 o superior
- MySQL 5.7 o superior
- Composer
- Node.js (para compilar assets)
- **SSL/HTTPS obligatorio** (para pagos con Transbank)
- Git (recomendado)

#### Extensiones PHP necesarias:
```bash
- php-mbstring
- php-xml
- php-gd
- php-curl
- php-zip
- php-mysql
- php-bcmath
```

---

### 2️⃣ **Subir el Código**

#### Opción A: Usando Git (Recomendado)
```bash
# En tu servidor, clona el repositorio
git clone https://github.com/bernardo-zacarias/MM_Impresiones.git
cd MM_Impresiones

# Cambiar a la rama correcta
git checkout improve/user-profile-edit
```

#### Opción B: Subir por FTP/SFTP
- Sube todos los archivos EXCEPTO:
  - `/node_modules/`
  - `/vendor/`
  - `/.env` (lo crearás en el servidor)

---

### 3️⃣ **Configurar el Entorno**

#### Instalar Dependencias:
```bash
# Instalar dependencias de PHP
composer install --optimize-autoloader --no-dev

# Instalar dependencias de Node
npm install

# Compilar assets para producción
npm run build
```

#### Crear archivo `.env`:
```bash
# Copiar el ejemplo
cp .env.example .env

# Editar con tus credenciales
nano .env
```

#### Configuración del `.env` de Producción:
```env
APP_NAME="MM Impresiones"
APP_ENV=production
APP_KEY=base64:TU_APP_KEY_GENERADA
APP_DEBUG=false
APP_URL=https://tu-dominio.cl

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña_segura

# 🚨 IMPORTANTE: Configuración de Transbank PRODUCCIÓN
TRANSBANK_ENVIRONMENT=production
TRANSBANK_COMMERCE_CODE=tu_codigo_comercio_real
TRANSBANK_API_KEY=tu_api_key_produccion_real

# Configuración de Email (Gmail, SendGrid, Mailgun, etc.)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_contraseña_aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="MM Impresiones"

# Session y Cache
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

# Otros
FILESYSTEM_DISK=public
```

#### Generar APP_KEY:
```bash
php artisan key:generate
```

---

### 4️⃣ **Configurar Base de Datos**

```bash
# Crear las tablas
php artisan migrate --force

# (Opcional) Crear usuario administrador
php artisan tinker
```

Dentro de tinker:
```php
$admin = new App\Models\User();
$admin->name = 'Admin';
$admin->email = 'admin@mmimpresiones.cl';
$admin->password = bcrypt('tu_contraseña_segura');
$admin->rol = 'admin';
$admin->telefono = '+56912345678';
$admin->region = 'Región Metropolitana';
$admin->ciudad = 'Santiago';
$admin->comuna = 'Santiago Centro';
$admin->direccion = 'Tu dirección';
$admin->email_verified_at = now();
$admin->save();
exit
```

---

### 5️⃣ **Configurar Permisos**

```bash
# Dar permisos de escritura a storage y bootstrap/cache
chmod -R 775 storage bootstrap/cache

# El usuario del servidor web debe ser dueño
chown -R www-data:www-data storage bootstrap/cache
```

---

### 6️⃣ **Crear Symlink de Storage**

```bash
php artisan storage:link
```

Esto crea un enlace simbólico desde `public/storage` a `storage/app/public` para que las imágenes sean accesibles.

---

### 7️⃣ **Configurar Servidor Web**

#### Apache (.htaccess ya incluido)
Asegúrate de que el DocumentRoot apunte a la carpeta `public/`:
```apache
DocumentRoot /ruta/a/tu/proyecto/public
```

#### Nginx (nginx.conf)
```nginx
server {
    listen 80;
    server_name tu-dominio.cl;
    root /ruta/a/tu/proyecto/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

### 8️⃣ **Optimizar para Producción**

```bash
# Cachear configuración
php artisan config:cache

# Cachear rutas
php artisan route:cache

# Cachear vistas
php artisan view:cache

# Optimizar autoload de Composer
composer dump-autoload --optimize
```

---

## 🔐 Configurar Transbank en Producción

### Paso 1: Obtener Credenciales de Producción

1. **Contacta a Transbank:**
   - Email: soporte@transbank.cl
   - Teléfono: +56 2 2661 9000
   - Portal: https://www.transbankdevelopers.cl/

2. **Documentos necesarios:**
   - RUT de tu empresa
   - Certificado de iniciación de actividades
   - Contrato de afiliación a Webpay Plus

3. **Te entregarán:**
   - Código de Comercio (Commerce Code)
   - API Key de Producción
   - Certificado SSL (si es necesario)

### Paso 2: Actualizar `.env`

```env
TRANSBANK_ENVIRONMENT=production
TRANSBANK_COMMERCE_CODE=597012345678  # Tu código real
TRANSBANK_API_KEY=579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C  # Tu key real
```

### Paso 3: Verificar HTTPS

⚠️ **CRÍTICO**: Transbank **EXIGE** que tu sitio tenga HTTPS en producción.

```bash
# Instalar Certbot para SSL gratuito con Let's Encrypt
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d tu-dominio.cl -d www.tu-dominio.cl
```

### Paso 4: Verificar URL de Callback

La URL de callback debe ser accesible públicamente:
```
https://tu-dominio.cl/transbank/callback
```

Transbank llamará a esta URL después de que el cliente pague.

---

## ✅ Checklist Final Pre-Producción

- [ ] **PHP 8.2+** instalado
- [ ] **MySQL** configurado y accesible
- [ ] **Composer** dependencias instaladas
- [ ] **Assets** compilados (npm run build)
- [ ] **.env** configurado correctamente
- [ ] **APP_KEY** generado
- [ ] **Migraciones** ejecutadas
- [ ] **Storage symlink** creado
- [ ] **Permisos** configurados (775 en storage)
- [ ] **SSL/HTTPS** activo y funcionando
- [ ] **Credenciales Transbank** de producción configuradas
- [ ] **Email SMTP** configurado y probado
- [ ] **Usuario admin** creado
- [ ] **Cachés** optimizados (config, route, view)
- [ ] **Backup** de base de datos configurado

---

## 🧪 Probar en Producción

### Test 1: Navegación Básica
- [ ] ✅ Página principal carga correctamente
- [ ] ✅ Login funciona
- [ ] ✅ Catálogo muestra productos
- [ ] ✅ Cotizador funciona

### Test 2: Flujo de Compra Completo
- [ ] ✅ Agregar producto al carrito
- [ ] ✅ Ver carrito con productos
- [ ] ✅ Iniciar pago (redirección a Transbank)
- [ ] ✅ Completar pago con tarjeta REAL
- [ ] ✅ Callback recibe confirmación
- [ ] ✅ Pedido cambia a "pagado"
- [ ] ✅ Emails se envían correctamente

### Test 3: Panel de Administración
- [ ] ✅ Login como admin
- [ ] ✅ Ver lista de pedidos
- [ ] ✅ Ver detalles de pedido
- [ ] ✅ Cambiar estado de pedido
- [ ] ✅ Gestionar productos
- [ ] ✅ Gestionar usuarios

---

## 🔧 Mantenimiento Post-Producción

### Monitoreo de Logs
```bash
# Ver últimos errores
tail -f storage/logs/laravel.log

# Ver errores de Transbank
tail -f storage/logs/laravel.log | grep Transbank
```

### Backups Automáticos
```bash
# Crear script de backup diario
nano /home/backup.sh
```

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u usuario -p'contraseña' base_datos > /backups/db_$DATE.sql
tar -czf /backups/files_$DATE.tar.gz /ruta/proyecto/storage/app/public
```

### Actualizaciones
```bash
# Actualizar código
git pull origin improve/user-profile-edit

# Actualizar dependencias
composer update --no-dev

# Migrar base de datos
php artisan migrate --force

# Limpiar y recrear cachés
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ⚠️ Problemas Comunes y Soluciones

### Error: "500 Internal Server Error"
```bash
# Revisar logs
tail -f storage/logs/laravel.log

# Verificar permisos
chmod -R 775 storage bootstrap/cache
```

### Error: "No application encryption key"
```bash
php artisan key:generate
```

### Imágenes no se muestran
```bash
# Recrear symlink
rm public/storage
php artisan storage:link
```

### Transbank devuelve error
```bash
# Verificar:
1. Credenciales correctas en .env
2. TRANSBANK_ENVIRONMENT=production
3. HTTPS activo
4. URL de callback accesible
```

---

## 📞 Soporte

### Transbank
- Teléfono: +56 2 2661 9000
- Email: soporte@transbank.cl
- Portal: https://www.transbankdevelopers.cl/

### Laravel
- Documentación: https://laravel.com/docs
- Comunidad: https://laracasts.com

---

**Fecha:** 20 de noviembre de 2025  
**Versión:** 1.0  
**Proyecto:** MM Impresiones - Sistema de Pedidos Online
