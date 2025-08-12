<?php
// Include admin authentication middleware
require_once '../../includes/admin-auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Admin Dashboard</title>
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
                <li><a href="orders.php"><span class="icon">📦</span> Orders</a></li>
                <li class="active"><a href="settings.php"><span class="icon">⚙️</span> Settings</a></li>
            </ul>
        </div>
        
        <div class="admin-content">
            <div class="admin-header">
                <h2>Settings</h2>
                <div class="admin-user">
                    <span id="admin-name">Admin</span>
                    <div class="admin-profile-pic" id="admin-profile-pic">
                        <img src="" alt="Admin" id="admin-image" style="display:none;">
                        <div class="admin-initials" id="admin-initials">A</div>
                    </div>
                </div>
            </div>
            
            <div class="admin-card">
                <div class="placeholder-content">
                    <h3>System Settings</h3>
                    <p>This is a placeholder for the System Settings functionality.</p>
                    <p>In the future, you can implement features like:</p>
                    <ul>
                        <li>Store configuration</li>
                        <li>Payment gateway settings</li>
                        <li>Email templates</li>
                        <li>Tax settings</li>
                        <li>Shipping options</li>
                        <li>General site preferences</li>
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
                    
                    // Update admin profile picture or initials
                    const adminImageElement = document.getElementById('admin-image');
                    const adminInitialsElement = document.getElementById('admin-initials');
                    
                    if (user.profile_picture) {
                        // Get base path for current page
                        const basePath = '../../';
                        const profilePicturePath = basePath + user.profile_picture;
                        
                        adminImageElement.src = profilePicturePath;
                        adminImageElement.style.display = 'block';
                        adminInitialsElement.style.display = 'none';
                    } else {
                        // Show initials if no profile picture
                        const nameParts = user.full_name.split(' ');
                        let initials = '';
                        
                        if (nameParts.length > 0) {
                            initials += nameParts[0].charAt(0).toUpperCase();
                            
                            if (nameParts.length > 1) {
                                initials += nameParts[nameParts.length - 1].charAt(0).toUpperCase();
                            }
                        }
                        
                        adminInitialsElement.textContent = initials || 'A';
                        adminInitialsElement.style.display = 'block';
                        adminImageElement.style.display = 'none';
                    }
                }
            });
        });
    </script>
</body>
</html>
