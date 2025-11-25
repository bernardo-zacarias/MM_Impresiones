#!/bin/bash

###############################################################################
# Script para crear enlace simbólico de storage en HostGator
# Uso: ./fix-storage-link.sh
###############################################################################

echo "=========================================="
echo "  Configurando Storage Link en HostGator"
echo "=========================================="
echo ""

# Detectar la carpeta home del usuario
USER_HOME=$(pwd | cut -d'/' -f1-3)
echo "📂 Detectado directorio home: $USER_HOME"

# Definir rutas
PUBLIC_HTML="$USER_HOME/public_html"
STORAGE_APP_PUBLIC="$USER_HOME/storage/app/public"
STORAGE_LINK="$PUBLIC_HTML/storage"

echo ""
echo "Verificando estructura..."
echo "  - public_html: $PUBLIC_HTML"
echo "  - storage/app/public: $STORAGE_APP_PUBLIC"
echo ""

# Verificar que existe public_html
if [ ! -d "$PUBLIC_HTML" ]; then
    echo "❌ ERROR: No se encuentra la carpeta public_html"
    exit 1
fi

# Verificar que existe storage/app/public
if [ ! -d "$STORAGE_APP_PUBLIC" ]; then
    echo "⚠️  La carpeta storage/app/public no existe. Creándola..."
    mkdir -p "$STORAGE_APP_PUBLIC"
    echo "✅ Carpeta creada"
fi

# Eliminar storage existente si es una carpeta
if [ -d "$STORAGE_LINK" ] && [ ! -L "$STORAGE_LINK" ]; then
    echo "⚠️  Existe una carpeta 'storage' en public_html (no es enlace simbólico)"
    echo "📦 Respaldando contenido existente..."
    
    BACKUP_DIR="$USER_HOME/storage_backup_$(date +%Y%m%d_%H%M%S)"
    mv "$STORAGE_LINK" "$BACKUP_DIR"
    echo "✅ Respaldo creado en: $BACKUP_DIR"
fi

# Eliminar enlace simbólico antiguo si existe
if [ -L "$STORAGE_LINK" ]; then
    echo "🔗 Eliminando enlace simbólico antiguo..."
    rm "$STORAGE_LINK"
fi

# Crear el enlace simbólico
echo ""
echo "🔗 Creando enlace simbólico..."
ln -s "$STORAGE_APP_PUBLIC" "$STORAGE_LINK"

# Verificar que se creó correctamente
if [ -L "$STORAGE_LINK" ]; then
    echo "✅ Enlace simbólico creado exitosamente"
    echo ""
    echo "Verificación:"
    ls -la "$STORAGE_LINK"
    echo ""
else
    echo "❌ ERROR: No se pudo crear el enlace simbólico"
    exit 1
fi

# Configurar permisos
echo "🔒 Configurando permisos..."
chmod -R 775 "$STORAGE_APP_PUBLIC" 2>/dev/null
chmod 775 "$STORAGE_LINK" 2>/dev/null

echo ""
echo "=========================================="
echo "  ✅ Configuración completada"
echo "=========================================="
echo ""
echo "📝 Próximos pasos:"
echo "   1. Verificar que las imágenes se vean en: https://mmimpresiones.com"
echo "   2. Subir una imagen de prueba desde el admin"
echo "   3. Si hay problemas, revisar: storage/logs/laravel.log"
echo ""
