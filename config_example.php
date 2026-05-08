<?php

/**
 * Configuración de la base de datos
 */
//renombra el archvo a config.php

define('DB_HOST', 'localhost');
define('DB_USER', '1234'); //cambiar el usuario
define('DB_PASS', '1234'); // cambiar el passwd
define('DB_NAME', 'videoclub_db'); // cambiar el nombre de la base de datos

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
