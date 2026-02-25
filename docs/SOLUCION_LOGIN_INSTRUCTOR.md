# Solución: Error 500 en Dashboard de Instructor

## Problema Identificado

El dashboard de instructor mostraba "Error 500 - Internal Server Error" debido a inconsistencias en las columnas utilizadas para identificar al instructor en las consultas SQL.

## Causa Raíz

1. La tabla `asignacion` tiene dos columnas relacionadas con instructores:
   - `instructor_inst_id` (INT) - FK a tabla `instructor.inst_id`
   - `instructor_id` (INT) - FK a tabla `usuarios.id` (agregada en refactorización)

2. El sistema de login guarda en sesión:
   - `$_SESSION['id']` = ID del usuario en tabla `usuarios`
   - `$_SESSION['instructor_id']` = ID del instructor en tabla `instructor` (campo `instructor_id` de usuarios)

3. El controlador `InstructorDashboardController.php` estaba usando:
   - `$usuario_id` (ID de usuarios) para consultar contra `instructor_id` (columna que no existía en las consultas)
   - Las consultas SQL usaban `a.instructor_id` pero la columna correcta es `a.instructor_inst_id`

## Solución Implementada

### Opción 1: Usar instructor_id de la sesión (IMPLEMENTADA)

Modificar el controlador para usar `$_SESSION['instructor_id']` que contiene el ID del instructor físico:

```php
// En lugar de:
$usuario_id = $_SESSION['id'] ?? $_SESSION['usuario_id'] ?? null;

// Usar:
$instructor_id = $_SESSION['instructor_id'] ?? null;
```

Y en las consultas SQL usar la columna correcta:
```sql
WHERE a.instructor_inst_id = ?
```

### Cambios Realizados

1. **InstructorDashboardController.php**:
   - Método `index()`: Usa `$_SESSION['instructor_id']` para obtener el ID del instructor
   - Método `getFichasInstructor()`: Cambiado `a.instructor_id` → `a.instructor_inst_id`
   - Método `getAsignacionesInstructor()`: Cambiado `a.instructor_id` → `a.instructor_inst_id`
   - Método `getEstadisticas()`: Cambiado todas las referencias `instructor_id` → `instructor_inst_id`
   - Método `misFichas()`: Usa `$_SESSION['instructor_id']`
   - Método `misAsignaciones()`: Cambiado `a.instructor_id` → `a.instructor_inst_id` y usa `$_SESSION['instructor_id']`

2. **AsignacionModel.php**:
   - Método `getForCalendar()`: Simplificado para usar solo `a.instructor_inst_id`

## Verificación

Para verificar que el instructor tiene asignaciones:

```sql
-- Ver instructor_id del usuario
SELECT id, nombre, email, instructor_id FROM usuarios WHERE email = 'joselop@sena.edu.co';

-- Ver asignaciones del instructor (usando instructor_inst_id)
SELECT * FROM asignacion WHERE instructor_inst_id = 2;

-- Si no hay asignaciones, crear una de prueba:
INSERT INTO asignacion (instructor_inst_id, asig_fecha_ini, asig_fecha_fin, ficha_fich_id, ambiente_amb_id, competencia_comp_id)
VALUES (2, NOW(), DATE_ADD(NOW(), INTERVAL 2 HOUR), 1, '101', 1);
```

## Notas Importantes

- El sistema mantiene dos columnas por compatibilidad:
  - `instructor_inst_id`: Referencia a tabla `instructor`
  - `instructor_id`: Referencia a tabla `usuarios` (si se ejecutó refactor_asignacion.sql)

- Para el dashboard de instructor, usamos `instructor_inst_id` porque es la columna principal y siempre existe.

- La sesión guarda `instructor_id` que corresponde al campo `instructor_id` de la tabla `usuarios`, que a su vez referencia a `instructor.inst_id`.

## Estado

✅ **CORREGIDO** - Todos los cambios implementados:

1. ✅ InstructorDashboardController.php - Todos los métodos actualizados
2. ✅ AsignacionModel.php - Método getForCalendar simplificado
3. ✅ Creado script de verificación: database/verificar_usuarios_instructores.sql

### Próximos Pasos

1. Acceder al sistema con credenciales de instructor:
   - Email: joselop@sena.edu.co
   - Password: instructor123

2. Si el dashboard muestra "0" en todas las estadísticas:
   - Ejecutar el script `database/verificar_usuarios_instructores.sql` en phpMyAdmin
   - Verificar que el usuario tenga `instructor_id = 2`
   - Verificar que existan asignaciones con `instructor_inst_id = 2`
   - Si no hay asignaciones, descomentar la sección de INSERT en el script

3. El dashboard debe mostrar:
   - Fichas asignadas al instructor
   - Asignaciones próximas
   - Estadísticas (total fichas, asignaciones, hoy, esta semana)
   - Calendario con asignaciones

### Archivos Modificados

- `controller/InstructorDashboardController.php` - 4 métodos corregidos
- `model/AsignacionModel.php` - 1 método simplificado
- `database/verificar_usuarios_instructores.sql` - Script de verificación creado
- `SOLUCION_LOGIN_INSTRUCTOR.md` - Documentación completa
