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
    
    // Get pagination parameters
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $limit = isset($_GET['limit']) ? min(100, max(1, intval($_GET['limit']))) : 10;
    $offset = ($page - 1) * $limit;
    
    // Get search parameter
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    
    // Get category filter
    $categoryId = isset($_GET['category']) ? intval($_GET['category']) : null;
    
    // Build WHERE clause
    $whereClause = "WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($search)) {
        $whereClause .= " AND (p.name LIKE ? OR p.description LIKE ? OR p.category LIKE ?)";
        $searchParam = "%$search%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types .= "sss";
    }
    
    if ($categoryId !== null && $categoryId > 0) {
        $whereClause .= " AND p.category_id = ?";
        $params[] = $categoryId;
        $types .= "i";
    }
    
    // Get total count
    $countSql = "SELECT COUNT(*) as total FROM products p $whereClause";
    $countStmt = $conn->prepare($countSql);
    if (!empty($params)) {
        $countStmt->bind_param($types, ...$params);
    }
    $countStmt->execute();
    $totalRecords = $countStmt->get_result()->fetch_assoc()['total'];
    $countStmt->close();
    
    // Get products with category information
    $sql = "SELECT p.*, pc.name as category_name 
            FROM products p 
            LEFT JOIN product_categories pc ON p.category_id = pc.id 
            $whereClause 
            ORDER BY p.updated_at DESC, p.id DESC 
            LIMIT ? OFFSET ?";
    
    $stmt = $conn->prepare($sql);
    $params[] = $limit;
    $params[] = $offset;
    $types .= "ii";
    
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        // Format the product data
        $product = [
            'id' => (int)$row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => (float)$row['price'],
            'stock_quantity' => (int)$row['stock_quantity'],
            'image' => $row['image'],
            'brand' => $row['brand'], // Add brand field
            'category' => $row['category'], // Legacy field
            'category_id' => (int)$row['category_id'],
            'category_name' => $row['category_name'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ];
        
        $products[] = $product;
    }
    
    $stmt->close();
    
    // Calculate pagination info
    $totalPages = ceil($totalRecords / $limit);
    
    echo json_encode([
        'success' => true,
        'data' => $products,
        'pagination' => [
            'current_page' => $page,
            'per_page' => $limit,
            'total_records' => (int)$totalRecords,
            'total_pages' => $totalPages,
            'has_next' => $page < $totalPages,
            'has_prev' => $page > 1
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
