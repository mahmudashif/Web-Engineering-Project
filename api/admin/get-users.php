<?php
// API endpoint to get all users
// Include admin authentication middleware
require_once '../../includes/admin-auth.php';

header('Content-Type: application/json');

try {
    // Database connection
    require_once '../../config/database.php';
    $conn = getDBConnection();
    
    // Get all users
    $query = "SELECT id, full_name, email, username, is_admin, profile_picture, bio, phone, address, created_at FROM users ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $users = [];
    while ($row = $result->fetch_assoc()) {
        // Clean sensitive data
        $user = [
            'id' => $row['id'],
            'full_name' => $row['full_name'],
            'email' => $row['email'],
            'username' => $row['username'],
            'is_admin' => (bool)$row['is_admin'],
            'profile_picture' => $row['profile_picture'],
            'bio' => $row['bio'],
            'phone' => $row['phone'],
            'address' => $row['address'],
            'created_at' => $row['created_at']
        ];
        
        $users[] = $user;
    }
    
    echo json_encode([
        'success' => true,
        'users' => $users
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
