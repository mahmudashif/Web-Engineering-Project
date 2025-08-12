<?php
// Admin authentication middleware
session_start();

// Function to verify if current user is an admin
function verifyAdmin() {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    
    // Connect to database
    $host = "localhost";
    $username = "root"; 
    $password = "";
    $database = "gadget_shop";
    
    $connection = new mysqli($host, $username, $password, $database);
    
    if ($connection->connect_error) {
        return false;
    }
    
    // Check if user exists and is an admin
    $stmt = $connection->prepare("
        SELECT id FROM users 
        WHERE id = ? AND role = 'admin' AND is_active = 1
    ");
    
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $isAdmin = $result->num_rows > 0;
    
    $stmt->close();
    $connection->close();
    
    return $isAdmin;
}

// If not an admin, redirect to home page
if (!verifyAdmin()) {
    // Set error message
    $_SESSION['error_message'] = "Access denied. Admin privileges required.";
    
    // Get base path
    $base_path = '';
    $current_path = $_SERVER['PHP_SELF'];
    
    // Calculate base path based on current file location
    if (strpos($current_path, '/pages/admin/') !== false) {
        $base_path = '../../';
    } else if (strpos($current_path, '/admin/') !== false) {
        $base_path = '../';
    }
    
    // Redirect to home page
    header("Location: {$base_path}index.php");
    exit;
}
?>
