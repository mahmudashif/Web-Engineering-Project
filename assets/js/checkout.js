// Checkout JavaScript
class CheckoutManager {
    constructor() {
        this.cartItems = [];
        this.userInfo = null;
        this.init();
    }

    async init() {
        await this.loadCartItems();
        await this.loadUserInfo();
        this.renderOrderSummary();
        this.bindEvents();
        this.populateUserInfo();
    }

    // Load cart items from API
    async loadCartItems() {
        try {
            const response = await fetch('../api/get-cart.php');
            const data = await response.json();
            
            if (data.success) {
                this.cartItems = data.data;
            } else {
                console.error('Failed to load cart items:', data.message);
                this.showError('Failed to load cart items');
            }
        } catch (error) {
            console.error('Error loading cart items:', error);
            this.showError('Failed to load cart items');
        }
    }

    // Load user information
    async loadUserInfo() {
        try {
            const response = await fetch('../api/profile.php');
            const data = await response.json();
            
            if (data.success) {
                this.userInfo = data.data;
            }
        } catch (error) {
            console.error('Error loading user info:', error);
        }
    }

    // Populate user information in form
    populateUserInfo() {
        if (!this.userInfo) return;

        // Split full name into first and last name
        const nameParts = (this.userInfo.full_name || '').split(' ');
        const firstName = nameParts[0] || '';
        const lastName = nameParts.slice(1).join(' ') || '';

        // Populate form fields
        document.getElementById('firstName').value = firstName;
        document.getElementById('lastName').value = lastName;
        document.getElementById('email').value = this.userInfo.email || '';
        document.getElementById('phone').value = this.userInfo.phone || '';
        document.getElementById('address').value = this.userInfo.address || '';
        document.getElementById('city').value = this.userInfo.city || '';
        document.getElementById('postalCode').value = this.userInfo.postal_code || '';
    }

    // Render order summary
    renderOrderSummary() {
        const itemsContainer = document.getElementById('checkout-items');
        
        if (this.cartItems.length === 0) {
            itemsContainer.innerHTML = '<p class="empty-cart-message">Your cart is empty</p>';
            document.getElementById('place-order-btn').disabled = true;
            return;
        }

        let itemsHtml = '';
        let subtotal = 0;

        this.cartItems.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            itemsHtml += `
                <div class="order-item">
                    <img src="${item.image_url}" alt="${item.name}" class="item-image" 
                         onerror="this.src='../assets/images/placeholder-product.svg'">
                    <div class="item-details">
                        <div class="item-name">${this.escapeHtml(item.name)}</div>
                        <div class="item-quantity">Qty: ${item.quantity}</div>
                    </div>
                    <div class="item-price">$${itemTotal.toFixed(2)}</div>
                </div>
            `;
        });

        itemsContainer.innerHTML = itemsHtml;

        // Calculate totals
        const tax = subtotal * 0.08; // 8% tax
        const total = subtotal + tax;

        // Update summary
        document.getElementById('checkout-subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('checkout-tax').textContent = `$${tax.toFixed(2)}`;
        document.getElementById('checkout-total').textContent = `$${total.toFixed(2)}`;
    }

    // Bind events
    bindEvents() {
        const placeOrderBtn = document.getElementById('place-order-btn');
        placeOrderBtn.addEventListener('click', () => this.placeOrder());

        // Form validation
        const form = document.getElementById('checkout-form');
        const inputs = form.querySelectorAll('input[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });
    }

    // Validate form field
    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let message = '';

        if (!value) {
            isValid = false;
            message = 'This field is required';
        } else {
            // Specific validations
            switch (field.type) {
                case 'email':
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        isValid = false;
                        message = 'Please enter a valid email address';
                    }
                    break;
                case 'tel':
                    const phoneRegex = /^[\d\s\-\+\(\)]+$/;
                    if (!phoneRegex.test(value) || value.length < 10) {
                        isValid = false;
                        message = 'Please enter a valid phone number';
                    }
                    break;
            }
        }

        if (!isValid) {
            this.showFieldError(field, message);
        } else {
            this.clearFieldError(field);
        }

        return isValid;
    }

    // Show field error
    showFieldError(field, message) {
        this.clearFieldError(field);
        field.style.borderColor = '#e53e3e';
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.cssText = 'color: #e53e3e; font-size: 0.8rem; margin-top: 4px;';
        errorDiv.textContent = message;
        
        field.parentNode.appendChild(errorDiv);
    }

    // Clear field error
    clearFieldError(field) {
        field.style.borderColor = '#e2e8f0';
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
    }

    // Validate entire form
    validateForm() {
        const form = document.getElementById('checkout-form');
        const requiredInputs = form.querySelectorAll('input[required]');
        let isValid = true;

        requiredInputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    // Place order
    async placeOrder() {
        // Validate form
        if (!this.validateForm()) {
            this.showError('Please fill in all required fields correctly');
            return;
        }

        // Check if cart is empty
        if (this.cartItems.length === 0) {
            this.showError('Your cart is empty');
            return;
        }

        // Show loading
        this.showLoading(true);

        try {
            // Collect form data
            const formData = this.collectFormData();
            
            // Submit order
            const response = await fetch('../api/place-order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (data.success) {
                // Show success modal
                this.showOrderSuccess(data.data);
                
                // Clear cart
                if (window.GlobalCart) {
                    await window.GlobalCart.loadFromAPI();
                }
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error placing order:', error);
            this.showError('Failed to place order: ' + error.message);
        } finally {
            this.showLoading(false);
        }
    }

    // Collect form data
    collectFormData() {
        const form = document.getElementById('checkout-form');
        const formData = new FormData(form);
        
        const data = {
            billing: {},
            payment: {},
            items: this.cartItems.map(item => ({
                product_id: item.product_id,
                quantity: item.quantity,
                price: item.price
            }))
        };

        // Collect billing information
        data.billing.firstName = formData.get('firstName');
        data.billing.lastName = formData.get('lastName');
        data.billing.email = formData.get('email');
        data.billing.phone = formData.get('phone');
        data.billing.address = formData.get('address');
        data.billing.city = formData.get('city');
        data.billing.postalCode = formData.get('postalCode');
        data.billing.orderNotes = formData.get('orderNotes') || '';

        // Collect payment method
        data.payment.method = formData.get('paymentMethod');

        // Calculate totals
        const subtotal = this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const tax = subtotal * 0.08;
        const total = subtotal + tax;

        data.totals = {
            subtotal: subtotal,
            tax: tax,
            total: total
        };

        return data;
    }

    // Show order success modal
    showOrderSuccess(orderData) {
        document.getElementById('order-id-display').textContent = `#${orderData.order_id}`;
        document.getElementById('order-total-display').textContent = `$${orderData.total.toFixed(2)}`;
        
        const modal = document.getElementById('order-success-modal');
        modal.style.display = 'block';

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }

    // Show loading overlay
    showLoading(show) {
        const overlay = document.getElementById('loading-overlay');
        overlay.style.display = show ? 'flex' : 'none';
    }

    // Show error notification
    showError(message) {
        // Create notification
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
            z-index: 10000;
            font-weight: 500;
            max-width: 400px;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        notification.textContent = message;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        // Remove after 5 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }

    // Escape HTML
    escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
}

// Initialize checkout when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new CheckoutManager();
});
