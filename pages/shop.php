<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Orebi - Shop</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=2" />
    <link rel="stylesheet" href="../assets/css/shop.css?v=2" />
    <link rel="stylesheet" href="../assets/css/shop-nav.css?v=2" />
    <script src="../components/components.js?v=2"></script>
  </head>
  <body>
    <!-- Navbar Placeholder -->
    <div id="navbar-placeholder"></div>

    <!-- Shop Navigation Bar -->
    <nav class="shop-navbar">
      <div class="shop-nav-container">
        <ul class="shop-nav-menu">
          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link">Smartphones</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByBrand('apple')">Apple iPhone</a>
                <a href="#" onclick="filterByBrand('samsung')">Samsung Galaxy</a>
                <a href="#" onclick="filterByBrand('google')">Google Pixel</a>
                <a href="#" onclick="filterByBrand('oneplus')">OnePlus</a>
                <a href="#" onclick="filterByBrand('xiaomi')">Xiaomi</a>
                <a href="#" onclick="filterByBrand('huawei')">Huawei</a>
              </div>
            </div>
          </li>

          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link">Laptops</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByBrand('apple')">Apple MacBook</a>
                <a href="#" onclick="filterByBrand('dell')">Dell</a>
                <a href="#" onclick="filterByBrand('hp')">HP</a>
                <a href="#" onclick="filterByBrand('lenovo')">Lenovo</a>
                <a href="#" onclick="filterByBrand('asus')">ASUS</a>
                <a href="#" onclick="filterByBrand('microsoft')">Microsoft Surface</a>
              </div>
            </div>
          </li>

          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link">Headphones</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByBrand('apple')">Apple AirPods</a>
                <a href="#" onclick="filterByBrand('sony')">Sony</a>
                <a href="#" onclick="filterByBrand('bose')">Bose</a>
                <a href="#" onclick="filterByBrand('sennheiser')">Sennheiser</a>
                <a href="#" onclick="filterByBrand('beats')">Beats</a>
                <a href="#" onclick="filterByBrand('jbl')">JBL</a>
              </div>
            </div>
          </li>

          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link">Smart Watches</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByBrand('apple')">Apple Watch</a>
                <a href="#" onclick="filterByBrand('samsung')">Samsung Galaxy Watch</a>
                <a href="#" onclick="filterByBrand('garmin')">Garmin</a>
                <a href="#" onclick="filterByBrand('fitbit')">Fitbit</a>
                <a href="#" onclick="filterByBrand('fossil')">Fossil</a>
                <a href="#" onclick="filterByBrand('amazfit')">Amazfit</a>
              </div>
            </div>
          </li>

          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link">Accessories</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByBrand('apple')">Apple</a>
                <a href="#" onclick="filterByBrand('anker')">Anker</a>
                <a href="#" onclick="filterByBrand('belkin')">Belkin</a>
                <a href="#" onclick="filterByBrand('logitech')">Logitech</a>
                <a href="#" onclick="filterByBrand('razer')">Razer</a>
                <a href="#" onclick="filterByBrand('samsung')">Samsung</a>
              </div>
            </div>
          </li>

          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link">PC Accessories</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByBrand('logitech')">Logitech</a>
                <a href="#" onclick="filterByBrand('corsair')">Corsair</a>
                <a href="#" onclick="filterByBrand('razer')">Razer</a>
                <a href="#" onclick="filterByBrand('steelseries')">SteelSeries</a>
                <a href="#" onclick="filterByBrand('hyperx')">HyperX</a>
                <a href="#" onclick="filterByBrand('dell')">Dell</a>
              </div>
            </div>
          </li>

          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link">Gaming</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByBrand('razer')">Razer</a>
                <a href="#" onclick="filterByBrand('asus')">ASUS ROG</a>
                <a href="#" onclick="filterByBrand('msi')">MSI Gaming</a>
                <a href="#" onclick="filterByBrand('corsair')">Corsair</a>
                <a href="#" onclick="filterByBrand('steelseries')">SteelSeries</a>
                <a href="#" onclick="filterByBrand('alienware')">Alienware</a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Shop Section -->
    <section class="shop-section">
      <div class="container">
        <!-- Search Bar -->
        <div class="shop-search-section">
          <div class="search-container">
            <input type="text" id="product-search" class="search-input" placeholder="Search products..." autocomplete="off">
            <button type="button" class="clear-search-btn" id="clear-search" title="Clear search" style="display: none;">
              <svg class="clear-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
            <button type="button" class="search-button" id="search-btn">
              <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </button>
          </div>
          <div id="search-status" class="search-status" style="display: none;"></div>
        </div>
        
        <div class="shop-layout">
          <!-- Sidebar Filters -->
          <aside class="shop-sidebar">
            <div class="filter-section">
              <h3>Categories</h3>
              <ul class="category-list" id="category-list">
                <li><a href="#" class="active" data-category="all">All Products</a></li>
                <!-- Categories will be loaded dynamically -->
              </ul>
            </div>
            
            <div class="filter-section">
              <h3>Price Range</h3>
              <div class="price-ranges">
                <label class="price-option">
                  <input type="checkbox" name="price" value="0-100">
                  <span>$0 - $100</span>
                </label>
                <label class="price-option">
                  <input type="checkbox" name="price" value="100-500">
                  <span>$100 - $500</span>
                </label>
                <label class="price-option">
                  <input type="checkbox" name="price" value="500-1000">
                  <span>$500 - $1000</span>
                </label>
                <label class="price-option">
                  <input type="checkbox" name="price" value="1000+">
                  <span>$1000+</span>
                </label>
              </div>
            </div>
          </aside>

          <!-- Main Content -->
          <main class="shop-main">
            <!-- Sort & Filter Bar -->
            <div class="shop-controls">
              <div class="results-count">
                <span>Showing <strong>24</strong> products</span>
              </div>
              <div class="sort-controls">
                <select class="sort-select">
                  <option value="default">Sort by: Default</option>
                  <option value="price-low">Price: Low to High</option>
                  <option value="price-high">Price: High to Low</option>
                  <option value="name">Name: A to Z</option>
                  <option value="rating">Rating: High to Low</option>
                </select>
              </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" id="products-grid">
              <!-- Products will be loaded dynamically -->
              <div class="loading-spinner" id="loading-spinner">
                <div class="spinner"></div>
                <p>Loading products...</p>
              </div>
            </div>

            <!-- Pagination -->
            <div class="pagination">
              <button class="page-btn active">1</button>
              <button class="page-btn">2</button>
              <button class="page-btn">3</button>
              <span class="page-dots">...</span>
              <button class="page-btn">10</button>
              <button class="page-btn next">Next →</button>
            </div>
          </main>
        </div>
      </div>
    </section>

    <!-- Footer Placeholder -->
    <div id="footer-placeholder"></div>

    <script>
      // Global variables
      let currentProducts = [];
      let currentFilters = {
        category: 'all',
        search: '',
        minPrice: 0,
        maxPrice: null,
        sortBy: 'id',
        sortOrder: 'DESC'
      };
      let currentPage = 1;
      let productsPerPage = 12;
      let totalProducts = 0;

      // Load products when page loads
      document.addEventListener('DOMContentLoaded', function() {
        // Initialize filters
        currentFilters = {
          category: 'all',
          search: '',
          minPrice: 0,
          maxPrice: null,
          sortBy: 'id',
          sortOrder: 'DESC'
        };
        loadProducts();
        setupEventListeners();
      });

      // Setup event listeners
      function setupEventListeners() {
        // Search functionality
        const searchInput = document.getElementById('product-search');
        const searchButton = document.getElementById('search-btn');
        const clearButton = document.getElementById('clear-search');
        
        if (searchInput) {
          // Real-time search as user types (debounced)
          searchInput.addEventListener('input', debounce(function() {
            const value = this.value ? this.value.trim() : '';
            currentFilters.search = value;
            currentPage = 1;
            
            // Show/hide clear button
            if (clearButton) {
              clearButton.style.display = value ? 'flex' : 'none';
            }
            
            loadProducts();
          }, 500));

          // Search on Enter key press
          searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
              e.preventDefault();
              performSearch();
            }
          });
        }

        // Search button click
        if (searchButton) {
          searchButton.addEventListener('click', function() {
            performSearch();
          });
        }

        // Clear search button click
        if (clearButton) {
          clearButton.addEventListener('click', function() {
            clearSearch();
          });
        }

        // Sort functionality
        const sortSelect = document.querySelector('.sort-select');
        sortSelect.addEventListener('change', function() {
          const [sortBy, sortOrder] = this.value.split('-');
          switch(this.value) {
            case 'price-low':
              currentFilters.sortBy = 'price';
              currentFilters.sortOrder = 'ASC';
              break;
            case 'price-high':
              currentFilters.sortBy = 'price';
              currentFilters.sortOrder = 'DESC';
              break;
            case 'name':
              currentFilters.sortBy = 'name';
              currentFilters.sortOrder = 'ASC';
              break;
            default:
              currentFilters.sortBy = 'id';
              currentFilters.sortOrder = 'DESC';
          }
          currentPage = 1;
          loadProducts();
        });

        // Price filter checkboxes
        document.querySelectorAll('input[name="price"]').forEach(checkbox => {
          checkbox.addEventListener('change', function() {
            applyPriceFilters();
          });
        });
      }

      // Perform search function
      function performSearch() {
        const searchInput = document.getElementById('product-search');
        if (searchInput) {
          const searchValue = searchInput.value ? searchInput.value.trim() : '';
          currentFilters.search = searchValue;
          currentPage = 1;
          
          // Show/hide clear button
          const clearButton = document.getElementById('clear-search');
          if (clearButton) {
            clearButton.style.display = searchValue ? 'flex' : 'none';
          }
          
          loadProducts();
        }
      }

      // Debounce function for search
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

      // Load products from API
      async function loadProducts() {
        showLoading(true);
        
        try {
          const params = new URLSearchParams({
            category: currentFilters.category || 'all',
            search: currentFilters.search || '',
            min_price: currentFilters.minPrice || 0,
            sort_by: currentFilters.sortBy || 'id',
            sort_order: currentFilters.sortOrder || 'DESC',
            limit: productsPerPage,
            offset: (currentPage - 1) * productsPerPage
          });

          if (currentFilters.maxPrice && currentFilters.maxPrice > 0) {
            params.append('max_price', currentFilters.maxPrice);
          }

          const response = await fetch(`../api/get-products.php?${params}`);
          const data = await response.json();

          if (data.success) {
            currentProducts = data.products;
            totalProducts = data.total;
            displayProducts(data.products);
            updateCategories(data.categories);
            updatePagination(data.pagination);
            updateResultsCount(data.total);
          } else {
            showError('Error loading products: ' + data.message);
          }
        } catch (error) {
          console.error('Error:', error);
          showError('Failed to load products. Please try again.');
        } finally {
          showLoading(false);
        }
      }

      // Display products in grid
      function displayProducts(products) {
        const grid = document.getElementById('products-grid');
        
        if (products.length === 0) {
          const searchTerm = currentFilters.search.trim();
          const isSearching = searchTerm !== '';
          
          let message = '<div class="no-products"><h3>No products found</h3>';
          
          if (isSearching) {
            message += `<p>No products match your search for "<strong>${escapeHtml(searchTerm)}</strong>"</p>`;
            message += '<p>Try adjusting your search terms or browse all products.</p>';
            message += `<button class="clear-search-button" onclick="clearSearch()">Clear Search</button>`;
          } else {
            message += '<p>Try adjusting your filters or check back later for new products.</p>';
          }
          
          message += '</div>';
          grid.innerHTML = message;
          return;
        }

        grid.innerHTML = products.map(product => createProductCard(product)).join('');
      }

      // Create product card HTML
      function createProductCard(product) {
        const stockBadge = product.stock_quantity <= 5 && product.stock_quantity > 0 
          ? '<span class="badge low-stock">Low Stock</span>' 
          : product.stock_quantity > 50 
          ? '<span class="badge in-stock">In Stock</span>' 
          : '';

        const isOutOfStock = product.stock_quantity === 0;
        const buttonDisabled = isOutOfStock ? 'disabled' : '';
        const cardClass = isOutOfStock ? 'product-card out-of-stock' : 'product-card';

        return `
          <div class="${cardClass}" data-category="${product.category}" data-product-id="${product.id}">
            <div class="product-image">
              ${product.image ? 
                `<img src="${product.image_url}" alt="${product.name}" onerror="this.src='../assets/images/placeholder-product.svg'">` :
                '<div class="image-placeholder">📦</div>'
              }
              <div class="product-badges">
                ${stockBadge}
              </div>
            </div>
            <div class="product-info">
              <div class="product-brand">${escapeHtml(product.brand || 'Unknown Brand')}</div>
              <h4>${escapeHtml(product.name)}</h4>
              <p class="product-description">${escapeHtml(product.description || 'No description available')}</p>
              <div class="product-price">
                <span class="current-price">${product.formatted_price}</span>
              </div>
              <div class="product-stock">
                <span class="stock-text ${product.stock_status}">${product.stock_text}</span>
              </div>
              <div class="product-buttons">
                <button class="add-to-cart" onclick="addToCart(${product.id})" ${buttonDisabled}>
                  ${isOutOfStock ? 'Out of Stock' : 'Add to Cart'}
                </button>
                <button class="view-details" onclick="viewProduct(${product.id})">View Details</button>
              </div>
            </div>
          </div>
        `;
      }

      // Update categories list
      function updateCategories(categories) {
        const categoryList = document.getElementById('category-list');
        const allProductsItem = categoryList.querySelector('[data-category="all"]').parentElement;
        
        categoryList.innerHTML = '';
        categoryList.appendChild(allProductsItem);

        categories.forEach(category => {
          const li = document.createElement('li');
          li.innerHTML = `<a href="#" data-category="${category}">${formatCategoryName(category)}</a>`;
          categoryList.appendChild(li);
        });

        // Add event listeners to category links
        categoryList.addEventListener('click', function(e) {
          if (e.target.tagName === 'A') {
            e.preventDefault();
            const category = e.target.getAttribute('data-category');
            filterByCategory(category);
            
            // Update active class
            document.querySelectorAll('.category-list a').forEach(link => {
              link.classList.remove('active');
            });
            e.target.classList.add('active');
          }
        });
      }

      // Format category name for display
      function formatCategoryName(category) {
        return category.split('_').map(word => 
          word.charAt(0).toUpperCase() + word.slice(1)
        ).join(' ');
      }

      // Filter by category
      function filterByCategory(category) {
        currentFilters.category = category;
        currentPage = 1;
        loadProducts();
      }

      // Apply price filters
      function applyPriceFilters() {
        const checkedPrices = document.querySelectorAll('input[name="price"]:checked');
        
        if (checkedPrices.length === 0) {
          currentFilters.minPrice = 0;
          currentFilters.maxPrice = null;
        } else {
          let minPrice = Infinity;
          let maxPrice = 0;
          
          checkedPrices.forEach(checkbox => {
            const range = checkbox.value;
            if (range === '0-100') {
              minPrice = Math.min(minPrice, 0);
              maxPrice = Math.max(maxPrice, 100);
            } else if (range === '100-500') {
              minPrice = Math.min(minPrice, 100);
              maxPrice = Math.max(maxPrice, 500);
            } else if (range === '500-1000') {
              minPrice = Math.min(minPrice, 500);
              maxPrice = Math.max(maxPrice, 1000);
            } else if (range === '1000+') {
              minPrice = Math.min(minPrice, 1000);
              maxPrice = null; // No upper limit
            }
          });
          
          currentFilters.minPrice = minPrice === Infinity ? 0 : minPrice;
          currentFilters.maxPrice = maxPrice;
        }
        
        currentPage = 1;
        loadProducts();
      }

      // Update pagination
      function updatePagination(pagination) {
        const paginationDiv = document.querySelector('.pagination');
        if (!pagination || pagination.total_pages <= 1) {
          paginationDiv.style.display = 'none';
          return;
        }
        
        paginationDiv.style.display = 'flex';
        let paginationHTML = '';
        
        // Previous button
        if (pagination.has_prev) {
          paginationHTML += `<button class="page-btn" onclick="goToPage(${pagination.current_page - 1})">← Prev</button>`;
        }
        
        // Page numbers
        const startPage = Math.max(1, pagination.current_page - 2);
        const endPage = Math.min(pagination.total_pages, pagination.current_page + 2);
        
        if (startPage > 1) {
          paginationHTML += `<button class="page-btn" onclick="goToPage(1)">1</button>`;
          if (startPage > 2) {
            paginationHTML += '<span class="page-dots">...</span>';
          }
        }
        
        for (let i = startPage; i <= endPage; i++) {
          const activeClass = i === pagination.current_page ? 'active' : '';
          paginationHTML += `<button class="page-btn ${activeClass}" onclick="goToPage(${i})">${i}</button>`;
        }
        
        if (endPage < pagination.total_pages) {
          if (endPage < pagination.total_pages - 1) {
            paginationHTML += '<span class="page-dots">...</span>';
          }
          paginationHTML += `<button class="page-btn" onclick="goToPage(${pagination.total_pages})">${pagination.total_pages}</button>`;
        }
        
        // Next button
        if (pagination.has_next) {
          paginationHTML += `<button class="page-btn" onclick="goToPage(${pagination.current_page + 1})">Next →</button>`;
        }
        
        paginationDiv.innerHTML = paginationHTML;
      }

      // Go to specific page
      function goToPage(page) {
        currentPage = page;
        loadProducts();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }

      // Update results count and search status
      function updateResultsCount(total) {
        const countElement = document.querySelector('.results-count strong');
        const searchStatus = document.getElementById('search-status');
        
        if (countElement) {
          countElement.textContent = total;
        }

        // Show search status if there's an active search
        if (searchStatus && currentFilters.search.trim()) {
          const searchTerm = currentFilters.search.trim();
          searchStatus.innerHTML = `
            <div class="search-results-info">
              <span class="search-term">Search results for: "<strong>${escapeHtml(searchTerm)}</strong>"</span>
              <span class="search-count">${total} ${total === 1 ? 'product' : 'products'} found</span>
            </div>
          `;
          searchStatus.style.display = 'block';
        } else if (searchStatus) {
          searchStatus.style.display = 'none';
        }
      }

      // Show/hide loading spinner
      function showLoading(show) {
        const spinner = document.getElementById('loading-spinner');
        if (spinner) {
          spinner.style.display = show ? 'flex' : 'none';
        }
      }

      // Show error message
      function showError(message) {
        const grid = document.getElementById('products-grid');
        grid.innerHTML = `
          <div class="error-message">
            <h3>Oops! Something went wrong</h3>
            <p>${message}</p>
            <button onclick="loadProducts()" class="retry-btn">Try Again</button>
          </div>
        `;
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

      // Add to cart function
      function addToCart(productId) {
        // TODO: Implement add to cart functionality
        alert(`Product ${productId} added to cart! (Cart functionality coming soon)`);
      }

      // View product details
      function viewProduct(productId) {
        // TODO: Implement product details page
        alert(`View product ${productId} details (Product page coming soon)`);
      }

      // Legacy functions for navbar compatibility
      function searchProducts() {
        performSearch();
      }

      function filterByBrand(brand) {
        const searchInput = document.getElementById('product-search');
        if (searchInput) {
          searchInput.value = brand;
        }
        currentFilters.search = brand;
        currentPage = 1;
        loadProducts();
      }

      function filterProducts(category) {
        filterByCategory(category);
      }

      // Clear search function
      function clearSearch() {
        const searchInput = document.getElementById('product-search');
        const clearButton = document.getElementById('clear-search');
        
        if (searchInput) {
          searchInput.value = '';
        }
        if (clearButton) {
          clearButton.style.display = 'none';
        }
        
        currentFilters.search = '';
        currentPage = 1;
        loadProducts();
      }
    </script>
  </body>
</html>
