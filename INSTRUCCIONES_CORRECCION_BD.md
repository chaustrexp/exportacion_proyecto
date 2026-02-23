# 🔧 Instrucciones para Corregir la Base de Datos

## Problemas Identificados

### 1. Falta AUTO_INCREMENT en las tablas
Las siguientes tablas NO tienen AUTO_INCREMENT en sus claves primarias:
- ✗ `titulo_programa` (titpro_id)
- ✗ `programa` (prog_codigo) ← **ESTE CAUSA EL ERROR**
- ✗ `competencia` (comp_id)
- ✗ `centro_formacion` (cent_id)
- ✗ `instructor` (inst_id)
- ✗ `coordinacion` (coord_id)
- ✗ `ficha` (fich_id)
- ✗ `sede` (sede_id)

### 2. Faltan campos en la tabla `ficha`
La tabla `ficha` necesita estos campos adicionales:
- ✗ `fich_numero` (VARCHAR)
- ✗ `fich_fecha_ini_lectiva` (DATE)
- ✗ `fich_fecha_fin_lectiva` (DATE)

## 🎯 Solución en 3 Pasos

### Paso 1: Verificar el Estado Actual
1. Abre tu navegador
2. Ve a: `http://localhost/exportacion_proyecto/verificar_autoincrement.php`
3. Verás qué tablas tienen problemas

### Paso 2: Ejecutar el Script de Corrección
1. Abre phpMyAdmin: `http://localhost/phpmyadmin`
2. En el panel izquierdo, haz clic en la base de datos **`progsena`**
3. Haz clic en la pestaña **"SQL"** (arriba)
4. Abre el archivo: `database/SOLUCION_COMPLETA.sql`
5. Copia TODO el contenido del archivo
6. Pégalo en el cuadro de texto de phpMyAdmin
7. Haz clic en el botón **"Continuar"** o **"Go"**
8. Espera a que termine (verás mensajes de confirmación)

### Paso 3: Verificar que Funcionó
1. Vuelve a: `http://localhost/exportacion_proyecto/verificar_autoincrement.php`
2. Todas las tablas deberían mostrar ✓ AUTO_INCREMENT
3. Prueba crear un programa: `http://localhost/exportacion_proyecto/programa/crear`
4. Debería funcionar sin errores

## 📋 ¿Qué Hace el Script?

El script `SOLUCION_COMPLETA.sql` realiza estas acciones:

1. **Agrega AUTO_INCREMENT** a 8 tablas (titulo_programa, programa, competencia, centro_formacion, instructor, coordinacion, ficha, sede)

2. **Agrega campos faltantes** a la tabla ficha:
   - `fich_numero` - Número de la ficha
   - `fich_fecha_ini_lectiva` - Fecha de inicio
   - `fich_fecha_fin_lectiva` - Fecha de fin

3. **Verifica** que todo quedó correcto mostrando:
   - Estructura de las tablas
   - Campos con AUTO_INCREMENT
   - Conteo de registros

## ⚠️ Importante

- El script es **seguro** - NO borra datos
- Verifica si los campos ya existen antes de agregarlos
- Puedes ejecutarlo múltiples veces sin problemas
- Si ya tienes datos en las tablas, se mantendrán

## 🐛 Si Aún Tienes Errores

### Error: "Duplicate entry '0' for key 'PRIMARY'"
- Significa que el AUTO_INCREMENT no se aplicó
- Reinicia Apache en XAMPP/WAMP
- Vuelve a ejecutar el script

### Error: "Unknown column 'fich_numero'"
- Significa que los campos de ficha no se agregaron
- Verifica que seleccionaste la base de datos `progsena`
- Vuelve a ejecutar el script

### Error: "Table doesn't exist"
- Verifica que estás en la base de datos correcta: `progsena`
- Verifica que las tablas existen en phpMyAdmin

## 📞 Archivos de Ayuda

- `database/SOLUCION_COMPLETA.sql` - Script principal (USAR ESTE)
- `database/agregar_autoincrement.sql` - Solo AUTO_INCREMENT
- `database/agregar_campos_faltantes.sql` - Solo campos de ficha
- `verificar_autoincrement.php` - Verificar estado de las tablas

## ✅ Resultado Esperado

Después de ejecutar el script correctamente:

1. ✓ Puedes crear programas sin error
2. ✓ Puedes crear fichas con número y fechas
3. ✓ Puedes crear coordinaciones
4. ✓ Puedes crear instructores
5. ✓ Puedes crear competencias
6. ✓ Todos los formularios funcionan correctamente

## 🔗 Enlaces Rápidos

- Base de datos: `progsena`
- phpMyAdmin: http://localhost/phpmyadmin
- Verificar AUTO_INCREMENT: http://localhost/exportacion_proyecto/verificar_autoincrement.php
- Sistema: http://localhost/exportacion_proyecto/
- Login: admin@sena.edu.co / admin123
