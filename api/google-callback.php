<?php
session_start();

require_once '../config/google-config.php';
require_once 'GoogleOAuth.php';

// Database connection
$host = "localhost";
$username = "root"; 
$password = "";
$database = "gadget_shop";

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

try {
    // Check if we have an authorization code
    if (!isset($_GET['code'])) {
        throw new Exception('Authorization code not received');
    }
    
    $code = $_GET['code'];
    $googleOAuth = new GoogleOAuth();
    
    // Exchange code for access token
    $accessToken = $googleOAuth->getAccessToken($code);
    
    // Get user information from Google
    $userInfo = $googleOAuth->getUserInfo($accessToken);
    
    if (!isset($userInfo['email']) || !isset($userInfo['name'])) {
        throw new Exception('Required user information not available');
    }
    
    $email = $userInfo['email'];
    $name = $userInfo['name'];
    $googleId = $userInfo['id'];
    $avatar = isset($userInfo['picture']) ? $userInfo['picture'] : null;
    
    // Check if user already exists
    $stmt = $connection->prepare("SELECT id, full_name, is_active FROM users WHERE email = ? OR google_id = ?");
    $stmt->bind_param("ss", $email, $googleId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // User exists, log them in
        $user = $result->fetch_assoc();
        
        if ($user['is_active'] == 0) {
            throw new Exception('Account is deactivated');
        }
        
        // Update Google ID if not set
        if (empty($user['google_id'])) {
            $updateStmt = $connection->prepare("UPDATE users SET google_id = ? WHERE id = ?");
            $updateStmt->bind_param("si", $googleId, $user['id']);
            $updateStmt->execute();
            $updateStmt->close();
        }
        
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_email'] = $email;
        
    } else {
        // Create new user
        $stmt = $connection->prepare("INSERT INTO users (full_name, email, google_id, password, is_active, created_at) VALUES (?, ?, ?, NULL, 1, NOW())");
        $stmt->bind_param("sss", $name, $email, $googleId);
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to create user account');
        }
        
        $userId = $connection->insert_id;
        
        // Set session for new user
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
    }
    
    $stmt->close();
    $connection->close();
    
    // Redirect to success page or dashboard
    header('Location: ../index.php?login_success=1');
    exit();
    
} catch (Exception $e) {
    error_log('Google OAuth Callback Error: ' . $e->getMessage());
    
    // Redirect back to login with error
    $errorCode = 'google_auth_failed';
    if (strpos($e->getMessage(), 'Authorization code') !== false) {
        $errorCode = 'google_access_denied';
    } elseif (strpos($e->getMessage(), 'access token') !== false) {
        $errorCode = 'google_token_failed';
    } elseif (strpos($e->getMessage(), 'user information') !== false) {
        $errorCode = 'google_user_info_failed';
    }
    
    header('Location: ../pages/auth/login.php?error=' . $errorCode);
    exit();
}
?>
