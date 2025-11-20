# 📧 ACCESO RÁPIDO AL CORREO - MM IMPRESIONES

## 🚀 OPCIÓN 1: Crear Correo en HostGator (RECOMENDADO)

### Paso a Paso Visual:

```
1. Ingresa a cPanel de HostGator
   └─ https://tudominio.com:2083
   
2. Busca sección "EMAIL"
   └─ Email Accounts / Cuentas de Correo
   
3. Clic en "CREATE" / "CREAR"
   
4. Completa el formulario:
   ┌─────────────────────────────────────┐
   │ Email: pedidos                      │  ← Solo escribe "pedidos"
   │ Domain: @mmimpresiones.com          │  ← Se selecciona automático
   │ Password: ●●●●●●●●●●●●●●●●●         │  ← Contraseña segura
   │ Storage: 250 MB                     │  ← Suficiente
   └─────────────────────────────────────┘
   
5. Clic en "CREATE" / "CREAR"
```

### 📥 Acceder al Correo Creado:

#### Opción A: Webmail (Navegador)
```
URL: https://mmimpresiones.com:2096
O:   https://webmail.mmimpresiones.com

Usuario: pedidos@mmimpresiones.com
Contraseña: La que configuraste
```

#### Opción B: Cliente de Correo (Outlook, Gmail, etc.)
```
IMAP (Recibir):
├─ Servidor: mail.mmimpresiones.com
├─ Puerto: 993
└─ Seguridad: SSL/TLS

SMTP (Enviar):
├─ Servidor: mail.mmimpresiones.com
├─ Puerto: 465
└─ Seguridad: SSL/TLS
```

---

## 🔧 OPCIÓN 2: Usar Gmail (Temporal)

### Si necesitas algo rápido mientras configuras HostGator:

```
1. Ve a Google Account → Seguridad
   └─ https://myaccount.google.com/security

2. Activa "Verificación en 2 pasos"

3. Busca "Contraseñas de aplicaciones"

4. Genera contraseña para "Correo"

5. Copia la contraseña de 16 dígitos
```

### Configura en .env:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tucorreo@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tucorreo@gmail.com
MAIL_FROM_NAME="MM Impresiones"
```

---

## ✅ PROBAR CONFIGURACIÓN

### Método 1: Script de Prueba
```bash
php test-email.php tu_correo@ejemplo.com
```

### Método 2: Tinker
```bash
php artisan tinker
```

Luego ejecuta:
```php
Mail::raw('Prueba', function($m) {
    $m->to('tucorreo@ejemplo.com')->subject('Test');
});
```

### Método 3: Hacer un Pedido de Prueba
```
1. Registra un usuario
2. Agrega productos al carrito
3. Realiza un pedido
4. Revisa que lleguen los correos
```

---

## 📝 CONFIGURACIÓN PARA PRODUCCIÓN (HostGator)

### 1. Edita tu archivo .env:
```env
# Cambia estas líneas:
MAIL_MAILER=smtp
MAIL_HOST=mail.mmimpresiones.com
MAIL_PORT=465
MAIL_USERNAME=pedidos@mmimpresiones.com
MAIL_PASSWORD=tu_contraseña_segura
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=pedidos@mmimpresiones.com
MAIL_FROM_NAME="MM Impresiones"
```

### 2. Limpia la caché:
```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Prueba:
```bash
php test-email.php tu_correo@gmail.com
```

---

## ⚠️ SOLUCIÓN DE PROBLEMAS

### ❌ "Connection refused"
```
Problema: Puerto bloqueado
Solución: Cambia MAIL_PORT a 587 y MAIL_ENCRYPTION a tls
```

### ❌ "Authentication failed"
```
Problema: Credenciales incorrectas
Solución: 
1. Verifica que el correo exista en cPanel
2. Restablece la contraseña
3. Elimina espacios en .env
```

### ❌ Los correos llegan a spam
```
Solución:
1. Usa correo del mismo dominio (@mmimpresiones.com)
2. Configura SPF y DKIM en cPanel
3. No uses palabras spam en asunto
```

---

## 📞 SOPORTE

### HostGator Chile
- Web: https://www.hostgator.com/help
- Chat: 24/7 disponible
- Teléfono: +56 2 32908047

### Documentación
- Ver: GUIA_CONFIGURACION_EMAIL.md (Guía completa)
- Ver: README.md (Documentación general)

---

## 🎯 RESUMEN EJECUTIVO

Para tener correos funcionando en 5 minutos:

1. **Desarrollo Local**: Deja `MAIL_MAILER=log` (ya está configurado)
   - Los correos se guardan en `storage/logs/laravel.log`
   
2. **Producción (HostGator)**: 
   - Crea correo en cPanel: `pedidos@mmimpresiones.com`
   - Obtén credenciales SMTP de cPanel
   - Configura .env con los datos
   - Ejecuta: `php artisan config:clear`
   - Prueba: `php test-email.php tu_correo@gmail.com`

**Listo!** 🎉
