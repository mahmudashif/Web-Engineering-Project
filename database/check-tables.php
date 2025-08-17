<?php
require_once __DIR__ . '/../config/database.php';

try {
    $conn = getDBConnection();
    
    // Show all tables
    $result = $conn->query("SHOW TABLES");
    
    echo "<h3>Database Tables:</h3>";
    while ($row = $result->fetch_array()) {
        $table_name = $row[0];
        echo "- $table_name<br>";
        
        // Get table structure
        $describe = $conn->query("DESCRIBE $table_name");
        echo "<ul>";
        while ($col = $describe->fetch_assoc()) {
            echo "<li>{$col['Field']} ({$col['Type']})</li>";
        }
        echo "</ul>";
        
        // Get record count
        $count_result = $conn->query("SELECT COUNT(*) as count FROM $table_name");
        $count = $count_result->fetch_assoc()['count'];
        echo "Records: $count<br><br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
