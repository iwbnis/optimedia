<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://192.168.61.3/includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'action' => 'GetClientsDetails',
    'identifier' => 'RKdWaaGpbRYEqet1RiGTDyJyGDUOIpQw',
    'secret' => 'lFZ6Df5SBaDBo5IA0QTADk8xXDf4H1TM',
    'clientid' => '14',
    'stats' => true,
    'responsetype' => 'json',
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Error handling and logging
if (curl_errno($ch)) {
    $error = curl_error($ch);
    curl_close($ch);
    die('CURL Error: ' . $error);
}

$response = curl_exec($ch);

// Error handling and logging
if (curl_errno($ch)) {
    $error = curl_error($ch);
    curl_close($ch);
    die('CURL Error: ' . $error);
}

curl_close($ch);

echo $response;
?>
