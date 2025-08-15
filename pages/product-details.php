<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Gadget Shop</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=2">
    <link rel="stylesheet" href="../assets/css/shop.css?v=2">
    <style>
        /* Product Details Page Styles */
        .product-details-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            background: white;
        }

        .breadcrumb {
            margin-bottom: 30px;
            color: #666;
            font-size: 14px;
        }

        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .product-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 60px;
        }

        .product-image-section {
            position: relative;
        }

        .product-main-image {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 12px;
            overflow: hidden;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .product-main-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-placeholder {
            font-size: 48px;
            color: #ccc;
        }

        .product-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 16px;
            border-radius: 20px;
            color: white;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-in-stock {
            background: #10b981;
        }

        .badge-low-stock {
            background: #f59e0b;
        }

        .badge-out-of-stock {
            background: #ef4444;
        }

        .product-info-section h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 8px;
        }

        .product-brand {
            font-size: 16px;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .product-price {
            font-size: 36px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
        }

        .product-description {
            font-size: 16px;
            line-height: 1.6;
            color: #4a5568;
            margin-bottom: 30px;
        }

        .product-stock {
            margin-bottom: 30px;
        }

        .stock-info {
            padding: 12px 16px;
            border-radius: 8px;
            font-weight: 600;
            display: inline-block;
        }

        .stock-info.in-stock {
            background: #d1fae5;
            color: #065f46;
        }

        .stock-info.low-stock {
            background: #fef3c7;
            color: #92400e;
        }

        .stock-info.out-of-stock {
            background: #fee2e2;
            color: #991b1b;
        }

        .quantity-section {
            margin-bottom: 30px;
        }

        .quantity-section label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: #2d3748;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .quantity-btn:hover:not(:disabled) {
            border-color: #667eea;
            color: #667eea;
        }

        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quantity-input {
            width: 80px;
            height: 40px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
        }

        .product-actions {
            display: flex;
            gap: 16px;
        }

        .btn-add-to-cart {
            flex: 1;
            padding: 16px 24px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-add-to-cart:hover:not(:disabled) {
            background: #5a67d8;
            transform: translateY(-2px);
        }

        .btn-add-to-cart:disabled {
            background: #a0aec0;
            cursor: not-allowed;
            transform: none;
        }

        .btn-back-to-shop {
            padding: 16px 24px;
            background: #f7fafc;
            color: #4a5568;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back-to-shop:hover {
            border-color: #cbd5e0;
            background: #edf2f7;
        }

        .related-products {
            margin-top: 80px;
        }

        .related-products h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #1a202c;
        }

        .related-products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .related-product-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s;
            cursor: pointer;
        }

        .related-product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .related-product-image {
            aspect-ratio: 1;
            background: #f8f9fa;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .related-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .related-product-info {
            padding: 20px;
        }

        .related-product-brand {
            font-size: 12px;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .related-product-name {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .related-product-price {
            font-size: 16px;
            font-weight: 700;
            color: #2d3748;
        }

        .loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
            flex-direction: column;
            gap: 20px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #e2e8f0;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-container {
            text-align: center;
            padding: 60px 20px;
        }

        .error-container h2 {
            font-size: 24px;
            color: #e53e3e;
            margin-bottom: 16px;
        }

        .error-container p {
            color: #4a5568;
            margin-bottom: 30px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .product-details-container {
                padding: 20px 15px;
            }

            .product-details-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .product-info-section h1 {
                font-size: 24px;
            }

            .product-price {
                font-size: 28px;
            }

            .product-actions {
                flex-direction: column;
            }

            .related-products-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
            }
        }

        /* Notification Styles */
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

        .notification-success { 
            border-left: 4px solid #10B981; 
        }

        .notification-error { 
            border-left: 4px solid #EF4444; 
        }

        .notification-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
        }

        .notification-message { 
            flex: 1; 
            font-weight: 500; 
        }

        .notification-close {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #9CA3AF;
            margin-left: 12px;
        }

        .notification-close:hover { 
            color: #374151; 
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
    <script src="../components/components.js?v=2"></script>
</head>
<body>
    <!-- Navbar Placeholder -->
    <div id="navbar-placeholder"></div>

    <div class="product-details-container">
        <!-- Loading State -->
        <div id="loading-state" class="loading-container">
            <div class="spinner"></div>
            <p>Loading product details...</p>
        </div>

        <!-- Error State -->
        <div id="error-state" class="error-container" style="display: none;">
            <h2>Product Not Found</h2>
            <p>The product you're looking for doesn't exist or has been removed.</p>
            <a href="shop.php" class="btn-back-to-shop">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to Shop
            </a>
        </div>

        <!-- Product Details Content -->
        <div id="product-content" style="display: none;">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="../index.php">Home</a> / <a href="shop.php">Shop</a> / <span id="product-breadcrumb">Product</span>
            </div>

            <!-- Product Details Grid -->
            <div class="product-details-grid">
                <!-- Product Image -->
                <div class="product-image-section">
                    <div class="product-main-image" id="product-image-container">
                        <!-- Image will be loaded here -->
                    </div>
                    <div id="product-badge-container">
                        <!-- Badge will be loaded here -->
                    </div>
                </div>

                <!-- Product Information -->
                <div class="product-info-section">
                    <div class="product-brand" id="product-brand"></div>
                    <h1 id="product-title"></h1>
                    <div class="product-price" id="product-price"></div>
                    <div class="product-description" id="product-description"></div>
                    
                    <div class="product-stock" id="product-stock-section">
                        <!-- Stock info will be loaded here -->
                    </div>

                    <div class="quantity-section" id="quantity-section" style="display: none;">
                        <label>Quantity:</label>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn" id="decrease-qty">−</button>
                            <input type="number" id="quantity-input" class="quantity-input" value="1" min="1">
                            <button type="button" class="quantity-btn" id="increase-qty">+</button>
                        </div>
                    </div>

                    <div class="product-actions">
                        <button id="add-to-cart-btn" class="btn-add-to-cart">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Add to Cart
                        </button>
                        <a href="shop.php" class="btn-back-to-shop">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M19 12H5M12 19l-7-7 7-7"/>
                            </svg>
                            Back to Shop
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div class="related-products" id="related-products-section" style="display: none;">
                <h2>Related Products</h2>
                <div class="related-products-grid" id="related-products-grid">
                    <!-- Related products will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Placeholder -->
    <div id="footer-placeholder"></div>

    <script>
        // Global variables
        let currentProduct = null;
        let maxQuantity = 1;

        // Load product when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get('id');
            
            if (productId) {
                loadProductDetails(productId);
            } else {
                showError('No product specified');
            }

            setupEventListeners();
        });

        // Setup event listeners
        function setupEventListeners() {
            // Quantity controls
            document.getElementById('decrease-qty').addEventListener('click', () => changeQuantity(-1));
            document.getElementById('increase-qty').addEventListener('click', () => changeQuantity(1));
            document.getElementById('quantity-input').addEventListener('change', validateQuantity);

            // Add to cart button
            document.getElementById('add-to-cart-btn').addEventListener('click', addToCartHandler);
        }

        // Load product details from API
        async function loadProductDetails(productId) {
            try {
                showLoading(true);
                
                const response = await fetch(`../api/get-product-details.php?id=${productId}`);
                const data = await response.json();
                
                if (data.success) {
                    currentProduct = data.product;
                    maxQuantity = data.product.stock_quantity;
                    
                    renderProductDetails(data.product);
                    renderRelatedProducts(data.related_products);
                    
                    // Update page title
                    document.title = `${data.product.name} - Gadget Shop`;
                    
                    showLoading(false);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                console.error('Error loading product:', error);
                showError(error.message);
            }
        }

        // Render product details
        function renderProductDetails(product) {
            // Breadcrumb
            document.getElementById('product-breadcrumb').textContent = product.name;

            // Product image
            const imageContainer = document.getElementById('product-image-container');
            if (product.image) {
                imageContainer.innerHTML = `<img src="${product.image_url}" alt="${escapeHtml(product.name)}" onerror="this.src='../assets/images/placeholder-product.svg'">`;
            } else {
                imageContainer.innerHTML = '<div class="image-placeholder">📦</div>';
            }

            // Product badge
            const badgeContainer = document.getElementById('product-badge-container');
            let badgeHtml = '';
            if (product.stock_quantity > 10) {
                badgeHtml = '<div class="product-badge badge-in-stock">In Stock</div>';
            } else if (product.stock_quantity > 0) {
                badgeHtml = `<div class="product-badge badge-low-stock">Low Stock (${product.stock_quantity} left)</div>`;
            } else {
                badgeHtml = '<div class="product-badge badge-out-of-stock">Out of Stock</div>';
            }
            badgeContainer.innerHTML = badgeHtml;

            // Product info
            document.getElementById('product-brand').textContent = product.brand || 'Unknown Brand';
            document.getElementById('product-title').textContent = product.name;
            document.getElementById('product-price').textContent = product.formatted_price;
            document.getElementById('product-description').textContent = product.description || 'No description available';

            // Stock info
            const stockSection = document.getElementById('product-stock-section');
            let stockClass = '';
            if (product.stock_quantity > 10) {
                stockClass = 'in-stock';
            } else if (product.stock_quantity > 0) {
                stockClass = 'low-stock';
            } else {
                stockClass = 'out-of-stock';
            }
            stockSection.innerHTML = `<div class="stock-info ${stockClass}">${product.stock_text}</div>`;

            // Quantity section and add to cart button
            const quantitySection = document.getElementById('quantity-section');
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            
            if (product.stock_quantity > 0) {
                quantitySection.style.display = 'block';
                addToCartBtn.disabled = false;
                addToCartBtn.innerHTML = `
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    Add to Cart
                `;
                
                // Set quantity input max
                const quantityInput = document.getElementById('quantity-input');
                quantityInput.max = product.stock_quantity;
                quantityInput.value = 1;
                
                updateQuantityButtons();
            } else {
                quantitySection.style.display = 'none';
                addToCartBtn.disabled = true;
                addToCartBtn.textContent = 'Out of Stock';
            }
        }

        // Render related products
        function renderRelatedProducts(relatedProducts) {
            if (relatedProducts.length === 0) {
                return;
            }

            const relatedSection = document.getElementById('related-products-section');
            const relatedGrid = document.getElementById('related-products-grid');
            
            relatedGrid.innerHTML = relatedProducts.map(product => `
                <div class="related-product-card" onclick="goToProduct(${product.id})">
                    <div class="related-product-image">
                        ${product.image ? 
                            `<img src="${product.image_url}" alt="${escapeHtml(product.name)}" onerror="this.src='../assets/images/placeholder-product.svg'">` :
                            '<div class="image-placeholder">📦</div>'
                        }
                    </div>
                    <div class="related-product-info">
                        <div class="related-product-brand">${escapeHtml(product.brand || 'Unknown')}</div>
                        <div class="related-product-name">${escapeHtml(product.name)}</div>
                        <div class="related-product-price">${product.formatted_price}</div>
                    </div>
                </div>
            `).join('');
            
            relatedSection.style.display = 'block';
        }

        // Go to another product
        function goToProduct(productId) {
            window.location.href = `product-details.php?id=${productId}`;
        }

        // Change quantity
        function changeQuantity(delta) {
            const quantityInput = document.getElementById('quantity-input');
            const currentValue = parseInt(quantityInput.value) || 1;
            const newValue = Math.max(1, Math.min(maxQuantity, currentValue + delta));
            
            quantityInput.value = newValue;
            updateQuantityButtons();
        }

        // Validate quantity input
        function validateQuantity() {
            const quantityInput = document.getElementById('quantity-input');
            const value = parseInt(quantityInput.value) || 1;
            const validValue = Math.max(1, Math.min(maxQuantity, value));
            
            quantityInput.value = validValue;
            updateQuantityButtons();
        }

        // Update quantity button states
        function updateQuantityButtons() {
            const quantityInput = document.getElementById('quantity-input');
            const decreaseBtn = document.getElementById('decrease-qty');
            const increaseBtn = document.getElementById('increase-qty');
            const currentValue = parseInt(quantityInput.value) || 1;
            
            decreaseBtn.disabled = currentValue <= 1;
            increaseBtn.disabled = currentValue >= maxQuantity;
        }

        // Add to cart handler
        async function addToCartHandler() {
            if (!currentProduct) return;
            
            const quantityInput = document.getElementById('quantity-input');
            const quantity = parseInt(quantityInput.value) || 1;
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            
            // Prevent multiple clicks
            if (addToCartBtn.disabled) return;
            
            addToCartBtn.disabled = true;
            const originalText = addToCartBtn.innerHTML;
            addToCartBtn.textContent = 'Adding...';
            
            try {
                const response = await fetch('../api/add-to-cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: currentProduct.id,
                        quantity: quantity
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showNotification(`${data.data.product_name} added to cart!`, 'success');
                    updateCartCount(data.data.cart_count);
                    
                    // Update global cart state if available
                    if (window.GlobalCart) {
                        await window.GlobalCart.loadFromAPI();
                    }
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                showNotification('Failed to add item to cart. Please try again.', 'error');
            } finally {
                // Re-enable button after delay
                setTimeout(() => {
                    if (currentProduct && currentProduct.stock_quantity > 0) {
                        addToCartBtn.disabled = false;
                        addToCartBtn.innerHTML = originalText;
                    }
                }, 1500);
            }
        }

        // Update cart count in navbar
        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('.cart-count, .cart_count');
            cartCountElements.forEach(element => {
                element.textContent = count;
                element.style.display = count > 0 ? 'inline' : 'none';
            });
        }

        // Show/hide loading state
        function showLoading(show) {
            const loadingState = document.getElementById('loading-state');
            const productContent = document.getElementById('product-content');
            const errorState = document.getElementById('error-state');
            
            if (show) {
                loadingState.style.display = 'flex';
                productContent.style.display = 'none';
                errorState.style.display = 'none';
            } else {
                loadingState.style.display = 'none';
                productContent.style.display = 'block';
                errorState.style.display = 'none';
            }
        }

        // Show error state
        function showError(message) {
            const loadingState = document.getElementById('loading-state');
            const productContent = document.getElementById('product-content');
            const errorState = document.getElementById('error-state');
            
            loadingState.style.display = 'none';
            productContent.style.display = 'none';
            errorState.style.display = 'block';
            
            // Update error message if needed
            const errorP = errorState.querySelector('p');
            if (message && message !== 'No product specified') {
                errorP.textContent = message;
            }
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
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }

        // Escape HTML to prevent XSS
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Load cart count on page load
        document.addEventListener('DOMContentLoaded', async function() {
            try {
                const response = await fetch('../api/get-cart.php');
                const data = await response.json();
                if (data.success) {
                    updateCartCount(data.total_items);
                }
            } catch (error) {
                console.error('Error loading cart count:', error);
            }
        });
    </script>
</body>
</html>
