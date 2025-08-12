document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('user-search');
    const searchButton = document.getElementById('search-btn');
    
    // Add event listeners for search
    if (searchButton && searchInput) {
        searchButton.addEventListener('click', function() {
            loadUsersData(searchInput.value);
        });
        
        // Also search when pressing Enter in the search field
        searchInput.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                loadUsersData(searchInput.value);
            }
        });
    }
    
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
    window.loadUsersData = function(searchQuery = '') {
        const tableBody = document.getElementById('users-table-body');
        
        fetch('../../api/admin/get-users.php')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.users) {
                    // Filter users if search query is provided
                    let filteredUsers = data.users;
                    if (searchQuery) {
                        const query = searchQuery.toLowerCase();
                        filteredUsers = data.users.filter(user => 
                            user.full_name.toLowerCase().includes(query) || 
                            user.email.toLowerCase().includes(query) || 
                            user.id.toString().includes(query)
                        );
                    }
                    
                    // Clear the loading message
                    tableBody.innerHTML = '';
                    
                    // Update users count
                    const userCountElement = document.querySelector('.users-management h3');
                    if (userCountElement) {
                        userCountElement.textContent = searchQuery 
                            ? `User Management (${filteredUsers.length} of ${data.users.length} users)` 
                            : `User Management (${data.users.length} users)`;
                    }
                    
                    // Check if no results after filtering
                    if (filteredUsers.length === 0) {
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="7" class="loading-message">
                                    No users match your search criteria.
                                </td>
                            </tr>
                        `;
                        return;
                    }
                    
                    // Add users to the table
                    filteredUsers.forEach(user => {
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
                        
                        // Create role badge - check both is_admin and role fields
                        const isAdmin = user.is_admin === true || user.is_admin === 1 || user.is_admin === '1' || user.role === 'admin';
                        const roleBadge = isAdmin ? 
                            '<span class="user-role role-admin">Admin</span>' : 
                            '<span class="user-role role-user">User</span>';
                        
                        row.innerHTML = `
                            <td>${user.id}</td>
                            <td>${avatarHTML}</td>
                            <td>${user.full_name}</td>
                            <td>${user.email}</td>
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
                            <td colspan="7" class="loading-message">
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
                        <td colspan="7" class="loading-message">
                            Error loading users. Please try again.
                        </td>
                    </tr>
                `;
            });
    };
    
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
