<?php
session_start();

echo "<h2>Google Sign-In Debug</h2>";

try {
    require_once 'GoogleOAuth.php';
    echo "✓ GoogleOAuth.php loaded successfully<br>";
    
    $googleOAuth = new GoogleOAuth();
    echo "✓ GoogleOAuth object created<br>";
    
    $authUrl = $googleOAuth->getAuthUrl();
    echo "✓ Auth URL generated: <br>";
    echo "<pre>$authUrl</pre>";
    
    echo "<h3>Click to test:</h3>";
    echo "<a href='$authUrl' target='_blank' style='padding: 10px 20px; background: #4285F4; color: white; text-decoration: none; border-radius: 5px;'>Sign in with Google</a>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
}
?>
