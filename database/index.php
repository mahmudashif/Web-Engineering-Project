<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: green; background: #d4edda; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: red; background: #f8d7da; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: #0c5460; background: #d1ecf1; padding: 10px; border-radius: 5px; margin: 10px 0; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Database Setup for Gadget Shop</h1>
        <p>This script will set up the necessary database tables for the authentication system.</p>
        
        <?php
        // Include database configuration
        try {
            require_once '../config/database.php';
            echo "<div class='success'>✓ Database connection successful!</div>";
            
            // SQL to create users table
            $sql = "CREATE TABLE IF NOT EXISTS users (
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
            
            echo "<div class='info'><strong>Creating users table...</strong></div>";
            
            $conn = getDBConnection();
            
            if ($conn->query($sql) === TRUE) {
                echo "<div class='success'>✓ Users table created successfully!</div>";
                
                // Check if table is empty and show status
                $check_users = $conn->query("SELECT COUNT(*) as count FROM users");
                $user_count = $check_users->fetch_assoc()['count'];
                
                echo "<div class='info'><strong>Current users in database:</strong> $user_count</div>";
                
                if ($user_count == 0) {
                    echo "<div class='info'>The table is ready for new user registrations!</div>";
                }
                
                // Show table structure
                echo "<h3>Users Table Structure:</h3>";
                $describe = $conn->query("DESCRIBE users");
                echo "<pre>";
                echo str_pad("Field", 20) . str_pad("Type", 20) . str_pad("Null", 8) . str_pad("Key", 8) . "Extra\n";
                echo str_repeat("-", 70) . "\n";
                while ($row = $describe->fetch_assoc()) {
                    echo str_pad($row['Field'], 20) . 
                         str_pad($row['Type'], 20) . 
                         str_pad($row['Null'], 8) . 
                         str_pad($row['Key'], 8) . 
                         $row['Extra'] . "\n";
                }
                echo "</pre>";
                
            } else {
                throw new Exception("Error creating table: " . $conn->error);
            }
            
        } catch (Exception $e) {
            echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
            echo "<div class='info'>Please check your database configuration in config/database.php</div>";
        }
        ?>
        
        <h3>Next Steps:</h3>
        <ul>
            <li>✓ Database connection is working</li>
            <li>✓ Users table has been created</li>
            <li>→ You can now test the registration and login functionality</li>
            <li>→ Visit <a href="../pages/auth/register.php">Register Page</a> to create a new account</li>
            <li>→ Visit <a href="../pages/auth/login.php">Login Page</a> to sign in</li>
        </ul>
        
        <div style="margin-top: 30px;">
            <a href="../index.php" class="btn">← Back to Home</a>
            <a href="../pages/auth/register.php" class="btn">Test Registration</a>
            <a href="../pages/auth/login.php" class="btn">Test Login</a>
        </div>
    </div>
</body>
</html>
