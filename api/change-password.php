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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    $input = $_POST;
}

$user_id = $_SESSION['user_id'];
$current_password = $input['current_password'] ?? '';
$new_password = $input['new_password'] ?? '';

// Validation
if (empty($current_password) || empty($new_password)) {
    http_response_code(400);
    echo json_encode(['error' => 'Current password and new password are required']);
    exit;
}

if (strlen($new_password) < 6) {
    http_response_code(400);
    echo json_encode(['error' => 'New password must be at least 6 characters long']);
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
    
    // Get current password from database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        $conn->close();
        exit;
    }
    
    $user = $result->fetch_assoc();
    
    // Verify current password
    if (!password_verify($current_password, $user['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Current password is incorrect']);
        $conn->close();
        exit;
    }
    
    // Hash new password
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Update password
    $update_stmt = $conn->prepare("UPDATE users SET password = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $update_stmt->bind_param("si", $hashed_new_password, $user_id);
    
    if ($update_stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Password updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update password');
    }
    
    $conn->close();
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
