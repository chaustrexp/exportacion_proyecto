# 🤝 Guía de Contribución

¡Gracias por tu interés en contribuir a ProgSENA! Esta guía te ayudará a empezar.

## 📋 Tabla de Contenidos

- [Código de Conducta](#código-de-conducta)
- [Cómo Contribuir](#cómo-contribuir)
- [Reportar Bugs](#reportar-bugs)
- [Sugerir Mejoras](#sugerir-mejoras)
- [Pull Requests](#pull-requests)
- [Estándares de Código](#estándares-de-código)

## 📜 Código de Conducta

Este proyecto se adhiere a un código de conducta. Al participar, se espera que mantengas este código.

## 🚀 Cómo Contribuir

### 1. Fork el Repositorio

```bash
# Haz fork desde GitHub, luego clona tu fork
git clone https://github.com/TU-USUARIO/exportacion_proyecto.git
cd exportacion_proyecto
```

### 2. Crea una Rama

```bash
# Crea una rama para tu feature o fix
git checkout -b feature/mi-nueva-caracteristica
# o
git checkout -b fix/correccion-de-bug
```

### 3. Realiza tus Cambios

- Escribe código limpio y bien documentado
- Sigue los estándares de código del proyecto
- Añade comentarios donde sea necesario
- Prueba tus cambios localmente

### 4. Commit tus Cambios

```bash
git add .
git commit -m "feat: descripción clara de tu cambio"
```

**Formato de mensajes de commit:**
- `feat:` Nueva característica
- `fix:` Corrección de bug
- `docs:` Cambios en documentación
- `style:` Formato, punto y coma faltantes, etc.
- `refactor:` Refactorización de código
- `test:` Añadir tests
- `chore:` Mantenimiento

### 5. Push y Pull Request

```bash
git push origin feature/mi-nueva-caracteristica
```

Luego abre un Pull Request en GitHub.

## 🐛 Reportar Bugs

### Antes de Reportar

- Verifica que el bug no haya sido reportado ya
- Asegúrate de estar usando la última versión
- Recopila información sobre el bug

### Cómo Reportar

Crea un issue con:

**Título:** Descripción breve y clara

**Descripción:**
```
## Descripción del Bug
[Descripción clara del problema]

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
- Navegador: [Chrome/Firefox/etc]

## Capturas de Pantalla
[Si aplica]

## Información Adicional
[Cualquier otro detalle relevante]
```

## 💡 Sugerir Mejoras

Para sugerir una mejora, crea un issue con:

```
## Descripción de la Mejora
[Descripción clara de la mejora]

## Motivación
[Por qué esta mejora es útil]

## Solución Propuesta
[Cómo implementarías esta mejora]

## Alternativas Consideradas
[Otras formas de lograr lo mismo]
```

## 🔄 Pull Requests

### Checklist antes de enviar

- [ ] El código sigue los estándares del proyecto
- [ ] He comentado mi código, especialmente en áreas complejas
- [ ] He actualizado la documentación si es necesario
- [ ] Mis cambios no generan nuevas advertencias
- [ ] He probado mis cambios localmente
- [ ] Los cambios funcionan en diferentes navegadores (si aplica)

### Proceso de Revisión

1. Un mantenedor revisará tu PR
2. Pueden solicitar cambios
3. Realiza los cambios solicitados
4. Una vez aprobado, se hará merge

## 📝 Estándares de Código

### PHP

```php
<?php
// Usa PSR-12 como guía base

// Nombres de clases en PascalCase
class MiClase {
    // Propiedades en camelCase
    private $miPropiedad;
    
    // Métodos en camelCase
    public function miMetodo() {
        // Código aquí
    }
}

// Constantes en MAYÚSCULAS
define('MI_CONSTANTE', 'valor');

// Siempre usa prepared statements para SQL
$stmt = $db->prepare("SELECT * FROM tabla WHERE id = ?");
$stmt->execute([$id]);
```

### HTML/CSS

```html
<!-- Usa indentación de 4 espacios -->
<div class="mi-clase">
    <p>Contenido</p>
</div>
```

```css
/* Nombres de clases descriptivos en kebab-case */
.mi-clase-especial {
    color: #39a900;
    padding: 10px;
}
```

### JavaScript

```javascript
// camelCase para variables y funciones
const miVariable = 'valor';

function miFuncion() {
    // Código aquí
}

// Usa const/let, no var
const constante = 'no cambia';
let variable = 'puede cambiar';
```

### SQL

```sql
-- Palabras clave en MAYÚSCULAS
SELECT columna1, columna2
FROM tabla
WHERE condicion = 'valor'
ORDER BY columna1;

-- Nombres de tablas y columnas en minúsculas con guión bajo
CREATE TABLE mi_tabla (
    id INT PRIMARY KEY,
    nombre VARCHAR(100)
);
```

## 🔒 Seguridad

Si encuentras una vulnerabilidad de seguridad, NO abras un issue público. En su lugar:

1. Envía un email a [email de contacto]
2. Describe la vulnerabilidad
3. Proporciona pasos para reproducirla
4. Espera respuesta antes de divulgar públicamente

## 📚 Recursos Adicionales

- [Documentación PHP](https://www.php.net/docs.php)
- [PSR-12 Coding Style](https://www.php-fig.org/psr/psr-12/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Git Basics](https://git-scm.com/book/en/v2)

## ❓ Preguntas

Si tienes preguntas, puedes:
- Abrir un issue con la etiqueta "question"
- Contactar a los mantenedores

## 🎉 ¡Gracias!

Gracias por contribuir a ProgSENA. Cada contribución, grande o pequeña, es valiosa.

---

**Última actualización:** Febrero 2026
