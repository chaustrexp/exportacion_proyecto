# Instrucciones de Instalación - ProgSENA

## Requisitos Previos
- XAMPP, WAMP, MAMP o cualquier servidor local con PHP y MySQL
- phpMyAdmin instalado (viene incluido con XAMPP/WAMP)
- PHP 7.4 o superior

## Pasos para Configurar la Base de Datos

### 1. Iniciar los Servicios
- Abre XAMPP/WAMP Control Panel
- Inicia el servicio **Apache**
- Inicia el servicio **MySQL**

### 2. Acceder a phpMyAdmin
- Abre tu navegador
- Ve a: `http://localhost/phpmyadmin`
- Usuario por defecto: `root`
- Contraseña por defecto: (vacía)

### 3. Importar la Base de Datos

#### Opción A: Importar el archivo SQL completo
1. En phpMyAdmin, haz clic en la pestaña **"Importar"**
2. Haz clic en **"Seleccionar archivo"**
3. Busca y selecciona el archivo: `database/estructura_completa_ProgSENA.sql`
4. Haz clic en **"Continuar"** o **"Go"** en la parte inferior
5. Espera a que se complete la importación

#### Opción B: Crear manualmente y luego importar
1. En phpMyAdmin, haz clic en **"Nueva"** en el panel izquierdo
2. Nombre de la base de datos: `progsena`
3. Cotejamiento: `utf8_general_ci`
4. Haz clic en **"Crear"**
5. Selecciona la base de datos `progsena` en el panel izquierdo
6. Ve a la pestaña **"Importar"**
7. Selecciona el archivo `database/estructura_completa_ProgSENA.sql`
8. Haz clic en **"Continuar"**

### 4. Verificar la Instalación
Después de importar, deberías ver las siguientes tablas en phpMyAdmin:
- ambiente
- asignacion
- centro_formacion
- competencia
- competxprograma
- coordinacion
- detallexasignacion
- ficha
- instructor
- programa
- sede
- titulo_programa

### 5. Configurar el Proyecto

#### Verificar la Conexión
El archivo `conexion.php` ya está configurado con:
- Host: `localhost`
- Base de datos: `progsena`
- Usuario: `root`
- Contraseña: (vacía)

Si tu configuración de MySQL es diferente, edita el archivo `conexion.php` y cambia los valores:
```php
define('DB_HOST', 'localhost');     // Tu host
define('DB_NAME', 'progsena');      // Nombre de tu base de datos
define('DB_USER', 'root');          // Tu usuario MySQL
define('DB_PASS', '');              // Tu contraseña MySQL
```

### 6. Colocar el Proyecto en el Servidor

#### Para XAMPP:
- Copia la carpeta del proyecto a: `C:\xampp\htdocs\progsena`
- Accede desde: `http://localhost/progsena`

#### Para WAMP:
- Copia la carpeta del proyecto a: `C:\wamp64\www\progsena`
- Accede desde: `http://localhost/progsena`

#### Para MAMP:
- Copia la carpeta del proyecto a: `/Applications/MAMP/htdocs/progsena`
- Accede desde: `http://localhost:8888/progsena`

### 7. Abrir el Proyecto
- Abre tu navegador
- Ve a: `http://localhost/progsena` (o la ruta correspondiente)
- Deberías ver la página de inicio del proyecto

## Solución de Problemas Comunes

### Error: "Access denied for user 'root'@'localhost'"
- Verifica que MySQL esté iniciado en XAMPP/WAMP
- Verifica el usuario y contraseña en `conexion.php`
- En phpMyAdmin, ve a "Cuentas de usuario" y verifica las credenciales

### Error: "Unknown database 'progsena'"
- Asegúrate de haber importado correctamente el archivo SQL
- Verifica que la base de datos `progsena` exista en phpMyAdmin

### Error: "Table doesn't exist"
- Reimporta el archivo `database/estructura_completa_ProgSENA.sql`
- Asegúrate de que todas las tablas se hayan creado correctamente

### El proyecto no carga (página en blanco)
- Verifica que Apache esté iniciado
- Revisa los logs de error de PHP en XAMPP/WAMP
- Asegúrate de que el proyecto esté en la carpeta correcta (htdocs o www)

## Próximos Pasos
Una vez que el proyecto esté funcionando:
1. Puedes comenzar a agregar datos de prueba desde phpMyAdmin
2. O usar las interfaces del proyecto para crear registros
3. Revisar la documentación adicional en los archivos README del proyecto

## Contacto y Soporte
Si encuentras problemas, revisa los archivos de documentación en:
- `README.md` - Información general del proyecto
- `auth/README_LOGIN.md` - Información sobre el sistema de autenticación
- `controller/README_CONTROLADORES.md` - Información sobre los controladores
