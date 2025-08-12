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
    $dbname = "gadget_shop";
    
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
    $old_pic_stmt = $conn->prepare("SELECT profile_picture FROM users WHERE id = ?");
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
    
    // Update user profile with new picture path directly in users table
    $update_stmt = $conn->prepare("UPDATE users SET profile_picture = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $update_stmt->bind_param("si", $db_path, $user_id);
    
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
