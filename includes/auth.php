<?php
session_start();

// Función para iniciar sesión
function login($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, username, password_hash FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    return false;
}

// Función para cerrar sesión
function logout() {
    session_unset();
    session_destroy();
}

// Función para verificar si el usuario está autenticado
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

// Función para redirigir a usuarios no autenticados
function requireAuth() {
    if (!isAuthenticated()) {
        header('Location: login.php');
        exit;
    }
}
?>