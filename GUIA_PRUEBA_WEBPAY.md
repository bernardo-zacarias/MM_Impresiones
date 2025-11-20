# 🛒 Guía de Prueba: Flujo de Compra con Webpay

## 📋 Flujo Completo de Compra

### **1. Agregar Productos al Carrito**

#### Opción A: Desde el Catálogo
1. Ve a **Catálogo de Productos** (`/catalogo`)
2. Selecciona un producto
3. Elige la cantidad
4. Click en **"Agregar al Carrito"**

#### Opción B: Desde el Cotizador
1. Ve a **Cotizador** (`/cotizador`)
2. Ingresa las medidas (ancho x alto)
3. Selecciona cantidad
4. Indica si requieres diseño gráfico
5. Sube archivo (opcional)
6. Click en **"Agregar al Carrito"**

---

### **2. Revisar el Carrito**

1. Click en el icono del carrito (navbar superior derecha)
2. URL: `/carrito`
3. Verás:
   - ✅ Lista de productos agregados
   - ✅ Cantidad y precio de cada item
   - ✅ Subtotal y Total
   - ✅ Botón **"Proceder al Pago"**

---

### **3. Iniciar el Pago**

1. Click en **"Proceder al Pago"** (botón verde con logo de tarjeta)
2. El sistema:
   - ✅ Crea un pedido en estado `pendiente_pago`
   - ✅ Marca el carrito como `comprado`
   - ✅ Genera orden de compra única (MM-{id}-{timestamp})
   - ✅ Te redirige automáticamente a Webpay

---

### **4. Página de Redirección**

Verás una pantalla intermedia que dice:
- **"Redirigiendo a Transbank..."**
- Logo animado
- Se auto-redirige en 2 segundos
- Si no redirige: Click en "Ir a Transbank"

---

### **5. Formulario de Pago Webpay**

El sistema está configurado en **MODO INTEGRACIÓN (TEST)**.

#### **Tarjetas de Prueba Transbank:**

##### ✅ **APROBADA (Débito)**
```
Número: 4051 8856 0045 6623
CVV: 123
Fecha: Cualquier fecha futura (Ej: 12/25)
RUT: 11.111.111-1
Contraseña: 123
```

##### ✅ **APROBADA (Crédito)**
```
Número: 4051 8842 3993 7763
CVV: 123
Fecha: Cualquier fecha futura
RUT: 11.111.111-1
Contraseña: 123
```

##### ❌ **RECHAZADA (para probar fallo)**
```
Número: 4051 8860 0005 6515
CVV: 123
Fecha: Cualquier fecha futura
RUT: 11.111.111-1
Contraseña: 123
```

---

### **6. Callback de Transbank**

Después de ingresar los datos y confirmar:

#### **Si el pago es APROBADO:**
1. Transbank redirige a: `/transbank/callback`
2. El sistema:
   - ✅ Confirma la transacción con Transbank
   - ✅ Actualiza estado del pedido a `pagado`
   - ✅ Guarda datos de pago (código autorización, buy_order, etc.)
   - ✅ Envía email al cliente (confirmación)
   - ✅ Envía email al admin (nuevo pedido)
3. Redirige a: `/pedidos/{id}` con mensaje de éxito

#### **Si el pago es RECHAZADO:**
1. Estado del pedido: `pago_rechazado`
2. Redirige a la página del pedido con mensaje de error
3. Puedes intentar pagar nuevamente

---

### **7. Ver el Pedido**

En la página de confirmación (`/pedidos/{id}`) verás:

- ✅ Número de pedido
- ✅ Estado actual
- ✅ Fecha y hora
- ✅ Total pagado
- ✅ Información de pago:
  - Código de autorización
  - Número de orden
  - Tipo de tarjeta (Débito/Crédito)
  - Monto
- ✅ Listado de productos
- ✅ Archivos adjuntos (con vista previa y descarga)

---

## 🔍 Verificación del Administrador

### **Panel de Admin**

1. Login como administrador
2. Ve a **Administración → Pedidos**
3. Verás todos los pedidos con:
   - Estado (Pendiente Pago / Pagado / etc.)
   - Total
   - Cliente
   - Fecha
4. Click en "Ver Detalles" para ver:
   - ✅ Toda la info del cliente
   - ✅ Productos comprados
   - ✅ Archivos del cliente (galería visual)
   - ✅ Información de pago de Transbank
   - ✅ Cambiar estado del pedido
   - ✅ Agregar notas internas

---

## 📧 Emails Automáticos

### **Cliente recibe:**
```
Asunto: ¡Pedido Confirmado! - MM Impresiones
Contenido:
- Número de pedido
- Total pagado
- Código de autorización Transbank
- Listado de productos
- Estado del pedido
```

### **Administrador recibe:**
```
Asunto: Nuevo Pedido #XX - MM Impresiones
Contenido:
- Info del cliente (nombre, email, teléfono)
- Productos comprados
- Total
- Método de pago
- Link directo al pedido en el panel de admin
```

---

## 🔧 Configuración Actual

### **Ambiente: INTEGRACIÓN (TEST)**
```env
TRANSBANK_ENVIRONMENT=test
TRANSBANK_COMMERCE_CODE=597055555532
TRANSBANK_API_KEY=579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C
```

### **URLs de Retorno**
- Callback: `https://tu-dominio.com/transbank/callback`
- En desarrollo: `http://127.0.0.1:8001/transbank/callback`

---

## 🚀 Datos de Prueba Creados

### **Usuario Cliente**
```
Email: cliente@test.com
Password: password
Rol: cliente
```

### **Usuario Admin**
```
Email: admin@mmimpresiones.com
Password: admin123
Rol: admin
```

---

## ✅ Checklist de Prueba

- [ ] Agregar producto al carrito desde catálogo
- [ ] Agregar cotización al carrito desde cotizador
- [ ] Ver carrito con items
- [ ] Click en "Proceder al Pago"
- [ ] Ver página de redirección a Transbank
- [ ] Llegar al formulario de Webpay
- [ ] Probar pago APROBADO con tarjeta de prueba
- [ ] Ver confirmación con datos de Transbank
- [ ] Recibir email de confirmación
- [ ] Ver pedido en historial del cliente
- [ ] Ver pedido en panel de administración
- [ ] Ver archivos adjuntos (si los hay)
- [ ] Probar pago RECHAZADO con tarjeta de rechazo
- [ ] Intentar pagar nuevamente un pedido rechazado

---

## 🐛 Resolución de Problemas

### **Error: "Tu carrito está vacío"**
- **Solución**: Agrega productos al carrito antes de proceder al pago

### **Error al conectar con Transbank**
- **Solución**: Verifica que el SDK de Transbank esté instalado:
  ```bash
  composer require transbank/transbank-sdk
  ```

### **No redirige a Webpay**
- **Solución**: Revisa los logs en `storage/logs/laravel.log`
- Verifica que la configuración en `.env` sea correcta

### **Emails no se envían**
- **Solución**: Verifica configuración de email en `.env`
- En desarrollo, usa: `MAIL_MAILER=log` (se guardan en logs)

### **Callback falla**
- **Solución**: Verifica que la ruta `/transbank/callback` esté accesible
- En producción: Debe ser HTTPS

---

## 📊 Estados del Pedido

| Estado | Descripción | Siguiente Acción |
|--------|-------------|------------------|
| `pendiente_pago` | Pedido creado, esperando pago | Cliente debe pagar en Webpay |
| `pagado` | Pago confirmado por Transbank | Admin procesa el pedido |
| `pago_rechazado` | Transbank rechazó el pago | Cliente puede reintentar |
| `en_proceso` | Admin está trabajando en el pedido | - |
| `completado` | Pedido entregado | - |
| `cancelado` | Pedido cancelado | - |

---

## 🎉 ¡Todo Listo!

El sistema de pagos con Webpay está **100% funcional** y listo para pruebas.

Para pasar a **producción**, solo necesitas:
1. Cambiar `TRANSBANK_ENVIRONMENT=production` en `.env`
2. Usar credenciales reales de Transbank
3. Configurar dominio con HTTPS

---

**Última actualización:** 20 de noviembre de 2025
