<?php
// API endpoint to update user role (make admin / remove admin)
// Include admin authentication middleware
require_once '../../includes/admin-auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Only POST method allowed'
    ]);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['user_id']) || !isset($input['role'])) {
    echo json_encode([
        'success' => false,
        'message' => 'User ID and role are required'
    ]);
    exit;
}

$userId = intval($input['user_id']);
$role = trim($input['role']);

// Validate role
if (!in_array($role, ['admin', 'user'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid role. Must be either "admin" or "user"'
    ]);
    exit;
}

// Prevent self-demotion (admin cannot remove their own admin privileges)
if ($userId === $_SESSION['user_id'] && $role === 'user') {
    echo json_encode([
        'success' => false,
        'message' => 'You cannot remove your own admin privileges'
    ]);
    exit;
}

try {
    // Database connection
    require_once '../../config/database.php';
    $conn = getDBConnection();
    
    // Check if user exists
    $checkStmt = $conn->prepare("SELECT id, full_name, email, role FROM users WHERE id = ?");
    $checkStmt->bind_param("i", $userId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'User not found'
        ]);
        exit;
    }
    
    $user = $result->fetch_assoc();
    
    // Check if role is already the same
    if ($user['role'] === $role) {
        $roleLabel = $role === 'admin' ? 'administrator' : 'regular user';
        echo json_encode([
            'success' => false,
            'message' => "User is already a {$roleLabel}"
        ]);
        exit;
    }
    
    // Update user role
    $updateStmt = $conn->prepare("UPDATE users SET role = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $updateStmt->bind_param("si", $role, $userId);
    
    if ($updateStmt->execute()) {
        $action = $role === 'admin' ? 'promoted to administrator' : 'demoted to regular user';
        echo json_encode([
            'success' => true,
            'message' => "User {$user['full_name']} has been {$action}",
            'user' => [
                'id' => $userId,
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'role' => $role
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update user role: ' . $conn->error
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
