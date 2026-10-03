<?php
// Incluir la conexión a la base de datos
require 'includes/db.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = htmlspecialchars($_POST['email']);
    $asunto = htmlspecialchars($_POST['asunto']);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    // Validar los datos (puedes agregar más validaciones si es necesario)
    if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
        die("Todos los campos son obligatorios.");
    }

    // Insertar el mensaje en la base de datos
    try {
        $stmt = $pdo->prepare("INSERT INTO mensajes (nombre, email, asunto, mensaje) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $email, $asunto, $mensaje]);

        // Redirigir al usuario con un mensaje de éxito
        header('Location: contacto.php?status=success');
        exit;
    } catch (PDOException $e) {
        // Manejo de errores
        die("Error al guardar el mensaje: " . $e->getMessage());
    }
} else {
    // Si el formulario no fue enviado, redirigir al formulario
    header('Location: contacto.php');
    exit;
}
?>