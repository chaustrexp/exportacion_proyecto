# 📚 Documentación Completa - ProgSENA

Sistema de Gestión de Programación SENA - Guía Completa

---

# 📋 Tabla de Contenidos

1. [Información del Proyecto](#información-del-proyecto)
2. [Instalación](#instalación)
3. [Despliegue](#despliegue)
4. [Contribución](#contribución)
5. [Resumen GitHub](#resumen-github)

---

# 🎓 Información del Proyecto

Sistema web para la gestión de programación académica del SENA, incluyendo asignación de instructores, fichas, competencias y ambientes de formación.

![Version](https://img.shields.io/badge/version-2.1.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-7.4+-purple.svg)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)

## Características

- ✅ Gestión de Programas de Formación
- ✅ Administración de Competencias
- ✅ Control de Instructores y Fichas
- ✅ Asignación de Ambientes
- ✅ Calendario de Programación
- ✅ Dashboard con Estadísticas en Tiempo Real
- ✅ Sistema de Autenticación Seguro
- ✅ APIs REST para Notificaciones y Búsqueda
- ✅ URLs Limpias con Sistema de Enrutamiento

## Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7+ / MariaDB 10.3+
- Servidor web Apache con mod_rewrite
- XAMPP, WAMP, LAMP o similar

## Estructura del Proyecto

```
exportacion_proyecto/
├── api/                    # APIs REST
├── assets/                 # Recursos estáticos (CSS, JS, imágenes)
├── auth/                   # Sistema de autenticación
├── config/                 # Configuración
├── controller/             # Controladores MVC (16 archivos)
├── database/               # Scripts SQL
├── helpers/                # Funciones auxiliares
├── model/                  # Modelos de datos (14 archivos)
├── views/                  # Vistas (17 módulos)
├── .gitignore             # Archivos ignorados por Git
├── .htaccess              # Configuración Apache
├── conexion.php           # Conexión a BD
├── index.php              # Punto de entrada
└── routing.php            # Sistema de enrutamiento
```

## Módulos del Sistema (17 Módulos CRUD)

1. Ambiente - Gestión de aulas
2. Asignación - Programación de clases
3. Centro de Formación
4. Competencia
5. Competencia por Programa
6. Coordinación
7. Dashboard
8. Detalle Asignación
9. Ficha
10. Instructor-Competencia
11. Instructor
12. Perfil
13. Programa
14. Sede
15. Título Programa
16. Errores

## Tecnologías

- **Backend:** PHP 7.4+ (MVC)
- **Base de Datos:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript
- **Servidor:** Apache con mod_rewrite
- **Autenticación:** Sesiones PHP
- **Seguridad:** PDO con prepared statements

---

# 🚀 Instalación

## Instalación Rápida

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

## Acceso al Sistema

### Credenciales por Defecto

- **Usuario:** `admin`
- **Contraseña:** `admin123`

⚠️ **Importante:** Cambia estas credenciales en producción.

### URLs Principales

- **Login:** `http://localhost/exportacion_proyecto/auth/login.php`
- **Dashboard:** `http://localhost/exportacion_proyecto/`
- **Verificar Conexión:** `http://localhost/exportacion_proyecto/verificar_conexion.php`
- **Importar Datos:** `http://localhost/exportacion_proyecto/importar_datos.php`

## Solución de Problemas

### Error: Table 'progsena.competxprograma' doesn't exist

Ejecuta en phpMyAdmin:
```sql
RENAME TABLE `compet_programa` TO `competxprograma`;
RENAME TABLE `detalle_asignacion` TO `detallexasignacion`;
```

### Error de Conexión

1. Verifica que MySQL esté corriendo
2. Revisa credenciales en `conexion.php`
3. Ejecuta: `http://localhost/exportacion_proyecto/verificar_conexion.php`

### URLs no funcionan

1. Verifica que mod_rewrite esté activo en Apache
2. Asegúrate de que `.htaccess` esté en la raíz
3. Revisa `BASE_PATH` en `config/config.php`

---

# 🌐 Despliegue

## Despliegue Local (Desarrollo)

### 1. Clonar el Repositorio

```bash
cd C:/xampp/htdocs/  # Windows
# o
cd /var/www/html/    # Linux

git clone https://github.com/chaustrexp/exportacion_proyecto.git
cd exportacion_proyecto
```

### 2. Configurar Base de Datos

```bash
# Crear base de datos
mysql -u root -p -e "CREATE DATABASE progsena CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Importar estructura
mysql -u root -p progsena < database/estructura_completa_ProgSENA.sql

# Corregir nombres de tablas
mysql -u root -p progsena < database/corregir_nombre_tabla.sql

# Crear usuario admin
mysql -u root -p progsena < database/crear_admin.sql

# Datos de prueba (opcional)
mysql -u root -p progsena < database/datos_prueba.sql
```

### 3. Configurar Aplicación

```bash
# Copiar archivos de configuración
cp conexion.example.php conexion.php
cp config/config.example.php config/config.php

# Editar conexion.php con tus credenciales
nano conexion.php
```

### 4. Verificar Instalación

```
http://localhost/exportacion_proyecto/conectar_bd.php
```

## Despliegue en Servidor Compartido (cPanel)

### 1. Subir Archivos

**Opción A: Git (Recomendado)**
```bash
ssh usuario@tu-servidor.com
cd public_html
git clone https://github.com/chaustrexp/exportacion_proyecto.git
```

**Opción B: FTP**
- Usa FileZilla
- Sube todos los archivos a `public_html/exportacion_proyecto/`

### 2. Crear Base de Datos en cPanel

1. Accede a cPanel
2. Ve a "MySQL Databases"
3. Crea: `usuario_progsena`
4. Crea usuario MySQL
5. Asigna privilegios

### 3. Importar Base de Datos

1. phpMyAdmin en cPanel
2. Importa en orden:
   - `estructura_completa_ProgSENA.sql`
   - `corregir_nombre_tabla.sql`
   - `crear_admin.sql`
   - `datos_prueba.sql` (opcional)

### 4. Configurar Aplicación

```bash
cp conexion.example.php conexion.php
cp config/config.example.php config/config.php
nano conexion.php
```

Configura:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'usuario_progsena');
define('DB_USER', 'usuario_mysql');
define('DB_PASS', 'tu_password');
```

```php
define('BASE_PATH', '/exportacion_proyecto/');
define('BASE_URL', 'https://tu-dominio.com/exportacion_proyecto/');
```

### 5. Configurar Permisos

```bash
chmod 755 -R exportacion_proyecto/
chmod 644 conexion.php
chmod 644 config/config.php
```

## Despliegue en VPS (Ubuntu/Debian)

### 1. Preparar Servidor

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install apache2 mysql-server php php-mysql php-mbstring php-xml -y
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 2. Configurar MySQL

```bash
sudo mysql_secure_installation
sudo mysql -u root -p
```

```sql
CREATE DATABASE progsena CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'progsena_user'@'localhost' IDENTIFIED BY 'password_seguro';
GRANT ALL PRIVILEGES ON progsena.* TO 'progsena_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Clonar Repositorio

```bash
cd /var/www/html
sudo git clone https://github.com/chaustrexp/exportacion_proyecto.git
cd exportacion_proyecto
```

### 4. Importar Base de Datos

```bash
mysql -u progsena_user -p progsena < database/estructura_completa_ProgSENA.sql
mysql -u progsena_user -p progsena < database/corregir_nombre_tabla.sql
mysql -u progsena_user -p progsena < database/crear_admin.sql
```

### 5. Configurar Apache

```bash
sudo nano /etc/apache2/sites-available/progsena.conf
```

```apache
<VirtualHost *:80>
    ServerName tu-dominio.com
    DocumentRoot /var/www/html/exportacion_proyecto
    
    <Directory /var/www/html/exportacion_proyecto>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/progsena_error.log
    CustomLog ${APACHE_LOG_DIR}/progsena_access.log combined
</VirtualHost>
```

```bash
sudo a2ensite progsena.conf
sudo systemctl reload apache2
```

### 6. Configurar Permisos

```bash
sudo chown -R www-data:www-data /var/www/html/exportacion_proyecto
sudo chmod -R 755 /var/www/html/exportacion_proyecto
```

### 7. Configurar SSL (Opcional)

```bash
sudo apt install certbot python3-certbot-apache -y
sudo certbot --apache -d tu-dominio.com
```

## Configuración de Producción

### Seguridad

**conexion.php:**
```php
define('DB_PASS', 'password_muy_seguro_y_largo');
```

**config/config.php:**
```php
if (!$isLocal) {
    error_reporting(0);
    ini_set('display_errors', 0);
}
```

### Optimizaciones

**php.ini:**
```ini
memory_limit = 256M
upload_max_filesize = 20M
post_max_size = 20M
max_execution_time = 300
opcache.enable=1
opcache.memory_consumption=128
```

### Backup Automático

```bash
sudo nano /usr/local/bin/backup-progsena.sh
```

```bash
#!/bin/bash
BACKUP_DIR="/backups/progsena"
DATE=$(date +%Y%m%d_%H%M%S)

mysqldump -u progsena_user -p'password' progsena > "$BACKUP_DIR/db_$DATE.sql"
tar -czf "$BACKUP_DIR/files_$DATE.tar.gz" /var/www/html/exportacion_proyecto
find $BACKUP_DIR -type f -mtime +7 -delete
```

```bash
sudo chmod +x /usr/local/bin/backup-progsena.sh
sudo crontab -e
# Agregar: 0 2 * * * /usr/local/bin/backup-progsena.sh
```

## Actualización

```bash
cd /var/www/html/exportacion_proyecto
git pull origin main
mysql -u progsena_user -p progsena < database/actualizacion.sql
```

---

# 🤝 Contribución

## Cómo Contribuir

### 1. Fork el Repositorio

```bash
git clone https://github.com/TU-USUARIO/exportacion_proyecto.git
cd exportacion_proyecto
```

### 2. Crea una Rama

```bash
git checkout -b feature/mi-nueva-caracteristica
# o
git checkout -b fix/correccion-de-bug
```

### 3. Realiza tus Cambios

- Escribe código limpio y documentado
- Sigue los estándares del proyecto
- Añade comentarios
- Prueba localmente

### 4. Commit

```bash
git add .
git commit -m "feat: descripción clara"
```

**Formato de commits:**
- `feat:` Nueva característica
- `fix:` Corrección de bug
- `docs:` Documentación
- `style:` Formato
- `refactor:` Refactorización
- `test:` Tests
- `chore:` Mantenimiento

### 5. Push y Pull Request

```bash
git push origin feature/mi-nueva-caracteristica
```

## Reportar Bugs

Crea un issue con:

```
## Descripción del Bug
[Descripción clara]

## Pasos para Reproducir
1. Ve a '...'
2. Haz clic en '...'
3. Observa el error

## Comportamiento Esperado
[Qué debería pasar]

## Comportamiento Actual
[Qué está pasando]

## Entorno
- OS: [Windows/Linux/Mac]
- PHP: [versión]
- MySQL: [versión]
- Navegador: [Chrome/Firefox]

## Capturas de Pantalla
[Si aplica]
```

## Sugerir Mejoras

```
## Descripción de la Mejora
[Descripción clara]

## Motivación
[Por qué es útil]

## Solución Propuesta
[Cómo implementarla]

## Alternativas
[Otras opciones]
```

## Estándares de Código

### PHP

```php
<?php
// PSR-12

class MiClase {
    private $miPropiedad;
    
    public function miMetodo() {
        // Código
    }
}

define('MI_CONSTANTE', 'valor');

// Prepared statements
$stmt = $db->prepare("SELECT * FROM tabla WHERE id = ?");
$stmt->execute([$id]);
```

### HTML/CSS

```html
<div class="mi-clase">
    <p>Contenido</p>
</div>
```

```css
.mi-clase-especial {
    color: #39a900;
    padding: 10px;
}
```

### JavaScript

```javascript
const miVariable = 'valor';

function miFuncion() {
    // Código
}
```

### SQL

```sql
SELECT columna1, columna2
FROM tabla
WHERE condicion = 'valor'
ORDER BY columna1;
```

## Checklist Pull Request

- [ ] Código sigue estándares
- [ ] Código comentado
- [ ] Documentación actualizada
- [ ] Sin nuevas advertencias
- [ ] Probado localmente
- [ ] Funciona en diferentes navegadores

---

# 📦 Resumen GitHub

## Proyecto Subido Exitosamente

**Repositorio:** https://github.com/chaustrexp/exportacion_proyecto.git  
**Rama:** main  
**Fecha:** 23 de Febrero de 2026

## Estadísticas

- **Archivos:** 191
- **Líneas:** 20,217+
- **Commits:** 5
- **Tamaño:** ~435 KB

## Contenido

### Código Fuente
- ✅ 14 Modelos PHP
- ✅ 16 Controladores
- ✅ 68+ Vistas (17 módulos)
- ✅ Sistema de autenticación
- ✅ APIs REST
- ✅ Sistema de enrutamiento

### Base de Datos
- ✅ Estructura completa
- ✅ Datos de prueba
- ✅ Scripts de corrección
- ✅ Usuario admin

### Documentación
- ✅ README.md completo
- ✅ LICENSE (MIT)
- ✅ Esta documentación completa
- ✅ Guías de solución

### Configuración
- ✅ .gitignore
- ✅ .htaccess
- ✅ Archivos .example

## Archivos Protegidos (No Subidos)

- ❌ conexion.php
- ❌ config/config.php
- ❌ Sesiones y caché
- ❌ Logs

## Commits

1. Initial commit (191 archivos)
2. Add MIT License
3. Add contributing guidelines
4. Add deployment guide
5. Add GitHub upload summary

## Acceso

### Clonar
```bash
git clone https://github.com/chaustrexp/exportacion_proyecto.git
```

### Ver en GitHub
```
https://github.com/chaustrexp/exportacion_proyecto
```

### Descargar ZIP
```
https://github.com/chaustrexp/exportacion_proyecto/archive/refs/heads/main.zip
```

## Métricas

### Código
- PHP: ~15,000 líneas
- SQL: ~3,000 líneas
- HTML/CSS: ~2,000 líneas
- JavaScript: ~200 líneas

### Arquitectura
- Patrón: MVC
- Base de Datos: 12 tablas
- Módulos: 17 CRUD completos
- APIs: 2 endpoints

---

# 📞 Contacto y Soporte

Para preguntas o soporte:
- Abre un issue en GitHub
- Contacta al equipo de desarrollo

---

# 📝 Licencia

MIT License - Ver archivo LICENSE para detalles

---

**Versión:** 2.1.0  
**Última actualización:** Febrero 2026  
**Estado:** ✅ Producción  
**Repositorio:** https://github.com/chaustrexp/exportacion_proyecto.git
