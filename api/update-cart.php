<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../config/database.php';
session_start();

try {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Please login to modify cart');
    }
    
    $userId = $_SESSION['user_id'];
    $conn = getDBConnection();
    
    $cartItemId = $_GET['id'] ?? null;
    if (!$cartItemId) {
        throw new Exception('Cart item ID is required');
    }
    
    // Verify cart item belongs to user
    $stmt = $conn->prepare("SELECT ci.*, p.name, p.stock_quantity FROM cart_items ci JOIN products p ON ci.product_id = p.id WHERE ci.id = ? AND ci.user_id = ?");
    $stmt->bind_param("ii", $cartItemId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Cart item not found');
    }
    
    $cartItem = $result->fetch_assoc();
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Remove item from cart
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $cartItemId, $userId);
        $stmt->execute();
        
        $message = 'Item removed from cart';
        
    } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // Update quantity
        $input = json_decode(file_get_contents('php://input'), true);
        $quantity = $input['quantity'] ?? 1;
        $quantity = max(1, intval($quantity));
        
        // Check stock availability
        if ($quantity > $cartItem['stock_quantity']) {
            throw new Exception('Not enough stock available. Only ' . $cartItem['stock_quantity'] . ' items left.');
        }
        
        $stmt = $conn->prepare("UPDATE cart_items SET quantity = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
        $stmt->bind_param("iii", $quantity, $cartItemId, $userId);
        $stmt->execute();
        
        $message = 'Cart updated successfully';
    }
    
    // Get updated cart count
    $stmt = $conn->prepare("SELECT SUM(quantity) as total_items FROM cart_items WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $cartCount = $stmt->get_result()->fetch_assoc()['total_items'] ?? 0;
    
    echo json_encode([
        'success' => true,
        'message' => $message,
        'cart_count' => (int)$cartCount
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
