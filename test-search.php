<?php
// Test search functionality
require_once 'config/database.php';

function testSearch($term) {
    try {
        $conn = getDBConnection();
        
        $where_conditions = ["stock_quantity > 0"];
        $params = [];
        $param_types = '';
        
        if (!empty($term)) {
            $where_conditions[] = "(name LIKE ? OR description LIKE ?)";
            $params[] = "%$term%";
            $params[] = "%$term%";
            $param_types .= 'ss';
        }
        
        $where_clause = implode(' AND ', $where_conditions);
        $sql = "SELECT id, name, description, price FROM products WHERE $where_clause";
        
        $stmt = $conn->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($param_types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row['name'];
        }
        
        return count($products) . ' results: ' . implode(', ', $products);
        
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
}

$searches = ['iphone', 'macbook', 'pro', 'watch', 'air', 'nonexistent'];
foreach($searches as $term) {
    echo "Search '$term': " . testSearch($term) . "\n";
}
?>
