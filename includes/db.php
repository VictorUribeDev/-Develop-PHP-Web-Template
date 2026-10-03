<?php
// Incluir la configuración de la base de datos
require_once 'config.php';

// Crear la conexión a la base de datos
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASS);

    // Configurar el manejo de errores
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Configurar el charset a UTF-8
    $pdo->exec("SET NAMES 'utf8'");

    // Mensaje de éxito (opcional, solo para desarrollo)
    // echo "Conexión exitosa a la base de datos.";

} catch (PDOException $e) {
    // Manejo de errores
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>