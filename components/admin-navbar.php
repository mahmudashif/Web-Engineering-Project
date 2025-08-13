<div class="admin-navbar">
    <div class="admin-brand">
        <a href="../../index.php">Orebi Admin</a>
    </div>
    
    <nav class="admin-nav">
        <ul class="admin-nav-list">
            <li><a href="../admin/dashboard.php" class="nav-link">
                <span class="nav-icon">📊</span>
                <span class="nav-text">Dashboard</span>
            </a></li>
            <li><a href="../admin/users.php" class="nav-link">
                <span class="nav-icon">👥</span>
                <span class="nav-text">Users</span>
            </a></li>
            <li><a href="../admin/products.php" class="nav-link">
                <span class="nav-icon">🛒</span>
                <span class="nav-text">Products</span>
            </a></li>
            <li><a href="../admin/orders.php" class="nav-link active">
                <span class="nav-icon">📦</span>
                <span class="nav-text">Orders</span>
            </a></li>
            <li><a href="../admin/settings.php" class="nav-link">
                <span class="nav-icon">⚙️</span>
                <span class="nav-text">Settings</span>
            </a></li>
        </ul>
    </nav>
    
    <div class="admin-user-section">
        <div class="admin-user-info">
            <span id="admin-name">Admin</span>
            <span id="admin-role">Administrator</span>
        </div>
        <div class="admin-profile-pic" id="admin-profile-pic">
            <img src="" alt="Admin" id="admin-image" style="display:none;">
            <div class="admin-initials" id="admin-initials">A</div>
        </div>
        <a href="../../api/logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<style>
.admin-navbar {
    background: #fff;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.admin-brand a {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--primary-color);
    text-decoration: none;
}

.admin-nav-list {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 2rem;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    text-decoration: none;
    color: #64748b;
    border-radius: 6px;
    transition: all 0.2s;
}

.nav-link:hover, .nav-link.active {
    color: var(--primary-color);
    background-color: #f1f5f9;
}

.nav-icon {
    font-size: 1rem;
}

.admin-user-section {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.admin-user-info {
    text-align: right;
}

.admin-user-info span {
    display: block;
    font-size: 0.9rem;
}

#admin-name {
    font-weight: 500;
    color: #1e293b;
}

#admin-role {
    color: #64748b;
}

.admin-profile-pic {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
}

.admin-profile-pic img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.admin-initials {
    color: white;
    font-weight: bold;
    font-size: 0.9rem;
}

.logout-btn {
    padding: 0.5rem 1rem;
    background: #ef4444;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 0.9rem;
    transition: background 0.2s;
}

.logout-btn:hover {
    background: #dc2626;
}

@media (max-width: 768px) {
    .admin-navbar {
        flex-direction: column;
        gap: 1rem;
    }
    
    .admin-nav-list {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .nav-text {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set active nav link based on current page
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (currentPath.includes(link.getAttribute('href').replace('../admin/', ''))) {
            link.classList.add('active');
        }
    });
    
    // Load admin user info
    loadAdminInfo();
});

function loadAdminInfo() {
    // Wait for UserAuth to be available
    const checkUserAuth = setInterval(function() {
        if (window.userAuth) {
            clearInterval(checkUserAuth);
            
            window.userAuth.requireAdminAuth().then(user => {
                if (user) {
                    updateAdminDisplay(user);
                }
            });
        }
    }, 100);
}

function updateAdminDisplay(user) {
    const adminNameElement = document.getElementById('admin-name');
    const adminRoleElement = document.getElementById('admin-role');
    const adminImageElement = document.getElementById('admin-image');
    const adminInitialsElement = document.getElementById('admin-initials');
    
    if (adminNameElement) {
        adminNameElement.textContent = user.full_name;
    }
    
    if (adminRoleElement) {
        adminRoleElement.textContent = 'Administrator';
    }
    
    if (user.profile_picture) {
        const basePath = '../../';
        const profilePicturePath = basePath + user.profile_picture;
        
        adminImageElement.src = profilePicturePath;
        adminImageElement.style.display = 'block';
        adminInitialsElement.style.display = 'none';
    } else {
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
</script>
