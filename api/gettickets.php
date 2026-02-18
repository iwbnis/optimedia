<?php

$whmcsUrl = "http://192.168.61.3/";
$api_Identifier = 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw';
$api_Secret = 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM';

$clientid = $_POST['client_id'];

 if (empty($clientid))
{
die ("Please post a client id");
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(
        array(
            'action' => 'GetTickets',
            'identifier' => $api_Identifier,
            'secret' => $api_Secret,
            'clientid' => $clientid,
            'responsetype' => 'json',
        )
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// Check if the response contains any tickets
$tickets = json_decode($response, true);
if (!empty($tickets['tickets'])) {
    // Tickets found, return the response as it is
    header('Content-Type: application/json');
    echo $response;
} else {
    // No tickets found
    echo json_encode("No tickets found for the client ID: " . $clientID);
}
?>

