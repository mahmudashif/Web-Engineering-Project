<?php
// API endpoint to get admin information
// Include admin authentication middleware
require_once '../../includes/admin-auth.php';

header('Content-Type: application/json');

try {
    // Database connection
    require_once '../../config/database.php';
    $conn = getDBConnection();
    
    // Get admin info for the current user
    $stmt = $conn->prepare("
        SELECT id, full_name, email, profile_picture, role 
        FROM users 
        WHERE id = ? AND is_active = 1
    ");
    
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        echo json_encode([
            'success' => true,
            'admin' => [
                'id' => $admin['id'],
                'full_name' => $admin['full_name'],
                'email' => $admin['email'],
                'profile_picture' => $admin['profile_picture'],
                'role' => $admin['role'] 
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Admin not found'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
