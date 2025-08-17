<?php
// Test the get-products.php API
require_once __DIR__ . '/../config/database.php';

try {
    $conn = getDBConnection();
    
    echo "<h3>Products in Database:</h3>";
    
    $result = $conn->query("SELECT id, name, price, stock_quantity, image, category, brand FROM products ORDER BY id");
    
    while ($row = $result->fetch_assoc()) {
        echo "<div style='border: 1px solid #ddd; margin: 10px; padding: 10px;'>";
        echo "<strong>ID:</strong> {$row['id']}<br>";
        echo "<strong>Name:</strong> {$row['name']}<br>";
        echo "<strong>Price:</strong> ${$row['price']}<br>";
        echo "<strong>Stock:</strong> {$row['stock_quantity']}<br>";
        echo "<strong>Image:</strong> {$row['image']}<br>";
        echo "<strong>Category:</strong> {$row['category']}<br>";
        echo "<strong>Brand:</strong> {$row['brand']}<br>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
