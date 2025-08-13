<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, OPTIONS');
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

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

try {
    // Check if user is admin
    requireAdminAuth();
    
    $conn = getDBConnection();
    
    // Get product ID from URL
    $productId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($productId <= 0) {
        throw new Exception('Valid product ID is required');
    }
    
    // Check if product exists
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Product not found');
    }
    
    $existingProduct = $result->fetch_assoc();
    $stmt->close();
    
    // Get PUT data
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate and extract data (use existing values if not provided)
    $name = isset($input['name']) && trim($input['name']) !== '' ? trim($input['name']) : $existingProduct['name'];
    $description = isset($input['description']) ? trim($input['description']) : $existingProduct['description'];
    $price = isset($input['price']) ? floatval($input['price']) : floatval($existingProduct['price']);
    $stock_quantity = isset($input['stock_quantity']) ? intval($input['stock_quantity']) : intval($existingProduct['stock_quantity']);
    $category = isset($input['category']) ? trim($input['category']) : $existingProduct['category'];
    $category_id = isset($input['category_id']) ? intval($input['category_id']) : intval($existingProduct['category_id']);
    
    // Ensure we have a valid category - default to 'electronics' if empty or invalid
    if (empty($category) && ($category_id === 0 || $category_id === null)) {
        $category = 'electronics';
    }
    
    if ($price < 0) {
        throw new Exception('Price cannot be negative');
    }
    
    if ($stock_quantity < 0) {
        throw new Exception('Stock quantity cannot be negative');
    }
    
    // If category_id is not provided but category name is, try to find or create the category
    if ($category_id === 0 && !empty($category)) {
        // Check if category exists
        $stmt = $conn->prepare("SELECT id FROM product_categories WHERE name = ?");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $category_id = $result->fetch_assoc()['id'];
        } else {
            // Create new category
            $stmt = $conn->prepare("INSERT INTO product_categories (name, created_at, updated_at) VALUES (?, NOW(), NOW())");
            $stmt->bind_param("s", $category);
            $stmt->execute();
            $category_id = $conn->insert_id;
        }
        $stmt->close();
    }
    
    // Update product
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock_quantity = ?, category = ?, category_id = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("ssdiisi", $name, $description, $price, $stock_quantity, $category, $category_id, $productId);
    
    if ($stmt->execute()) {
        // Get the updated product
        $stmt = $conn->prepare("SELECT p.*, pc.name as category_name FROM products p LEFT JOIN product_categories pc ON p.category_id = pc.id WHERE p.id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        
        // Format the response
        $product['id'] = (int)$product['id'];
        $product['price'] = (float)$product['price'];
        $product['stock_quantity'] = (int)$product['stock_quantity'];
        $product['category_id'] = (int)$product['category_id'];
        
        echo json_encode([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    } else {
        throw new Exception('Failed to update product: ' . $conn->error);
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
