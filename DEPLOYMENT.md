# 🚀 Guía de Despliegue

Esta guía te ayudará a desplegar ProgSENA en diferentes entornos.

## 📋 Tabla de Contenidos

- [Requisitos Previos](#requisitos-previos)
- [Despliegue Local](#despliegue-local)
- [Despliegue en Servidor Compartido](#despliegue-en-servidor-compartido)
- [Despliegue en VPS](#despliegue-en-vps)
- [Configuración de Producción](#configuración-de-producción)
- [Mantenimiento](#mantenimiento)

## ✅ Requisitos Previos

- PHP 7.4 o superior
- MySQL 5.7+ / MariaDB 10.3+
- Apache con mod_rewrite habilitado
- Acceso SSH (para VPS)
- Git instalado

## 💻 Despliegue Local (Desarrollo)

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
nano conexion.php  # o usa tu editor favorito
```

### 4. Verificar Instalación

Abre en tu navegador:
```
http://localhost/exportacion_proyecto/conectar_bd.php
```

## 🌐 Despliegue en Servidor Compartido (cPanel)

### 1. Subir Archivos

**Opción A: Git (Recomendado)**
```bash
# Conecta por SSH
ssh usuario@tu-servidor.com

# Navega al directorio público
cd public_html

# Clona el repositorio
git clone https://github.com/chaustrexp/exportacion_proyecto.git
```

**Opción B: FTP**
- Usa FileZilla o similar
- Sube todos los archivos a `public_html/exportacion_proyecto/`

### 2. Crear Base de Datos en cPanel

1. Accede a cPanel
2. Ve a "MySQL Databases"
3. Crea una nueva base de datos: `usuario_progsena`
4. Crea un usuario MySQL
5. Asigna el usuario a la base de datos con todos los privilegios

### 3. Importar Base de Datos

1. Ve a phpMyAdmin en cPanel
2. Selecciona la base de datos creada
3. Importa en orden:
   - `database/estructura_completa_ProgSENA.sql`
   - `database/corregir_nombre_tabla.sql`
   - `database/crear_admin.sql`
   - `database/datos_prueba.sql` (opcional)

### 4. Configurar Aplicación

```bash
# Copia archivos de configuración
cp conexion.example.php conexion.php
cp config/config.example.php config/config.php

# Edita conexion.php
nano conexion.php
```

Configura:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'usuario_progsena');
define('DB_USER', 'usuario_mysql');
define('DB_PASS', 'tu_password');
```

Edita `config/config.php`:
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

## 🖥️ Despliegue en VPS (Ubuntu/Debian)

### 1. Preparar Servidor

```bash
# Actualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar LAMP stack
sudo apt install apache2 mysql-server php php-mysql php-mbstring php-xml -y

# Habilitar mod_rewrite
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 2. Configurar MySQL

```bash
# Asegurar MySQL
sudo mysql_secure_installation

# Crear base de datos
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

### 5. Configurar Aplicación

```bash
cp conexion.example.php conexion.php
cp config/config.example.php config/config.php

sudo nano conexion.php
sudo nano config/config.php
```

### 6. Configurar Apache

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
# Habilitar sitio
sudo a2ensite progsena.conf
sudo systemctl reload apache2
```

### 7. Configurar Permisos

```bash
sudo chown -R www-data:www-data /var/www/html/exportacion_proyecto
sudo chmod -R 755 /var/www/html/exportacion_proyecto
```

### 8. Configurar SSL (Opcional pero Recomendado)

```bash
# Instalar Certbot
sudo apt install certbot python3-certbot-apache -y

# Obtener certificado SSL
sudo certbot --apache -d tu-dominio.com
```

## 🔒 Configuración de Producción

### 1. Seguridad

**conexion.php:**
```php
// Usa credenciales seguras
define('DB_PASS', 'password_muy_seguro_y_largo');
```

**config/config.php:**
```php
// Desactivar errores en producción
if (!$isLocal) {
    error_reporting(0);
    ini_set('display_errors', 0);
}
```

### 2. Optimizaciones

**php.ini:**
```ini
; Aumentar límites
memory_limit = 256M
upload_max_filesize = 20M
post_max_size = 20M
max_execution_time = 300

; Habilitar OPcache
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
```

### 3. Backup Automático

```bash
# Crear script de backup
sudo nano /usr/local/bin/backup-progsena.sh
```

```bash
#!/bin/bash
BACKUP_DIR="/backups/progsena"
DATE=$(date +%Y%m%d_%H%M%S)

# Backup de base de datos
mysqldump -u progsena_user -p'password' progsena > "$BACKUP_DIR/db_$DATE.sql"

# Backup de archivos
tar -czf "$BACKUP_DIR/files_$DATE.tar.gz" /var/www/html/exportacion_proyecto

# Eliminar backups antiguos (más de 7 días)
find $BACKUP_DIR -type f -mtime +7 -delete
```

```bash
# Hacer ejecutable
sudo chmod +x /usr/local/bin/backup-progsena.sh

# Agregar a crontab (diario a las 2 AM)
sudo crontab -e
0 2 * * * /usr/local/bin/backup-progsena.sh
```

## 🔄 Actualización del Sistema

### Actualizar desde Git

```bash
cd /var/www/html/exportacion_proyecto
git pull origin main

# Si hay cambios en la base de datos
mysql -u progsena_user -p progsena < database/actualizacion.sql
```

### Rollback

```bash
# Ver commits
git log --oneline

# Volver a un commit anterior
git checkout <commit-hash>

# O crear una rama de la versión anterior
git checkout -b rollback-version <commit-hash>
```

## 🛠️ Mantenimiento

### Logs

```bash
# Ver logs de Apache
sudo tail -f /var/log/apache2/progsena_error.log

# Ver logs de MySQL
sudo tail -f /var/log/mysql/error.log
```

### Monitoreo

```bash
# Verificar espacio en disco
df -h

# Verificar uso de memoria
free -m

# Verificar procesos
top
```

### Limpieza

```bash
# Limpiar logs antiguos
sudo find /var/log -type f -name "*.log" -mtime +30 -delete

# Limpiar caché de PHP (si aplica)
sudo service php7.4-fpm restart
```

## 📞 Soporte

Si encuentras problemas durante el despliegue:

1. Revisa los logs de error
2. Verifica la configuración
3. Consulta la documentación
4. Abre un issue en GitHub

## ✅ Checklist de Despliegue

- [ ] Base de datos creada e importada
- [ ] Archivos de configuración copiados y editados
- [ ] Permisos configurados correctamente
- [ ] mod_rewrite habilitado
- [ ] SSL configurado (producción)
- [ ] Backups automáticos configurados
- [ ] Credenciales de admin cambiadas
- [ ] Errores de PHP desactivados (producción)
- [ ] Sistema probado y funcionando

---

**Última actualización:** Febrero 2026
