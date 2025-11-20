# 📧 Guía de Configuración de Correo Electrónico

## Opciones Disponibles

### 1. **CORREO CORPORATIVO EN HOSTGATOR** (Recomendado) ✅

HostGator incluye cuentas de correo corporativo con tu hosting. Es la opción más profesional.

#### Paso 1: Crear la cuenta de correo en cPanel

1. Ingresa a tu **cPanel de HostGator**
2. Busca la sección **"Email"** → **"Cuentas de correo"** o **"Email Accounts"**
3. Haz clic en **"Crear"** o **"Create"**
4. Completa:
   - **Email**: `noreply@mmimpresiones.com` (para notificaciones automáticas)
   - O también: `pedidos@mmimpresiones.com` (para pedidos)
   - **Contraseña**: Una contraseña segura
   - **Almacenamiento**: 250 MB es suficiente para correos transaccionales
5. Haz clic en **"Crear cuenta"**

#### Paso 2: Obtener configuración SMTP

En cPanel, ve a **"Email Accounts"** → Busca tu cuenta → Clic en **"Conectar dispositivos"** o **"Connect Devices"**

Verás algo como:

```
Servidor de correo entrante (IMAP):
- Host: mail.mmimpresiones.com
- Puerto: 993
- Seguridad: SSL/TLS

Servidor de correo saliente (SMTP):
- Host: mail.mmimpresiones.com
- Puerto: 465 (SSL) o 587 (TLS)
- Seguridad: SSL/TLS
- Autenticación: Requerida
```

#### Paso 3: Configurar en Laravel (.env)

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.mmimpresiones.com
MAIL_PORT=465
MAIL_USERNAME=noreply@mmimpresiones.com
MAIL_PASSWORD=tu_contraseña_segura
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@mmimpresiones.com
MAIL_FROM_NAME="MM Impresiones"
```

**Nota**: Si el puerto 465 no funciona, intenta con:
```env
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

---

### 2. **GMAIL SMTP** (Alternativa Rápida)

Si quieres usar tu Gmail personal o de negocio:

#### Paso 1: Habilitar "Contraseñas de aplicación"

1. Ve a tu cuenta de Google → **Seguridad**
2. Activa la **verificación en 2 pasos** (si no está activa)
3. Busca **"Contraseñas de aplicaciones"**
4. Genera una contraseña para "Correo" en "Otro dispositivo"
5. Copia la contraseña de 16 caracteres

#### Paso 2: Configurar en Laravel (.env)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx  # La contraseña de aplicación generada
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="MM Impresiones"
```

**Limitaciones de Gmail**:
- Límite de 500 correos por día
- Puede que algunos correos caigan en spam
- Menos profesional (aparece tu @gmail.com)

---

### 3. **MAILTRAP** (Solo para Desarrollo/Pruebas) 🧪

Perfecto para probar correos sin enviarlos realmente:

1. Crea una cuenta gratuita en https://mailtrap.io
2. Ve a tu bandeja de prueba
3. Copia las credenciales SMTP

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_usuario_mailtrap
MAIL_PASSWORD=tu_password_mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=test@mmimpresiones.com
MAIL_FROM_NAME="MM Impresiones"
```

**Uso**: Solo para desarrollo. Los correos no salen, solo los ves en Mailtrap.

---

### 4. **MAILGUN** (Para Volumen Alto) 💪

Servicio profesional de envío de correos masivos:

1. Crea cuenta en https://www.mailgun.com
2. Verifica tu dominio (requiere configurar DNS)
3. Obtén tu API Key

```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=mg.mmimpresiones.com
MAILGUN_SECRET=tu_api_key_de_mailgun
MAIL_FROM_ADDRESS=noreply@mmimpresiones.com
MAIL_FROM_NAME="MM Impresiones"
```

---

## 📋 Recomendación para MM Impresiones

### Para Producción (HostGator):
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.mmimpresiones.com
MAIL_PORT=465
MAIL_USERNAME=pedidos@mmimpresiones.com
MAIL_PASSWORD=contraseña_segura_aqui
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=pedidos@mmimpresiones.com
MAIL_FROM_NAME="MM Impresiones"
```

### Para Desarrollo Local:
```env
MAIL_MAILER=log
```
(Los correos se guardan en `storage/logs/laravel.log`)

---

## 🧪 Probar Configuración

Después de configurar, ejecuta:

```bash
php artisan tinker
```

Luego en la consola de Tinker:

```php
Mail::raw('Prueba de correo', function ($message) {
    $message->to('tu_correo@gmail.com')
            ->subject('Test desde MM Impresiones');
});
```

Si no hay errores, el correo debería enviarse.

---

## 🔧 Acceder a tu Correo Corporativo

Una vez creada la cuenta en HostGator, puedes acceder de 3 formas:

### 1. Webmail (Navegador)
```
https://mmimpresiones.com:2096
O
https://webmail.mmimpresiones.com
```

**Credenciales**:
- Usuario: `pedidos@mmimpresiones.com`
- Contraseña: La que configuraste

### 2. Cliente de Correo (Outlook, Thunderbird, etc.)

**Configuración IMAP**:
```
Servidor entrante: mail.mmimpresiones.com
Puerto: 993
Seguridad: SSL/TLS

Servidor saliente: mail.mmimpresiones.com
Puerto: 465
Seguridad: SSL/TLS
```

### 3. Gmail (Reenviar correos)

Puedes configurar Gmail para recibir correos de tu dominio:
1. Gmail → Configuración → Cuentas e importación
2. Agregar otra dirección de correo electrónico
3. Usa la configuración SMTP de arriba

---

## ⚠️ Problemas Comunes

### "Connection refused" o "Connection timeout"

**Causa**: Puerto bloqueado por el firewall o proveedor de internet.

**Solución**:
1. Cambia el puerto:
   - Si usas `465`, prueba con `587`
   - Si usas `587`, prueba con `465`
2. Cambia la encriptación:
   - Si usas `ssl`, prueba con `tls`
   - Si usas `tls`, prueba con `ssl`

### "Authentication failed"

**Causa**: Usuario o contraseña incorrectos.

**Solución**:
1. Verifica que el correo exista en cPanel
2. Intenta restablecer la contraseña
3. Asegúrate de no tener espacios extra en el `.env`

### Los correos llegan a spam

**Solución**:
1. Configura SPF en tu dominio (cPanel → Zone Editor)
2. Configura DKIM en cPanel → Email Authentication
3. Usa un correo corporativo del mismo dominio

---

## 📝 Checklist Final

- [ ] Cuenta de correo creada en cPanel
- [ ] Credenciales SMTP obtenidas
- [ ] Archivo `.env` configurado
- [ ] Cache limpiado: `php artisan config:clear`
- [ ] Correo de prueba enviado exitosamente
- [ ] Webmail funciona correctamente
- [ ] Correos no caen en spam

---

## 🆘 Soporte HostGator

Si tienes problemas con la configuración del correo:
- Soporte HostGator: https://www.hostgator.com/help
- Chat en vivo disponible 24/7
- Teléfono Chile: +56 2 32908047
