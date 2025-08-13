<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Orebi</title>
    <base href="../../">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="components/navbar/navbar.css">
    <link rel="stylesheet" href="components/footer/footer.css">
    <link rel="stylesheet" href="components/cart/cart.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="components/components.js"></script>
</head>
<body>
    <!-- Navbar Placeholder -->
    <div id="navbar-placeholder"></div>

    <!-- Cart Main Content -->
    <main class="cart-main">
        <!-- Hero Section -->
        <section class="cart-hero">
            <div class="container">
                <div class="cart-hero-content">
                    <h1>Shopping Cart</h1>
                    <p>Review your selected items and proceed to checkout</p>
                    <div class="breadcrumb">
                        <a href="index.php">Home</a> / <span>Cart</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cart Content -->
        <section class="cart-section">
            <div class="container">
                <div class="cart-wrapper">
                    <!-- Cart Items -->
                    <div class="cart-items-container">
                        <div class="cart-header">
                            <h2>Cart Items</h2>
                            <span class="item-count">0 items</span>
                        </div>

                        <div class="cart-items" id="cart-items-list">
                            <!-- Cart items will be dynamically loaded here -->
                        </div>

                        <!-- Continue Shopping -->
                        <div class="continue-shopping">
                            <a href="pages/shop.php" class="btn-secondary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                                </svg>
                                Continue Shopping
                            </a>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="cart-summary">
                        <div class="summary-card">
                            <h3>Order Summary</h3>
                            
                            <div class="summary-details">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span id="subtotal-amount">$0.00</span>
                                </div>
                                <div class="summary-row">
                                    <span>Shipping</span>
                                    <span class="free">Free</span>
                                </div>
                                <div class="summary-row">
                                    <span>Tax</span>
                                    <span id="tax-amount">$0.00</span>
                                </div>
                                <div class="summary-row discount">
                                    <span>Discount</span>
                                    <span id="discount-amount">$0.00</span>
                                </div>
                                <hr>
                                <div class="summary-total">
                                    <span>Total</span>
                                    <span id="total-amount">$0.00</span>
                                </div>
                            </div>

                            <!-- Promo Code -->
                            <div class="promo-section">
                                <h4>Have a promo code?</h4>
                                <div class="promo-input">
                                    <input type="text" placeholder="Enter promo code">
                                    <button class="btn-apply">Apply</button>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <button class="btn-checkout" id="checkout-btn" disabled onclick="proceedToCheckout()">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M9 12l2 2 4-4"/>
                                    <path d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9c2.39 0 4.68.94 6.36 2.64"/>
                                </svg>
                                Proceed to Checkout
                            </button>

                            <!-- Security Badges -->
                            <div class="security-badges">
                                <div class="security-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    </svg>
                                    <span>Secure Payment</span>
                                </div>
                                <div class="security-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                    </svg>
                                    <span>Fast Delivery</span>
                                </div>
                                <div class="security-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M9 12l2 2 4-4"/>
                                        <circle cx="12" cy="12" r="10"/>
                                    </svg>
                                    <span>Money Back Guarantee</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Actions Section -->
        <section class="quick-actions-section">
            <div class="container">
                <div class="quick-actions-wrapper">
                    <div class="quick-actions-card">
                        <div class="quick-action-item">
                            <div class="quick-action-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="quick-action-content">
                                <h3>Track Your Orders</h3>
                                <p>View order history and track delivery status</p>
                                <a href="../pages/orders.php" class="btn-quick-action">View All Orders</a>
                            </div>
                        </div>
                        
                        <div class="quick-action-item">
                            <div class="quick-action-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="quick-action-content">
                                <h3>Continue Shopping</h3>
                                <p>Browse our collection of products</p>
                                <a href="../pages/shop.php" class="btn-quick-action">Browse Products</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Empty Cart State (Shown by default) -->
        <section class="empty-cart" id="empty-cart-section">
            <div class="container">
                <div class="empty-cart-content">
                    <div class="empty-cart-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="9" cy="21" r="1"/>
                            <circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                    </div>
                    <h2>Your cart is empty</h2>
                    <p>Looks like you haven't added any items to your cart yet</p>
                    <a href="pages/shop.php" class="btn-primary">Start Shopping</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Placeholder -->
    <div id="footer-placeholder"></div>

    <!-- JavaScript -->
    <script>
        // Load components when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Update cart count
            const totalItems = 2; // Based on test items
            const cartCountElement = document.querySelector('.cart_count');
            if (cartCountElement) {
                cartCountElement.textContent = totalItems;
            }
        });
        
        // Global checkout function
        function proceedToCheckout() {
            // Check if user is logged in first
            fetch('../api/check-auth.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // User is logged in, proceed to checkout
                        window.location.href = '../pages/checkout.php';
                    } else {
                        // User not logged in, redirect to login
                        alert('Please login to proceed with checkout');
                        window.location.href = '../pages/auth/login.php';
                    }
                })
                .catch(error => {
                    console.error('Error checking authentication:', error);
                    alert('Please login to proceed with checkout');
                    window.location.href = '../pages/auth/login.php';
                });
        }
    </script>
    <script src="components/cart-global.js"></script>
    <script src="components/cart/cart.js"></script>
</body>
</html>
