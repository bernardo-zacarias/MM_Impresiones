#!/bin/bash

# Script de ayuda para gestionar imágenes del sitio MM Impresiones
# Uso: ./manage-images.sh [comando]

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}"
echo "╔══════════════════════════════════════╗"
echo "║  MM Impresiones - Gestor de Imágenes ║"
echo "╚══════════════════════════════════════╝"
echo -e "${NC}"

# Función para listar imágenes
list_images() {
    echo -e "${GREEN}📁 Imágenes actuales:${NC}\n"
    
    echo -e "${YELLOW}Banners:${NC}"
    ls -lh public/images/banners/ 2>/dev/null || echo "  (vacío)"
    
    echo -e "\n${YELLOW}Assets:${NC}"
    ls -lh public/images/assets/ 2>/dev/null || echo "  (vacío)"
    
    echo -e "\n${YELLOW}Sitio:${NC}"
    ls -lh public/images/site/ 2>/dev/null || echo "  (vacío)"
    
    echo -e "\n${YELLOW}Productos:${NC}"
    ls -lh storage/app/public/productos/ 2>/dev/null || echo "  (vacío)"
}

# Función para verificar configuración
check_config() {
    echo -e "${GREEN}⚙️  Configuración actual:${NC}\n"
    
    if [ -f "config/images.php" ]; then
        echo -e "${BLUE}Archivo de configuración encontrado:${NC}"
        cat config/images.php | grep "=>" | head -10
    else
        echo -e "${RED}❌ Archivo de configuración no encontrado${NC}"
    fi
    
    echo -e "\n${BLUE}Variables en .env:${NC}"
    grep "IMAGE\|BANNER\|LOGO" .env 2>/dev/null || echo "  (ninguna configurada)"
}

# Función para optimizar imágenes
optimize_images() {
    echo -e "${GREEN}🔧 Optimizando imágenes...${NC}\n"
    
    # Verificar si ImageMagick está instalado
    if ! command -v convert &> /dev/null; then
        echo -e "${YELLOW}⚠️  ImageMagick no está instalado. Instalando...${NC}"
        sudo apt-get install imagemagick -y
    fi
    
    # Optimizar JPG y PNG
    find public/images -type f \( -name "*.jpg" -o -name "*.jpeg" \) -exec convert {} -quality 85 {} \;
    find public/images -type f -name "*.png" -exec convert {} -quality 90 {} \;
    
    echo -e "${GREEN}✅ Imágenes optimizadas${NC}"
}

# Función para limpiar cachés
clear_cache() {
    echo -e "${GREEN}🧹 Limpiando cachés de Laravel...${NC}\n"
    
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    
    echo -e "${GREEN}✅ Cachés limpiados${NC}"
}

# Función para subir imagen
upload_image() {
    echo -e "${GREEN}📤 Subir nueva imagen${NC}\n"
    echo "Ingresa la ruta de la imagen en tu computadora:"
    read -r image_path
    
    if [ ! -f "$image_path" ]; then
        echo -e "${RED}❌ Archivo no encontrado${NC}"
        return 1
    fi
    
    echo -e "\n${YELLOW}¿Dónde quieres guardarla?${NC}"
    echo "1) Banners (fondos y banners del home)"
    echo "2) Assets (logo y recursos corporativos)"
    echo "3) Site (imágenes generales)"
    read -r choice
    
    case $choice in
        1) dest="public/images/banners/" ;;
        2) dest="public/images/assets/" ;;
        3) dest="public/images/site/" ;;
        *) echo -e "${RED}❌ Opción inválida${NC}"; return 1 ;;
    esac
    
    filename=$(basename "$image_path")
    cp "$image_path" "$dest$filename"
    
    echo -e "${GREEN}✅ Imagen subida a: $dest$filename${NC}"
}

# Menú principal
case "$1" in
    list|ls)
        list_images
        ;;
    config)
        check_config
        ;;
    optimize)
        optimize_images
        ;;
    clear|cache)
        clear_cache
        ;;
    upload)
        upload_image
        ;;
    help|--help|-h)
        echo "Uso: ./manage-images.sh [comando]"
        echo ""
        echo "Comandos disponibles:"
        echo "  list      - Listar todas las imágenes"
        echo "  config    - Ver configuración actual"
        echo "  optimize  - Optimizar todas las imágenes"
        echo "  clear     - Limpiar cachés de Laravel"
        echo "  upload    - Subir una nueva imagen"
        echo "  help      - Mostrar esta ayuda"
        ;;
    *)
        echo -e "${YELLOW}Selecciona una opción:${NC}"
        echo "1) Listar imágenes"
        echo "2) Ver configuración"
        echo "3) Optimizar imágenes"
        echo "4) Limpiar cachés"
        echo "5) Subir nueva imagen"
        echo "6) Salir"
        read -r option
        
        case $option in
            1) list_images ;;
            2) check_config ;;
            3) optimize_images ;;
            4) clear_cache ;;
            5) upload_image ;;
            6) exit 0 ;;
            *) echo -e "${RED}❌ Opción inválida${NC}" ;;
        esac
        ;;
esac

echo ""
echo -e "${BLUE}Para más información, lee: public/images/README_IMAGENES.md${NC}"
