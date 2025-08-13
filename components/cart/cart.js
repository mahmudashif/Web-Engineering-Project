// Cart functionality - API-based cart system

let cartItems = [];

// Initialize cart
document.addEventListener('DOMContentLoaded', function() {
    loadCartFromAPI();
    bindEventListeners();
});

// Load cart from API
async function loadCartFromAPI() {
    try {
        const response = await fetch('../api/get-cart.php');
        const data = await response.json();
        
        if (data.success) {
            cartItems = data.data.map(item => ({
                id: item.cart_item_id,
                productId: item.product_id,
                name: item.name,
                description: item.description || 'No description available',
                price: parseFloat(item.price),
                quantity: item.quantity,
                image: item.image_url,
                brand: item.brand,
                stockQuantity: item.stock_quantity,
                isAvailable: item.is_available,
                maxQuantity: item.max_quantity,
                itemTotal: parseFloat(item.item_total),
                formattedPrice: item.formatted_price,
                formattedItemTotal: item.formatted_item_total
            }));
            
            updateCartDisplay();
            updateCartCount();
            toggleCartVisibility();
            
            // Animate cart items if there are any
            if (cartItems.length > 0) {
                setTimeout(animateCartItems, 100);
            }
        }
    } catch (error) {
        console.error('Error loading cart:', error);
        showError('Failed to load cart items');
    }
}

// Update quantity
async function updateQuantity(cartItemId, change) {
    const item = cartItems.find(item => item.id === cartItemId);
    if (!item) return;
    
    const newQuantity = Math.max(1, Math.min(item.maxQuantity, item.quantity + change));
    if (newQuantity === item.quantity) return;
    
    try {
        const response = await fetch(`../api/update-cart.php?id=${cartItemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                quantity: newQuantity
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            await loadCartFromAPI(); // Reload to get updated data
            showSuccess('Cart updated successfully');
        } else {
            showError(data.message);
        }
    } catch (error) {
        console.error('Error updating quantity:', error);
        showError('Failed to update cart');
    }
}

// Remove item from cart
async function removeItem(cartItemId) {
    if (!confirm('Are you sure you want to remove this item from your cart?')) {
        return;
    }
    
    try {
        const response = await fetch(`../api/update-cart.php?id=${cartItemId}`, {
            method: 'DELETE'
        });
        
        const data = await response.json();
        
        if (data.success) {
            await loadCartFromAPI(); // Reload to get updated data
            showSuccess('Item removed from cart');
        } else {
            showError(data.message);
        }
    } catch (error) {
        console.error('Error removing item:', error);
        showError('Failed to remove item from cart');
    }
}

// Update cart display
function updateCartDisplay() {
    // Render cart items
    renderCartItems();
    
    // Update calculations
    const subtotal = calculateSubtotal();
    const tax = subtotal * 0.08; // 8% tax
    const discount = 0; // No discount for now
    const total = subtotal + tax - discount;
    
    // Update summary amounts
    document.getElementById('subtotal-amount').textContent = `$${subtotal.toFixed(2)}`;
    document.getElementById('tax-amount').textContent = `$${tax.toFixed(2)}`;
    document.getElementById('discount-amount').textContent = `-$${discount.toFixed(2)}`;
    document.getElementById('total-amount').textContent = `$${total.toFixed(2)}`;
    
    // Update item count
    const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    document.querySelector('.item-count').textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''}`;
    
    // Enable/disable checkout button
    const checkoutBtn = document.getElementById('checkout-btn');
    if (totalItems > 0) {
        checkoutBtn.disabled = false;
        checkoutBtn.style.opacity = '1';
        checkoutBtn.style.cursor = 'pointer';
    } else {
        checkoutBtn.disabled = true;
        checkoutBtn.style.opacity = '0.5';
        checkoutBtn.style.cursor = 'not-allowed';
    }
}

// Calculate subtotal
function calculateSubtotal() {
    return cartItems.reduce((sum, item) => sum + item.itemTotal, 0);
}

// Update cart count in navbar
function updateCartCount() {
    const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    const cartCountElements = document.querySelectorAll('.cart_count, .cart-count');
    cartCountElements.forEach(element => {
        element.textContent = totalItems;
        element.style.display = totalItems > 0 ? 'inline' : 'none';
    });
}

// Toggle cart visibility based on items (Always show cart content and order status)
function toggleCartVisibility() {
    const cartSection = document.querySelector('.cart-section');
    const emptyCartSection = document.querySelector('.empty-cart');
    const orderStatusSection = document.querySelector('.order-status-section');
    
    // Always show the cart section and order status section
    if (cartSection) cartSection.style.display = 'block';
    if (orderStatusSection) orderStatusSection.style.display = 'block';
    
    if (cartItems.length === 0) {
        if (cartSection) cartSection.classList.remove('has-items');
        if (emptyCartSection) emptyCartSection.classList.remove('hidden');
    } else {
        if (cartSection) cartSection.classList.add('has-items');
        if (emptyCartSection) emptyCartSection.classList.add('hidden');
    }
}

// Render cart items dynamically
function renderCartItems() {
    const cartItemsList = document.getElementById('cart-items-list');
    if (!cartItemsList) return;
    
    cartItemsList.innerHTML = '';
    
    cartItems.forEach(item => {
        const availabilityWarning = !item.isAvailable ? 
            `<div class="stock-warning">⚠️ Only ${item.stockQuantity} items available</div>` : '';
        
        const cartItemHTML = `
            <div class="cart-item ${!item.isAvailable ? 'unavailable' : ''}" data-item-id="${item.id}">
                <div class="item-image">
                    <img src="${item.image}" alt="${item.name}" onerror="this.src='../assets/images/placeholder-product.svg'">
                </div>
                <div class="item-details">
                    <div class="item-brand">${escapeHtml(item.brand || 'Unknown Brand')}</div>
                    <h3>${escapeHtml(item.name)}</h3>
                    <p class="item-description">${escapeHtml(item.description)}</p>
                    ${availabilityWarning}
                    <div class="item-actions">
                        <button class="btn-danger btn-sm" onclick="removeItem(${item.id})">Remove</button>
                    </div>
                </div>
                <div class="item-quantity">
                    <label>Quantity</label>
                    <div class="quantity-controls">
                        <button class="qty-btn" onclick="updateQuantity(${item.id}, -1)" ${item.quantity <= 1 ? 'disabled' : ''}>-</button>
                        <input type="number" value="${item.quantity}" min="1" max="${item.maxQuantity}" id="qty-${item.id}" onchange="handleQuantityChange(${item.id}, this.value)">
                        <button class="qty-btn" onclick="updateQuantity(${item.id}, 1)" ${item.quantity >= item.maxQuantity ? 'disabled' : ''}>+</button>
                    </div>
                    <small>Max: ${item.maxQuantity}</small>
                </div>
                <div class="item-price">
                    <div class="current-price">${item.formattedItemTotal}</div>
                    ${item.quantity > 1 ? `<div class="unit-price">${item.formattedPrice} × ${item.quantity}</div>` : ''}
                </div>
            </div>
        `;
        cartItemsList.insertAdjacentHTML('beforeend', cartItemHTML);
    });
}

// Handle quantity change from input
async function handleQuantityChange(cartItemId, newQuantityStr) {
    const newQuantity = parseInt(newQuantityStr);
    const item = cartItems.find(item => item.id === cartItemId);
    
    if (!item || !newQuantity || newQuantity <= 0) {
        document.getElementById(`qty-${cartItemId}`).value = item ? item.quantity : 1;
        return;
    }
    
    if (newQuantity > item.maxQuantity) {
        document.getElementById(`qty-${cartItemId}`).value = item.maxQuantity;
        showError(`Maximum ${item.maxQuantity} items available`);
        return;
    }
    
    if (newQuantity === item.quantity) return;
    
    try {
        const response = await fetch(`../api/update-cart.php?id=${cartItemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                quantity: newQuantity
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            await loadCartFromAPI();
        } else {
            document.getElementById(`qty-${cartItemId}`).value = item.quantity;
            showError(data.message);
        }
    } catch (error) {
        console.error('Error updating quantity:', error);
        document.getElementById(`qty-${cartItemId}`).value = item.quantity;
        showError('Failed to update quantity');
    }
}

// Bind event listeners
function bindEventListeners() {
    // Checkout button
    const checkoutBtn = document.querySelector('.btn-checkout');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            if (cartItems.length > 0) {
                // Check if all items are available
                const unavailableItems = cartItems.filter(item => !item.isAvailable);
                if (unavailableItems.length > 0) {
                    showError('Some items in your cart are no longer available. Please review your cart.');
                    return;
                }
                
                showInfo('Redirecting to checkout...');
                // Redirect to checkout page
                window.location.href = '../pages/checkout.php';
            }
        });
    }
}

// Animation for cart items
function animateCartItems() {
    const cartItemElements = document.querySelectorAll('.cart-item');
    cartItemElements.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.5s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

// Notification functions
function showSuccess(message) {
    showNotification(message, 'success');
}

function showError(message) {
    showNotification(message, 'error');
}

function showInfo(message) {
    showNotification(message, 'info');
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close" onclick="this.parentElement.parentElement.remove()">&times;</button>
        </div>
    `;
    
    // Add CSS if not exists
    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                max-width: 400px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                z-index: 10000;
                animation: slideInRight 0.3s ease;
            }
            .notification-success { border-left: 4px solid #10B981; }
            .notification-error { border-left: 4px solid #EF4444; }
            .notification-info { border-left: 4px solid #3B82F6; }
            .notification-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 16px;
            }
            .notification-message { flex: 1; font-weight: 500; }
            .notification-close {
                background: none;
                border: none;
                font-size: 18px;
                cursor: pointer;
                color: #9CA3AF;
                margin-left: 12px;
            }
            .notification-close:hover { color: #374151; }
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            .cart-item.unavailable {
                opacity: 0.7;
                background: #FEF2F2;
            }
            .stock-warning {
                color: #DC2626;
                font-size: 12px;
                font-weight: 500;
                margin-top: 4px;
            }
            .item-brand {
                color: #6D28D9;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
                margin-bottom: 4px;
            }
            .unit-price {
                color: #6B7280;
                font-size: 12px;
                margin-top: 4px;
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Utility function
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Global function to refresh cart (can be called from other pages)
window.refreshCart = function() {
    loadCartFromAPI();
};

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    loadCartFromAPI();
});
