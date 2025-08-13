<?php
require_once __DIR__ . '/../config/database.php';

try {
    $conn = getDBConnection();
    
    // Create cart_items table
    $sql = "CREATE TABLE IF NOT EXISTS cart_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
        UNIQUE KEY unique_user_product (user_id, product_id)
    )";
    
    $conn->query($sql);
    echo "Cart table created successfully!\n";
    
} catch (Exception $e) {
    echo "Error creating cart table: " . $e->getMessage() . "\n";
}
?>
