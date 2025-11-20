# 💳 Tarjetas de Prueba Transbank - Webpay Plus

## 🎯 IMPORTANTE: Datos Actualizados para 2025

Estas son las tarjetas de prueba **oficiales** de Transbank para el ambiente de **integración**.

---

## ✅ TARJETAS QUE FUNCIONAN (Aprobadas)

### **Tarjeta de DÉBITO RedCompra - APROBADA**
```
Número de Tarjeta: 4051 8856 0045 6623
CVV: 123
Fecha de Vencimiento: Cualquier fecha futura (ej: 12/25, 01/26, etc.)
RUT: 11.111.111-1
Clave: 123
```
**Resultado:** ✅ Transacción APROBADA

---

### **Tarjeta de CRÉDITO - APROBADA**
```
Número de Tarjeta: 4051 8842 3993 7763
CVV: 123
Fecha de Vencimiento: Cualquier fecha futura (ej: 12/25)
RUT: 11.111.111-1
Clave: 123
```
**Resultado:** ✅ Transacción APROBADA

---

### **Tarjeta PREPAGO - APROBADA**
```
Número de Tarjeta: 4051 8860 0005 4321
CVV: 123
Fecha de Vencimiento: Cualquier fecha futura
RUT: 11.111.111-1
Clave: 123
```
**Resultado:** ✅ Transacción APROBADA

---

## ❌ TARJETAS PARA PROBAR RECHAZOS

### **Tarjeta RECHAZADA por Falta de Fondos**
```
Número de Tarjeta: 4051 8860 0005 6515
CVV: 123
Fecha de Vencimiento: Cualquier fecha futura
RUT: 11.111.111-1
Clave: 123
```
**Resultado:** ❌ Transacción RECHAZADA (Fondos insuficientes)

---

### **Tarjeta RECHAZADA por el Banco**
```
Número de Tarjeta: 4051 8842 3993 7771
CVV: 123
Fecha de Vencimiento: Cualquier fecha futura
RUT: 11.111.111-1
Clave: 123
```
**Resultado:** ❌ Transacción RECHAZADA (Banco rechaza)

---

## 📋 Datos Comunes para TODAS las Tarjetas

| Campo | Valor |
|-------|-------|
| **CVV** | `123` |
| **Fecha de Vencimiento** | Cualquier fecha futura (MM/AA) |
| **RUT** | `11.111.111-1` |
| **Clave/Contraseña** | `123` |

---

## 🔄 Si aún no funciona, intenta estas alternativas:

### **Opción 1: Tarjeta Visa Débito (más común)**
```
4051885600456623
```

### **Opción 2: Tarjeta Mastercard Crédito**
```
5186059559590568
CVV: 123
Vencimiento: 12/25
RUT: 11.111.111-1
Clave: 123
```

### **Opción 3: Tarjeta Visa Crédito**
```
4051884239937763
```

---

## 🎬 Paso a Paso para Usar las Tarjetas

1. **Inicia el proceso de pago** desde el carrito o pedido
2. **Espera la redirección** a Webpay (página de Transbank)
3. **En el formulario de Webpay:**
   - Ingresa el **número de tarjeta** (con o sin espacios)
   - Ingresa el **CVV: 123**
   - Selecciona **fecha futura** (ejemplo: 12/25)
   - Click en **Continuar**
4. **En la página de autenticación:**
   - Ingresa **RUT: 11.111.111-1** (o 11111111-1)
   - Ingresa **Clave: 123**
   - Click en **Aceptar** o **Pagar**
5. **Espera confirmación** → Serás redirigido de vuelta al sitio

---

## 🐛 Solución de Problemas

### ❓ "Número de tarjeta inválido"
**Soluciones:**
- Verifica que estés en el **ambiente de integración** (no producción)
- Copia y pega el número **SIN ESPACIOS**: `4051885600456623`
- Prueba con otra tarjeta de la lista
- Verifica que `.env` tenga: `TRANSBANK_ENVIRONMENT=test`

### ❓ "Transacción rechazada"
**Posibles causas:**
- Usaste una tarjeta de la lista de "rechazadas" (es normal)
- El monto es $0 (Transbank no permite montos cero)
- Hay un error en las credenciales del SDK

### ❓ "Error al procesar pago"
**Soluciones:**
- Revisa `storage/logs/laravel.log` para ver el error exacto
- Verifica que el SDK esté instalado: `composer show transbank/transbank-sdk`
- Limpia cachés: `php artisan config:clear`

### ❓ No llego al formulario de Webpay
**Soluciones:**
- Verifica que el pedido esté en estado `pendiente_pago`
- Revisa que la URL de callback sea accesible
- Verifica logs en `storage/logs/laravel.log`

---

## 🔐 Configuración Actual del Proyecto

### **Credenciales de Integración (TEST)**
```env
TRANSBANK_ENVIRONMENT=test
TRANSBANK_COMMERCE_CODE=597055555532
TRANSBANK_API_KEY=579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C
```

Estas credenciales están **hardcodeadas** en el código para el ambiente TEST.

---

## 🌐 URLs Importantes

- **Ambiente de Integración:** `https://webpay3gint.transbank.cl`
- **Documentación Oficial:** https://www.transbankdevelopers.cl
- **GitHub del SDK:** https://github.com/TransbankDevelopers/transbank-sdk-php

---

## 📝 Notas Importantes

1. ⚠️ **NUNCA uses estas tarjetas en producción** - Son solo para pruebas
2. ✅ Las tarjetas de prueba **solo funcionan en ambiente de integración**
3. 🔄 Puedes usar la misma tarjeta **múltiples veces**
4. 💰 El monto de la compra **no importa** en pruebas (se aprobará igual)
5. 📧 En ambiente de prueba **no se cobran comisiones reales**

---

## ✅ Verificación Rápida

Si quieres verificar que todo está bien configurado:

```bash
# 1. Verificar SDK instalado
composer show transbank/transbank-sdk

# 2. Verificar ambiente
php artisan tinker --execute="echo config('services.transbank.environment');"

# 3. Ver último pedido pendiente
php artisan tinker --execute="\$p = \App\Models\Pedido::where('estado', 'pendiente_pago')->latest()->first(); if(\$p) echo 'Pedido #' . \$p->id . ' - $' . \$p->total; else echo 'No hay pedidos pendientes';"
```

---

**Última actualización:** 20 de noviembre de 2025  
**SDK Version:** 5.1.0  
**Ambiente:** Integración/Test
