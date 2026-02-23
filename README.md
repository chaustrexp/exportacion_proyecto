# 🎓 ProgSENA - Sistema de Gestión de Programación SENA

Sistema web para la gestión de programación académica del SENA, incluyendo asignación de instructores, fichas, competencias y ambientes de formación.

![Version](https://img.shields.io/badge/version-2.1.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-7.4+-purple.svg)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)

## 📋 Características

- ✅ Gestión de Programas de Formación
- ✅ Administración de Competencias
- ✅ Control de Instructores y Fichas
- ✅ Asignación de Ambientes
- ✅ Calendario de Programación
- ✅ Dashboard con Estadísticas en Tiempo Real
- ✅ Sistema de Autenticación Seguro
- ✅ APIs REST para Notificaciones y Búsqueda
- ✅ URLs Limpias con Sistema de Enrutamiento

## 🚀 Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7+ / MariaDB 10.3+
- Servidor web Apache con mod_rewrite
- XAMPP, WAMP, LAMP o similar

## 📦 Instalación Rápida

### 1. Clonar el Repositorio

```bash
git clone https://github.com/chaustrexp/exportacion_proyecto.git
cd exportacion_proyecto
```

### 2. Configurar la Base de Datos

**Opción A: Usando phpMyAdmin**

1. Abre `http://localhost/phpmyadmin`
2. Crea la base de datos:
```sql
CREATE DATABASE progsena CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
3. Importa: `database/estructura_completa_ProgSENA.sql`
4. **IMPORTANTE - Corrige nombres de tablas:**
```sql
USE progsena;
RENAME TABLE `compet_programa` TO `competxprograma`;
RENAME TABLE `detalle_asignacion` TO `detallexasignacion`;
```
5. Importa datos de prueba: `database/datos_prueba.sql` (opcional)
6. Crea usuario admin: `database/crear_admin.sql`

**Opción B: Usando línea de comandos**

```bash
mysql -u root -p -e "CREATE DATABASE progsena CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p progsena < database/estructura_completa_ProgSENA.sql
mysql -u root -p progsena < database/corregir_nombre_tabla.sql
mysql -u root -p progsena < database/crear_admin.sql
mysql -u root -p progsena < database/datos_prueba.sql
```

### 3. Configurar la Aplicación

```bash
# Copiar archivos de configuración
cp conexion.example.php conexion.php
cp config/config.example.php config/config.php
```

Edita `conexion.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'progsena');
define('DB_USER', 'root');
define('DB_PASS', ''); // Tu contraseña
```

Edita `config/config.php`:
```php
define('BASE_PATH', '/exportacion_proyecto/');
define('BASE_URL', 'http://localhost/exportacion_proyecto/');
```

### 4. Verificar Instalación

Abre en tu navegador:
```
http://localhost/exportacion_proyecto/conectar_bd.php
```

## 👤 Acceso al Sistema

### Credenciales por Defecto

- **Usuario:** `admin`
- **Contraseña:** `admin123`

⚠️ **Importante:** Cambia estas credenciales en producción.

### URLs Principales

- **Login:** `http://localhost/exportacion_proyecto/auth/login.php`
- **Dashboard:** `http://localhost/exportacion_proyecto/`
- **Verificar Conexión:** `http://localhost/exportacion_proyecto/verificar_conexion.php`
- **Importar Datos:** `http://localhost/exportacion_proyecto/importar_datos.php`

## 📁 Estructura del Proyecto

```
exportacion_proyecto/
├── api/                    # APIs REST
│   ├── notifications.php   # Sistema de notificaciones
│   └── search.php          # Búsqueda global
├── assets/                 # Recursos estáticos
│   ├── css/               # Estilos (styles.css, theme-enhanced.css)
│   ├── js/                # JavaScript
│   ├── images/            # Imágenes y logos
│   └── icons/             # Iconos del sistema
├── auth/                   # Sistema de autenticación
│   ├── login.php          # Formulario de login
│   ├── check_auth.php     # Verificación de sesión
│   ├── logout.php         # Cierre de sesión
│   └── *.sql              # Scripts de usuarios
├── config/                 # Configuración
│   ├── config.php         # Configuración general
│   └── error_handler.php  # Manejo de errores
├── controller/             # Controladores MVC (16 archivos)
│   ├── BaseController.php
│   ├── DashboardController.php
│   ├── AmbienteController.php
│   ├── AsignacionController.php
│   └── ...
├── database/               # Scripts SQL
│   ├── estructura_completa_ProgSENA.sql
│   ├── datos_prueba.sql
│   ├── crear_admin.sql
│   └── corregir_nombre_tabla.sql
├── helpers/                # Funciones auxiliares
│   ├── functions.php
│   └── page_titles.php
├── model/                  # Modelos de datos (14 archivos)
│   ├── AdministradorModel.php
│   ├── AmbienteModel.php
│   ├── AsignacionModel.php
│   └── ...
├── views/                  # Vistas (17 módulos)
│   ├── ambiente/          # Gestión de ambientes
│   ├── asignacion/        # Gestión de asignaciones
│   ├── competencia/       # Gestión de competencias
│   ├── dashboard/         # Dashboard principal
│   ├── ficha/             # Gestión de fichas
│   ├── instructor/        # Gestión de instructores
│   ├── layout/            # Plantillas (header, footer, sidebar)
│   └── ...
├── .gitignore             # Archivos ignorados por Git
├── .htaccess              # Configuración Apache
├── conexion.php           # Conexión a BD (no en repo)
├── index.php              # Punto de entrada
├── routing.php            # Sistema de enrutamiento
└── README.md              # Este archivo
```

## 🎯 Módulos del Sistema

### 17 Módulos Completos (CRUD)

1. **Ambiente** - Gestión de aulas y espacios
2. **Asignación** - Programación de clases
3. **Centro de Formación** - Gestión de centros
4. **Competencia** - Competencias académicas
5. **Competencia por Programa** - Relaciones
6. **Coordinación** - Coordinaciones académicas
7. **Dashboard** - Panel principal con estadísticas
8. **Detalle Asignación** - Detalles de programación
9. **Ficha** - Gestión de fichas de formación
10. **Instructor-Competencia** - Asignación de competencias
11. **Instructor** - Gestión de instructores
12. **Perfil** - Perfil de usuario
13. **Programa** - Programas de formación
14. **Sede** - Gestión de sedes
15. **Título Programa** - Títulos académicos
16. **Errores** - Páginas de error personalizadas

## 🛠️ Tecnologías

- **Backend:** PHP 7.4+ (Arquitectura MVC)
- **Base de Datos:** MySQL 5.7+ / MariaDB
- **Frontend:** HTML5, CSS3, JavaScript
- **Servidor:** Apache con mod_rewrite
- **Autenticación:** Sesiones PHP
- **Seguridad:** PDO con prepared statements

## 📊 Base de Datos

### Tablas Principales (12)

- `ambiente` - Ambientes de formación
- `asignacion` - Asignaciones de instructores
- `centro_formacion` - Centros SENA
- `competencia` - Competencias académicas
- `competxprograma` - Relación competencias-programas
- `coordinacion` - Coordinaciones
- `detallexasignacion` - Detalles de asignación
- `ficha` - Fichas de formación
- `instructor` - Instructores
- `programa` - Programas de formación
- `sede` - Sedes
- `titulo_programa` - Títulos académicos

## 🔧 Solución de Problemas

### Error: Table 'progsena.competxprograma' doesn't exist

Ejecuta en phpMyAdmin:
```sql
RENAME TABLE `compet_programa` TO `competxprograma`;
RENAME TABLE `detalle_asignacion` TO `detallexasignacion`;
```

Ver: `SOLUCION_NOMBRES_TABLAS.md`

### Error de Conexión

1. Verifica que MySQL esté corriendo
2. Revisa credenciales en `conexion.php`
3. Ejecuta: `http://localhost/exportacion_proyecto/verificar_conexion.php`

### URLs no funcionan

1. Verifica que mod_rewrite esté activo en Apache
2. Asegúrate de que `.htaccess` esté en la raíz
3. Revisa `BASE_PATH` en `config/config.php`

## 📚 Documentación Adicional

- `INSTRUCCIONES_INSTALACION.md` - Guía detallada de instalación
- `SOLUCION_NOMBRES_TABLAS.md` - Solución a errores de tablas
- `INSTRUCCIONES_CORRECCION_BD.md` - Correcciones de base de datos
- `INVENTARIO.md` - Inventario completo del proyecto

## 🤝 Contribuir

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver archivo `LICENSE` para más detalles.

## 👥 Autores

- **Equipo SENA** - Desarrollo inicial

## 📧 Contacto

Para preguntas o soporte, contacta al equipo de desarrollo.

---

**Versión:** 2.1.0  
**Última actualización:** Febrero 2026  
**Estado:** Producción

