# Solución: Error "Duplicate entry '0' for key 'PRIMARY'"

## Problema Identificado
Las tablas NO tienen AUTO_INCREMENT configurado en sus claves primarias, por lo que cuando intentas insertar un registro sin especificar el ID, MySQL intenta usar 0 como valor predeterminado, causando el error de duplicado.

## Tablas Afectadas
- `titulo_programa` (titpro_id)
- `programa` (prog_codigo) ⚠️ ESTA ES LA QUE ESTÁ FALLANDO
- `competencia` (comp_id)
- `centro_formacion` (cent_id)
- `instructor` (inst_id)
- `coordinacion` (coord_id)
- `ficha` (fich_id)
- `sede` (sede_id)

## Solución

### Paso 1: Ejecutar Script SQL
1. Abre phpMyAdmin
2. Selecciona la base de datos `progsena`
3. Ve a la pestaña "SQL"
4. Copia y pega el contenido del archivo: `database/agregar_autoincrement.sql`
5. Haz clic en "Continuar" o "Go"

### Paso 2: Verificar los Cambios
Después de ejecutar el script, verifica que las tablas tengan AUTO_INCREMENT:

```sql
SHOW CREATE TABLE programa;
```

Deberías ver algo como:
```sql
`prog_codigo` int(11) NOT NULL AUTO_INCREMENT,
```

### Paso 3: Probar la Creación
1. Ve a: http://localhost/exportacion_proyecto/programa/crear
2. Completa el formulario:
   - Denominación del Programa: "Programación"
   - Título que Otorga: Selecciona uno
   - Tipo de Programa: Selecciona uno
3. Haz clic en "Guardar Programa"

Ahora debería funcionar correctamente sin el error de duplicado.

## ¿Por Qué Ocurrió Este Error?

El modelo `ProgramaModel.php` tiene el INSERT correcto:
```php
INSERT INTO programa (prog_denominacion, titulo_programa_titpro_id, prog_tipo) 
VALUES (?, ?, ?)
```

NO está insertando el campo `prog_codigo`, lo cual está bien. El problema es que la tabla no tiene AUTO_INCREMENT, entonces MySQL intenta usar 0 como valor predeterminado para el campo PRIMARY KEY, y como ya existe un registro con ID 0 (o es el segundo intento), genera el error "Duplicate entry '0'".

## Archivos Actualizados
✅ `database/estructura_completa_ProgSENA.sql` - Ahora incluye AUTO_INCREMENT en todas las PKs
✅ `database/agregar_autoincrement.sql` - Script para aplicar cambios a BD existente
✅ `model/ProgramaModel.php` - Ya estaba correcto (no inserta ID manualmente)

## Nota Importante
Las tablas `asignacion` y `detallexasignacion` YA tienen AUTO_INCREMENT configurado correctamente, por eso no se modificaron.
