<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gadget Shop - Register</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/auth.css">
    <script src="../../components/components.js"></script>
</head>
<body>
    <!-- Navbar Placeholder -->
    <div id="navbar-placeholder"></div>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Create Account</h1>
                <p>Join us today and start shopping</p>
            </div>

            <form class="auth-form" method="POST" action="../../api/register.php">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Create a password">
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" required placeholder="Confirm your password">
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms" class="checkbox-label">
                        I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
                    </label>
                </div>

                <button type="submit" class="auth-btn primary">Create Account</button>

                <div class="divider">
                    <span>Or continue with</span>
                </div>

                <button type="button" class="auth-btn google" onclick="signInWithGoogle()">
                    <svg class="google-icon" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Sign up with Google
                </button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="login.php">Sign in</a></p>
            </div>
        </div>
    </div>

    <!-- Footer Placeholder -->
    <div id="footer-placeholder"></div>

    <script src="../../assets/js/auth.js"></script>
    <script src="../../assets/js/user-auth.js"></script>
    <script>
        // Google Sign-In function
        function signInWithGoogle() {
            // Show loading state
            const googleBtn = document.querySelector('.auth-btn.google');
            const originalText = googleBtn.innerHTML;
            googleBtn.innerHTML = '<div class="loading-spinner"></div>Connecting to Google...';
            googleBtn.disabled = true;

            // Redirect to Google OAuth
            window.location.href = '../../api/google-login.php';
        }

        // Prevent access to auth pages when already logged in
        document.addEventListener('DOMContentLoaded', () => {
            if (window.userAuth) {
                window.userAuth.preventAuthPageAccess();
            }

            // Check for URL parameters and show messages
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');
            
            if (error) {
                let errorMessage = '';
                switch(error) {
                    case 'google_access_denied':
                        errorMessage = 'Google sign-in was cancelled. Please try again.';
                        break;
                    case 'google_token_failed':
                        errorMessage = 'Google authentication failed. Please try again.';
                        break;
                    case 'google_user_info_failed':
                        errorMessage = 'Failed to retrieve user information from Google. Please try again.';
                        break;
                    case 'registration_failed':
                        errorMessage = 'Account creation failed. Please try again or contact support.';
                        break;
                    case 'invalid_request':
                        errorMessage = 'Invalid authentication request. Please try signing in again.';
                        break;
                    default:
                        errorMessage = 'An error occurred during Google sign-in. Please try again.';
                }
                
                // Show error message (you can customize this based on your UI)
                alert(errorMessage);
                
                // Clean URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>
</body>
</html>
