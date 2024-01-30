<?php
$configPath = __DIR__ . '/common/config.json';
$htaccessPath = __DIR__ . '/.htaccess';
// echo $_SERVER['REQUEST_METHOD']; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $formData = json_decode(file_get_contents('php://input'), true);

    // Validate and sanitize the form data (implement as needed)

    // Save data to the config file
    $configData = json_encode($formData, JSON_PRETTY_PRINT);
    file_put_contents($configPath, $configData);

    // $htaccessContent = "
    //     <FilesMatch \"\.(htaccess|htpasswd|ini|log|sh|inc|bak|config|sql|db|json)\">
    //         Order Allow,Deny
    //         Deny from all
    //     </FilesMatch>
    //     RewriteEngine On
    //     DirectoryIndex index.php

    //     RewriteBase " . $formData['baseSlug'] . "
    //     RewriteCond %{REQUEST_FILENAME}.php -f
    //     RewriteCond %{REQUEST_URI} !/$
    //     RewriteRule ^([^/]+)/?$ $1.php [L]

    // ";
    $htaccessContent = "RewriteEngine On
RewriteBase " . $formData['baseSlug'] . "

DirectoryIndex index.php
ErrorDocument 404 " . $formData['baseSlug'] . "error/404.php

RewriteCond %{REQUEST_FILENAME}.php -f
RewriteCond %{REQUEST_URI} !/$
RewriteRule ^([^/]+)/?$ $1.php [L]

<FilesMatch \"(\.(htaccess|htpasswd|ini|log|sh|inc|bak|config|sql|db|json)|~)$\">
    Deny from all
</FilesMatch>";
    file_put_contents($htaccessPath, $htaccessContent);


    // Send a response back to the client
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Credentials saved successfully']);
    exit;
} else {
    // If the request is not a POST request, return an error response
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}
