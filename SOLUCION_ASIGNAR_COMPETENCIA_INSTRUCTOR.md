# Solución: No se puede asignar competencia a instructor

## Problema
Al intentar asignar una competencia a un instructor, aparece el mensaje:
> "Por favor seleccione una combinación de Programa y Competencia"

## Causa
El sistema requiere que primero exista una relación entre el Programa y la Competencia en la tabla `competxprograma`. Si esta tabla está vacía, no hay combinaciones válidas para seleccionar.

## Solución

### Opción 1: Usar la Interfaz Web (RECOMENDADO)

1. **Ir al módulo "Competencias por Programa"**
   - En el menú lateral, busca la sección "Competencias por Programa"
   - Haz clic en "Nueva Relación" o el botón "+"

2. **Crear la asociación**
   - Selecciona un Programa (ejemplo: "gestion documental -- prog_122")
   - Selecciona una Competencia
   - Guarda la relación

3. **Repetir para todas las combinaciones necesarias**
   - Crea todas las relaciones entre programas y competencias que necesites
   - Por ejemplo:
     - Programa "Gestión Documental" → Competencia "Organizar documentos"
     - Programa "Gestión Documental" → Competencia "Archivar información"
     - Programa "Desarrollo de Software" → Competencia "Programar aplicaciones"

4. **Ahora podrás asignar competencias a instructores**
   - Vuelve a "Asignar Competencia a Instructor"
   - Ahora verás las combinaciones disponibles en el select

### Opción 2: Usar SQL (Para administradores)

Si prefieres crear las relaciones directamente en la base de datos:

1. **Ejecuta el script de verificación**
   ```sql
   -- Ver programas disponibles
   SELECT prog_codigo, prog_denominacion FROM programa;
   
   -- Ver competencias disponibles
   SELECT comp_id, comp_nombre_corto FROM competencia;
   ```

2. **Crear las relaciones**
   ```sql
   -- Ejemplo: Asociar competencia 1 con programa 122
   INSERT INTO competxprograma (PROGRAMA_prog_id, COMPETENCIA_comp_id) 
   VALUES (122, 1);
   
   -- Ejemplo: Asociar competencia 2 con programa 122
   INSERT INTO competxprograma (PROGRAMA_prog_id, COMPETENCIA_comp_id) 
   VALUES (122, 2);
   ```

3. **Verificar las relaciones creadas**
   ```sql
   SELECT cp.*, 
          p.prog_denominacion as programa,
          c.comp_nombre_corto as competencia
   FROM competxprograma cp
   LEFT JOIN programa p ON cp.PROGRAMA_prog_id = p.prog_codigo
   LEFT JOIN competencia c ON cp.COMPETENCIA_comp_id = c.comp_id;
   ```

## Flujo Correcto del Sistema

```
1. Crear Programas
   ↓
2. Crear Competencias
   ↓
3. Asociar Competencias con Programas (Competencias por Programa)
   ↓
4. Asignar Competencias a Instructores
   ↓
5. Crear Asignaciones (Instructor + Ficha + Ambiente)
```

## Validación del Sistema

El sistema valida que:
- La combinación Programa + Competencia exista en `competxprograma`
- Si no existe, muestra el mensaje de error
- Esto asegura la integridad de los datos

## Archivos Relacionados

- `controller/InstruCompetenciaController.php` - Contiene la validación
- `views/instru_competencia/crear.php` - Formulario de asignación
- `database/crear_relaciones_competencia_programa.sql` - Script de ayuda

## Notas Importantes

1. **No puedes saltarte el paso de asociar Competencias con Programas**
   - Es un requisito del sistema para mantener la integridad de datos

2. **Cada programa puede tener múltiples competencias**
   - Crea todas las asociaciones que necesites

3. **Las competencias deben estar asociadas al programa correcto**
   - Asegúrate de que las competencias correspondan al programa

## Ejemplo Práctico

Si tienes:
- Programa: "Gestión Documental" (ID: 122)
- Competencias:
  - "Organizar documentos" (ID: 1)
  - "Archivar información" (ID: 2)
  - "Gestionar correspondencia" (ID: 3)

Debes crear 3 relaciones en "Competencias por Programa":
1. Gestión Documental → Organizar documentos
2. Gestión Documental → Archivar información
3. Gestión Documental → Gestionar correspondencia

Luego podrás asignar cualquiera de estas 3 competencias a los instructores que enseñan "Gestión Documental".

---

**Fecha:** 24 de Febrero de 2026  
**Estado:** Documentado
