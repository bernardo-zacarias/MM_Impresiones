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
# Clonar el repositorio
git clone https://github.com/bernardo-zacarias/MM_Impresiones.git
cd MM_Impresiones

# Instalar dependencias
composer install
npm install && npm run build

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Base de datos
php artisan migrate --seed

# Crear enlace simbólico para imágenes
php artisan storage:link

# Iniciar servidor de desarrollo
php artisan serve
```

## ⚠️ Problema Común: Imágenes No Se Ven en Hosting

Si las imágenes funcionan en local pero no en el hosting, revisa **GUIA_IMAGENES_HOSTING.md** para la solución completa.

**Solución rápida** (via SSH en el hosting):
```bash
cd ~/proyecto
./fix-storage-link.sh
```

## 📋 Documentación

### General
- **README.md** - Este archivo (información general del proyecto)
- **GUIA_GIT.md** - Guía completa para trabajar con Git en el proyecto

### Despliegue y Configuración
- **GUIA_PRODUCCION.md** - Guía completa de despliegue
- **GUIA_IMAGENES_HOSTING.md** - ⭐ Solución para imágenes que no se ven en hosting
- **DESPLIEGUE_HOSTGATOR.md** - Instrucciones específicas para HostGator
- **GUIA_HOSTGATOR.md** - Configuración avanzada de HostGator

### Transbank/Webpay
- **GUIA_PRUEBA_WEBPAY.md** - Pruebas con Transbank
- **GUIA_PRUEBAS_TRANSBANK.md** - Más detalles de pruebas
- **TARJETAS_PRUEBA_TRANSBANK.md** - Tarjetas de prueba

### Email
- **GUIA_CONFIGURACION_EMAIL.md** - Configuración de correos
- **ACCESO_CORREO.md** - Credenciales y accesos

### Scripts de Utilidad
- **fix-storage-link.sh** - Script para crear enlace simbólico de storage en hosting
- **export-database.sh** - Exportar base de datos
- **prepare-hostgator.sh** - Preparar proyecto para HostGator
- **prepare-manual.sh** - Preparación manual
- **verificar-deploy.sh** - Verificar estado del despliegue

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
