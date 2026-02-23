# Inventario Completo - Exportación Dashboard SENA

## 📦 Resumen

- **Total Modelos**: 14 archivos
- **Total Controladores**: 16 archivos (15 controladores + 1 README)
- **Total Vistas**: 17 módulos completos (68+ archivos)
- **Total Auth**: 8 archivos
- **Total Helpers**: 2 archivos
- **Total API**: 2 archivos
- **Assets**: CSS, JS, imágenes, iconos
- **Config**: 1 archivo
- **Base de Datos**: 1 archivo SQL
- **Archivos Core**: 4 archivos (.htaccess, conexion.php, routing.php, index.php)

---

## 📂 Detalle por Carpeta

### 1. MODEL (14 archivos)

| Archivo | Descripción |
|---------|-------------|
| AdministradorModel.php | Gestión de administradores del sistema |
| AmbienteModel.php | Gestión de ambientes/aulas |
| AsignacionModel.php | Gestión de asignaciones de instructores |
| CentroFormacionModel.php | Gestión de centros de formación |
| CompetenciaModel.php | Gestión de competencias |
| CompetenciaProgramaModel.php | Relación competencias-programas |
| CoordinacionModel.php | Gestión de coordinaciones |
| DetalleAsignacionModel.php | Detalles de asignaciones |
| FichaModel.php | Gestión de fichas de formación |
| InstruCompetenciaModel.php | Relación instructores-competencias |
| InstructorModel.php | Gestión de instructores |
| ProgramaModel.php | Gestión de programas de formación |
| SedeModel.php | Gestión de sedes |
| TituloProgramaModel.php | Gestión de títulos de programas |

### 2. CONTROLLER (16 archivos)

| Archivo | Descripción |
|---------|-------------|
| BaseController.php | Controlador base con funcionalidades comunes |
| DashboardController.php | Controlador del dashboard principal |
| AmbienteController.php | CRUD de ambientes |
| AsignacionController.php | CRUD de asignaciones |
| CentroFormacionController.php | CRUD de centros de formación |
| CompetenciaController.php | CRUD de competencias |
| CompetenciaProgramaController.php | CRUD de competencias-programas |
| CoordinacionController.php | CRUD de coordinaciones |
| DetalleAsignacionController.php | CRUD de detalles de asignación |
| FichaController.php | CRUD de fichas |
| InstruCompetenciaController.php | CRUD de instructor-competencias |
| InstructorController.php | CRUD de instructores |
| ProgramaController.php | CRUD de programas |
| SedeController.php | CRUD de sedes |
| TituloProgramaController.php | CRUD de títulos de programas |
| README_CONTROLADORES.md | Documentación de controladores |

### 3. VIEWS (17 módulos completos)

Cada módulo incluye archivos CRUD: crear.php, editar.php, ver.php, index.php

| Módulo | Archivos | Descripción |
|--------|----------|-------------|
| ambiente/ | 4 | Gestión de ambientes/aulas |
| asignacion/ | 6+ | Gestión de asignaciones (incluye get_asignacion.php, get_form_data.php) |
| centro_formacion/ | 4 | Gestión de centros de formación |
| competencia/ | 4 | Gestión de competencias |
| competencia_programa/ | 4 | Relación competencias-programas |
| coordinacion/ | 4 | Gestión de coordinaciones |
| dashboard/ | 5 | Dashboard principal (index, stats_cards, recent_assignments, calendar, scripts) |
| detalle_asignacion/ | 4 | Detalles de asignaciones |
| errors/ | 2+ | Páginas de error (404.php, 500.php) |
| ficha/ | 4 | Gestión de fichas de formación |
| instru_competencia/ | 4 | Relación instructores-competencias |
| instructor/ | 4 | Gestión de instructores |
| layout/ | 3 | Plantillas comunes (header.php, footer.php, sidebar.php) |
| perfil/ | 2+ | Perfil de usuario |
| programa/ | 4 | Gestión de programas de formación |
| sede/ | 4 | Gestión de sedes |
| titulo_programa/ | 4 | Gestión de títulos de programas |

**Total estimado**: 68+ archivos PHP de vistas

### 5. AUTH (8 archivos)

| Archivo | Descripción |
|---------|-------------|
| login.php | Formulario de inicio de sesión |
| check_auth.php | Middleware de verificación de autenticación |
| logout.php | Cierre de sesión |
| generar_password.php | Utilidad para generar contraseñas hash |
| test_login.php | Script de prueba del sistema de login |
| login.sql | Script SQL para crear tabla de usuarios |
| actualizar_passwords.sql | Script para actualizar contraseñas |
| README_LOGIN.md | Documentación del sistema de login |

### 6. HELPERS (2 archivos)

| Archivo | Descripción |
|---------|-------------|
| functions.php | Funciones auxiliares generales del sistema |
| page_titles.php | Gestión de títulos dinámicos de páginas |

### 7. API (2 archivos)

| Archivo | Descripción |
|---------|-------------|
| notifications.php | Sistema de notificaciones en tiempo real |
| search.php | API de búsqueda global del sistema |

### 8. ASSETS (múltiples archivos)

| Carpeta | Contenido |
|---------|-----------|
| css/ | styles.css, theme-enhanced.css |
| js/ | header-functions.js y otros scripts |
| images/ | Logos SENA, fotos de perfil, imágenes del sistema |
| icons/ | Iconos del sistema |

### 9. CONFIG (1 archivo)

| Archivo | Descripción |
|---------|-------------|
| error_handler.php | Manejo centralizado de errores y excepciones |

### 10. DATABASE (1 archivo)

| Archivo | Descripción |
|---------|-------------|
| estructura_completa_ProgSENA.sql | Base de datos completa con todas las tablas |

**Tablas incluidas en la BD:**
- administrador
- ambiente
- asignacion
- centro_formacion
- competencia
- competencia_programa
- coordinacion
- detalle_asignacion
- ficha
- instru_competencia
- instructor
- programa
- sede
- titulo_programa

### 11. ARCHIVOS CORE (4 archivos)

| Archivo | Descripción |
|---------|-------------|
| .htaccess | Configuración Apache para URLs limpias y reescritura |
| conexion.php | Configuración de conexión a MySQL |
| routing.php | Sistema de enrutamiento y URLs limpias |
| index.php | Punto de entrada principal del sistema |

---

## 🔗 Dependencias entre Componentes

### Flujo de Autenticación
```
index.php → auth/check_auth.php → Dashboard o Login
```

### Flujo de Peticiones
```
index.php → routing.php → Controller → Model → Database
                       ↓
                     View
```

### Estructura MVC
```
Model (Datos) ← Controller (Lógica) → View (Presentación)
      ↓
  Database
```

---

## 📊 Estadísticas

- **Líneas de código estimadas**: ~20,000+
- **Tablas de base de datos**: 14
- **Módulos CRUD completos**: 14
- **Vistas totales**: 68+ archivos PHP
- **Sistema de autenticación**: ✅ Completo
- **Sistema de routing**: ✅ URLs limpias
- **Dashboard funcional**: ✅ Con estadísticas y calendario
- **APIs**: ✅ Notificaciones y búsqueda
- **Assets completos**: ✅ CSS, JS, imágenes

---

## ✅ Checklist de Componentes

- [x] Todos los modelos exportados (14)
- [x] Todos los controladores exportados (16)
- [x] Todas las vistas exportadas (17 módulos, 68+ archivos)
- [x] Sistema de login completo (8 archivos)
- [x] Base de datos SQL incluida
- [x] Archivos de configuración incluidos
- [x] Sistema de routing incluido
- [x] Helpers incluidos (2 archivos)
- [x] APIs incluidas (2 archivos)
- [x] Assets completos (CSS, JS, imágenes)
- [x] Config incluida (error_handler)
- [x] .htaccess incluido
- [x] Documentación completa incluida

---

**Generado**: 23 de febrero de 2026
**Versión del Sistema**: 2.1.0
