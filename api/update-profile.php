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
    $dbname = "gadegt_shop";
    
    $conn = new mysqli($servername, $username, $db_password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8");
    
    // Check if profile table exists, if not create it with profile_picture column
    $create_profile_table = "CREATE TABLE IF NOT EXISTS user_profiles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        phone VARCHAR(20),
        address TEXT,
        bio TEXT,
        profile_picture VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        UNIQUE KEY unique_user (user_id)
    )";
    
    $conn->query($create_profile_table);
    
    // Add profile_picture column if it doesn't exist (for existing tables)
    $check_column = $conn->query("SHOW COLUMNS FROM user_profiles LIKE 'profile_picture'");
    if ($check_column->num_rows === 0) {
        $add_column_query = "ALTER TABLE user_profiles ADD COLUMN profile_picture VARCHAR(255) NULL";
        $conn->query($add_column_query);
    }
    
    // Update user's basic info (full name) in users table
    $stmt = $conn->prepare("UPDATE users SET full_name = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->bind_param("si", $full_name, $user_id);
    
    if (!$stmt->execute()) {
        throw new Exception('Failed to update user information');
    }
    
    // Update or insert profile information
    $profile_stmt = $conn->prepare("
        INSERT INTO user_profiles (user_id, phone, address, bio) 
        VALUES (?, ?, ?, ?) 
        ON DUPLICATE KEY UPDATE 
        phone = VALUES(phone), 
        address = VALUES(address), 
        bio = VALUES(bio),
        updated_at = CURRENT_TIMESTAMP
    ");
    
    $profile_stmt->bind_param("isss", $user_id, $phone, $address, $bio);
    
    if ($profile_stmt->execute()) {
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
