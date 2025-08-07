<?php
// Session management utility functions

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['user_id'],
        'name' => $_SESSION['user_name'] ?? '',
        'email' => $_SESSION['user_email'] ?? ''
    ];
}

function requireAuth() {
    if (!isLoggedIn()) {
        header('Location: pages/auth/login.php');
        exit;
    }
}

function redirectIfLoggedIn($redirect_to = 'index.php') {
    if (isLoggedIn()) {
        header("Location: $redirect_to");
        exit;
    }
}

function logout() {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
