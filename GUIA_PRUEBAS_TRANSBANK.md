# 💳 Guía de Pruebas de Transbank - Ambiente de Integración
## MM Impresiones - Requisitos para Certificación de Transbank

---

## 🎯 OBJETIVO

Transbank requiere que **antes de entregarte las credenciales de producción**, realices pruebas exhaustivas en el **ambiente de integración** con tu sitio web ya subido al hosting con SSL activo.

Esta guía te ayudará a completar todas las pruebas requeridas por Transbank.

---

## ✅ REQUISITOS PREVIOS

Antes de comenzar las pruebas, asegúrate de tener:

- ✅ **Sitio web subido a HostGator** con dominio `https://mmimpresiones.com`
- ✅ **Certificado SSL activo** (candado verde en el navegador)
- ✅ **Base de datos configurada** con productos y usuarios
- ✅ **Emails configurados** para recibir confirmaciones
- ✅ **Credenciales de integración** configuradas en `.env`:

```bash
TRANSBANK_ENVIRONMENT=test
TRANSBANK_COMMERCE_CODE=597055555532
TRANSBANK_API_KEY=579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C
```

---

## 🔍 QUÉ ESTÁ REVISANDO TRANSBANK

Transbank verificará que tu integración:

1. ✅ **Redirige correctamente** a la plataforma de pago de Transbank
2. ✅ **Maneja transacciones aprobadas** correctamente
3. ✅ **Maneja transacciones rechazadas** correctamente
4. ✅ **Actualiza el estado del pedido** según resultado del pago
5. ✅ **Registra correctamente** la información de la transacción
6. ✅ **Funciona con HTTPS** (SSL obligatorio)
7. ✅ **Envía confirmaciones** por email al cliente

---

## 🧪 TARJETAS DE PRUEBA

### TARJETA VISA - Transacción Aprobada ✅

```
Número de Tarjeta: 4051 8856 0044 6623
CVV: 123
Fecha de Vencimiento: Cualquier fecha futura (ej: 12/25)
RUT: 11.111.111-1
Clave Webpay: 123

Resultado esperado: APROBADA
```

### TARJETA VISA - Transacción Rechazada ❌

```
Número de Tarjeta: 4051 8842 3993 7763
(Seguir el flujo pero NO ingresar la clave)

Resultado esperado: RECHAZADA (timeout)
```

### TARJETA MASTERCARD - Transacción Rechazada ❌

```
Número de Tarjeta: 5186 0595 3829 8637
CVV: 123
Fecha de Vencimiento: Cualquier fecha futura
RUT: 11.111.111-1

Resultado esperado: RECHAZADA
```

### TARJETA REDCOMPRA - Transacción Aprobada ✅

```
Número de Tarjeta: 4051 8842 3993 7763
Clave: 123

Resultado esperado: APROBADA
```

---

## 📝 PROCESO DE PRUEBAS PASO A PASO

### PRUEBA 1: Transacción Aprobada (Flujo Completo Exitoso)

#### Paso 1: Crear una orden de compra

1. Abre tu navegador en modo incógnito
2. Ve a `https://mmimpresiones.com`
3. Crea una cuenta nueva o inicia sesión:
   ```
   Email: prueba@test.com
   Password: Test123!
   ```
4. Ve al **Catálogo** y agrega productos al carrito
   - Agrega al menos 2 productos diferentes
   - Verifica que el carrito calcule correctamente el total
5. Ve al **Cotizador** y crea una cotización:
   - Selecciona tipo de trabajo
   - Ingresa dimensiones
   - Solicita diseño o sube un archivo
   - Agrega al carrito
6. Ve al **Carrito** y verifica:
   - Los productos están correctamente listados
   - Las cantidades son correctas
   - El total es correcto
7. Haz clic en **"Proceder al Pago"**

#### Paso 2: Proceso de pago con Transbank

1. Verás la página de resumen del pedido
2. Haz clic en **"Pagar con Webpay"**
3. **Serás redirigido a Transbank** (verifica que la URL sea de Transbank)
4. Ingresa los datos de la **tarjeta VISA aprobada**:
   ```
   Tarjeta: 4051 8856 0044 6623
   CVV: 123
   Vencimiento: 12/25
   RUT: 11.111.111-1
   ```
5. Haz clic en **"Continuar"**
6. Ingresa la **clave Webpay: 123**
7. Confirma el pago

#### Paso 3: Verificaciones después del pago

**✅ Verificación 1: Redirección correcta**
- Debes volver automáticamente a `mmimpresiones.com`
- Debes ver un mensaje de éxito tipo: "¡Pago confirmado exitosamente!"

**✅ Verificación 2: Estado del pedido**
- Ve al panel de usuario → Mis Pedidos
- El pedido debe estar en estado **"Pagado"**
- Debe mostrar:
  - Código de autorización de Transbank
  - Fecha y hora del pago
  - Monto pagado
  - Últimos 4 dígitos de la tarjeta

**✅ Verificación 3: Email de confirmación**
- Revisa la bandeja de entrada del email usado: `prueba@test.com`
- Debe haber llegado un email con:
  - Asunto: "✅ Confirmación de Pedido #XXX - MM Impresiones"
  - Detalle de los productos
  - Total pagado
  - Datos de contacto

**✅ Verificación 4: Email al administrador**
- El admin debe recibir un email notificando el nuevo pedido
- Verifica el email configurado en usuarios admin

**✅ Verificación 5: Panel de administración**
- Inicia sesión como administrador
- Ve a **Administración → Pedidos**
- El nuevo pedido debe aparecer con estado **"Pagado"**
- Verifica que todos los datos sean correctos

#### Paso 4: Capturar evidencias

**📸 Toma capturas de pantalla de:**

1. ✅ Página de carrito con productos
2. ✅ Página de Webpay de Transbank con el formulario
3. ✅ Página de confirmación después del pago
4. ✅ Detalle del pedido mostrando estado "Pagado"
5. ✅ Email de confirmación recibido
6. ✅ Panel de admin mostrando el pedido

---

### PRUEBA 2: Transacción Rechazada

#### Paso 1: Crear otra orden de compra

1. Repite los pasos 1-7 de la Prueba 1
2. Agrega productos diferentes al carrito
3. Procede al pago

#### Paso 2: Simular pago rechazado

1. En Webpay, usa la **tarjeta MASTERCARD rechazada**:
   ```
   Tarjeta: 5186 0595 3829 8637
   CVV: 123
   Vencimiento: 12/25
   RUT: 11.111.111-1
   ```
2. Completa el proceso

#### Paso 3: Verificaciones después del rechazo

**✅ Verificación 1: Mensaje de error**
- Debes ver un mensaje tipo: "El pago fue rechazado. Por favor, intenta con otro medio de pago."

**✅ Verificación 2: Estado del pedido**
- El pedido debe estar en estado **"Pago Rechazado"** o **"Pendiente de Pago"**

**✅ Verificación 3: NO debe enviarse email de confirmación**
- Verifica que NO llegue email de "Pago Confirmado"

**✅ Verificación 4: Usuario puede reintentar**
- El usuario debe poder volver al carrito
- El carrito debe mantener los productos
- El usuario puede intentar pagar nuevamente

#### Paso 4: Capturar evidencias

**📸 Toma capturas de pantalla de:**

1. ✅ Mensaje de pago rechazado
2. ✅ Estado del pedido (rechazado o pendiente)
3. ✅ Opción para reintentar el pago

---

### PRUEBA 3: Transacción Cancelada por el Usuario

#### Paso 1: Crear orden y cancelar

1. Crea una nueva orden de compra
2. Procede al pago con Webpay
3. En la página de Transbank, haz clic en **"Anular"** o **"Cancelar"**

#### Paso 2: Verificaciones

**✅ Verificación 1: Redirección correcta**
- Debes volver a tu sitio
- Mensaje tipo: "Transacción cancelada"

**✅ Verificación 2: Estado del pedido**
- El pedido debe permanecer en **"Pendiente de Pago"**
- El usuario puede reintentar

**✅ Verificación 3: NO debe cobrar**
- El pedido NO debe marcarse como pagado

---

## 🔍 VERIFICACIÓN DE LOGS

### Ver logs de Laravel en el servidor

```bash
# Conectarse por SSH o Terminal de cPanel
cd /home/tu-usuario/laravel/disenos-graficos

# Ver últimas 100 líneas del log
tail -100 storage/logs/laravel.log

# Buscar entradas relacionadas con Transbank
grep -i "transbank" storage/logs/laravel.log

# Buscar errores
grep -i "error" storage/logs/laravel.log | grep -i "transbank"
```

### Logs que Transbank puede pedir

Si Transbank solicita logs de las transacciones, proporciona:

```
[2025-11-20 10:30:15] local.INFO: Iniciando pago Transbank {"pedido_id":123,"buy_order":"MM-123-1234567890","amount":50000}
[2025-11-20 10:30:16] local.INFO: Token recibido de Transbank {"token":"01ab23cd45ef67890123456789abcdef"}
[2025-11-20 10:31:45] local.INFO: Callback de Transbank {"token":"01ab23cd45ef67890123456789abcdef","status":"AUTHORIZED"}
[2025-11-20 10:31:46] local.INFO: Pago confirmado {"pedido_id":123,"authorization_code":"123456"}
```

---

## 📊 REPORTE DE PRUEBAS PARA TRANSBANK

Después de completar todas las pruebas, prepara un documento con:

### 1. Información del Sitio Web

```
Nombre del Comercio: MM Impresiones
RUT: [Tu RUT]
URL del sitio: https://mmimpresiones.com
Fecha de pruebas: 20 de noviembre de 2025
Ambiente: Integración (Test)
```

### 2. Resumen de Pruebas Realizadas

| # | Tipo de Prueba | Tarjeta Usada | Resultado | Estado Pedido | Email Enviado |
|---|----------------|---------------|-----------|---------------|---------------|
| 1 | Pago Aprobado  | VISA 4051...6623 | ✅ Éxito | Pagado | ✅ Sí |
| 2 | Pago Rechazado | MC 5186...8637 | ✅ Éxito | Rechazado | ✅ No |
| 3 | Cancelación Usuario | VISA 4051...6623 | ✅ Éxito | Pendiente | ✅ No |

### 3. Capturas de Pantalla

Incluye todas las capturas organizadas por prueba:

```
Prueba 1 - Pago Aprobado/
├── 01-carrito-con-productos.png
├── 02-webpay-formulario.png
├── 03-confirmacion-pago.png
├── 04-detalle-pedido-pagado.png
├── 05-email-confirmacion.png
└── 06-panel-admin-pedido.png

Prueba 2 - Pago Rechazado/
├── 01-mensaje-rechazo.png
├── 02-pedido-rechazado.png
└── 03-opcion-reintentar.png

Prueba 3 - Cancelación/
├── 01-mensaje-cancelacion.png
└── 02-pedido-pendiente.png
```

### 4. Datos de Contacto

```
Nombre del responsable técnico: [Tu nombre]
Email: [Tu email]
Teléfono: [Tu teléfono]
```

---

## 📤 ENVÍO DE CERTIFICACIÓN A TRANSBANK

### Paso 1: Preparar documentación

1. Crea una carpeta con todo el material:
   ```
   Certificacion-MM-Impresiones-Transbank/
   ├── Reporte-Pruebas.pdf
   ├── Capturas/
   │   ├── Prueba1/
   │   ├── Prueba2/
   │   └── Prueba3/
   └── Logs/
       └── transbank-logs.txt
   ```

2. Comprime la carpeta en un ZIP

### Paso 2: Contactar a Transbank

**Email:** soporte@transbank.cl o tu ejecutivo asignado

**Asunto:** Solicitud de Certificación - MM Impresiones - [Tu RUT]

**Cuerpo del email:**

```
Estimado equipo de Transbank,

Por medio del presente, solicito la certificación para el comercio:

- Nombre: MM Impresiones
- RUT: [Tu RUT]
- URL: https://mmimpresiones.com

He completado todas las pruebas de integración en el ambiente de test/integración
con resultados exitosos. Adjunto el reporte completo de pruebas con capturas de
pantalla y evidencias.

Pruebas realizadas:
✅ Transacción aprobada (VISA 4051...6623)
✅ Transacción rechazada (MC 5186...8637)
✅ Cancelación por usuario
✅ Emails de confirmación
✅ Actualización de estados
✅ Panel de administración

El sitio cuenta con certificado SSL activo y todas las funcionalidades requeridas
están operando correctamente.

Quedo atento a sus comentarios y disponible para cualquier aclaración adicional.

Solicito me envíen las credenciales de producción una vez aprobada la certificación.

Saludos cordiales,
[Tu nombre]
[Tu email]
[Tu teléfono]
```

### Paso 3: Esperar respuesta de Transbank

**Tiempo estimado:** 3-5 días hábiles

**Transbank puede:**
- ✅ **Aprobar la certificación** y enviarte credenciales de producción
- ❌ **Solicitar correcciones** si encuentran problemas
- ❓ **Pedir más evidencias** o aclaraciones

---

## 🚀 ACTIVACIÓN DE PRODUCCIÓN

Una vez que Transbank apruebe y te envíe las credenciales:

### Paso 1: Actualizar .env en el servidor

```bash
# Conectarse por SSH o editar en cPanel File Manager
nano /home/tu-usuario/laravel/disenos-graficos/.env

# Cambiar estas líneas:
TRANSBANK_ENVIRONMENT=production
TRANSBANK_COMMERCE_CODE=TU_CODIGO_REAL_AQUI
TRANSBANK_API_KEY=TU_API_KEY_REAL_AQUI
```

### Paso 2: Limpiar cachés

```bash
cd /home/tu-usuario/laravel/disenos-graficos
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### Paso 3: Realizar transacción real de prueba

**⚠️ IMPORTANTE:** Haz una compra REAL con tu propia tarjeta por un monto pequeño (ej: $1000 CLP)

1. Crea un pedido de prueba
2. Paga con tu tarjeta real
3. Verifica que todo funcione correctamente
4. **Este cargo SÍ será real** pero es necesario para validar

### Paso 4: Monitorear transacciones

```bash
# Ver logs en tiempo real
tail -f storage/logs/laravel.log | grep -i "transbank"
```

---

## 🆘 SOLUCIÓN DE PROBLEMAS

### Error: "Token inválido"

**Causa:** El token de Transbank expiró o es incorrecto

**Solución:**
1. Verifica que `TRANSBANK_ENVIRONMENT` sea `test`
2. Verifica que las credenciales sean exactamente:
   - Commerce Code: `597055555532`
   - API Key: `579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C`
3. Limpia cachés: `php artisan config:clear`

### Error: "SSL certificate problem"

**Causa:** El sitio no tiene SSL activo o está mal configurado

**Solución:**
1. Ve a cPanel → SSL/TLS Status
2. Ejecuta AutoSSL
3. Espera 10-15 minutos
4. Verifica en navegador que aparezca el candado verde

### Error: "Connection refused"

**Causa:** El servidor no puede conectar con Transbank

**Solución:**
1. Verifica que el servidor tenga acceso a internet
2. Contacta a soporte de HostGator
3. Verifica que no haya firewall bloqueando

### Transbank no redirige de vuelta

**Causa:** La URL de retorno está mal configurada

**Solución:**
1. Verifica que `APP_URL` en `.env` sea correcta:
   ```bash
   APP_URL=https://mmimpresiones.com
   ```
2. Limpia cachés
3. Verifica que la ruta `route('transbank.callback')` exista

---

## 📞 CONTACTOS DE SOPORTE

### Transbank
- **Email:** soporte@transbank.cl
- **Teléfono:** 600 638 6380
- **Web:** https://www.transbankdevelopers.cl
- **Documentación:** https://www.transbankdevelopers.cl/documentacion/webpay-plus

### Recursos Técnicos
- **SDK Transbank PHP:** https://github.com/TransbankDevelopers/transbank-sdk-php
- **Ejemplos de código:** https://github.com/TransbankDevelopers/transbank-sdk-php-webpay-rest-example
- **API Reference:** https://www.transbankdevelopers.cl/referencia/webpay

---

## ✅ CHECKLIST FINAL

Antes de contactar a Transbank, asegúrate de tener:

- [ ] Sitio web funcionando en `https://mmimpresiones.com`
- [ ] SSL activo (candado verde en navegador)
- [ ] Al menos 3 pruebas exitosas con diferentes tarjetas
- [ ] Capturas de pantalla de todas las pruebas
- [ ] Emails de confirmación funcionando
- [ ] Panel de administración mostrando pedidos correctamente
- [ ] Logs sin errores críticos
- [ ] Reporte de pruebas documentado
- [ ] Datos de contacto preparados

---

**¡Éxito con tus pruebas de Transbank! 🎉**

Una vez certificado, tu sitio estará listo para recibir pagos reales de clientes.

---

**Última actualización:** 20 de noviembre de 2025
**Versión:** 1.0
**Proyecto:** MM Impresiones - Integración Transbank Webpay Plus
