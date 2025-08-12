<?php
// This script creates an admin user if one doesn't exist yet
require_once 'config/database.php';

try {
    $conn = getDBConnection();
    
    // Check if an admin user already exists
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['count'] > 0) {
        echo "Admin user already exists. No action taken.\n";
    } else {
        // Create admin user
        $fullName = 'Admin User';
        $email = 'admin@example.com';
        $password = password_hash('admin123', PASSWORD_DEFAULT); // Temporary password - change this in production!
        $role = 'admin';
        
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullName, $email, $password, $role);
        
        if ($stmt->execute()) {
            echo "Admin user created successfully!\n";
            echo "Email: admin@example.com\n";
            echo "Password: admin123\n";
            echo "Please change the password after login for security reasons.\n";
        } else {
            echo "Error creating admin user: " . $stmt->error . "\n";
        }
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
