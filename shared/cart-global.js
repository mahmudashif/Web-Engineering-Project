// Global Cart Management System

// Global cart state
window.GlobalCart = {
    items: [],
    
    // Initialize cart from localStorage
    init() {
        this.loadFromStorage();
        this.updateCartCount();
        this.bindEvents();
    },
    
    // Add item to cart
    addItem(product) {
        const existingItem = this.items.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.items.push({
                ...product,
                quantity: 1,
                addedAt: new Date().toISOString()
            });
        }
        
        this.saveToStorage();
        this.updateCartCount();
        this.showAddedNotification(product.name);
    },
    
    // Remove item from cart
    removeItem(productId) {
        this.items = this.items.filter(item => item.id !== productId);
        this.saveToStorage();
        this.updateCartCount();
    },
    
    // Update item quantity
    updateQuantity(productId, quantity) {
        const item = this.items.find(item => item.id === productId);
        if (item) {
            if (quantity <= 0) {
                this.removeItem(productId);
            } else {
                item.quantity = quantity;
                this.saveToStorage();
                this.updateCartCount();
            }
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
        const cartCountElements = document.querySelectorAll('.cart_count');
        const count = this.getItemCount();
        
        cartCountElements.forEach(element => {
            element.textContent = count;
            element.style.display = count > 0 ? 'block' : 'none';
        });
    },
    
    // Save to localStorage
    saveToStorage() {
        localStorage.setItem('orebiCart', JSON.stringify(this.items));
    },
    
    // Load from localStorage
    loadFromStorage() {
        const stored = localStorage.getItem('orebiCart');
        if (stored) {
            try {
                this.items = JSON.parse(stored);
            } catch (e) {
                console.error('Error loading cart from storage:', e);
                this.items = [];
            }
        }
    },
    
    // Clear cart
    clearCart() {
        this.items = [];
        this.saveToStorage();
        this.updateCartCount();
    },
    
    // Show notification when item is added
    showAddedNotification(productName) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'cart-notification';
        notification.innerHTML = `
            <div class="notification-content">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M9 12l2 2 4-4"/>
                    <circle cx="12" cy="12" r="10"/>
                </svg>
                <span>${productName} added to cart!</span>
            </div>
        `;
        
        // Add styles
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            z-index: 10000;
            transform: translateX(400px);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            font-weight: 600;
            font-size: 14px;
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
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    },
    
    // Bind events for add to cart buttons
    bindEvents() {
        // Handle add to cart button clicks
        document.addEventListener('click', (e) => {
            if (e.target.matches('.add-to-cart, button[data-action="add-to-cart"]')) {
                e.preventDefault();
                
                // Get product data from the button's parent product card
                const productCard = e.target.closest('.product-card, .product, .featured-product');
                if (productCard) {
                    const product = this.extractProductData(productCard);
                    if (product) {
                        this.addItem(product);
                        
                        // Visual feedback
                        const button = e.target;
                        const originalText = button.textContent;
                        const originalBackground = button.style.background;
                        
                        button.textContent = 'Added!';
                        button.style.background = '#059669';
                        button.disabled = true;
                        
                        setTimeout(() => {
                            button.textContent = originalText;
                            button.style.background = originalBackground;
                            button.disabled = false;
                        }, 1500);
                    }
                }
            }
        });
        
        // Handle cart icon clicks
        document.addEventListener('click', (e) => {
            if (e.target.closest('.cart_icon_link')) {
                // If cart is empty, show notification
                if (this.items.length === 0) {
                    e.preventDefault();
                    this.showEmptyCartNotification();
                }
            }
        });
    },
    
    // Extract product data from DOM element
    extractProductData(productElement) {
        try {
            // Try to get data from data attributes first
            const id = productElement.dataset.productId || 
                      productElement.querySelector('[data-product-id]')?.dataset.productId ||
                      this.generateId();
                      
            const name = productElement.dataset.productName || 
                        productElement.querySelector('.product-title, .product-name, h3, h4')?.textContent?.trim() ||
                        'Product';
                        
            const priceText = productElement.dataset.productPrice || 
                             productElement.querySelector('.price, .product-price, .current-price')?.textContent?.trim() ||
                             '0';
                             
            const price = parseFloat(priceText.replace(/[^0-9.]/g, '')) || 0;
            
            const image = productElement.dataset.productImage || 
                         productElement.querySelector('img')?.src ||
                         '/images/placeholder.jpg';
                         
            const description = productElement.dataset.productDescription || 
                              productElement.querySelector('.product-description, .description')?.textContent?.trim() ||
                              'High-quality product';
            
            return {
                id: id,
                name: name,
                price: price,
                image: image,
                description: description,
                category: productElement.dataset.category || 'electronics'
            };
        } catch (error) {
            console.error('Error extracting product data:', error);
            return null;
        }
    },
    
    // Generate unique ID
    generateId() {
        return 'product_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    },
    
    // Show empty cart notification
    showEmptyCartNotification() {
        const notification = document.createElement('div');
        notification.className = 'cart-notification empty';
        notification.innerHTML = `
            <div class="notification-content">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="9" cy="21" r="1"/>
                    <circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                <span>Your cart is empty!</span>
            </div>
        `;
        
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(251, 191, 36, 0.4);
            z-index: 10000;
            transform: translateX(400px);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            font-weight: 600;
            font-size: 14px;
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
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.GlobalCart.init();
});

// Also initialize if DOM is already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.GlobalCart.init();
    });
} else {
    window.GlobalCart.init();
}
