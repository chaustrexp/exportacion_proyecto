# Solución: Nombres de Tablas Inconsistentes

## Problema
El código PHP usa nombres de tablas con "x" pero la base de datos tiene nombres con guión bajo:
- Código busca: `competxprograma` → Base de datos tiene: `compet_programa`
- Código busca: `detallexasignacion` → Base de datos tiene: `detalle_asignacion`

## Solución Rápida (RECOMENDADA)

Ejecuta este SQL en phpMyAdmin para renombrar las tablas:

```sql
USE progsena;

-- Renombrar tablas para que coincidan con el código
RENAME TABLE `compet_programa` TO `competxprograma`;
RENAME TABLE `detalle_asignacion` TO `detallexasignacion`;

-- Verificar
SHOW TABLES;
```

## Pasos Detallados

1. Abre phpMyAdmin: `http://localhost/phpmyadmin`
2. Selecciona la base de datos `progsena` en el panel izquierdo
3. Haz clic en la pestaña "SQL" en la parte superior
4. Copia y pega el SQL de arriba
5. Haz clic en "Continuar"
6. Recarga tu aplicación

## Verificación

Después de ejecutar el SQL, deberías ver estas tablas:
- ✅ `competxprograma` (con x)
- ✅ `detallexasignacion` (con x)

## Alternativa (No Recomendada)

Si prefieres mantener los nombres con guión bajo, necesitarías actualizar aproximadamente 20 archivos PHP, lo cual es más trabajo y propenso a errores.

## Archivo SQL Listo

También puedes importar el archivo: `database/corregir_nombre_tabla.sql`
