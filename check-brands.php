<?php
require_once 'config/database.php';

try {
    $conn = getDBConnection();
    
    echo "<h2>Brand Analysis for Laptop Products</h2>";
    
    // Show all laptop products with their exact brand names
    $stmt = $conn->prepare("SELECT id, name, CONCAT('\"', brand, '\"') as brand_quoted, category, stock_quantity FROM products WHERE LOWER(category) LIKE '%laptop%' ORDER BY brand, name");
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Product Name</th><th>Brand (quoted)</th><th>Category</th><th>Stock</th></tr>";
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['brand_quoted']}</td>";
            echo "<td>{$row['category']}</td>";
            echo "<td>{$row['stock_quantity']}</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No laptop products found</td></tr>";
    }
    
    echo "</table>";
    
    echo "<h3>Unique Brands in Database:</h3>";
    $stmt = $conn->prepare("SELECT DISTINCT CONCAT('\"', brand, '\"') as brand_quoted, brand, COUNT(*) as product_count FROM products GROUP BY brand ORDER BY brand");
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>{$row['brand_quoted']} ({$row['product_count']} products)</li>";
    }
    echo "</ul>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
