# Tema Viera Abogados

Tema profesional 100% nativo de WordPress para landing page de estudio de abogados. Sin plugins, sin frameworks externos, solo PHP nativo de WordPress.

## Características

✅ **100% Nativo** - Solo PHP nativo de WordPress, sin dependencias externas
✅ **Totalmente Editable desde Admin** - Todas las opciones editables desde el panel de administración
✅ **Custom Post Type** - Sistema completo de gestión de abogados
✅ **Meta Boxes Nativos** - Información completa de cada abogado sin ACF
✅ **Panel de Opciones** - Gestión centralizada de toda la landing page
✅ **Responsive Mobile-First** - Diseño moderno y adaptativo
✅ **Seguridad** - Nonces, sanitización y verificación de permisos en todos lados
✅ **Accesibilidad** - HTML5 semántico y buenas prácticas

## Instalación

1. Descargar el tema en `/wp-content/themes/tema-viera-abogados`
2. Ir a **Apariencia > Temas** en el admin de WordPress
3. Activar el tema "Tema Viera Abogados"
4. ¡Listo! El tema está activo

## Primeros Pasos

### 1. Configurar Menú Principal
- Ir a **Apariencia > Menús**
- Crear un menú y asignarlo a "Menú Principal"
- (Opcional) Crear otro para "Menú Footer"

### 2. Editar Opciones de Landing
- Ir a **Opciones Landing** en el menú principal
- Completar todas las secciones:
  - **Hero**: Título, subtítulo, imagen de fondo, CTA
  - **Sobre Nosotros**: Título, contenido, imagen
  - **Servicios**: Agregar entre 3 y 6 servicios
  - **Sección Abogados**: Títulos y subtítulos
  - **Contacto**: Información de contacto y mensaje
- **Guardar Cambios**

### 3. Agregar Abogados
- Ir a **Abogados** en el menú principal
- Hacer clic en **Agregar Nuevo**
- Completar:
  - **Título**: Nombre del abogado
  - **Imagen destacada**: Foto del abogado
  - **Información del Abogado** (Meta Box):
    - Especialidad
    - Email
    - Teléfono
    - LinkedIn (opcional)
    - Biografía completa
  - Usar el campo **Orden** para reordenar abogados (mediante drag-and-drop)
- **Publicar**

### 4. Visualizar en la Web
- La landing page se muestra en la página de inicio
- Cada abogado tiene su página individual en `/abogados/nombre-del-abogado`
- Listado completo disponible en `/abogados/`

## Estructura del Tema

```
tema-viera-abogados/
├── style.css                      # Estilos principales
├── functions.php                  # Configuración del tema
├── header.php                     # HTML head y apertura
├── footer.php                     # Cierre HTML
├── front-page.php                 # Página de inicio
├── single-abogado.php             # Página individual abogado
├── archive-abogado.php            # Listado de abogados
├── inc/
│   ├── cpt-abogados.php          # Custom Post Type
│   ├── metaboxes-abogados.php    # Meta Boxes
│   └── admin-opciones-landing.php # Panel de opciones
├── template-parts/
│   ├── header.php                # Componente header
│   ├── footer.php                # Componente footer
│   └── abogado-card.php          # Card de abogado
├── js/
│   └── main.js                   # JavaScript
└── README.md                      # Esta documentación
```

## Opciones Disponibles en Admin

### Menú "Opciones Landing"

**Sección Hero**
- `Título Principal` - Texto principal del hero
- `Subtítulo/Descripción` - Descripción corta
- `Imagen de Fondo` - Imagen de fondo del hero
- `Texto del Botón CTA` - Texto del botón principal
- `URL del Botón CTA` - Destino del botón

**Sección Sobre Nosotros**
- `Título` - Título de la sección
- `Contenido` - Texto enriquecido (WYSIWYG)
- `Imagen` - Imagen de la sección

**Sección Servicios**
- `Título de la Sección` - Título principal
- `Servicios` - Hasta 6 servicios con:
  - Título
  - Descripción
  - Icono (emoji o clase)

**Sección Abogados**
- `Título` - Título de la sección
- `Subtítulo` - Descripción

**Sección Contacto**
- `Título` - Título de la sección
- `Dirección` - Dirección del estudio
- `Teléfono` - Número de teléfono
- `Email` - Email de contacto
- `Mensaje` - Texto o descripción

## Personalización

### Cambiar Colores
Editar las variables CSS en `style.css`:
```css
:root {
  --color-primary: #1a3a52;      /* Azul oscuro */
  --color-secondary: #d4af37;    /* Dorado */
  --color-accent: #2c5aa0;       /* Azul claro */
  /* etc... */
}
```

### Cambiar Tipografía
Las fuentes están definidas en variables CSS en `style.css`.

### Agregar Campos Personalizados
Para agregar más campos a los abogados:
1. Editar `inc/metaboxes-abogados.php`
2. Agregar nuevo campo en `mi_tema_render_abogado_metabox()`
3. Agregar guardado en `mi_tema_save_abogado_metabox()`

## Seguridad

El tema implementa todas las buenas prácticas de seguridad:

✅ **Nonces** - Verificación de tokens CSRF en todos los formularios
✅ **Sanitización** - Todos los inputs se sanitizan antes de guardar
✅ **Escapado** - Todo output se escapa según el contexto
✅ **Verificación de Permisos** - Se verifica `current_user_can()` en admin
✅ **Validación de Autosave** - No se procesan autosaves en meta boxes

## Desarrollo

### Agregar Funciones Personalizadas
Crear un archivo en la carpeta `/inc/` y incluirlo en `functions.php`:
```php
require_once MI_TEMA_ABOGADOS_PATH . '/inc/mi-archivo.php';
```

### Modificar Templates
Los templates pueden editarse directamente en el tema. Los principales son:
- `front-page.php` - Landing page
- `single-abogado.php` - Página individual
- `archive-abogado.php` - Listado
- `template-parts/` - Componentes reutilizables

## Soporte de Funciones WordPress

- ✅ Logo personalizado
- ✅ Imagen destacada
- ✅ Menús personalizados
- ✅ Editor Gutenberg (completo)
- ✅ Feeds RSS
- ✅ HTML5
- ✅ WP-CLI compatible

## Información

**Versión:** 1.0.0
**Requiere:** WordPress 5.0+, PHP 7.4+
**Licencia:** GPL v2 o posterior
**Autor:** VC Studio


