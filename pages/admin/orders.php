<?php
// Include admin authentication middleware
require_once '../../includes/admin-auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders | Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/admin-dashboard.css">
</head>
<body>
    <!-- Include navbar -->
    <div id="navbar-container"></div>

    <div class="admin-dashboard-container">
        <div class="admin-sidebar">
            <h3>Admin Panel</h3>
            <ul class="admin-menu">
                <li><a href="dashboard.php"><span class="icon">📊</span> Dashboard</a></li>
                <li><a href="users.php"><span class="icon">👥</span> Users</a></li>
                <li><a href="products.php"><span class="icon">🛒</span> Products</a></li>
                <li class="active"><a href="orders.php"><span class="icon">📦</span> Orders</a></li>
                <li><a href="settings.php"><span class="icon">⚙️</span> Settings</a></li>
            </ul>
        </div>
        
        <div class="admin-content">
            <div class="admin-header">
                <h2>Manage Orders</h2>
                <div class="admin-user">
                    <span id="admin-name">Admin</span>
                </div>
            </div>
            
            <div class="admin-card">
                <div class="placeholder-content">
                    <h3>Order Management</h3>
                    <p>This is a placeholder for the Order Management functionality.</p>
                    <p>In the future, you can implement features like:</p>
                    <ul>
                        <li>View all orders</li>
                        <li>Filter orders by status</li>
                        <li>View order details</li>
                        <li>Update order status</li>
                        <li>Generate invoices</li>
                        <li>Process refunds</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Include footer -->
    <div id="footer-container"></div>

    <!-- Scripts -->
    <script src="../../components/components.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize components
            new Components();
            
            // Check for admin user and update UI
            const userAuth = new UserAuth();
            
            userAuth.requireAuth().then(user => {
                if (user) {
                    // Update admin name
                    const adminNameElement = document.getElementById('admin-name');
                    if (adminNameElement) {
                        adminNameElement.textContent = user.full_name;
                    }
                }
            });
        });
    </script>
</body>
</html>
