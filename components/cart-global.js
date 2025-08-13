// Global Cart Management System - API-based

// Global cart state
window.GlobalCart = {
    items: [],
    
    // Initialize cart from API
    async init() {
        await this.loadFromAPI();
        this.updateCartCount();
        this.bindEvents();
    },
    
    // Load cart from API
    async loadFromAPI() {
        try {
            const response = await fetch('../api/get-cart.php');
            const data = await response.json();
            
            if (data.success) {
                this.items = data.data.map(item => ({
                    id: item.product_id,
                    cartItemId: item.cart_item_id,
                    name: item.name,
                    price: parseFloat(item.price),
                    quantity: item.quantity,
                    image: item.image_url,
                    description: item.description,
                    brand: item.brand
                }));
            } else {
                this.items = [];
            }
        } catch (error) {
            console.error('Error loading cart from API:', error);
            this.items = [];
        }
    },
    
    // Add item to cart via API
    async addItem(productId, quantity = 1) {
        try {
            const response = await fetch('../api/add-to-cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                await this.loadFromAPI(); // Reload cart data
                this.updateCartCount();
                this.showAddedNotification(data.data.product_name);
                return true;
            } else {
                this.showErrorNotification(data.message);
                return false;
            }
        } catch (error) {
            console.error('Error adding item to cart:', error);
            this.showErrorNotification('Failed to add item to cart');
            return false;
        }
    },
    
    // Remove item from cart via API
    async removeItem(cartItemId) {
        try {
            const response = await fetch(`../api/update-cart.php?id=${cartItemId}`, {
                method: 'DELETE'
            });
            
            const data = await response.json();
            
            if (data.success) {
                await this.loadFromAPI();
                this.updateCartCount();
                return true;
            } else {
                this.showErrorNotification(data.message);
                return false;
            }
        } catch (error) {
            console.error('Error removing item from cart:', error);
            this.showErrorNotification('Failed to remove item from cart');
            return false;
        }
    },
    
    // Update item quantity via API
    async updateQuantity(cartItemId, quantity) {
        try {
            const response = await fetch(`../api/update-cart.php?id=${cartItemId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    quantity: quantity
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                await this.loadFromAPI();
                this.updateCartCount();
                return true;
            } else {
                this.showErrorNotification(data.message);
                return false;
            }
        } catch (error) {
            console.error('Error updating cart quantity:', error);
            this.showErrorNotification('Failed to update quantity');
            return false;
        }
    },
    
    // Get cart total
    getTotal() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    },
    
    // Get cart item count
    getItemCount() {
        return this.items.reduce((count, item) => count + item.quantity, 0);
    },
    
    // Update cart count in navbar
    updateCartCount() {
        const cartCountElements = document.querySelectorAll('.cart_count, .cart-count');
        const count = this.getItemCount();
        
        cartCountElements.forEach(element => {
            element.textContent = count;
            if (count > 0) {
                element.style.display = 'inline-block';
                element.style.opacity = '1';
            } else {
                element.style.display = 'none';
                element.style.opacity = '0';
            }
        });
    },
    
    // Clear old localStorage data (migration function)
    clearOldStorage() {
        localStorage.removeItem('orebiCart');
    },
    
    // Show notification when item is added
    showAddedNotification(productName) {
        this.showNotification(`${productName} added to cart!`, 'success');
    },
    
    // Show error notification
    showErrorNotification(message) {
        this.showNotification(message, 'error');
    },
    
    // Generic notification function
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `cart-notification ${type}`;
        
        const icon = type === 'success' ? 
            '<path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/>' :
            type === 'error' ?
            '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>' :
            '<circle cx="12" cy="12" r="10"/><path d="M12 6v6m0 4h.01"/>';
        
        notification.innerHTML = `
            <div class="notification-content">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    ${icon}
                </svg>
                <span>${message}</span>
            </div>
        `;
        
        const colors = {
            success: 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
            error: 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
            info: 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)'
        };
        
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${colors[type]};
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            transform: translateX(400px);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            font-weight: 600;
            font-size: 14px;
            max-width: 350px;
        `;
        
        const notificationContent = notification.querySelector('.notification-content');
        notificationContent.style.cssText = `
            display: flex;
            align-items: center;
            gap: 12px;
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 4 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 4000);
    },
    
    // Check if user is logged in
    async checkAuth() {
        try {
            const response = await fetch('../api/check-auth.php');
            const data = await response.json();
            return data.success;
        } catch (error) {
            return false;
        }
    },
    
    // Bind events for add to cart buttons - DISABLED to prevent conflicts
    bindEvents() {
        // Cart-global.js event handling is disabled to prevent conflicts
        // Individual pages handle their own add-to-cart functionality
        
        // Handle cart icon clicks only
        document.addEventListener('click', (e) => {
            if (e.target.closest('.cart_icon_link')) {
                // If cart is empty, show notification
                if (this.items.length === 0) {
                    e.preventDefault();
                    this.showNotification('Your cart is empty!', 'info');
                }
            }
        });
    },
    
    // Get base path for API calls
    getBasePath() {
        const path = window.location.pathname;
        if (path.includes('/pages/auth/')) {
            return '../../';
        } else if (path.includes('/pages/') || path.includes('/components/') || path.includes('/error/')) {
            return '../';
        } else {
            return '';
        }
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', async () => {
    // Clear old localStorage data
    window.GlobalCart.clearOldStorage();
    
    // Initialize new cart system
    await window.GlobalCart.init();
});

// Also initialize if DOM is already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', async () => {
        window.GlobalCart.clearOldStorage();
        await window.GlobalCart.init();
    });
} else {
    window.GlobalCart.clearOldStorage();
    window.GlobalCart.init();
}
