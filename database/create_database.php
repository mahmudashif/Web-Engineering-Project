<?php
// Database creation script
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gadget_shop";

try {
    // First, connect without selecting a database
    $conn = new mysqli($servername, $username, $password);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8 COLLATE utf8_general_ci";
    
    if ($conn->query($sql) === TRUE) {
        echo "Database '$dbname' created successfully or already exists.\n";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }
    
    // Now select the database
    $conn->select_db($dbname);
    
    // Create users table
    $table_sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        is_active TINYINT(1) DEFAULT 1,
        last_login TIMESTAMP NULL,
        INDEX idx_email (email),
        INDEX idx_active (is_active)
    )";
    
    if ($conn->query($table_sql) === TRUE) {
        echo "Users table created successfully or already exists.\n";
    } else {
        throw new Exception("Error creating users table: " . $conn->error);
    }
    
    $conn->close();
    echo "Database setup completed successfully!\n";
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage() . "\n");
}
?>
