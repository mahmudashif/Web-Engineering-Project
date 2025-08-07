<?php
// Check users in database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gadegt_shop";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<h2>Users in Database:</h2>";
    
    $result = $conn->query("SELECT id, full_name, email, created_at, last_login, is_active FROM users ORDER BY id");
    
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Created</th><th>Last Login</th><th>Active</th></tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . htmlspecialchars($row["full_name"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
            echo "<td>" . $row["created_at"] . "</td>";
            echo "<td>" . ($row["last_login"] ?: 'Never') . "</td>";
            echo "<td>" . ($row["is_active"] ? 'Yes' : 'No') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No users found.";
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<style>
table { border-collapse: collapse; width: 100%; margin: 20px 0; }
th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
th { background-color: #f2f2f2; }
h2 { color: #333; }
</style>
