<?php
// Set error reporting to avoid HTML error output
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, OPTIONS');
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
    if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
        throw new Exception('Method not allowed');
    }
    
    // Simple admin check
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
        throw new Exception('Admin access required');
    }
    
    $stmt->close();
    
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
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON data provided');
    }
    
    // Extract data with fallbacks to existing values
    $name = isset($input['name']) && trim($input['name']) !== '' ? trim($input['name']) : $existingProduct['name'];
    $description = isset($input['description']) ? trim($input['description']) : $existingProduct['description'];
    $price = isset($input['price']) && $input['price'] > 0 ? floatval($input['price']) : floatval($existingProduct['price']);
    $stock_quantity = isset($input['stock_quantity']) && $input['stock_quantity'] >= 0 ? intval($input['stock_quantity']) : intval($existingProduct['stock_quantity']);
    
    // Handle image update
    $image = $existingProduct['image']; // Keep existing image by default
    if (isset($input['image']) && trim($input['image']) !== '') {
        $image = trim($input['image']);
    }
    
    // Handle category - use existing if not provided or empty
    $category_id = null;
    $category = '';
    
    if (isset($input['category_id']) && $input['category_id'] !== '' && $input['category_id'] !== '0') {
        $category_id = intval($input['category_id']);
        
        // Get category name
        $stmt = $conn->prepare("SELECT name FROM product_categories WHERE id = ?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc()['name'];
        }
        $stmt->close();
    } else {
        // Keep existing category, but validate it's not empty or "0"
        $category_id = $existingProduct['category_id'];
        $category = $existingProduct['category'];
        
        // If existing category is invalid, default to electronics
        if (empty($category) || $category === '0' || $category_id === 0 || $category_id === null) {
            // Find or create electronics category
            $stmt = $conn->prepare("SELECT id FROM product_categories WHERE name = 'electronics'");
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $category_id = $result->fetch_assoc()['id'];
                $category = 'electronics';
            } else {
                // Create electronics category if it doesn't exist
                $stmt = $conn->prepare("INSERT INTO product_categories (name, created_at, updated_at) VALUES ('electronics', NOW(), NOW())");
                $stmt->execute();
                $category_id = $conn->insert_id;
                $category = 'electronics';
            }
            $stmt->close();
        }
    }
    
    // Validate
    if (empty($name)) {
        throw new Exception('Product name cannot be empty');
    }
    
    if ($price <= 0) {
        throw new Exception('Product price must be greater than 0');
    }
    
    // Update product
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock_quantity = ?, image = ?, category = ?, category_id = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("ssdisisi", $name, $description, $price, $stock_quantity, $image, $category, $category_id, $productId);
    
    if (!$stmt->execute()) {
        throw new Exception('Failed to update product: ' . $stmt->error);
    }
    
    $stmt->close();
    
    // Get the updated product with category info
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
        'message' => 'Product updated successfully',
        'data' => $product
    ]);

} catch (Exception $e) {
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
