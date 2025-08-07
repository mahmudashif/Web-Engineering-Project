<?php
require_once '../config/database.php';

// SQL to create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active TINYINT(1) DEFAULT 1,
    last_login TIMESTAMP NULL,
    INDEX idx_email (email)
)";

try {
    $conn = getDBConnection();
    
    if ($conn->query($sql) === TRUE) {
        echo "Users table created successfully or already exists<br>";
        
        // Check if table is empty and create a test user (optional)
        $check_users = $conn->query("SELECT COUNT(*) as count FROM users");
        $user_count = $check_users->fetch_assoc()['count'];
        
        if ($user_count == 0) {
            echo "Table is empty. You can now register users through the registration form.<br>";
        } else {
            echo "Table already has $user_count user(s).<br>";
        }
        
    } else {
        throw new Exception("Error creating table: " . $conn->error);
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
