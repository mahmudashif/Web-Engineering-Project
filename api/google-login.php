<?php
session_start();

// Redirect to Google OAuth
require_once __DIR__ . '/../config/google-config.php';
require_once __DIR__ . '/GoogleOAuth.php';

try {
    $googleOAuth = new GoogleOAuth();
    $authUrl = $googleOAuth->getAuthUrl();
    
    // Log for debugging
    error_log('Google OAuth redirect URL: ' . $authUrl);
    
    // Redirect to Google OAuth
    header('Location: ' . $authUrl);
    exit();
} catch (Exception $e) {
    // Handle error - redirect back to login with error
    error_log('Google OAuth Login Error: ' . $e->getMessage());
    
    // Create user-friendly error message
    $errorParam = 'google_config_failed';
    if (strpos($e->getMessage(), 'configuration') !== false) {
        $errorParam = 'google_config_error';
    }
    
    header('Location: ../pages/auth/login.php?error=' . $errorParam);
    exit();
}
?>
