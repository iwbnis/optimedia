<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use WHMCS\Database\Capsule;
define("CLIENTAREA", true);
require __DIR__ . '/init.php';

// Function to fetch the email template name based on the ID
function getEmailTemplateName($templateId) {
    return Capsule::table('tblemailtemplates')
        ->where('id', $templateId)
        ->value('name');
}

// Fetch all active products with their associated email template ID
$activeProducts = Capsule::table('tblhosting')
    ->select('tblhosting.userid', 'tblhosting.id as serviceid', 'tblproducts.welcomeemail')
    ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
    ->where('tblhosting.domainstatus', 'Active')
    ->get();

foreach ($activeProducts as $product) {
    $clientId = $product->userid;
    $serviceId = $product->serviceid;
    $welcomeEmailId = $product->welcomeemail;

    // Get the email template name based on the template ID
    $emailTemplateName = getEmailTemplateName($welcomeEmailId);

    if ($emailTemplateName) {
        // Send the welcome email using the template name
        $command = 'SendEmail';
        $postData = array(
            'id' => $clientId,
            'messagename' => $emailTemplateName, // Use the template name
        );

        // Execute the API call
        $results = localAPI($command, $postData);

        if ($results['result'] == 'success') {
            echo 'Welcome email sent to client ID ' . $clientId . ' for service ID ' . $serviceId . PHP_EOL;
        } else {
            echo 'Error sending welcome email to client ID ' . $clientId . ' for service ID ' . $serviceId . ': ' . $results['message'] . PHP_EOL;
        }
    } else {
        echo 'Error: Template name not found for template ID ' . $welcomeEmailId . ' for client ID ' . $clientId . ' and service ID ' . $serviceId . PHP_EOL;
    }
}