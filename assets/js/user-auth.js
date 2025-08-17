// User authentication and navbar management
class UserAuth {
    constructor() {
        this.init();
    }

    init() {
        this.loadUser();
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Logout button
        document.addEventListener('click', (e) => {
            if (e.target && e.target.id === 'logoutBtn') {
                e.preventDefault();
                this.logout();
            }
        });

        // Login button
        document.addEventListener('click', (e) => {
            if (e.target && e.target.id === 'loginNavBtn') {
                e.preventDefault();
                const basePath = this.getBasePath();
                window.location.href = basePath + 'pages/auth/login.php';
            }
        });

        // Profile link
        document.addEventListener('click', (e) => {
            if (e.target && e.target.classList.contains('profile-link')) {
                e.preventDefault();
                const basePath = this.getBasePath();
                window.location.href = basePath + 'pages/profile.php';
            }
        });
    }

    async loadUser() {
        try {
            const basePath = this.getBasePath();
            const response = await fetch(basePath + 'api/check-auth.php', {
                method: 'GET',
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                if (data.success && data.user) {
                    this.updateNavbarForLoggedInUser(data.user);
                } else {
                    this.updateNavbarForLoggedOutUser();
                }
            } else {
                this.updateNavbarForLoggedOutUser();
            }
        } catch (error) {
            console.error('Error checking authentication:', error);
            this.updateNavbarForLoggedOutUser();
        }
    }

    updateNavbarForLoggedInUser(user) {
        const userIconDropdown = document.querySelector('.user-icon-dropdown');
        if (userIconDropdown) {
            const fullName = user.full_name || 'User';
            const email = user.email || '';
            // Handle profile picture path - it should already be the full relative path from the API
            const profilePicture = user.profile_picture ? user.profile_picture : null;
            
            // Get base path for current page
            const basePath = this.getBasePath();
            const fullProfilePicturePath = profilePicture ? basePath + profilePicture : null;

            // Determine what to show as the main icon
            const mainIconHTML = fullProfilePicturePath ? 
                `<img src="${fullProfilePicturePath}?t=${Date.now()}" alt="Profile" class="nav_profile_image" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                 <svg class="nav_icon nav_default_icon" style="display: none;" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                    <path d="M12 14C7.02944 14 3 18.0294 3 23H21C21 18.0294 16.9706 14 12 14Z"/>
                 </svg>` :
                `<svg class="nav_icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                    <path d="M12 14C7.02944 14 3 18.0294 3 23H21C21 18.0294 16.9706 14 12 14Z"/>
                 </svg>`;

            // Profile picture for dropdown header - horizontal layout
            const dropdownProfileHTML = fullProfilePicturePath ? 
                `<div class="dropdown_profile_container">
                    <img src="${fullProfilePicturePath}?t=${Date.now()}" alt="Profile" class="dropdown_profile_image" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <svg class="dropdown_default_icon" style="display: none;" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                        <path d="M12 14C7.02944 14 3 18.0294 3 23H21C21 18.0294 16.9706 14 12 14Z"/>
                    </svg>
                    <div class="dropdown_user_info">
                        <span class="user_greeting">${fullName}</span>
                        <span class="user_subtitle">${email}</span>
                    </div>
                 </div>` : 
                `<div class="dropdown_profile_container">
                    <svg class="dropdown_default_icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                        <path d="M12 14C7.02944 14 3 18.0294 3 23H21C21 18.0294 16.9706 14 12 14Z"/>
                    </svg>
                    <div class="dropdown_user_info">
                        <span class="user_greeting">${fullName}</span>
                        <span class="user_subtitle">${email}</span>
                    </div>
                 </div>`;
                 
            // Admin dashboard link - only show for admin users
            const adminDashboardLink = user.role === 'admin' ? 
                `<a href="${basePath}pages/admin/dashboard.php" class="dropdown_item admin-dashboard-link">
                    <svg class="dropdown_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Admin Dashboard
                </a>` : '';

            userIconDropdown.innerHTML = `
                <div class="user_dropdown_container">
                    <a href="#" class="nav_icon_link user_icon_link" title="User Account">
                        ${mainIconHTML}
                    </a>
                    <div class="user_dropdown">
                        <div class="dropdown_header">
                            ${dropdownProfileHTML}
                        </div>
                        <div class="dropdown_menu">
                            <a href="${basePath}pages/profile.php" class="dropdown_item profile-link">
                                <svg class="dropdown_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                My Profile
                            </a>
                            ${adminDashboardLink}
                            <a href="${basePath}pages/orders.php" class="dropdown_item orders-link">
                                <svg class="dropdown_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                My Orders
                            </a>
                            <a href="#" class="dropdown_item">
                                <svg class="dropdown_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Settings
                            </a>
                            <div class="dropdown_divider"></div>
                            <a href="#" class="dropdown_item logout_item" id="logoutBtn">
                                <svg class="dropdown_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Sign Out
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    updateNavbarForLoggedOutUser() {
        const userIconDropdown = document.querySelector('.user-icon-dropdown');
        if (userIconDropdown) {
            userIconDropdown.innerHTML = `
                <div class="user_dropdown_container">
                    <a href="#" class="nav_icon_link user_icon_link" title="User Account">
                        <svg class="nav_icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"/>
                            <path d="M12 14C7.02944 14 3 18.0294 3 23H21C21 18.0294 16.9706 14 12 14Z"/>
                        </svg>
                    </a>
                    <div class="user_dropdown">
                        <div class="dropdown_header">
                            <span class="user_greeting">Welcome!</span>
                            <span class="user_subtitle">Join us today</span>
                        </div>
                        <div class="dropdown_menu">
                            <a href="pages/auth/login.php" class="dropdown_item auth_item" id="loginNavBtn">
                                <svg class="dropdown_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Sign In
                            </a>
                            <a href="pages/auth/register.php" class="dropdown_item auth_item">
                                <svg class="dropdown_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Sign Up
                            </a>
                            <div class="dropdown_divider"></div>
                            <a href="pages/shop.php" class="dropdown_item">
                                <svg class="dropdown_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Browse Products
                            </a>
                            <a href="pages/about.php" class="dropdown_item">
                                <svg class="dropdown_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                About Us
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    async logout() {
        try {
            const basePath = this.getBasePath();
            const response = await fetch(basePath + 'api/logout.php', {
                method: 'POST',
                credentials: 'same-origin'
            });

            if (response.ok) {
                // Refresh the page to update navbar state
                window.location.reload();
            } else {
                console.error('Logout failed');
                // Still refresh on error
                window.location.reload();
            }
        } catch (error) {
            console.error('Error during logout:', error);
            // Still refresh on error
            window.location.reload();
        }
    }

    // Method to check if user is authenticated and is an admin (for admin pages)
    async requireAdminAuth() {
        try {
            const basePath = this.getBasePath();
            const response = await fetch(basePath + 'api/check-auth.php', {
                method: 'GET',
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                // Check if user is admin using either role field or is_admin field
                if (data.success && data.user && (data.user.role === 'admin' || data.user.is_admin === '1' || data.user.is_admin === 1)) {
                    return data.user;
                } else {
                    // Redirect to login if not authenticated or not an admin
                    window.location.href = basePath + 'index.php';
                    return null;
                }
            } else {
                window.location.href = basePath + 'index.php';
                return null;
            }
        } catch (error) {
            console.error('Error checking admin authentication:', error);
            const basePath = this.getBasePath();
            window.location.href = basePath + 'index.php';
            return null;
        }
    }

    // Method to check if user is authenticated (for protected pages)
    async requireAuth() {
        try {
            const basePath = this.getBasePath();
            const response = await fetch(basePath + 'api/check-auth.php', {
                method: 'GET',
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                if (data.success && data.user) {
                    return data.user;
                } else {
                    // Redirect to login if not authenticated
                    window.location.href = basePath + 'pages/auth/login.php';
                    return null;
                }
            } else {
                window.location.href = basePath + 'pages/auth/login.php';
                return null;
            }
        } catch (error) {
            console.error('Error checking authentication:', error);
            const basePath = this.getBasePath();
            window.location.href = basePath + 'pages/auth/login.php';
            return null;
        }
    }

    // Method to prevent access to auth pages when already logged in
    async preventAuthPageAccess() {
        try {
            const basePath = this.getBasePath();
            const response = await fetch(basePath + 'api/check-auth.php', {
                method: 'GET',
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                if (data.success && data.user) {
                    // User is already logged in, redirect to home
                    window.location.href = basePath + 'index.php';
                }
            }
        } catch (error) {
            console.error('Error checking authentication:', error);
        }
    }

    // Method to refresh navbar after profile picture update
    async refreshNavbar() {
        await this.loadUser();
    }

    // Method to get correct base path based on current page location
    getBasePath() {
        const path = window.location.pathname;
        
        if (path.includes('/pages/admin/')) {
            // Admin pages are in a subfolder, need to go up two levels
            return '../../';
        } else if (path.includes('/pages/auth/')) {
            return '../../';
        } else if (path.includes('/pages/') || path.includes('/components/') || path.includes('/error/')) {
            return '../';
        } else {
            return '';
        }
    }
}

// Export for use in other scripts
window.UserAuth = UserAuth;

// Note: UserAuth will be initialized by components.js after navbar is loaded
