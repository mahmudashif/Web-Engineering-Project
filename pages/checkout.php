<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Orebi</title>
    <base href="../">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="components/navbar/navbar.css">
    <link rel="stylesheet" href="components/footer/footer.css">
    <link rel="stylesheet" href="assets/css/checkout.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="components/components.js"></script>
</head>
<body>
    <!-- Navbar Placeholder -->
    <div id="navbar-placeholder"></div>

    <!-- Checkout Main Content -->
    <main class="checkout-main">
        <!-- Hero Section -->
        <section class="checkout-hero">
            <div class="container">
                <div class="checkout-hero-content">
                    <h1>Checkout</h1>
                    <p>Complete your order</p>
                    <div class="breadcrumb">
                        <a href="index.php">Home</a> / 
                        <a href="components/cart/cart.php">Cart</a> / 
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Checkout Content -->
        <section class="checkout-section">
            <div class="container">
                <div class="checkout-wrapper">
                    <!-- Checkout Form -->
                    <div class="checkout-form-container">
                        <form id="checkout-form" class="checkout-form">
                            <!-- Billing Information -->
                            <div class="form-section">
                                <h2>Billing Information</h2>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="firstName">First Name *</label>
                                        <input type="text" id="firstName" name="firstName" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastName">Last Name *</label>
                                        <input type="text" id="lastName" name="lastName" required>
                                    </div>
                                    <div class="form-group full-width">
                                        <label for="email">Email Address *</label>
                                        <input type="email" id="email" name="email" required>
                                    </div>
                                    <div class="form-group full-width">
                                        <label for="phone">Phone Number *</label>
                                        <input type="tel" id="phone" name="phone" required>
                                    </div>
                                    <div class="form-group full-width">
                                        <label for="address">Street Address *</label>
                                        <input type="text" id="address" name="address" placeholder="House number and street name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="city">City *</label>
                                        <input type="text" id="city" name="city" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="postalCode">Postal Code *</label>
                                        <input type="text" id="postalCode" name="postalCode" required>
                                    </div>
                                    <div class="form-group full-width">
                                        <label for="orderNotes">Order Notes (Optional)</label>
                                        <textarea id="orderNotes" name="orderNotes" rows="3" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="form-section">
                                <h2>Payment Method</h2>
                                <div class="payment-methods">
                                    <div class="payment-option">
                                        <input type="radio" id="cod" name="paymentMethod" value="cod" checked>
                                        <label for="cod" class="payment-label">
                                            <div class="payment-info">
                                                <span class="payment-title">Cash on Delivery</span>
                                                <span class="payment-desc">Pay with cash when your order is delivered</span>
                                            </div>
                                            <div class="payment-icon">💵</div>
                                        </label>
                                    </div>
                                    <div class="payment-option">
                                        <input type="radio" id="bkash" name="paymentMethod" value="bkash">
                                        <label for="bkash" class="payment-label">
                                            <div class="payment-info">
                                                <span class="payment-title">bKash</span>
                                                <span class="payment-desc">Pay securely with bKash mobile banking</span>
                                            </div>
                                            <div class="payment-icon">📱</div>
                                        </label>
                                    </div>
                                    <div class="payment-option">
                                        <input type="radio" id="nagad" name="paymentMethod" value="nagad">
                                        <label for="nagad" class="payment-label">
                                            <div class="payment-info">
                                                <span class="payment-title">Nagad</span>
                                                <span class="payment-desc">Pay securely with Nagad mobile banking</span>
                                            </div>
                                            <div class="payment-icon">💳</div>
                                        </label>
                                    </div>
                                    <div class="payment-option">
                                        <input type="radio" id="visa" name="paymentMethod" value="visa">
                                        <label for="visa" class="payment-label">
                                            <div class="payment-info">
                                                <span class="payment-title">Visa/Mastercard</span>
                                                <span class="payment-desc">Pay securely with your credit/debit card</span>
                                            </div>
                                            <div class="payment-icon">💳</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Order Summary -->
                    <div class="checkout-summary">
                        <div class="summary-card">
                            <h3>Your Order</h3>
                            
                            <div class="order-items" id="checkout-items">
                                <!-- Order items will be loaded here -->
                            </div>

                            <div class="summary-totals">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span id="checkout-subtotal">$0.00</span>
                                </div>
                                <div class="summary-row">
                                    <span>Shipping</span>
                                    <span class="free">Free</span>
                                </div>
                                <div class="summary-row">
                                    <span>Tax</span>
                                    <span id="checkout-tax">$0.00</span>
                                </div>
                                <hr>
                                <div class="summary-total">
                                    <span>Total</span>
                                    <span id="checkout-total">$0.00</span>
                                </div>
                            </div>

                            <button type="button" class="btn-place-order" id="place-order-btn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M9 12l2 2 4-4"/>
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                                Place Order
                            </button>

                            <div class="secure-checkout">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                                <span>Secure Checkout - SSL Encrypted</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Placeholder -->
    <div id="footer-placeholder"></div>

    <!-- Order Success Modal -->
    <div id="order-success-modal" class="modal">
        <div class="modal-content">
            <div class="success-icon">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M9 12l2 2 4-4"/>
                    <circle cx="12" cy="12" r="10"/>
                </svg>
            </div>
            <h2>Order Placed Successfully!</h2>
            <p>Thank you for your order. We've received your order and will process it soon.</p>
            <div class="order-details">
                <p><strong>Order ID:</strong> <span id="order-id-display"></span></p>
                <p><strong>Total:</strong> <span id="order-total-display"></span></p>
            </div>
            <div class="modal-buttons">
                <a href="index.php" class="btn-primary">Continue Shopping</a>
                <button onclick="window.print()" class="btn-secondary">Print Receipt</button>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="loading-overlay" style="display: none;">
        <div class="loading-spinner">
            <div class="spinner"></div>
            <p>Processing your order...</p>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="components/cart-global.js"></script>
    <script src="assets/js/checkout.js"></script>
</body>
</html>
