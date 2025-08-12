<?php
$servername = "localhost";
$username = "root";
$password = ""; // Empty password for root user
$dbname = "gadget_shop";
$conn = null;

// Function to get database connection
function getDBConnection() {
    global $servername, $username, $password, $dbname, $conn;
    
    if ($conn === null) {
        try {
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            // Check connection
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
            
            // Set charset
            $conn->set_charset("utf8");
            
        } catch (Exception $e) {
            // For API endpoints, throw exception instead of dying
            if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
                throw new Exception("Database connection failed: " . $e->getMessage());
            } else {
                // For regular pages, show error message
                die("Database connection failed: " . $e->getMessage());
            }
        }
    }
    
    return $conn;
}

// Test connection function
function testDatabaseConnection() {
    try {
        $conn = getDBConnection();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
