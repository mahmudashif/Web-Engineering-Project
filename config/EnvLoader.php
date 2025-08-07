<?php
class EnvLoader {
    private $variables = [];
    
    public function load($filePath) {
        if (!file_exists($filePath)) {
            throw new Exception("Environment file not found: {$filePath}");
        }
        
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            
            // Parse key=value pairs
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remove quotes from value if present
                if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
                    (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
                    $value = substr($value, 1, -1);
                }
                
                $this->variables[$key] = $value;
                
                // Also set as environment variable
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
            }
        }
    }
    
    public function get($key, $default = null) {
        return isset($this->variables[$key]) ? $this->variables[$key] : $default;
    }
    
    public function has($key) {
        return isset($this->variables[$key]);
    }
    
    public function all() {
        return $this->variables;
    }
}
?>
