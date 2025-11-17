# 🚀 Guía de Despliegue a Producción - MM Impresiones

## 📋 CHECKLIST PRE-DESPLIEGUE

### 1. Contratar Servicios Necesarios

#### A) Transbank Webpay Plus
**¿Qué solicitar?**
- Webpay Plus (para pagos con tarjetas de crédito/débito)
- Modalidad: Normal (no necesitas Webpay Plus Mall a menos que tengas múltiples comercios)

**Documentos que te pedirán:**
- RUT de la empresa
- Certificado de vigencia de la empresa
- Datos bancarios (cuenta para recibir los pagos)
- Información del representante legal

**Lo que recibirás:**
- **Código de Comercio** (Commerce Code): Número único de 12 dígitos
- **API Key**: Cadena larga alfanumérica (clave secreta)
- Acceso al portal de Transbank para ver transacciones

**Costos aproximados:**
- Comisión por transacción: 2.95% - 3.49% (depende del volumen)
- Sin costo de implementación
- Sin mensualidad fija

#### B) Hosting / Servidor
**Opciones recomendadas:**

**Opción 1: VPS (Recomendado)**
- **DigitalOcean**: $6-12 USD/mes
- **Linode**: $5-10 USD/mes  
- **Vultr**: $6-12 USD/mes
- **Amazon Lightsail**: $5-10 USD/mes

**Opción 2: Hosting Compartido Chile**
- **SolucionHost**: Desde $5.990 CLP/mes
- **WebHosting**: Desde $4.990 CLP/mes
- **HostingPlus**: Desde $6.990 CLP/mes

**Requisitos mínimos del servidor:**
- PHP 8.2 o superior
- MySQL 8.0 o superior
- 2 GB RAM mínimo
- 20 GB almacenamiento
- Certificado SSL (Let's Encrypt gratis)
- Acceso SSH (para configuración)

#### C) Dominio
- Registrar en NIC Chile (.cl) o proveedor internacional
- Costo: ~$8.000-15.000 CLP/año para .cl
- Ejemplo: mmimpresiones.cl

#### D) Servicio de Emails (Opcional pero recomendado)
**Gratis (con límites):**
- Gmail SMTP: 500 emails/día
- SendGrid: 100 emails/día gratis

**De pago:**
- SendGrid: Desde $19.95 USD/mes (40,000 emails)
- Mailgun: $35 USD/mes (50,000 emails)
- Amazon SES: $0.10 por 1000 emails

---

## 🔐 CONFIGURACIÓN PASO A PASO

### PASO 1: Preparar el Proyecto Local

```bash
# 1. Limpiar cachés
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 2. Verificar que todo funciona en local
php artisan serve

# 3. Crear backup de la base de datos
php artisan db:seed  # Si necesitas datos de prueba
mysqldump -u root -p mm_impresiones > backup_antes_deploy.sql
```

### PASO 2: Subir el Código al Servidor

**Opción A: Usando Git (Recomendado)**

```bash
# En tu servidor (vía SSH)
cd /var/www/html
git clone https://github.com/bernardo-zacarias/MM_Impresiones.git
cd MM_Impresiones

# Instalar dependencias
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

**Opción B: Subir archivos por FTP/SFTP**
- Usa FileZilla o WinSCP
- Sube todos los archivos EXCEPTO:
  - `/node_modules`
  - `/vendor`
  - `/.env` (crearás uno nuevo)
  - `/storage/logs/*`

### PASO 3: Configurar el Archivo .env en Producción

```bash
# En el servidor
cp .env.production.example .env
nano .env  # o vim .env
```

**Configuración crítica:**

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.cl

# Base de datos de producción
DB_DATABASE=mm_impresiones_prod
DB_USERNAME=usuario_bd
DB_PASSWORD=password_segura

# Transbank PRODUCCIÓN
TRANSBANK_COMMERCE_CODE=123456789012  # Tu código real
TRANSBANK_API_KEY=ABC123...XYZ789      # Tu API Key real
TRANSBANK_ENVIRONMENT=production

# Emails
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-app-password
MAIL_FROM_ADDRESS=contacto@tu-dominio.cl
```

### PASO 4: Configurar Permisos y Base de Datos

```bash
# Generar nueva clave de aplicación
php artisan key:generate

# Configurar permisos
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Crear enlace simbólico para archivos públicos
php artisan storage:link

# Migrar base de datos
php artisan migrate --force

# (Opcional) Poblar con datos iniciales
php artisan db:seed --force
```

### PASO 5: Optimizar para Producción

```bash
# Cachear configuración
php artisan config:cache

# Cachear rutas
php artisan route:cache

# Cachear vistas
php artisan view:cache

# Optimización general
php artisan optimize
```

### PASO 6: Configurar el Servidor Web

**Para Apache (.htaccess ya incluido):**

```apache
<VirtualHost *:80>
    ServerName tu-dominio.cl
    ServerAlias www.tu-dominio.cl
    DocumentRoot /var/www/html/MM_Impresiones/public

    <Directory /var/www/html/MM_Impresiones/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/mmimpresiones-error.log
    CustomLog ${APACHE_LOG_DIR}/mmimpresiones-access.log combined
</VirtualHost>
```

**Para Nginx:**

```nginx
server {
    listen 80;
    server_name tu-dominio.cl www.tu-dominio.cl;
    root /var/www/html/MM_Impresiones/public;

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

### PASO 7: Instalar Certificado SSL (HTTPS)

```bash
# Instalar Certbot
sudo apt install certbot python3-certbot-apache  # Para Apache
# o
sudo apt install certbot python3-certbot-nginx   # Para Nginx

# Obtener certificado SSL gratis
sudo certbot --apache -d tu-dominio.cl -d www.tu-dominio.cl
# o
sudo certbot --nginx -d tu-dominio.cl -d www.tu-dominio.cl

# Renovación automática (ya viene configurada)
sudo certbot renew --dry-run
```

---

## 🧪 VERIFICACIÓN POST-DESPLIEGUE

### Checklist de Pruebas:

- [ ] La página principal carga correctamente (https://tu-dominio.cl)
- [ ] Puedes registrarte como cliente
- [ ] Puedes iniciar sesión
- [ ] El catálogo muestra productos con imágenes
- [ ] Puedes agregar productos al carrito
- [ ] El checkout funciona
- [ ] **PRUEBA DE PAGO REAL**: Haz una compra de $100 para probar
- [ ] Recibes el email de confirmación
- [ ] El administrador recibe el email de nuevo pedido
- [ ] Puedes acceder al panel de administración
- [ ] Los pedidos se muestran correctamente
- [ ] Puedes descargar archivos adjuntos

### Probar Transbank en Producción:

```
⚠️ IMPORTANTE: En producción ya NO usarás la tarjeta de prueba.
Debes hacer una compra REAL con tu tarjeta personal para verificar.

1. Compra algo por $500-1000 CLP
2. Verifica que te llegue el email
3. Revisa que el pedido aparezca en el panel admin
4. Verifica que el dinero llegue a tu cuenta (demora 2-3 días hábiles)
```

---

## 📊 MONITOREO Y MANTENIMIENTO

### Logs importantes:

```bash
# Ver errores de Laravel
tail -f storage/logs/laravel.log

# Ver errores del servidor
tail -f /var/log/apache2/error.log  # Apache
tail -f /var/log/nginx/error.log    # Nginx
```

### Backups Automáticos:

```bash
# Crear script de backup diario
# /root/backup-mmimpresiones.sh

#!/bin/bash
FECHA=$(date +%Y%m%d)
mysqldump -u usuario -ppassword mm_impresiones_prod > /backups/db_$FECHA.sql
tar -czf /backups/files_$FECHA.tar.gz /var/www/html/MM_Impresiones/storage/app/public
# Eliminar backups de más de 30 días
find /backups -name "*.sql" -mtime +30 -delete
find /backups -name "*.tar.gz" -mtime +30 -delete
```

```bash
# Agregar a crontab
crontab -e
# Agregar línea:
0 2 * * * /root/backup-mmimpresiones.sh
```

---

## 🆘 SOLUCIÓN DE PROBLEMAS COMUNES

### Error 500 - Internal Server Error
```bash
# Ver logs
cat storage/logs/laravel.log
# Verificar permisos
chmod -R 755 storage bootstrap/cache
# Limpiar cachés
php artisan cache:clear
php artisan config:clear
```

### Transbank no redirige correctamente
```bash
# Verificar que APP_URL esté correcto
grep APP_URL .env
# Debe ser: APP_URL=https://tu-dominio.cl (con HTTPS)

# Limpiar caché de config
php artisan config:clear
php artisan config:cache
```

### Imágenes no se muestran
```bash
# Verificar enlace simbólico
ls -la public/storage
# Si no existe:
php artisan storage:link
```

### Emails no se envían
```bash
# Verificar configuración
php artisan tinker
>>> config('mail')

# Probar envío
>>> Mail::raw('Test', function($m) { $m->to('tu@email.com')->subject('Test'); });
```

---

## 📞 CONTACTOS ÚTILES

- **Transbank Soporte**: 600 638 6380 | soporte@transbank.cl
- **Documentación Transbank**: https://www.transbankdevelopers.cl
- **Certificados SSL**: https://letsencrypt.org
- **Laravel Docs**: https://laravel.com/docs

---

## 💰 RESUMEN DE COSTOS MENSUALES ESTIMADOS

| Servicio | Costo Mensual |
|----------|---------------|
| Dominio .cl | ~$1.000 CLP (anual ÷ 12) |
| Hosting VPS | $6.000 - 15.000 CLP |
| Transbank | 2.95% por transacción |
| SSL | Gratis (Let's Encrypt) |
| Emails | Gratis (Gmail) o $20.000 CLP |
| **TOTAL** | **~$7.000 - 36.000 CLP/mes** |

---

## ✅ LISTO PARA PRODUCCIÓN

Una vez completados todos estos pasos:
- Tu sitio estará en HTTPS
- Los pagos funcionarán con Transbank real
- Los emails se enviarán correctamente
- Tendrás backups automáticos
- El sistema estará optimizado

**¡Éxito con MM Impresiones! 🎉**
