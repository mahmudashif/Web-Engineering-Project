<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE, OPTIONS');
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

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
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
    
    // Check if product exists and get image path for cleanup
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Product not found');
    }
    
    $product = $result->fetch_assoc();
    $imagePath = $product['image'];
    $stmt->close();
    
    // Check if product is referenced in orders (prevent deletion if so)
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM order_items WHERE product_id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $orderCount = $result->fetch_assoc()['count'];
    $stmt->close();
    
    if ($orderCount > 0) {
        throw new Exception('Cannot delete product. It is referenced in existing orders.');
    }
    
    // Delete product
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    
    if ($stmt->execute()) {
        // Clean up image file if it exists
        if ($imagePath && file_exists('../../../' . $imagePath)) {
            unlink('../../../' . $imagePath);
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete product: ' . $conn->error);
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
