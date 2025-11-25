#!/bin/bash

# Script para preparar el proyecto MM Impresiones para HostGator
# Autor: Bernardo Zacarias
# Fecha: 20/11/2025

echo "========================================"
echo "  PREPARANDO PROYECTO PARA HOSTGATOR   "
echo "========================================"
echo ""

# Colores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Directorio del proyecto
PROJECT_DIR="$(pwd)"
BACKUP_DIR="$HOME/Escritorio/MM_Backup_$(date +%Y%m%d_%H%M%S)"

echo -e "${YELLOW}Creando directorio de backup...${NC}"
mkdir -p "$BACKUP_DIR"

echo -e "${GREEN}✓ Directorio creado: $BACKUP_DIR${NC}"
echo ""

# 1. EXPORTAR BASE DE DATOS
echo -e "${YELLOW}[1/6] Exportando base de datos...${NC}"
mysqldump -u root mm_impresiones > "$BACKUP_DIR/mm_impresiones.sql"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Base de datos exportada: mm_impresiones.sql${NC}"
else
    echo -e "${RED}✗ Error al exportar base de datos${NC}"
    exit 1
fi
echo ""

# 2. COPIAR PROYECTO
echo -e "${YELLOW}[2/6] Copiando proyecto...${NC}"
cp -r "$PROJECT_DIR" "$BACKUP_DIR/proyecto"
cd "$BACKUP_DIR/proyecto"
echo -e "${GREEN}✓ Proyecto copiado${NC}"
echo ""

# 3. LIMPIAR ARCHIVOS INNECESARIOS
echo -e "${YELLOW}[3/6] Limpiando archivos de desarrollo...${NC}"

# Remover node_modules
if [ -d "node_modules" ]; then
    echo "  - Removiendo node_modules..."
    rm -rf node_modules
fi

# Remover vendor (se reinstalará en servidor)
if [ -d "vendor" ]; then
    echo "  - Removiendo vendor..."
    rm -rf vendor
fi

# Remover archivos de cache
echo "  - Limpiando cache..."
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
rm -rf storage/logs/*.log

# Remover .git (opcional - descomenta si quieres)
# echo "  - Removiendo .git..."
# rm -rf .git

# Remover archivos temporales
find . -name ".DS_Store" -delete
find . -name "Thumbs.db" -delete
find . -name "*.swp" -delete

echo -e "${GREEN}✓ Archivos limpiados${NC}"
echo ""

# 4. PREPARAR .env.example PARA PRODUCCIÓN
echo -e "${YELLOW}[4/6] Preparando archivo .env.example...${NC}"
cat > .env.production.example << 'EOF'
APP_NAME="MM Impresiones"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=America/Santiago
APP_URL=https://tudominio.com

APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es_ES

LOG_CHANNEL=stack
LOG_LEVEL=error

# Base de datos HostGator
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=tu_usuario_mm_impresiones
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password

# Session & Cache
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail Configuration (Gmail)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD="tu_password_aplicacion"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="MM Impresiones"

# Transbank PRODUCCIÓN
TRANSBANK_API_KEY=tu_api_key_produccion
TRANSBANK_COMMERCE_CODE=tu_codigo_comercio_produccion
TRANSBANK_ENVIRONMENT=production

# Filesystem
FILESYSTEM_DISK=public
EOF

echo -e "${GREEN}✓ Archivo .env.production.example creado${NC}"
echo ""

# 5. CREAR ESTRUCTURA DE DIRECTORIOS
echo -e "${YELLOW}[5/6] Verificando estructura de directorios...${NC}"
mkdir -p storage/app/public/archivos_diseno
mkdir -p storage/app/public/productos
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

echo -e "${GREEN}✓ Estructura de directorios verificada${NC}"
echo ""

# 6. COMPRIMIR PROYECTO
echo -e "${YELLOW}[6/6] Comprimiendo proyecto...${NC}"
cd "$BACKUP_DIR"
zip -r "mm_impresiones_hostgator.zip" proyecto -q

if [ $? -eq 0 ]; then
    SIZE=$(du -h "mm_impresiones_hostgator.zip" | cut -f1)
    echo -e "${GREEN}✓ Proyecto comprimido: mm_impresiones_hostgator.zip ($SIZE)${NC}"
else
    echo -e "${RED}✗ Error al comprimir proyecto${NC}"
    exit 1
fi
echo ""

# RESUMEN
echo "========================================"
echo -e "${GREEN}  ¡PREPARACIÓN COMPLETADA!${NC}"
echo "========================================"
echo ""
echo "Archivos generados en: $BACKUP_DIR"
echo ""
echo "📦 Archivos listos:"
echo "  1. mm_impresiones.sql - Base de datos"
echo "  2. mm_impresiones_hostgator.zip - Proyecto limpio"
echo "  3. proyecto/.env.production.example - Configuración"
echo ""
echo "📋 PRÓXIMOS PASOS:"
echo ""
echo "1. Sube mm_impresiones_hostgator.zip a HostGator"
echo "2. Descomprime en el directorio de tu dominio"
echo "3. Importa mm_impresiones.sql en phpMyAdmin"
echo "4. Configura el archivo .env con tus credenciales"
echo "5. Ejecuta: composer install --no-dev"
echo "6. Ejecuta: php artisan key:generate"
echo "7. Ejecuta: php artisan storage:link"
echo "8. Ejecuta: php artisan migrate"
echo "9. Configura permisos: chmod -R 775 storage bootstrap/cache"
echo "10. Prueba Webpay en ambiente de integración"
echo ""
echo "📖 Lee GUIA_HOSTGATOR.md para instrucciones detalladas"
echo ""
