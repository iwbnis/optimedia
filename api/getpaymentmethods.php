<?php

require '/var/www/html/init.php';

$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

use WHMCS\Database\Capsule;

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
curl_close($ch);

$paymentMethodsData = json_decode($response, true);

// Filter the payment methods and assign a value
$visiblePaymentMethods = [];
$value = 1; // Starting value

foreach ($paymentMethodsData['paymentmethods']['paymentmethod'] as $method) {
    $gateway = $method['module'];
    
    $isVisible = Capsule::table('tblpaymentgateways')
                 ->where('gateway', $gateway)
                 ->where('setting', 'visible')
                 ->where('value', 'on')
                 ->count();
                 
    if ($isVisible) {
        $method['value'] = $value; // Assign the value to the payment method
        $visiblePaymentMethods[] = $method;
        $value++; // Increment the value for the next payment method
    }
}

// Output the visible payment methods
header('Content-Type: application/json');
echo json_encode(['paymentmethods' => $visiblePaymentMethods], JSON_PRETTY_PRINT);

?>
