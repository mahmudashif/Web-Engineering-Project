<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../../config/database.php';

// Admin authentication check
session_start();

function requireAdminAuth() {
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Authentication required');
    }
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT id, is_admin, role FROM users WHERE id = ? AND is_active = 1");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('User not found or inactive');
    }
    
    $user = $result->fetch_assoc();
    if (!$user['is_admin'] && $user['role'] !== 'admin') {
        throw new Exception('Admin access required');
    }
    
    $stmt->close();
    return $user;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

try {
    // Check if user is admin
    requireAdminAuth();
    
    // Check if file was uploaded
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('No image file uploaded or upload error occurred');
    }
    
    $uploadDir = '../../../assets/uploads/products/';
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $file = $_FILES['image'];
    $fileName = time() . '_' . basename($file['name']);
    $targetPath = $uploadDir . $fileName;
    
    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    $fileType = $file['type'];
    
    if (!in_array($fileType, $allowedTypes)) {
        throw new Exception('Invalid file type. Only JPEG, PNG, and GIF are allowed.');
    }
    
    // Validate file size (5MB max)
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new Exception('File size too large. Maximum 5MB allowed.');
    }
    
    // Additional validation using getimagesize
    $imageInfo = getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        throw new Exception('Invalid image file.');
    }
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $relativePath = 'assets/uploads/products/' . $fileName;
        
        echo json_encode([
            'success' => true,
            'message' => 'Image uploaded successfully',
            'data' => [
                'path' => $relativePath,
                'filename' => $fileName
            ]
        ]);
    } else {
        throw new Exception('Failed to upload image');
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
