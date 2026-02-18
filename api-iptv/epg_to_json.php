<?php
// Check if the necessary query parameters are set
if (isset($_GET['url']) && isset($_GET['username']) && isset($_GET['password'])) {
    // Retrieve query parameters
    $url = $_GET['url'];
    $username = $_GET['username'];
    $password = $_GET['password'];

    // Construct the endpoint URL
    $endpoint = $url . '?username=' . urlencode($username) . '&password=' . urlencode($password);

    // Fetch XML data
    $xmlData = file_get_contents($endpoint);

    // Check if XML data was fetched successfully
    if ($xmlData !== false) {
        // Convert XML to SimpleXML object
        $xml = simplexml_load_string($xmlData);

        // Convert SimpleXML object to JSON
        $json = json_encode($xml, JSON_PRETTY_PRINT);

        // Output JSON data
        header('Content-Type: application/json');
        echo $json;
    } else {
        // Handle error if XML data fetch fails
        echo 'Failed to fetch XMLTV data.';
    }
} else {
    // Handle error if necessary query parameters are missing
    echo 'Missing required query parameters: url, username, and password.';
}
?>
