<?php
// Check database structure
require_once '../config/database.php';

try {
    $conn = getDBConnection();
    
    // Check if role column exists
    $result = $conn->query("DESCRIBE users");
    
    echo "Current users table structure:\n";
    echo str_pad("Field", 20) . str_pad("Type", 20) . str_pad("Null", 10) . str_pad("Key", 10) . str_pad("Default", 15) . "Extra\n";
    echo str_repeat("-", 90) . "\n";
    
    $hasRole = false;
    while ($row = $result->fetch_assoc()) {
        echo str_pad($row['Field'], 20) . 
             str_pad($row['Type'], 20) . 
             str_pad($row['Null'], 10) . 
             str_pad($row['Key'], 10) . 
             str_pad($row['Default'] ?? 'NULL', 15) . 
             $row['Extra'] . "\n";
        
        if ($row['Field'] === 'role') {
            $hasRole = true;
        }
    }
    
    echo "\nRole field exists: " . ($hasRole ? "YES" : "NO") . "\n";
    
    if (!$hasRole) {
        echo "\nRunning role field migration...\n";
        
        // Run the migration
        $migration = file_get_contents('add-role-field-migration.sql');
        $statements = array_filter(array_map('trim', explode(';', $migration)));
        
        foreach ($statements as $statement) {
            if (!empty($statement) && !strpos($statement, '--') === 0) {
                try {
                    $conn->query($statement);
                    echo "✓ Executed: " . substr($statement, 0, 50) . "...\n";
                } catch (Exception $e) {
                    echo "✗ Error in statement: " . $e->getMessage() . "\n";
                }
            }
        }
        
        echo "Migration completed!\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
