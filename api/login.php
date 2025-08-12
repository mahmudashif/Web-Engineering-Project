<?php
session_start();

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors in JSON response

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    $input = $_POST;
}

$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';

// Validation
if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(['error' => 'Email and password are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid email format']);
    exit;
}

try {
    // Direct database connection to gadegt_shop
    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "gadget_shop";
    
    $conn = new mysqli($servername, $username, $db_password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8");
    
    // Get user by email
    $stmt = $conn->prepare("SELECT id, full_name, email, password FROM users WHERE email = ? AND is_active = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid email or password']);
        $conn->close();
        exit;
    }
    
    $user = $result->fetch_assoc();
    
    // Verify password
    if (!password_verify($password, $user['password'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid email or password']);
        $conn->close();
        exit;
    }
    
    // Update last login
    $update_stmt = $conn->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
    $update_stmt->bind_param("i", $user['id']);
    $update_stmt->execute();
    
    // Set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['full_name'];
    $_SESSION['user_email'] = $user['email'];
    
    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'user' => [
            'id' => $user['id'],
            'full_name' => $user['full_name'],
            'email' => $user['email']
        ]
    ]);
    
    $conn->close();
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
