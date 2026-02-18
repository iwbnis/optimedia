<?php

$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

$clientId = '14';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetClientsProducts',
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'clientid' => $clientId,
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// Decode response
$jsonData = json_decode($response, true);

// Extract dedicatedip, username, and password field values
$dedicatedIP = $jsonData['products']['product'][0]['dedicatedip'];
$username = $jsonData['products']['product'][0]['username'];
$password = $jsonData['products']['product'][0]['password'];

// Output the values
echo "Dedicated IP: " . $dedicatedIP . PHP_EOL;
echo "Username: " . $username . PHP_EOL;
echo "Password: " . $password . PHP_EOL;
