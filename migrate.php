<?php
// Database Migration Runner
$host = "localhost";
$username = "root"; 
$password = "";
$database = "gadget_shop";

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

echo "<h2>Running Google OAuth Migration</h2>";

// Read the SQL file
$sql = file_get_contents('database/google-oauth-migration.sql');

if ($sql === false) {
    die("Could not read migration file");
}

// Split by semicolons and execute each statement
$statements = array_filter(array_map('trim', explode(';', $sql)));

foreach ($statements as $statement) {
    if (empty($statement) || strpos($statement, '--') === 0 || strpos($statement, 'USE') === 0) {
        continue;
    }
    
    echo "Executing: " . substr($statement, 0, 50) . "...<br>";
    
    if ($connection->query($statement)) {
        echo "✅ Success<br><br>";
    } else {
        echo "❌ Error: " . $connection->error . "<br><br>";
    }
}

$connection->close();
echo "<h3>Migration completed!</h3>";
?>
