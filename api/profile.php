<?php
session_start();

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Authentication required']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Direct database connection
    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "gadget_shop";
    
    $conn = new mysqli($servername, $username, $db_password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8");
    
    $user_id = $_SESSION['user_id'];
    
    // Get user info including profile fields
    $user_stmt = $conn->prepare("SELECT full_name, email, phone, address, bio, profile_picture, created_at FROM users WHERE id = ?");
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    $user_data = $user_result->fetch_assoc();
    
    if (!$user_data) {
        throw new Exception("User not found");
    }
    
    echo json_encode([
        'success' => true,
        'user' => [
            'id' => $user_id,
            'name' => $user_data['full_name'],
            'email' => $user_data['email'],
            'phone' => $user_data['phone'] ?? '',
            'address' => $user_data['address'] ?? '',
            'bio' => $user_data['bio'] ?? '',
            'profile_picture' => $user_data['profile_picture'] ?? '',
            'created_at' => $user_data['created_at']
        ]
    ]);
    
    $conn->close();
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
