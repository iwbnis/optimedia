<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use WHMCS\Database\Capsule;
define("CLIENTAREA", true);
require __DIR__ . '/init.php';

//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Define the columns you want to retrieve
    $columns = ['tblproducts.id as product_id', 'tblcustomfields.relid', 'fieldname', 'fieldtype', 'tblcustomfields.description', 'fieldoptions', 'regexpr', 'required'];

    // Retrieve custom fields data from tblcustomfields and join with tblproducts
    $customFields = Capsule::table('tblcustomfields')
        ->join('tblproducts', 'tblproducts.id', '=', 'tblcustomfields.relid')
        ->select($columns)
        ->where('username', $username)
        ->where('password', $password) // Add a filter to search for the password
        ->get();

    // Check if any custom fields were found
    if (!$customFields) {
        echo json_encode(["message" => "No custom fields found for the provided username and password."], JSON_PRETTY_PRINT);
    } else {
        // Output the custom fields data in JSON format with unescaped Unicode
        echo json_encode($customFields, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
//} else {
 //   echo json_encode(["message" => "Invalid request. Please provide both username and password via POST."], JSON_PRETTY_PRINT);
}
?>
