<?php
// Set error reporting to avoid HTML error output
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    require_once '../../../config/database.php';
    
    // Start session
    session_start();
    
    // Check request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Method not allowed');
    }
    
    // Simple admin check - for now, just check if user_id exists in session
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Authentication required - please login as admin');
    }
    
    // Get database connection
    $conn = getDBConnection();
    
    // Verify user is admin
    $userId = intval($_SESSION['user_id']);
    $stmt = $conn->prepare("SELECT id, full_name, is_admin, role FROM users WHERE id = ? AND is_active = 1");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('User not found or inactive');
    }
    
    $user = $result->fetch_assoc();
    if (!$user['is_admin'] && $user['role'] !== 'admin') {
        throw new Exception('Admin access required. Current user: ' . $user['full_name']);
    }
    
    $stmt->close();
    
    // Handle form data
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock_quantity = intval($_POST['stock_quantity'] ?? 0);
    $category_id = intval($_POST['category_id'] ?? 0) ?: null;
    
    // Validate required fields
    if (empty($name)) {
        throw new Exception('Product name is required');
    }
    
    if ($price <= 0) {
        throw new Exception('Product price must be greater than 0');
    }
    
    // Set category name based on category_id
    $category = '';
    if ($category_id) {
        $stmt = $conn->prepare("SELECT name FROM product_categories WHERE id = ?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc()['name'];
        }
        $stmt->close();
    }
    
    // Handle image upload
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../../assets/uploads/products/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $fileName;
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $fileType = $_FILES['image']['type'];
        
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception('Invalid file type. Only JPEG, PNG, and GIF are allowed.');
        }
        
        // Validate file size (5MB max)
        if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
            throw new Exception('File size too large. Maximum 5MB allowed.');
        }
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = 'assets/uploads/products/' . $fileName;
        } else {
            throw new Exception('Failed to upload image');
        }
    }
    
    // Insert product
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock_quantity, image, category, category_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssdissi", $name, $description, $price, $stock_quantity, $imagePath, $category, $category_id);
    
    if (!$stmt->execute()) {
        throw new Exception('Failed to save product: ' . $stmt->error);
    }
    
    $productId = $conn->insert_id;
    $stmt->close();
    
    // Get the created product with category info
    $stmt = $conn->prepare("
        SELECT p.*, pc.name as category_name 
        FROM products p 
        LEFT JOIN product_categories pc ON p.category_id = pc.id 
        WHERE p.id = ?
    ");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
    
    // Format response
    $product['id'] = (int)$product['id'];
    $product['price'] = (float)$product['price'];
    $product['stock_quantity'] = (int)$product['stock_quantity'];
    $product['category_id'] = (int)($product['category_id'] ?? 0);
    
    echo json_encode([
        'success' => true,
        'message' => 'Product added successfully',
        'data' => $product
    ]);

} catch (Exception $e) {
    // Clean up uploaded image if product creation failed
    if (isset($imagePath) && file_exists('../../../' . $imagePath)) {
        unlink('../../../' . $imagePath);
    }
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'debug' => [
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]
    ]);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Fatal error: ' . $e->getMessage()
    ]);
}
?>
