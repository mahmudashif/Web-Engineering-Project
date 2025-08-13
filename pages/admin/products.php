<?php
// Include admin authentication middleware
require_once '../../includes/admin-auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products | Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="../../assets/css/product-management.css">
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
                <li class="active"><a href="products.php"><span class="icon">🛒</span> Products</a></li>
                <li><a href="orders.php"><span class="icon">📦</span> Orders</a></li>
                <li><a href="settings.php"><span class="icon">⚙️</span> Settings</a></li>
                <li class="home-link"><a href="../../index.php"><span class="icon">🏠</span> Back to Website</a></li>
            </ul>
        </div>
        
        <div class="admin-content">
            <div class="admin-header">
                <h2>Manage Products</h2>
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
            
            <div class="admin-card">
                <div class="product-management">
                    <!-- Header with Actions -->
                    <div class="products-header">
                        <h3 class="products-title">Product Management</h3>
                        <div class="products-actions">
                            <button class="btn btn-success" id="addCategoryBtn">Add Category</button>
                            <button class="btn btn-primary" id="addProductBtn">Add Product</button>
                        </div>
                    </div>
                    
                    <!-- Filters -->
                    <div class="products-filters">
                        <div class="filter-group">
                            <label for="searchProducts">Search Products</label>
                            <input type="text" id="searchProducts" class="filter-input" placeholder="Search by name, description, or category...">
                        </div>
                        <div class="filter-group">
                            <label for="categoryFilter">Category</label>
                            <select id="categoryFilter" class="filter-select">
                                <option value="">All Categories</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Products Grid -->
                    <div class="products-grid" id="productsContainer">
                        <div class="loading">Loading products...</div>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="pagination-container" id="paginationContainer">
                        <!-- Pagination will be rendered here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Modal -->
    <div class="modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="productModalTitle">Add New Product</h3>
                <button type="button" class="close-modal">&times;</button>
            </div>
            <form id="productForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="productName">Product Name *</label>
                        <input type="text" id="productName" name="productName" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="productDescription">Description</label>
                        <textarea id="productDescription" name="productDescription" class="form-control" rows="4"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="productPrice">Price *</label>
                        <input type="number" id="productPrice" name="productPrice" class="form-control" min="0" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="productStock">Stock Quantity</label>
                        <input type="number" id="productStock" name="productStock" class="form-control" min="0" value="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="productCategory">Category</label>
                        <select id="productCategory" name="productCategory" class="form-control">
                            <option value="">Select Category</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="productImage">Product Image</label>
                        <div class="image-upload-group">
                            <div class="image-upload-input">
                                <input type="file" id="productImage" name="productImage" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Accepted formats: JPEG, PNG, GIF. Max size: 5MB</small>
                            </div>
                            <div class="image-preview" id="imagePreview">
                                <div class="preview-placeholder">No image selected</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Category Modal -->
    <div class="modal" id="categoryModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add New Category</h3>
                <button type="button" class="close-modal">&times;</button>
            </div>
            <form id="categoryForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="categoryName">Category Name *</label>
                        <input type="text" id="categoryName" name="categoryName" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="categoryDescription">Description</label>
                        <textarea id="categoryDescription" name="categoryDescription" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include footer -->
    <div id="footer-container"></div>

    <!-- Scripts -->
    <script src="../../assets/js/admin-components.js"></script>
    <script src="../../assets/js/product-manager.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for UserAuth to be available
            const checkUserAuth = setInterval(function() {
                if (window.userAuth) {
                    clearInterval(checkUserAuth);
                    
                    // Now we can use UserAuth
                    const userAuth = window.userAuth;
                    
                    userAuth.requireAdminAuth().then(user => {
                        if (user) {
                            // Update admin name
                            const adminNameElement = document.getElementById('admin-name');
                            if (adminNameElement) {
                                adminNameElement.textContent = user.full_name;
                            }
                            
                            // Update admin role
                            const adminRoleElement = document.getElementById('admin-role');
                            if (adminRoleElement) {
                                adminRoleElement.textContent = 'Administrator';
                            }
                            
                            // Update admin profile picture or initials
                            const adminImageElement = document.getElementById('admin-image');
                            const adminInitialsElement = document.getElementById('admin-initials');
                            
                            if (user.profile_picture) {
                                // Get base path for current page
                                const basePath = '../../';
                                const profilePicturePath = basePath + user.profile_picture;
                                
                                adminImageElement.src = profilePicturePath;
                                adminImageElement.style.display = 'block';
                                adminInitialsElement.style.display = 'none';
                            } else {
                                // Show initials if no profile picture
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
                    });
                }
            }, 100); // Check every 100ms
        });
    </script>
</body>
</html>
