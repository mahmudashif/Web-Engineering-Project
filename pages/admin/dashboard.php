<?php
// Include admin authentication middleware
require_once '../../includes/admin-auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Orebi</title>
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
                <li class="active"><a href="dashboard.php"><span class="icon">📊</span> Dashboard</a></li>
                <li><a href="users.php"><span class="icon">👥</span> Users</a></li>
                <li><a href="products.php"><span class="icon">🛒</span> Products</a></li>
                <li><a href="orders.php"><span class="icon">📦</span> Orders</a></li>
                <li><a href="settings.php"><span class="icon">⚙️</span> Settings</a></li>
            </ul>
        </div>
        
        <div class="admin-content">
            <div class="admin-header">
                <h2>Dashboard</h2>
                <div class="admin-user">
                    <span id="admin-name">Admin</span>
                </div>
            </div>
            
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon users-icon">👥</div>
                    <div class="stat-details">
                        <h3>Users</h3>
                        <p class="stat-number">0</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon products-icon">🛒</div>
                    <div class="stat-details">
                        <h3>Products</h3>
                        <p class="stat-number">0</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon orders-icon">📦</div>
                    <div class="stat-details">
                        <h3>Orders</h3>
                        <p class="stat-number">0</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon revenue-icon">💰</div>
                    <div class="stat-details">
                        <h3>Revenue</h3>
                        <p class="stat-number">$0</p>
                    </div>
                </div>
            </div>
            
            <div class="recent-activity">
                <h3>Recent Activity</h3>
                <div class="activity-card">
                    <p>No recent activity to display.</p>
                    <p>As you add functionality to your admin dashboard, this area will show recent user actions, order placements, or system changes.</p>
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
