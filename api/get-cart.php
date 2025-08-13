<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
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
        echo json_encode([
            'success' => true,
            'data' => [],
            'total_items' => 0,
            'total_amount' => 0
        ]);
        exit();
    }
    
    $userId = $_SESSION['user_id'];
    $conn = getDBConnection();
    
    // Get cart items with product details
    $sql = "SELECT 
                ci.id as cart_item_id,
                ci.quantity,
                ci.created_at as added_at,
                p.id as product_id,
                p.name,
                p.description,
                p.price,
                p.image,
                p.brand,
                p.stock_quantity,
                (ci.quantity * p.price) as item_total
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.user_id = ?
            ORDER BY ci.updated_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $cartItems = [];
    $totalItems = 0;
    $totalAmount = 0;
    
    while ($row = $result->fetch_assoc()) {
        // Format image URL
        if (!empty($row['image'])) {
            if (strpos($row['image'], 'assets/uploads/products/') === 0) {
                $row['image_url'] = '../' . $row['image'];
            } else {
                $row['image_url'] = '../assets/uploads/products/' . $row['image'];
            }
        } else {
            $row['image_url'] = '../assets/images/placeholder-product.svg';
        }
        
        // Format price
        $row['formatted_price'] = '$' . number_format($row['price'], 2);
        $row['formatted_item_total'] = '$' . number_format($row['item_total'], 2);
        
        // Check stock status
        $row['is_available'] = $row['stock_quantity'] >= $row['quantity'];
        $row['max_quantity'] = $row['stock_quantity'];
        
        $cartItems[] = $row;
        $totalItems += $row['quantity'];
        $totalAmount += $row['item_total'];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $cartItems,
        'total_items' => $totalItems,
        'total_amount' => $totalAmount,
        'formatted_total' => '$' . number_format($totalAmount, 2)
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
