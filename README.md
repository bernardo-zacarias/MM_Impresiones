# 🖨️ MM Impresiones - Sistema de Pedidos Online

Sistema web completo para gestión de pedidos de impresión con integración de pagos mediante Webpay Plus (Transbank).

## ✨ Características Principales

- 🛒 E-Commerce completo con catálogo y cotizador personalizado
- 💳 Integración con Webpay Plus (Transbank)
- 👥 Gestión de usuarios con ubicaciones chilenas (región/ciudad/comuna)
- 📊 Panel de administración completo
- �� Sistema de subida y visualización de archivos
- 📧 Notificaciones por email
- 🎨 Interfaz moderna con Tailwind CSS

## 🚀 Instalación Rápida

```bash
git clone https://github.com/bernardo-zacarias/MM_Impresiones.git
cd MM_Impresiones
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```

## �� Documentación

- **GUIA_PRODUCCION.md** - Guía completa de despliegue
- **GUIA_PRUEBA_WEBPAY.md** - Pruebas con Transbank
- **TARJETAS_PRUEBA_TRANSBANK.md** - Tarjetas de prueba

## 🛠️ Stack Tecnológico

- Laravel 12.0 (PHP 8.2+)
- MySQL
- Transbank SDK 5.1.0
- Tailwind CSS
- JavaScript

## ✅ Estado

**Listo para Producción** - Versión 1.0.0

---

Desarrollado por Bernardo Zacarias © 2025
