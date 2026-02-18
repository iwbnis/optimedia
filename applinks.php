<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/init.php';

use WHMCS\Database\Capsule;

try {
    // Initialize Capsule
    $capsule = new Capsule;

    // Make sure the Eloquent ORM is booted
    $capsule->bootEloquent();

    // Define the table name
    $table_name = 'xtreamui_applinks';

    // Retrieve data from the table
    $data = Capsule::table($table_name)
        ->select('ID', 'appname', 'applink', 'appfor')
        ->get();

    // Determine the device type (Android or iOS)
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $isAndroid = strpos($userAgent, 'android') !== false;
    $isIOS = strpos($userAgent, 'ios') !== false;

    // Iterate through the data and update 'appfor' and add 'androiddl' and 'iosdl'
    foreach ($data as &$row) {
        // Check if 'appfor' is 'Android' or 'android' (case-insensitive)
        if (strcasecmp($row->appfor, 'android') === 0 || $isAndroid) {
            $row->appfor = 'Android/Firestick';
            $row->androiddl = 1;
        } else {
            $row->androiddl = 0;
        }

        // Check if the device is iOS
        if ($isIOS) {
            $row->iosdl = 1;
        } else {
            $row->iosdl = 0;
        }
    }

    // Set the content type to JSON
    header('Content-Type: application/json');

    // Output the JSON data with pretty formatting
    echo json_encode($data, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // Handle any exceptions that may occur during the execution of your code
    echo json_encode(['error' => $e->getMessage()]);
}
?>
