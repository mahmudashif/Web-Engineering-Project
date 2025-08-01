// Function to load CSS file dynamically
function loadCSS(href) {
  const link = document.createElement('link');
  link.rel = 'stylesheet';
  link.href = href;
  document.head.appendChild(link);
}

// Function to load shared components
async function loadSharedComponents() {
  try {
    // Load CSS files
    loadCSS('/shared/navbar.css');
    loadCSS('/shared/footer.css');

    // Load navbar
    const navbarResponse = await fetch('/shared/navbar.html');
    const navbarHtml = await navbarResponse.text();
    document.getElementById('navbar-placeholder').innerHTML = navbarHtml;

    // Load footer
    const footerResponse = await fetch('/shared/footer.html');
    const footerHtml = await footerResponse.text();
    document.getElementById('footer-placeholder').innerHTML = footerHtml;

    // Set active navigation state
    setActiveNavigation();
    
    // Initialize mobile menu functionality
    initializeMobileMenu();
  } catch (error) {
    console.error('Error loading shared components:', error);
  }
}

// Function to set active navigation based on current page
function setActiveNavigation() {
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  
  // Remove active class from all nav items
  const navItems = document.querySelectorAll('.nav_item a');
  navItems.forEach(item => item.classList.remove('active'));

  // Add active class to current page nav item
  let activeNavId = '';
  switch (currentPage) {
    case 'index.html':
    case '':
      activeNavId = 'nav-home';
      break;
    case 'shop.html':
      activeNavId = 'nav-shop';
      break;
    case 'about.html':
      activeNavId = 'nav-about';
      break;
    case 'contact.html':
      activeNavId = 'nav-contact';
      break;
    case 'journal.html':
      activeNavId = 'nav-journal';
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

// Load components when DOM is ready
document.addEventListener('DOMContentLoaded', loadSharedComponents);

// Handle window resize
window.addEventListener('resize', handleResize);
