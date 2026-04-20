-- Script SQL completo para la base de datos de Videoclub
-- Objetivo: Crear base de datos desde cero con soporte para pósters y descripciones.
Drop database if exists videoclub_db;
CREATE DATABASE videoclub_db;
USE videoclub_db;

-- Eliminar tablas si existen para evitar conflictos
DROP TABLE IF EXISTS peliculas;
DROP TABLE IF EXISTS directores;

-- 1. Tabla de Directores
CREATE TABLE directores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    nacionalidad VARCHAR(50),
    fecha_nacimiento DATE,
    premios_oscar INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabla de Películas
CREATE TABLE peliculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    anio_estreno INT,
    genero VARCHAR(50),
    id_director INT,
    poster_url VARCHAR(255) DEFAULT 'https://via.placeholder.com/600x900?text=No+Poster',
    descripcion TEXT,
    CONSTRAINT fk_director FOREIGN KEY (id_director) 
        REFERENCES directores(id) 
        ON DELETE SET NULL 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Inserción de Directores
INSERT INTO directores (id, nombre, nacionalidad, fecha_nacimiento, premios_oscar) VALUES
(1, 'Steven Spielberg', 'Estadounidense', '1946-12-18', 3),
(2, 'Christopher Nolan', 'Británico', '1970-07-30', 2),
(3, 'Greta Gerwig', 'Estadounidense', '1983-08-04', 0),
(4, 'Quentin Tarantino', 'Estadounidense', '1963-03-27', 2),
(5, 'Hayao Miyazaki', 'Japonés', '1941-01-05', 2),
(6, 'John Lasseter', 'Estadounidense', '1957-01-12', 2);

-- 4. Inserción de Películas con Pósters y Descripciones
INSERT INTO peliculas (titulo, anio_estreno, genero, id_director, poster_url, descripcion) VALUES
('Jurassic Park', 1993, 'Ciencia Ficción', 1, 'img/jurassic_park.png', 'Un millonario construye un parque temático con dinosaurios clonados, pero las cosas salen terriblemente mal cuando los sistemas de seguridad fallan.'),
('Schindler\'s List', 1993, 'Drama Escénico', 1, 'img/schindlers_list.png', 'En la Polonia ocupada por los alemanes durante la Segunda Guerra Mundial, el industrial Oskar Schindler se preocupa por su fuerza laboral judía tras presenciar su persecución.'),
('Inception', 2010, 'Ciencia Ficción', 2, 'img/inception.png', 'Un ladrón que roba secretos corporativos a través del uso de la tecnología de compartir sueños tiene la tarea inversa de plantar una idea en la mente de un CEO.'),
('Oppenheimer', 2023, 'Biópico', 2, 'img/oppenheimer.png', 'La historia del científico estadounidense J. Robert Oppenheimer y su papel en el desarrollo de la bomba atómica.'),
('Barbie', 2023, 'Fantasía/Comedia', 3, 'img/barbie.png', 'Barbie sufre una crisis que la lleva a cuestionar su mundo y su existencia, embarcándose en un viaje al mundo real.'),
('Pulp Fiction', 1994, 'Crimen', 4, 'img/pulp_fiction.png', 'Las vidas de dos sicarios de la mafia, un boxeador, la esposa de un gánster y un par de bandidos de cafetería se entrelazan en cuatro historias de violencia y redención.'),
('El Viaje de Chihiro', 2001, 'Animación/Fantasía', 5, 'img/spirited_away.png', 'Durante el traslado de su familia al campo, una niña de 10 años deambula por un mundo gobernado por dioses, brujas y espíritus.'),
('Mi Vecino Totoro', 1988, 'Animación/Fantasía', 5, 'img/totoro.png', 'Cuando dos niñas se mudan al campo para estar cerca de su madre enferma, tienen aventuras con los espíritus del bosque que viven cerca.'),
('Toy Story', 1995, 'Animación/Aventura', 6, 'img/toy_story.png', 'Un muñeco vaquero se siente profundamente amenazado y celoso cuando una nueva figura de acción de un guardián espacial lo reemplaza como el juguete favorito en la habitación de un niño.'),
('Cars', 2006, 'Animación/Comedia', 6, 'img/cars.png', 'Un coche de carreras novato y ambicioso que busca el éxito aprende que la vida se trata del viaje, no de la línea de meta.');

-- Verificación
SELECT p.titulo, d.nombre AS director, p.poster_url 
FROM peliculas p 
JOIN directores d ON p.id_director = d.id
ORDER BY p.anio_estreno ASC;
