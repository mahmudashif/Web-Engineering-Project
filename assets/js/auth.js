// ========== Authentication Form Validation and Enhancement ========== 

// Message display function
function showMessage(message, type = 'info') {
    // Remove existing messages
    const existingMessages = document.querySelectorAll('.auth-message');
    existingMessages.forEach(msg => msg.remove());
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `auth-message auth-message-${type}`;
    messageDiv.textContent = message;
    
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 6px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        max-width: 400px;
        animation: slideIn 0.3s ease-out;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        ${type === 'success' ? 'background-color: #10b981;' : ''}
        ${type === 'error' ? 'background-color: #ef4444;' : ''}
        ${type === 'info' ? 'background-color: #3b82f6;' : ''}
    `;
    
    document.body.appendChild(messageDiv);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        messageDiv.style.animation = 'slideOut 0.3s ease-in forwards';
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 300);
    }, 5000);
}

// Add animation styles
const messageCSS = `
@keyframes slideIn {
    from { 
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
`;

const messageStyle = document.createElement('style');
messageStyle.textContent = messageCSS;
document.head.appendChild(messageStyle);

document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle functionality
    function addPasswordToggle() {
        const passwordInputs = document.querySelectorAll('input[type="password"]');
        
        passwordInputs.forEach(input => {
            // Mark input as having password toggle
            input.setAttribute('data-password-toggle', 'true');
            
            // Create wrapper if it doesn't exist
            let wrapper = input.parentNode;
            if (!wrapper.classList.contains('password-input-wrapper')) {
                wrapper = document.createElement('div');
                wrapper.className = 'password-input-wrapper';
                wrapper.style.cssText = `
                    position: relative;
                    width: 100%;
                `;
                input.parentNode.insertBefore(wrapper, input);
                wrapper.appendChild(input);
            }
            
            const toggleBtn = document.createElement('button');
            toggleBtn.type = 'button';
            toggleBtn.innerHTML = '👁️';
            toggleBtn.className = 'password-toggle-btn';
            toggleBtn.style.cssText = `
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                cursor: pointer;
                font-size: 16px;
                opacity: 0.6;
                transition: opacity 0.3s ease;
                width: 24px;
                height: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10;
            `;
            
            toggleBtn.addEventListener('click', function() {
                if (input.type === 'password') {
                    input.type = 'text';
                    toggleBtn.innerHTML = '🙈';
                } else {
                    input.type = 'password';
                    toggleBtn.innerHTML = '👁️';
                    // Re-add the data attribute when switching back to password
                    input.setAttribute('data-password-toggle', 'true');
                }
            });
            
            toggleBtn.addEventListener('mouseenter', function() {
                toggleBtn.style.opacity = '1';
            });
            
            toggleBtn.addEventListener('mouseleave', function() {
                toggleBtn.style.opacity = '0.6';
            });
            
            wrapper.appendChild(toggleBtn);
        });
    }
    
    // Real-time validation for register form
    function setupRegisterValidation() {
        const form = document.querySelector('.auth-form');
        if (!form) return;
        
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm-password');
        const termsCheckbox = document.getElementById('terms');
        
        // Email validation
        if (emailInput) {
            emailInput.addEventListener('blur', function() {
                const email = this.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (email && !emailRegex.test(email)) {
                    this.classList.add('error');
                    this.classList.remove('success');
                } else if (email) {
                    this.classList.add('success');
                    this.classList.remove('error');
                } else {
                    this.classList.remove('error', 'success');
                }
            });
        }
        
        // Password strength validation
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const minLength = password.length >= 8;
                const hasUppercase = /[A-Z]/.test(password);
                const hasLowercase = /[a-z]/.test(password);
                const hasNumber = /\d/.test(password);
                
                if (password && minLength && (hasUppercase || hasLowercase || hasNumber)) {
                    this.classList.add('success');
                    this.classList.remove('error');
                } else if (password) {
                    this.classList.add('error');
                    this.classList.remove('success');
                } else {
                    this.classList.remove('error', 'success');
                }
                
                // Revalidate confirm password if it has a value
                if (confirmPasswordInput && confirmPasswordInput.value) {
                    confirmPasswordInput.dispatchEvent(new Event('blur'));
                }
            });
        }
        
        // Confirm password validation
        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('blur', function() {
                const password = passwordInput ? passwordInput.value : '';
                const confirmPassword = this.value;
                
                if (confirmPassword && password !== confirmPassword) {
                    this.classList.add('error');
                    this.classList.remove('success');
                } else if (confirmPassword && password === confirmPassword) {
                    this.classList.add('success');
                    this.classList.remove('error');
                } else {
                    this.classList.remove('error', 'success');
                }
            });
        }
        
        // Form submission for registration
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            let isValid = true;
            const submitBtn = form.querySelector('.auth-btn.primary');
            
            // Validate all fields
            const requiredInputs = form.querySelectorAll('input[required]');
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('error');
                    isValid = false;
                } else {
                    input.classList.remove('error');
                }
            });
            
            // Check terms checkbox for register page
            if (termsCheckbox && !termsCheckbox.checked) {
                isValid = false;
                termsCheckbox.style.outline = '2px solid var(--accent-red)';
                setTimeout(() => {
                    termsCheckbox.style.outline = '';
                }, 3000);
            }
            
            if (isValid) {
                // Add loading state
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Creating Account...';
                
                try {
                    // Prepare form data
                    const formData = {
                        name: nameInput.value,
                        email: emailInput.value,
                        password: passwordInput.value,
                        confirm_password: confirmPasswordInput.value
                    };
                    
                    // Send registration request
                    const response = await fetch('../../api/register.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(formData)
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok && result.success) {
                        // Registration successful
                        showMessage(result.message || 'Account created successfully!', 'success');
                        
                        // Redirect to home page after successful registration
                        setTimeout(() => {
                            window.location.href = '../../index.php';
                        }, 2000);
                    } else {
                        // Registration failed
                        showMessage(result.error || 'Registration failed. Please try again.', 'error');
                    }
                    
                } catch (error) {
                    console.error('Registration error:', error);
                    showMessage('Network error. Please check your connection and try again.', 'error');
                }
                
                // Reset button state
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Create Account';
            } else {
                // Shake animation for invalid form
                form.style.animation = 'shake 0.5s ease-in-out';
                setTimeout(() => {
                    form.style.animation = '';
                }, 500);
            }
        });
    }
    
    // Setup login form validation
    function setupLoginValidation() {
        const form = document.querySelector('.auth-form');
        if (!form) return;
        
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        
        // Email validation for login
        if (emailInput) {
            emailInput.addEventListener('blur', function() {
                const email = this.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (email && !emailRegex.test(email)) {
                    this.classList.add('error');
                } else {
                    this.classList.remove('error');
                }
            });
        }
        
        // Form submission for login
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            let isValid = true;
            const submitBtn = form.querySelector('.auth-btn.primary');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            // Basic validation
            const requiredInputs = form.querySelectorAll('input[required]');
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('error');
                    isValid = false;
                } else {
                    input.classList.remove('error');
                }
            });
            
            if (isValid) {
                // Add loading state
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Signing In...';
                
                try {
                    // Prepare form data
                    const formData = {
                        email: emailInput.value,
                        password: passwordInput.value
                    };
                    
                    // Send login request
                    const response = await fetch('../../api/login.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(formData)
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok && result.success) {
                        // Login successful
                        showMessage(result.message || 'Login successful!', 'success');
                        
                        // Redirect to home page after successful login
                        setTimeout(() => {
                            window.location.href = '../../index.php';
                        }, 1500);
                    } else {
                        // Login failed
                        showMessage(result.error || 'Login failed. Please check your credentials.', 'error');
                    }
                    
                } catch (error) {
                    console.error('Login error:', error);
                    showMessage('Network error. Please check your connection and try again.', 'error');
                }
                
                // Reset button state
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Sign In';
            }
        });
    }
    
    // Enhanced Google button functionality
    function setupGoogleButton() {
        const googleBtn = document.querySelector('.auth-btn.google');
        if (googleBtn) {
            // Remove any existing event listeners by cloning the element
            const newGoogleBtn = googleBtn.cloneNode(true);
            googleBtn.parentNode.replaceChild(newGoogleBtn, googleBtn);
            
            // The onclick="signInWithGoogle()" in HTML will handle the Google login
            // No additional JavaScript needed here
            console.log('Google button setup completed - using HTML onclick handler');
        }
    }
    
    // Initialize based on current page
    const pageTitle = document.title;
    
    // Add password toggle for both pages
    addPasswordToggle();
    
    // Setup Google button
    setupGoogleButton();
    
    if (pageTitle.includes('Register')) {
        setupRegisterValidation();
    } else if (pageTitle.includes('Login')) {
        setupLoginValidation();
    }
    
    // Add smooth focus transitions
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentNode.style.transform = 'scale(1.02)';
        });
        
        input.addEventListener('blur', function() {
            this.parentNode.style.transform = 'scale(1)';
        });
    });
});

// Add shake animation CSS
const shakeCSS = `
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}
`;

const style = document.createElement('style');
style.textContent = shakeCSS;
document.head.appendChild(style);
