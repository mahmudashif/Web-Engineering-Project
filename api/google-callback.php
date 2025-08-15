<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors to user, but log them

require_once __DIR__ . '/../config/google-config.php';
require_once __DIR__ . '/GoogleOAuth.php';
require_once __DIR__ . '/../config/EnvLoader.php';

// Load environment variables
$envLoader = new EnvLoader();
$envLoader->load(__DIR__ . '/../.env');

// Database connection using environment variables
$host = $envLoader->get('DB_HOST', 'localhost');
$username = $envLoader->get('DB_USERNAME', 'root'); 
$password = $envLoader->get('DB_PASSWORD', '');
$database = $envLoader->get('DB_NAME', 'gadget_shop');

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    error_log("Database connection failed: " . $connection->connect_error);
    die("Connection failed: " . $connection->connect_error);
}

try {
    // Check for Google OAuth errors first
    if (isset($_GET['error'])) {
        $errorReason = $_GET['error'];
        $errorDescription = $_GET['error_description'] ?? 'Unknown error';
        error_log("Google OAuth Error: $errorReason - $errorDescription");
        throw new Exception("Google OAuth error: $errorReason");
    }

    // Check if we have an authorization code
    if (!isset($_GET['code'])) {
        error_log('Google OAuth: No authorization code received. GET params: ' . json_encode($_GET));
        throw new Exception('Authorization code not received');
    }
    
    $code = $_GET['code'];
    error_log('Google OAuth: Processing authorization code: ' . substr($code, 0, 20) . '...');
    
    $googleOAuth = new GoogleOAuth();
    
    // Exchange code for access token
    $accessToken = $googleOAuth->getAccessToken($code);
    error_log('Google OAuth: Access token obtained');
    
    // Get user information from Google
    $userInfo = $googleOAuth->getUserInfo($accessToken);
    error_log('Google OAuth: User info obtained for email: ' . ($userInfo['email'] ?? 'unknown'));
    
    if (!isset($userInfo['email']) || !isset($userInfo['name'])) {
        error_log('Google OAuth: Missing required user information: ' . json_encode($userInfo));
        throw new Exception('Required user information not available from Google');
    }
    
    $email = $userInfo['email'];
    $name = $userInfo['name'];
    $googleId = $userInfo['id'];
    $avatar = $userInfo['picture'] ?? null;
    
    // Check if user already exists (by email or google_id)
    $stmt = $connection->prepare("SELECT id, full_name, is_active, google_id FROM users WHERE email = ? OR google_id = ?");
    if (!$stmt) {
        throw new Exception('Database prepare error: ' . $connection->error);
    }
    
    $stmt->bind_param("ss", $email, $googleId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // User exists, log them in
        $user = $result->fetch_assoc();
        
        if ($user['is_active'] == 0) {
            throw new Exception('Your account has been deactivated. Please contact support.');
        }
        
        // Update Google ID if not set
        if (empty($user['google_id']) && !empty($googleId)) {
            $updateStmt = $connection->prepare("UPDATE users SET google_id = ?, last_login = NOW() WHERE id = ?");
            $updateStmt->bind_param("si", $googleId, $user['id']);
            $updateStmt->execute();
            $updateStmt->close();
            error_log('Google OAuth: Updated google_id for existing user');
        } else {
            // Just update last login
            $updateStmt = $connection->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $updateStmt->bind_param("i", $user['id']);
            $updateStmt->execute();
            $updateStmt->close();
        }
        
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_email'] = $email;
        
        error_log('Google OAuth: Existing user logged in: ' . $user['id']);
        
    } else {
        // Create new user with a placeholder password for OAuth users
        // Using a random hash so regular password login won't work for OAuth-only accounts
        $oauthPlaceholderPassword = password_hash('OAUTH_USER_' . $googleId . '_' . time(), PASSWORD_DEFAULT);
        
        $stmt = $connection->prepare("INSERT INTO users (full_name, email, google_id, password, is_active, created_at, last_login) VALUES (?, ?, ?, ?, 1, NOW(), NOW())");
        if (!$stmt) {
            throw new Exception('Database prepare error: ' . $connection->error);
        }
        
        $stmt->bind_param("ssss", $name, $email, $googleId, $oauthPlaceholderPassword);
        
        if (!$stmt->execute()) {
            error_log('Google OAuth: Failed to create user: ' . $stmt->error);
            throw new Exception('Failed to create user account: ' . $stmt->error);
        }
        
        $userId = $connection->insert_id;
        
        // Set session for new user
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        
        error_log('Google OAuth: New user created and logged in: ' . $userId);
    }
    
    $stmt->close();
    $connection->close();
    
    // Redirect to success page or dashboard
    header('Location: ../index.php?login_success=1&method=google');
    exit();
    
} catch (Exception $e) {
    error_log('Google OAuth Callback Error: ' . $e->getMessage());
    
    if ($connection) {
        $connection->close();
    }
    
    // Determine error type for user-friendly messages
    $errorCode = 'google_auth_failed';
    $message = $e->getMessage();
    
    if (strpos($message, 'Authorization code') !== false) {
        $errorCode = 'google_access_denied';
    } elseif (strpos($message, 'access token') !== false) {
        $errorCode = 'google_token_failed';
    } elseif (strpos($message, 'user information') !== false || strpos($message, 'user data') !== false) {
        $errorCode = 'google_user_info_failed';
    } elseif (strpos($message, 'deactivated') !== false) {
        $errorCode = 'account_deactivated';
    } elseif (strpos($message, 'Database') !== false || strpos($message, 'database') !== false) {
        $errorCode = 'database_error';
    } elseif (strpos($message, 'Network') !== false || strpos($message, 'cURL') !== false) {
        $errorCode = 'network_error';
    }
    
    header('Location: ../pages/auth/login.php?error=' . $errorCode . '&details=' . urlencode(substr($message, 0, 100)));
    exit();
}
?>
