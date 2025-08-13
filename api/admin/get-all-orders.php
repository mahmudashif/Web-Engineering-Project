<?php
header('Content-Type: application/json');
require_once '../../config/database.php';
require_once '../../includes/admin-auth.php';

// Check if user is admin - admin-auth.php handles authentication
// If not admin, user will be redirected already

try {
    $conn = getDBConnection();
    
    // Get all orders with user and order details
    $stmt = $conn->prepare("
        SELECT 
            o.id as order_id,
            o.user_id,
            o.total_amount,
            o.status,
            o.payment_method,
            o.customer_name,
            o.customer_email,
            o.customer_phone,
            o.shipping_address,
            o.order_notes,
            o.created_at,
            o.updated_at,
            u.full_name as user_full_name,
            u.email as user_email,
            u.created_at as user_registered_at,
            COUNT(oi.id) as total_items,
            SUM(oi.quantity) as total_quantity
        FROM orders o
        LEFT JOIN users u ON o.user_id = u.id
        LEFT JOIN order_items oi ON o.id = oi.order_id
        GROUP BY o.id
        ORDER BY o.created_at DESC
    ");
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        // Get order items with complete product information for each order
        $itemsStmt = $conn->prepare("
            SELECT 
                oi.id as item_id,
                oi.product_id,
                oi.quantity,
                oi.price,
                oi.product_name,
                oi.product_brand,
                oi.product_image,
                oi.product_description,
                p.name as current_product_name,
                p.brand as current_product_brand,
                p.price as current_product_price,
                p.stock_quantity as current_stock,
                p.image as current_product_image
            FROM order_items oi
            LEFT JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        
        $itemsStmt->bind_param("i", $row['order_id']);
        $itemsStmt->execute();
        $itemsResult = $itemsStmt->get_result();
        
        $items = [];
        while ($item = $itemsResult->fetch_assoc()) {
            // Use stored product info (from order time) with fallback to current product info
            $productName = $item['product_name'] ?: $item['current_product_name'];
            $productBrand = $item['product_brand'] ?: $item['current_product_brand'];
            $productImage = $item['product_image'] ?: $item['current_product_image'];
            $productDescription = $item['product_description'] ?: '';
            
            // Format image URL
            $imageUrl = '';
            if ($productImage) {
                if (strpos($productImage, 'http') === 0) {
                    $imageUrl = $productImage;
                } else if (strpos($productImage, 'assets/') === 0) {
                    $imageUrl = '../../' . $productImage;
                } else {
                    $imageUrl = '../../assets/uploads/products/' . $productImage;
                }
            } else {
                $imageUrl = '../../assets/images/placeholder-product.svg';
            }
            
            $items[] = [
                'item_id' => $item['item_id'],
                'product_id' => $item['product_id'],
                'product_name' => $productName,
                'product_brand' => $productBrand,
                'product_description' => $productDescription,
                'quantity' => (int)$item['quantity'],
                'price' => (float)$item['price'],
                'item_total' => (float)$item['price'] * (int)$item['quantity'],
                'image_url' => $imageUrl,
                'current_product_price' => (float)$item['current_product_price'],
                'current_stock' => (int)$item['current_stock']
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
            'user_id' => $row['user_id'],
            'user_full_name' => $row['user_full_name'],
            'user_email' => $row['user_email'],
            'user_registered_at' => $row['user_registered_at'],
            'total_amount' => (float)$row['total_amount'],
            'status' => $row['status'],
            'status_label' => $statusLabels[$row['status']] ?? ucfirst($row['status']),
            'status_color' => $statusColors[$row['status']] ?? '#6b7280',
            'payment_method' => $row['payment_method'],
            'customer_name' => $row['customer_name'],
            'customer_email' => $row['customer_email'],
            'customer_phone' => $row['customer_phone'],
            'shipping_address' => $row['shipping_address'],
            'order_notes' => $row['order_notes'],
            'total_items' => (int)$row['total_items'],
            'total_quantity' => (int)$row['total_quantity'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'formatted_date' => date('M d, Y \a\t g:i A', strtotime($row['created_at'])),
            'items' => $items
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $orders,
        'count' => count($orders),
        'message' => 'Orders retrieved successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching orders: ' . $e->getMessage()
    ]);
}
?>
