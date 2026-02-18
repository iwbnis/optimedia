<?php
$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';
$clientid = $_POST['client_id'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetClientsProducts',
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'clientid' => $clientid, // Corrected the variable name here
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// Decode response
$jsonData = json_decode($response, true);
$jsonResponse = json_encode($jsonData);
// Dump array structure for inspection
// var_dump($jsonData);
header("Content-Type: application/json");
echo $jsonResponse;
