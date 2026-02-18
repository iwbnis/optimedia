<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include WHMCS initialization
require __DIR__ . '/init.php';

use WHMCS\Database\Capsule;

$userDataArray = [];

try {
    // Set the maximum execution time for this script to 10 seconds
    set_time_limit(10);

    // Retrieve all user IDs
    $userIds = Capsule::table('tblclients')
        ->select('id')
        ->pluck('id');

    if (empty($userIds)) {
        $userDataArray[] = ["message" => "No user IDs found in the database."];
    } else {
        // Loop through the user IDs and retrieve dedicated IP data for each user
        foreach ($userIds as $userId) {
            // Retrieve dedicated IP data for the user
            $dedicatedIpData = Capsule::table('tblhosting')
                ->where('userid', $userId)
                ->pluck('dedicatedip')
                ->toArray();

            // Only include users with non-empty dedicated IP values
            if (!empty($dedicatedIpData) && !empty(array_filter($dedicatedIpData))) {
                // Retrieve nextduedate from the first hosting record (assuming one user can have multiple hosting records)
                $nextDueDate = Capsule::table('tblhosting')
                    ->where('userid', $userId)
                    ->value('nextduedate');

                // Create an array for the user data
                $userData = [
                    "userId" => $userId,
                    "nextduedate" => $nextDueDate,
                    "dedicatedip" => $dedicatedIpData[0], // Assuming you want the first dedicated IP if there are multiple
                ];

                // Add the user data to the main array
                $userDataArray[] = $userData;
            }
        }
    }
} catch (Exception $e) {
    // Log the error for debugging purposes
    error_log("An error occurred: " . $e->getMessage());
    $userDataArray[] = ["error" => "An error occurred. Please try again later."];
}

// Output the JSON data with pretty-printing
header('Content-Type: application/json');
echo json_encode($userDataArray, JSON_PRETTY_PRINT);

// Iterate through user data and make API requests
foreach ($userDataArray as $userData) {
    $dedicatedIp = $userData['dedicatedip'];
    $apiUrl = 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_line&id=' . urlencode($dedicatedIp);

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
        echo 'Failed to fetch data from the API for dedicated IP: ' . $dedicatedIp . PHP_EOL;
    }
}
?>
