<?php
header('Content-Type: application/json');
require_once '../config/database.php';

// Check if user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'User not logged in'
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    $conn = getDBConnection();
    
    // Get user's orders with order items
    $stmt = $conn->prepare("
        SELECT 
            o.id as order_id,
            o.total_amount,
            o.status,
            o.payment_method,
            o.customer_name,
            o.shipping_address,
            o.created_at,
            o.updated_at,
            COUNT(oi.id) as total_items
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        WHERE o.user_id = ?
        GROUP BY o.id
        ORDER BY o.created_at DESC
        LIMIT 10
    ");
    
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        // Get order items for each order
        $itemsStmt = $conn->prepare("
            SELECT 
                oi.quantity,
                oi.price,
                oi.product_name,
                oi.product_brand,
                oi.product_image,
                oi.product_description,
                oi.product_id
            FROM order_items oi
            WHERE oi.order_id = ?
        ");
        
        $itemsStmt->bind_param("i", $row['order_id']);
        $itemsStmt->execute();
        $itemsResult = $itemsStmt->get_result();
        
        $items = [];
        while ($item = $itemsResult->fetch_assoc()) {
            // Format image URL using stored product image
            $imageUrl = '';
            if ($item['product_image']) {
                if (strpos($item['product_image'], 'http') === 0) {
                    // Full URL
                    $imageUrl = $item['product_image'];
                } else if (strpos($item['product_image'], 'assets/') === 0) {
                    // Already has assets/ prefix, just add ../
                    $imageUrl = '../' . $item['product_image'];
                } else {
                    // Just filename, add full path
                    $imageUrl = '../assets/uploads/products/' . $item['product_image'];
                }
            } else {
                $imageUrl = '../assets/images/placeholder-product.svg';
            }
            
            $items[] = [
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'product_brand' => $item['product_brand'],
                'product_description' => $item['product_description'],
                'quantity' => (int)$item['quantity'],
                'price' => (float)$item['price'],
                'image_url' => $imageUrl,
                'item_total' => (float)$item['price'] * (int)$item['quantity']
            ];
        }
        
        // Format status for display
        $statusLabels = [
            'pending' => 'Order Placed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];
        
        $statusColors = [
            'pending' => '#fbbf24',
            'processing' => '#3b82f6',
            'shipped' => '#8b5cf6',
            'delivered' => '#10b981',
            'completed' => '#059669',
            'cancelled' => '#ef4444'
        ];
        
        $orders[] = [
            'order_id' => $row['order_id'],
            'total_amount' => (float)$row['total_amount'],
            'status' => $row['status'],
            'status_label' => $statusLabels[$row['status']] ?? ucfirst($row['status']),
            'status_color' => $statusColors[$row['status']] ?? '#6b7280',
            'payment_method' => $row['payment_method'],
            'customer_name' => $row['customer_name'],
            'shipping_address' => $row['shipping_address'],
            'total_items' => (int)$row['total_items'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'formatted_date' => date('M d, Y \a\t g:i A', strtotime($row['created_at'])),
            'items' => $items
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $orders,
        'count' => count($orders)
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching orders: ' . $e->getMessage()
    ]);
}
?>
