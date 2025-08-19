// Function to get the correct base path based on current page location
function getBasePath() {
  const path = window.location.pathname;
  const depth = (path.match(/\//g) || []).length - 1;
  
  if (path.includes('/pages/legal/') || path.includes('/pages/auth/')) {
    return '../../';
  } else if (path.includes('/pages/') || path.includes('/components/') || path.includes('/error/')) {
    return '../';
  } else {
    return '';
  }
}

// Function to load CSS file dynamically
function loadCSS(href) {
  const link = document.createElement('link');
  link.rel = 'stylesheet';
  link.href = getBasePath() + href;
  document.head.appendChild(link);
}

// Function to load JavaScript file dynamically
function loadJS(src) {
  const script = document.createElement('script');
  script.src = getBasePath() + src;
  document.head.appendChild(script);
}

// Function to load shared components
async function loadSharedComponents() {
  try {
    const basePath = getBasePath();
    
    // Load CSS files
    loadCSS('components/navbar/navbar.css');
    loadCSS('components/footer/footer.css');

    // Load global cart system
    loadJS('components/cart-global.js');
    
    // Load user authentication system
    loadJS('assets/js/user-auth.js');

    // Load navbar
    const navbarResponse = await fetch(basePath + 'components/navbar/navbar.html');
    const navbarHtml = await navbarResponse.text();
    document.getElementById('navbar-placeholder').innerHTML = navbarHtml;

    // Load footer
    const footerResponse = await fetch(basePath + 'components/footer/footer.html');
    const footerHtml = await footerResponse.text();
    document.getElementById('footer-placeholder').innerHTML = footerHtml;

    // Set active navigation state
    setActiveNavigation();
    
    // Set correct navigation links based on current path
    setNavigationLinks();
    
    // Initialize mobile menu functionality
    initializeMobileMenu();
    
    // Initialize user authentication system after navbar is loaded
    if (window.UserAuth) {
      window.userAuth = new window.UserAuth();
    }

    // Initialize navbar search functionality
    initializeNavbarSearch();
  } catch (error) {
    console.error('Error loading shared components:', error);
  }
}

// Function to set active navigation based on current page
function setActiveNavigation() {
  const currentPage = window.location.pathname.split('/').pop() || 'index.php';
  
  // Remove active class from all nav items
  const navItems = document.querySelectorAll('.nav_item a');
  navItems.forEach(item => item.classList.remove('active'));

  // Add active class to current page nav item
  let activeNavId = '';
  switch (currentPage) {
    case 'index.php':
    case '':
      activeNavId = 'nav-home';
      break;
    case 'shop.php':
      activeNavId = 'nav-shop';
      break;
    case 'about.php':
      activeNavId = 'nav-about';
      break;
    case 'contact.php':
      activeNavId = 'nav-contact';
      break;
    default:
      activeNavId = 'nav-home';
  }

  const activeNavElement = document.getElementById(activeNavId);
  if (activeNavElement) {
    activeNavElement.classList.add('active');
  }
}

// Function to initialize mobile menu functionality
function initializeMobileMenu() {
  const mobileToggle = document.querySelector('.mobile_menu_toggle');
  const navMenu = document.querySelector('.nav_menu');
  
  if (mobileToggle && navMenu) {
    mobileToggle.addEventListener('click', function() {
      // Toggle active class on mobile toggle button
      this.classList.toggle('active');
      
      // Toggle active class on nav menu
      navMenu.classList.toggle('active');
    });

    // Close mobile menu when clicking on a nav link
    const navLinks = document.querySelectorAll('.nav_item a');
    navLinks.forEach(link => {
      link.addEventListener('click', function() {
        mobileToggle.classList.remove('active');
        navMenu.classList.remove('active');
      });
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
      const isClickInsideNav = navMenu.contains(event.target) || mobileToggle.contains(event.target);
      
      if (!isClickInsideNav && navMenu.classList.contains('active')) {
        mobileToggle.classList.remove('active');
        navMenu.classList.remove('active');
      }
    });
  }
}

// Handle window resize to ensure mobile menu is properly closed on desktop
function handleResize() {
  const mobileToggle = document.querySelector('.mobile_menu_toggle');
  const navMenu = document.querySelector('.nav_menu');
  
  if (window.innerWidth > 768 && navMenu) {
    navMenu.classList.remove('active');
    if (mobileToggle) {
      mobileToggle.classList.remove('active');
    }
  }
}

// Function to set correct navigation links based on current page location
function setNavigationLinks() {
  const basePath = getBasePath();
  
  // Set home link
  const homeLink = document.getElementById('home-link');
  if (homeLink) {
    homeLink.href = basePath + 'index.php';
  }
  
  // Set main navigation links
  const navHome = document.getElementById('nav-home');
  const navShop = document.getElementById('nav-shop');
  const navAbout = document.getElementById('nav-about');
  const navContact = document.getElementById('nav-contact');
  
  if (navHome) navHome.href = basePath + 'index.php';
  if (navShop) navShop.href = basePath + 'pages/shop.php';
  if (navAbout) navAbout.href = basePath + 'pages/about.php';
  if (navContact) navContact.href = basePath + 'pages/contact.php';
  
  // Set auth links
  const loginLink = document.getElementById('login-link');
  const registerLink = document.getElementById('register-link');
  
  if (loginLink) loginLink.href = basePath + 'pages/auth/login.php';
  if (registerLink) registerLink.href = basePath + 'pages/auth/register.php';
  
  // Set dropdown links
  const shopLink = document.getElementById('shop-link');
  const aboutLink = document.getElementById('about-link');
  
  if (shopLink) shopLink.href = basePath + 'pages/shop.php';
  if (aboutLink) aboutLink.href = basePath + 'pages/about.php';
  
  // Set cart link
  const cartLink = document.getElementById('cart-link');
  if (cartLink) cartLink.href = basePath + 'components/cart/cart.php';
  
  // Set icon sources
  const userIcon = document.getElementById('user-icon');
  const cartIcon = document.getElementById('cart-icon');
  const facebookIcon = document.getElementById('facebook-icon');
  const linkedinIcon = document.getElementById('linkedin-icon');
  const instagramIcon = document.getElementById('instagram-icon');
  
  if (userIcon) userIcon.src = basePath + 'assets/images/homepage/Icon_user.svg';
  if (cartIcon) cartIcon.src = basePath + 'assets/images/homepage/Icon_cart.svg';
  if (facebookIcon) facebookIcon.src = basePath + 'assets/images/homepage/facebook_icon.svg';
  if (linkedinIcon) linkedinIcon.src = basePath + 'assets/images/homepage/linkedin_icon.svg';
  if (instagramIcon) instagramIcon.src = basePath + 'assets/images/homepage/instagram_icon.svg';
  
  // Set footer links
  const footerHome = document.getElementById('footer-home');
  const footerShop = document.getElementById('footer-shop');
  const footerAbout = document.getElementById('footer-about');
  const footerContact = document.getElementById('footer-contact');
  const footerPrivacyPolicy = document.getElementById('footer-privacy-policy');
  const footerTerms = document.getElementById('footer-terms');
  
  if (footerHome) footerHome.href = basePath + 'index.php';
  if (footerShop) footerShop.href = basePath + 'pages/shop.php';
  if (footerAbout) footerAbout.href = basePath + 'pages/about.php';
  if (footerContact) footerContact.href = basePath + 'pages/contact.php';
  if (footerPrivacyPolicy) footerPrivacyPolicy.href = basePath + 'pages/legal/privacy.php';
  if (footerTerms) footerTerms.href = basePath + 'pages/legal/terms.php';
}
    const siteLogo = document.getElementById('site-logo');
    const footerLogo = document.getElementById('footer-logo');
    const adminLogo = document.getElementById('admin-logo');
    // Set brand logo (shared). Prefer existing src (absolute URL set in HTML); otherwise use local logo path.
    const defaultLogoUrl = 'https://i.ibb.co.com/pjYGFbKr/logo.png';
    if (siteLogo && !siteLogo.src) siteLogo.src = defaultLogoUrl;
    if (footerLogo && !footerLogo.src) footerLogo.src = defaultLogoUrl;
    if (adminLogo && !adminLogo.src) adminLogo.src = defaultLogoUrl;

// Initialize navbar search functionality
function initializeNavbarSearch() {
  const navbarSearchInput = document.querySelector('.nav_search .search_input');
  const navbarSearchButton = document.querySelector('.nav_search .search_button');
  const searchDropdown = document.getElementById('search-dropdown');
  
  if (navbarSearchInput && navbarSearchButton && searchDropdown) {
    let searchTimeout;
    let currentSearchTerm = '';

    // Search on input (enhanced with better debouncing)
    navbarSearchInput.addEventListener('input', function() {
      const searchTerm = this.value.trim();
      
      clearTimeout(searchTimeout);
      
      if (searchTerm.length === 0) {
        hideSearchDropdown();
        currentSearchTerm = '';
        return;
      }
      
      if (searchTerm.length >= 2) {
        // Show loading immediately for better UX
        if (searchTerm !== currentSearchTerm) {
          showSearchDropdown();
          document.querySelector('.search_loading').style.display = 'flex';
          document.getElementById('search-results').innerHTML = '';
        }
        
        searchTimeout = setTimeout(() => {
          currentSearchTerm = searchTerm;
          performSearchDropdown(searchTerm);
        }, 200); // Reduced from 300ms for faster response
      } else {
        hideSearchDropdown();
        currentSearchTerm = '';
      }
    });

    // Enhanced search with enter key - redirect to shop page
    navbarSearchInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        const searchTerm = this.value.trim();
        if (searchTerm) {
          redirectToShopWithSearch(searchTerm);
        }
        hideSearchDropdown();
        this.blur();
      }
    });

    // Search on button click - redirect to shop page
    navbarSearchButton.addEventListener('click', function(e) {
      e.preventDefault();
      const searchTerm = navbarSearchInput.value.trim();
      if (searchTerm) {
        redirectToShopWithSearch(searchTerm);
      }
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
      if (!navbarSearchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
        hideSearchDropdown();
      }
    });

    // Hide dropdown on escape key
    navbarSearchInput.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        hideSearchDropdown();
        this.blur();
      }
    });
  }
}

// Perform search and show dropdown results with improved relevance
async function performSearchDropdown(searchTerm) {
  const searchDropdown = document.getElementById('search-dropdown');
  const searchLoading = document.querySelector('.search_loading');
  const searchResults = document.getElementById('search-results');
  const searchNoResults = document.getElementById('search-no-results');
  const searchViewAll = document.getElementById('search-view-all');
  
  if (!searchDropdown) return;

  // Show dropdown and loading state
  showSearchDropdown();
  searchLoading.style.display = 'flex';
  searchResults.innerHTML = '';
  searchNoResults.style.display = 'none';
  searchViewAll.style.display = 'none';

  try {
    const basePath = getBasePath();
    // Increased limit to 8 for better search results
    const response = await fetch(`${basePath}api/get-products.php?search=${encodeURIComponent(searchTerm)}&limit=8`);
    const data = await response.json();
    
    searchLoading.style.display = 'none';
    
    if (data.success && data.products.length > 0) {
      // Show results with improved relevance sorting
      searchResults.innerHTML = data.products.map(product => createSearchResultItem(product)).join('');
      
      // Show search statistics
      const searchStats = `<div class="search_stats">Found ${data.total} ${data.total === 1 ? 'product' : 'products'} matching "${searchTerm}"</div>`;
      searchResults.insertAdjacentHTML('afterbegin', searchStats);
      
      // Hide "View all results" section as previously requested
      // if (data.total > 8) {
      //   searchViewAll.style.display = 'block';
      //   const viewAllLink = document.getElementById('view-all-results');
      //   if (viewAllLink) {
      //     viewAllLink.href = `${basePath}pages/shop.php?search=${encodeURIComponent(searchTerm)}`;
      //     viewAllLink.textContent = `View all ${data.total} results →`;
      //   }
      // }
    } else {
      // Show enhanced no results message
      searchNoResults.innerHTML = `
        <p>No products found for "${searchTerm}"</p>
        <small>Try different keywords or check spelling</small>
      `;
      searchNoResults.style.display = 'block';
    }
  } catch (error) {
    console.error('Search error:', error);
    searchLoading.style.display = 'none';
    searchNoResults.innerHTML = `
      <p>Search temporarily unavailable</p>
      <small>Please try again in a moment</small>
    `;
    searchNoResults.style.display = 'block';
  }
}

// Create search result item HTML with search term highlighting
function createSearchResultItem(product) {
  const basePath = getBasePath();
  const imageUrl = product.image_url 
    ? product.image_url.replace('../', basePath)
    : `${basePath}assets/images/placeholder-product.svg`;
  
  // Get current search term for highlighting
  const currentSearch = document.querySelector('.search_input').value.trim();
  const highlightedName = highlightSearchTerm(product.name, currentSearch);
  
  return `
    <a href="${basePath}pages/product-details.php?id=${product.id}" class="search_result_item">
      <div class="search_result_image ${!product.image_url ? 'placeholder' : ''}">
        ${product.image_url 
          ? `<img src="${imageUrl}" alt="${product.name}" onerror="this.style.display='none'; this.parentElement.innerHTML='📦'; this.parentElement.classList.add('placeholder');">`
          : '📦'
        }
      </div>
      <div class="search_result_info">
        <div class="search_result_name">${highlightedName}</div>
        <div class="search_result_details">
          <span class="search_result_brand">${escapeHtml(product.brand || 'Unknown')}</span>
          <span class="search_result_price">${product.formatted_price}</span>
        </div>
      </div>
    </a>
  `;
}

// Highlight search term in text
function highlightSearchTerm(text, searchTerm) {
  if (!searchTerm || searchTerm.length < 2) return escapeHtml(text);
  
  const escapedText = escapeHtml(text);
  const escapedSearchTerm = escapeHtml(searchTerm);
  
  // Create a case-insensitive regex to find the search term
  const regex = new RegExp(`(${escapedSearchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
  
  return escapedText.replace(regex, '<mark class="search_highlight">$1</mark>');
}

// Show search dropdown
function showSearchDropdown() {
  const searchDropdown = document.getElementById('search-dropdown');
  if (searchDropdown) {
    searchDropdown.style.display = 'block';
  }
}

// Hide search dropdown
function hideSearchDropdown() {
  const searchDropdown = document.getElementById('search-dropdown');
  if (searchDropdown) {
    searchDropdown.style.display = 'none';
  }
}

// Redirect to shop page with search
function redirectToShopWithSearch(searchTerm) {
  const basePath = getBasePath();
  window.location.href = `${basePath}pages/shop.php?search=${encodeURIComponent(searchTerm)}`;
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
  return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
}

// Perform navbar search (legacy function)
function performNavbarSearch() {
  const navbarSearchInput = document.querySelector('.nav_search .search_input');
  if (!navbarSearchInput) return;

  const searchTerm = navbarSearchInput.value.trim();
  if (!searchTerm) return;

  redirectToShopWithSearch(searchTerm);
}

// Load components when DOM is ready
document.addEventListener('DOMContentLoaded', loadSharedComponents);

// Handle window resize
window.addEventListener('resize', handleResize);
