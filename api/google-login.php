<?php
// Redirect to Google OAuth
require_once '../config/google-config.php';
require_once 'GoogleOAuth.php';

try {
    $googleOAuth = new GoogleOAuth();
    $authUrl = $googleOAuth->getAuthUrl();
    
    // Redirect to Google OAuth
    header('Location: ' . $authUrl);
    exit();
} catch (Exception $e) {
    // Handle error - redirect back to login with error
    error_log('Google OAuth Error: ' . $e->getMessage());
    header('Location: ../pages/auth/login.php?error=google_config_failed');
    exit();
}
?>
