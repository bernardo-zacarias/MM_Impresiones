# 🚀 Guía de Despliegue en HostGator

## 📋 Requisitos Previos

- ✅ Cuenta de HostGator con soporte PHP 8.2+
- ✅ Acceso a cPanel
- ✅ Base de datos MySQL creada en cPanel
- ✅ Dominio configurado

---

## 🛠️ PASO 1: Preparar Archivos Localmente

### 1.1 Ejecutar Script de Preparación

```bash
cd /home/bernardo/Escritorio/MM_impresionesWeb/disenos-graficos
./prepare-hostgator.sh
```

Este script generará:
- `mm_impresiones.sql` - Base de datos
- `mm_impresiones_hostgator.zip` - Proyecto limpio
- `.env.production.example` - Configuración de ejemplo

Los archivos estarán en: `~/Escritorio/MM_Backup_YYYYMMDD_HHMMSS/`

---

## 📤 PASO 2: Subir Archivos a HostGator

### 2.1 Acceder a cPanel

1. Inicia sesión en tu cuenta de HostGator
2. Accede al cPanel

### 2.2 Subir Proyecto

**Opción A: File Manager (Recomendado para archivos grandes)**

1. En cPanel → **File Manager**
2. Navega a `public_html/` (o el directorio de tu dominio)
3. Clic en **Upload**
4. Sube `mm_impresiones_hostgator.zip`
5. Clic derecho en el archivo → **Extract**
6. Mueve el contenido de la carpeta `proyecto/` a la raíz

**Opción B: FTP**

1. Usa FileZilla o similar
2. Conecta a tu hosting
3. Sube el contenido de `proyecto/` a `public_html/`

### 2.3 Estructura Final

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          ← Este será tu document root
│   ├── index.php
│   ├── storage -> ../storage/app/public
│   └── ...
├── resources/
├── routes/
├── storage/
├── vendor/          (se creará después)
├── .env             (lo crearás después)
├── artisan
├── composer.json
└── ...
```

---

## 🗄️ PASO 3: Configurar Base de Datos

### 3.1 Crear Base de Datos en cPanel

1. cPanel → **MySQL® Databases**
2. **Create New Database**: `tu_usuario_mm_impresiones`
3. **Create New User**: `tu_usuario` con contraseña segura
4. **Add User To Database**: Asigna el usuario con **ALL PRIVILEGES**

### 3.2 Importar Base de Datos

1. cPanel → **phpMyAdmin**
2. Selecciona tu base de datos
3. Pestaña **Import**
4. Sube `mm_impresiones.sql`
5. Clic en **Go**

⚠️ **Si hay error de tamaño máximo:**
```bash
# Dividir archivo SQL
split -l 50000 mm_impresiones.sql parte_
# Importa parte_aa, luego parte_ab, etc.
```

---

## ⚙️ PASO 4: Configurar Archivo .env

### 4.1 Crear .env

1. En File Manager, navega a la raíz del proyecto
2. Copia `.env.production.example` → `.env`
3. Edita `.env` con tus datos:

```env
APP_NAME="MM Impresiones"
APP_ENV=production
APP_KEY=                           # Se generará después
APP_DEBUG=false
APP_TIMEZONE=America/Santiago
APP_URL=https://tudominio.com      # TU DOMINIO REAL

DB_CONNECTION=mysql
DB_HOST=localhost                   # Usualmente localhost en HostGator
DB_PORT=3306
DB_DATABASE=tu_usuario_mm_impresiones  # Nombre de tu BD
DB_USERNAME=tu_usuario                  # Usuario de BD
DB_PASSWORD=tu_password_real            # Contraseña de BD

# Gmail para emails
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD="xxxx xxxx xxxx xxxx"    # Contraseña de aplicación
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="MM Impresiones"

# Transbank (Empieza en INTEGRACIÓN)
TRANSBANK_API_KEY=597055555532
TRANSBANK_COMMERCE_CODE=597055555532
TRANSBANK_ENVIRONMENT=integration
```

---

## 🔧 PASO 5: Instalar Dependencias

### 5.1 Acceder a Terminal SSH

**Opción A: Terminal SSH de cPanel**
1. cPanel → **Terminal**

**Opción B: SSH Externo**
```bash
ssh tu_usuario@tudominio.com
cd public_html  # o tu directorio
```

### 5.2 Verificar Versión de PHP

```bash
php -v
```

Debe ser **PHP 8.2** o superior. Si no:

```bash
# En HostGator, usa:
/opt/alt/php82/usr/bin/php -v
# O configura en cPanel → Select PHP Version
```

### 5.3 Instalar Composer Dependencies

```bash
# Si composer está disponible globalmente
composer install --no-dev --optimize-autoloader

# Si no está disponible, usa:
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --optimize-autoloader
```

### 5.4 Comandos de Configuración

```bash
# Generar APP_KEY
php artisan key:generate

# Crear enlace simbólico de storage
php artisan storage:link

# Ejecutar migraciones (si no importaste BD completa)
php artisan migrate --force

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔐 PASO 6: Configurar Permisos

```bash
# Permisos de directorios
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Si usas suEXEC (común en HostGator):
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Dueño de archivos (si tienes acceso)
chown -R tu_usuario:tu_usuario storage bootstrap/cache
```

---

## 🌐 PASO 7: Configurar Document Root

### 7.1 Apuntar Dominio a /public

En cPanel → **Domains** → **Manage Domains**:

1. Selecciona tu dominio
2. Cambia **Document Root** a: `public_html/public`
3. Guarda cambios

**Estructura:**
```
public_html/              ← Raíz del proyecto
└── public/               ← Document root del dominio
    └── index.php         ← Punto de entrada
```

---

## 📧 PASO 8: Configurar Gmail

### 8.1 Generar Contraseña de Aplicación

1. Accede a tu cuenta Google
2. Seguridad → **Verificación en 2 pasos** (actívala si no está)
3. **Contraseñas de aplicaciones**
4. Genera una nueva para "Laravel"
5. Copia la contraseña (formato: `xxxx xxxx xxxx xxxx`)
6. Pégala en `.env` → `MAIL_PASSWORD`

### 8.2 Probar Envío de Email

```bash
php artisan tinker
Mail::raw('Test email from MM Impresiones', function($msg) {
    $msg->to('tu_email@gmail.com')->subject('Test');
});
exit
```

---

## 💳 PASO 9: Configurar Transbank (Integración)

### 9.1 Ambiente de Integración (Pruebas)

Ya está configurado en `.env`:
```env
TRANSBANK_API_KEY=597055555532
TRANSBANK_COMMERCE_CODE=597055555532
TRANSBANK_ENVIRONMENT=integration
```

### 9.2 Probar Transbank

1. Ve a tu sitio: `https://tudominio.com`
2. Crea una cuenta de usuario
3. Agrega productos al carrito
4. Procede al pago
5. Usa tarjeta de prueba:
   - **Número**: `4051 8842 3993 7763`
   - **CVV**: `123`
   - **Fecha**: Cualquier fecha futura

### 9.3 Verificar Logs

```bash
tail -f storage/logs/laravel.log
```

---

## 🔒 PASO 10: SSL/HTTPS (Obligatorio para Producción)

### 10.1 Instalar Certificado SSL

HostGator ofrece **SSL gratuito con Let's Encrypt**:

1. cPanel → **SSL/TLS Status**
2. Selecciona tu dominio
3. Clic en **Run AutoSSL**
4. Espera 5-10 minutos

### 10.2 Forzar HTTPS

Edita `public/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Forzar HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Redireccionar a public
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### 10.3 Actualizar .env

```env
APP_URL=https://tudominio.com  # Con HTTPS
```

Luego:
```bash
php artisan config:clear
php artisan config:cache
```

---

## ✅ PASO 11: Verificación Final

### 11.1 Checklist

- [ ] Sitio carga correctamente en `https://tudominio.com`
- [ ] Inicio de sesión funciona
- [ ] Registro de usuarios funciona
- [ ] Productos se muestran correctamente
- [ ] Carrito funciona
- [ ] Cotizador permite subir archivos
- [ ] Webpay redirige correctamente (prueba con tarjeta test)
- [ ] Emails se envían correctamente
- [ ] Panel de admin accesible
- [ ] Imágenes de productos se muestran

### 11.2 Comandos de Diagnóstico

```bash
# Ver configuración actual
php artisan config:show

# Ver rutas
php artisan route:list

# Ver logs en tiempo real
tail -f storage/logs/laravel.log

# Limpiar cache si hay problemas
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 🚨 PASO 12: Pasar a Producción Transbank

⚠️ **SOLO cuando hayas probado TODO en integración**

### 12.1 Solicitar Credenciales de Producción

1. Contacta a Transbank:
   - Email: **soporte@transbank.cl**
   - Teléfono: **600 638 6380**
   
2. Solicita credenciales de **Webpay Plus Producción**

3. Te enviarán:
   - `COMMERCE_CODE` de producción
   - `API_KEY` de producción

### 12.2 Actualizar .env para Producción

```env
TRANSBANK_API_KEY=tu_api_key_produccion
TRANSBANK_COMMERCE_CODE=tu_codigo_produccion
TRANSBANK_ENVIRONMENT=production
```

### 12.3 Limpiar Cache

```bash
php artisan config:clear
php artisan config:cache
```

### 12.4 Probar con Tarjeta Real

⚠️ **Usa tu propia tarjeta para una transacción de prueba pequeña**

---

## 🔧 Solución de Problemas Comunes

### Error 500 - Internal Server Error

```bash
# Ver logs
tail -n 50 storage/logs/laravel.log

# Verificar permisos
chmod -R 775 storage bootstrap/cache

# Limpiar cache
php artisan cache:clear
php artisan config:clear
```

### Página en Blanco

```env
# Habilita debug temporalmente
APP_DEBUG=true
```

Recarga el sitio, verás el error. **Desactiva después:**
```env
APP_DEBUG=false
```

### Imágenes No Cargan

```bash
# Recrear enlace simbólico
php artisan storage:link

# Verificar permisos
chmod -R 775 storage/app/public
```

### Composer No Instala

```bash
# Aumentar memoria
php -d memory_limit=512M composer.phar install --no-dev
```

### Base de Datos No Conecta

1. Verifica credenciales en `.env`
2. Verifica que el usuario tenga privilegios
3. Prueba conexión:
```bash
php artisan tinker
DB::connection()->getPdo();
```

---

## 📊 Monitoreo

### Logs de Aplicación
```bash
tail -f storage/logs/laravel.log
```

### Logs de Errores PHP (cPanel)
cPanel → **Errors** → **Error Log**

### Logs de Transbank
Revisa `storage/logs/laravel.log` para transacciones Webpay

---

## 🎯 Lista de Verificación Final

Antes de lanzar oficialmente:

- [ ] **Seguridad**
  - [ ] `APP_DEBUG=false`
  - [ ] `APP_ENV=production`
  - [ ] SSL activo (HTTPS)
  - [ ] Permisos correctos en storage/
  
- [ ] **Base de Datos**
  - [ ] Backup actualizado
  - [ ] Migraciones ejecutadas
  - [ ] Datos de prueba removidos (si aplica)
  
- [ ] **Email**
  - [ ] Emails de confirmación funcionan
  - [ ] Emails de pedidos funcionan
  
- [ ] **Pagos**
  - [ ] Transbank en ambiente correcto
  - [ ] URL de retorno correcta
  - [ ] Pruebas exitosas
  
- [ ] **Performance**
  - [ ] Cache de configuración activo
  - [ ] Cache de rutas activo
  - [ ] Cache de vistas activo
  
- [ ] **Contenido**
  - [ ] Productos cargados
  - [ ] Categorías creadas
  - [ ] Usuario admin creado

---

## 📞 Soporte

**HostGator:**
- Chat en vivo 24/7
- https://www.hostgator.com/contact

**Transbank:**
- Email: soporte@transbank.cl
- Teléfono: 600 638 6380

**Laravel:**
- Documentación: https://laravel.com/docs

---

## 🎉 ¡Listo!

Tu sistema MM Impresiones está ahora en producción.

**Próximos pasos recomendados:**
1. Configura backups automáticos de BD
2. Configura monitoreo de errores (Sentry, Bugsnag)
3. Implementa Google Analytics
4. Prueba exhaustivamente antes de publicitar

---

*Guía creada el 20 de noviembre de 2025*  
*Proyecto: MM Impresiones*  
*Desarrollador: Bernardo Zacarias*
