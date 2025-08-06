# Web Engineering Project - Organized Structure

## Folder Organization

### Root Level
- `index.php` - Main homepage (remains at root for easy access)

### Assets (`/assets/`)
- `css/` - All CSS stylesheets
  - `style.css` - Global styles
  - `index.css` - Homepage specific styles
  - `shop.css`, `about.css`, `contact.css`, `journal.css` - Page specific styles
  - `auth.css` - Authentication pages styles
  - `error404.css` - Error page styles
  - `shop-nav.css` - Shop navigation specific styles

- `js/` - All JavaScript files
  - `auth.js` - Authentication functionality
  - `hero-slider.js` - Homepage slider functionality
  - `user-auth.js` - User authentication system

- `images/` - All image assets (organized by purpose)
  - `banner/` - Hero slider images
  - `homepage/` - Homepage specific icons and graphics
  - `logo/` - Brand logos
  - `mini-slider/` - Product slider images

### Pages (`/pages/`)
- `shop.php` - Product catalog page
- `about.php` - About us page
- `contact.php` - Contact information page
- `journal.php` - Blog/journal page

- `auth/` - Authentication related pages
  - `login.php` - User login page
  - `register.php` - User registration page

### Components (`/components/`)
- `components.js` - Main component loader with dynamic path resolution
- `cart-global.js` - Global cart functionality

- `navbar/` - Navigation component
  - `navbar.html` - Navigation HTML structure
  - `navbar.css` - Navigation styles

- `footer/` - Footer component
  - `footer.html` - Footer HTML structure
  - `footer.css` - Footer styles

- `cart/` - Shopping cart component
  - `cart.php` - Cart page
  - `cart.css` - Cart styles
  - `cart.js` - Cart functionality

### Error Pages (`/error/`)
- `404.php` - Page not found error page

### Configuration (`/config/`, `/database/`, `/includes/`)
- These directories are preserved for backend configuration and database files

## Path Resolution

The project now uses a smart path resolution system in `components/components.js` that automatically detects the current page location and adjusts all paths accordingly:

- **Root level** (index.php): Uses direct paths
- **Pages level** (/pages/): Uses `../` prefix
- **Auth level** (/pages/auth/): Uses `../../` prefix
- **Components level** (/components/): Uses `../` prefix
- **Error level** (/error/): Uses `../` prefix

## Benefits of This Organization

1. **Clear Separation of Concerns**: Assets, pages, and components are logically separated
2. **Scalability**: Easy to add new pages, components, or assets
3. **Maintainability**: Related files are grouped together
4. **Dynamic Path Resolution**: Works correctly from any directory level
5. **Standard Structure**: Follows common web development practices

## File Path Updates Made

All files have been updated with correct relative paths:
- CSS and JS imports updated in all PHP files
- Image paths updated throughout the project
- Navigation links use dynamic path resolution
- Component loading system updated for new structure

The design and functionality remain exactly the same - only the organization has been improved!
