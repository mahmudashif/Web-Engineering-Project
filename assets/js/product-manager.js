// Product Management System
class ProductManager {
    constructor() {
        this.apiBase = '../../../api/admin/products';
        this.currentPage = 1;
        this.itemsPerPage = 10;
        this.totalPages = 1;
        this.searchQuery = '';
        this.selectedCategory = '';
        this.products = [];
        this.categories = [];
        this.isLoading = false;
        this.editingProduct = null;
        
        this.init();
    }
    
    async init() {
        try {
            await this.loadCategories();
            await this.loadProducts();
            this.setupEventListeners();
            this.renderCategoryFilter();
        } catch (error) {
            console.error('Initialization failed:', error);
            this.showError('Failed to initialize product manager');
        }
    }
    
    setupEventListeners() {
        // Search functionality
        const searchInput = document.getElementById('searchProducts');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.searchQuery = e.target.value;
                this.currentPage = 1;
                this.debounce(() => this.loadProducts(), 300)();
            });
        }
        
        // Category filter
        const categoryFilter = document.getElementById('categoryFilter');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', (e) => {
                this.selectedCategory = e.target.value;
                this.currentPage = 1;
                this.loadProducts();
            });
        }
        
        // Add product modal
        const addProductBtn = document.getElementById('addProductBtn');
        if (addProductBtn) {
            addProductBtn.addEventListener('click', () => this.openAddProductModal());
        }
        
        // Add category modal
        const addCategoryBtn = document.getElementById('addCategoryBtn');
        if (addCategoryBtn) {
            addCategoryBtn.addEventListener('click', () => this.openAddCategoryModal());
        }
        
        // Modal close buttons
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal') || e.target.classList.contains('close-modal')) {
                this.closeModals();
            }
        });
        
        // Form submissions
        const productForm = document.getElementById('productForm');
        if (productForm) {
            productForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleProductSubmit();
            });
        }
        
        const categoryForm = document.getElementById('categoryForm');
        if (categoryForm) {
            categoryForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleCategorySubmit();
            });
        }
        
        // Image upload preview
        const imageInput = document.getElementById('productImage');
        if (imageInput) {
            imageInput.addEventListener('change', (e) => this.previewImage(e));
        }
    }
    
    debounce(func, wait) {
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
    
    async loadProducts() {
        if (this.isLoading) return;
        
        this.isLoading = true;
        this.showLoading();
        
        try {
            const params = new URLSearchParams({
                page: this.currentPage,
                limit: this.itemsPerPage
            });
            
            if (this.searchQuery) {
                params.append('search', this.searchQuery);
            }
            
            if (this.selectedCategory) {
                params.append('category', this.selectedCategory);
            }
            
            const response = await fetch(`${this.apiBase}/get-products.php?${params}`);
            const data = await response.json();
            
            if (data.success) {
                this.products = data.data;
                this.totalPages = data.pagination.total_pages;
                this.renderProducts();
                this.renderPagination(data.pagination);
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Failed to load products:', error);
            this.showError('Failed to load products');
        } finally {
            this.isLoading = false;
            this.hideLoading();
        }
    }
    
    async loadCategories() {
        try {
            const response = await fetch(`${this.apiBase}/get-categories.php`);
            const data = await response.json();
            
            if (data.success) {
                this.categories = data.data;
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Failed to load categories:', error);
            this.categories = [];
        }
    }
    
    renderProducts() {
        const container = document.getElementById('productsContainer');
        if (!container) return;
        
        if (this.products.length === 0) {
            container.innerHTML = `
                <div class="no-data">
                    <p>No products found.</p>
                    ${this.searchQuery || this.selectedCategory ? '<p>Try adjusting your filters.</p>' : ''}
                </div>
            `;
            return;
        }
        
        const html = this.products.map(product => `
            <div class="product-card" data-id="${product.id}">
                <div class="product-image">
                    ${product.image ? 
                        `<img src="../../${product.image}" alt="${product.name}" onerror="this.src='../../assets/images/placeholder.svg'">` :
                        `<div class="placeholder-image">No Image</div>`
                    }
                </div>
                <div class="product-info">
                    <h3 class="product-name">${this.escapeHtml(product.name)}</h3>
                    <p class="product-description">${this.escapeHtml(product.description || '')}</p>
                    <div class="product-details">
                        <span class="product-price">$${parseFloat(product.price).toFixed(2)}</span>
                        <span class="product-stock">Stock: ${product.stock_quantity}</span>
                        ${product.category_name ? `<span class="product-category">${this.escapeHtml(product.category_name)}</span>` : ''}
                    </div>
                    <div class="product-actions">
                        <button class="btn btn-secondary btn-sm" onclick="productManager.editProduct(${product.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="productManager.deleteProduct(${product.id})">Delete</button>
                    </div>
                </div>
            </div>
        `).join('');
        
        container.innerHTML = html;
    }
    
    renderCategoryFilter() {
        const select = document.getElementById('categoryFilter');
        if (!select) return;
        
        const options = [
            '<option value="">All Categories</option>',
            ...this.categories.map(cat => 
                `<option value="${cat.id}" ${this.selectedCategory == cat.id ? 'selected' : ''}>
                    ${this.escapeHtml(cat.name)} (${cat.product_count})
                </option>`
            )
        ];
        
        select.innerHTML = options.join('');
    }
    
    renderPagination(pagination) {
        const container = document.getElementById('paginationContainer');
        if (!container) return;
        
        let html = '<div class="pagination">';
        
        // Previous button
        if (pagination.has_prev) {
            html += `<button class="btn btn-secondary" onclick="productManager.goToPage(${pagination.current_page - 1})">Previous</button>`;
        }
        
        // Page numbers
        const startPage = Math.max(1, pagination.current_page - 2);
        const endPage = Math.min(pagination.total_pages, pagination.current_page + 2);
        
        for (let i = startPage; i <= endPage; i++) {
            const isActive = i === pagination.current_page ? 'active' : '';
            html += `<button class="btn btn-secondary ${isActive}" onclick="productManager.goToPage(${i})">${i}</button>`;
        }
        
        // Next button
        if (pagination.has_next) {
            html += `<button class="btn btn-secondary" onclick="productManager.goToPage(${pagination.current_page + 1})">Next</button>`;
        }
        
        html += '</div>';
        html += `<div class="pagination-info">Showing ${pagination.per_page * (pagination.current_page - 1) + 1} to ${Math.min(pagination.per_page * pagination.current_page, pagination.total_records)} of ${pagination.total_records} products</div>`;
        
        container.innerHTML = html;
    }
    
    goToPage(page) {
        this.currentPage = page;
        this.loadProducts();
    }
    
    openAddProductModal() {
        this.editingProduct = null;
        const modal = document.getElementById('productModal');
        const form = document.getElementById('productForm');
        const title = document.getElementById('productModalTitle');
        
        if (title) title.textContent = 'Add New Product';
        if (form) form.reset();
        
        // Populate category dropdown
        this.populateCategoryDropdown();
        
        // Clear image preview
        this.clearImagePreview();
        
        if (modal) modal.style.display = 'flex';
    }
    
    editProduct(productId) {
        const product = this.products.find(p => p.id === productId);
        if (!product) return;
        
        this.editingProduct = product;
        const modal = document.getElementById('productModal');
        const form = document.getElementById('productForm');
        const title = document.getElementById('productModalTitle');
        
        if (title) title.textContent = 'Edit Product';
        
        // Populate form
        if (form) {
            form.productName.value = product.name;
            form.productDescription.value = product.description || '';
            form.productPrice.value = product.price;
            form.productStock.value = product.stock_quantity;
        }
        
        // Populate category dropdown first, then set the selected value
        this.populateCategoryDropdown(product.category_id);
        
        // Set the selected category after dropdown is populated
        setTimeout(() => {
            const categorySelect = document.getElementById('productCategory');
            if (categorySelect && product.category_id) {
                categorySelect.value = product.category_id;
            }
        }, 100);
        
        // Show current image if exists
        if (product.image) {
            this.showImagePreview(`../../${product.image}`);
        } else {
            this.clearImagePreview();
        }
        
        if (modal) modal.style.display = 'flex';
    }
    
    async deleteProduct(productId) {
        const product = this.products.find(p => p.id === productId);
        if (!product) return;
        
        if (!confirm(`Are you sure you want to delete "${product.name}"?`)) {
            return;
        }
        
        try {
            const response = await fetch(`${this.apiBase}/delete-product.php?id=${productId}`, {
                method: 'DELETE'
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.showSuccess('Product deleted successfully');
                await this.loadProducts();
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Failed to delete product:', error);
            this.showError(error.message || 'Failed to delete product');
        }
    }
    
    async updateProductImage(productId, imagePath) {
        try {
            const response = await fetch(`${this.apiBase}/update-product-simple.php?id=${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    image: imagePath
                })
            });
            
            const data = await response.json();
            if (!data.success) {
                throw new Error(data.message);
            }
            
            return data;
        } catch (error) {
            console.error('Failed to update product image:', error);
            throw error;
        }
    }
    
    populateCategoryDropdown(selectedValue = null) {
        const select = document.getElementById('productCategory');
        if (!select) return;
        
        const options = [
            '<option value="">Select Category</option>',
            ...this.categories.map(cat => 
                `<option value="${cat.id}" ${selectedValue == cat.id ? 'selected' : ''}>
                    ${this.escapeHtml(cat.name)}
                </option>`
            )
        ];
        
        select.innerHTML = options.join('');
        
        // If selectedValue is provided, set it
        if (selectedValue) {
            select.value = selectedValue;
        }
    }
    
    async handleProductSubmit() {
        const form = document.getElementById('productForm');
        if (!form) return;

        const formData = new FormData();
        formData.append('name', form.productName.value.trim());
        formData.append('description', form.productDescription.value.trim());
        formData.append('price', form.productPrice.value);
        formData.append('stock_quantity', form.productStock.value);
        
        // Handle category - use empty string if no category selected
        const categoryValue = form.productCategory.value;
        formData.append('category_id', categoryValue);

        // Add image if selected
        const imageFile = form.productImage.files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }        try {
            let url, method, body, headers = {};
            
            if (this.editingProduct) {
                // Handle image upload first if there's a new image
                if (imageFile) {
                    try {
                        // Upload image first
                        const imageFormData = new FormData();
                        imageFormData.append('image', imageFile);
                        imageFormData.append('product_id', this.editingProduct.id);
                        
                        const imageResponse = await fetch(`${this.apiBase}/upload-image.php`, {
                            method: 'POST',
                            body: imageFormData
                        });
                        
                        if (!imageResponse.ok) {
                            throw new Error(`Image upload failed: ${imageResponse.status}`);
                        }
                        
                        const imageResult = JSON.parse(await imageResponse.text());
                        if (!imageResult.success) {
                            throw new Error(imageResult.message);
                        }
                        
                        // Update the product with the new image path
                        await this.updateProductImage(this.editingProduct.id, imageResult.data.path);
                        
                    } catch (imageError) {
                        console.error('Image upload error:', imageError);
                        this.showError('Failed to upload image: ' + imageError.message);
                        return;
                    }
                }
                
                // Update other product fields
                url = `${this.apiBase}/update-product-simple.php?id=${this.editingProduct.id}`;
                method = 'PUT';
                
                // Convert FormData to JSON for PUT request
                const data = {};
                for (let [key, value] of formData.entries()) {
                    if (key !== 'image') {
                        data[key] = value;
                    }
                }
                
                headers['Content-Type'] = 'application/json';
                body = JSON.stringify(data);
            } else {
                // For new products, use POST with FormData
                url = `${this.apiBase}/add-product-simple.php`;
                method = 'POST';
                body = formData;
                // Don't set Content-Type for FormData - let browser set it with boundary
            }
            
            console.log('Submitting to:', url, 'Method:', method);
            
            const response = await fetch(url, {
                method: method,
                headers: headers,
                body: body
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const responseText = await response.text();
            
            let result;
            try {
                result = JSON.parse(responseText);
            } catch (parseError) {
                console.error('JSON parse error:', parseError);
                console.error('Response text:', responseText);
                throw new Error('Server returned invalid response. Please check the console for details.');
            }
            
            if (result.success) {
                if (this.editingProduct) {
                    this.showSuccess('Product updated successfully');
                } else {
                    this.showSuccess('Product added successfully');
                    await this.loadCategories(); // Refresh categories in case a new one was created
                    this.renderCategoryFilter();
                }
                this.closeModals();
                await this.loadProducts();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Failed to save product:', error);
            this.showError(error.message || 'Failed to save product');
        }
    }
    
    openAddCategoryModal() {
        const modal = document.getElementById('categoryModal');
        const form = document.getElementById('categoryForm');
        
        if (form) form.reset();
        if (modal) modal.style.display = 'flex';
    }
    
    async handleCategorySubmit() {
        const form = document.getElementById('categoryForm');
        if (!form) return;
        
        const data = {
            name: form.categoryName.value.trim(),
            description: form.categoryDescription.value.trim()
        };
        
        try {
            const response = await fetch(`${this.apiBase}/add-category.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showSuccess('Category added successfully');
                this.closeModals();
                await this.loadCategories();
                this.renderCategoryFilter();
                this.populateCategoryDropdown();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Failed to add category:', error);
            this.showError(error.message || 'Failed to add category');
        }
    }
    
    previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => this.showImagePreview(e.target.result);
            reader.readAsDataURL(file);
        } else {
            this.clearImagePreview();
        }
    }
    
    showImagePreview(src) {
        const preview = document.getElementById('imagePreview');
        if (preview) {
            preview.innerHTML = `<img src="${src}" alt="Preview" style="max-width: 200px; max-height: 200px;">`;
        }
    }
    
    clearImagePreview() {
        const preview = document.getElementById('imagePreview');
        if (preview) {
            preview.innerHTML = '<div class="preview-placeholder">No image selected</div>';
        }
    }
    
    closeModals() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.style.display = 'none';
        });
        
        this.editingProduct = null;
        this.clearImagePreview();
    }
    
    showLoading() {
        const container = document.getElementById('productsContainer');
        if (container) {
            container.innerHTML = '<div class="loading">Loading products...</div>';
        }
    }
    
    hideLoading() {
        // Loading will be hidden when products are rendered
    }
    
    showSuccess(message) {
        this.showNotification(message, 'success');
    }
    
    showError(message) {
        this.showNotification(message, 'error');
    }
    
    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
        
        // Allow manual close
        notification.addEventListener('click', () => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        });
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.productManager = new ProductManager();
});
