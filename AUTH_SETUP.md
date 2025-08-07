# Authentication System Setup

This guide will help you set up the database connection and authentication system for your Gadget Shop project.

## Prerequisites

- PHP 8.0 or higher
- MySQL/MariaDB server
- Web server (Apache/Nginx) or PHP development server

## Database Setup

1. **Create Database:**
   ```sql
   CREATE DATABASE gadegt_shop;
   ```

2. **Configure Database Connection:**
   - Open `config/database.php`
   - Update the database credentials if needed:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "gadegt_shop";
     ```

3. **Run Database Setup:**
   - Visit: `http://your-domain/database/index.php`
   - This will create the users table automatically

## Features Implemented

### 1. Database Configuration
- **File:** `config/database.php`
- Secure MySQL connection with error handling
- Connection reuse function

### 2. User Table Structure
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active TINYINT(1) DEFAULT 1,
    last_login TIMESTAMP NULL,
    INDEX idx_email (email),
    INDEX idx_active (is_active)
);
```

### 3. Authentication API Endpoints

#### Registration: `/api/register.php`
- **Method:** POST
- **Fields:** name, email, password, confirm_password
- **Response:** JSON with success/error status
- **Features:**
  - Email validation
  - Password hashing (PHP password_hash)
  - Duplicate email check
  - Session creation on success

#### Login: `/api/login.php`
- **Method:** POST
- **Fields:** email, password
- **Response:** JSON with success/error status
- **Features:**
  - Email/password verification
  - Password verification (PHP password_verify)
  - Last login timestamp update
  - Session creation on success

#### Logout: `/api/logout.php`
- **Method:** POST
- **Response:** JSON confirmation
- Session destruction

#### Check Authentication: `/api/check-auth.php`
- **Method:** GET
- **Response:** Current user info or authentication status

### 4. Frontend Integration
- **File:** `assets/js/auth.js`
- AJAX form submissions
- Real-time validation
- User feedback messages
- Loading states

### 5. Session Management
- **File:** `includes/auth.php`
- Helper functions for authentication checks
- User session utilities

## Usage

### 1. Registration
1. Go to `/pages/auth/register.php`
2. Fill in the form:
   - Full Name
   - Email Address
   - Password (minimum 6 characters)
   - Confirm Password
3. Accept terms and conditions
4. Click "Create Account"

### 2. Login
1. Go to `/pages/auth/login.php`
2. Enter email and password
3. Click "Sign In"

### 3. Authentication Check
To check if a user is logged in on any page:
```php
<?php
require_once 'includes/auth.php';

if (isLoggedIn()) {
    $user = getCurrentUser();
    echo "Welcome, " . $user['name'];
} else {
    echo "Please log in";
}
?>
```

### 4. Protect Pages
To require authentication for a page:
```php
<?php
require_once 'includes/auth.php';
requireAuth(); // Redirects to login if not authenticated
?>
```

## Security Features

1. **Password Security:**
   - Passwords are hashed using PHP's `password_hash()` function
   - Verification using `password_verify()`

2. **Input Validation:**
   - Email format validation
   - Required field checks
   - Password strength requirements

3. **SQL Injection Prevention:**
   - Prepared statements for all database queries

4. **Session Security:**
   - Secure session management
   - Proper session destruction on logout

## Testing

1. **Start Development Server:**
   ```bash
   php -S localhost:8000
   ```

2. **Test Database Setup:**
   - Visit: `http://localhost:8000/database/index.php`
   - Verify table creation

3. **Test Registration:**
   - Visit: `http://localhost:8000/pages/auth/register.php`
   - Create a test account

4. **Test Login:**
   - Visit: `http://localhost:8000/pages/auth/login.php`
   - Login with test account

## Troubleshooting

### Database Connection Issues
1. Check MySQL service is running
2. Verify database credentials in `config/database.php`
3. Ensure database `gadegt_shop` exists

### Registration/Login Not Working
1. Check browser console for JavaScript errors
2. Verify API endpoints are accessible
3. Check PHP error logs

### Session Issues
1. Ensure session.save_path is writable
2. Check session configuration in php.ini

## File Structure
```
├── api/
│   ├── check-auth.php      # Authentication status check
│   ├── login.php           # Login endpoint
│   ├── logout.php          # Logout endpoint
│   └── register.php        # Registration endpoint
├── config/
│   └── database.php        # Database configuration
├── database/
│   ├── index.php          # Database setup page
│   └── setup.php          # Table creation script
├── includes/
│   └── auth.php           # Authentication helpers
├── pages/auth/
│   ├── login.php          # Login form page
│   └── register.php       # Registration form page
└── assets/js/
    └── auth.js            # Frontend authentication logic
```

## Next Steps

1. ✅ Database connection established
2. ✅ Users table created
3. ✅ Registration system implemented
4. ✅ Login system implemented
5. ✅ Session management added
6. 🔄 Test the complete authentication flow
7. 📝 Add user profile management (optional)
8. 📝 Add password reset functionality (optional)
9. 📝 Add email verification (optional)

The authentication system is now ready for use!
