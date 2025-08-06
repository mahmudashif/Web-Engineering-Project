<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Orebi</title>
    <base href="../">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="shared/navbar.css">
    <link rel="stylesheet" href="shared/footer.css">
    <link rel="stylesheet" href="cart/cart.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
      <div class="nav_main_div">
        <!-- Mobile menu toggle button (left side) -->
        <div class="mobile_menu_toggle">
          <span></span>
          <span></span>
          <span></span>
        </div>
        
        <!-- Left side: Logo -->
        <div class="nav_left_section">
          <div class="nav_logo">
            <a href="index.php">
              <span style="font-size: 24px; font-weight: bold; color: #667eea;">Orebi</span>
            </a>
          </div>
        </div>
        
        <!-- Center: Search Bar -->
        <div class="nav_search">
          <div class="search_container">
            <input type="text" class="search_input" placeholder="Search products">
            <button class="search_button" type="submit">
              <svg class="search_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </button>
          </div>
        </div>
        
        <!-- Mobile Navigation Menu -->
        <div class="nav_menu">
          <ul class="nav_item">
            <li><a href="index.php" id="nav-home">Home</a></li>
            <li><a href="shop.php" id="nav-shop">Shop</a></li>
            <li><a href="about.php" id="nav-about">About</a></li>
            <li><a href="contact.php" id="nav-contact">Contacts</a></li>
            <li><a href="journal.php" id="nav-journal">Journal</a></li>
          </ul>
        </div>
        
        <!-- User and Cart Icons (right side) -->
        <div class="nav_icons">
          <a href="#" class="nav_icon_link" title="User Account">
            <img src="images/homepage/Icon_user.svg" alt="User Account" class="nav_icon" />
          </a>
          <a href="cart/cart.php" class="nav_icon_link cart_icon_link" title="Shopping Cart">
            <img src="images/homepage/Icon_cart.svg" alt="Shopping Cart" class="nav_icon" />
            <span class="cart_count">0</span>
          </a>
        </div>
      </div>
    </nav>

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
                            <a href="shop.php" class="btn-secondary">
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
                            <button class="btn-checkout" id="checkout-btn" disabled>
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

                        <!-- Recommended Products -->
                        <div class="recommended-section">
                            <h3>You might also like</h3>
                            <div class="recommended-items">
                                <div class="recommended-item">
                                    <img src="images/mini-slider/4.jpg" alt="iPad Pro">
                                    <div class="recommended-info">
                                        <h4>iPad Pro</h4>
                                        <p>$1,099.00</p>
                                        <button class="btn-add-small">Add to Cart</button>
                                    </div>
                                </div>
                                <div class="recommended-item">
                                    <img src="images/mini-slider/5.jpg" alt="Apple Watch">
                                    <div class="recommended-info">
                                        <h4>Apple Watch Ultra</h4>
                                        <p>$799.00</p>
                                        <button class="btn-add-small">Add to Cart</button>
                                    </div>
                                </div>
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
                    <a href="shop.php" class="btn-primary">Start Shopping</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer style="background: #1a1a1a; color: white; text-align: center; padding: 40px 0; margin-top: 80px;">
        <div class="container">
            <p>&copy; 2025 Orebi. All rights reserved.</p>
        </div>
    </footer>

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
            
            // Initialize mobile menu
            const mobileToggle = document.querySelector('.mobile_menu_toggle');
            const navMenu = document.querySelector('.nav_menu');
            
            if (mobileToggle && navMenu) {
                mobileToggle.addEventListener('click', function() {
                    this.classList.toggle('active');
                    navMenu.classList.toggle('active');
                });
            }
        });
    </script>
    <script src="shared/cart-global.js"></script>
    <script src="cart/cart.js"></script>
</body>
</html>
