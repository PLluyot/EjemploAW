<?php
require_once 'config.php';

// Manejo de Inserción de Película
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_movie') {
    $titulo = $_POST['titulo'];
    $anio = $_POST['anio'];
    $genero = $_POST['genero'];
    $director_id = $_POST['director_id'];
    $poster_url = $_POST['poster_url'] ?: 'https://via.placeholder.com/600x900?text=No+Poster';
    $descripcion = $_POST['descripcion'] ?: 'Sin descripción.';

    $stmt = $pdo->prepare("INSERT INTO peliculas (titulo, anio_estreno, genero, id_director, poster_url, descripcion) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$titulo, $anio, $genero, $director_id, $poster_url, $descripcion]);
    header("Location: index.php?msg=Movie+Added");
    exit;
}

// Manejo de Inserción de Director
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_director') {
    $nombre = $_POST['nombre'];
    $nacionalidad = $_POST['nacionalidad'];
    $nacimiento = $_POST['nacimiento'];
    $oscars = $_POST['oscars'];

    $stmt = $pdo->prepare("INSERT INTO directores (nombre, nacionalidad, fecha_nacimiento, premios_oscar) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $nacionalidad, $nacimiento, $oscars]);
    header("Location: index.php?section=add-director&msg=Director+Added");
    exit;
}

// Manejo de Borrado
if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM peliculas WHERE id = ?");
    $stmt->execute([$_GET['delete_id']]);
    header("Location: index.php?msg=Movie+Deleted");
    exit;
}

// Obtener Directores para el select
$directores = $pdo->query("SELECT * FROM directores ORDER BY nombre ASC")->fetchAll();

// Obtener Películas con nombre de director
$query = "SELECT p.*, d.nombre as nombre_director 
          FROM peliculas p 
          LEFT JOIN directores d ON p.id_director = d.id 
          ORDER BY p.anio_estreno ASC";
$peliculas = $pdo->query($query)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoClub Premium | Gestión de Cine</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header>
        <div class="logo">VIDEOCLUB<span>★</span>PREMIUM</div>
        <nav>
            <ul>
                <li><a onclick="showSection('movies')" id="nav-movies" class="active">Ver Películas</a></li>
                <li><a onclick="showSection('add-movie')" id="nav-add-movie">Nueva Película</a></li>
                <li><a onclick="showSection('add-director')" id="nav-add-director">Nuevo Director</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">

        <!-- Vista de Películas -->
        <section id="movies" class="active">
            <h2>Catálogo de Películas</h2>
            <div class="movie-grid">
                <?php foreach ($peliculas as $p): ?>
                    <div class="movie-card" onclick="showMovieDetails('<?= addslashes($p['titulo']) ?>', '<?= $p['anio_estreno'] ?>', '<?= addslashes($p['genero']) ?>', '<?= addslashes($p['nombre_director']) ?>', '<?= $p['poster_url'] ?>', '<?= addslashes($p['descripcion']) ?>')">
                        <div class="poster-container" style="background: url('<?= $p['poster_url'] ?>') center/cover;">
                            <img src="<?= $p['poster_url'] ?>" alt="<?= $p['titulo'] ?> Poster">
                        </div>
                        <div class="card-content">
                            <span class="genre"><?= $p['genero'] ?></span>
                            <h3><?= $p['titulo'] ?></h3>
                            <div class="info">Año: <?= $p['anio_estreno'] ?></div>
                            <span class="director">Director: <?= $p['nombre_director'] ?></span>
                            <a href="?delete_id=<?= $p['id'] ?>" class="delete-link" onclick="event.stopPropagation(); return confirm('¿Borrar película?')">Eliminar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Detalle de Película -->
        <section id="movie-details">
            <div class="details-container">
                <button class="back-btn" onclick="showSection('movies')">← Volver al Catálogo</button>
                <div class="details-layout">
                    <div class="details-poster">
                        <img id="detail-img" src="" alt="Poster">
                    </div>
                    <div class="details-info">
                        <span id="detail-genre" class="genre"></span>
                        <h2 id="detail-title"></h2>
                        <div class="detail-meta">
                            <span id="detail-year"></span> • <span id="detail-director"></span>
                        </div>
                        <p id="detail-description"></p>
                        <div class="detail-actions">
                            <button class="primary-action">Alquilar Ahora</button>
                            <button class="secondary-action">Ver Trailer</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Formulario Alta Película -->
        <section id="add-movie">
            <h2>Registrar Nueva Película</h2>
            <div class="form-container">
                <form method="POST" action="index.php" id="form-movie">
                    <input type="hidden" name="action" value="add_movie">
                    <div class="form-group">
                        <label for="titulo">Título de la Película</label>
                        <input type="text" name="titulo" id="titulo" placeholder="Ej: Pulp Fiction" required>
                    </div>
                    <div class="form-group">
                        <label for="anio">Año de Estreno</label>
                        <input type="number" name="anio" id="anio" min="1888" max="2030" placeholder="Ej: 1994" required>
                    </div>
                    <div class="form-group">
                        <label for="genero">Género</label>
                        <input type="text" name="genero" id="genero" placeholder="Ej: Crimen/Drama" required>
                    </div>
                    <div class="form-group">
                        <label for="poster-url">URL del Poster</label>
                        <input type="text" name="poster_url" id="poster-url" placeholder="Ej: img/pelicula.png">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" placeholder="Breve trama de la película..." style="width: 100%; background: rgba(0,0,0,0.3); color: white; border: 1px solid var(--glass-border); border-radius: 12px; padding: 1rem; font-family: 'Outfit';"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="director-select">Director</label>
                        <select name="director_id" id="director-select" required>
                            <option value="">Selecciona un director...</option>
                            <?php foreach ($directores as $d): ?>
                                <option value="<?= $d['id'] ?>"><?= $d['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit">Guardar Película</button>
                </form>
            </div>
        </section>

        <!-- Formulario Alta Director -->
        <section id="add-director">
            <h2>Registrar Nuevo Director</h2>
            <div class="form-container">
                <form method="POST" action="index.php" id="form-director">
                    <input type="hidden" name="action" value="add_director">
                    <div class="form-group">
                        <label for="nombre-dir">Nombre Completo</label>
                        <input type="text" name="nombre" id="nombre-dir" placeholder="Ej: Martin Scorsese" required>
                    </div>
                    <div class="form-group">
                        <label for="nacionalidad">Nacionalidad</label>
                        <input type="text" name="nacionalidad" id="nacionalidad" placeholder="Ej: Estadounidense">
                    </div>
                    <div class="form-group">
                        <label for="nacimiento">Fecha de Nacimiento</label>
                        <input type="date" name="nacimiento" id="nacimiento">
                    </div>
                    <div class="form-group">
                        <label for="oscars">Premios Oscar</label>
                        <input type="number" name="oscars" id="oscars" min="0" value="0">
                    </div>
                    <button type="submit">Dar de Alta Director</button>
                </form>
            </div>
        </section>

    </div>

    <script>
        function showSection(sectionId) {
            // Ocultar todas las secciones
            document.querySelectorAll('section').forEach(section => {
                section.classList.remove('active');
            });
            // Desactivar todos los links
            document.querySelectorAll('nav a').forEach(link => {
                link.classList.remove('active');
            });

            // Mostrar la elegida
            const targetSection = document.getElementById(sectionId);
            if (targetSection) targetSection.classList.add('active');

            const navLink = document.getElementById('nav-' + sectionId);
            if (navLink) navLink.classList.add('active');

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Manejar la sección activa por URL (para redirecciones PHP)
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section');
        if (section) {
            showSection(section);
        } else {
            showSection('movies');
        }

        function showMovieDetails(title, year, genre, director, imgSrc, desc) {
            document.getElementById('detail-title').innerText = title;
            document.getElementById('detail-year').innerText = year;
            document.getElementById('detail-genre').innerText = genre;
            document.getElementById('detail-director').innerText = director;
            document.getElementById('detail-img').src = imgSrc;
            document.getElementById('detail-description').innerText = desc;

            showSection('movie-details');
        }
    </script>
</body>

</html>