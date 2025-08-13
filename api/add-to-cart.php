<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
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
        throw new Exception('Please login to add items to cart');
    }
    
    $userId = $_SESSION['user_id'];
    $conn = getDBConnection();
    
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    $productId = $input['product_id'] ?? null;
    $quantity = $input['quantity'] ?? 1;
    
    if (!$productId) {
        throw new Exception('Product ID is required');
    }
    
    // Validate quantity
    $quantity = max(1, intval($quantity));
    
    // Check if product exists and has stock
    $stmt = $conn->prepare("SELECT id, name, price, stock_quantity FROM products WHERE id = ? AND stock_quantity > 0");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Product not found or out of stock');
    }
    
    $product = $result->fetch_assoc();
    
    // Check if requested quantity is available
    if ($quantity > $product['stock_quantity']) {
        throw new Exception('Not enough stock available. Only ' . $product['stock_quantity'] . ' items left.');
    }
    
    // Check if item already exists in cart
    $stmt = $conn->prepare("SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $cartResult = $stmt->get_result();
    
    if ($cartResult->num_rows > 0) {
        // Update existing cart item
        $cartItem = $cartResult->fetch_assoc();
        $newQuantity = $cartItem['quantity'] + $quantity;
        
        // Check if new quantity exceeds stock
        if ($newQuantity > $product['stock_quantity']) {
            throw new Exception('Cannot add more items. Only ' . $product['stock_quantity'] . ' items available, and you already have ' . $cartItem['quantity'] . ' in your cart.');
        }
        
        $stmt = $conn->prepare("UPDATE cart_items SET quantity = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("ii", $newQuantity, $cartItem['id']);
        $stmt->execute();
        
        $message = 'Cart updated successfully';
        $totalQuantity = $newQuantity;
    } else {
        // Add new cart item
        $stmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $userId, $productId, $quantity);
        $stmt->execute();
        
        $message = 'Product added to cart successfully';
        $totalQuantity = $quantity;
    }
    
    // Get updated cart count
    $stmt = $conn->prepare("SELECT SUM(quantity) as total_items FROM cart_items WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $cartCount = $stmt->get_result()->fetch_assoc()['total_items'] ?? 0;
    
    echo json_encode([
        'success' => true,
        'message' => $message,
        'data' => [
            'product_id' => $productId,
            'product_name' => $product['name'],
            'quantity' => $totalQuantity,
            'cart_count' => (int)$cartCount
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
