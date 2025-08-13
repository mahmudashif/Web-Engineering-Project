# Product Management System

## Overview
The Product Management System is a comprehensive admin interface for managing products and categories in your e-commerce website. It provides full CRUD (Create, Read, Update, Delete) operations with a modern, responsive design.

## Features

### Product Management
- ✅ View all products with pagination
- ✅ Add new products with images
- ✅ Edit existing products
- ✅ Delete products (with safety checks)
- ✅ Search products by name, description, or category
- ✅ Filter products by category
- ✅ Image upload with validation
- ✅ Stock quantity tracking
- ✅ Price management

### Category Management
- ✅ View all categories with product counts
- ✅ Add new categories
- ✅ Automatic category assignment
- ✅ Category filtering

### User Interface
- ✅ Modern, responsive design
- ✅ Real-time search and filtering
- ✅ Modal-based forms
- ✅ Image preview functionality
- ✅ Success/error notifications
- ✅ Loading states and pagination

## API Endpoints

### Products
- `GET /api/admin/products/get-products.php` - List products with pagination and filters
- `POST /api/admin/products/add-product.php` - Add new product
- `PUT /api/admin/products/update-product.php?id={id}` - Update existing product
- `DELETE /api/admin/products/delete-product.php?id={id}` - Delete product

### Categories
- `GET /api/admin/products/get-categories.php` - List all categories
- `POST /api/admin/products/add-category.php` - Add new category

### Image Upload
- `POST /api/admin/products/upload-image.php` - Upload product image

## Database Schema

### Products Table
```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT DEFAULT 0,
    image VARCHAR(255),
    category VARCHAR(100),          -- Legacy field
    category_id INT,                -- Foreign key to product_categories
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Product Categories Table
```sql
CREATE TABLE product_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Usage Instructions

### Accessing the System
1. Login as an admin user
2. Navigate to Admin Dashboard → Products
3. The product management interface will load automatically

### Adding Products
1. Click the "Add Product" button
2. Fill in the required fields:
   - Product Name (required)
   - Description (optional)
   - Price (required)
   - Stock Quantity
   - Category
   - Product Image
3. Click "Save Product"

### Managing Categories
1. Click the "Add Category" button
2. Enter category name and description
3. Categories will be automatically available for product assignment

### Searching and Filtering
- Use the search box to find products by name, description, or category
- Use the category dropdown to filter by specific categories
- Results update automatically as you type

### Image Upload
- Supported formats: JPEG, PNG, GIF
- Maximum file size: 5MB
- Images are automatically resized and optimized
- Preview available before saving

## File Structure
```
api/admin/products/
├── get-products.php      # List products with pagination
├── add-product.php       # Add new product
├── update-product.php    # Update existing product
├── delete-product.php    # Delete product
├── get-categories.php    # List categories
├── add-category.php      # Add new category
└── upload-image.php      # Upload product images

assets/
├── css/
│   └── product-management.css  # Styles for the interface
├── js/
│   └── product-manager.js      # JavaScript functionality
└── uploads/products/           # Product image storage

pages/admin/
└── products.php                # Main admin interface
```

## Security Features
- Admin authentication required for all operations
- SQL injection protection with prepared statements
- File upload validation and sanitization
- CSRF protection through session management
- Input validation and sanitization

## Sample Data
The system comes with sample products across different categories:
- Electronics (Sony WH-1000XM5)
- Mobile Phones (iPhone 15 Pro, Samsung Galaxy S24)
- Computers (MacBook Air M2, Dell XPS 13)
- Accessories (Apple Watch Series 9)

## Technical Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Modern web browser for admin interface

## Browser Support
- Chrome 80+
- Firefox 75+
- Safari 13+
- Edge 80+

## Responsive Design
The interface is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile phones

## Error Handling
- User-friendly error messages
- Graceful degradation for network issues
- Input validation feedback
- Image upload error handling

## Performance Features
- Efficient pagination to handle large product catalogs
- Optimized database queries with proper indexing
- Image compression and optimization
- Lazy loading for better performance

## Future Enhancements
- Bulk product operations
- Product import/export
- Advanced inventory management
- Product variants support
- SEO optimization fields
- Product reviews management
