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
    
    $conn = getDBConnection();
    
    // Get POST data
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate required fields
    if (!isset($input['name']) || trim($input['name']) === '') {
        throw new Exception("Category name is required");
    }
    
    $name = trim($input['name']);
    $description = isset($input['description']) ? trim($input['description']) : '';
    
    // Check if category already exists
    $stmt = $conn->prepare("SELECT id FROM product_categories WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        throw new Exception('Category with this name already exists');
    }
    $stmt->close();
    
    // Insert category
    $stmt = $conn->prepare("INSERT INTO product_categories (name, description, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
    $stmt->bind_param("ss", $name, $description);
    
    if ($stmt->execute()) {
        $categoryId = $conn->insert_id;
        
        // Get the created category
        $stmt = $conn->prepare("SELECT * FROM product_categories WHERE id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();
        
        // Format the response
        $category['id'] = (int)$category['id'];
        $category['product_count'] = 0;
        
        echo json_encode([
            'success' => true,
            'message' => 'Category added successfully',
            'data' => $category
        ]);
    } else {
        throw new Exception('Failed to add category: ' . $conn->error);
    }
    
    $stmt->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
