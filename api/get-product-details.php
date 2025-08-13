<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../config/database.php';
session_start();

try {
    $productId = $_GET['id'] ?? null;
    if (!$productId) {
        throw new Exception('Product ID is required');
    }
    
    $conn = getDBConnection();
    
    // Get product details
    $sql = "SELECT 
                p.*,
                pc.name as category_name
            FROM products p
            LEFT JOIN product_categories pc ON p.category_id = pc.id
            WHERE p.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Product not found');
    }
    
    $product = $result->fetch_assoc();
    
    // Format image URL
    if (!empty($product['image'])) {
        if (strpos($product['image'], 'assets/uploads/products/') === 0) {
            $product['image_url'] = '../' . $product['image'];
        } else {
            $product['image_url'] = '../assets/uploads/products/' . $product['image'];
        }
    } else {
        $product['image_url'] = '../assets/images/placeholder-product.svg';
    }
    
    // Format price
    $product['formatted_price'] = '$' . number_format($product['price'], 2);
    
    // Format stock status
    if ($product['stock_quantity'] > 10) {
        $product['stock_status'] = 'in_stock';
        $product['stock_text'] = 'In Stock';
    } elseif ($product['stock_quantity'] > 0) {
        $product['stock_status'] = 'low_stock';
        $product['stock_text'] = 'Low Stock (' . $product['stock_quantity'] . ' left)';
    } else {
        $product['stock_status'] = 'out_of_stock';
        $product['stock_text'] = 'Out of Stock';
    }
    
    // Get related products (same category)
    $relatedProducts = [];
    if (!empty($product['category'])) {
        $relatedSql = "SELECT id, name, price, image, brand, stock_quantity 
                      FROM products 
                      WHERE category = ? AND id != ? AND stock_quantity > 0 
                      ORDER BY RAND() 
                      LIMIT 4";
        
        $relatedStmt = $conn->prepare($relatedSql);
        $relatedStmt->bind_param("si", $product['category'], $productId);
        $relatedStmt->execute();
        $relatedResult = $relatedStmt->get_result();
        
        while ($relatedRow = $relatedResult->fetch_assoc()) {
            // Format related product image
            if (!empty($relatedRow['image'])) {
                if (strpos($relatedRow['image'], 'assets/uploads/products/') === 0) {
                    $relatedRow['image_url'] = '../' . $relatedRow['image'];
                } else {
                    $relatedRow['image_url'] = '../assets/uploads/products/' . $relatedRow['image'];
                }
            } else {
                $relatedRow['image_url'] = '../assets/images/placeholder-product.svg';
            }
            
            $relatedRow['formatted_price'] = '$' . number_format($relatedRow['price'], 2);
            $relatedProducts[] = $relatedRow;
        }
    }
    
    echo json_encode([
        'success' => true,
        'product' => $product,
        'related_products' => $relatedProducts
    ]);
    
} catch (Exception $e) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
