<?php
require_once 'config/google-config.php';
require_once 'api/GoogleOAuth.php';

echo "<h2>Google OAuth Test</h2>";

// Test configuration loading
echo "<h3>Configuration Test:</h3>";
echo "Client ID: " . (defined('GOOGLE_CLIENT_ID') ? GOOGLE_CLIENT_ID : 'NOT DEFINED') . "<br>";
echo "Client Secret: " . (defined('GOOGLE_CLIENT_SECRET') ? substr(GOOGLE_CLIENT_SECRET, 0, 10) . '...' : 'NOT DEFINED') . "<br>";
echo "Redirect URI: " . (defined('GOOGLE_REDIRECT_URI') ? GOOGLE_REDIRECT_URI : 'NOT DEFINED') . "<br>";

// Test OAuth URL generation
echo "<h3>OAuth URL Test:</h3>";
try {
    $googleOAuth = new GoogleOAuth();
    $authUrl = $googleOAuth->getAuthUrl();
    echo "Auth URL generated successfully:<br>";
    echo "<a href='$authUrl' target='_blank'>$authUrl</a><br>";
} catch (Exception $e) {
    echo "Error generating auth URL: " . $e->getMessage() . "<br>";
}

echo "<h3>Direct Test:</h3>";
echo "<a href='api/google-login.php' style='padding: 10px 20px; background: #4285F4; color: white; text-decoration: none; border-radius: 5px;'>Test Google Sign-In</a>";
?>
