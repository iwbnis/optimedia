<?php

$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

// Check if 'client_id' is set in the POST request and isn't empty
if (!isset($_POST['client_id']) || empty(trim($_POST['client_id']))) {
    echo json_encode(['result' => 'error', 'message' => 'Client ID not provided or is empty'], JSON_PRETTY_PRINT);
    exit;
}

$clientid = $_POST['client_id'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetClientsDetails',
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'clientid' => $clientid,
            'stats' => true,
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// Decode response
$jsonData = json_decode($response, true);
echo json_encode($jsonData, JSON_PRETTY_PRINT);
?>
