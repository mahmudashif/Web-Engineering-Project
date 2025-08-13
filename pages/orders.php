<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Orebi</title>
    <base href="../">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="components/navbar/navbar.css">
    <link rel="stylesheet" href="components/footer/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="components/components.js"></script>
    <style>
        /* My Orders Page Styles */
        .orders-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0 40px;
            position: relative;
            overflow: hidden;
        }
        
        .orders-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><radialGradient id="orders-hero" cx="50%" cy="0%" r="100%"><stop offset="0%" stop-color="rgba(255,255,255,0.1)"/><stop offset="100%" stop-color="rgba(255,255,255,0)"/></radialGradient></defs><rect width="100" height="20" fill="url(%23orders-hero)"/></svg>');
            opacity: 0.3;
        }
        
        .orders-hero-content {
            text-align: center;
            position: relative;
            z-index: 2;
        }
        
        .orders-hero-content h1 {
            font-size: 32px;
            font-weight: 600;
            color: white;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .orders-hero-content p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 20px;
            font-weight: 400;
        }
        
        .breadcrumb {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }
        
        .breadcrumb a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            color: white;
        }
        
        /* Orders Section */
        .orders-section {
            padding: 60px 0;
            background: #f8fafc;
            min-height: 60vh;
        }
        
        .orders-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-header h2 {
            font-size: 28px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 12px;
        }
        
        .section-header p {
            font-size: 16px;
            color: #718096;
            max-width: 500px;
            margin: 0 auto;
        }
        
        /* Order Cards */
        .orders-grid {
            display: grid;
            gap: 24px;
        }
        
        .order-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 24px;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }
        
        .order-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .order-info h3 {
            font-size: 20px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
        }
        
        .order-date {
            font-size: 14px;
            color: #718096;
        }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: white;
            letter-spacing: 0.5px;
        }
        
        .order-details {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 20px;
        }
        
        .order-items-preview {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .order-item-preview {
            display: grid;
            grid-template-columns: 60px 1fr auto;
            gap: 12px;
            align-items: center;
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
        }
        
        .order-item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        
        .order-item-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        
        .order-item-brand {
            font-size: 11px;
            font-weight: 600;
            color: #6D28D9;
            text-transform: uppercase;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
        }
        
        .order-item-name {
            font-size: 14px;
            font-weight: 500;
            color: #2d3748;
            margin-bottom: 2px;
        }
        
        .order-item-quantity {
            font-size: 12px;
            color: #718096;
        }
        
        .order-item-price {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
        }
        
        .order-summary-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
        }
        
        .order-total {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
        }
        
        .payment-method {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
        }
        
        .order-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
        }
        
        .btn-order-action {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-view-details {
            background: #e2e8f0;
            color: #4a5568;
        }
        
        .btn-view-details:hover {
            background: #cbd5e0;
        }
        
        .btn-track-order {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-track-order:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        /* Loading and Empty States */
        .loading-orders {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 60px 20px;
            color: #718096;
        }
        
        .spinner-small {
            width: 20px;
            height: 20px;
            border: 2px solid #e2e8f0;
            border-top: 2px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .no-orders {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 12px;
            color: #718096;
        }
        
        .no-orders-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .no-orders h3 {
            font-size: 24px;
            margin-bottom: 12px;
            color: #4a5568;
        }
        
        .no-orders p {
            margin-bottom: 24px;
            font-size: 16px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .orders-hero-content h1 {
                font-size: 24px;
            }
            
            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .order-details {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .order-summary-info {
                align-items: flex-start;
            }
            
            .order-actions {
                justify-content: flex-start;
            }
            
            .section-header h2 {
                font-size: 20px;
            }
            
            .order-item-preview {
                grid-template-columns: 50px 1fr auto;
            }
            
            .order-item-image {
                width: 50px;
                height: 50px;
            }
        }
        
        /* Not logged in state */
        .not-logged-in {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 12px;
            color: #718096;
        }
        
        .not-logged-in-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .not-logged-in h3 {
            font-size: 24px;
            margin-bottom: 12px;
            color: #4a5568;
        }
        
        .not-logged-in p {
            margin-bottom: 24px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <!-- Navbar Placeholder -->
    <div id="navbar-placeholder"></div>

    <!-- Orders Main Content -->
    <main class="orders-main">
        <!-- Hero Section -->
        <section class="orders-hero">
            <div class="container">
                <div class="orders-hero-content">
                    <h1>My Orders</h1>
                    <p>Track your orders and view purchase history</p>
                    <div class="breadcrumb">
                        <a href="index.php">Home</a> / <span>My Orders</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Orders Section -->
        <section class="orders-section">
            <div class="orders-container">
                <div class="section-header">
                    <h2>Order History</h2>
                    <p>View details and track the status of your recent orders</p>
                </div>

                <div class="orders-grid" id="orders-grid">
                    <!-- Orders will be loaded here -->
                    <div class="loading-orders">
                        <div class="spinner-small"></div>
                        <span>Loading your orders...</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Placeholder -->
    <div id="footer-placeholder"></div>

    <!-- JavaScript -->
    <script src="assets/js/user-auth.js"></script>
    <script>
        // Initialize page and load orders
        document.addEventListener('DOMContentLoaded', async function() {
            // Check if user is logged in
            const userAuth = new UserAuth();
            const user = await checkUserAuth();
            
            if (user) {
                loadUserOrders();
            } else {
                showNotLoggedInState();
            }
        });

        // Check user authentication
        async function checkUserAuth() {
            try {
                const response = await fetch('api/check-auth.php');
                const data = await response.json();
                
                if (data.success && data.user) {
                    return data.user;
                } else {
                    return null;
                }
            } catch (error) {
                console.error('Error checking authentication:', error);
                return null;
            }
        }

        // Load user orders
        async function loadUserOrders() {
            try {
                const response = await fetch('api/get-orders.php');
                const data = await response.json();
                
                if (data.success) {
                    renderOrders(data.data);
                } else {
                    console.log('No orders found:', data.message);
                    renderNoOrders();
                }
            } catch (error) {
                console.error('Error loading orders:', error);
                renderNoOrders();
            }
        }

        // Render orders
        function renderOrders(orders) {
            const container = document.getElementById('orders-grid');
            
            if (orders.length === 0) {
                renderNoOrders();
                return;
            }
            
            let ordersHtml = '';
            
            orders.forEach(order => {
                const itemsPreviewHtml = order.items.slice(0, 3).map(item => `
                    <div class="order-item-preview">
                        <img src="${item.image_url}" alt="${escapeHtml(item.product_name)}" 
                             class="order-item-image" onerror="this.src='assets/images/placeholder-product.svg'">
                        <div class="order-item-details">
                            <div class="order-item-brand">${escapeHtml(item.product_brand || 'Unknown Brand')}</div>
                            <div class="order-item-name">${escapeHtml(item.product_name)}</div>
                            <div class="order-item-quantity">Qty: ${item.quantity}</div>
                        </div>
                        <div class="order-item-price">$${item.item_total.toFixed(2)}</div>
                    </div>
                `).join('');
                
                const moreItemsText = order.items.length > 3 ? 
                    `<p style="text-align: center; color: #718096; font-size: 0.9rem; margin-top: 12px; font-style: italic;">
                        +${order.items.length - 3} more ${order.items.length - 3 === 1 ? 'item' : 'items'}
                    </p>` : '';
                
                ordersHtml += `
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-info">
                                <h3>Order #${order.order_id}</h3>
                                <div class="order-date">${order.formatted_date}</div>
                            </div>
                            <div class="order-status">
                                <span class="status-badge" style="background-color: ${order.status_color}">
                                    ${order.status_label}
                                </span>
                            </div>
                        </div>
                        
                        <div class="order-details">
                            <div class="order-items-preview">
                                ${itemsPreviewHtml}
                                ${moreItemsText}
                            </div>
                            
                            <div class="order-summary-info">
                                <div class="order-total">$${order.total_amount.toFixed(2)}</div>
                                <div class="payment-method">${order.payment_method.toUpperCase()}</div>
                                <div style="font-size: 0.85rem; color: #718096; text-align: right; margin-top: 8px;">
                                    ${order.total_items} item${order.total_items > 1 ? 's' : ''}
                                </div>
                            </div>
                        </div>
                        
                        <div class="order-actions">
                            <button class="btn-order-action btn-view-details" onclick="viewOrderDetails(${order.order_id})">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                View Details
                            </button>
                            ${order.status !== 'delivered' && order.status !== 'completed' && order.status !== 'cancelled' ? `
                                <button class="btn-order-action btn-track-order" onclick="trackOrder(${order.order_id})">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12,6 12,12 16,14"/>
                                    </svg>
                                    Track Order
                                </button>
                            ` : ''}
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = ordersHtml;
        }

        // Render no orders state
        function renderNoOrders() {
            const container = document.getElementById('orders-grid');
            container.innerHTML = `
                <div class="no-orders">
                    <div class="no-orders-icon">📦</div>
                    <h3>No Orders Found</h3>
                    <p>You haven't placed any orders yet. Start shopping to see your order history here.</p>
                    <a href="pages/shop.php" class="btn-primary">Start Shopping</a>
                </div>
            `;
        }

        // Show not logged in state
        function showNotLoggedInState() {
            const container = document.getElementById('orders-grid');
            container.innerHTML = `
                <div class="not-logged-in">
                    <div class="not-logged-in-icon">🔒</div>
                    <h3>Please Log In</h3>
                    <p>You need to be logged in to view your order history.</p>
                    <a href="pages/auth/login.php" class="btn-primary">Sign In</a>
                </div>
            `;
        }

        // View order details (placeholder function)
        function viewOrderDetails(orderId) {
            showNotification(`Viewing details for order #${orderId}`, 'info');
        }

        // Track order (placeholder function)  
        function trackOrder(orderId) {
            showNotification(`Tracking order #${orderId}`, 'info');
        }

        // Show notification
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
    </script>
</body>
</html>
