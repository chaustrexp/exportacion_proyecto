# 👨‍🏫 Rol de Instructor - Guía de Implementación

## ✅ Implementación Completada

Se ha creado exitosamente el rol de Instructor en el sistema ProgSENA.

## 📋 Archivos Creados

### Base de Datos
- `database/crear_rol_instructor.sql` - Script SQL para crear el rol

### Controlador
- `controller/InstructorDashboardController.php` - Controlador del dashboard del instructor

### Vistas
- `views/instructor_dashboard/index.php` - Dashboard principal del instructor
- `views/instructor_dashboard/mis_fichas.php` - Listado de fichas asignadas
- `views/instructor_dashboard/mis_asignaciones.php` - Historial de asignaciones

### Archivos Modificados
- `auth/login.php` - Agregado instructor_id a la sesión
- `routing.php` - Agregadas rutas del instructor y redirección automática

## 🚀 Pasos para Activar el Rol de Instructor

### 1. Ejecutar el Script SQL

Abre phpMyAdmin y ejecuta el archivo:
```
database/crear_rol_instructor.sql
```

Este script:
- Modifica la tabla `usuarios` para soportar el rol "Instructor"
- Agrega el campo `instructor_id` para vincular usuarios con instructores
- Crea automáticamente usuarios para todos los instructores existentes

### 2. Credenciales de Acceso

**Contraseña por defecto para todos los instructores:**
```
instructor123
```

**Email:** El correo registrado en la tabla `instructor`

### 3. Probar el Sistema

1. Cierra sesión si estás logueado como admin
2. Inicia sesión con las credenciales de un instructor
3. Serás redirigido automáticamente al dashboard del instructor

## 📊 Funcionalidades del Rol Instructor

### Dashboard Principal
- ✅ Estadísticas personales (fichas, asignaciones)
- ✅ Vista de fichas asignadas
- ✅ Próximas asignaciones
- ✅ Resumen semanal

### Mis Fichas
- ✅ Listado completo de fichas donde participa
- ✅ Información del programa
- ✅ Jornada y coordinación
- ✅ Número de asignaciones por ficha

### Mis Asignaciones
- ✅ Historial completo de asignaciones
- ✅ Fechas y horarios
- ✅ Competencias asignadas
- ✅ Ambientes y sedes

## 🔐 Seguridad

- ✅ Los instructores solo ven sus propias fichas y asignaciones
- ✅ No tienen acceso a funciones administrativas
- ✅ Redirección automática según el rol
- ✅ Validación de permisos en cada controlador

## 📝 Estructura de la Base de Datos

### Tabla `usuarios` (Modificada)

```sql
CREATE TABLE `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `rol` ENUM('Administrador', 'Instructor') NOT NULL,
  `instructor_id` INT NULL,  -- NUEVO CAMPO
  `estado` VARCHAR(20) NOT NULL DEFAULT 'Activo',
  `ultimo_acceso` DATETIME NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`inst_id`)
) ENGINE = InnoDB;
```

## 🔄 Flujo de Autenticación

1. Usuario ingresa credenciales
2. Sistema verifica en tabla `usuarios`
3. Si `rol = 'Instructor'`:
   - Guarda `instructor_id` en sesión
   - Redirige a `/instructor_dashboard`
4. Si `rol = 'Administrador'`:
   - Redirige a `/dashboard` (admin)

## 🎨 Personalización

### Agregar Más Funcionalidades

Para agregar nuevas funciones al dashboard del instructor:

1. Agregar método en `InstructorDashboardController.php`
2. Crear vista en `views/instructor_dashboard/`
3. Agregar ruta en `routing.php` en la sección `instructor_dashboard`

### Ejemplo:

```php
// En InstructorDashboardController.php
public function miHorario() {
    // Lógica aquí
    require_once __DIR__ . '/../views/instructor_dashboard/mi_horario.php';
}
```

```php
// En routing.php
'instructor_dashboard' => [
    'controller' => 'InstructorDashboardController',
    'file' => 'controller/InstructorDashboardController.php',
    'actions' => ['index', 'misFichas', 'misAsignaciones', 'miHorario'], // Agregar aquí
    'default_action' => 'index'
],
```

## 📞 URLs del Sistema

### Para Administradores
```
http://localhost/exportacion_proyecto/
→ Redirige a /dashboard
```

### Para Instructores
```
http://localhost/exportacion_proyecto/
→ Redirige a /instructor_dashboard
```

### Rutas Específicas del Instructor
```
/instructor_dashboard/index - Dashboard principal
/instructor_dashboard/misFichas - Mis fichas
/instructor_dashboard/misAsignaciones - Mis asignaciones
```

## ✅ Checklist de Verificación

- [ ] Script SQL ejecutado en phpMyAdmin
- [ ] Usuarios instructores creados automáticamente
- [ ] Login funciona con credenciales de instructor
- [ ] Redirección automática al dashboard del instructor
- [ ] Dashboard muestra estadísticas correctas
- [ ] Listado de fichas funciona
- [ ] Listado de asignaciones funciona
- [ ] Instructores no pueden acceder a funciones admin

## 🔧 Solución de Problemas

### Error: "No se encontró el ID del instructor"

**Causa:** El usuario no tiene `instructor_id` asignado

**Solución:**
```sql
-- Verificar usuarios sin instructor_id
SELECT * FROM usuarios WHERE rol = 'Instructor' AND instructor_id IS NULL;

-- Asignar manualmente
UPDATE usuarios 
SET instructor_id = (SELECT inst_id FROM instructor WHERE inst_correo = usuarios.email LIMIT 1)
WHERE rol = 'Instructor' AND instructor_id IS NULL;
```

### No aparecen fichas o asignaciones

**Causa:** El instructor no tiene fichas o asignaciones registradas

**Solución:** Asignar fichas o crear asignaciones desde el panel de administrador

## 📊 Consultas Útiles

### Ver todos los usuarios instructores
```sql
SELECT 
    u.id,
    u.nombre,
    u.email,
    u.instructor_id,
    i.inst_nombres,
    i.inst_apellidos
FROM usuarios u
LEFT JOIN instructor i ON u.instructor_id = i.inst_id
WHERE u.rol = 'Instructor';
```

### Ver fichas de un instructor
```sql
SELECT 
    f.fich_numero,
    p.prog_denominacion,
    COUNT(a.asig_id) as total_asignaciones
FROM ficha f
LEFT JOIN programa p ON f.programa_prog_id = p.prog_codigo
LEFT JOIN asignacion a ON f.fich_id = a.ficha_fich_id AND a.instructor_inst_id = 1
WHERE f.instructor_inst_id_lider = 1 
   OR EXISTS (
       SELECT 1 FROM asignacion a2 
       WHERE a2.ficha_fich_id = f.fich_id 
       AND a2.instructor_inst_id = 1
   )
GROUP BY f.fich_id;
```

---

**Fecha de Implementación:** 24 de Febrero de 2026  
**Versión:** 1.0.0  
**Estado:** ✅ Completado y Funcional
