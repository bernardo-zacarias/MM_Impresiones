#!/bin/bash

# ============================================
# Script de Verificación Pre-Despliegue
# MM Impresiones - HostGator
# ============================================

echo "🔍 VERIFICACIÓN PRE-DESPLIEGUE - MM IMPRESIONES"
echo "=============================================="
echo ""

ERRORS=0
WARNINGS=0

# Colores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Función para mostrar errores
error() {
    echo -e "${RED}❌ ERROR: $1${NC}"
    ERRORS=$((ERRORS + 1))
}

# Función para mostrar advertencias
warning() {
    echo -e "${YELLOW}⚠️  WARNING: $1${NC}"
    WARNINGS=$((WARNINGS + 1))
}

# Función para mostrar éxito
success() {
    echo -e "${GREEN}✅ $1${NC}"
}

echo "📁 1. VERIFICANDO ARCHIVOS CRÍTICOS..."
echo "----------------------------------------"

# Verificar .env
if [ ! -f ".env" ]; then
    error "Archivo .env no encontrado"
else
    success "Archivo .env existe"
    
    # Verificar APP_KEY
    if ! grep -q "^APP_KEY=base64:" .env; then
        error "APP_KEY no está configurada en .env"
    else
        success "APP_KEY configurada"
    fi
    
    # Verificar APP_ENV
    APP_ENV=$(grep "^APP_ENV=" .env | cut -d '=' -f2)
    if [ "$APP_ENV" != "production" ]; then
        warning "APP_ENV no está en 'production' (actual: $APP_ENV)"
    else
        success "APP_ENV configurado como production"
    fi
    
    # Verificar APP_DEBUG
    APP_DEBUG=$(grep "^APP_DEBUG=" .env | cut -d '=' -f2)
    if [ "$APP_DEBUG" != "false" ]; then
        error "APP_DEBUG debe ser 'false' en producción (actual: $APP_DEBUG)"
    else
        success "APP_DEBUG está en false"
    fi
fi

# Verificar .env.example
if [ ! -f ".env.example" ]; then
    warning "Archivo .env.example no encontrado"
else
    success "Archivo .env.example existe"
fi

echo ""
echo "🗄️  2. VERIFICANDO BASE DE DATOS..."
echo "----------------------------------------"

# Verificar configuración de BD
if [ -f ".env" ]; then
    DB_DATABASE=$(grep "^DB_DATABASE=" .env | cut -d '=' -f2)
    DB_USERNAME=$(grep "^DB_USERNAME=" .env | cut -d '=' -f2)
    
    if [ -z "$DB_DATABASE" ]; then
        error "DB_DATABASE no está configurado"
    else
        success "DB_DATABASE: $DB_DATABASE"
    fi
    
    if [ -z "$DB_USERNAME" ]; then
        error "DB_USERNAME no está configurado"
    else
        success "DB_USERNAME: $DB_USERNAME"
    fi
fi

echo ""
echo "📂 3. VERIFICANDO PERMISOS..."
echo "----------------------------------------"

# Verificar storage
if [ -d "storage" ]; then
    if [ -w "storage" ]; then
        success "Directorio storage tiene permisos de escritura"
    else
        error "Directorio storage NO tiene permisos de escritura"
    fi
else
    error "Directorio storage no existe"
fi

# Verificar bootstrap/cache
if [ -d "bootstrap/cache" ]; then
    if [ -w "bootstrap/cache" ]; then
        success "Directorio bootstrap/cache tiene permisos de escritura"
    else
        error "Directorio bootstrap/cache NO tiene permisos de escritura"
    fi
else
    error "Directorio bootstrap/cache no existe"
fi

echo ""
echo "📦 4. VERIFICANDO DEPENDENCIAS..."
echo "----------------------------------------"

# Verificar vendor
if [ -d "vendor" ]; then
    success "Carpeta vendor existe"
else
    warning "Carpeta vendor no existe - ejecutar: composer install"
fi

# Verificar composer.lock
if [ -f "composer.lock" ]; then
    success "Archivo composer.lock existe"
else
    warning "Archivo composer.lock no existe"
fi

echo ""
echo "🌐 5. VERIFICANDO CONFIGURACIÓN WEB..."
echo "----------------------------------------"

# Verificar public/index.php
if [ -f "public/index.php" ]; then
    success "Archivo public/index.php existe"
else
    error "Archivo public/index.php NO existe"
fi

# Verificar public/storage link
if [ -L "public/storage" ]; then
    success "Symbolic link public/storage existe"
else
    warning "Symbolic link public/storage no existe - ejecutar: php artisan storage:link"
fi

# Verificar .htaccess
if [ -f "public/.htaccess" ]; then
    success "Archivo public/.htaccess existe"
else
    warning "Archivo public/.htaccess no existe"
fi

echo ""
echo "📧 6. VERIFICANDO CONFIGURACIÓN DE CORREO..."
echo "----------------------------------------"

if [ -f ".env" ]; then
    MAIL_HOST=$(grep "^MAIL_HOST=" .env | cut -d '=' -f2)
    MAIL_USERNAME=$(grep "^MAIL_USERNAME=" .env | cut -d '=' -f2)
    
    if [ -z "$MAIL_HOST" ]; then
        warning "MAIL_HOST no está configurado"
    else
        success "MAIL_HOST: $MAIL_HOST"
    fi
    
    if [ -z "$MAIL_USERNAME" ]; then
        warning "MAIL_USERNAME no está configurado"
    else
        success "MAIL_USERNAME: $MAIL_USERNAME"
    fi
fi

echo ""
echo "💳 7. VERIFICANDO CONFIGURACIÓN DE TRANSBANK..."
echo "----------------------------------------"

if [ -f ".env" ]; then
    TRANSBANK_ENV=$(grep "^TRANSBANK_ENVIRONMENT=" .env | cut -d '=' -f2)
    TRANSBANK_CODE=$(grep "^TRANSBANK_COMMERCE_CODE=" .env | cut -d '=' -f2)
    
    if [ -z "$TRANSBANK_ENV" ]; then
        error "TRANSBANK_ENVIRONMENT no está configurado"
    else
        success "TRANSBANK_ENVIRONMENT: $TRANSBANK_ENV"
        
        if [ "$TRANSBANK_ENV" == "integration" ]; then
            warning "Transbank en modo INTEGRACIÓN (pruebas)"
        else
            success "Transbank en modo PRODUCCIÓN"
        fi
    fi
    
    if [ -z "$TRANSBANK_CODE" ]; then
        error "TRANSBANK_COMMERCE_CODE no está configurado"
    else
        success "TRANSBANK_COMMERCE_CODE configurado"
    fi
fi

echo ""
echo "🖼️  8. VERIFICANDO ARCHIVOS PÚBLICOS..."
echo "----------------------------------------"

# Verificar imágenes
if [ -d "public/images" ]; then
    success "Carpeta public/images existe"
    
    # Verificar imágenes específicas
    if [ -f "public/images/banners/home-bg.png" ]; then
        success "Imagen home-bg.png existe"
    else
        warning "Imagen home-bg.png no encontrada"
    fi
    
    if [ -f "public/images/assets/logo.enc" ]; then
        success "Logo logo.enc existe"
    else
        warning "Logo logo.enc no encontrado"
    fi
else
    warning "Carpeta public/images no existe"
fi

echo ""
echo "🔒 9. VERIFICANDO SEGURIDAD..."
echo "----------------------------------------"

# Verificar .gitignore
if [ -f ".gitignore" ]; then
    if grep -q ".env" .gitignore; then
        success "Archivo .env está en .gitignore"
    else
        error "Archivo .env NO está en .gitignore"
    fi
else
    warning "Archivo .gitignore no existe"
fi

# Verificar archivos sensibles
if [ -f ".git" ] || [ -d ".git" ]; then
    warning "Carpeta .git presente (no subir a producción)"
fi

if [ -d "node_modules" ]; then
    warning "Carpeta node_modules presente (no necesaria en producción)"
fi

echo ""
echo "📝 10. VERIFICANDO MIGRACIONES..."
echo "----------------------------------------"

if [ -d "database/migrations" ]; then
    MIGRATION_COUNT=$(find database/migrations -name "*.php" | wc -l)
    success "Encontradas $MIGRATION_COUNT migraciones"
else
    error "Carpeta database/migrations no existe"
fi

echo ""
echo "=============================================="
echo "📊 RESUMEN DE VERIFICACIÓN"
echo "=============================================="
echo ""

if [ $ERRORS -eq 0 ] && [ $WARNINGS -eq 0 ]; then
    echo -e "${GREEN}✅ ¡TODO PERFECTO! El proyecto está listo para despliegue.${NC}"
    exit 0
elif [ $ERRORS -eq 0 ]; then
    echo -e "${YELLOW}⚠️  Hay $WARNINGS advertencias, pero puedes continuar.${NC}"
    echo -e "${YELLOW}   Revisa las advertencias antes de desplegar.${NC}"
    exit 0
else
    echo -e "${RED}❌ ERRORES ENCONTRADOS: $ERRORS${NC}"
    if [ $WARNINGS -gt 0 ]; then
        echo -e "${YELLOW}   Advertencias: $WARNINGS${NC}"
    fi
    echo -e "${RED}   ¡CORRIGE LOS ERRORES ANTES DE DESPLEGAR!${NC}"
    exit 1
fi
