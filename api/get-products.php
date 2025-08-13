<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../config/database.php';

try {
    $conn = getDBConnection();
    
    // Get filter parameters
    $category = $_GET['category'] ?? '';
    $search = $_GET['search'] ?? '';
    $min_price = $_GET['min_price'] ?? 0;
    $max_price = $_GET['max_price'] ?? PHP_INT_MAX;
    $sort_by = $_GET['sort_by'] ?? 'id';
    $sort_order = $_GET['sort_order'] ?? 'DESC';
    $limit = $_GET['limit'] ?? 12;
    $offset = $_GET['offset'] ?? 0;
    
    // Build query
    $where_conditions = [
        "stock_quantity > 0"
    ]; // Only show products in stock
    $params = [];
    $param_types = '';
    
    // Category filter
    if (!empty($category) && $category !== 'all') {
        $where_conditions[] = "category = ?";
        $params[] = $category;
        $param_types .= 's';
    }
    
    // Search filter - search in name, description, and brand
    if (!empty($search)) {
        $where_conditions[] = "(name LIKE ? OR description LIKE ? OR brand LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $param_types .= 'sss';
    }
    
    // Price filter
    if ($min_price > 0) {
        $where_conditions[] = "price >= ?";
        $params[] = $min_price;
        $param_types .= 'd';
    }
    
    if ($max_price < PHP_INT_MAX) {
        $where_conditions[] = "price <= ?";
        $params[] = $max_price;
        $param_types .= 'd';
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    // Validate sort parameters
    $allowed_sort_fields = ['id', 'name', 'price', 'stock_quantity', 'created_at'];
    if (!in_array($sort_by, $allowed_sort_fields)) {
        $sort_by = 'id';
    }
    
    $sort_order = strtoupper($sort_order) === 'ASC' ? 'ASC' : 'DESC';
    
    // Get total count for pagination
    $count_sql = "SELECT COUNT(*) as total FROM products WHERE $where_clause";
    $count_stmt = $conn->prepare($count_sql);
    
    if (!empty($params)) {
        $count_stmt->bind_param($param_types, ...$params);
    }
    
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $total_products = $count_result->fetch_assoc()['total'];
    
    // Get products
    $sql = "SELECT id, name, description, price, image, stock_quantity, brand, category, created_at 
            FROM products 
            WHERE $where_clause 
            ORDER BY $sort_by $sort_order 
            LIMIT ? OFFSET ?";
    
    $stmt = $conn->prepare($sql);
    
    // Add limit and offset parameters
    $params[] = (int)$limit;
    $params[] = (int)$offset;
    $param_types .= 'ii';
    
    if (!empty($params)) {
        $stmt->bind_param($param_types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        // Format price
        $row['formatted_price'] = '$' . number_format($row['price'], 2);
        
        // Handle image path
        if (!empty($row['image'])) {
            // Check if image path already contains the full path
            if (strpos($row['image'], 'assets/uploads/products/') === 0) {
                $row['image_url'] = '../' . $row['image'];
            } else {
                $row['image_url'] = '../assets/uploads/products/' . $row['image'];
            }
        } else {
            $row['image_url'] = '../assets/images/placeholder-product.svg';
        }
        
        // Format stock status
        if ($row['stock_quantity'] > 10) {
            $row['stock_status'] = 'in_stock';
            $row['stock_text'] = 'In Stock';
        } elseif ($row['stock_quantity'] > 0) {
            $row['stock_status'] = 'low_stock';
            $row['stock_text'] = 'Low Stock (' . $row['stock_quantity'] . ' left)';
        } else {
            $row['stock_status'] = 'out_of_stock';
            $row['stock_text'] = 'Out of Stock';
        }
        
        // Add to products array
        $products[] = $row;
    }
    
    // Get unique categories for filter
    $categories_sql = "SELECT DISTINCT category FROM products 
                      WHERE stock_quantity > 0 
                      AND category IS NOT NULL 
                      AND category != ''
                      ORDER BY category";
    $categories_result = $conn->query($categories_sql);
    $categories = [];
    while ($cat_row = $categories_result->fetch_assoc()) {
        if (!empty($cat_row['category'])) {
            $categories[] = $cat_row['category'];
        }
    }
    
    $response = [
        'success' => true,
        'products' => $products,
        'total' => $total_products,
        'categories' => $categories,
        'pagination' => [
            'current_page' => floor($offset / $limit) + 1,
            'per_page' => (int)$limit,
            'total_pages' => ceil($total_products / $limit),
            'has_next' => ($offset + $limit) < $total_products,
            'has_prev' => $offset > 0
        ]
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching products: ' . $e->getMessage()
    ]);
}
?>
