<?php
// Include admin authentication middleware
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
        /* Orders specific styles */
        .orders-management {
            padding: 0;
            margin-bottom: 20px;
        }
        
        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .orders-header h3 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }
        
        .orders-filters {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .filter-select, .filter-input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
        }
        
        .filter-select:focus, .filter-input:focus {
            border-color: #667eea;
        }
        
        .orders-table-container {
            overflow-x: auto;
        }
        
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: #777;
        }
        
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        
        .orders-table th,
        .orders-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .orders-table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
            position: sticky;
            top: 0;
        }
        
        .orders-table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .order-id {
            font-weight: 600;
            color: #333;
        }
        
        .customer-name {
            font-weight: 500;
            color: #333;
        }
        
        .order-amount {
            font-weight: 600;
            color: #2196f3;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
            color: white;
            text-transform: capitalize;
        }
        
        .status-pending { background-color: #fbbf24; }
        .status-processing { background-color: #3b82f6; }
        .status-shipped { background-color: #8b5cf6; }
        .status-delivered { background-color: #10b981; }
        .status-completed { background-color: #059669; }
        .status-cancelled { background-color: #ef4444; }
        
        .status-select {
            padding: 4px 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 12px;
            margin-left: 8px;
        }
        
        .order-date {
            color: #666;
            font-size: 13px;
        }
        
        .order-items-btn {
            background: #f0f0f0;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.2s;
        }
        
        .order-items-btn:hover {
            background: #e0e0e0;
        }
        
        .order-details {
            display: none;
            background: #f8f9fa;
            padding: 15px;
            border-top: 1px solid #eee;
        }
        
        .order-details.show {
            display: block;
        }
        
        .order-items-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        
        .order-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
        
        .item-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            background: #f0f0f0;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-name {
            font-weight: 500;
            color: #333;
            margin: 0 0 4px 0;
            font-size: 13px;
        }
        
        .item-info {
            color: #666;
            font-size: 12px;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        
        .empty-state h4 {
            margin-bottom: 10px;
            color: #333;
        }
        
        @media (max-width: 768px) {
            .orders-header {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }
            
            .orders-filters {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            
            .orders-table {
                min-width: 800px;
            }
        }
    </style>
</head>
<body>
    <!-- Admin header with logo -->
    <div class="admin-top-header">
        <div class="admin-logo">
            <a href="../../index.php">
                <img src="https://i.ibb.co.com/pjYGFbKr/logo.png" id="admin-logo" alt="Gadget Shop" style="height:72px; display:inline-block; vertical-align:middle;">
            </a>
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

            <!-- Orders Statistics -->
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon orders-icon">📦</div>
                    <div class="stat-details">
                        <h3>Total Orders</h3>
                        <p class="stat-number" id="totalOrders">0</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon orders-icon">⏳</div>
                    <div class="stat-details">
                        <h3>Pending</h3>
                        <p class="stat-number" id="pendingOrders">0</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon orders-icon">🔄</div>
                    <div class="stat-details">
                        <h3>Processing</h3>
                        <p class="stat-number" id="processingOrders">0</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon orders-icon">✅</div>
                    <div class="stat-details">
                        <h3>Completed</h3>
                        <p class="stat-number" id="completedOrders">0</p>
                    </div>
                </div>
            </div>

            <!-- Orders Management -->
            <div class="admin-card orders-management">
                <div class="orders-header">
                    <h3>All Orders</h3>
                    <div class="orders-filters">
                        <select id="statusFilter" class="filter-select">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <input type="text" id="searchFilter" class="filter-input" placeholder="Search orders...">
                        <button type="button" class="search-btn" onclick="clearFilters()">Clear</button>
                    </div>
                </div>

                <div class="orders-table-container">
                    <div id="ordersList" class="loading-message">
                        <div class="loading-spinner">Loading orders...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include footer -->
    <div id="footer-container"></div>
    
    <script src="../../assets/js/admin-components.js"></script>
    <script src="../../assets/js/user-auth.js"></script>
    <script>
        let allOrders = [];
        let filteredOrders = [];
        
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
                        <h4>No orders found</h4>
                        <p>No orders match your current filters.</p>
                    </div>
                `;
                return;
            }
            
            let tableHTML = `
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            filteredOrders.forEach(order => {
                tableHTML += `
                    <tr>
                        <td class="order-id">#${order.order_id}</td>
                        <td>
                            <div class="customer-name">${order.customer_name}</div>
                            <div style="font-size: 12px; color: #666;">${order.customer_email}</div>
                        </td>
                        <td class="order-amount">$${order.total_amount.toFixed(2)}</td>
                        <td>
                            <span class="status-badge status-${order.status}">${order.status_label}</span>
                            <select class="status-select" onchange="updateOrderStatus(${order.order_id}, this.value)">
                                <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="processing" ${order.status === 'processing' ? 'selected' : ''}>Processing</option>
                                <option value="shipped" ${order.status === 'shipped' ? 'selected' : ''}>Shipped</option>
                                <option value="delivered" ${order.status === 'delivered' ? 'selected' : ''}>Delivered</option>
                                <option value="completed" ${order.status === 'completed' ? 'selected' : ''}>Completed</option>
                                <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                            </select>
                        </td>
                        <td class="order-date">${order.formatted_date}</td>
                        <td>
                            <button class="order-items-btn" onclick="toggleOrderDetails(${order.order_id})">
                                View Items (${order.items.length})
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <div class="order-details" id="order-details-${order.order_id}">
                                <h4>Order Items:</h4>
                                <ul class="order-items-list">
                                    ${order.items.map(item => `
                                        <li class="order-item">
                                            <img src="${item.image_url}" alt="${item.product_name}" class="item-image" 
                                                 onerror="this.src='../../assets/images/placeholder-product.svg'">
                                            <div class="item-details">
                                                <div class="item-name">${item.product_name}</div>
                                                <div class="item-info">
                                                    ${item.product_brand ? item.product_brand + ' • ' : ''}
                                                    Qty: ${item.quantity} × $${item.price.toFixed(2)} = $${item.item_total.toFixed(2)}
                                                </div>
                                            </div>
                                        </li>
                                    `).join('')}
                                </ul>
                                <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee;">
                                    <strong>Customer Details:</strong><br>
                                    ${order.customer_phone ? 'Phone: ' + order.customer_phone + '<br>' : ''}
                                    ${order.shipping_address ? 'Address: ' + order.shipping_address + '<br>' : ''}
                                    ${order.order_notes ? 'Notes: ' + order.order_notes : ''}
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            tableHTML += `
                    </tbody>
                </table>
            `;
            
            container.innerHTML = tableHTML;
        }
        
        function toggleOrderDetails(orderId) {
            const detailsElement = document.getElementById(`order-details-${orderId}`);
            if (detailsElement.classList.contains('show')) {
                detailsElement.classList.remove('show');
            } else {
                detailsElement.classList.add('show');
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
                        
                        allOrders[orderIndex].status_label = statusLabels[newStatus] || newStatus;
                    }
                    
                    // Refresh display
                    applyFilters();
                    updateStats();
                    
                    // Show success message (you can implement a proper toast notification)
                    console.log('Order status updated successfully');
                } else {
                    alert('Error updating order status: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Failed to update order status');
            }
        }
        
        function setupFilters() {
            const statusFilter = document.getElementById('statusFilter');
            const searchFilter = document.getElementById('searchFilter');
            
            statusFilter.addEventListener('change', applyFilters);
            searchFilter.addEventListener('input', debounce(applyFilters, 300));
        }
        
        function applyFilters() {
            const status = document.getElementById('statusFilter').value;
            const search = document.getElementById('searchFilter').value.toLowerCase();
            
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
                
                return true;
            });
            
            displayOrders();
        }
        
        function clearFilters() {
            document.getElementById('statusFilter').value = '';
            document.getElementById('searchFilter').value = '';
            
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
        
        function showError(message) {
            console.error(message);
            document.getElementById('ordersList').innerHTML = `
                <div class="empty-state">
                    <h4>Error Loading Orders</h4>
                    <p>${message}</p>
                </div>
            `;
        }
    </script>
</body>
</html>
