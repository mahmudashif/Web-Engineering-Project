<?php
session_start();
header('Content-Type: application/json');

// Database connection to gadegt_shop
$host = "localhost";
$username = "root"; 
$password = "";
$database = "gadegt_shop";

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed'
    ]);
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Not authenticated'
    ]);
    exit();
}

// Get user data from database
$stmt = $connection->prepare("SELECT id, full_name, email, created_at FROM users WHERE id = ? AND is_active = 1");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // User not found, clear session
    session_destroy();
    echo json_encode([
        'success' => false,
        'message' => 'User not found'
    ]);
    exit();
}

$user = $result->fetch_assoc();

echo json_encode([
    'success' => true,
    'message' => 'User authenticated',
    'user' => $user
]);

$stmt->close();
$connection->close();
?>
