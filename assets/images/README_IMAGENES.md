# Imágenes del Sistema Dashboard SENA

## 📸 Inventario de Imágenes

### 1. favicon.svg
- **Tipo**: Icono SVG
- **Uso**: Favicon del sitio (icono de la S de SENA en la pestaña del navegador)
- **Ubicación**: Se referencia en el `<head>` de las páginas
- **Formato**: SVG (vectorial)

### 2. foto-perfil.jpg
- **Tipo**: Fotografía
- **Uso**: Foto de perfil del administrador en el header
- **Ubicación**: Header del dashboard (esquina superior derecha)
- **Formato**: JPG
- **Descripción**: Imagen de perfil predeterminada para usuarios/administradores

### 3. ImagenFachada111124SENA.jpg
- **Tipo**: Fotografía
- **Uso**: Imagen de fondo en la página de login
- **Ubicación**: Fondo de auth/login.php
- **Formato**: JPG
- **Descripción**: Fachada del Centro de Formación SENA
- **Fecha**: 11/11/2024

### 4. sena-logo.png
- **Tipo**: Logo
- **Uso**: Logo principal del SENA en el sistema
- **Ubicación**: Header, login, documentos
- **Formato**: PNG con transparencia
- **Descripción**: Logo oficial del SENA

### 5. sena cucuta copia.jpg
- **Tipo**: Fotografía
- **Uso**: Imagen del SENA Cúcuta
- **Ubicación**: Recursos adicionales
- **Formato**: JPG
- **Descripción**: Imagen del centro SENA Cúcuta

## 🎨 Uso en el Sistema

### Login (auth/login.php)
```php
<!-- Fondo del login -->
background-image: url('assets/images/ImagenFachada111124SENA.jpg');

<!-- Logo en el formulario -->
<img src="assets/images/sena-logo.png" alt="SENA Logo">
```

### Header (views/layout/header.php)
```php
<!-- Logo en el header -->
<img src="assets/images/sena-logo.png" alt="SENA">

<!-- Foto de perfil -->
<img src="assets/images/foto-perfil.jpg" alt="Perfil">
```

### Favicon (en todas las páginas)
```html
<link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg">
```

## 📋 Especificaciones Técnicas

| Imagen | Formato | Uso Principal | Tamaño Recomendado |
|--------|---------|---------------|-------------------|
| favicon.svg | SVG | Favicon | 32x32 o escalable |
| foto-perfil.jpg | JPG | Avatar usuario | 150x150 px |
| ImagenFachada111124SENA.jpg | JPG | Fondo login | 1920x1080 px |
| sena-logo.png | PNG | Logo sistema | 200x80 px |
| sena cucuta copia.jpg | JPG | Recurso adicional | Variable |

## 🔄 Reemplazo de Imágenes

Si necesitas reemplazar alguna imagen:

1. **Mantén el mismo nombre de archivo** para evitar cambios en el código
2. **Respeta el formato** (SVG, PNG, JPG) según corresponda
3. **Optimiza el tamaño** para mejorar el rendimiento
4. **Verifica las dimensiones** recomendadas

### Ejemplo: Cambiar foto de perfil
```bash
# Reemplazar foto-perfil.jpg manteniendo el nombre
cp nueva-foto.jpg assets/images/foto-perfil.jpg
```

## 📝 Notas Importantes

- **favicon.svg**: Es vectorial, se adapta a cualquier tamaño
- **sena-logo.png**: Tiene transparencia, ideal para fondos variados
- **ImagenFachada111124SENA.jpg**: Imagen grande, considerar optimización
- Todas las rutas son relativas a la raíz del proyecto

## 🎯 Rutas de Acceso

Desde cualquier vista PHP:
```php
// Ruta relativa desde views/
../assets/images/nombre-imagen.ext

// Ruta absoluta desde raíz
assets/images/nombre-imagen.ext
```

Desde CSS:
```css
background-image: url('../images/nombre-imagen.ext');
```

---

**Última actualización**: 23 de febrero de 2026
