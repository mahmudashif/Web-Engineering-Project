<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>API Test - Brand Field</title>
</head>
<body>
    <h1>API Test - Brand Field</h1>
    
    <h2>Direct API Test</h2>
    <div id="api-test"></div>
    
    <script>
        async function testAPI() {
            try {
                const response = await fetch('./api/get-products.php?limit=5');
                const data = await response.json();
                
                const container = document.getElementById('api-test');
                
                if (data.success && data.products) {
                    let html = '<h3>Products from API:</h3>';
                    data.products.forEach(product => {
                        html += `
                            <div style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
                                <strong>${product.name}</strong><br>
                                Brand: <em>${product.brand || 'MISSING BRAND'}</em><br>
                                Category: ${product.category}<br>
                                Price: ${product.formatted_price}
                            </div>
                        `;
                    });
                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<p style="color: red;">API Error: ' + JSON.stringify(data) + '</p>';
                }
            } catch (error) {
                document.getElementById('api-test').innerHTML = '<p style="color: red;">Network Error: ' + error.message + '</p>';
            }
        }
        
        // Test when page loads
        testAPI();
    </script>
</body>
</html>
