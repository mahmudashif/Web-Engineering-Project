<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gadget Shop - Shop</title>
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
            <a href="#" class="shop-nav-link" onclick="filterByCategory('smartphones')">Smartphones</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByCategoryAndBrand('smartphones', 'apple', 'Apple iPhone')">Apple iPhone</a>
                <a href="#" onclick="filterByCategoryAndBrand('smartphones', 'samsung', 'Samsung Galaxy')">Samsung Galaxy</a>
                <a href="#" onclick="filterByCategoryAndBrand('smartphones', 'google', 'Google Pixel')">Google Pixel</a>
                <a href="#" onclick="filterByCategoryAndBrand('smartphones', 'oneplus', 'OnePlus')">OnePlus</a>
                <a href="#" onclick="filterByCategoryAndBrand('smartphones', 'xiaomi', 'Xiaomi')">Xiaomi</a>
                <a href="#" onclick="filterByCategoryAndBrand('smartphones', 'huawei', 'Huawei')">Huawei</a>
              </div>
            </div>
          </li>

          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link" onclick="filterByCategory('laptops')">Laptops</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByCategoryAndBrand('laptops', 'apple', 'Apple MacBook')">Apple MacBook</a>
                <a href="#" onclick="filterByCategoryAndBrand('laptops', 'dell', 'Dell')">Dell</a>
                <a href="#" onclick="filterByCategoryAndBrand('laptops', 'hp', 'HP')">HP</a>
                <a href="#" onclick="filterByCategoryAndBrand('laptops', 'lenovo', 'Lenovo')">Lenovo</a>
                <a href="#" onclick="filterByCategoryAndBrand('laptops', 'asus', 'ASUS')">ASUS</a>
                <a href="#" onclick="filterByCategoryAndBrand('laptops', 'microsoft', 'Microsoft Surface')">Microsoft Surface</a>
              </div>
            </div>
          </li>

          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link" onclick="filterByCategory('headphones')">Headphones</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByCategoryAndBrand('headphones', 'apple', 'Apple AirPods')">Apple AirPods</a>
                <a href="#" onclick="filterByCategoryAndBrand('headphones', 'sony', 'Sony')">Sony</a>
                <a href="#" onclick="filterByCategoryAndBrand('headphones', 'bose', 'Bose')">Bose</a>
                <a href="#" onclick="filterByCategoryAndBrand('headphones', 'sennheiser', 'Sennheiser')">Sennheiser</a>
                <a href="#" onclick="filterByCategoryAndBrand('headphones', 'beats', 'Beats')">Beats</a>
                <a href="#" onclick="filterByCategoryAndBrand('headphones', 'jbl', 'JBL')">JBL</a>
              </div>
            </div>
          </li>

          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link" onclick="filterByCategory('smartwatches')">Smart Watches</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByCategoryAndBrand('smartwatches', 'apple', 'Apple Watch')">Apple Watch</a>
                <a href="#" onclick="filterByCategoryAndBrand('smartwatches', 'samsung', 'Samsung Galaxy Watch')">Samsung Galaxy Watch</a>
                <a href="#" onclick="filterByCategoryAndBrand('smartwatches', 'garmin', 'Garmin')">Garmin</a>
                <a href="#" onclick="filterByCategoryAndBrand('smartwatches', 'fitbit', 'Fitbit')">Fitbit</a>
                <a href="#" onclick="filterByCategoryAndBrand('smartwatches', 'fossil', 'Fossil')">Fossil</a>
                <a href="#" onclick="filterByCategoryAndBrand('smartwatches', 'amazfit', 'Amazfit')">Amazfit</a>
              </div>
            </div>
          </li>

          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link" onclick="filterByCategory('accessories')">Accessories</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByCategoryAndBrand('accessories', 'apple', 'Apple Accessories')">Apple Accessories</a>
                <a href="#" onclick="filterByCategoryAndBrand('accessories', 'anker', 'Anker')">Anker</a>
                <a href="#" onclick="filterByCategoryAndBrand('accessories', 'belkin', 'Belkin')">Belkin</a>
                <a href="#" onclick="filterByCategoryAndBrand('accessories', 'logitech', 'Logitech')">Logitech</a>
                <a href="#" onclick="filterByCategoryAndBrand('accessories', 'razer', 'Razer')">Razer</a>
                <a href="#" onclick="filterByCategoryAndBrand('accessories', 'samsung', 'Samsung Accessories')">Samsung Accessories</a>
              </div>
            </div>
          </li>

          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link" onclick="filterByCategory('pc_accessories')">PC Accessories</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByCategoryAndBrand('pc_accessories', 'logitech', 'Logitech')">Logitech</a>
                <a href="#" onclick="filterByCategoryAndBrand('pc_accessories', 'corsair', 'Corsair')">Corsair</a>
                <a href="#" onclick="filterByCategoryAndBrand('pc_accessories', 'razer', 'Razer')">Razer</a>
                <a href="#" onclick="filterByCategoryAndBrand('pc_accessories', 'steelseries', 'SteelSeries')">SteelSeries</a>
                <a href="#" onclick="filterByCategoryAndBrand('pc_accessories', 'hyperx', 'HyperX')">HyperX</a>
                <a href="#" onclick="filterByCategoryAndBrand('pc_accessories', 'dell', 'Dell')">Dell</a>
              </div>
            </div>
          </li>

          <li class="shop-nav-item">
            <a href="#" class="shop-nav-link" onclick="filterByCategory('gaming')">Gaming</a>
            <div class="shop-dropdown">
              <div class="dropdown-content">
                <a href="#" onclick="filterByCategoryAndBrand('gaming', 'razer', 'Razer')">Razer</a>
                <a href="#" onclick="filterByCategoryAndBrand('gaming', 'asus', 'ASUS ROG')">ASUS ROG</a>
                <a href="#" onclick="filterByCategoryAndBrand('gaming', 'msi', 'MSI Gaming')">MSI Gaming</a>
                <a href="#" onclick="filterByCategoryAndBrand('gaming', 'corsair', 'Corsair')">Corsair</a>
                <a href="#" onclick="filterByCategoryAndBrand('gaming', 'steelseries', 'SteelSeries')">SteelSeries</a>
                <a href="#" onclick="filterByCategoryAndBrand('gaming', 'alienware', 'Alienware')">Alienware</a>
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

    <!-- Product Details Modal -->
    <div class="modal" id="productDetailsModal">
      <div class="modal-backdrop"></div>
      <div class="modal-content product-modal">
        <button class="modal-close" onclick="closeProductModal()">&times;</button>
        <div class="modal-loading" id="modalLoading">
          <div class="spinner"></div>
          <p>Loading product details...</p>
        </div>
        <div class="product-details-content" id="productDetailsContent" style="display: none;">
          <!-- Product details will be loaded here -->
        </div>
      </div>
    </div>

    <script>
      // Global variables
      let currentProducts = [];
      let currentFilters = {
        category: 'all',
        brand: '',
        search: '',
        minPrice: 0,
        maxPrice: null,
        sortBy: 'id',
        sortOrder: 'DESC'
      };
      let currentPage = 1;
      let productsPerPage = 9;
      let totalProducts = 0;

      // Load products when page loads
      document.addEventListener('DOMContentLoaded', function() {
        // Get URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const urlSearch = urlParams.get('search') || '';
        
        // Initialize filters
        currentFilters = {
          category: 'all',
          brand: '',
          search: urlSearch,
          minPrice: 0,
          maxPrice: null,
          sortBy: 'id',
          sortOrder: 'DESC'
        };
        
        // Set search input value if coming from URL
        if (urlSearch) {
          const searchInput = document.getElementById('product-search');
          if (searchInput) {
            searchInput.value = urlSearch;
            const clearButton = document.getElementById('clear-search');
            if (clearButton) {
              clearButton.style.display = 'flex';
            }
          }
        }
        
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

        // Clear search button clic
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
            brand: currentFilters.brand || '',
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

      // Helper function to truncate description to few words
      function truncateDescription(description, wordLimit = 8) {
        if (!description || description === 'No description available') {
          return 'No description available';
        }
        
        const words = description.split(' ');
        if (words.length <= wordLimit) {
          return description;
        }
        
        return words.slice(0, wordLimit).join(' ') + '...';
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

        // Truncate description to show only few words for better card layout
        const shortDescription = truncateDescription(product.description || 'No description available', 8);

        return `
          <div class="${cardClass}" data-category="${product.category}" data-product-id="${product.id}" onclick="navigateToProduct(${product.id}, event)">
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
              <p class="product-description">${escapeHtml(shortDescription)}</p>
              <div class="product-price">
                <span class="current-price">${product.formatted_price}</span>
              </div>
              <div class="product-stock">
                <span class="stock-text ${product.stock_status}">${product.stock_text}</span>
              </div>
              <div class="product-buttons">
                <button class="add-to-cart" onclick="addToCart(${product.id}, 1); event.stopPropagation();" ${buttonDisabled}>
                  ${isOutOfStock ? 'Out of Stock' : 'Add to Cart'}
                </button>
                <a href="product-details.php?id=${product.id}" class="view-details" onclick="event.stopPropagation();">View Details</a>
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

        // Show search status only if there's an active search with actual text
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

      // Add to cart function - ensures single addition only
      async function addToCart(productId, quantity = 1) {
        // Prevent multiple simultaneous requests
        if (window.addToCartInProgress) {
          return;
        }
        
        window.addToCartInProgress = true;
        
        try {
          const response = await fetch('../api/add-to-cart.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              product_id: productId,
              quantity: quantity
            })
          });
          
          const data = await response.json();
          
          if (data.success) {
            showNotification(`${data.data.product_name} added to cart!`, 'success');
            updateCartCount(data.data.cart_count);
            
            // Update global cart state
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
          window.addToCartInProgress = false;
        }
      }

      // View product details
      async function viewProduct(productId) {
        const modal = document.getElementById('productDetailsModal');
        const loading = document.getElementById('modalLoading');
        const content = document.getElementById('productDetailsContent');
        
        modal.style.display = 'block';
        loading.style.display = 'flex';
        content.style.display = 'none';
        
        try {
          const response = await fetch(`../api/get-product-details.php?id=${productId}`);
          const data = await response.json();
          
          if (data.success) {
            renderProductDetails(data.product, data.related_products);
            loading.style.display = 'none';
            content.style.display = 'block';
          } else {
            throw new Error(data.message);
          }
        } catch (error) {
          console.error('Error loading product details:', error);
          closeProductModal();
          showNotification('Failed to load product details. Please try again.', 'error');
        }
      }
      
      // Render product details in modal
      function renderProductDetails(product, relatedProducts) {
        const content = document.getElementById('productDetailsContent');
        
        const relatedProductsHtml = relatedProducts.length > 0 ? `
          <div class="related-products-section">
            <h3 class="related-products-title">Related Products</h3>
            <div class="related-products-grid">
              ${relatedProducts.map(related => `
                <div class="related-product-card" onclick="window.location.href='product-details.php?id=${related.id}'">>
                  <div class="related-product-image">
                    ${related.image ? 
                      `<img src="${related.image_url}" alt="${related.name}" onerror="this.src='../assets/images/placeholder-product.svg'">` :
                      '<div class="image-placeholder">📦</div>'
                    }
                  </div>
                  <div class="related-product-brand">${escapeHtml(related.brand || 'Unknown')}</div>
                  <div class="related-product-name">${escapeHtml(related.name)}</div>
                  <div class="related-product-price">${related.formatted_price}</div>
                </div>
              `).join('')}
            </div>
          </div>
        ` : '';
        
        content.innerHTML = `
          <div class="product-image-section">
            <div class="main-product-image">
              ${product.image ? 
                `<img src="${product.image_url}" alt="${product.name}" onerror="this.src='../assets/images/placeholder-product.svg'">` :
                '<div class="image-placeholder">📦</div>'
              }
            </div>
          </div>
          
          <div class="product-info-section">
            <div class="product-brand-modal">${escapeHtml(product.brand || 'Unknown Brand')}</div>
            <h1 class="product-title-modal">${escapeHtml(product.name)}</h1>
            <div class="product-price-modal">${product.formatted_price}</div>
            
            ${product.description ? `
              <div class="product-description-modal">${escapeHtml(product.description)}</div>
            ` : ''}
            
            <div class="product-stock-modal ${product.stock_status}">
              ${product.stock_text}
            </div>
            
            ${product.stock_quantity > 0 ? `
              <div class="quantity-selector">
                <label for="quantityModal">Quantity:</label>
                <div class="quantity-controls">
                  <button type="button" class="quantity-btn" onclick="changeQuantity(-1)" ${product.stock_quantity <= 1 ? 'disabled' : ''}>−</button>
                  <input type="number" id="quantityModal" class="quantity-input" value="1" min="1" max="${product.stock_quantity}" onchange="validateQuantity()">
                  <button type="button" class="quantity-btn" onclick="changeQuantity(1)" ${product.stock_quantity <= 1 ? 'disabled' : ''}>+</button>
                </div>
              </div>
            ` : ''}
            
            <div class="modal-buttons">
              ${product.stock_quantity > 0 ? `
                <button class="btn-add-to-cart-modal" onclick="addToCartFromModal(${product.id})" data-product-id="${product.id}">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="9" cy="21" r="1"/>
                    <circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                  </svg>
                  Add to Cart
                </button>
              ` : `
                <button class="btn-add-to-cart-modal" disabled>Out of Stock</button>
              `}
              <button class="btn-continue-shopping" onclick="closeProductModal()">Continue Shopping</button>
            </div>
          </div>
          
          ${relatedProductsHtml}
        `;
      }
      
      // Close product modal
      function closeProductModal() {
        const modal = document.getElementById('productDetailsModal');
        modal.style.display = 'none';
      }
      
      // Change quantity in modal
      function changeQuantity(delta) {
        const input = document.getElementById('quantityModal');
        if (!input) return;
        
        const currentValue = parseInt(input.value) || 1;
        const newValue = Math.max(1, Math.min(parseInt(input.max), currentValue + delta));
        input.value = newValue;
        
        // Update button states
        const decreaseBtn = input.parentElement.querySelector('.quantity-btn:first-child');
        const increaseBtn = input.parentElement.querySelector('.quantity-btn:last-child');
        
        decreaseBtn.disabled = newValue <= 1;
        increaseBtn.disabled = newValue >= parseInt(input.max);
      }
      
      // Validate quantity input
      function validateQuantity() {
        const input = document.getElementById('quantityModal');
        if (!input) return;
        
        const value = parseInt(input.value) || 1;
        const min = parseInt(input.min) || 1;
        const max = parseInt(input.max) || 999;
        
        input.value = Math.max(min, Math.min(max, value));
        
        // Update button states
        const decreaseBtn = input.parentElement.querySelector('.quantity-btn:first-child');
        const increaseBtn = input.parentElement.querySelector('.quantity-btn:last-child');
        
        decreaseBtn.disabled = input.value <= min;
        increaseBtn.disabled = input.value >= max;
      }
      
      // Add to cart from modal - with button state management
      async function addToCartFromModal(productId) {
        // Prevent multiple clicks
        const button = event.target;
        if (button.disabled) return;
        
        const quantityInput = document.getElementById('quantityModal');
        const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
        
        // Disable button temporarily
        button.disabled = true;
        const originalText = button.innerHTML;
        button.innerHTML = 'Adding...';
        
        try {
          await addToCart(productId, quantity);
        } finally {
          // Re-enable button after delay
          setTimeout(() => {
            button.disabled = false;
            button.innerHTML = originalText;
          }, 1500);
        }
      }
      
      // Update cart count in navbar
      function updateCartCount(count) {
        // Try to find cart count elements in navbar
        const cartCountElements = document.querySelectorAll('.cart-count, .cart_count');
        cartCountElements.forEach(element => {
          element.textContent = count;
          element.style.display = count > 0 ? 'inline' : 'none';
        });
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
      
      // Close modal when clicking backdrop
      document.addEventListener('click', function(e) {
        const modal = document.getElementById('productDetailsModal');
        if (e.target === modal || e.target.classList.contains('modal-backdrop')) {
          closeProductModal();
        }
      });
      
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

      // Legacy functions for navbar compatibility
      function searchProducts() {
        performSearch();
      }

      // New optimized filtering functions
      function filterByCategoryAndBrand(category, brand, displayName) {
        // Clear search input when filtering by category and brand
        const searchInput = document.getElementById('product-search');
        const clearButton = document.getElementById('clear-search');
        if (searchInput) {
          searchInput.value = '';
        }
        if (clearButton) {
          clearButton.style.display = 'none';
        }
        
        currentFilters.category = category;
        currentFilters.brand = brand;
        currentFilters.search = '';
        currentPage = 1;
        loadProducts();
      }

      function filterByCategory(category) {
        // Clear search input when filtering by category only
        const searchInput = document.getElementById('product-search');
        const clearButton = document.getElementById('clear-search');
        if (searchInput) {
          searchInput.value = '';
        }
        if (clearButton) {
          clearButton.style.display = 'none';
        }
        
        currentFilters.category = category;
        currentFilters.brand = ''; // Clear brand filter when filtering by category only
        currentFilters.search = '';
        currentPage = 1;
        
        // Update active class in sidebar
        document.querySelectorAll('.category-list a').forEach(link => {
          link.classList.remove('active');
          if (link.getAttribute('data-category') === category) {
            link.classList.add('active');
          }
        });
        
        loadProducts();
      }

      // Update filter status display
      function updateFilterStatus() {
        // This function is disabled - no filter status display needed
        const searchStatus = document.getElementById('search-status');
        if (!searchStatus) return;

        // Only show search status when there's actual search text
        if (currentFilters.search !== '') {
          const searchTerm = currentFilters.search.trim();
          searchStatus.innerHTML = `
            <div class="search-results-info">
              <span class="search-term">Search results for: "<strong>${escapeHtml(searchTerm)}</strong>"</span>
              <span class="search-count">${totalProducts} ${totalProducts === 1 ? 'product' : 'products'} found</span>
            </div>
          `;
          searchStatus.style.display = 'block';
        } else {
          searchStatus.style.display = 'none';
        }
      }

      // Clear all filters
      function clearAllFilters() {
        const searchInput = document.getElementById('product-search');
        const clearButton = document.getElementById('clear-search');
        
        if (searchInput) {
          searchInput.value = '';
        }
        if (clearButton) {
          clearButton.style.display = 'none';
        }
        
        currentFilters = {
          category: 'all',
          brand: '',
          search: '',
          minPrice: 0,
          maxPrice: null,
          sortBy: 'id',
          sortOrder: 'DESC'
        };
        currentPage = 1;
        
        // Update active class in sidebar
        document.querySelectorAll('.category-list a').forEach(link => {
          link.classList.remove('active');
          if (link.getAttribute('data-category') === 'all') {
            link.classList.add('active');
          }
        });
        
        loadProducts();
      }

      // Utility function to capitalize first letter
      function capitalizeFirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
      }

      function filterByBrand(brand) {
        const searchInput = document.getElementById('product-search');
        if (searchInput) {
          searchInput.value = brand;
        }
        currentFilters.search = brand;
        currentFilters.category = 'all';
        currentFilters.brand = '';
        currentPage = 1;
        loadProducts();
      }

      function filterProducts(category) {
        filterByCategory(category);
      }

      // Navigate to product details page
      function navigateToProduct(productId, event) {
        // Don't navigate if user clicked on a button or link
        if (event && (event.target.tagName === 'BUTTON' || event.target.tagName === 'A' || event.target.closest('button') || event.target.closest('a'))) {
          return;
        }
        
        window.location.href = `product-details.php?id=${productId}`;
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
