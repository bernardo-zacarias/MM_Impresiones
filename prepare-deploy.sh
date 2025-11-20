#!/bin/bash

################################################################################
# Script de Preparación para Despliegue - MM Impresiones
# 
# Este script prepara el proyecto para ser subido a HostGator
# Ejecutar ANTES de subir al servidor
################################################################################

echo "======================================================================"
echo "🚀 Preparando MM Impresiones para Despliegue a HostGator"
echo "======================================================================"
echo ""

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Verificar que estamos en el directorio correcto
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ Error: No se encuentra el archivo 'artisan'${NC}"
    echo "Por favor, ejecuta este script desde el directorio raíz del proyecto Laravel"
    exit 1
fi

echo -e "${BLUE}📋 Paso 1: Verificando estructura del proyecto...${NC}"
sleep 1

# Verificar archivos importantes
REQUIRED_FILES=("composer.json" "package.json" ".env.example" "artisan")
for file in "${REQUIRED_FILES[@]}"; do
    if [ -f "$file" ]; then
        echo -e "${GREEN}✓${NC} $file encontrado"
    else
        echo -e "${RED}✗${NC} $file NO encontrado"
        exit 1
    fi
done

echo ""
echo -e "${BLUE}📦 Paso 2: Instalando dependencias de producción...${NC}"
sleep 1

# Instalar dependencias de Composer (sin dev)
echo "Instalando dependencias de Composer..."
composer install --optimize-autoloader --no-dev --prefer-dist

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓${NC} Dependencias de Composer instaladas"
else
    echo -e "${RED}✗${NC} Error al instalar dependencias de Composer"
    exit 1
fi

echo ""
echo -e "${BLUE}🎨 Paso 3: Compilando assets (CSS/JS)...${NC}"
sleep 1

# Verificar si node_modules existe
if [ ! -d "node_modules" ]; then
    echo "Instalando dependencias de NPM..."
    npm install
fi

# Compilar assets para producción
echo "Compilando assets para producción..."
npm run build

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓${NC} Assets compilados correctamente"
else
    echo -e "${YELLOW}⚠${NC} No se pudieron compilar assets (esto no es crítico si no usas Vite/NPM)"
fi

echo ""
echo -e "${BLUE}🧹 Paso 4: Limpiando archivos innecesarios...${NC}"
sleep 1

# Limpiar cachés
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo -e "${GREEN}✓${NC} Cachés limpiados"

# Eliminar archivos de desarrollo
echo "Eliminando archivos de desarrollo..."
rm -rf node_modules
rm -rf tests/
rm -rf .git/
rm -f .gitignore .gitattributes
rm -f phpunit.xml
rm -f README_Laravel.md

echo -e "${GREEN}✓${NC} Archivos de desarrollo eliminados"

echo ""
echo -e "${BLUE}📝 Paso 5: Verificando archivo .env.example...${NC}"
sleep 1

if grep -q "TRANSBANK_ENVIRONMENT=test" .env.example; then
    echo -e "${GREEN}✓${NC} Configuración de Transbank encontrada en .env.example"
else
    echo -e "${YELLOW}⚠${NC} Advertencia: No se encontró configuración de Transbank en .env.example"
fi

echo ""
echo -e "${BLUE}🗜️  Paso 6: Creando archivo comprimido para subir...${NC}"
sleep 1

# Nombre del archivo con timestamp
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
ARCHIVE_NAME="mm-impresiones-deploy-${TIMESTAMP}.tar.gz"

# Crear el archivo comprimido
cd ..
tar -czf "$ARCHIVE_NAME" disenos-graficos \
    --exclude='disenos-graficos/storage/logs/*' \
    --exclude='disenos-graficos/storage/framework/cache/*' \
    --exclude='disenos-graficos/storage/framework/sessions/*' \
    --exclude='disenos-graficos/storage/framework/views/*' \
    --exclude='disenos-graficos/.env'

if [ $? -eq 0 ]; then
    ARCHIVE_SIZE=$(du -h "$ARCHIVE_NAME" | cut -f1)
    echo -e "${GREEN}✓${NC} Archivo comprimido creado: ${GREEN}$ARCHIVE_NAME${NC} (${ARCHIVE_SIZE})"
    echo ""
    echo -e "${GREEN}📁 Ubicación: $(pwd)/$ARCHIVE_NAME${NC}"
else
    echo -e "${RED}✗${NC} Error al crear archivo comprimido"
    exit 1
fi

cd disenos-graficos

echo ""
echo "======================================================================"
echo -e "${GREEN}✅ PREPARACIÓN COMPLETADA EXITOSAMENTE${NC}"
echo "======================================================================"
echo ""
echo -e "${YELLOW}📋 PRÓXIMOS PASOS:${NC}"
echo ""
echo "1. 📤 Sube el archivo comprimido a HostGator:"
echo "   - Archivo: ../$ARCHIVE_NAME"
echo "   - Ubicación: /home/tu-usuario/laravel/"
echo ""
echo "2. 🗂️  Extrae el archivo en el servidor usando File Manager de cPanel"
echo ""
echo "3. 📝 Crea el archivo .env en el servidor con las credenciales correctas"
echo "   - Usa .env.example como referencia"
echo "   - Configura: Base de datos, Email, Transbank"
echo ""
echo "4. 🔑 Genera la APP_KEY ejecutando en el servidor:"
echo "   php artisan key:generate"
echo ""
echo "5. 🗄️  Ejecuta las migraciones:"
echo "   php artisan migrate --force"
echo ""
echo "6. 🔗 Crea el enlace simbólico de storage:"
echo "   php artisan storage:link"
echo ""
echo "7. 🔒 Configura permisos:"
echo "   chmod -R 775 storage"
echo "   chmod -R 775 bootstrap/cache"
echo ""
echo "8. ⚡ Optimiza Laravel para producción:"
echo "   php artisan config:cache"
echo "   php artisan route:cache"
echo "   php artisan view:cache"
echo ""
echo "9. 💳 Realiza las pruebas de Transbank siguiendo:"
echo "   - GUIA_PRUEBAS_TRANSBANK.md"
echo ""
echo "10. 🚀 Para despliegue detallado, consulta:"
echo "    - GUIA_DESPLIEGUE_HOSTGATOR.md"
echo ""
echo "======================================================================"
echo -e "${BLUE}📞 Soporte Técnico:${NC}"
echo "   - Transbank: soporte@transbank.cl"
echo "   - HostGator: https://www.hostgator.com/support"
echo "======================================================================"
echo ""
echo -e "${GREEN}¡Buena suerte con tu despliegue! 🎉${NC}"
echo ""
