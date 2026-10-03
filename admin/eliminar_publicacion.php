<?php
require '../includes/auth.php';
requireAuth(); // Redirige a login.php si no está autenticado

// Conexión a la base de datos
require '../includes/db.php';

// Verificar si se proporcionó un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar las imágenes asociadas a la publicación
    $stmt = $pdo->prepare("DELETE FROM imagenes WHERE publicacion_id = ?");
    $stmt->execute([$id]);

    // Eliminar la publicación
    $stmt = $pdo->prepare("DELETE FROM publicaciones WHERE id = ?");
    $stmt->execute([$id]);

    // Redirigir al panel de control con un mensaje de éxito
    header('Location: index.php?status=deleted');
    exit;
} else {
    // Redirigir si no se proporcionó un ID válido
    header('Location: index.php');
    exit;
}
?>