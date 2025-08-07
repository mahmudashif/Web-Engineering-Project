<?php
class GoogleOAuth {
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    
    public function __construct() {
        require_once '../config/google-config.php';
        
        $this->clientId = GOOGLE_CLIENT_ID;
        $this->clientSecret = GOOGLE_CLIENT_SECRET;
        $this->redirectUri = GOOGLE_REDIRECT_URI;
    }
    
    public function getAuthUrl() {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'scope' => 'email profile',
            'response_type' => 'code',
            'access_type' => 'offline',
            'prompt' => 'consent'
        ];
        
        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    }
    
    public function getAccessToken($code) {
        $tokenUrl = 'https://oauth2.googleapis.com/token';
        
        $postData = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code',
            'code' => $code
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception('Failed to get access token. HTTP Code: ' . $httpCode);
        }
        
        $data = json_decode($response, true);
        
        if (!isset($data['access_token'])) {
            throw new Exception('Access token not found in response');
        }
        
        return $data['access_token'];
    }
    
    public function getUserInfo($accessToken) {
        $userInfoUrl = 'https://www.googleapis.com/oauth2/v2/userinfo?access_token=' . $accessToken;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $userInfoUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception('Failed to get user info. HTTP Code: ' . $httpCode);
        }
        
        $userData = json_decode($response, true);
        
        if (!$userData) {
            throw new Exception('Invalid user data received from Google');
        }
        
        return $userData;
    }
}
?>
