// ========== Profile Page JavaScript ==========

document.addEventListener('DOMContentLoaded', function() {
    checkAuthenticationAndLoadProfile();
    initializeProfileFunctionality();
});

// Check if user is authenticated and load profile data
async function checkAuthenticationAndLoadProfile() {
    try {
        const response = await fetch('../api/check-auth.php');
        const result = await response.json();
        
        if (!result.success || !result.user) {
            // Redirect to login if not authenticated
            window.location.href = 'auth/login.php';
            return;
        }
        
        // Load user profile data
        loadUserProfile(result.user);
        
    } catch (error) {
        console.error('Authentication check failed:', error);
        showMessage('Failed to verify authentication', 'error');
        // Redirect to login on error
        setTimeout(() => {
            window.location.href = 'auth/login.php';
        }, 2000);
    }
}

// Load and display user profile information
function loadUserProfile(user) {
    console.log('Loading user profile with data:', user); // Debug log
    
    // Use full_name from database or default to 'User'
    const fullName = user.full_name || 'User';
    
    // Update profile header
    document.getElementById('profile-name').textContent = fullName;
    document.getElementById('profile-email').textContent = user.email;
    
    // Update form fields
    document.getElementById('full-name').value = fullName;
    document.getElementById('email').value = user.email;
    
    // Load phone and address from check-auth response
    if (user.phone) {
        console.log('Setting phone:', user.phone); // Debug log
        document.getElementById('phone').value = user.phone;
    } else {
        console.log('No phone data available'); // Debug log
    }
    
    if (user.address) {
        console.log('Setting address:', user.address); // Debug log
        document.getElementById('address').value = user.address;
    } else {
        console.log('No address data available'); // Debug log
    }
    
    // Set join date from database if available
    if (user.created_at) {
        const joinDate = new Date(user.created_at).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        document.getElementById('join-date').textContent = joinDate;
    } else {
        document.getElementById('join-date').textContent = 'Recently';
    }
}

// Initialize profile page functionality
function initializeProfileFunctionality() {
    // Profile form submission
    document.getElementById('profile-form').addEventListener('submit', handleProfileUpdate);
    
    // Avatar upload functionality
    document.getElementById('avatar-upload').addEventListener('change', handleAvatarUpload);
}

// Toggle edit mode for profile form
let isEditMode = false;

function toggleEditMode() {
    isEditMode = !isEditMode;
    const form = document.getElementById('profile-form');
    const inputs = form.querySelectorAll('input:not([type="email"]), textarea');
    const emailInput = form.querySelector('input[type="email"]');
    const formActions = document.getElementById('form-actions');
    const editBtn = document.querySelector('.edit-profile-btn');
    
    if (isEditMode) {
        // Enable editing
        inputs.forEach(input => {
            input.removeAttribute('readonly');
            input.style.background = 'white';
        });
        
        // Keep email readonly but show it's in edit mode
        emailInput.style.background = '#f9fafb';
        
        formActions.style.display = 'flex';
        editBtn.textContent = '✕ Cancel';
        editBtn.style.background = 'rgba(239, 68, 68, 0.2)';
        editBtn.style.borderColor = 'rgba(239, 68, 68, 0.3)';
        
    } else {
        // Disable editing
        inputs.forEach(input => {
            input.setAttribute('readonly', true);
            input.style.background = '#f3f4f6';
        });
        
        emailInput.style.background = '#f3f4f6';
        formActions.style.display = 'none';
        editBtn.innerHTML = `
            <svg class="edit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Profile
        `;
        editBtn.style.background = 'rgba(255, 255, 255, 0.2)';
        editBtn.style.borderColor = 'rgba(255, 255, 255, 0.3)';
    }
}

// Cancel edit mode
function cancelEdit() {
    // Reload original values
    location.reload();
}

// Handle profile form update
async function handleProfileUpdate(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const profileData = {
        full_name: formData.get('full_name'),
        phone: formData.get('phone'),
        address: formData.get('address')
    };
    
    try {
        showMessage('Updating profile...', 'info');
        
        const response = await fetch('../api/update-profile.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(profileData)
        });
        
        const result = await response.json();
        
        if (response.ok && result.success) {
            showMessage('Profile updated successfully!', 'success');
            
            // Update profile display
            document.getElementById('profile-name').textContent = profileData.full_name;
            
            // Exit edit mode
            toggleEditMode();
            
        } else {
            showMessage(result.error || 'Failed to update profile', 'error');
        }
        
    } catch (error) {
        console.error('Profile update error:', error);
        showMessage('Network error. Please try again.', 'error');
    }
}

// Handle avatar upload
function triggerAvatarUpload() {
    document.getElementById('avatar-upload').click();
}

function handleAvatarUpload(e) {
    const file = e.target.files[0];
    if (!file) return;
    
    // Validate file type
    if (!file.type.startsWith('image/')) {
        showMessage('Please select a valid image file', 'error');
        return;
    }
    
    // Validate file size (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
        showMessage('Image size must be less than 2MB', 'error');
        return;
    }
    
    // Preview the image
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('profile-avatar').src = e.target.result;
    };
    reader.readAsDataURL(file);
    
    // Upload the image (implement later)
    showMessage('Avatar upload functionality will be implemented', 'info');
}

// Message display function
function showMessage(message, type = 'info') {
    // Remove existing messages
    const existingMessages = document.querySelectorAll('.profile-message');
    existingMessages.forEach(msg => msg.remove());
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `profile-message ${type}-message`;
    messageDiv.textContent = message;
    
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 500;
        z-index: 10000;
        max-width: 400px;
        animation: slideInRight 0.3s ease-out;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    `;
    
    // Set colors based on type
    if (type === 'success') {
        messageDiv.style.background = '#dcfce7';
        messageDiv.style.color = '#166534';
        messageDiv.style.border = '1px solid #bbf7d0';
    } else if (type === 'error') {
        messageDiv.style.background = '#fef2f2';
        messageDiv.style.color = '#dc2626';
        messageDiv.style.border = '1px solid #fecaca';
    } else {
        messageDiv.style.background = '#dbeafe';
        messageDiv.style.color = '#1e40af';
        messageDiv.style.border = '1px solid #bfdbfe';
    }
    
    document.body.appendChild(messageDiv);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        messageDiv.style.animation = 'slideOutRight 0.3s ease-in forwards';
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 300);
    }, 4000);
}

// Add animation styles
const profileAnimationCSS = `
@keyframes slideInRight {
    from { 
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
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

const profileStyle = document.createElement('style');
profileStyle.textContent = profileAnimationCSS;
document.head.appendChild(profileStyle);
