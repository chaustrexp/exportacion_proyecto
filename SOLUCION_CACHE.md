# Solución al Problema de Caché PHP

## Problema Identificado
Los archivos están correctamente actualizados con nombres de columnas en minúsculas, pero PHP OPcache está sirviendo código antiguo en bytecode compilado.

## Archivos Corregidos
✅ Todos los modelos actualizados con nombres en minúsculas
✅ Todos los controladores actualizados
✅ Todas las vistas de coordinacion corregidas (eliminados campos inexistentes)
✅ Todas las vistas de ficha ya estaban correctas

## Campos Eliminados de Coordinación
La tabla `coordinacion` solo tiene estos campos:
- `coord_id` (PK)
- `coord_nombre` (nombre de la coordinación)
- `centro_formacion_cent_id` (FK)

Se eliminaron referencias a campos que NO existen:
- ❌ `coord_descripcion` (no existe)
- ❌ `coord_nombre_coordinador` (no existe)
- ❌ `coord_correo` (no existe)
- ❌ `coord_password` (no existe)

## Solución: Reiniciar Apache

### Opción 1: Desde XAMPP/WAMP Panel
1. Abre el panel de control de XAMPP o WAMP
2. Haz clic en "Stop" en Apache
3. Espera 10 segundos
4. Haz clic en "Start" en Apache

### Opción 2: Limpiar Caché Manualmente
Ejecuta en tu navegador:
```
http://localhost/exportacion_proyecto/limpiar_cache.php
```

### Opción 3: Reiniciar Servicios (Windows)
```cmd
net stop Apache2.4
net start Apache2.4
```

## Después de Reiniciar
1. Cierra TODAS las ventanas del navegador
2. Abre el navegador nuevamente
3. Presiona Ctrl+Shift+Delete para limpiar caché del navegador
4. Accede a: `http://localhost/exportacion_proyecto/`

## URL del Proyecto
```
http://localhost/exportacion_proyecto/
```

## Credenciales de Acceso
- Email: `admin@sena.edu.co`
- Password: `admin123`

## Verificar que Funciona
Después de reiniciar, las secciones deberían funcionar correctamente:
- ✅ Dashboard
- ✅ Programas
- ✅ Competencias
- ✅ Coordinaciones
- ✅ Fichas
- ✅ Asignaciones
- ✅ Instructores
- ✅ Ambientes
- ✅ Sedes
- ✅ Centros de Formación

Si aún ves errores con nombres en mayúsculas, el caché no se limpió correctamente.
