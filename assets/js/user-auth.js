// ========== User Authentication State Management ========== 

// Simple user state management (in a real app, this would connect to your backend)
const UserAuth = {
    // Check if user is logged in (you can replace this with actual session/token checking)
    isLoggedIn: function() {
        return localStorage.getItem('userLoggedIn') === 'true';
    },
    
    // Get current user data (replace with actual user data fetching)
    getCurrentUser: function() {
        const userData = localStorage.getItem('userData');
        return userData ? JSON.parse(userData) : null;
    },
    
    // Simulate login (replace with actual login logic)
    login: function(userData) {
        localStorage.setItem('userLoggedIn', 'true');
        localStorage.setItem('userData', JSON.stringify(userData));
        this.updateDropdownUI();
    },
    
    // Simulate logout (replace with actual logout logic)
    logout: function() {
        localStorage.removeItem('userLoggedIn');
        localStorage.removeItem('userData');
        this.updateDropdownUI();
    },
    
    // Update the dropdown UI based on login status
    updateDropdownUI: function() {
        const notLoggedInContent = document.getElementById('dropdown_not_logged_in');
        const loggedInContent = document.getElementById('dropdown_logged_in');
        const userNameElement = document.getElementById('user_name');
        
        if (!notLoggedInContent || !loggedInContent) return;
        
        if (this.isLoggedIn()) {
            // Show logged-in content
            notLoggedInContent.style.display = 'none';
            loggedInContent.style.display = 'block';
            
            // Update user name if available
            const user = this.getCurrentUser();
            if (user && user.name && userNameElement) {
                userNameElement.textContent = user.name;
            }
        } else {
            // Show not-logged-in content
            notLoggedInContent.style.display = 'block';
            loggedInContent.style.display = 'none';
        }
    }
};

// Handle logout functionality
function handleLogout() {
    if (confirm('Are you sure you want to sign out?')) {
        UserAuth.logout();
        
        // Optional: Redirect to home page
        window.location.href = 'index.php';
        
        // Show success message
        showNotification('You have been signed out successfully!', 'success');
    }
}

// Simple notification system
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10B981' : type === 'error' ? '#EF4444' : '#3B82F6'};
        color: white;
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        z-index: 10000;
        font-weight: 500;
        max-width: 300px;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    notification.textContent = message;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Simulate successful login (for testing purposes)
function simulateLogin(name = 'John Doe', email = 'john@example.com') {
    const userData = {
        name: name,
        email: email,
        loginTime: new Date().toISOString()
    };
    
    UserAuth.login(userData);
    showNotification(`Welcome back, ${name}!`, 'success');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Update dropdown UI based on current login status
    UserAuth.updateDropdownUI();
    
    // Add click handler for testing login (remove this in production)
    // You can call simulateLogin() from browser console to test logged-in state
    
    // Optional: Add keyboard shortcut for testing
    document.addEventListener('keydown', function(e) {
        // Ctrl + Shift + L to simulate login (for testing only)
        if (e.ctrlKey && e.shiftKey && e.key === 'L') {
            if (!UserAuth.isLoggedIn()) {
                simulateLogin();
            } else {
                handleLogout();
            }
        }
    });
});

// Export functions for global access
window.UserAuth = UserAuth;
window.handleLogout = handleLogout;
window.simulateLogin = simulateLogin;
window.showNotification = showNotification;
