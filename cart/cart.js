// Cart functionality

// Cart data (starts with some test items for demonstration)
let cartItems = [
    {
        id: 1,
        name: "iPhone 15 Pro",
        description: "Latest iPhone with A17 Pro chip and titanium design",
        price: 999.00,
        originalPrice: 1099.00,
        quantity: 1,
        image: "images/mini-slider/1.jpg",
        color: "Natural Titanium",
        storage: "128GB",
        badge: "NEW"
    },
    {
        id: 2,
        name: "MacBook Pro 14\"",
        description: "M3 chip with 8-core CPU and 10-core GPU",
        price: 1599.00,
        quantity: 1,
        image: "images/mini-slider/2.png",
        color: "Space Gray",
        ram: "16GB",
        storage: "512GB SSD"
    }
];

// Initialize cart
document.addEventListener('DOMContentLoaded', function() {
    loadCartFromStorage();
    updateCartDisplay();
    updateCartCount();
    toggleCartVisibility();
    bindEventListeners();
});

// Update quantity
function updateQuantity(itemId, change) {
    const item = cartItems.find(item => item.id === itemId);
    if (item) {
        item.quantity = Math.max(1, item.quantity + change);
        document.getElementById(`qty-${itemId}`).value = item.quantity;
        updateCartDisplay();
        updateCartCount();
        autoSaveCart();
    }
}

// Remove item from cart
function removeItem(itemId) {
    if (confirm('Are you sure you want to remove this item from your cart?')) {
        cartItems = cartItems.filter(item => item.id !== itemId);
        updateCartDisplay();
        updateCartCount();
        toggleCartVisibility();
        autoSaveCart();
    }
}

// Update cart display
function updateCartDisplay() {
    // Render cart items
    renderCartItems();
    
    // Update calculations
    const subtotal = calculateSubtotal();
    const tax = subtotal * 0.08; // 8% tax
    const discount = calculateDiscount();
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
    return cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
}

// Calculate discount
function calculateDiscount() {
    // Simple discount logic - $100 off if iPhone is in cart
    const hasIphone = cartItems.some(item => item.name.includes('iPhone'));
    return hasIphone ? 100 : 0;
}

// Update cart count in navbar
function updateCartCount() {
    const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    const cartCountElement = document.querySelector('.cart_count');
    if (cartCountElement) {
        cartCountElement.textContent = totalItems;
    }
}

// Toggle cart visibility based on items
function toggleCartVisibility() {
    const cartSection = document.querySelector('.cart-section');
    const emptyCartSection = document.querySelector('.empty-cart');
    
    if (cartItems.length === 0) {
        cartSection.classList.remove('has-items');
        emptyCartSection.classList.remove('hidden');
    } else {
        cartSection.classList.add('has-items');
        emptyCartSection.classList.add('hidden');
    }
}

// Render cart items dynamically
function renderCartItems() {
    const cartItemsList = document.getElementById('cart-items-list');
    cartItemsList.innerHTML = '';
    
    cartItems.forEach(item => {
        const cartItemHTML = `
            <div class="cart-item" data-item-id="${item.id}">
                <div class="item-image">
                    <img src="${item.image}" alt="${item.name}">
                    ${item.badge ? `<div class="item-badge ${item.badge.toLowerCase()}">${item.badge}</div>` : ''}
                </div>
                <div class="item-details">
                    <h3>${item.name}</h3>
                    <p class="item-description">${item.description}</p>
                    <div class="item-specs">
                        ${item.color ? `<span>Color: ${item.color}</span>` : ''}
                        ${item.storage ? `<span>Storage: ${item.storage}</span>` : ''}
                        ${item.ram ? `<span>RAM: ${item.ram}</span>` : ''}
                        ${item.case ? `<span>Case: ${item.case}</span>` : ''}
                    </div>
                    <div class="item-actions">
                        <button class="btn-secondary btn-sm">Edit</button>
                        <button class="btn-danger btn-sm" onclick="removeItem(${item.id})">Remove</button>
                    </div>
                </div>
                <div class="item-quantity">
                    <label>Quantity</label>
                    <div class="quantity-controls">
                        <button class="qty-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
                        <input type="number" value="${item.quantity}" min="1" id="qty-${item.id}" onchange="handleQuantityChange(${item.id}, this.value)">
                        <button class="qty-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                    </div>
                </div>
                <div class="item-price">
                    <div class="current-price">$${(item.price * item.quantity).toFixed(2)}</div>
                    ${item.originalPrice ? `<div class="original-price">$${item.originalPrice.toFixed(2)}</div>` : ''}
                    ${item.originalPrice ? `<div class="discount">Save $${((item.originalPrice - item.price) * item.quantity).toFixed(2)}</div>` : ''}
                    ${item.quantity > 1 ? `<div class="total-price">$${item.price.toFixed(2)} × ${item.quantity}</div>` : ''}
                </div>
            </div>
        `;
        cartItemsList.insertAdjacentHTML('beforeend', cartItemHTML);
    });
}

// Handle quantity change from input
function handleQuantityChange(itemId, newQuantity) {
    const quantity = parseInt(newQuantity);
    if (quantity > 0) {
        const item = cartItems.find(item => item.id === itemId);
        if (item) {
            item.quantity = quantity;
            updateCartDisplay();
            updateCartCount();
            autoSaveCart();
        }
    }
}

// Apply promo code
function applyPromoCode() {
    const promoInput = document.querySelector('.promo-input input');
    const promoCode = promoInput.value.trim().toLowerCase();
    
    let discount = 0;
    let message = '';
    
    switch(promoCode) {
        case 'welcome10':
            discount = 0.10;
            message = '10% discount applied!';
            break;
        case 'save20':
            discount = 0.20;
            message = '20% discount applied!';
            break;
        case 'freeship':
            message = 'Free shipping applied!';
            break;
        default:
            message = 'Invalid promo code';
            break;
    }
    
    if (discount > 0) {
        // Apply percentage discount
        const subtotal = calculateSubtotal();
        const discountAmount = subtotal * discount;
        
        // Update discount row
        document.querySelector('.summary-row.discount span:last-child').textContent = `-$${discountAmount.toFixed(2)}`;
        
        // Recalculate total
        updateCartDisplay();
    }
    
    // Show message (you could implement a toast notification here)
    alert(message);
    
    // Clear input
    promoInput.value = '';
}

// Bind event listeners
function bindEventListeners() {
    // Apply promo code button
    const applyBtn = document.querySelector('.btn-apply');
    if (applyBtn) {
        applyBtn.addEventListener('click', applyPromoCode);
    }
    
    // Promo code input enter key
    const promoInput = document.querySelector('.promo-input input');
    if (promoInput) {
        promoInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyPromoCode();
            }
        });
    }
    
    // Checkout button
    const checkoutBtn = document.querySelector('.btn-checkout');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            if (cartItems.length > 0) {
                alert('Proceeding to checkout... (This would redirect to a checkout page in a real application)');
            }
        });
    }
    
    // Add to cart buttons for recommended items
    document.querySelectorAll('.btn-add-small').forEach(btn => {
        btn.addEventListener('click', function() {
            // Simple feedback
            const originalText = this.textContent;
            this.textContent = 'Added!';
            this.style.background = '#059669';
            
            setTimeout(() => {
                this.textContent = originalText;
                this.style.background = '';
            }, 1500);
        });
    });
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

// Auto-save cart changes
function autoSaveCart() {
    saveCartToStorage();
}

// Local storage functions
function saveCartToStorage() {
    localStorage.setItem('orebiCart', JSON.stringify(cartItems));
}

function loadCartFromStorage() {
    const stored = localStorage.getItem('orebiCart');
    if (stored) {
        try {
            cartItems = JSON.parse(stored);
        } catch (e) {
            console.error('Error loading cart from storage:', e);
            cartItems = [];
        }
    }
}

// Load cart from storage on page load
document.addEventListener('DOMContentLoaded', function() {
    loadCartFromStorage();
    updateCartDisplay();
    updateCartCount();
    toggleCartVisibility();
    bindEventListeners();
    
    // Animate cart items if there are any
    if (cartItems.length > 0) {
        setTimeout(animateCartItems, 100);
    }
});

// Listen for cart updates from global cart system
window.addEventListener('storage', function(e) {
    if (e.key === 'orebiCart') {
        loadCartFromStorage();
        updateCartDisplay();
        updateCartCount();
        toggleCartVisibility();
        
        // Animate new items
        if (cartItems.length > 0) {
            setTimeout(animateCartItems, 100);
        }
    }
});

// Check for cart updates when page gains focus
window.addEventListener('focus', function() {
    loadCartFromStorage();
    updateCartDisplay();
    updateCartCount();
    toggleCartVisibility();
});
