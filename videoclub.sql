-- Script SQL para base de datos de Videoclub
-- Objetivo: Dos tablas relacionadas (Directores -> Películas) con datos de ejemplo.

CREATE DATABASE IF NOT EXISTS videoclub_db;
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

-- 2. Tabla de Películas (Relacionada con Directores)
CREATE TABLE peliculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    anio_estreno INT,
    genero VARCHAR(50),
    id_director INT,
    CONSTRAINT fk_director FOREIGN KEY (id_director) 
        REFERENCES directores(id) 
        ON DELETE SET NULL 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Inserción de datos de ejemplo
INSERT INTO directores (nombre, nacionalidad, fecha_nacimiento, premios_oscar) VALUES
('Steven Spielberg', 'Estadounidense', '1946-12-18', 3),
('Christopher Nolan', 'Británico', '1970-07-30', 2),
('Greta Gerwig', 'Estadounidense', '1983-08-04', 0),
('Quentin Tarantino', 'Estadounidense', '1963-03-27', 2),
('Hayao Miyazaki', 'Japonés', '1941-01-05', 2),
('John Lasseter', 'Estadounidense', '1957-01-12', 2);

INSERT INTO peliculas (titulo, anio_estreno, genero, id_director) VALUES
('Jurassic Park', 1993, 'Ciencia Ficción', 1),
('Schindler\'s List', 1993, 'Drama Escénico', 1),
('Inception', 2010, 'Ciencia Ficción', 2),
('Oppenheimer', 2023, 'Biópico', 2),
('Barbie', 2023, 'Fantasía/Comedia', 3),
('Pulp Fiction', 1994, 'Crimen', 4),
('El Viaje de Chihiro', 2001, 'Animación/Fantasía', 5),
('Mi Vecino Totoro', 1988, 'Animación/Fantasía', 5),
('Toy Story', 1995, 'Animación/Aventura', 6),
('Cars', 2006, 'Animación/Comedia', 6);

-- Consultas de verificación
SELECT 'TABLA DIRECTORES' AS '';
SELECT * FROM directores;

SELECT 'TABLA PELÍCULAS CON NOMBRE DE DIRECTOR' AS '';
SELECT p.titulo, p.anio_estreno, d.nombre AS director
FROM peliculas p
JOIN directores d ON p.id_director = d.id;
