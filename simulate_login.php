<?php
// Simple test script to simulate login for testing cart functionality
session_start();

// Simulate login as admin user (ID: 1) for testing
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'admin1';
$_SESSION['is_admin'] = true;

echo "✅ Simulated login as user ID 1 (admin1)\n";
echo "You can now test the cart functionality!\n";
echo "\nTo use:\n";
echo "1. Go to shop page: http://localhost/pages/shop.php\n";
echo "2. Click 'View Details' on any product\n";
echo "3. Add products to cart\n";
echo "4. Visit cart page: http://localhost/components/cart/cart.php\n";
echo "\nNote: This is just for testing. In production, users should login through the normal login page.\n";
?>
