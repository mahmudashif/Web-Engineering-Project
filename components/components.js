// Function to get the correct base path based on current page location
function getBasePath() {
  const path = window.location.pathname;
  const depth = (path.match(/\//g) || []).length - 1;
  
  if (path.includes('/pages/auth/')) {
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
  
  if (footerHome) footerHome.href = basePath + 'index.php';
  if (footerShop) footerShop.href = basePath + 'pages/shop.php';
  if (footerAbout) footerAbout.href = basePath + 'pages/about.php';
  if (footerContact) footerContact.href = basePath + 'pages/contact.php';
}
    const siteLogo = document.getElementById('site-logo');
    const footerLogo = document.getElementById('footer-logo');
    const adminLogo = document.getElementById('admin-logo');
    // Set brand logo (shared). Prefer existing src (absolute URL set in HTML); otherwise use local logo path.
    const defaultLogoUrl = 'https://i.ibb.co.com/pjYGFbKr/logo.png';
    if (siteLogo && !siteLogo.src) siteLogo.src = defaultLogoUrl;
    if (footerLogo && !footerLogo.src) footerLogo.src = defaultLogoUrl;
    if (adminLogo && !adminLogo.src) adminLogo.src = defaultLogoUrl;

// Load components when DOM is ready
document.addEventListener('DOMContentLoaded', loadSharedComponents);

// Handle window resize
window.addEventListener('resize', handleResize);
