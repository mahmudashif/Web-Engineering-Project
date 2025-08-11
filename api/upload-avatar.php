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

// Check if file was uploaded
if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded or upload error']);
    exit;
}

$file = $_FILES['avatar'];
$user_id = $_SESSION['user_id'];

// Validate file type
$allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
$file_type = mime_content_type($file['tmp_name']);

if (!in_array($file_type, $allowed_types)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid file type. Only JPEG, PNG, and GIF are allowed']);
    exit;
}

// Validate file size (max 2MB)
if ($file['size'] > 2 * 1024 * 1024) {
    http_response_code(400);
    echo json_encode(['error' => 'File size too large. Maximum 2MB allowed']);
    exit;
}

try {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "gadegt_shop";
    
    $conn = new mysqli($servername, $username, $db_password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8");
    
    // Create uploads directory if it doesn't exist
    $upload_dir = '../assets/uploads/profile_pictures/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Generate unique filename
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_filename = 'profile_' . $user_id . '_' . time() . '.' . $file_extension;
    $upload_path = $upload_dir . $new_filename;
    $db_path = 'assets/uploads/profile_pictures/' . $new_filename;
    
    // Remove old profile picture if exists
    $old_pic_stmt = $conn->prepare("SELECT profile_picture FROM user_profiles WHERE user_id = ?");
    $old_pic_stmt->bind_param("i", $user_id);
    $old_pic_stmt->execute();
    $old_pic_result = $old_pic_stmt->get_result();
    
    if ($old_pic_result->num_rows > 0) {
        $old_pic_data = $old_pic_result->fetch_assoc();
        if ($old_pic_data['profile_picture']) {
            $old_file_path = '../' . $old_pic_data['profile_picture'];
            if (file_exists($old_file_path)) {
                unlink($old_file_path);
            }
        }
    }
    
    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
        throw new Exception('Failed to save uploaded file');
    }
    
    // Ensure user_profiles table exists with profile_picture column
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
    
    // Try to add profile_picture column if it doesn't exist (ignore error if exists)
    $check_column = $conn->query("SHOW COLUMNS FROM user_profiles LIKE 'profile_picture'");
    if ($check_column->num_rows === 0) {
        $add_column_query = "ALTER TABLE user_profiles ADD COLUMN profile_picture VARCHAR(255) NULL";
        $conn->query($add_column_query);
    }
    
    // Update user profile with new picture path
    $update_stmt = $conn->prepare("
        INSERT INTO user_profiles (user_id, profile_picture) 
        VALUES (?, ?) 
        ON DUPLICATE KEY UPDATE 
        profile_picture = VALUES(profile_picture),
        updated_at = CURRENT_TIMESTAMP
    ");
    
    $update_stmt->bind_param("is", $user_id, $db_path);
    
    if ($update_stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Profile picture updated successfully',
            'profile_picture' => $db_path
        ]);
    } else {
        throw new Exception('Failed to update database');
    }
    
    $conn->close();
    
} catch (Exception $e) {
    // Clean up uploaded file if database update failed
    if (isset($upload_path) && file_exists($upload_path)) {
        unlink($upload_path);
    }
    
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
