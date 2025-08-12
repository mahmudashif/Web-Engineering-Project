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
$full_name = trim($input['full_name'] ?? '');
$phone = trim($input['phone'] ?? '');
$address = trim($input['address'] ?? '');
$bio = trim($input['bio'] ?? '');

// Validation
if (empty($full_name)) {
    http_response_code(400);
    echo json_encode(['error' => 'Full name is required']);
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
    
    // Update user's profile information directly in users table
    $stmt = $conn->prepare("UPDATE users SET full_name = ?, phone = ?, address = ?, bio = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->bind_param("ssssi", $full_name, $phone, $address, $bio, $user_id);
    
    if ($stmt->execute()) {
        // Update session with new name
        $_SESSION['user_name'] = $full_name;
        
        echo json_encode([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => [
                'id' => $user_id,
                'name' => $full_name,
                'email' => $_SESSION['user_email'],
                'phone' => $phone,
                'address' => $address,
                'bio' => $bio
            ]
        ]);
    } else {
        throw new Exception('Failed to update profile information');
    }
    
    $conn->close();
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
