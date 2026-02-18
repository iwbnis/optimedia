<?php
// Define the API URL
$apiUrl = 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_line&id=8311';

// Fetch data from the API
$response = file_get_contents($apiUrl);

// Check if the API request was successful
if ($response !== false) {
    // Use the same method to find and display the "id"
    if (preg_match('/"id":(\d+)/', $response, $idMatches)) {
        $id = $idMatches[1];
        echo 'ID: ' . $id . PHP_EOL;
    } else {
        echo 'Failed to retrieve "ID" from the API response.';
    }

    // Define a regular expression pattern to match the "exp_date" field
    $pattern = '/"exp_date":(\d+)/';

    // Use preg_match to find the Unix timestamp in the response
    if (preg_match($pattern, $response, $matches)) {
        // Extract the Unix timestamp from the matched pattern
        $expDate = $matches[1];

        // Create a DateTime object with the Unix timestamp
        $dateTime = new DateTime("@$expDate");

        // Set the timezone to 'America/New_York'
        $dateTime->setTimezone(new DateTimeZone('America/New_York'));

        // Format the date (without the time)
        $formattedDate = $dateTime->format('Y-m-d');

        // Output the extracted Unix timestamp and the formatted date (without the time) as 'new_exp_date' in 'America/New_York' timezone
        echo 'new_exp_date: ' . $formattedDate . PHP_EOL;
    } else {
        echo 'Failed to retrieve "exp_date" from the API response.';
    }

    // Use the same method to find and display the "username"
    if (preg_match('/"username":"([^"]+)"/', $response, $usernameMatches)) {
        $username = $usernameMatches[1];
        echo 'username: ' . $username . PHP_EOL;
    } else {
        echo 'Failed to retrieve "username" from the API response.';
    }

    // Find and display the "password"
    if (preg_match('/"password":"([^"]+)"/', $response, $passwordMatches)) {
        $password = $passwordMatches[1];
        echo 'password: ' . $password . PHP_EOL;
    } else {
        echo 'Failed to retrieve "password" from the API response.';
    }

    // Find and display the "bouquet"
    if (preg_match('/"bouquet":"([^"]+)"/', $response, $bouquetMatches)) {
        $bouquet = $bouquetMatches[1];
        echo 'bouquet: ' . $bouquet . PHP_EOL;
    } else {
        echo 'Failed to retrieve "bouquet" from the API response.';
    }

    // Find and display the "max_connections"
    if (preg_match('/"max_connections":(\d+)/', $response, $maxConnectionsMatches)) {
        $maxConnections = $maxConnectionsMatches[1];
        echo 'max_connections: ' . $maxConnections . PHP_EOL;
    } else {
        echo 'Failed to retrieve "max_connections" from the API response.';
    }

    // Find and display the "package_name"
    if (preg_match('/"package_name":"([^"]+)"/', $response, $packageNameMatches)) {
        $packageName = $packageNameMatches[1];
        echo 'package_name: ' . $packageName . PHP_EOL;
    } else {
        echo 'Failed to retrieve "package_name" from the API response.';
    }
} else {
    echo 'Failed to fetch data from the API.';
}
?>
