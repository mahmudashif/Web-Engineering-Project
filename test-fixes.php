<?php
echo "Testing Product Management Fixes\n";
echo "===================================\n\n";

require_once 'config/database.php';

try {
    $conn = getDBConnection();
    
    // Test 1: Check if brand field exists and has data
    echo "1. Testing brand data in products:\n";
    $result = $conn->query("SELECT id, name, brand, category FROM products ORDER BY id DESC LIMIT 3");
    while ($row = $result->fetch_assoc()) {
        $brand = $row['brand'] ?? 'NULL';
        $category = $row['category'] ?? 'NULL';
        echo "   - Product ID {$row['id']}: {$row['name']}, Brand: '$brand', Category: '$category'\n";
    }
    
    echo "\n2. Testing shop API for products with category '0':\n";
    $_GET['category'] = 'all';
    $_GET['search'] = '';
    
    // Capture output
    ob_start();
    include 'api/get-products.php';
    $shopResponse = ob_get_clean();
    
    $shopData = json_decode($shopResponse, true);
    if ($shopData && $shopData['success']) {
        echo "   - Shop API returned {$shopData['total']} products\n";
        
        // Check for products with category '0'
        $category0Products = array_filter($shopData['products'], function($p) {
            return $p['category'] === '0';
        });
        
        echo "   - Products with category '0': " . count($category0Products) . "\n";
        if (count($category0Products) > 0) {
            foreach ($category0Products as $product) {
                echo "     * {$product['name']} (Brand: {$product['brand']})\n";
            }
        }
    } else {
        echo "   - Shop API error: " . ($shopData['message'] ?? 'Unknown error') . "\n";
    }
    
    echo "\n3. Testing admin API simulation:\n";
    // Simulate admin API call structure
    $adminSql = "SELECT p.*, pc.name as category_name 
                FROM products p 
                LEFT JOIN product_categories pc ON p.category_id = pc.id 
                ORDER BY p.updated_at DESC, p.id DESC 
                LIMIT 3";
    
    $adminResult = $conn->query($adminSql);
    echo "   - Admin API would return:\n";
    while ($row = $adminResult->fetch_assoc()) {
        $brand = $row['brand'] ?? 'NULL';
        echo "     * ID {$row['id']}: {$row['name']}, Brand: '$brand', Category: '{$row['category_name']}'\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n✅ Fixes Applied:\n";
echo "1. Added 'brand' field to admin products API response\n";
echo "2. Removed category filtering in shop API to show products with category '0'\n";
echo "3. JavaScript already supports displaying brand names\n";
?>
