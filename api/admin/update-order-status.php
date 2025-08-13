<?php
header('Content-Type: application/json');
require_once '../../config/database.php';
require_once '../../includes/admin-auth.php';

// Check if user is admin
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['order_id']) || !isset($input['status'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Order ID and status are required']);
    exit;
}

$orderId = $input['order_id'];
$status = $input['status'];

// Validate status
$validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'completed', 'cancelled'];
if (!in_array($status, $validStatuses)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit;
}

try {
    $conn = getDBConnection();
    
    // Update order status
    $stmt = $conn->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("si", $status, $orderId);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Order status updated successfully',
                'order_id' => $orderId,
                'new_status' => $status
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Order not found']);
        }
    } else {
        throw new Exception('Failed to update order status');
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error updating order status: ' . $e->getMessage()
    ]);
}
?>
