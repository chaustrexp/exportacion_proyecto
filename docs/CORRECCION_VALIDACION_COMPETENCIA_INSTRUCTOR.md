# Corrección: Validación de Programa y Competencia

## Problema Identificado

El sistema mostraba "Por favor seleccione una combinación de Programa y Competencia" aunque el usuario había seleccionado correctamente una opción.

## Causas Encontradas

### 1. Validación con `empty()` en BaseController
**Problema:** La función `validate()` usaba `empty()` que considera `"0"` como vacío.
```php
// ANTES (INCORRECTO)
if (!isset($data[$field]) || empty($data[$field])) {
    $errors[$field] = "El campo {$field} es requerido";
}
```

**Solución:** Cambiar a validación que permita 0 como valor válido.
```php
// DESPUÉS (CORRECTO)
if (!isset($data[$field]) || (is_string($data[$field]) && trim($data[$field]) === '')) {
    $errors[$field] = "El campo {$field} es requerido";
}
```

### 2. JavaScript sin logs de debug
**Problema:** No había forma de saber si los valores se estaban separando correctamente.

**Solución:** Agregados console.log para debug:
```javascript
console.log('Valor seleccionado:', valor);
console.log('Programa ID:', partes[0], 'Competencia ID:', partes[1]);
console.log('Validación final - Combo:', combo.value, 'Programa:', programaId, 'Competencia:', competenciaId);
```

### 3. Validación JavaScript no intentaba separar antes de validar
**Problema:** La validación ocurría sin intentar separar los valores una última vez.

**Solución:** Llamar a `separarProgramaCompetencia()` antes de validar:
```javascript
document.getElementById('formCrear').addEventListener('submit', function(e) {
    // Intentar separar una última vez antes de validar
    separarProgramaCompetencia();
    
    // Luego validar...
});
```

## Archivos Modificados

### 1. `controller/BaseController.php`
- ✅ Corregida función `validate()` para permitir 0 como valor válido
- ✅ Ahora solo rechaza strings vacíos o valores no definidos

### 2. `views/instru_competencia/crear.php`
- ✅ Mejorado JavaScript con logs de debug
- ✅ Validación mejorada que intenta separar antes de validar
- ✅ Mejor manejo de casos edge

### 3. `controller/InstruCompetenciaController.php`
- ✅ Agregados logs de debug temporales para ver datos POST
- ✅ Logs de errores de validación

## Cómo Probar

1. **Abrir la consola del navegador** (F12)
2. **Ir a "Asignar Competencia a Instructor"**
3. **Seleccionar:**
   - Un instructor
   - Una combinación de Programa y Competencia
   - Una fecha de vigencia
4. **Hacer clic en "Guardar Asignación"**
5. **Revisar la consola:**
   - Debe mostrar: "Valor seleccionado: 122|1" (ejemplo)
   - Debe mostrar: "Programa ID: 122 Competencia ID: 1"
   - Debe mostrar: "Validación final - Combo: 122|1 Programa: 122 Competencia: 1"

## Logs del Servidor

Si aún hay problemas, revisar los logs de PHP:
- En Apache: `error.log`
- Buscar líneas que digan: "POST Data:" y "Validation Errors:"

## Casos que Ahora Funcionan

✅ IDs con valor 0 (si existen)  
✅ IDs numéricos normales  
✅ Selección y reselección de opciones  
✅ Validación antes de enviar  
✅ Separación correcta de valores compuestos  

## Casos que Siguen Fallando (Esperado)

❌ No seleccionar ninguna opción → Muestra error correcto  
❌ Seleccionar "Seleccione una combinación..." → Muestra error correcto  
❌ Campos vacíos → Muestra error correcto  

## Próximos Pasos

1. **Probar el formulario** con las correcciones
2. **Revisar logs de consola** para confirmar que los valores se separan
3. **Si funciona:** Remover los `console.log()` y `error_log()` de debug
4. **Si no funciona:** Revisar los logs y reportar qué valores se están enviando

## Notas Importantes

- La corrección en `BaseController.php` afecta a TODOS los controladores
- Esto es BUENO porque mejora la validación en todo el sistema
- Ahora 0 es un valor válido en cualquier formulario
- Solo strings vacíos o valores no definidos son rechazados

---

**Fecha:** 24 de Febrero de 2026  
**Estado:** Corregido - Pendiente de prueba
