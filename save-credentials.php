<?php
$configPath = __DIR__ . '\common\config.json';
// echo $_SERVER['REQUEST_METHOD']; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $formData = json_decode(file_get_contents('php://input'), true);

    // Validate and sanitize the form data (implement as needed)

    // Save data to the config file
    $configData = json_encode($formData, JSON_PRETTY_PRINT);
    file_put_contents($configPath, $configData);

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
?>
