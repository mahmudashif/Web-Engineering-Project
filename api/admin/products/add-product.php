<?php
// Set error reporting to avoid HTML error output
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../../config/database.php';

// Global error handler for unexpected errors
set_error_handler(function($severity, $message, $filename, $lineno) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
});

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
    
    // Handle both JSON and form data
    $isMultipart = strpos($_SERVER['CONTENT_TYPE'] ?? '', 'multipart/form-data') !== false;
    $isJson = strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false;
    
    if ($isJson) {
        // Get JSON data
        $input = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON data provided');
        }
    } else {
        // Get form data (including multipart for file uploads)
        $input = $_POST;
    }
    
    // Debug logging
    error_log("Content-Type: " . ($_SERVER['CONTENT_TYPE'] ?? 'not set'));
    error_log("Input data: " . print_r($input, true));
    
    // Validate required fields
    $requiredFields = ['name', 'price'];
    foreach ($requiredFields as $field) {
        if (!isset($input[$field]) || trim($input[$field]) === '') {
            throw new Exception("Field '$field' is required");
        }
    }
    
    // Extract and validate data
    $name = trim($input['name']);
    $description = isset($input['description']) ? trim($input['description']) : '';
    $price = floatval($input['price']);
    $stock_quantity = isset($input['stock_quantity']) ? intval($input['stock_quantity']) : 0;
    $category = isset($input['category']) ? trim($input['category']) : '';
    $category_id = isset($input['category_id']) ? intval($input['category_id']) : null;
    
    if ($price < 0) {
        throw new Exception('Price cannot be negative');
    }
    
    if ($stock_quantity < 0) {
        throw new Exception('Stock quantity cannot be negative');
    }
    
    // Handle image upload if present
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../../assets/uploads/products/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
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
    
    // If category_id is not provided but category name is, try to find or create the category
    if ($category_id === null && !empty($category)) {
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
    
    // Insert product
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock_quantity, image, category, category_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssdissi", $name, $description, $price, $stock_quantity, $imagePath, $category, $category_id);
    
    if ($stmt->execute()) {
        $productId = $conn->insert_id;
        
        // Get the created product
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
            'message' => 'Product added successfully',
            'data' => $product
        ]);
    } else {
        throw new Exception('Failed to add product: ' . $conn->error);
    }
    
    $stmt->close();

} catch (Exception $e) {
    // If image was uploaded but product creation failed, clean up
    if (isset($imagePath) && file_exists('../../../' . $imagePath)) {
        unlink('../../../' . $imagePath);
    }
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} catch (Error $e) {
    // Handle PHP fatal errors
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
} catch (Throwable $e) {
    // Handle any other throwable
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Unexpected error occurred'
    ]);
}
?>
