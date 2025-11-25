#!/bin/bash

# Script manual para preparar proyecto MM Impresiones
# Ejecuta estos comandos UNO POR UNO

echo "============================================"
echo "  PREPARACIÓN MANUAL PARA HOSTGATOR"
echo "============================================"
echo ""

# Variables
BACKUP_DIR="$HOME/Escritorio/MM_Backup_$(date +%Y%m%d_%H%M%S)"
PROJECT_DIR="$(pwd)"

echo "📁 Directorio de backup: $BACKUP_DIR"
echo ""
echo "Sigue estos pasos:"
echo ""

echo "==== PASO 1: Crear directorio de backup ===="
echo "Ejecuta:"
echo "  mkdir -p $BACKUP_DIR"
echo ""

echo "==== PASO 2: Exportar base de datos ===="
echo "Ejecuta UNO de estos comandos:"
echo ""
echo "Opción A (con sudo):"
echo "  sudo mysqldump -u root mm_impresiones > $BACKUP_DIR/mm_impresiones.sql"
echo ""
echo "Opción B (con contraseña):"
echo "  mysqldump -u root -p mm_impresiones > $BACKUP_DIR/mm_impresiones.sql"
echo ""
echo "Opción C (desde phpMyAdmin):"
echo "  1. Abre http://localhost/phpmyadmin"
echo "  2. Selecciona 'mm_impresiones'"
echo "  3. Exportar → Método rápido → SQL"
echo "  4. Guarda como: $BACKUP_DIR/mm_impresiones.sql"
echo ""

echo "==== PASO 3: Copiar proyecto ===="
echo "Ejecuta:"
echo "  cp -r $PROJECT_DIR $BACKUP_DIR/proyecto"
echo ""

echo "==== PASO 4: Limpiar archivos ===="
echo "Ejecuta:"
echo "  cd $BACKUP_DIR/proyecto"
echo "  rm -rf node_modules vendor"
echo "  rm -rf bootstrap/cache/*.php"
echo "  rm -rf storage/framework/cache/* storage/framework/sessions/* storage/framework/views/*"
echo "  find . -name '.DS_Store' -delete"
echo ""

echo "==== PASO 5: Comprimir proyecto ===="
echo "Ejecuta:"
echo "  cd $BACKUP_DIR"
echo "  zip -r mm_impresiones_hostgator.zip proyecto"
echo ""

echo "==== RESULTADO FINAL ===="
echo "Tendrás estos archivos en $BACKUP_DIR:"
echo "  - mm_impresiones.sql (Base de datos)"
echo "  - mm_impresiones_hostgator.zip (Proyecto limpio)"
echo ""
echo "¡Sube esos 2 archivos a HostGator!"
echo ""
