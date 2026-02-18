<?php
// WHMCS login page URL for optimedia.tv
$whmcsLoginUrl = 'https://optimedia.tv/index.php/login';

// Client credentials for optimedia.tv
$clientEmail = 'saad@gmail.com';     // Replace with the client's email
$clientPassword = '123456';          // Replace with the client's password

// Prepare POST data
$postfields = array(
    'username' => $clientEmail,       // Use 'username' for email
    'password' => $clientPassword,
);

// Initialize cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsLoginUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Set User-Agent header to mimic a real browser
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');

// Execute the login request
$response = curl_exec($ch);

// Check for a successful login by looking for a welcome message
if (strpos($response, 'Welcome to the Client Area') !== false) {
    echo "Client login successful";

    // Perform additional actions after login
    // For example, you can use the WHMCS API to retrieve client details or perform tasks.

    // Example: Retrieve client details using WHMCS API
    /*
    $apiUrl = 'https://optimedia.tv/includes/api.php';
    $apiIdentifier = 'your_api_identifier';
    $apiSecret = 'your_api_secret';

    $apiPostfields = array(
        'action' => 'GetClientsDetails',
        'email' => $clientEmail,
        'responsetype' => 'json',
        'identifier' => $apiIdentifier,
        'secret' => $apiSecret,
    );

    // Initialize another cURL session for API request
    $apiCh = curl_init();
    curl_setopt($apiCh, CURLOPT_URL, $apiUrl);
    curl_setopt($apiCh, CURLOPT_POST, 1);
    curl_setopt($apiCh, CURLOPT_POSTFIELDS, http_build_query($apiPostfields));
    curl_setopt($apiCh, CURLOPT_RETURNTRANSFER, 1);

    // Execute the API request
    $apiResponse = curl_exec($apiCh);

    // Debugging: Output the API response
    echo "API Response:<br>";
    echo htmlspecialchars($apiResponse);

    curl_close($apiCh);

    // Process the API response
    $clientDetails = json_decode($apiResponse, true);

    // Use $clientDetails as needed
    */

} else {
    echo "Client login failed";
    // Handle login failure, such as displaying an error message.
}

curl_close($ch);
?>
