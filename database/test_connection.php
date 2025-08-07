<?php
// Database connection test script

$configurations = [
    [
        'name' => 'XAMPP/WAMP Default',
        'servername' => 'localhost',
        'username' => 'root',
        'password' => '',
        'port' => 3306
    ],
    [
        'name' => 'MySQL Default with password',
        'servername' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'port' => 3306
    ],
    [
        'name' => 'Local MySQL Socket',
        'servername' => 'localhost',
        'username' => 'root',
        'password' => '',
        'port' => null
    ]
];

echo "Testing Database Connections...\n\n";

foreach ($configurations as $config) {
    echo "Testing: {$config['name']}\n";
    echo "Server: {$config['servername']}\n";
    echo "Username: {$config['username']}\n";
    echo "Password: " . (empty($config['password']) ? '(empty)' : '(set)') . "\n";
    
    try {
        if ($config['port']) {
            $conn = new mysqli($config['servername'], $config['username'], $config['password'], '', $config['port']);
        } else {
            $conn = new mysqli($config['servername'], $config['username'], $config['password']);
        }
        
        if ($conn->connect_error) {
            echo "❌ Failed: " . $conn->connect_error . "\n";
        } else {
            echo "✅ Success! Connected to MySQL server\n";
            
            // Try to create database
            $dbname = "gadegt_shop";
            $create_db = "CREATE DATABASE IF NOT EXISTS `$dbname`";
            
            if ($conn->query($create_db)) {
                echo "✅ Database '$dbname' created or already exists\n";
                
                // Select database and create table
                $conn->select_db($dbname);
                
                $create_table = "CREATE TABLE IF NOT EXISTS test_table (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(50)
                )";
                
                if ($conn->query($create_table)) {
                    echo "✅ Test table created successfully\n";
                    
                    // Drop test table
                    $conn->query("DROP TABLE test_table");
                    echo "✅ Test table cleaned up\n";
                }
            }
            
            $conn->close();
            echo "\n*** Use this configuration for your database.php ***\n";
            break;
        }
        
    } catch (Exception $e) {
        echo "❌ Exception: " . $e->getMessage() . "\n";
    }
    
    echo "\n" . str_repeat("-", 50) . "\n\n";
}
?>
