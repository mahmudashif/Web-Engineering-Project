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
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Invalid JSON input');
    }

    // Validate required fields
    if (!isset($input['billing']) || !isset($input['payment']) || !isset($input['items']) || !isset($input['totals'])) {
        throw new Exception('Missing required fields');
    }

    $billing = $input['billing'];
    $payment = $input['payment'];
    $items = $input['items'];
    $totals = $input['totals'];

    // Validate billing information
    $requiredBillingFields = ['firstName', 'lastName', 'email', 'phone', 'address', 'city', 'postalCode'];
    foreach ($requiredBillingFields as $field) {
        if (empty($billing[$field])) {
            throw new Exception("Missing billing field: $field");
        }
    }

    // Validate payment method
    $allowedPaymentMethods = ['cod', 'bkash', 'nagad', 'visa'];
    if (!in_array($payment['method'], $allowedPaymentMethods)) {
        throw new Exception('Invalid payment method');
    }

    // Validate items
    if (empty($items)) {
        throw new Exception('No items in order');
    }

    $conn = getDBConnection();
    $conn->begin_transaction();

    try {
        // Verify user's cart items and check stock
        $cartItems = [];
        $placeholderIds = str_repeat('?,', count($items) - 1) . '?';
        $productIds = array_column($items, 'product_id');
        
        $stmt = $conn->prepare("
            SELECT ci.product_id, ci.quantity, p.name, p.price, p.stock_quantity 
            FROM cart_items ci 
            JOIN products p ON ci.product_id = p.id 
            WHERE ci.user_id = ? AND ci.product_id IN ($placeholderIds)
        ");
        
        $stmt->bind_param('i' . str_repeat('i', count($productIds)), $userId, ...$productIds);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $cartItems[$row['product_id']] = $row;
        }

        // Validate each item
        $calculatedTotal = 0;
        foreach ($items as $item) {
            $productId = $item['product_id'];
            $requestedQuantity = $item['quantity'];
            
            if (!isset($cartItems[$productId])) {
                throw new Exception("Product ID $productId not found in cart");
            }
            
            $cartItem = $cartItems[$productId];
            
            // Check if requested quantity matches cart
            if ($cartItem['quantity'] != $requestedQuantity) {
                throw new Exception("Quantity mismatch for product: {$cartItem['name']}");
            }
            
            // Check stock availability
            if ($cartItem['stock_quantity'] < $requestedQuantity) {
                throw new Exception("Insufficient stock for product: {$cartItem['name']}. Only {$cartItem['stock_quantity']} available");
            }
            
            $calculatedTotal += $cartItem['price'] * $requestedQuantity;
        }

        // Verify total amount (allowing small floating point differences)
        $expectedSubtotal = round($calculatedTotal, 2);
        $providedSubtotal = round($totals['subtotal'], 2);
        
        if (abs($expectedSubtotal - $providedSubtotal) > 0.01) {
            throw new Exception("Total amount mismatch. Expected: $expectedSubtotal, Provided: $providedSubtotal");
        }

        // Create order
        $fullName = $billing['firstName'] . ' ' . $billing['lastName'];
        $shippingAddress = $billing['address'] . ', ' . $billing['city'] . ', ' . $billing['postalCode'];
        
        $stmt = $conn->prepare("
            INSERT INTO orders (
                user_id, 
                total_amount, 
                status, 
                payment_method,
                customer_name,
                customer_email,
                customer_phone,
                shipping_address,
                order_notes,
                created_at, 
                updated_at
            ) VALUES (?, ?, 'pending', ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        
        $stmt->bind_param(
            'idssssss', 
            $userId, 
            $totals['total'], 
            $payment['method'],
            $fullName,
            $billing['email'],
            $billing['phone'],
            $shippingAddress,
            $billing['orderNotes']
        );
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to create order');
        }
        
        $orderId = $conn->insert_id;

        // Add order items
        $stmt = $conn->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price, created_at) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        
        foreach ($items as $item) {
            $productId = $item['product_id'];
            $cartItem = $cartItems[$productId];
            
            $stmt->bind_param(
                'iiid', 
                $orderId, 
                $productId, 
                $item['quantity'], 
                $cartItem['price']
            );
            
            if (!$stmt->execute()) {
                throw new Exception('Failed to add order item');
            }
        }

        // Update product stock
        foreach ($items as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];
            
            $stmt = $conn->prepare("
                UPDATE products 
                SET stock_quantity = stock_quantity - ?, updated_at = NOW() 
                WHERE id = ?
            ");
            $stmt->bind_param('ii', $quantity, $productId);
            
            if (!$stmt->execute()) {
                throw new Exception('Failed to update product stock');
            }
        }

        // Clear user's cart
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
        $stmt->bind_param('i', $userId);
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to clear cart');
        }

        // Commit transaction
        $conn->commit();

        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Order placed successfully!',
            'data' => [
                'order_id' => $orderId,
                'total' => $totals['total'],
                'payment_method' => $payment['method'],
                'status' => 'pending'
            ]
        ]);

    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
