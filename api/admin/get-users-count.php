<?php
// API endpoint to get the total number of users
// Include admin authentication middleware
require_once '../../includes/admin-auth.php';

header('Content-Type: application/json');

try {
    // Database connection
    require_once '../../config/database.php';
    $conn = getDBConnection();
    
    // Count all users
    $stmt = $conn->prepare("SELECT COUNT(*) as user_count FROM users");
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc()['user_count'];
    
    echo json_encode([
        'success' => true,
        'count' => (int)$count
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
