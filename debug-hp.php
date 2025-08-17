<?php
require_once 'config/database.php';

try {
    $conn = getDBConnection();
    
    echo "<h2>Debug HP Products Issue</h2>";
    
    // 1. Check all products with HP brand (case insensitive)
    echo "<h3>1. All products with HP brand (any case):</h3>";
    $stmt = $conn->prepare("SELECT id, name, brand, category, stock_quantity FROM products WHERE LOWER(brand) LIKE LOWER('%hp%')");
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "ID: {$row['id']}, Name: {$row['name']}, Brand: '{$row['brand']}', Category: '{$row['category']}', Stock: {$row['stock_quantity']}<br>";
        }
    } else {
        echo "No HP products found<br>";
    }
    
    // 2. Check all laptop category products
    echo "<h3>2. All laptop category products:</h3>";
    $stmt = $conn->prepare("SELECT id, name, brand, category, stock_quantity FROM products WHERE LOWER(category) LIKE LOWER('%laptop%')");
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "ID: {$row['id']}, Name: {$row['name']}, Brand: '{$row['brand']}', Category: '{$row['category']}', Stock: {$row['stock_quantity']}<br>";
        }
    } else {
        echo "No laptop products found<br>";
    }
    
    // 3. Check exact match for laptops + hp
    echo "<h3>3. Products matching 'laptops' category and 'hp' brand:</h3>";
    $stmt = $conn->prepare("SELECT id, name, brand, category, stock_quantity FROM products WHERE LOWER(category) = LOWER('laptops') AND LOWER(brand) = LOWER('hp') AND stock_quantity > 0");
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "ID: {$row['id']}, Name: {$row['name']}, Brand: '{$row['brand']}', Category: '{$row['category']}', Stock: {$row['stock_quantity']}<br>";
        }
    } else {
        echo "No products found with exact match<br>";
    }
    
    // 4. Show all unique categories
    echo "<h3>4. All unique categories in database:</h3>";
    $result = $conn->query("SELECT DISTINCT category FROM products ORDER BY category");
    while ($row = $result->fetch_assoc()) {
        echo "'{$row['category']}'<br>";
    }
    
    // 5. Show all unique brands
    echo "<h3>5. All unique brands in database:</h3>";
    $result = $conn->query("SELECT DISTINCT brand FROM products ORDER BY brand");
    while ($row = $result->fetch_assoc()) {
        echo "'{$row['brand']}'<br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
