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
            <a href="../../index.php">Orebi</a>
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
                    <div class="users-table-container">
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="users-table-body">
                                <tr>
                                    <td colspan="8" class="loading-message">Loading users...</td>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for UserAuth to be available
            const checkUserAuth = setInterval(function() {
                if (window.userAuth) {
                    clearInterval(checkUserAuth);
                    
                    // Now we can use UserAuth
                    const userAuth = window.userAuth;
                    
                    userAuth.requireAdminAuth().then(user => {
                        if (user) {
                            // Update admin name
                            const adminNameElement = document.getElementById('admin-name');
                            if (adminNameElement) {
                                adminNameElement.textContent = user.full_name;
                            }
                            
                            // Update admin role
                            const adminRoleElement = document.getElementById('admin-role');
                            if (adminRoleElement) {
                                adminRoleElement.textContent = 'Administrator'; // Always show Administrator since only admins can access
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
                            
                            // Load users data
                            loadUsersData();
                        }
                    });
                }
            }, 100); // Check every 100ms
            
            // Function to load users data
            function loadUsersData() {
                const tableBody = document.getElementById('users-table-body');
                
                fetch('../../api/admin/get-users.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.users) {
                            // Clear the loading message
                            tableBody.innerHTML = '';
                            
                            // Update users count
                            const userCountElement = document.querySelector('.users-management h3');
                            if (userCountElement) {
                                userCountElement.textContent = `User Management (${data.users.length} users)`;
                            }
                            
                            // Add users to the table
                            data.users.forEach(user => {
                                const row = document.createElement('tr');
                                
                                // Format date
                                const createdDate = new Date(user.created_at);
                                const formattedDate = createdDate.toLocaleDateString();
                                
                                // Create user avatar or initials
                                let avatarHTML = '';
                                if (user.profile_picture) {
                                    avatarHTML = `
                                        <div class="user-avatar">
                                            <img src="../../${user.profile_picture}" alt="${user.full_name}">
                                        </div>
                                    `;
                                } else {
                                    // Create initials from name
                                    const nameParts = user.full_name.split(' ');
                                    let initials = '';
                                    
                                    if (nameParts.length > 0) {
                                        initials += nameParts[0].charAt(0).toUpperCase();
                                        
                                        if (nameParts.length > 1) {
                                            initials += nameParts[nameParts.length - 1].charAt(0).toUpperCase();
                                        }
                                    }
                                    
                                    avatarHTML = `
                                        <div class="user-avatar">
                                            <div class="user-initials">${initials || 'U'}</div>
                                        </div>
                                    `;
                                }
                                
                                // Create role badge
                                const roleBadge = user.is_admin ? 
                                    '<span class="user-role role-admin">Admin</span>' : 
                                    '<span class="user-role role-user">User</span>';
                                
                                row.innerHTML = `
                                    <td>${user.id}</td>
                                    <td>${avatarHTML}</td>
                                    <td>${user.full_name}</td>
                                    <td>${user.email}</td>
                                    <td>${user.username}</td>
                                    <td>${roleBadge}</td>
                                    <td>${formattedDate}</td>
                                    <td>
                                        <button class="action-btn edit-btn" data-id="${user.id}">Edit</button>
                                        <button class="action-btn delete-btn" data-id="${user.id}">Delete</button>
                                    </td>
                                `;
                                
                                tableBody.appendChild(row);
                            });
                            
                            // Add event listeners to action buttons
                            addActionButtonListeners();
                            
                        } else {
                            tableBody.innerHTML = `
                                <tr>
                                    <td colspan="8" class="loading-message">
                                        No users found or error loading users.
                                    </td>
                                </tr>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching users:', error);
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="8" class="loading-message">
                                    Error loading users. Please try again.
                                </td>
                            </tr>
                        `;
                    });
            }
            
            // Function to add event listeners to action buttons
            function addActionButtonListeners() {
                // Edit buttons
                document.querySelectorAll('.edit-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const userId = this.getAttribute('data-id');
                        alert(`Edit user with ID: ${userId} (To be implemented)`);
                    });
                });
                
                // Delete buttons
                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const userId = this.getAttribute('data-id');
                        if (confirm(`Are you sure you want to delete user with ID: ${userId}?`)) {
                            alert(`Delete user with ID: ${userId} (To be implemented)`);
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>
