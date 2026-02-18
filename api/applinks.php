<?php
use WHMCS\Database\Capsule;

define("CLIENTAREA", true);

require __DIR__ . '/init.php';

// Check for API access permissions, authentication, etc. (as needed)

$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';
$action = 'get_xtreamui_applinks';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inside this block, the code acts as a custom API action

    // Initialize WHMCS Capsule
    $capsule = new Capsule();
    $capsule->boot();

    // Define the table name
    $table_name = 'xtreamui_applinks';

    // Query to retrieve data from the table
    $query = "SELECT ID, appname, applink, appfor FROM $table_name";

    // Execute the query
    try {
        $result = $capsule::table($table_name)->select('ID', 'appname', 'applink', 'appfor')->get();

        // Initialize an array to store the results
        $data = array();

        // Convert the result to an array
        foreach ($result as $row) {
            $data[] = (array)$row;
        }

        // Set the content type to JSON
        header('Content-Type: application/json');

        // Output the JSON data with pretty formatting
        echo json_encode($data, JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        // Handle database query errors
        echo "Database query error: " . $e->getMessage();
    }
} else {
    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
        'action' => $action,
        'api_identifier' => $api_Identifier,
        'api_secret' => $api_Secret,
    )));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    } else {
        // Output the JSON response with pretty formatting
        $decodedResponse = json_decode($response);

        if ($decodedResponse !== null) {
            echo json_encode($decodedResponse, JSON_PRETTY_PRINT);
        } else {
            echo "Invalid JSON Response: " . $response;
        }
    }

    // Close cURL
    curl_close($ch);
}

// Close the database connection (if not already closed)
if (isset($capsule)) {
    $capsule->getConnection()->disconnect();
}
?>
