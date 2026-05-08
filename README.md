# VideoClub Premium ★ Gestión de Cine

Bienvenido al sistema de gestión de **VideoClub Premium**, una aplicación web moderna diseñada para administrar un catálogo de películas y directores de cine con una interfaz fluida y una experiencia de usuario de alto nivel.

## 🚀 Funcionamiento de la Aplicación

La aplicación funciona bajo una arquitectura **SPA (Single Page Application)** simplificada sobre PHP. Aunque todo se gestiona principalmente desde `index.php`, la navegación entre secciones es instantánea gracias al uso de JavaScript para la manipulación del DOM, evitando recargas innecesarias de la página.

### Características Principales:
- **Gestión CRUD**: Permite dar de alta, visualizar y eliminar registros de la base de datos.
- **Interfaz Fluida**: Navegación dinámica entre secciones.
- **Diseño Responsive**: Adaptado para dispositivos móviles y escritorio con una estética "Glassmorphism".
- **Validación de Datos**: Control de entrada en formularios para asegurar la integridad de la información.

---

## 📄 Estructura de Páginas y Secciones

La aplicación se divide en las siguientes secciones accesibles desde el menú de navegación:

### 1. Catálogo de Películas (`#movies`)
Es la pantalla principal donde se muestran todas las películas registradas. Cada película se presenta en una tarjeta visual que incluye:
- Imagen del póster.
- Título y género.
- Año de estreno y nombre del director.
- Botón de eliminación directa.

### 2. Detalle de Película (`#movie-details`)
Al hacer clic en cualquier tarjeta del catálogo, se despliega esta sección con información extendida:
- Sinopsis/Descripción detallada.
- Póster en alta resolución.
- Metadatos completos (Año, Director, Género).
- Acciones simuladas (Alquilar, Ver Tráiler).

### 3. Registro de Nueva Película (`#add-movie`)
Formulario para añadir títulos al sistema. Requiere:
- Título, año y género.
- URL de la imagen del póster (opcional, con placeholder por defecto).
- Selección de un director existente en la base de datos.

### 4. Registro de Nuevo Director (`#add-director`)
Formulario dedicado a la gestión de autores cinematográficos, permitiendo almacenar su nacionalidad, fecha de nacimiento y número de premios Oscar obtenidos.

---

## 🗄️ Estructura de la Base de Datos

La base de datos se denomina `videoclub_db` y consta de dos tablas principales relacionadas:

### Tabla: `directores`
Almacena la información de los directores de cine.
- `id` (INT, PK): Identificador único.
- `nombre` (VARCHAR): Nombre completo.
- `nacionalidad` (VARCHAR): País de origen.
- `fecha_nacimiento` (DATE): Fecha de nacimiento.
- `premios_oscar` (INT): Cantidad de estatuillas ganadas.

### Tabla: `peliculas`
Almacena los títulos cinematográficos y su relación con los directores.
- `id` (INT, PK): Identificador único.
- `titulo` (VARCHAR): Título de la cinta.
- `anio_estreno` (INT): Año de lanzamiento.
- `genero` (VARCHAR): Género cinematográfico.
- `id_director` (INT, FK): Referencia al ID del director (Relación 1:N).
- `poster_url` (VARCHAR): Enlace a la imagen del póster.
- `descripcion` (TEXT): Resumen de la trama.

---

## 🛠️ Manual de Administración

### Instalación y Configuración
1. **Base de Datos**: Importa el archivo `videoclub.sql` en tu servidor MySQL (phpMyAdmin o consola). Esto creará la base de datos y las tablas con datos de ejemplo.
2. **Configuración PHP**:
   - Localiza el archivo `config_example.php`.
   - Renómbralo a `config.php`.
   - Edita las constantes `DB_USER` y `DB_PASS` con tus credenciales locales de MySQL.
3. **Servidor**: Asegúrate de tener un servidor compatible con PHP 7.4 o superior (XAMPP, Laragon, etc.).

### Tareas de Gestión
- **Añadir Contenido**: Se recomienda dar de alta primero a los **Directores** antes de las películas, ya que cada película requiere estar vinculada a un director existente.
- **Eliminación**: Para borrar una película, usa el enlace "Eliminar" en la tarjeta correspondiente. El sistema pedirá una confirmación antes de proceder.
- **Imágenes**: Puedes usar rutas locales (carpeta `img/`) o URLs externas para los pósters de las películas.

---

*Desarrollado para el módulo de Despliegue de Aplicaciones Web (AW).*
