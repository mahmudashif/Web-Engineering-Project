<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
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

try {
    // Check if user is admin
    requireAdminAuth();
    
    $conn = getDBConnection();
    
    // Get all categories with product counts
    $sql = "SELECT pc.*, 
                   COUNT(p.id) as product_count
            FROM product_categories pc 
            LEFT JOIN products p ON pc.id = p.category_id 
            GROUP BY pc.id 
            ORDER BY pc.name";
    
    $result = $conn->query($sql);
    
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $category = [
            'id' => (int)$row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'product_count' => (int)$row['product_count'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ];
        
        $categories[] = $category;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $categories
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
