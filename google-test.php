<?php
echo "<h2>Google OAuth System Test</h2>";

// Test 1: Check if environment variables are loaded
require_once 'config/google-config.php';

echo "<h3>1. Configuration Test:</h3>";
echo "✅ GOOGLE_CLIENT_ID: " . (defined('GOOGLE_CLIENT_ID') && !empty(GOOGLE_CLIENT_ID) ? 'Loaded' : 'Missing') . "<br>";
echo "✅ GOOGLE_CLIENT_SECRET: " . (defined('GOOGLE_CLIENT_SECRET') && !empty(GOOGLE_CLIENT_SECRET) ? 'Loaded' : 'Missing') . "<br>";
echo "✅ GOOGLE_REDIRECT_URI: " . (defined('GOOGLE_REDIRECT_URI') && !empty(GOOGLE_REDIRECT_URI) ? 'Loaded (' . GOOGLE_REDIRECT_URI . ')' : 'Missing') . "<br><br>";

// Test 2: Test GoogleOAuth class
echo "<h3>2. GoogleOAuth Class Test:</h3>";
try {
    require_once 'api/GoogleOAuth.php';
    $googleOAuth = new GoogleOAuth();
    $authUrl = $googleOAuth->getAuthUrl();
    echo "✅ GoogleOAuth class working<br>";
    echo "✅ Auth URL generated successfully<br>";
    echo "🔗 <a href='$authUrl' target='_blank' style='color: blue;'>Test Google Sign-In</a><br><br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br><br>";
}

// Test 3: Database connection
echo "<h3>3. Database Test:</h3>";
$host = "localhost";
$username = "root"; 
$password = "";
$database = "gadegt_shop";

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    echo "❌ Database connection failed<br>";
} else {
    echo "✅ Database connection successful<br>";
    
    // Check if google_id column exists
    $result = $connection->query("DESCRIBE users");
    $hasGoogleId = false;
    while ($row = $result->fetch_assoc()) {
        if ($row['Field'] === 'google_id') {
            $hasGoogleId = true;
            break;
        }
    }
    
    if ($hasGoogleId) {
        echo "✅ google_id column exists in users table<br>";
    } else {
        echo "❌ google_id column missing - run migration<br>";
    }
}

$connection->close();

echo "<br><h3>4. Quick Test Links:</h3>";
echo "<a href='pages/auth/login.php' style='padding: 10px; background: #4285F4; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>Test Login Page</a><br><br>";
echo "<a href='pages/auth/register.php' style='padding: 10px; background: #34A853; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>Test Register Page</a><br><br>";
?>
