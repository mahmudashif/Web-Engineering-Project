// Admin dashboard specific components and utilities
class AdminComponents {
    constructor() {
        this.init();
    }

    init() {
        // Load navbar and footer placeholders
        this.loadPlaceholders();
        
        // Load the actual components
        this.loadComponents();
    }

    loadPlaceholders() {
        // Create footer container if it doesn't exist
        if (!document.getElementById('footer-placeholder')) {
            const footerContainer = document.getElementById('footer-container');
            if (footerContainer) {
                const footerPlaceholder = document.createElement('div');
                footerPlaceholder.id = 'footer-placeholder';
                footerContainer.appendChild(footerPlaceholder);
            }
        }
    }

    loadComponents() {
        // Load CSS files directly
        this.loadCSS('../../components/footer/footer.css');
        this.loadCSS('../../assets/css/style.css');  // Make sure the main styles are loaded
        
        // Load JS files directly
        this.loadJS('../../assets/js/user-auth.js', () => {
            // Initialize UserAuth after script is loaded
            if (window.UserAuth) {
                window.userAuth = new window.UserAuth();
                console.log('UserAuth initialized successfully');
            } else {
                console.error('UserAuth failed to initialize');
            }
        });
        
        // Remove navbar placeholder since we're not using it
        const navbarPlaceholder = document.getElementById('navbar-placeholder');
        if (navbarPlaceholder) {
            navbarPlaceholder.remove();
        }
        
        // Load footer content
        this.loadHTML('../../components/footer/footer.html', 'footer-placeholder');
    }

    loadCSS(href) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = href;
        document.head.appendChild(link);
    }

    loadJS(src, callback) {
        const script = document.createElement('script');
        script.src = src;
        
        if (callback) {
            script.onload = callback;
        }
        
        document.body.appendChild(script);
    }

    loadHTML(url, targetId, callback = null) {
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Failed to load ${url}: ${response.status}`);
                }
                return response.text();
            })
            .then(html => {
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    targetElement.innerHTML = html;
                    
                    // Execute callback if provided
                    if (callback && typeof callback === 'function') {
                        callback();
                    }
                }
            })
            .catch(error => {
                console.error(`Error loading component: ${error}`);
            });
    }
}

// Initialize on page load
window.adminComponents = new AdminComponents();
