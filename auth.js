// ========== Authentication Form Validation and Enhancement ========== 

document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle functionality
    function addPasswordToggle() {
        const passwordInputs = document.querySelectorAll('input[type="password"]');
        
        passwordInputs.forEach(input => {
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);
            
            const toggleBtn = document.createElement('button');
            toggleBtn.type = 'button';
            toggleBtn.innerHTML = '👁️';
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
            `;
            
            toggleBtn.addEventListener('click', function() {
                if (input.type === 'password') {
                    input.type = 'text';
                    toggleBtn.innerHTML = '🙈';
                } else {
                    input.type = 'password';
                    toggleBtn.innerHTML = '👁️';
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
        
        // Form submission
        form.addEventListener('submit', function(e) {
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
                
                // Simulate form submission
                setTimeout(() => {
                    alert('Form would be submitted here! (No backend functionality implemented)');
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                }, 2000);
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
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;
            const submitBtn = form.querySelector('.auth-btn.primary');
            
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
                
                // Simulate login
                setTimeout(() => {
                    alert('Login would be processed here! (No backend functionality implemented)');
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                }, 2000);
            }
        });
    }
    
    // Enhanced Google button functionality
    function setupGoogleButton() {
        const googleBtn = document.querySelector('.auth-btn.google');
        if (googleBtn) {
            googleBtn.addEventListener('click', function() {
                alert('Google Sign-in would be implemented here! (No functionality implemented)');
            });
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
