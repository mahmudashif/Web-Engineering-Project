<?php
require_once '../../includes/admin-auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders | Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/admin-dashboard.css">
    <style>
        .orders-management {
            padding: 0;
        }
        
        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 20px;
            padding: 0 20px;
        }
        
        .orders-header h3 {
            margin: 0;
            color: #333;
            font-size: 22px;
        }
        
        .orders-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin: 0 20px 25px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:nth-child(2) {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
        }
        
        .stat-card:nth-child(3) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
        }
        
        .stat-card:nth-child(4) {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            box-shadow: 0 4px 15px rgba(67, 233, 123, 0.3);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .stat-number {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .orders-filters {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin: 0 20px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #667eea;
        }
        
        .filters-row {
            display: flex;
            gap: 15px;
            align-items: end;
            flex-wrap: wrap;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .filter-group label {
            font-size: 0.9rem;
            color: #555;
            font-weight: 500;
        }
        
        .filter-input {
            padding: 10px 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .filter-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .orders-list {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin: 0 20px;
        }
        
        .order-card {
            border-bottom: 1px solid #eee;
            padding: 25px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .order-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .order-card:hover {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
        }
        
        .order-card:hover::before {
            opacity: 1;
        }
        
        .order-card:last-child {
            border-bottom: none;
        }
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .order-info {
            flex: 1;
        }
        
        .order-id {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }
        
        .order-meta {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .customer-info {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        
        .customer-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 1rem;
        }
        
        .customer-details {
            font-size: 0.9rem;
            color: #555;
            line-height: 1.5;
        }
        
        .order-status {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #fff;
            text-transform: capitalize;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .status-select {
            padding: 8px 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
            background: white;
            transition: all 0.3s ease;
        }
        
        .status-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .order-amount {
            font-size: 1.4rem;
            font-weight: bold;
            color: #667eea;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        .order-items {
            margin-top: 20px;
        }
        
        .items-header {
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .items-header:hover {
            background: linear-gradient(135deg, #e6ecff 0%, #dde6ff 100%);
        }
        
        .items-toggle {
            font-size: 0.8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 6px 12px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .items-toggle:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }
        
        .items-list {
            display: none;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            border-radius: 10px;
            padding: 20px;
            margin-top: 15px;
            border-left: 4px solid #667eea;
        }
        
        .items-list.show {
            display: block;
        }
        
        .order-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
        
        .item-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            background: #f0f0f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 1rem;
        }
        
        .item-brand {
            color: #667eea;
            font-size: 0.9rem;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .item-price {
            color: #4caf50;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .empty-state {
            text-align: center;
            padding: 60px;
            color: #666;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #667eea;
        }
        
        .empty-state h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        @media (max-width: 768px) {
            .orders-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filters-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .order-header {
                flex-direction: column;
            }
            
            .order-item {
                flex-direction: column;
                align-items: flex-start;
                text-align: center;
            }
            
            .item-image {
                align-self: center;
            }
            
            .orders-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .stat-card {
                padding: 15px;
            }
            
            .stat-number {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 576px) {
            .orders-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Admin header with logo -->
    <div class="admin-top-header">
        <div class="admin-logo">
            <a href="../../index.php">Orebi</a>
        </div>
        <div class="admin-title">Admin Dashboard</div>
    </div>

    <div class="admin-dashboard-container">
        <div class="admin-sidebar">
            <h3>Admin Panel</h3>
            <ul class="admin-menu">
                <li><a href="dashboard.php"><span class="icon">📊</span> Dashboard</a></li>
                <li><a href="users.php"><span class="icon">👥</span> Users</a></li>
                <li><a href="products.php"><span class="icon">🛒</span> Products</a></li>
                <li class="active"><a href="orders.php"><span class="icon">📦</span> Orders</a></li>
                <li><a href="settings.php"><span class="icon">⚙️</span> Settings</a></li>
                <li class="home-link"><a href="../../index.php"><span class="icon">🏠</span> Back to Website</a></li>
            </ul>
        </div>
        
        <div class="admin-content">
            <div class="admin-header">
                <h2>Manage Orders</h2>
                <div class="admin-user">
                    <div class="admin-user-info">
                        <span id="admin-name">Admin</span>
                        <span id="admin-role">Administrator</span>
                    </div>
                    <div class="admin-profile-pic" id="admin-profile-pic">
                        <img src="" alt="Admin" id="admin-image" style="display:none;">
                        <div class="admin-initials" id="admin-initials">A</div>
                    </div>
                </div>
            </div>
            
            <div class="admin-card orders-management">
                <!-- Orders Statistics -->
                <div class="orders-stats">
                    <div class="stat-card">
                        <div class="stat-number" id="totalOrders">-</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="pendingOrders">-</div>
                        <div class="stat-label">Pending Orders</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="processingOrders">-</div>
                        <div class="stat-label">Processing</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="completedOrders">-</div>
                        <div class="stat-label">Completed</div>
                    </div>
                </div>
                
                <!-- Filters -->
                <div class="orders-filters">
                    <div class="filters-row">
                        <div class="filter-group">
                            <label>Status</label>
                            <select class="filter-input" id="statusFilter">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Search Orders</label>
                            <input type="text" class="filter-input" id="searchFilter" placeholder="Order ID, customer name, email...">
                        </div>
                        <div class="filter-group">
                            <label>Date From</label>
                            <input type="date" class="filter-input" id="dateFromFilter">
                        </div>
                        <div class="filter-group">
                            <label>Date To</label>
                            <input type="date" class="filter-input" id="dateToFilter">
                        </div>
                        <div class="filter-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
                        </div>
                    </div>
                </div>
                
                <!-- Orders List -->
                <div class="orders-list" id="ordersList">
                    <div class="loading-spinner">
                        <div class="spinner"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include footer -->
    <div id="footer-container"></div>

    <!-- Scripts -->
    <script src="../../assets/js/admin-components.js"></script>
    
    <script src="../../assets/js/user-auth.js"></script>
    <script>
        let allOrders = [];
        let filteredOrders = [];
        
        // Load orders on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadAdminInfo();
            loadOrders();
            setupFilters();
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
        
        async function loadOrders() {
            try {
                const response = await fetch('../../api/admin/get-all-orders.php');
                const result = await response.json();
                
                if (result.success) {
                    allOrders = result.data;
                    filteredOrders = [...allOrders];
                    updateStats();
                    displayOrders();
                } else {
                    showError('Error loading orders: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Failed to load orders');
            }
        }
        
        function updateStats() {
            const stats = {
                total: allOrders.length,
                pending: allOrders.filter(o => o.status === 'pending').length,
                processing: allOrders.filter(o => o.status === 'processing').length,
                completed: allOrders.filter(o => ['delivered', 'completed'].includes(o.status)).length
            };
            
            document.getElementById('totalOrders').textContent = stats.total;
            document.getElementById('pendingOrders').textContent = stats.pending;
            document.getElementById('processingOrders').textContent = stats.processing;
            document.getElementById('completedOrders').textContent = stats.completed;
        }
        
        function displayOrders() {
            const container = document.getElementById('ordersList');
            
            if (filteredOrders.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>No orders found</h3>
                        <p>No orders match your current filters.</p>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = filteredOrders.map(order => `
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <div class="order-id">Order #${order.order_id}</div>
                            <div class="order-meta">
                                Placed on ${order.formatted_date} • ${order.total_items} items • ${order.total_quantity} products
                            </div>
                            ${order.payment_method ? `<div class="order-meta">Payment: ${order.payment_method.toUpperCase()}</div>` : ''}
                        </div>
                        <div class="order-status">
                            <div class="order-amount">$${order.total_amount.toFixed(2)}</div>
                            <span class="status-badge" style="background-color: ${order.status_color}">
                                ${order.status_label}
                            </span>
                            <select class="status-select" onchange="updateOrderStatus(${order.order_id}, this.value)">
                                <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="processing" ${order.status === 'processing' ? 'selected' : ''}>Processing</option>
                                <option value="shipped" ${order.status === 'shipped' ? 'selected' : ''}>Shipped</option>
                                <option value="delivered" ${order.status === 'delivered' ? 'selected' : ''}>Delivered</option>
                                <option value="completed" ${order.status === 'completed' ? 'selected' : ''}>Completed</option>
                                <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="customer-info">
                        <div class="customer-name">${order.customer_name}</div>
                        <div class="customer-details">
                            ${order.customer_email} ${order.customer_phone ? '• ' + order.customer_phone : ''}
                            ${order.user_full_name && order.user_full_name !== order.customer_name ? `<br>User Account: ${order.user_full_name} (${order.user_email})` : ''}
                        </div>
                        ${order.shipping_address ? `<div class="customer-details"><strong>Address:</strong> ${order.shipping_address}</div>` : ''}
                        ${order.order_notes ? `<div class="customer-details"><strong>Notes:</strong> ${order.order_notes}</div>` : ''}
                    </div>
                    
                    <div class="order-items">
                        <div class="items-header" onclick="toggleOrderItems(${order.order_id})">
                            <span>Order Items (${order.items.length})</span>
                            <button class="items-toggle">Show Details</button>
                        </div>
                        <div class="items-list" id="items-${order.order_id}">
                            ${order.items.map(item => `
                                <div class="order-item">
                                    <img src="${item.image_url}" alt="${item.product_name}" class="item-image" onerror="this.src='../../assets/images/placeholder-product.svg'">
                                    <div class="item-details">
                                        <div class="item-name">${item.product_name}</div>
                                        ${item.product_brand ? `<div class="item-brand">${item.product_brand}</div>` : ''}
                                        <div class="item-price">
                                            $${item.price.toFixed(2)} × ${item.quantity} = $${item.item_total.toFixed(2)}
                                        </div>
                                        ${item.current_product_price && item.current_product_price !== item.price ? 
                                            `<div style="color: #999; font-size: 0.8rem;">Current price: $${item.current_product_price.toFixed(2)}</div>` : ''}
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `).join('');
        }
        
        function toggleOrderItems(orderId) {
            const itemsList = document.getElementById(`items-${orderId}`);
            const button = itemsList.previousElementSibling.querySelector('.items-toggle');
            
            if (itemsList.classList.contains('show')) {
                itemsList.classList.remove('show');
                button.textContent = 'Show Details';
            } else {
                itemsList.classList.add('show');
                button.textContent = 'Hide Details';
            }
        }
        
        async function updateOrderStatus(orderId, newStatus) {
            try {
                const response = await fetch('../../api/admin/update-order-status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        order_id: orderId,
                        status: newStatus
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Update local data
                    const orderIndex = allOrders.findIndex(o => o.order_id === orderId);
                    if (orderIndex !== -1) {
                        allOrders[orderIndex].status = newStatus;
                        
                        // Update status label and color
                        const statusLabels = {
                            'pending': 'Order Placed',
                            'processing': 'Processing',
                            'shipped': 'Shipped',
                            'delivered': 'Delivered',
                            'completed': 'Completed',
                            'cancelled': 'Cancelled'
                        };
                        
                        const statusColors = {
                            'pending': '#fbbf24',
                            'processing': '#3b82f6',
                            'shipped': '#8b5cf6',
                            'delivered': '#10b981',
                            'completed': '#059669',
                            'cancelled': '#ef4444'
                        };
                        
                        allOrders[orderIndex].status_label = statusLabels[newStatus] || newStatus;
                        allOrders[orderIndex].status_color = statusColors[newStatus] || '#6b7280';
                    }
                    
                    // Refresh display
                    applyFilters();
                    updateStats();
                    
                    showSuccess('Order status updated successfully');
                } else {
                    showError('Error updating order status: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Failed to update order status');
            }
        }
        
        function setupFilters() {
            const statusFilter = document.getElementById('statusFilter');
            const searchFilter = document.getElementById('searchFilter');
            const dateFromFilter = document.getElementById('dateFromFilter');
            const dateToFilter = document.getElementById('dateToFilter');
            
            statusFilter.addEventListener('change', applyFilters);
            searchFilter.addEventListener('input', debounce(applyFilters, 300));
            dateFromFilter.addEventListener('change', applyFilters);
            dateToFilter.addEventListener('change', applyFilters);
        }
        
        function applyFilters() {
            const status = document.getElementById('statusFilter').value;
            const search = document.getElementById('searchFilter').value.toLowerCase();
            const dateFrom = document.getElementById('dateFromFilter').value;
            const dateTo = document.getElementById('dateToFilter').value;
            
            filteredOrders = allOrders.filter(order => {
                // Status filter
                if (status && order.status !== status) {
                    return false;
                }
                
                // Search filter
                if (search) {
                    const searchableText = `
                        ${order.order_id}
                        ${order.customer_name}
                        ${order.customer_email}
                        ${order.user_full_name || ''}
                        ${order.user_email || ''}
                    `.toLowerCase();
                    
                    if (!searchableText.includes(search)) {
                        return false;
                    }
                }
                
                // Date filters
                const orderDate = new Date(order.created_at).toISOString().split('T')[0];
                if (dateFrom && orderDate < dateFrom) {
                    return false;
                }
                if (dateTo && orderDate > dateTo) {
                    return false;
                }
                
                return true;
            });
            
            displayOrders();
        }
        
        function clearFilters() {
            document.getElementById('statusFilter').value = '';
            document.getElementById('searchFilter').value = '';
            document.getElementById('dateFromFilter').value = '';
            document.getElementById('dateToFilter').value = '';
            
            filteredOrders = [...allOrders];
            displayOrders();
        }
        
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
        
        function showSuccess(message) {
            // You can implement a toast notification system here
            alert(message);
        }
        
        function showError(message) {
            // You can implement a toast notification system here
            alert(message);
        }
    </script>
</body>
</html>
