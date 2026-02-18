<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use WHMCS\Database\Capsule;

define("CLIENTAREA", true);
require __DIR__ . '/init.php';

$whmcsUrl = "https://optimedia.tv/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

// Get all payment methods
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetPaymentMethods',
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);

// Handle cURL Errors
if(curl_errno($ch)) {
    throw new Exception(curl_error($ch));
}

curl_close($ch);

$paymentMethodsData = json_decode($response, true);

// Check if the necessary data exists in the response
if(!isset($paymentMethodsData['paymentmethods']['paymentmethod'])) {
    throw new Exception("Unexpected API response format.");
}

// Filter the payment methods
$visiblePaymentMethods = [];
foreach ($paymentMethodsData['paymentmethods']['paymentmethod'] as $method) {
    $gateway = $method['module'];
    
    $isVisible = Capsule::table('tblpaymentgateways')
                 ->where('gateway', $gateway)
                 ->where('setting', 'visible')
                 ->where('value', '1')
                 ->count();
                 
    if ($isVisible) {
        $visiblePaymentMethods[] = $method;
    }
}

// Output the visible payment methods
header('Content-Type: application/json');
echo json_encode(['paymentmethods' => $visiblePaymentMethods], JSON_PRETTY_PRINT);

?>
