<?php
// Load environment variables
require_once __DIR__ . '/EnvLoader.php';

// Initialize environment loader
$envLoader = new EnvLoader();
$envLoader->load(__DIR__ . '/../.env');

// Define Google OAuth constants
define('GOOGLE_CLIENT_ID', $envLoader->get('GOOGLE_CLIENT_ID'));
define('GOOGLE_CLIENT_SECRET', $envLoader->get('GOOGLE_CLIENT_SECRET'));
define('GOOGLE_REDIRECT_URI', $envLoader->get('GOOGLE_REDIRECT_URI'));

// Google OAuth URLs
define('GOOGLE_OAUTH_URL', 'https://accounts.google.com/o/oauth2/v2/auth');
define('GOOGLE_TOKEN_URL', 'https://oauth2.googleapis.com/token');
define('GOOGLE_USERINFO_URL', 'https://www.googleapis.com/oauth2/v2/userinfo');
?>
