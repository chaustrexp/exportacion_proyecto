# 🔐 SISTEMA DE LOGIN - DASHBOARD SENA

## ✅ INSTALACIÓN COMPLETADA

El sistema de autenticación ha sido instalado exitosamente.

## 🎨 CARACTERÍSTICAS

### Página de Login
- ✅ Diseño moderno con gradiente verde SENA
- ✅ Formulario responsive
- ✅ Validación de credenciales
- ✅ Mensajes de error amigables
- ✅ Credenciales de prueba visibles

### Seguridad
- ✅ Contraseñas encriptadas con `password_hash()`
- ✅ Sesiones PHP seguras
- ✅ Protección de páginas con `check_auth.php`
- ✅ Verificación de roles
- ✅ Registro de último acceso

### Funcionalidades
- ✅ Login con email y contraseña
- ✅ Logout desde cualquier página
- ✅ Mostrar nombre y rol del usuario en navbar
- ✅ Redirección automática si ya está logueado
- ✅ Protección de todas las páginas del dashboard

## 👥 USUARIOS DE PRUEBA

### Administrador
- **Email:** admin@sena.edu.co
- **Contraseña:** admin123
- **Rol:** Administrador

### Instructor
- **Email:** juan.perez@sena.edu.co
- **Contraseña:** admin123
- **Rol:** Instructor

### Coordinador
- **Email:** maria.garcia@sena.edu.co
- **Contraseña:** admin123
- **Rol:** Coordinador

## 🔗 URLS

- **Login:** http://localhost/dashboard_sena/auth/login.php
- **Dashboard:** http://localhost/dashboard_sena/
- **Logout:** http://localhost/dashboard_sena/auth/logout.php

## 📁 ARCHIVOS CREADOS

```
dashboard_sena/
├── auth/
│   ├── login.php          # Página de login
│   ├── logout.php         # Cerrar sesión
│   ├── check_auth.php     # Verificar autenticación
│   └── login.sql          # Script SQL para tabla usuarios
```

## 🔧 CÓMO FUNCIONA

### 1. Login (auth/login.php)
- Usuario ingresa email y contraseña
- Sistema verifica en tabla `usuarios`
- Si es correcto, crea sesión y redirige al dashboard
- Si es incorrecto, muestra mensaje de error

### 2. Protección de Páginas
Todas las páginas del dashboard incluyen:
```php
require_once __DIR__ . '/auth/check_auth.php';
```

Esto verifica que el usuario esté logueado, si no lo redirige al login.

### 3. Logout
- Destruye la sesión
- Elimina cookies
- Redirige al login

### 4. Navbar
Muestra:
- Nombre del usuario logueado
- Rol del usuario
- Botón "Cerrar Sesión"

## 🎯 FLUJO DE AUTENTICACIÓN

```
1. Usuario accede a cualquier página del dashboard
   ↓
2. check_auth.php verifica si hay sesión activa
   ↓
3a. SI hay sesión → Muestra la página
3b. NO hay sesión → Redirige a login.php
   ↓
4. Usuario ingresa credenciales en login.php
   ↓
5. Sistema verifica en BD
   ↓
6a. Correcto → Crea sesión y redirige al dashboard
6b. Incorrecto → Muestra error
```

## 🔐 TABLA DE USUARIOS

```sql
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(200) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('Administrador', 'Instructor', 'Coordinador'),
    estado ENUM('Activo', 'Inactivo'),
    ultimo_acceso DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 🎨 DISEÑO DEL LOGIN

- **Fondo:** Gradiente verde SENA (#39A900 → #007832)
- **Layout:** Dos columnas (info + formulario)
- **Logo:** Círculo blanco con "S" verde
- **Formulario:** Campos con borde verde al focus
- **Botón:** Gradiente verde con efecto hover
- **Responsive:** Se adapta a móviles

## 🚀 PRÓXIMOS PASOS

### Agregar Más Usuarios
```sql
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Nuevo Usuario', 'usuario@sena.edu.co', '$2y$10$...', 'Instructor');
```

### Cambiar Contraseña
```php
$nueva_password = password_hash('nueva_contraseña', PASSWORD_DEFAULT);
```

### Verificar Roles en Páginas Específicas
```php
require_once __DIR__ . '/auth/check_auth.php';
verificarRol(['Administrador']); // Solo administradores
```

## 🔒 SEGURIDAD

### Contraseñas
- ✅ Encriptadas con `password_hash()` (bcrypt)
- ✅ Verificadas con `password_verify()`
- ✅ No se almacenan en texto plano

### Sesiones
- ✅ Sesiones PHP nativas
- ✅ Timeout automático
- ✅ Destrucción completa al logout

### SQL Injection
- ✅ Consultas preparadas con PDO
- ✅ Parámetros vinculados
- ✅ Sin concatenación de strings

## 📝 NOTAS

- Todos los usuarios de prueba tienen la contraseña: `admin123`
- Las contraseñas están encriptadas en la BD
- El sistema registra el último acceso de cada usuario
- Los usuarios inactivos no pueden iniciar sesión

## 🎓 PERSONALIZACIÓN

### Cambiar Logo
Editar en `auth/login.php`:
```html
<div class="logo">S</div>
```

### Cambiar Colores
Editar variables CSS en `auth/login.php`:
```css
background: linear-gradient(135deg, #39A900 0%, #007832 100%);
```

### Agregar Campos al Login
1. Agregar campo en formulario
2. Capturar en `$_POST`
3. Validar y procesar

---

**¡Sistema de Login Instalado y Funcionando!** 🎉
