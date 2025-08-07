<?php
// Debug database connection
echo "Testing database connection from API context...\n";

// Simulate being in API context
$_SERVER['REQUEST_URI'] = '/api/register.php';

require_once '../config/database.php';

try {
    echo "Attempting to get database connection...\n";
    $conn = getDBConnection();
    echo "✅ Database connection successful!\n";
    
    // Test a simple query
    $result = $conn->query("SELECT 1 as test");
    if ($result) {
        echo "✅ Test query successful!\n";
        
        // Check if users table exists
        $tables = $conn->query("SHOW TABLES LIKE 'users'");
        if ($tables->num_rows > 0) {
            echo "✅ Users table exists!\n";
        } else {
            echo "❌ Users table does not exist!\n";
        }
    } else {
        echo "❌ Test query failed: " . $conn->error . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}
?>
