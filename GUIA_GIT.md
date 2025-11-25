# 🚀 Guía de Trabajo con Git - MM Impresiones

## 📋 Estado Actual del Proyecto

- **Repositorio**: MM_Impresiones
- **Owner**: bernardo-zacarias
- **Rama actual**: `improve/user-profile-edit`
- **Rama principal**: `main`
- **Remoto**: GitHub (origin)

## 🌳 Estructura de Ramas

```
main (producción) ← Lo que está en el hosting
  └── improve/user-profile-edit (desarrollo actual)
```

## ⚡ Comandos Básicos Diarios

### Ver Estado Actual
```bash
git status
```

### Agregar Cambios al Staging
```bash
# Agregar un archivo específico
git add nombre-archivo.php

# Agregar todos los archivos modificados
git add .

# Agregar solo archivos PHP
git add *.php
```

### Hacer Commit
```bash
# Commit con mensaje corto
git commit -m "Descripción breve del cambio"

# Commit con mensaje detallado
git commit -m "Título del cambio" -m "Descripción más larga explicando qué y por qué"
```

### Ver Historial de Commits
```bash
# Ver últimos 5 commits
git log --oneline -5

# Ver cambios detallados
git log --stat -3

# Ver gráfico de ramas
git log --graph --oneline --all -10
```

### Sincronizar con GitHub

```bash
# Subir cambios a GitHub
git push origin improve/user-profile-edit

# Descargar cambios desde GitHub
git pull origin improve/user-profile-edit
```

## 🔄 Workflow Recomendado

### 1. Al Comenzar el Día
```bash
# Asegurarte de estar en la rama correcta
git branch

# Descargar últimos cambios
git pull origin improve/user-profile-edit
```

### 2. Durante el Desarrollo
```bash
# Hacer cambios en tus archivos...
# Luego ver qué cambió
git status

# Agregar cambios
git add .

# Hacer commit
git commit -m "feat: Descripción de lo que agregaste"
```

### 3. Al Terminar una Funcionalidad
```bash
# Subir cambios a GitHub
git push origin improve/user-profile-edit
```

## 📝 Convenciones para Mensajes de Commit

Usa estos prefijos para organizar tus commits:

- `feat:` - Nueva funcionalidad
  ```bash
  git commit -m "feat: Agregar filtro de productos por categoría"
  ```

- `fix:` - Corrección de bug
  ```bash
  git commit -m "fix: Corregir cálculo de total en carrito"
  ```

- `docs:` - Documentación
  ```bash
  git commit -m "docs: Actualizar README con instrucciones de instalación"
  ```

- `style:` - Cambios de formato (espacios, comas, etc)
  ```bash
  git commit -m "style: Formatear código en ProductoController"
  ```

- `refactor:` - Refactorización de código
  ```bash
  git commit -m "refactor: Extraer lógica de cálculo a clase separada"
  ```

- `test:` - Agregar o modificar tests
  ```bash
  git commit -m "test: Agregar tests para validación de pedidos"
  ```

- `chore:` - Tareas de mantenimiento
  ```bash
  git commit -m "chore: Actualizar dependencias de Composer"
  ```

## 🔀 Trabajar con Ramas

### Crear Nueva Rama
```bash
# Crear rama para una nueva funcionalidad
git checkout -b feature/nombre-funcionalidad

# Ejemplos:
git checkout -b feature/carrito-rapido
git checkout -b fix/error-login
git checkout -b improve/optimizar-imagenes
```

### Cambiar de Rama
```bash
# Ver ramas disponibles
git branch -a

# Cambiar a otra rama
git checkout nombre-rama

# Ejemplos:
git checkout main
git checkout improve/user-profile-edit
```

### Fusionar Cambios (Merge)

Cuando termines una funcionalidad y quieras llevarla a `main`:

```bash
# 1. Asegurarte de que tu rama está actualizada
git checkout improve/user-profile-edit
git add .
git commit -m "feat: Completar funcionalidad X"
git push origin improve/user-profile-edit

# 2. Ir a main y actualizar
git checkout main
git pull origin main

# 3. Fusionar tu rama en main
git merge improve/user-profile-edit

# 4. Subir los cambios a GitHub
git push origin main
```

## 🚨 Comandos de Emergencia

### Descartar Cambios No Guardados
```bash
# Descartar cambios en un archivo específico
git restore nombre-archivo.php

# Descartar TODOS los cambios no guardados (⚠️ CUIDADO)
git restore .
```

### Deshacer Último Commit (sin perder cambios)
```bash
# Mantener los cambios en staging
git reset --soft HEAD~1

# Mantener los cambios pero sacarlos de staging
git reset HEAD~1

# ⚠️ PELIGRO: Eliminar cambios completamente
git reset --hard HEAD~1
```

### Ver Diferencias
```bash
# Ver qué cambió en archivos no guardados
git diff

# Ver qué cambió en un archivo específico
git diff nombre-archivo.php

# Ver diferencias entre tu rama y main
git diff main..improve/user-profile-edit
```

### Ignorar Archivos Temporalmente
```bash
# Si modificaste un archivo pero no quieres commitearlo aún
git stash

# Ver lista de cambios guardados temporalmente
git stash list

# Recuperar cambios guardados
git stash pop
```

## 🔍 Verificar Conexión con GitHub

```bash
# Ver repositorio remoto configurado
git remote -v

# Debería mostrar:
# origin  https://github.com/bernardo-zacarias/MM_Impresiones.git (fetch)
# origin  https://github.com/bernardo-zacarias/MM_Impresiones.git (push)

# Testear conexión
git fetch origin
```

## 🎯 Flujo Típico de Trabajo

### Escenario 1: Agregar Nueva Funcionalidad

```bash
# 1. Crear rama para la funcionalidad
git checkout -b feature/sistema-favoritos

# 2. Hacer cambios en el código...
# ... editar archivos ...

# 3. Guardar progreso
git add .
git commit -m "feat: Agregar modelo y migración para favoritos"

# 4. Continuar trabajando...
# ... más cambios ...

git add .
git commit -m "feat: Implementar controlador de favoritos"

# 5. Subir a GitHub
git push origin feature/sistema-favoritos

# 6. Cuando esté lista, fusionar a main
git checkout main
git merge feature/sistema-favoritos
git push origin main

# 7. (Opcional) Eliminar rama si ya no se usa
git branch -d feature/sistema-favoritos
```

### Escenario 2: Corregir Bug Urgente

```bash
# 1. Ir a main
git checkout main

# 2. Crear rama de fix
git checkout -b fix/error-calculo-envio

# 3. Corregir el bug...
# ... editar archivos ...

# 4. Guardar y subir
git add .
git commit -m "fix: Corregir cálculo de costo de envío para regiones"
git push origin fix/error-calculo-envio

# 5. Fusionar inmediatamente a main
git checkout main
git merge fix/error-calculo-envio
git push origin main
```

### Escenario 3: Actualizar Hosting

```bash
# 1. Asegurarte de que main está actualizado
git checkout main
git pull origin main

# 2. Conectar al hosting via SSH
ssh tu_usuario@mmimpresiones.com

# 3. En el servidor, ir a la carpeta del proyecto
cd ~/proyecto

# 4. Descargar últimos cambios
git pull origin main

# 5. Limpiar caché de Laravel
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 6. Si hay migraciones nuevas
php artisan migrate --force

# 7. Recrear enlace de storage si es necesario
./fix-storage-link.sh
```

## 📚 Recursos Útiles

- **GitHub Desktop**: Interfaz gráfica fácil de usar (recomendado para principiantes)
  - Descargar: https://desktop.github.com/

- **GitKraken**: Otra interfaz gráfica potente
  - Descargar: https://www.gitkraken.com/

- **VS Code**: Tiene integración con Git incorporada
  - Ver cambios: Panel "Source Control" (Ctrl+Shift+G)
  - Hacer commits desde la interfaz

## 🆘 Problemas Comunes

### "Nothing to commit, working tree clean"
✅ Esto es BUENO. Significa que no hay cambios sin guardar.

### "Your branch is ahead of 'origin/...' by X commits"
➡️ Tienes commits que no has subido a GitHub.
```bash
git push origin nombre-rama
```

### "Your branch is behind 'origin/...' by X commits"
➡️ GitHub tiene cambios que no tienes localmente.
```bash
git pull origin nombre-rama
```

### "Merge conflict"
⚠️ Git no puede fusionar automáticamente. Pasos:
1. Abrir archivos en conflicto (marcados con `<<<<<<<`)
2. Editar y elegir qué cambios mantener
3. Eliminar las marcas `<<<<<<<`, `=======`, `>>>>>>>`
4. Guardar archivos
5. `git add .`
6. `git commit -m "fix: Resolver conflicto de merge"`

### "Permission denied (publickey)"
🔑 Problema de autenticación con GitHub.
- Opción 1: Usar HTTPS en lugar de SSH
- Opción 2: Configurar SSH keys (más avanzado)

## 💡 Tips Pro

1. **Commits frecuentes**: Mejor muchos commits pequeños que uno grande
2. **Mensajes claros**: Tus commits futuros te lo agradecerán
3. **Branch por funcionalidad**: Mantén el código organizado
4. **Push diariamente**: Respaldo automático en la nube
5. **Pull antes de empezar**: Evita conflictos

## 🎓 Comandos para Aprender

```bash
# Ver manual de un comando
git help commit
git help merge

# Ver versión de Git
git --version

# Ver configuración
git config --list

# Configurar nombre y email (si no lo has hecho)
git config --global user.name "Tu Nombre"
git config --global user.email "tu@email.com"
```

---

**Nota**: Esta guía está personalizada para el proyecto MM Impresiones. Guárdala y consúltala cuando necesites recordar algún comando. 🚀
