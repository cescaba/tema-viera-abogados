# Guía de Instalación y Prueba

## Activar el Tema

1. **Ir a WordPress Admin** → `http://tu-sitio.local/wp-admin`
2. **Apariencia** → **Temas**
3. Buscar "Tema Viera Abogados"
4. Hacer clic en **Activar**

## Configuración Inicial

### Paso 1: Crear el Menú Principal (Opcional)
1. **Apariencia** → **Menús**
2. **Crear un nuevo menú** (ej: "Menú Principal")
3. Agregar elementos del menú (puedes crear páginas primero si quieres)
4. En **Configuración de menú**, marcar "Mostrar en Menú Principal"
5. **Guardar menú**

*Nota: Si no creas un menú, el tema mostrará un menú por defecto.*

### Paso 2: Editar Opciones de Landing
Esta es la parte más importante. Aquí editas TODO el contenido.

1. En el admin, verás un nuevo menú **"Opciones Landing"** en el sidebar izquierdo
2. Hacer clic en **"Opciones Landing"**
3. Completar todas las secciones:

#### **Sección Hero**
- Título Principal: "Soluciones Legales de Excelencia"
- Subtítulo: "Más de 20 años sirviendo a nuestros clientes"
- Imagen de Fondo: Hacer clic en "Seleccionar Imagen", elegir una imagen
- Texto del Botón CTA: "Contáctanos Ahora"
- URL del Botón CTA: `#contacto` (salta a la sección de contacto)

#### **Sección Sobre Nosotros**
- Título: "Sobre Nuestro Estudio"
- Contenido: Escribir párrafos sobre el estudio (soporta editor WYSIWYG completo)
- Imagen: Foto del estudio o del equipo

#### **Sección Servicios**
- Título de la Sección: "Nuestros Servicios"
- Agregar servicios:
  - Servicio 1: "Derecho Mercantil" | "Asesoría en transacciones comerciales" | Icono: "💼"
  - Servicio 2: "Derecho Laboral" | "Conflictos laborales y contratos" | Icono: "⚖️"
  - Servicio 3: "Derecho Civil" | "Asuntos civiles y familiares" | Icono: "👨‍👩‍👧"

#### **Sección Abogados**
- Título: "Nuestro Equipo de Abogados"
- Subtítulo: "Profesionales con amplia experiencia"

#### **Sección Contacto**
- Título: "Ponte en Contacto"
- Dirección: "Calle Principal 123, Madrid"
- Teléfono: "+34 900 123 456"
- Email: "info@estudioabogados.com"
- Mensaje: "Nos encantaría escuchar de ti. Rellena el formulario y nos pondremos en contacto pronto."

4. **Guardar Cambios**

### Paso 3: Agregar Abogados
Este es el Custom Post Type. Aquí agregas cada miembro del equipo.

1. En el admin, verás **"Abogados"** en el sidebar izquierdo
2. Hacer clic en **"Abogados"** → **"Agregar Nuevo"**
3. Completar:

#### **Información Básica**
- **Título**: Nombre del abogado (ej: "Juan García López")
- **Imagen destacada**: Foto profesional del abogado
- **Orden**: Número para ordenar en la lista (1, 2, 3, etc.)

#### **Meta Box: Información del Abogado**
(Aparece debajo del editor de contenido)
- **Especialidad**: "Derecho Mercantil y Corporativo"
- **Email**: "juan@estudioabogados.com"
- **Teléfono**: "+34 900 123 456"
- **LinkedIn**: "https://linkedin.com/in/juangarcia"
- **Biografía**: Texto enriquecido con su trayectoria profesional

4. **Publicar**

Repetir para cada abogado del equipo.

## Probar el Sitio

1. **Ir a la página de inicio**: `http://tu-sitio.local/`
   - Deberías ver el Hero con tu título, subtítulo e imagen
   - El resto de secciones con el contenido que agregaste

2. **Ver un abogado individual**:
   - Hacer clic en un abogado en la sección "Nuestro Equipo"
   - O ir directamente a: `http://tu-sitio.local/abogados/nombre-del-abogado`

3. **Ver listado completo de abogados**:
   - `http://tu-sitio.local/abogados/`

4. **Probar formulario de contacto**:
   - Ir a la sección "Contacto" al final
   - Rellenar el formulario

5. **Probar responsividad**:
   - Abrir en navegador mobile
   - El sitio debe verse bien en todos los tamaños

## Personalización Adicional

### Cambiar Logo
1. **Apariencia** → **Logo Personalizado**
2. Subir tu logo
3. Se mostrará en el header

### Cambiar Colores
1. Editar `wp-content/themes/tema-viera-abogados/style.css`
2. Modificar las variables CSS al inicio del archivo:
   ```css
   --color-primary: #1a3a52;      /* Cambiar azul principal */
   --color-secondary: #d4af37;    /* Cambiar dorado */
   ```

### Agregar Más Campos a Abogados
1. Editar `wp-content/themes/tema-viera-abogados/inc/metaboxes-abogados.php`
2. Agregar nuevos campos en la función `mi_tema_render_abogado_metabox()`
3. Procesar guardado en `mi_tema_save_abogado_metabox()`

## Troubleshooting

### El tema no aparece activado
- Asegúrate de que el directorio está en: `/wp-content/themes/tema-viera-abogados/`
- Verificar que existe `style.css` y `functions.php` en la raíz
- Ir a Apariencia > Temas, debería aparecer "Tema Viera Abogados"

### Las imágenes no aparecen
- Verificar que seleccionaste las imágenes correctamente en el admin
- Ir a Medios y comprobar que las imágenes están subidas
- En "Opciones Landing", los botones de "Seleccionar Imagen" deben abrir la media library

### El menú no aparece
- El tema tiene un menú por defecto si no configuras uno
- Para usar el tuyo, ir a Apariencia > Menús y asignarlo a "Menú Principal"

### Los estilos CSS no aplican
- Limpiar el caché del navegador (Ctrl+F5 o Cmd+Shift+R)
- Verificar que los estilos se están cargando: Ver código fuente > <head>

## Soporte

Para reportar problemas, verificar:
1. Que WordPress 5.0+ está instalado
2. Que PHP 7.4+ está activo
3. Que el tema está en la carpeta correcta
4. Que los permisos de carpeta son correctos (755)

¡El tema está listo para usar! 🎉
