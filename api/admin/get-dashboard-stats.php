<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once '../../config/database.php';

try {
    $conn = getDBConnection();
    
    // Get users count
    $usersResult = $conn->query("SELECT COUNT(*) as count FROM users");
    $usersCount = $usersResult->fetch_assoc()['count'];
    
    // Get products count
    $productsResult = $conn->query("SELECT COUNT(*) as count FROM products");
    $productsCount = $productsResult->fetch_assoc()['count'];
    
    // Get orders count
    $ordersResult = $conn->query("SELECT COUNT(*) as count FROM orders");
    $ordersCount = $ordersResult->fetch_assoc()['count'];
    
    // Get total revenue
    $revenueResult = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as revenue FROM orders");
    $totalRevenue = $revenueResult->fetch_assoc()['revenue'];
    
    // Return all statistics
    echo json_encode([
        'success' => true,
        'data' => [
            'users' => intval($usersCount),
            'products' => intval($productsCount),
            'orders' => intval($ordersCount),
            'revenue' => floatval($totalRevenue)
        ]
    ]);
    
} catch (Exception $e) {
    error_log("Dashboard stats error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Database error occurred',
        'error' => $e->getMessage()
    ]);
}
?>
