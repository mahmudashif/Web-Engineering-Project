<?php
// Include admin authentication middleware
require_once '../../includes/admin-auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/admin-dashboard.css">
</head>
<body>
    <!-- Admin header with logo -->
    <div class="admin-top-header">
            <div class="admin-logo">
            <a href="../../index.php">
                <img src="https://i.ibb.co.com/pjYGFbKr/logo.png" id="admin-logo" alt="Gadget Shop" style="height:72px; display:inline-block; vertical-align:middle;">
            </a>
        </div>
        <div class="admin-title">Admin Dashboard</div>
    </div>

    <div class="admin-dashboard-container">
        <div class="admin-sidebar">
            <h3>Admin Panel</h3>
            <ul class="admin-menu">
                <li><a href="dashboard.php"><span class="icon">📊</span> Dashboard</a></li>
                <li class="active"><a href="users.php"><span class="icon">👥</span> Users</a></li>
                <li><a href="products.php"><span class="icon">🛒</span> Products</a></li>
                <li><a href="orders.php"><span class="icon">📦</span> Orders</a></li>
                <li><a href="settings.php"><span class="icon">⚙️</span> Settings</a></li>
                <li class="home-link"><a href="../../index.php"><span class="icon">🏠</span> Back to Website</a></li>
            </ul>
        </div>
        
        <div class="admin-content">
            <div class="admin-header">
                <h2>Manage Users</h2>
                <div class="admin-user">
                    <div class="admin-user-info">
                        <span id="admin-name">Admin</span>
                        <span id="admin-role">Administrator</span>
                    </div>
                    <div class="admin-profile-pic" id="admin-profile-pic">
                        <img src="" alt="Admin" id="admin-image" style="display:none;">
                        <div class="admin-initials" id="admin-initials">A</div>
                    </div>
                </div>
            </div>
            
            <div class="admin-card">
                <div class="users-management">
                    <h3>User Management</h3>
                    <div class="search-bar-container">
                        <input type="text" id="user-search" class="search-input" placeholder="Search users by name, email, or ID...">
                        <button id="search-btn" class="search-btn">Search</button>
                    </div>
                    <div class="users-table-container">
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="users-table-body">
                                <tr>
                                    <td colspan="7" class="loading-message">Loading users...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include footer -->
    <div id="footer-container"></div>

    <!-- Scripts -->
    <script src="../../assets/js/admin-components.js"></script>
    <script src="../../assets/js/admin-users.js"></script>
</body>
</html>
